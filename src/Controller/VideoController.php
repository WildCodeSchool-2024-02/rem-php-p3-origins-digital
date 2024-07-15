<?php

namespace App\Controller;

use App\Entity\PpgVideo;
use App\Entity\TwitchUserWatch;
use App\Entity\Video;
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
    #[Route('/ppgVideo/{id}', name: 'ppg-video')]
    public function ppgVideo(
        PpgVideo $ppgVideo
    ): Response {
        return $this->render('video/ppg.html.twig', ['video' => $ppgVideo]);
    }
}
