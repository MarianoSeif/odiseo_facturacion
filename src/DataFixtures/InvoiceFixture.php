<?php

namespace App\DataFixtures;


use App\Entity\Movement;
use App\Repository\MovementRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\Entity;
use Faker\Factory;
use App\Entity\Invoice;

class InvoiceFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var array
     */
    private $receivedBy = ['diego', 'pablo'];

    private $movementRepository;

    private $referencesIndex = [];

    public function __construct(MovementRepository $movementRepository)
    {
        $this->movementRepository = $movementRepository;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->faker = Factory::create();

        for ($i=0; $i<10; $i++){
            $invoice = new Invoice();
            $invoice->setDetails($this->faker->text(50));
            $invoice->setInvoicedAt($this->faker->dateTimeThisYear);
            $invoice->setNumber("00004-0000".$this->faker->numberBetween(1000, 9999));
            $invoice->setReceivedBy($this->receivedBy[$this->faker->numberBetween(0, 1)]);
            $invoice->addMovement($this->getRandomReference());
            $manager->persist($invoice);
        }

        $manager->flush();
    }

    protected function getRandomReference() {
        foreach ($this->referenceRepository->getReferences() as $key => $ref) {
            if (strpos($key, 'movement_') === 0) {
                $this->referencesIndex[] = $key;
            }
        }
        return $this->getReference($this->faker->randomElement($this->referencesIndex));
    }


    public function getDependencies()
    {
        return [MovementFixture::class, ];
    }


}
