<?php

namespace App\Controller;

use App\Service\ClientGoogleService;
use App\Service\YouTubeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddVideoController extends AbstractController
{
    private ClientGoogleService $clientGoogleService;

    public function __construct(ClientGoogleService $clientGoogleService)
    {
        $this->clientGoogleService = $clientGoogleService;
    }
    #[Route('/admin/addVideo', name: 'addVideo')]
    public function index(): Response
    {
        $client = $this->clientGoogleService->getClient();
        if ($client->isAccessTokenExpired() && !$client->getRefreshToken()) {
            $autUrl = $this->clientGoogleService-> getAuthUrl();
            return $this->redirect($autUrl);
        }
        $channelId = 'UCYGjxo5ifuhnmvhPvCc3DJQ';
        $maxResults = 50;
        $videos = new YouTubeService($client);
        $item = $videos->getListVideosByChannelId($channelId, $maxResults);

        return $this->render('admin/addVideo.html.twig', ['item' => $item]);
    }
    #[Route('/oauth2callback', name: 'oauth2callback')]
    public function oauth2callback(Request $request): Response
    {
        $code = $request->query->get('code');
        $this->clientGoogleService->fetchAccessTokenWithAuthCode($code);

        return $this->redirectToRoute('addVideo');
    }
}
