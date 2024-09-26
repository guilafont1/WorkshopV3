<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\Loan;
use App\Entity\State;
use App\Entity\Stock;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $states = [];
        for ($i = 0; $i < 10; $i++) {
            $state = new State();
            $state->setDescription($faker->word());
            $manager->persist($state);
            $states[] = $state;
        }

        $stocks = [];
        for ($i = 0; $i < 10; $i++) {
            $stock = new Stock();
            $stock->setType($faker->word());
            $stock->setQuantity($faker->randomNumber());
            $manager->persist($stock);
            $stocks[] = $stock;
        }

        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $userRegular = new User();
            $userRegular->setEmail($faker->email());
            $userRegular->setPassword($this->hasher->hashPassword($userRegular, 'test'));
            $manager->persist($userRegular);
            $users[] = $userRegular;
        }




        $equipments = [];
        for ($i = 0; $i < 10; $i++) {
            $equipment = new Equipment();
            $equipment->setName($faker->name());
            $equipment->setDescription($faker->word());
            $equipment->setAvailable($faker->boolean());
            $equipment->setCreatedAt($faker->dateTime());
            $equipment->setReference($faker->word());
            $equipment->setStateId($faker->randomElement($states));
            $equipment->setTypeId($faker->randomElement($stocks));
            $manager->persist($equipment);
            $equipments[] = $equipment;
        }

        $loans = [];
        for ($i = 0; $i < 10; $i++) {
            $loan = new Loan();
            $loan->setUser($faker->randomElement($users));
            $loan->setEquipment($faker->randomElement($equipments));
            $loan->setStartTime($faker->dateTime());
            $loan->setEndTime($faker->dateTime());
            $loan->setStatus($faker->word());
            $loan->setCreatedAt($faker->dateTime());
            $manager->persist($loan);
            $loans[] = $loan;
        }
        $manager->flush();
    }
}
