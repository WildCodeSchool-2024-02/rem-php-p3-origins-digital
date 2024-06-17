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
        $isTokenExist = $this->twitchTokenService->verificationTwitchToken();
        if ($isTokenExist === false) {
            $paramApi = new ParamApi();
            $paramApi->setToken('Bearer dc1vw2rlvp0g04bo3tm5l76zs7z39n');
            $paramApi->setDateToken(DateTime::createFromFormat('Y-m-d', '2024-08-09'));
            if ($this->paramApiRepository->findOneBy(['apiName' => 'twitch']) === null) {
                $paramApi->setApiName('twitch');
                $manager->persist($paramApi);
            }
            $manager->flush();
        }
    }
}
