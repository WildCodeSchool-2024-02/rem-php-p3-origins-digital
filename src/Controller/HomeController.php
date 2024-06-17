<?php

namespace App\Controller;

use App\Repository\ParamApiRepository;
use App\Service\TwitchTokenService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(TwitchTokenService $twitchTokenService, ParamApiRepository $paramApiRepository): Response
    {
        $isTokenExist = $twitchTokenService->verificationTwitchToken();
        if ($isTokenExist === false) {
            $twitchTokenService->updateTwitchToken();
        }
        $token = $paramApiRepository->findAll();

        return $this->render('home/index.html.twig', ['token' => $token]);
    }
}
