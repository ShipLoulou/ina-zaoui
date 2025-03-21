<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\Album;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class addAlbumTest extends FunctionalTestCase
{
    /**
     * Vérifie que je trouve bien 5 albums sur la page /admin/album.
     */
    public function testShouldListFiveAlbum(): void
    {
        $this->login();
        $this->get('/admin/album');
        self::assertResponseIsSuccessful();
        self::assertSelectorCount(5, 'tr.albumCard');
    }

    public function testShouldAddOneAlbum($name = 'Album Test'): void
    {
        $this->login();

        $this->get('/admin/album/add');

        $this->submit(
            'Ajouter',
            [
                'album[name]' => $name
            ]
        );

        // Vérifie que le bon code status est renvoyé (302).
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        // Vérifier que le nouvel élément à bien été ajouté.
        self::assertSelectorCount(6, 'tr.albumCard');

        // Vérifier que les bonnes informations ont été enregistrer dans la base de donnée.
        $em = $this->service('doctrine.orm.entity_manager');

        $albumRepository = $em->getRepository(Album::class);
        $album = $albumRepository->findOneBy([
            'name' => $name
        ]);

        self::assertNotNull($album);
    }
}
