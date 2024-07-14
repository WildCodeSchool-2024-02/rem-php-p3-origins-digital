<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Service\SortedCategoryService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(
        CategoryRepository $categoryRepository,
        SortedCategoryService $categoryService
    ): Response {

        $categories = $categoryRepository->findAll();
        $sortedCategory = $categoryService->getSortedCategories($categories);

        return $this->render('home/index.html.twig', [
            'categories' => $sortedCategory
        ]);
    }
}
