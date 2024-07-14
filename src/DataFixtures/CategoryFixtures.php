<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Reponse;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
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
            if ($newCategory->getName($newCategory) == 'Evenement') {
                $newCategory->addReponse($this->getReference('Reponse_0'));
                $newCategory->addReponse($this->getReference('Reponse_11'));
                $newCategory->addReponse($this->getReference('Reponse_15'));
                $newCategory->addReponse($this->getReference('Reponse_24'));
                $newCategory->addReponse($this->getReference('Reponse_32'));
                $newCategory->addReponse($this->getReference('Reponse_38'));
                $newCategory->addReponse($this->getReference('Reponse_45'));
            } elseif ($newCategory->getName($newCategory) == 'Esport') {
                $newCategory->addReponse($this->getReference('Reponse_1'));
                $newCategory->addReponse($this->getReference('Reponse_5'));
                $newCategory->addReponse($this->getReference('Reponse_17'));
                $newCategory->addReponse($this->getReference('Reponse_18'));
                $newCategory->addReponse($this->getReference('Reponse_22'));
                $newCategory->addReponse($this->getReference('Reponse_35'));
                $newCategory->addReponse($this->getReference('Reponse_47'));
            } elseif ($newCategory->getName($newCategory) == 'Interview') {
                $newCategory->addReponse($this->getReference('Reponse_6'));
                $newCategory->addReponse($this->getReference('Reponse_13'));
                $newCategory->addReponse($this->getReference('Reponse_19'));
                $newCategory->addReponse($this->getReference('Reponse_23'));
                $newCategory->addReponse($this->getReference('Reponse_34'));
                $newCategory->addReponse($this->getReference('Reponse_48'));
            } elseif ($newCategory->getName($newCategory) == 'Tutoriel') {
                $newCategory->addReponse($this->getReference('Reponse_3'));
                $newCategory->addReponse($this->getReference('Reponse_7'));
                $newCategory->addReponse($this->getReference('Reponse_13'));
                $newCategory->addReponse($this->getReference('Reponse_40'));
                $newCategory->addReponse($this->getReference('Reponse_41'));
            } elseif ($newCategory->getName($newCategory) == 'Documentaire') {
                $newCategory->addReponse($this->getReference('Reponse_8'));
                $newCategory->addReponse($this->getReference('Reponse_26'));
                $newCategory->addReponse($this->getReference('Reponse_27'));
                $newCategory->addReponse($this->getReference('Reponse_37'));
                $newCategory->addReponse($this->getReference('Reponse_42'));
                $newCategory->addReponse($this->getReference('Reponse_43'));
                $newCategory->addReponse($this->getReference('Reponse_49'));
            } elseif ($newCategory->getName($newCategory) == 'VOD') {
                $newCategory->addReponse($this->getReference('Reponse_2'));
                $newCategory->addReponse($this->getReference('Reponse_9'));
                $newCategory->addReponse($this->getReference('Reponse_12'));
                $newCategory->addReponse($this->getReference('Reponse_48'));
                $newCategory->addReponse($this->getReference('Reponse_23'));
                $newCategory->addReponse($this->getReference('Reponse_34'));
            } elseif ($newCategory->getName($newCategory) == 'Création communautaire') {
                $newCategory->addReponse($this->getReference('Reponse_4'));
                $newCategory->addReponse($this->getReference('Reponse_25'));
            } elseif ($newCategory->getName($newCategory) == 'Test Hardware') {
                $newCategory->addReponse($this->getReference('Reponse_10'));
                $newCategory->addReponse($this->getReference('Reponse_14'));
                $newCategory->addReponse($this->getReference('Reponse_30'));
                $newCategory->addReponse($this->getReference('Reponse_31'));
                $newCategory->addReponse($this->getReference('Reponse_45'));
            } elseif ($newCategory->getName($newCategory) == 'Test Gameplay') {
                $newCategory->addReponse($this->getReference('Reponse_2'));
                $newCategory->addReponse($this->getReference('Reponse_44'));
                $newCategory->addReponse($this->getReference('Reponse_9'));
                $newCategory->addReponse($this->getReference('Reponse_31'));
            }
            
            $manager->persist($newCategory);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ReponseFixtures::class,];
    }
}
