<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin', methods: ['GET'], name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    #[Route('/admin/users', methods: ['GET'], name: 'dashboard_users')]
    public function dashboardUser(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/users.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/admin/users/delete/{id}', name: 'dashboard_user_delete')]
    public function dashboardUserDelete(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        int $id
    ): Response {
        $user = $userRepository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash('success', 'User Deleted with success');
        return $this->redirectToRoute('dashboard_users');
    }
}
