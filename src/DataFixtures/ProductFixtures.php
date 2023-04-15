<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $product1 = new Product();
        $product1->setName('Product 1');
        $product1->setDescription('This is product 1');
        $product1->setPrice(10.99);
        $manager->persist($product1);

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setDescription('This is product 2');
        $product2->setPrice(19.99);
        $manager->persist($product2);

        $product3 = new Product();
        $product3->setName('Product 3');
        $product3->setDescription('This is product 3.');
        $product3->setPrice(29.99);
        $manager->persist($product3);

        $manager->flush();
    }
}
