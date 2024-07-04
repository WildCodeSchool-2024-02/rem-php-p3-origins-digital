<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $user = $options['data'];
        $subscriptionMessage = $user->getSubscription() ? "Vous êtes abonné à Pause Play Game" : "Vous n'êtes pas abonné à Pause Play Game";

        $builder
            ->add('pseudo', null, [
                'label' => 'Pseudonyme'
            ])
            ->add('urlAvatar', null, [
                'label' => "Url de l'avatar"
            ])
            ->add('firstname', null, [
                'label' => 'Nom'
            ])
            ->add('lastname', null, [
                'label' => 'Prenom'
            ])
            ->add('adressStreet', null, [
                'label' => 'Adresse'
            ])
            ->add('adressZipCode', null, [
                'label' => 'Code postal'
            ])
            ->add('adressCity', null, [
                'label' => 'Ville'
            ])
            ->add('adressCountry', null, [
                'label' => 'Pays'
            ])
            ->add('subscriptionMessage', TextType::class, [
                'label' => 'Abonnement',
                'mapped' => false,
                'data' => $subscriptionMessage,
                'disabled' => true,
                'attr' => ['class' => 'form-control-plaintext']
            ])
            ->add('subscriptionDate', null, [
                'label' => "Début d'abonnement",
                'widget' => 'single_text',
                'disabled' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
