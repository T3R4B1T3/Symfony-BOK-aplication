<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            "Missing product",
            "Damaged product",
            "Deception",
            "Harassment",
            "Mobbing",
            "Improvement suggestion"
        ];

        for($i = 0; $i < count($values); $i++){
            $category = new Category();
            $category->setName($values[$i]);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
