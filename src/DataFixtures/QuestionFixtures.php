<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    const QUESTIONS = [
        "Quand vous jouez à un nouveau jeu, qu'est-ce qui vous intéresse le plus ?",
        "Quel type de contenu vous aide le plus à améliorer vos compétences de jeu ?",
        "Quand vous achetez un nouveau matériel de jeu, que cherchez-vous avant tout ?",
        "Quel aspect des jeux vidéo trouvez-vous le plus inspirant ?",
        "Quand vous recherchez des informations sur les nouveaux jeux, que préférez-vous regarder ?",
        "Comment aimez-vous rester informé sur les nouveautés du monde des jeux vidéo ?",
        "Quel type de contenu vous aide le plus à prendre des décisions d'achat ?",
        "Qu'est-ce qui vous motive à regarder des vidéos de jeux vidéo ?",
        "Quand vous cherchez des avis sur un jeu, quel type de contenu préférez-vous ?",
        "Quel contenu regardez-vous le plus souvent après une journée de travail ?"
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::QUESTIONS as $key => $questionTitle) {
            $question = new Question();
            $question->setTitle($questionTitle);
            $this->addReference('question' . $key, $question);
            $manager->persist($question);
        }
        
        $manager->flush();
        
    }
}