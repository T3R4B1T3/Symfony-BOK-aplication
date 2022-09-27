<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleName = [
            "ROLE_MODERATOR",
            "ROLE_USER",
        ];

        for($i = 0; $i < count($roleName); $i++){
            $role = new Role();
            $role->setName($roleName[$i]);
            $manager->persist($role);
        }

        $user = new User();
        $role = new Role();
        $role->setName("ROLE_ADMIN");
        $manager->persist($role);
        $user->addRole($role);
        $user->setUsername('Admin');
        $hashedPassword = password_hash("zaq1@WSX", PASSWORD_DEFAULT);
        $user->setPassword($hashedPassword);
        $manager->persist($user);
        $manager->flush();
    }

}