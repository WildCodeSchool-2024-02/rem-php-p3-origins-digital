<?php

namespace App\DataFixtures;

use App\Entity\Game;
use App\Repository\GenresRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture implements DependentFixtureInterface
{
    const GAMES =[
        [
            'name'=> 'Rocket League',
            'description'=> 'Rocket League is a high-powered hybrid of arcade-style soccer and vehicular mayhem with easy-to-understand controls and fluid, physics-driven competition. Rocket League includes casual and competitive Online Matches, a fully-featured offline Season Mode, special “Mutators” that let you change the rules entirely, hockey and basketball-inspired Extra Modes, and more than 500 trillion possible cosmetic customization combinations.',
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co5w0w.jpg',
            'genres' => [
                'Sports',
                'Racing'
            ],
            'themes' => [
                'Competitive',
                'Multiplayer'
            ]
        ],
        [
            'name'=> 'League of Legends',
            'description'=> 'League of Legends is a fast-paced, competitive online game that blends the speed and intensity of an RTS with RPG elements. Two teams of powerful champions, each with a unique design and playstyle, battle head-to-head across multiple battlefields and game modes. With an ever-expanding roster of champions, frequent updates and a thriving tournament scene, League of Legends offers endless replayability for players of every skill level.',
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co49wj.jpg',
            'genres' => [
                'Action',
                'MOBA'
            ],
            'themes' => [
                'Competitive',
                'Multiplayer'
            ]
        ],
        [
            'name'=> 'Counter-Strike 2',
            'description'=> 'For over two decades, Counter-Strike has offered an elite competitive experience, one shaped by millions of players from across the globe. And now the next chapter in the CS story is about to begin. This is Counter-Strike 2.\n\nA free upgrade to CS:GO, Counter-Strike 2 marks the largest technical leap in Counter-Strike’s history. Built on the Source 2 engine, Counter-Strike 2 is modernized with realistic physically-based rendering, state of the art networking, and upgraded Community Workshop tools.',
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co7989.jpg',
            'genres' => [
                'Action',
                'FPS'
            ],
            'themes' => [
                'Competitive',
                'Multiplayer'
            ]
        ],
        [
            'name'=> 'Grand Theft Auto V',
            'description'=> 'Grand Theft Auto V is a vast open world game set in Los Santos, a sprawling sun-soaked metropolis struggling to stay afloat in an era of economic uncertainty and cheap reality TV. The game blends storytelling and gameplay in new ways as players repeatedly jump in and out of the lives of the game’s three lead characters, playing all sides of the game’s interwoven story.',
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co2lbd.jpg',
            'genres' => [
                'TPS',
                'Adventure',
                'Life and Immersive'
            ],
            'themes' => [
                'Multiplayer',
                'Open World'
            ]
        ],
        [
            'name'=> 'Valorant',
            'description'=> 'Valorant is a character-based 5v5 tactical shooter set on the global stage. Outwit, outplay, and outshine your competition with tactical abilities, precise gunplay, and adaptive teamwork.',
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co2mvt.jpg',
            'genres' => [
                'FPS',
                'Action'
            ],
            'themes' => [
                'Multiplayer',
                'Competitive'
            ]
        ],
        [
            'name'=> 'Elden Ring',
            'description'=> 'Elden Ring is a fantasy, action and open world game with RPG elements such as stats, weapons and spells. Rise, Tarnished, and be guided by grace to brandish the power of the Elden Ring and become an Elden Lord in the Lands Between.',
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co4jni.jpg',
            'genres' => [
                'RPG',
                'Adventure'
            ],
            'themes' => [
                'Survival',
                'Multiplayer',
                'Single Player',
                'Open World'
            ]
        ],
        [
            'name'=> 'Apex Legends',
            'description'=> 'Conquer with character in Apex Legends, a free-to-play Hero shooter where legendary characters with powerful abilities team up to battle for fame & fortune on the fringes of the Frontier.\n\nMaster an ever-growing roster of diverse Legends, deep tactical squad play and bold new innovations that go beyond the Battle Royale experience—all within a rugged world where anything goes. Welcome to the next evolution of Hero Shooter.',
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co1wzo.jpg',
            'genres' => [
                'FPS',
                'Action'
            ],
            'themes' => [
                'Survival',
                'Multiplayer',
            ]
        ],
        [
            'name'=> 'Street Fighter 6',
            'description'=> "The evolution of fighting games starts with our traditional Fighting Ground, and then we're turning the genre on its head with World Tour and Battle Hub for a total of three modes where anyone can play to their liking.\n\nNo one starts off as a champion. You get there step by step, punch by punch.\nTake up the challenge and bring your game to the next level.",
            'cover' => '//images.igdb.com/igdb/image/upload/t_720p/co5vst.jpg',
            'genres' => [
                'Fighting',
                'Action'
            ],
            'themes' => [
                'Anime',
                'Multiplayer',
                'Single Player',
                'Competitive'
            ]
        ],



    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::GAMES as $game) {
            $newGame = new Game();
            $newGame->setName($game['name']);
            $newGame->setDescription($game['description']);
            $newGame->setCover($game['cover']);
            if (isset($game['genres'])) {
                foreach ($game['genres'] as $genre) {
                    $newGame->addGenre($this->getReference('genre_' . $genre));
                }
            }
            if (isset($game['themes'])) {
                foreach ($game['themes'] as $theme) {
                    $newGame->addTheme($this->getReference('theme_' . $theme));
                }
            }
            $manager->persist($newGame);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [GenreFixtures::class, ThemeFixtures::class];
    }
}

