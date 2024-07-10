<?php

namespace App\DataFixtures;

use App\Entity\ParamApi;
use App\Repository\ParamApiRepository;
use App\Service\TwitchTokenService;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TwitchTokenFixtures extends Fixture
{
    private TwitchTokenService $twitchTokenService;
    private ParamApiRepository $paramApiRepository;

    public function __construct(
        TwitchTokenService $twitchTokenService,
        ParamApiRepository $paramApiRepository
    ) {
        $this->twitchTokenService = $twitchTokenService;
        $this->paramApiRepository = $paramApiRepository;
    }
    public function load(ObjectManager $manager): void
    {
            $paramApi = new ParamApi();
            $paramApi->setToken('Bearer ns50yyi84xznzv06kow9avyxwfz4z8');
            $paramApi->setDateToken(DateTime::createFromFormat('Y-m-d', '2024-08-09'));
            $paramApi->setApiName('twitch');
            $manager->persist($paramApi);
            $manager->flush();
    }
}
