<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {

    for ($i = 1; $i < 100; $i++) {

      $image = new Images;
      $image->setName("https://picsum.photos/300/200?random=$i");
      $product = $this->getReference('prod-' . rand(1, 9));
      $image->setProducts($product);
      $manager->persist($image);
    }

    $manager->flush();
  }

  public function getDependencies(): array
  {
    return [
      ProductsFixtures::class
    ];
  }
}
