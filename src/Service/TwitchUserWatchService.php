<?php

namespace App\Service;

use App\Entity\TwitchUserWatch;
use App\Repository\TwitchUserWatchRepository;

class TwitchUserWatchService
{
    private TwitchUserWatchRepository $twitchUserWatchRepository;

    public function __construct(TwitchUserWatchRepository $twitchUserWatchRepository)
    {
        $this->twitchUserWatchRepository = $twitchUserWatchRepository;
    }

    public function getTwitchUsername(): array
    {
        $users = $this->twitchUserWatchRepository->findAll();
        $userNames = array_map(function (TwitchUserWatch $twitchUser) {
            return $twitchUser->getName();
        }, $users);
        return $userNames;
    }
}
