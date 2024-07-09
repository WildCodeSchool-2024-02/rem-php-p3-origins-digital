<?php

namespace App\DataFixtures;

use App\Entity\Theme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThemeFixtures extends Fixture
{
    const THEME = [
        'Anime',
        'Horror',
        'Sci-Fi',
        'Cyberpunk',
        'Space',
        'Survival',
        'Open World',
        'Coop',
        'MMO',
        'Multiplayer',
        'Competitive',
        'Single Player'

    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::THEME as $key => $theme) {
            $newTheme = new Theme();
            $newTheme->setName($theme);
            $this->addReference('theme_'.$theme, $newTheme);
            $manager->persist($newTheme);
        }
        $manager->flush();
    }
}
