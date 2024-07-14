<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Form\CategoryEditType;
use App\Repository\CategoryRepository;
use App\Repository\ReponseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('admin/category', name:'admin_category')]
    public function categoryDashboard(
        CategoryRepository $categoryRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        ReponseRepository $reponseRepository
    ): Response {
        $categories = $categoryRepository->findAll();
        $reponses = $reponseRepository->findAll();
        
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category, [
            'reponses' => $reponses,
        ]);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            if ($categoryRepository->findOneBy(['name' => $form->getData()->getName()])) {
                $this->addFlash('danger', 'This category already exists!');
                return $this->redirectToRoute('admin_category');
            } else {
                $entityManager->persist($category);
                $entityManager->flush();
                $this->addFlash('success', 'Category created!');
                return $this->redirectToRoute('admin_category');
            }
        }
        
        return $this->render('admin/category.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }


    #[Route('/admin/category/{id}', name: 'delete_category')]
    public function delete(
        Category $category,
        EntityManagerInterface $entityManager
    ): Response {
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('danger', 'Category deleted!');
        return $this->redirectToRoute('admin_category');
    }

    #[Route('/admin/category/edit/{id}', name: 'edit_category')]
    public function edit(
        int $id,
        CategoryRepository $categoryRepository,
        EntityManagerInterface $entityManager,
        Request $request,
        ReponseRepository $reponseRepository
    ): Response {
        $category = $categoryRepository->find($id);
        $reponses = $reponseRepository->findAll();
        
        $form = $this->createForm(CategoryEditType::class, $category, [
            'reponses' => $reponses,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        $reponsesChecked = $form->get('reponses')->getData();
            
            foreach ($reponses as $reponse) {
                $reponse->removeCategory($category);
            }

            foreach ($reponsesChecked as $reponse) {
                $reponse->addCategory($category);
            }

            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été mise à jour.');

            return $this->redirectToRoute('edit_category', ['id' => $category->getId()]);
        } elseif ($form->isSubmitted()) {
            $this->addFlash('danger', 'la mise à jour a échoué');
        }

        return $this->render('admin/category_edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }
}
