<?php

namespace App\Controller;

use App\Entity\Genres;
use App\Form\GenreType;
use App\Repository\GenresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GenresController extends AbstractController
{
    #[Route('/admin/genre', name: 'admin_genres')]
    public function index(
        GenresRepository $genresRepository,
        Request $request,
        EntityManagerInterface $entityManager,
    ): Response {
        $genres =  $genresRepository->findAll();

        $genre = new Genres();
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($genresRepository->findOneBy(['name' => $form->getData()->getName()])) {
                $this->addFlash('danger', 'This genre already exists!');
                return $this->redirectToRoute('admin_genres');
            } else {
                $entityManager->persist($genre);
                $entityManager->flush();
                $this->addFlash('success', 'Genre created!');
                return $this->redirectToRoute('admin_genres');
            }
        }
        return $this->render('admin/genre.html.twig', [
            'genres' => $genres,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/admin/genre/{id}', name: 'delete_genre')]
    public function delete(Genres $genre, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($genre);
        $entityManager->flush();
        $this->addFlash('danger', 'Genre deleted!');
        return $this->redirectToRoute('admin_genres');
    }
}
