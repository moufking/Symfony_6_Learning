<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Migrations\Generator\Generator as GeneratorGenerator;
use Doctrine\Persistence\ObjectManager;
use Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{

    private GeneratorGenerator $faker;

    public function __construct() {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i=0; $i<=50; $i++) {

            $ingredient = new Ingredient();
            //$this->faker->words()
            $ingredient->setName("Incredient ". $i);
            $ingredient->setPrice(0.4);
            $manager->persist($ingredient);
        }
        
        $manager->flush();
    }
}
