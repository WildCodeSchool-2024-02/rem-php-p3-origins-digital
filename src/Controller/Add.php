<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Service\ClientGoogleService;
use App\Service\TwitchTokenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
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
        VideoRepository $videoRepository,
        TwitchTokenService $twitchTokenService
    ): Response {
        //check token youtube
        $client = $this->clientGoogleService->getClient();
        if ($client->isAccessTokenExpired() && !$client->getRefreshToken()) {
            $autUrl = $this->clientGoogleService-> getAuthUrl();
            return $this->redirect($autUrl);
        }
        //check token twitch
        $isTokenExist = $twitchTokenService->verificationTwitchToken();
        if ($isTokenExist === false) {
            $twitchTokenService->updateTwitchToken();
        }
        // Add data to BDD
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($videoRepository->findOneBy(['videoPicking' => $form->get('videoPicking')->getData()]) === null) {
                $entityManager->persist($video);
                $entityManager->flush();
            //return $this->redirectToRoute('showVideo');
            } else {
                $this->addFlash('danger', 'This video is already added.');
                return $this->redirectToRoute('getVideo');
            }
        }

        //$channelId = 'UCYGjxo5ifuhnmvhPvCc3DJQ';
        //$maxResults = 50;
        //$videoId = "IcSEGhKyLkc";
        //$videos = new YouTubeService($client);
        //$item = $videos->getVideoById($videoId);

        return $this->render('admin/getVideo.html.twig');
    }
    #[Route('/oauth2callback', name: 'oauth2callback')]
    public function oauth2callback(Request $request): Response
    {
        $code = $request->query->get('code');
        $this->clientGoogleService->fetchAccessTokenWithAuthCodes($code);

        return $this->redirectToRoute('getVideo');
    }
}
