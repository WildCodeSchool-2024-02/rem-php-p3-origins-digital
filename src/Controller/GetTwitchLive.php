<?php

namespace App\Controller;

use App\Entity\TwitchUserWatch;
use App\Form\TwitchUserWatchType;
use App\Repository\TwitchUserWatchRepository;
use App\Service\TwitchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTwitchLive extends AbstractController
{
    #[Route('/admin/getTwitchLive', name: 'getTwitchLive')]
    public function index(
        Request $request,
        TwitchService $twitchService,
        TwitchUserWatchRepository $twitchUserRepository,
        EntityManagerInterface $entityManager,
    ): response {
        // Add new user twitch
        $twitchUser = new TwitchUserWatch();
        $form = $this->createForm(TwitchUserWatchType::class, $twitchUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($twitchService->twitchUserExists($form->get('name')->getData()) === false) {
                $this->addFlash('danger', 'This User does not exist');
                return $this->redirectToRoute('getTwitchLive');
            }
            if ($twitchUserRepository->findOneBy(['name' => $form->get('name')->getData()]) !== null) {
                $this->addFlash('danger', 'Twitch User already added');
                return $this->redirectToRoute('getTwitchLive');
            } else {
                $entityManager->persist($twitchUser);
                $entityManager->flush();
                $this->addFlash('success', 'Twitch User added');
                return $this->redirectToRoute('getTwitchLive');
            }
        }
        $users = $twitchUserRepository->findBy([], ['id' => 'DESC']);
        return $this->render('admin/getTwitchLive.html.twig', [
            'form' => $form->createView(),
            'users' => $users,
        ]);
    }
    #[Route('/admin/getTwitchLive/{id}', name: 'deleteTwitchUser')]
    public function delete(
        Request $request,
        TwitchUserWatch $twitchUserWatch,
        EntityManagerInterface $entityManager,
    ): Response {
        $this->addFlash('danger', 'Twitch user was deleted');
        $entityManager->remove($twitchUserWatch);
        $entityManager->flush();
        return $this->redirectToRoute('getTwitchLive');
    }
}
