<?php

namespace App\Service;

use App\Entity\TwitchUserWatch;
use App\Repository\TwitchUserWatchRepository;

class TwitchUserWatchService
{
    private TwitchUserWatchRepository $twitchUserRepository;

    public function __construct(TwitchUserWatchRepository $twitchUserRepository)
    {
        $this->twitchUserRepository = $twitchUserRepository;
    }

    public function getTwitchUsername(): array
    {
        $users = $this->twitchUserRepository->findAll();
        $userNames = array_map(function (TwitchUserWatch $twitchUser) {
            return $twitchUser->getName();
        }, $users);
        return $userNames;
    }
}
