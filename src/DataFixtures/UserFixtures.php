<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $encoder
    ) {}

    public function load(ObjectManager $manager): void
    {
        $admin = new User;

        $hash = $this->encoder->hashPassword($admin, "password");

        $admin->setAdmin(true);
        $admin->setDescription(null);
        $admin->setEmail("ina@zaoui.com");
        $admin->setName("Ina Zaoui");
        $admin->setPassword($hash);
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        $this->addReference("user_0", $admin);

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
            $this->addReference("user_$index", $user);
        }

        $manager->flush();
    }
}
