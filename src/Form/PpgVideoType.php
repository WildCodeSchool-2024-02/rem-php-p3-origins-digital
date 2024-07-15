<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\PpgVideo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PpgVideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('videoId')
            ->add('title')
            ->add('description')
            ->add('thumbnail')
            ->add('liveChatId')
            ->add('channelId')
            ->add('publishTime', null, [
                'widget' => 'single_text',
            ])
            ->add('status')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'attr' => ['style' => 'display:none;'],
            ])
            ->add('game', EntityType::class, [
                'class' => Game::class,
                'choice_label' => 'name',
                'attr' => ['style' => 'display:none;'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PpgVideo::class,
        ]);
    }
}
