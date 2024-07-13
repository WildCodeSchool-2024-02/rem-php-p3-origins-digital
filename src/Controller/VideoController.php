<?php

namespace App\Controller;

use App\Entity\TwitchUserWatch;
use App\Entity\Video;
use App\Repository\TwitchUserWatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    #[Route('/live/{id}', name: 'videoLive')]
    public function videoLive(
        TwitchUserWatch $twitchUserWatch
    ): Response {
        return $this->render('video/live.html.twig', ['live' => $twitchUserWatch]);
    }
    #[Route('/video/{id}', name: 'video')]
    public function video(
        Video $video
    ): Response {
        return $this->render('video/video.html.twig', ['video' => $video]);
    }
}
