<?php

namespace App\DataFixtures;

use App\Entity\TwitchUserWatch;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TwitchLiveFixtures extends Fixture
{
    const USERTWITCH =[
        'rocketleague',
        'Vitality',
        'gotaga',
        'kamet0',
        'rlgym',
        'saaxqi',
        'nhs_rl',
        'squeezie',
        'tarik',
        'eslcs',
        'kenbogard',
        'tenz',
        'behop_',
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::USERTWITCH as $user) {
            $newTwitch= new TwitchUserWatch();
            $newTwitch->setName($user);
            $manager->persist($newTwitch);
        }
        $manager->flush();
    }
}
