<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('imageFile', VichFileType::class, [
                'required' => true,
                'allow_delete' => true,
                'download_uri' => true,
            ])
            ->add('reponses', EntityType::class, [
                'label' => 'Sélectionnez les réponses correspondantes', // Étiquette facultative
                'label_attr' => ['class' => 'form-label'], // Classes CSS facultatives
                'class' => Reponse::class,
                'choices' => $options['reponses'],
                'choice_label' => 'response', // Choisir le champ de l'entité Reponse à afficher
                'multiple' => true,
                'expanded' => true,
                
                'attr' => ['class' => 'checkbox-custom-input'], // Classes CSS facultatives
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'reponses' => [], // Définition par défaut de 'reponses'
        ]);
    }
}
