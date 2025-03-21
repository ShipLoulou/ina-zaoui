<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\Album;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\HttpFoundation\Response;

class AlbumControllerTest extends FunctionalTestCase
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

    /**
     * Vérifie l'ajout d'un album.
     *      - Ajoute un album
     *      - Vérifie que l'album à bien été ajouté
     *      - Vérifie que les informations saisies ont été correctements ajoutés. 
     */
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

        $albumRepository = $this->em->getRepository(Album::class);
        $album = $albumRepository->findOneBy([
            'name' => $name
        ]);

        self::assertNotNull($album);
    }

    public function testShouldUpdateOneAlbum($newName = 'Album 1 modifier'): void
    {
        $this->login();

        $albumRepository = $this->em->getRepository(Album::class);
        // Récupère l'album 1.
        $album = $albumRepository->find(1);

        self::assertSame('Album 1', $album->getName());

        $this->get('/admin/album/update/1');

        $this->submit(
            'Modifier',
            [
                'album[name]' => $newName
            ]
        );

        // Vérifie que le bon code status est renvoyé (302).
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        // Récupère l'album 1 modifié.
        $album = $albumRepository->find(1);

        self::assertSame($newName, $album->getName());
    }
}
