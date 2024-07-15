<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\CategoryRepository;
use App\Repository\GameRepository;
use App\Repository\VideoRepository;
use App\Service\ClientGoogleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetVideo extends AbstractController
{
    private ClientGoogleService $clientGoogleService;

    public function __construct(
        ClientGoogleService $clientGoogleService,
    ) {
        $this->clientGoogleService = $clientGoogleService;
    }
    #[Route('/admin/getVideo', name: 'getVideo')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        VideoRepository $videoRepository
    ): Response {
        //check token youtube
        $client = $this->clientGoogleService->getClient();
        if ($client->isAccessTokenExpired() && !$client->getRefreshToken()) {
            $autUrl = $this->clientGoogleService-> getAuthUrl();
            return $this->redirect($autUrl);
        }
        // GetVideo data to BDD
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($videoRepository->findOneBy(['videoPicking' => $form->get('videoPicking')->getData()]) === null) {
                $entityManager->persist($video);
                $entityManager->flush();
                return $this->redirectToRoute('showVideo');
            } else {
                $this->addFlash('danger', 'This video is already added.');
                return $this->redirectToRoute('getVideo');
            }
        } elseif ($form->isSubmitted()) {
            $this->addFlash('danger', 'Add a category');
            return $this->redirectToRoute('getVideo');
        }
        return $this->render('admin/getVideo.html.twig');
    }
    #[Route('/oauth2callback', name: 'oauth2callback')]
    public function oauth2callback(Request $request): Response
    {
        $code = $request->query->get('code');
        $this->clientGoogleService->fetchAccessTokenWithAuthCodes($code);

        return $this->redirectToRoute('getVideo');
    }
    #[Route('/admin/showVideo', name: 'showVideo')]
    public function showVideo(VideoRepository $videoRepository): Response
    {
        $videos = $videoRepository->findBy([], ['id' => 'DESC']);
        return $this->render('admin/show-video.html.twig', [
            'videos' => $videos,
        ]);
    }
    #[Route('/admin/video/delete/{id}', name: 'deleteVideo')]
    public function delete(Video $video, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($video);
        $entityManager->flush();
        $this->addFlash('sucess', 'Video has been successfully deleted.');
        return $this->redirectToRoute('showVideo');
    }
    #[Route('/admin/video/edit/{id}', name: 'editVideo')]
    public function editVideo(
        Video $video,
        Request $request,
        EntityManagerInterface $entityManager,
        GameRepository $gameRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Video has been successfully edited.');
            return $this->redirectToRoute('showVideo');
        }
        $games = $gameRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('admin/edit-video.html.twig', [
            'games' => $games,
            'form' => $form->createView(),
            'video' => $video,
            'categories' => $categories,
        ]);
    }
}
