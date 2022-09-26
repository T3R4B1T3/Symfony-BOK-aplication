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
            "Szczecińska 36i",
            "Szczecińska 58",
            "Arciszewkiego 22d",
            "Jana Pawła 2",
            "Portowa 13b"
        ];

        for($i = 0; $i < count($values); $i++){
            $shop = new Shop();
            $shop->setName($values[$i]);
            $manager->persist($shop);
        }

        $manager->flush();
    }
}
