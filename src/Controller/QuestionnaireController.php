<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\QuestionnaireType;
use App\Repository\UserRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionnaireController extends AbstractController
{
    // Showall des questionnaires pour l'admin
    #[Route('/questionnaire/showall', name: 'all_quizz')]
    public function show(UserRepository $userRepository, QuestionRepository $questionRepository): Response
    {
        $users = $userRepository->findAll();
        $questions = $questionRepository->findAll();

        return $this->render('questionnaire/showall.html.twig', [
            'users' => $users,
            'questions' => $questions,
        ]);
    }

  // Page du premier quizz pour user fraichement inscrit
    #[Route('/questionnaire/new', name: 'new_quizz')]
    public function newQuestionnaire(
        EntityManagerInterface $entityManager,
        QuestionRepository $questionRepository,
        Request $request
    ): Response {
        $reponses = [];
        $questions = $questionRepository->findAll();
        // Data envoyée au form
        $form = $this->CreateForm(QuestionnaireType::class, $reponses, [
            'questions' => $questions,
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
                    // Persist pour stocker à chaque itération
                    $entityManager->persist($reponseChecked->addUser($this->getUser()));
                }
            }

                    // Flush pour envoyer
                    $entityManager->flush();
                    return $this->redirectToRoute('end_quizz');
        }

        return $this->render('questionnaire/registration.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/questionnaire/end', name: 'end_quizz')]
    public function endQuestionnaire(): Response
    {
        return $this->render('questionnaire/confirmnewquestionnaire.html.twig');
    }

    #[Route('/questionnaire/endeditquizz', name: 'finaledit_quizz')]
    public function endEditQuestionnaire(): Response
    {
        return $this->render('questionnaire/confirmeditquestionnaire.html.twig');
    }

    // Edition du questionnaire dans les options user
    #[Route('/questionnaire/{id}', name: 'edit_quizz')]
    public function editQuestionnaire(
        EntityManagerInterface $entityManager,
        QuestionRepository $questionRepository,
        Request $request,
        User $user,
    ): Response {
        $questions = $questionRepository->findAll();
        $reponses = [];

        foreach ($user->getReponse() as $reponse) {
            $reponses[$reponse->getQuestion()->getId()][] = $reponse;
        }

        $form = $this->CreateForm(QuestionnaireType::class, $reponses, [
            'questions' => $questions,
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($questions as $question) {
                $reponsesChecked = $form->get(strval($question->getId()))->getData();

                foreach ($user->getReponse() as $reponse) {
                    if ($reponse->getQuestion() == $question) {
                        $entityManager->persist($user->removeReponse($reponse));
                    }
                }
                foreach ($reponsesChecked as $reponseChecked) {
                    $entityManager->persist($user->addReponse($reponseChecked));
                }
            }
            $entityManager->flush();
            return $this->redirectToRoute('finaledit_quizz');
        }
        return $this->render('questionnaire/editquestionnaire.html.twig', [
            'form' => $form
        ]);
    }
}
