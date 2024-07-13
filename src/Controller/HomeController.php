<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TwitchUserWatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        TwitchUserWatchRepository $twitchUserRepository,
        CategoryRepository $categoryRepository
    ): Response {
        $lives = $twitchUserRepository->findBy(['is_live' => true]);
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'lives' => $lives,
            'categories' => $categories
        ]);
    }
}
