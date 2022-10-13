<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UsersFixtures extends Fixture
{
  public function __construct(
    private UserPasswordHasherInterface $passwordEncoder ,
    private SluggerInterface $slugger
    )  {}
    public function load(ObjectManager $manager): void
    {
    
      $admin = new Users;
      $admin->setFirstname('Rezdar');
      $admin->setLastname ('Karimi');
      $admin->setEmail('greenest_2010@yahoo.com');
      $admin->setAddress('24 RUE marc seguin');
      $admin->setZipcode('65002');
      $admin->setCity('Paris');
      $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
      $admin->setRoles(['ROLE_ADMIN']);
      $manager->persist($admin);

      $faker=Factory::create('fr_FR');

      for ($i=1; $i <5 ; $i++) { 
        
      $user = new Users;
      $user->setFirstname($faker->firstName);
      $user->setLastname ($faker->lastName);
      $user->setEmail($faker->email);
      $user->setAddress($faker->streetAddress);
      $user->setZipcode($faker->postcode);
      $user->setCity($faker->city);
      $user->setPassword($this->passwordEncoder->hashPassword($user, 'user'));
      $manager->persist($user);
      }

        $manager->flush();
    }
}