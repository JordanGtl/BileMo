<?php
namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $array = array(
            ['username' => 'admin', 'password' => 'admin', 'email' => 'admin@admin.fr'],
        );

        $this->createMany(User::class, count($array), function(User $user, $count, $manager) use ($array)
        {
            $user->setUsername($array[$count]['username']);
            $user->setPassword($array[$count]['password']);
            $user->setEmail($array[$count]['email']);
        });

        $manager->flush();
    }
}
