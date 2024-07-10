<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('videoPicking', TextType::class)
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('thumbnail', TextType::class)
            ->add('channelId', TextType::class)
            ->add('channelTitle', TextType::class)
            ->add('videoFrom', TextType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id'
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'id',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
