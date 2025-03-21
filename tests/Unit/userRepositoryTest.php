<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class userRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);

        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    protected function createUser(): User
    {
        $user = new User;

        $user->setName('New User');
        $user->setEmail('new@test.com');
        $user->setPassword('old_password');

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    public function testUpdatePassword(): void
    {
        $user = $this->createUser();

        self::assertSame('old_password', $user->getPassword());

        $newPassword = 'new_secure_password';

        $this->userRepository->upgradePassword($user, $newPassword);

        self::assertEquals($newPassword, $user->getPassword());
    }
}
