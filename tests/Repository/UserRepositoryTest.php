<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserRepositoryTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        self::bootKernel();

        // Récupère l'EntityManager et le UserRepository
        $this->entityManager = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->userRepository = $this->entityManager->getRepository(User::class);

        // Nettoie la base de données avant chaque test
        $this->truncateEntities();
    }

    public function testUpdatePassword(): void
    {
        // Création d'un utilisateur
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('old_hashed_password');

        // Persiste l'utilisateur dans la base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Appel de la méthode upgradePassword
        $newHashedPassword = 'new_hashed_password';
        $this->userRepository->upgradePassword($user, $newHashedPassword);

        // Récupère l'utilisateur mis à jour
        $updatedUser = $this->userRepository->find($user->getId());

        // Assertions
        $this->assertEquals($newHashedPassword, $updatedUser->getPassword());
    }

    private function truncateEntities(): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        // Désactive les contraintes de clé étrangère
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');

        // Vide la table Playlist
        $connection->executeStatement($platform->getTruncateTableSQL('user', true));

        // Réactive les contraintes de clé étrangère
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
    }
}