<?php

namespace App\DataFixtures;

use App\Entity\Media;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\AlbumFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getGroups(): array
    {
        return ['media']; // Nom du groupe
    }

    public function load(ObjectManager $manager): void
    {
        for ($index = 0; $index < 5051; $index++) {
            $media = new Media;
            if ($index <= 49) {
                $album = $this->getReference('album_' . mt_rand(1, 5), AlbumFixtures::class);
                $media->setAlbum($album);
            } else {
                $media->setAlbum(null);
            }

            $formattedIndex = str_pad($index, 4, '0', STR_PAD_LEFT);
            $media->setPath("uploads/$formattedIndex.jpg");

            $media->setTitle("Titre $index");
            $user = $this->getReference('user_0', UserFixtures::class);
            $media->setUser($user);

            $manager->persist($media);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            AlbumFixtures::class
        ];
    }
}
