<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoryFixtures extends Fixture
{
    const CATEGORY = [
        ['name' => 'Evenement',
        'image' => 'Evenement_img.jpg'],
        ['name' => 'Esport',
        'image' => 'The_International_2014.jpg'],
        ['name' => 'Interview',
        'image' => 'Interview_img.webp'],
        ['name' => 'Tutoriel',
        'image' => 'Tuto_img.webp'],
        ['name' => 'Documentaire',
        'image' => 'Docu_img.jpg'],
        ['name' => 'VOD',
        'image' => 'VOD_img.jpg'],
        ['name' => 'Création communautaire',
        'image' => 'Community_img.jpg'],
        ['name' => 'Test Hardware',
        'image' => 'Hardware_img.webp'],
        ['name' => 'Test Gameplay',
        'image' => 'gameplay_img.jpg'],
        ['name' => 'Live',
        'image' => 'Live_img.jpg'],
    ];

    public function load(ObjectManager $manager): void
    {
        $categoryDir = '/uploads/images/posters';
        if (!is_dir(__DIR__ . '/../../public' .$categoryDir)) {
            mkdir(__DIR__ . '/../../public' .$categoryDir, recursive: true);
        }
        

        foreach (self::CATEGORY as $category) {
            copy(__DIR__ . "/data/" .$category['image'], __DIR__ .'/../../public' .$categoryDir .'/' .$category['image']);
            $newCategory= new Category();
            $newCategory->setName($category['name']);
            $newCategory->setImage($category['image']);
            $this->addReference('category_'.$category['name'], $newCategory);
            $manager->persist($newCategory);
        }
        $manager->flush();
    }
}
