<?php

namespace App\Service;

use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\User;

class SortedCategoryService
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getSortedCategories(array $categories): array
    {
        // On vient chercher l'utilisateur en cours de session
        $user = $this->security->getUser();
        // S'il n'y en a pas, on retourne l'array d'entity tel quel
        if (!$user) {
            return $categories;
        }
        // Création d'un tableau à utiliser dans les boucles
        $categoryCounts = [];
        // Boucle sur les category présente dans les reponses du user en session
        foreach ($user->getReponse() as $reponse) {
            foreach ($reponse->getCategory() as $category) {
                // Isolation de l'id des category
                $categoryId = $category->getId();
                // Verification de l'existance de la category dans le tableau Counts
                if (!isset($categoryCounts[$categoryId])) {
                    // Si elle n'existe pas, initialisation d'un sous-tableau avec son count de départ à 0
                    $categoryCounts[$categoryId] =  ['category' => $category,
                                                    'count' => 0];
                }
                // pour chaque category, +1 au 'count'
                $categoryCounts[$categoryId]['count']++;
            }
        }

        // Utilisation de usort pour trier les counts avec une fonction anonyme en param'
        usort($categories, function ($categoryA, $categoryB) use ($categoryCounts) {
            $countA = $categoryCounts[$categoryA->getId()]['count'] ?? 0;
            $countB = $categoryCounts[$categoryB->getId()]['count'] ?? 0;
            return $countB <=> $countA;
        });

        return $categories;
    }
}
