<?php
namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixtures
{
    public function loadData(ObjectManager $manager)
    {
        $array = array(
            ['name' => 'Samsung 7',         'price' => 620,     'das' => 0.26, 'screen' => 5],
            ['name' => 'Samsung Note 9',    'price' => 980,     'das' => 0.30, 'screen' => 5.5],
            ['name' => 'Iphone 6',          'price' => 750,     'das' => 0.35, 'screen' => 6],
            ['name' => 'Iphone X',          'price' => 1150,    'das' => 0.19, 'screen' => 6.1]
        );

        $this->createMany(Product::class, count($array), function(Product $product, $count, $manager) use ($array)
        {
            $product->setName($array[$count]['name']);
            $product->setPrice($array[$count]['price']);
            $product->setDas($array[$count]['das']);
            $product->setScreenSize($array[$count]['screen']);
        });

        $manager->flush();
    }
}
