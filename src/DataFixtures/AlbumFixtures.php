<?php

namespace App\DataFixtures;

use App\Entity\Album;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AlbumFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($index = 1; $index < 6; $index++) {
            $album = new Album;
            $album->setId($index);
            $album->setName("Album $index");

            $manager->persist($album);

            $this->addReference("album_$index", $album);
        }

        $manager->flush();
    }
}
