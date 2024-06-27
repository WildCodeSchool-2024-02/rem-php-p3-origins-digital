<?php

namespace App\Controller;

use App\Entity\TwitchUserWatch;
use App\Form\TwitchUserWatchType;
use App\Repository\TwitchUserWatchRepository;
use App\Service\TwitchService;
use App\Service\TwitchTokenService;
use App\Service\TwitchUserWatchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetTwitchLive extends AbstractController
{
    #[Route('/admin/getTwitchLive', name: 'getTwitchLive')]
    public function index(
        TwitchTokenService $twitchTokenService,
        Request $request,
        TwitchService $twitchService,
        TwitchUserWatchRepository $twitchUserWatchRepository,
        EntityManagerInterface $entityManager,
        TwitchUserWatchService $twitchUserWatchService,
    ): response {
        //check token twitch
        $isTokenExist = $twitchTokenService->verificationTwitchToken();
        if ($isTokenExist === false) {
            $twitchTokenService->updateTwitchToken();
        }

        // Add new user twitch
        $twitchUser = new TwitchUserWatch();
        $form = $this->createForm(TwitchUserWatchType::class, $twitchUser);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($twitchService->twitchUserExists($form->get('name')->getData()) === false) {
                $this->addFlash('danger', 'This User does not exist');
                return $this->redirectToRoute('getTwitchLive');
            }
            if ($twitchUserWatchRepository->findOneBy(['name' => $form->get('name')->getData()]) !== null) {
                $this->addFlash('danger', 'Twitch User already added');
                return $this->redirectToRoute('getTwitchLive');
            } else {
                $entityManager->persist($twitchUser);
                $entityManager->flush();
                $this->addFlash('success', 'Twitch User added');
                return $this->redirectToRoute('getTwitchLive');
            }
        }
        //récuperation live
        $userNames = $twitchUserWatchService->getTwitchUsername();
        $data = $twitchService->getStreams($userNames);

        return $this->render('admin/getTwitchLive.html.twig', [
            'form' => $form->createView(),
            'userNames' => $userNames,
            'data' => $data
        ]);
    }
}
