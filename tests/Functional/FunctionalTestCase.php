<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

abstract class FunctionalTestCase extends WebTestCase
{
    protected KernelBrowser|null $client = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        // Supprimer les données et regénère les fixtures dans la base de donnée. 
        $databaseTool = $this->getContainer()->get(DatabaseToolCollection::class)->get();
        $databaseTool->loadAllFixtures(['test']);
    }

    protected function getEntityManager(): object
    {
        return $this->service(EntityManagerInterface::class);
    }

    protected function service(string $id): object
    {
        $service = $this->client->getContainer()->get($id);
        self::assertNotNull($service);
        return $service;
    }

    /**
     * @param array<string, mixed> $parameters
     */
    protected function get(string $uri, array $parameters = []): Crawler
    {
        return $this->client->request('GET', $uri, $parameters);
    }

    protected function login(string $email = 'ina@zaoui.com'): void
    {
        $user = $this->getEntityManager()->getRepository(User::class)->findOneByEmail($email);
        self::assertNotNull($user);
        $this->client->loginUser($user);
    }

    /**
     * @param array<string, mixed> $formData
     */
    protected function submit(string $button, array $formData = [], string $method = 'POST'): Crawler
    {
        return $this->client->submitForm($button, $formData, $method);
    }
}
