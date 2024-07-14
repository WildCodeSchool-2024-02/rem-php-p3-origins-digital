<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class CategoryEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ])
            ->add('reponses', EntityType::class, [
                'class' => Reponse::class,
                'choices' => $options['reponses'],
                'choice_label' => 'response',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Sélectionnez les réponses correspondantes',
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'checkbox-custom-input'],
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
