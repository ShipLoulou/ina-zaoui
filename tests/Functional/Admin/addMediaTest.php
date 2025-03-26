<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\User;
use App\Tests\Functional\FunctionalTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;

class AddMediaTest extends FunctionalTestCase
{
    /**
     * Vérifie que je trouve bien 10 médias sur la page /admin/media.
     */
    public function testShouldListTwentyFiveMedia(): void
    {
        $this->login();
        $this->get('/admin/media');
        self::assertResponseIsSuccessful();
        self::assertSelectorCount(10, 'tr.mediaCard');
    }

    /**
     * Vérifie l'ajout d'un média.
     *      - Ajoute un média
     *      - Vérifie que le média à bien été ajouté
     *      - Vérifie que les informations saisies ont été correctements ajoutés.
     */
    public function testShouldAddOneMedia(): void
    {
        $this->login();

        $user = $this->getEntityManager()->getRepository(User::class)->findOneByEmail('ina@zaoui.com');
        $album = $this->getEntityManager()->getRepository(Album::class)->find(1);

        // Création d'une image de test.
        $imagePath = __DIR__ . '/../../Fixtures/images/test-image.jpeg';

        $this->get('/admin/media/add');

        $this->submit(
            'Ajouter',
            [
                'media[user]' => $user->getId(),
                'media[album]' => $album->getId(),
                'media[title]' => 'Titre de test',
                'media[file]' => new UploadedFile(
                    $imagePath,
                    'test-image.jpeg',
                    'image/jpeg',
                    null,
                    true
                ),
            ]
        );

        // Vérifie que le bon code status est renvoyé (302).
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        unlink($imagePath);

        // Vérifier que le nouvel élément à bien été ajouté.
        self::assertSelectorCount(11, 'tr.mediaCard');

        // Vérifier que les bonnes informations ont été enregistrer dans la base de donnée.
        $em = $this->service('doctrine.orm.entity_manager');

        $mediaRepository = $em->getRepository(Media::class);
        $media = $mediaRepository->findOneBy([
            'user' => $user,
            'album' => $album,
            'title' => 'Titre de test',
        ]);

        self::assertNotNull($media);
    }
}
