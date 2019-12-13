<?php

namespace App\DataFixtures;

use App\Entity\Books;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $book = new Books();
        $book->setTitle("Samuel à la plage");
        $book->setPrice("45");
        $manager->persist($book);

        $book = new Books();
        $book->setTitle("Samuel apprend le code");
        $book->setPrice("45");
        $manager->persist($book);

        $book = new Books();
        $book->setTitle("Samuel sort de sa cité");
        $book->setPrice("45");
        $manager->persist($book);

        $book = new Books();
        $book->setTitle("Samuel veut gagner de l'argent");
        $book->setPrice("45");
        $manager->persist($book);
        
        $manager->flush();
    }
}
