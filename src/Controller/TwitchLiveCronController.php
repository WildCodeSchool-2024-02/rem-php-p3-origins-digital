<?php

namespace App\Controller;

use App\Repository\TwitchUserWatchRepository;
use App\Service\TwitchService;
use App\Service\TwitchTokenService;
use App\Service\TwitchUserWatchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TwitchLiveCronController extends AbstractController
{
    #[Route('/admin/twitch-live-cron', name: 'twitch-live-cron')]
    public function index(
        TwitchTokenService $twitchTokenService,
        TwitchUserWatchService $twitchUserService,
        TwitchService $twitchService,
        TwitchUserWatchRepository $twitchUserRepository,
        EntityManagerInterface $entityManager
    ): Response {
        //check token twitch
        $isTokenExist = $twitchTokenService->verificationTwitchToken();
        if ($isTokenExist === false) {
            $twitchTokenService->updateTwitchToken();
        }
        $userNames = $twitchUserService->getTwitchUsername();
        $datas = $twitchService->getStreams($userNames);

        if (!empty($datas)) {
            $excludedUserNames = [];
            foreach ($datas as $data) {
                $twitchUser = $twitchUserRepository->findOneBy(['name' => $data['user_login']]);
                if ($twitchUser !== null) {
                    $twitchUser->setTitle($data['title']);
                    $twitchUser->setThumbnail($twitchService->replacementThumbnailUrl($data['thumbnail_url']));
                    $twitchUser->setLive(true);
                    $twitchUser->setGameId($data['game_id']);
                    $twitchUser->setGameName($data["game_name"]);
                    $twitchUser->setVideoId($data['id']);
                    $entityManager->flush();
                    $excludedUserNames[] = $data['user_login'];
                }
            }
            $usersToUpdate = array_diff($userNames, $excludedUserNames);
            foreach ($usersToUpdate as $userName) {
                $twitchUser = $twitchUserRepository->findOneBy(['name' => $userName]);
                if ($twitchUser !== null) {
                    $twitchUser->setLive(false);
                    $entityManager->flush();
                }
            }
        }
        return $this->render('admin/twitchLiveCron.html.twig');
    }
}
