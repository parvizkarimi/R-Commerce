<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
  
    public function load(ObjectManager $manager): void
    {
      //  $category = new Categories();
        // $manager->persist($product);

        $manager->flush();
    }
}
