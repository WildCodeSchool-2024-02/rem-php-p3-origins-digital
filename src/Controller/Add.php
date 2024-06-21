<?php

namespace App\Controller;

use App\Service\ClientGoogleService;
use App\Service\YouTubeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Add extends AbstractController
{
    private ClientGoogleService $clientGoogleService;

    public function __construct(ClientGoogleService $clientGoogleService)
    {
        $this->clientGoogleService = $clientGoogleService;
    }
    #[Route('/admin/add', name: 'add')]
    public function index(): Response
    {
        $client = $this->clientGoogleService->getClient();
        if ($client->isAccessTokenExpired() && !$client->getRefreshToken()) {
            $autUrl = $this->clientGoogleService-> getAuthUrl();
            return $this->redirect($autUrl);
        }
        //$channelId = 'UCYGjxo5ifuhnmvhPvCc3DJQ';
        //$maxResults = 50;
        //$videoId = "IcSEGhKyLkc";
        //$videos = new YouTubeService($client);
        //$item = $videos->getVideoById($videoId);

        return $this->render('admin/add.html.twig');
    }
    #[Route('/oauth2callback', name: 'oauth2callback')]
    public function oauth2callback(Request $request): Response
    {
        $code = $request->query->get('code');
        $this->clientGoogleService->fetchAccessTokenWithAuthCodes($code);

        return $this->redirectToRoute('add');
    }
}
