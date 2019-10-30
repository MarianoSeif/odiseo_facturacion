<?php

namespace App\DataFixtures;

use App\Entity\Movement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class MovementFixture extends Fixture
{
    /** @var \Faker\Generator */
    private $faker;

    /**
     * @var array
     */
    private $movementType = ['revenue', 'expense'];

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        for ($i=0; $i<10; $i++){
            $movement = new Movement();
            $movement->setTitle($this->faker->title);
            $movement->setDate($this->faker->dateTimeThisYear);
            $movement->setPrice($this->faker->randomNumber([4]));
            $movement->setType($this->movementType[$this->faker->numberBetween(0, 1)]);
            $this->addReference(sprintf('movement_%d', $i), $movement);
            $manager->persist($movement);
        }

        $manager->flush();
    }
}
