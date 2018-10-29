<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
git statu
class ClientFixtures extends BaseFixtures
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->encoder = $passwordEncoder;
    }

    public function loadData(ObjectManager $manager)
    {
        $array = array(
            ['username' => 'member1', 'password' => 'member1', 'email' => 'member1@admin.fr'],
            ['username' => 'member2', 'password' => 'member2', 'email' => 'member2@admin.fr'],
            ['username' => 'member3', 'password' => 'member3', 'email' => 'member3@admin.fr'],
        );

        $this->createMany(Client::class, count($array), function(Client $client, $count, $manager) use ($array)
        {
            $client->setUsername($array[$count]['username']);

            $password = $this->encoder->encodePassword($client, $array[$count]['password']);
            $client->setPassword($password);

            $client->setEmail($array[$count]['email']);
            $client->setIsActive(false);
        });

        $manager->flush();
    }
}
