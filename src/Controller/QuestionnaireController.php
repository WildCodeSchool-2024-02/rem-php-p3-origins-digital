<?php

namespace App\Controller;

use App\Form\QuestionnaireType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionnaireController extends AbstractController
{
    // #[Route('/quizz/show', name: 'all_quizz')]
    // public function show(QuizzRepository $quizzRepository): Response
    // {
    //     $quizz = $quizzRepository->findAll();
    //     return $this->render('quizz/showallquizz.html.twig', [
    //         'allquizz' => $quizz
    //     ]);
    // }

    // #[Route('/quizz/{id}', name: 'user_quizz')]
    // public function showOne(int $id, UserRepository $userRepository): Response
    // {
    //     $user = $userRepository->find($id);

    //     return $this->render('quizz/showallquizz.html.twig', [
    //         'user' => $user
    //     ]);
    // }

    #[Route('/questionnaire/new', name: 'new_quizz')]
    public function newQuestionnaire(
        EntityManagerInterface $entityManager,
        QuestionRepository $questionRepository,
        Request $request
    ): Response {
        $questions = $questionRepository->findAll();
        // Data envoyée au form
        $form = $this->CreateForm(QuestionnaireType::class, null, [
            'questions' => $questions
        ]);
        // Data récupérée du form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($questions as $question) {
                // get est une méthode de form pour récupérer des choses dans
                // l'objet form une fois la data récupérée via request et
                // getData récupére spécifiquement les réponses cochés du user.
                $reponsesChecked = $form->get(strval($question->getId()))->getData();
                foreach ($reponsesChecked as $reponseChecked) {
                    $reponseChecked->addUser($this->getUser());

                    // Persist pour stocker à chaque itération
                    $entityManager->persist($reponseChecked);
                }
            }

                    // Flush pour envoyer
                    $entityManager->flush();
        // faire une route de felicitations + redirection
                    return $this->redirectToRoute('new_quizz');
        }

        return $this->render('questionnaire/registration.html.twig', [
            'form' => $form
        ]);
    }
}
