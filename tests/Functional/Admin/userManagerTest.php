<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class userManagerTest extends FunctionalTestCase
{
    /**
     * Vérifie que je trouve bien 9 invités sur la page /admin/guest.
     */
    public function testShouldListNineUsers(): void
    {
        $this->login();
        $this->get('/admin/guest');
        self::assertResponseIsSuccessful();
        self::assertSelectorCount(9, 'tr.guestCard');
    }

    /**
     * Vérifie l'ajout d'un invité.
     *      - Ajoute un invité
     *      - Vérifie que l'invité à bien été ajouté
     *      - Vérifie que les informations saisies ont été correctements ajoutés.
     */
    public function testShouldAddOneGuest(
        string $name = 'Invité Test',
        string $description = 'Description de test',
        string $email = 'test@test.com',
        string $password = 'password',
    ): void {
        $this->login();

        $this->get('/admin/guest/add');

        $this->submit(
            'Ajouter',
            [
                'user[name]' => $name,
                'user[description]' => $description,
                'user[email]' => $email,
                'user[password]' => $password,
            ]
        );

        // Vérifie que le bon code status est renvoyé (302).
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        // Vérifier que le nouvel élément à bien été ajouté.
        self::assertSelectorCount(10, 'tr.guestCard');

        // Vérifier que les bonnes informations ont été enregistrer dans la base de donnée.
        $em = $this->service('doctrine.orm.entity_manager');

        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->findOneBy([
            'name' => $name,
            'description' => $description,
            'email' => $email,
        ]);

        self::assertNotNull($user);
    }
}
