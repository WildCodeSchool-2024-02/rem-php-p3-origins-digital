<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPseudo('Toto');
        $user->setUrlAvatar('https://sm.ign.com/ign_fr/cover/a/avatar-gen/avatar-generations_bssq.jpg');
        $user->setFirstname('user');
        $user->setLastname('bidon');
        $user->setAdressStreet('69 rue de la soif');
        $user->setAdressZipCode(69069);
        $user->setAdressCity('Saint Michel');
        $user->setAdressCountry('France');
        $user->setSubscription(true);
        $user->setSubscriptionDate(date_create('now'));
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'azerty');
        $user->setPassword($hashedPassword);
        $manager->persist($user);
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPseudo('The boss');
        $admin->setFirstname('admin');
        $admin->setLastname('admin');
        $admin->setAdressStreet('01 rue du chef');
        $admin->setAdressZipCode(01000);
        $admin->setAdressCity('adminCity');
        $admin->setAdressCountry('France');
        $admin->setSubscription(true);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);
        $manager->flush();
    }
}
