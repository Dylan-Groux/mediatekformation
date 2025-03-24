<?php
namespace App\Tests\Repository;

use App\Entity\Playlist;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Formation;

class PlaylistRepositoryTest extends KernelTestCase
{
    private $entityManager;
    private $playlistRepository;

    protected function setUp(): void
    {
        // Démarre le kernel Symfony pour accéder aux services
        self::bootKernel();

        // Récupère l'EntityManager depuis le conteneur de services
        $this->entityManager = self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        // Récupère le repository PlaylistRepository
        $this->playlistRepository = $this->entityManager->getRepository(Playlist::class);

        // Nettoie la base de données avant chaque test
        $this->truncateEntities();
    }

    public function testFindAllWithFormationCount(): void
    {
        // Ajout de données dans la base
        $playlist1 = new Playlist();
        $playlist1->setName('Playlist 1');
    
        $playlist2 = new Playlist();
        $playlist2->setName('Playlist 2');
    
        // Ajout de formations associées aux playlists
        $formation1 = new Formation();
        $formation1->setTitle('Formation 1');
        $formation1->setPlaylist($playlist1);
    
        $formation2 = new Formation();
        $formation2->setTitle('Formation 2');
        $formation2->setPlaylist($playlist1);
    
        $formation3 = new Formation();
        $formation3->setTitle('Formation 3');
        $formation3->setPlaylist($playlist1);
    
        $formation4 = new Formation();
        $formation4->setTitle('Formation 4');
        $formation4->setPlaylist($playlist2);
    
        $formation5 = new Formation();
        $formation5->setTitle('Formation 5');
        $formation5->setPlaylist($playlist2);
    
        $this->entityManager->persist($playlist1);
        $this->entityManager->persist($playlist2);
        $this->entityManager->persist($formation1);
        $this->entityManager->persist($formation2);
        $this->entityManager->persist($formation3);
        $this->entityManager->persist($formation4);
        $this->entityManager->persist($formation5);
        $this->entityManager->flush();
    
        // Appel de la méthode à tester
        $results = $this->playlistRepository->findAllWithFormationCount('DESC');
    
        // Assertions
        $this->assertCount(2, $results);
    
        // Vérifie que les playlists sont triées par le nombre de formations (DESC)
        $this->assertEquals('Playlist 1', $results[0]->getName());
        $this->assertEquals(3, $results[0]->getNbFormations()); // Vérifie le nombre de formations
    
        $this->assertEquals('Playlist 2', $results[1]->getName());
        $this->assertEquals(2, $results[1]->getNbFormations()); // Vérifie le nombre de formations
    }

    private function truncateEntities(): void
    {
        $connection = $this->entityManager->getConnection();
        $platform = $connection->getDatabasePlatform();

        // Désactive les contraintes de clé étrangère
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');

        // Vide la table Playlist
        $connection->executeStatement($platform->getTruncateTableSQL('playlist', true));
        $connection->executeStatement($platform->getTruncateTableSQL('formation', true));

        // Réactive les contraintes de clé étrangère
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null; // Évite les fuites de mémoire
    }
}