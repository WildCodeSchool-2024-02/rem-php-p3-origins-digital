<?php

namespace App\Controller;

use App\Entity\PpgVideo;
use App\Form\PpgVideoType;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\PpgVideoRepository;
use App\Service\ClientGoogleService;
use App\Service\YouTubeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PpgVideoController extends AbstractController
{
    private ClientGoogleService $clientGoogleService;
    private YouTubeService $youTubeService;

    public function __construct(
        ClientGoogleService $clientGoogleService,
    ) {
        $this->clientGoogleService = $clientGoogleService;
        $this->youTubeService = new YouTubeService($clientGoogleService->getClient());
    }
    #[Route('/admin/PPG-manager', name: 'ppg-video-manager')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        PpgVideoRepository $videoRepository
    ): Response {
        //check token youtube
        $client = $this->clientGoogleService->getClient();
        if ($client->isAccessTokenExpired() && !$client->getRefreshToken()) {
            $autUrl = $this->clientGoogleService-> getAuthUrl();
            return $this->redirect($autUrl);
        }

        $ppgVideos = $videoRepository->findBy([], ['id' => 'DESC']);
        $isLive = $videoRepository->findBy(['status' => 'live']);

        $livesUpComing = $this->youTubeService->getPpgVideoUpComing();
        $addVideos = [];

        $forms = [];

        foreach ($livesUpComing as $index => $liveUpComing) {
            $ppgVideo = new PpgVideo();
            $form = $this->createForm(PpgVideoType::class, $ppgVideo, [
                'action' => $this->generateUrl('ppg-video-add', ['index' => $index]),
            ]);
            $forms[$index] = $form->createView();
            $videoAdded = $videoRepository->findOneBy(['videoId' => $liveUpComing['videoId']]);
            if ($videoAdded === null) {
                $addVideos[] = $liveUpComing;
            }
        }

        return $this->render('admin/ppg-video/index.html.twig', [
            'livesUpComing' => $addVideos,
            'forms' => $forms,
            'videos' => $ppgVideos,
            'isLive' => $isLive,
        ]);
    }
    #[Route('/admin/PPG-manager/add/{index}', name: 'ppg-video-add')]
    public function add(
        Request $request,
        EntityManagerInterface $entityManager,
        PpgVideoRepository $videoRepository,
        $index
    ): Response {
        $ppgVideo = new PpgVideo();
        $form = $this->createForm(PpgVideoType::class, $ppgVideo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($videoRepository->findOneBy(['videoId' => $form->get('videoId')->getData()]) === null) {
                $entityManager->persist($ppgVideo);
                $entityManager->flush();
                $this->addFlash('success', 'Video added successfully');
            } else {
                $this->addFlash('danger', 'This video is already added');
            }
        }

        return $this->redirectToRoute('ppg-video-manager');
    }
    #[Route('/admin/PPG-manager/delete/{id}', name: 'ppg-video-delete')]
    public function delete(
        PpgVideo $video,
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->remove($video);
        $entityManager->flush();
        $this->addFlash('sucess', 'Video has been successfully deleted.');
        return $this->redirectToRoute('ppg-video-manager');
    }
    #[Route('/admin/PPG-manager/edit/{id}', name: 'ppg-video-edit')]
    public function edit(
        PpgVideo $video,
        Request $request,
        EntityManagerInterface $entityManager,
        GameRepository $gameRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $form = $this ->createForm(PpgVideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Video has been successfully edited.');
            return $this->redirectToRoute('ppg-video-manager');
        }
        $games = $gameRepository->findAll();
        $categories = $categoryRepository->findAll();
        return $this->render('admin/ppg-video/edit.html.twig', [
            'games' => $games,
            'form' => $form->createView(),
            'video' => $video,
            'categories' => $categories
        ]);
    }
    #[Route('/oauth2callback', name: 'oauth2callback')]
    public function oauth2callback(Request $request): Response
    {
        $code = $request->query->get('code');
        $this->clientGoogleService->fetchAccessTokenWithAuthCodes($code);

        return $this->redirectToRoute('ppg-video-manager');
    }
}
