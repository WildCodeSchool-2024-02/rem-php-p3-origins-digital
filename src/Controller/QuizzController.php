<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class QuizzController extends AbstractController
{
    #[Route('/quizz/{user}')]
    public function show(): Response
    {
        return $this->render('registration/quizz.html.twig', [

        ]);
    }
}
