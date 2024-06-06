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
        $hashedPassword = $this->passwordHasher->hashPassword($user, 'azerty');
        $user->setPassword($hashedPassword);
        $manager->persist($user);
        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $hashedPassword = $this->passwordHasher->hashPassword($admin, 'admin');
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);
        $manager->flush();
    }
}
