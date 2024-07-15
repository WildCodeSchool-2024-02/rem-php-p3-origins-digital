<?php

namespace App\DataFixtures;

use App\Entity\Reponse;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\QuestionFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReponseFixtures extends Fixture implements DependentFixtureInterface
{
    const REPONSE = [
        
        "Découvrir les annonces et les événements autour du jeu",
        "Observer les compétitions et les tournois",
        "Entendre les avis et les tests des autres joueurs",
        "Suivre des guides et des tutoriels pour bien commencer",
        "Voir les créations et les mods des autres joueurs",
        "Les analyses de matchs et les compétitions",
        "Les discussions et les interviews avec des experts",
        "Les tutoriels détaillés et les guides de jeu",
        "Les documentaires et les analyses approfondies",
        "Les tests de gameplay et les démonstrations de matériel",
        "Les tests et les comparatifs de hardware",
        "Les événements de présentation de nouveaux produits",
        "Les avis des experts et des influenceurs",
        "Les tutoriels d'installation et de configuration",
        "Les vidéos de gameplay pour tester le matériel",
        "Les événements de lancement et les conférences de presse",
        "Les présentations officielles lors des événements",
        "Les analyses de matchs et les compétitions",
        "Les matchs compétitifs et les tournois de jeux vidéo",
        "Les interviews des développeurs et des créateurs du jeu",
        "Des rediffusions de streams et des parties en direct",
        "Les streams en direct et les rediffusions",
        "Des compétitions de jeux vidéo et des tournois",
        "Les interviews des critiques et des influenceurs",
        "Les événements de lancement et les conférences de presse",
        "Voir les créations et les mods des autres joueurs",
        "Les documentaires et les analyses approfondies",
        "Les documentaires sur le développement du jeu",
        "Des rediffusions de streams et des parties en direct",
        "Les streams en direct et les rediffusions",
        "Les tests et les comparatifs de hardware",
        "Les tests de gameplay et les démonstrations de matériel",
        "Les événements de lancement et les conférences de presse",
        "Les présentations officielles lors des événements",
        "Les interviews des critiques et des influenceurs",
        "Les analyses de matchs et les compétitions",
        "Les discussions et les interviews avec des experts",
        "Les documentaires et les analyses approfondies",
        "Les événements de lancement et les conférences de presse",
        "Les présentations officielles lors des événements",
        "Les tutoriels détaillés et les guides de jeu",
        "Les tutoriels d'installation et de configuration",
        "Les documentaires et les analyses approfondies",
        "Les documentaires sur le développement du jeu",
        "Les tests de gameplay et les démonstrations de matériel",
        "Les événements de lancement et les conférences de presse",
        "Les présentations officielles lors des événements",
        "Les analyses de matchs et les compétitions",
        "Les discussions et les interviews avec des experts",
        "Les documentaires et les analyses approfondies"
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::REPONSE as $key => $response) {
            $reponse = new Reponse();
            $reponse->setResponse($response);
            $this->addReference("Reponse_". $key, $reponse);
            if ($key <= 4) {
            $reponse->setQuestion($this->getReference("question0"));
                } elseif ($key <= 9 && $key > 4) {
                    $reponse->setQuestion($this->getReference("question1"));
                } elseif ($key <= 14 && $key > 9) {
                    $reponse->setQuestion($this->getReference("question2"));
                } elseif ($key <= 19 && $key > 14) {
                    $reponse->setQuestion($this->getReference("question3"));
                } elseif ($key <= 24 && $key > 19) {
                    $reponse->setQuestion($this->getReference("question4"));
                } elseif ($key <= 29 && $key > 24) {
                    $reponse->setQuestion($this->getReference("question5"));
                } elseif ($key <= 34 && $key > 29) {
                    $reponse->setQuestion($this->getReference("question6"));
                } elseif ($key <= 39 && $key > 34) {
                    $reponse->setQuestion($this->getReference("question7"));
                } elseif ($key <= 44 && $key > 39) {
                    $reponse->setQuestion($this->getReference("question8"));
                } elseif ($key <= 49 && $key > 44) {
                    $reponse->setQuestion($this->getReference("question9"));
                }

            $manager->persist($reponse);
        }

        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [QuestionFixtures::class,];
    }
}