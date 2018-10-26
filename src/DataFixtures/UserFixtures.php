<?php
namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 30, function(User $user, $count, $manager)
        {
            $faker = Faker\Factory::create('fr_FR');

            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            //$user->setClient($this->getReference('App\Entity\Client_'.rand(1, 3)));
            $user->setAdress($faker->address);
            $user->setCity($faker->city);
            $user->setPostalCode($faker->postcode);
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ClientFixtures::class,
        );
    }
}
