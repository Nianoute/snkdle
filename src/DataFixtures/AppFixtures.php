<?php

namespace App\DataFixtures;

use App\Entity\Song;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    public function __construct(){
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($index = 0; $index < 100; $index++) {
            $song = new Song();
            $song->setName($this->faker->sentence(3));
            $song->setArtiste($this->faker->name());

            $manager->persist($song);
        }
        $manager->flush();
    }
}
