<?php

namespace App\DataFixtures;

use App\Entity\Genres;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    const GENRES = [
        'Action',
        'Fighting',
        'FPS',
        'Hack & Slash',
        'Platform',
        'TPS',
        'Adventure',
        'RPG',
        'Party Game',
        'Rogue Like',
        'Strategy',
        'Space and Flight',
        'Farming and Crafting',
        'Building & Automation',
        'Life and Immersive',
        'Card & Board',
        'Sports',
        'racing',
        'Simulation'
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::GENRES as $key => $genre) {
            $newGenre= new Genres();
            $newGenre->setName($genre);
            $this->addReference('genre_'.$key, $newGenre);
            $manager->persist($newGenre);
        }
        $manager->flush();
    }
}
