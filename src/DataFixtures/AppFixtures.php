<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Album;
use App\Entity\Media;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private UserPasswordHasherInterface $encoder
    ) {}
    public static function getGroups(): array
    {
        return ['app'];
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Création des Users.
        $arrayUsers = [];
        $admin = new User;

        $hash = $this->encoder->hashPassword($admin, "password");

        $admin->setAdmin(true);
        $admin->setDescription(null);
        $admin->setEmail("ina@zaoui.com");
        $admin->setName("Ina Zaoui");
        $admin->setPassword($hash);
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        $arrayUsers[] = $admin;

        for ($index = 1; $index < 25; $index++) {
            $user = new User;

            $hash = $this->encoder->hashPassword($user, "password");

            $user->setAdmin(false);
            $user->setDescription("Le maître de l'urbanité capturée, explore les méandres des cités avec un regard vif et impétueux, figeant l'énergie des rues dans des instants éblouissants. À travers une technique avant-gardiste, il métamorphose le béton et l'acier en toiles abstraites, ");
            $user->setEmail('invite+' . $index - 1 . '@example.com');
            $user->setName("Invité $index");
            $user->setPassword($hash);
            $user->setRoles([]);

            $manager->persist($user);
            $arrayUsers[] = $user;
        }

        // Création des Albums.
        $arrayAlbums = [];

        for ($index = 1; $index < 6; $index++) {
            $album = new Album;
            $album->setId($index);
            $album->setName("Album $index");

            $manager->persist($album);

            $arrayAlbums[] = $album;
        }

        // Création des Medias.
        for ($index = 0; $index < 5051; $index++) {
            $media = new Media;
            if ($index <= 49) {
                /** @var Album */
                $album = $faker->randomElement($arrayAlbums);
                $media->setAlbum($album);
            } else {
                $media->setAlbum(null);
            }

            $indexImage = $index + 1;
            $formattedIndex = str_pad("$indexImage", 4, '0', STR_PAD_LEFT);
            $media->setPath("uploads/$formattedIndex.jpg");

            $media->setTitle("Titre $index");
            /** @var User */
            $user = $faker->randomElement($arrayUsers);
            $media->setUser($user);

            $manager->persist($media);
        }

        $manager->flush();
    }
}
