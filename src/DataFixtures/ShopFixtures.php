<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $shopValueName = [
            "Nie dotyczny sklepu stacjonarnego",
            "Bałtycka 15",
            "Koszalińska 22"
        ];

        for($i = 0; $i < count($shopValueName); $i++){
            $shop = new Shop();
            $shop->setName($shopValueName[$i]);
            $manager->persist($shop);
        }
        $manager->flush();
    }
}
