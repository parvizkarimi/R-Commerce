<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductsFixtures extends Fixture
{
  public function __construct(private SluggerInterface $slugger)
  {
  }
  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create('fr_FR');

    for ($i = 1; $i < 10; $i++) {

      $product = new Products;
      $product->setName($faker->word());
      $product->setDescription($faker->realText(rand(100, 2000)));
      $product->setSlug($this->slugger->slug($product->getName())->lower());
      $product->setPrice($faker->numberBetween(1141, 111441));
      $product->setStock($faker->numberBetween(1, 11));
      $category = $this->getReference('cat-' . rand(2, 8));
      $product->setCategories($category);
      $this->setReference('prod-' . $i, $product);
      $manager->persist($product);
    }

    $manager->flush();
  }
}
