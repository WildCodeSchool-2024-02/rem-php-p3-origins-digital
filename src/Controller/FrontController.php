<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FrontController extends AbstractController
{
    #[Route('/mentionslegales', methods: ['GET'], name: 'mentions_legales')]
    public function mentionslegales(): Response
    {
        return $this->render('front/mentionslegales.html.twig');
    }
}
