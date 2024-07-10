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
        'Racing',
        'Simulation',
        'MOBA'
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::GENRES as $genre) {
            $newGenre= new Genres();
            $newGenre->setName($genre);
            $this->addReference('genre_'.$genre, $newGenre);
            $manager->persist($newGenre);
        }
        $manager->flush();
    }
}
