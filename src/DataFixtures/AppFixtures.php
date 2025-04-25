<?php

namespace App\DataFixtures;

use App\Entity\Song;
use App\Entity\Pool;
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
        // $pools = [];
        // for ($index = 0; $index < 10; $index++) {
        //     //pool
        //     $pool = new Pool();
        //     $pool->setName($this->faker->sentence(3));
        //     $pool->setShortname($this->faker->sentence(1));
        //     $manager->persist($pool);
        //     $pools[] = $pool;
        // }

        for ($index = 0; $index < 100; $index++) {
            $song = new Song();
            $song->setName($this->faker->sentence(3));
            $song->setArtiste($this->faker->name());
            $song->setStatus("on");
            // $song->addPool($pools[array_rand($pools, 1)]);
            $manager->persist($song);
        }
        $manager->flush();
    }
}