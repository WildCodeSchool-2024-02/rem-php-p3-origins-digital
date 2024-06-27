<?php

namespace App\Form;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionnaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $questions = $options['questions'];
        $reponses = $options['data'];
        
        foreach ($questions as $question) {
            $builder->add($question->getId(), EntityType::class, [
                    'class' => Reponse::class,
                    'choices' => $question->getReponse(),
                    'choice_label' => 'response',
                    'label' => $question->getTitle(),
                    'multiple' => true,
                    'expanded' => true,
                    'constraints' => [
                        new Count([
                            'max' => 3,
                            'min' => 1,
                            'minMessage' => 'Vous devez selectionner un choix au minimum.',
                            'maxMessage' => 'Vous ne pouvez pas selectionner plus de trois choix.',
                        ]),
                    ],
                    'data' => isset($reponses[$question->getId()]) ? $reponses[$question->getId()] : [],
                    'attr' => [
                        'class' => 'form-check'
                    ],
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
        ]);
        $resolver->setRequired('questions');
    }
}
