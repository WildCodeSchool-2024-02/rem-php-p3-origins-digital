<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
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
        SortedCategoryService $categoryService
    ): Response {
        $lives = $twitchUserRepository->findBy(['is_live' => true]);
        $categories = $categoryRepository->findAll();
        $sortedCategory = $categoryService->getSortedCategories($categories);

        return $this->render('home/index.html.twig', [
            'lives' => $lives,
            'categories' => $sortedCategory
        ]);
    }
}
