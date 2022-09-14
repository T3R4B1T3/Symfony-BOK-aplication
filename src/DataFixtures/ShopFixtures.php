<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            "Does not apply for physical shop",
            "Long Street 3",
            "Third road 7",
            "Station Road 6",
            "High Street 6",
            "Sixth Street 9"
        ];

        for($i = 0; $i < count($values); $i++){
            $shop = new Shop();
            $shop->setName($values[$i]);
            $manager->persist($shop);
        }

        $manager->flush();
    }
}
