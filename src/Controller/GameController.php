<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameSeekerType;
use App\Form\GameType;
use App\Repository\GameRepository;
use App\Repository\GenresRepository;
use App\Repository\ThemeRepository;
use App\Service\IgbdService;
use Doctrine\ORM\EntityManagerInterface;
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
        SessionInterface $session,
        GameRepository $gameRepository,
        EntityManagerInterface $entityManager,
        GenresRepository $genresRepository,
        ThemeRepository $themeRepository
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
            $gameInfo = $igbdService->getGameInfo($session->get('game')['id']);
            $gameInfo['cover'] = $igbdService->getCover($gameInfo['cover']);
            $session->set('game', $gameInfo);
        }
        $gameInfo = $session->get('game');

        $game = new Game();
        $gameForm = $this->createForm(GameType::class, $game);
        $gameForm->handleRequest($request);
        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            if ($gameRepository->findOneBy(['name' => $gameInfo['name']])) {
                $this->addFlash('danger', 'This Game already added');
                $session->set('game', []);
                return $this->redirectToRoute('game');
            } else {
                $entityManager->persist($game);
                $entityManager->flush();
                $this->addFlash('success', 'Game Created');
                $session->set('game', []);
                return $this->redirectToRoute('game');
            }
        }
        $genres = $genresRepository->findAll();
        $themes = $themeRepository->findAll();
        $games = $gameRepository->findAll();

        return $this->render('admin/game.html.twig', [
            'gameSeeker' => $gameSeeker,
            'gameInfo' => $gameInfo,
            'gameForm' => $gameForm,
            'genres' => $genres,
            'themes' => $themes,
            'games' => $games
        ]);
    }
    #[Route('/admin/game/edit/{id}', name: 'gameEdit')]
    public function gameEdit(
        Game $game,
        Request $request,
        EntityManagerInterface $entityManager,
        GenresRepository $genresRepository,
        ThemeRepository $themeRepository
    ): Response {
        $gameForm = $this->createForm(GameType::class, $game);
        $gameForm->handleRequest($request);
        if ($gameForm->isSubmitted() && $gameForm->isValid()) {
            $this->addFlash('success', 'Game updated');
            $entityManager->flush();
            return $this->redirectToRoute('game');
        }
        $genres = $genresRepository->findAll();
        $themes = $themeRepository->findAll();
        $gameGenresIds = array_map(fn($genre) => $genre->getId(), $game->getGenres()->toArray());
        $gameThemeIds = array_map(fn($theme) => $theme->getId(), $game->getThemes()->toArray());
        return $this->render('admin/edit-game.html.twig', [
            'game' => $game,
            'gameForm' => $gameForm->createView(),
            'genres' => $genres,
            'themes' => $themes,
            'gameGenresIds' => $gameGenresIds,
            'gameThemeIds' => $gameThemeIds
        ]);
    }
    #[Route('/admin/game/delete/{id}', name: 'gameDelete')]
    public function gameDelete(
        Game $game,
        EntityManagerInterface $entityManager,
    ): Response {
        $entityManager->remove($game);
        $entityManager->flush();
        $this->addFlash('success', 'Game Deleted');
        return $this->redirectToRoute('game');
    }
}
