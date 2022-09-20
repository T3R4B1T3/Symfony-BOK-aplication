<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            "New",
            "In progress",
            "Rejected",
            "Completed",
            "Duplicate"
        ];

        for($i = 0; $i < count($values); $i++){
            $state = new State();
            $state->setName($values[$i]);
            $manager->persist($state);
        }

        $manager->flush();
    }
}
