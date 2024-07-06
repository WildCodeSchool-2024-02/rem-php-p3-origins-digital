<?php

namespace App\Controller;

use App\Form\GameSeekerType;
use App\Service\IgbdService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    #[Route('/admin/game', name: 'game')]
    public function index(
        Request $request,
        IgbdService $igbdService,
        SessionInterface $session
    ): Response {
        $gameSeeker = $this->createForm(GameSeekerType::class);
        $gameSeeker->handleRequest($request);

        if ($gameSeeker->isSubmitted() && $gameSeeker->isValid()) {
            $games = $igbdService->getGameExist($gameSeeker->get('name')->getData());
            $session->set('game', $games);
            if (empty($session->get('game'))) {
                $this->addFlash('danger', 'This game does not exist');
            }
            return $this->redirectToRoute('game');
        }
        if (!empty($session->get('game'))) {
            $gameInfo = $igbdService->getGameInfo($session->get('games')['id']);
            $gameInfo['cover'] = $igbdService->getCover($gameInfo['cover']);
            $session->set('gameInfo', $gameInfo);
        }
        $gameInfo = $session->get('gameInfo');
        return $this->render('admin/game.html.twig', [
            'gameSeeker' => $gameSeeker,
            'gameInfo' => $gameInfo
        ]);
    }
}
