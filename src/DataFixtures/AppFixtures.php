<?php

namespace App\DataFixtures;

use App\Entity\Book;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i =0; $i < 20; $i++) {
            $title = 'book' . $i;
            $year = mt_rand(1950,2023);
            $description = 'Book Title: ' . $title . ' Book Year: ' . $year;

            $book = new Book();
            $book->setTitle($title);
            $book->setDescription($description);
            $book->setYearOfPublication($year);
            //$book->setCoverFilename();

            $manager->persist($book);
        }

        $manager->flush();
    }
}
