<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\Entity\User;
use App\Entity\Album;
use App\Entity\Media;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class AddMedia extends WebTestCase
{
    protected $databaseTool;
    private KernelBrowser|null $client = null;
    private $userRepository;
    private $albumRepository;
    private $user;
    private $album;

    public function setUp(): void
    {
        $this->client = static::createClient();

        // Supprimer les données et regénère les fixtures dans la base de donnée. 
        $this->databaseTool = $this->getContainer()->get(DatabaseToolCollection::class)->get();
        $this->databaseTool->loadAllFixtures(['test']);

        $this->userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $this->user = $this->userRepository->findOneByEmail('ina@zaoui.com');

        $this->albumRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Album::class);
        $this->album = $this->albumRepository->find(1);

        $this->client->loginUser($this->user);
    }

    /**
     * Vérifie que je trouve bien 10 médias sur la page /admin/media.
     */
    public function testShouldListTwentyFiveMedia(): void
    {
        $crawler = $this->client->request('GET', '/admin/media');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorCount(10, 'tr.mediaCard');
    }

    /**
     * Vérifie l'ajout d'un média.
     */
    public function testShouldAddOneMedia(): void
    {
        // Création d'une image de test.
        $imagePath = '/tmp/test-image.jpg';
        $imageContent = file_get_contents('https://placehold.co/600x400');
        file_put_contents($imagePath, $imageContent);

        $crawler = $this->client->request('GET', '/admin/media/add');

        // Remplissage du formulaire.
        $form = $crawler->selectButton('Ajouter')->form();
        $form['media[user]'] = $this->user->getId();
        $form['media[album]'] = $this->album->getId();
        $form['media[title]'] = 'Titre de test';
        $form['media[file]'] = new UploadedFile(
            $imagePath,
            'test-image.jpg',
            'image/jpeg',
            null,
            true
        );

        $this->client->submit($form);

        // Vérifie que le bon code status est renvoyé (302).
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $this->client->followRedirect();

        unlink($imagePath);

        // Vérifier que le nouvel élément à bien été ajouté.
        $this->assertSelectorCount(11, 'tr.mediaCard');

        // Vérifier que les bonnes informations ont été enregistrer dans la base de donnée.
        $mediaRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Media::class);
        $media = $mediaRepository->findOneBy([
            'user' => $this->user,
            'album' => $this->album,
            'title' => 'Titre de test'
        ]);

        $this->assertNotNull($media);
    }
}
