<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PpgVideoRepository;
use App\Repository\TwitchUserWatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\SortedCategoryService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        TwitchUserWatchRepository $twitchUserRepository,
        CategoryRepository $categoryRepository,
        PpgVideoRepository $ppgVideoRepository,
        SortedCategoryService $categoryService
    ): Response {

        $lives = $twitchUserRepository->findBy(['is_live' => true]);
        $ppgLives = $ppgVideoRepository->findBy(['status' => 'live'], ['id' => 'DESC']);
        $categories = $categoryRepository->findAll();
        $sortedCategory = $categoryService->getSortedCategories($categories);

        return $this->render('home/index.html.twig', [
            'ppgLives' => $ppgLives,
            'lives' => $lives,
            'categories' => $sortedCategory
        ]);
    }
}
