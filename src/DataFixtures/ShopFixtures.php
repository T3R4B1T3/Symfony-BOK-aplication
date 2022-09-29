<?php

namespace App\DataFixtures;

use App\Entity\Shop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ShopFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $shopName = [
            "Nie dotyczy sklepu fizycznego",
            "Bałtycka 15",
            "Koszalińska 22",
            "Szczecińska 36i",
            "Arciszewskiego 22d",
            "Portowa 12",
        ];

        for($i = 0; $i < count($shopName); $i++){
            $shop = new Shop();
            $shop->setName($shopName[$i]);

            if($i != 0){
             $shop->setCity("Słupsk");
             $shop->setRegion("Pomorskie");
             $shop->setPostCode("76-200");
            }

            if($i == 1){
                $shop->setPhoneNumber("666-666-666");
            }

            if($i == 3){
                $shop->setPhoneNumber("213-769-666");
            }

            $manager->persist($shop);
        }
        $manager->flush();
    }
}
