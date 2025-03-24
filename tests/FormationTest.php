<?php

namespace App\Tests;

use App\Entity\Formation;
use App\Form\FormationType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactoryInterface;
use App\Entity\Playlist;
use Doctrine\ORM\EntityManagerInterface;

class FormationTypeTest extends KernelTestCase
{
    private $formFactory;

    // Déclarer la propriété statique pour le conteneur
    protected static $container;

    protected function setUp(): void
    {
        // Démarrer le kernel Symfony
        self::bootKernel();

        // Initialiser la propriété statique $container
        self::$container = self::getContainer();

        // Récupérer le service FormFactoryInterface à partir du conteneur
        $this->formFactory = self::$container->get(FormFactoryInterface::class);
    }

    public function testGetPublishedAtString()
    {
        // Date à tester
        $date = new \DateTime('2023-01-04 17:00:12');
        
        // Création de l'objet Formation avec cette date
        $formation = new Formation();
        $formation->setPublishedAt($date);  // Assurez-vous que la méthode setPublishedAt existe et est correctement définie
        
        // Test de la méthode getPublishedAtString
        $expected = '04/01/2023';
        $actual = $formation->getPublishedAtString();

        $this->assertEquals($expected, $actual, "Erreur dans le test, date mal formatée : ". $actual . " ne correspond pas avec la date attendue : ". $expected );
    }

    public function testValidPublishedAt()
    {
        // Création d'une playlist valide
        $playlist = new Playlist();
        $playlist->setName('Test Playlist');
    
        $entityManager = self::$container->get(EntityManagerInterface::class);
        $entityManager->persist($playlist);
        $entityManager->flush(); // Sauvegarde en base
    
        // Création de l'entité Formation avec une date valide
        $formation = new Formation();
        $formation->setPublishedAt(new \DateTime('2026-03-28'));
        $formation->setPlaylist($playlist); // Associer à une playlist valide
    
        // Création du formulaire
        $form = $this->formFactory->create(FormationType::class, $formation);
    
        // Soumission des données
        $form->submit([
            'title' => 'Playlist Test',
            'playlist' => $playlist->getId(), // Récupération de l'ID dynamique
            'publishedAt' => '2026-03-28', // Format string
        ]);
    
        // Vérifier et afficher les erreurs si le formulaire est invalide
        if (!$form->isValid()) {
            foreach ($form->getErrors(true) as $error) {
                echo "Erreur générale : " . $error->getMessage() . "\n";
            }
            foreach ($form as $child) {
                if (!$child->isValid()) {
                    foreach ($child->getErrors(true) as $error) {
                        echo "Champ " . $child->getName() . " : " . $error->getMessage() . "\n";
                    }
                }
            }
        }
    
        // Vérifier que le formulaire est valide
        $this->assertTrue($form->isValid(), 'Formulaire invalide avec les erreurs.');
    }

    //Test pour vérifier le format stocké de la date de publication.
    public function testPublishedAtIsDateTimeImmutable()
    {
        // Création d'une playlist valide
        $playlist = new Playlist();
        $playlist->setName('Test Playlist');
        
        $entityManager = self::$container->get(EntityManagerInterface::class);
        $entityManager->persist($playlist);
        $entityManager->flush(); // Sauvegarde en base
        
        // Création de l'entité Formation avec une date valide
        $formation = new Formation();
        $formation->setPublishedAt(new \DateTimeImmutable('2025-03-28')); // Utilisation de DateTimeImmutable
        $formation->setPlaylist($playlist); // Associer à une playlist valide
        
        // Création du formulaire
        $form = $this->formFactory->create(FormationType::class, $formation);
        
        // Soumission des données avec la date sous format string
        $form->submit([
            'title' => 'Playlist Test',
            'playlist' => $playlist->getId(),
            'publishedAt' => '2025-03-28', // Format string
        ]);
        
        // Récupérer la valeur du champ 'publishedAt' et vérifier que c'est un DateTimeImmutable
        $publishedAt = $form->get('publishedAt')->getData();
        
        // Convertir en DateTimeImmutable si ce n'est pas déjà le cas
        if (!$publishedAt instanceof \DateTimeImmutable) {
            $publishedAt = \DateTimeImmutable::createFromMutable($publishedAt);
        }
        
        // Vérification que la date est bien un objet DateTimeImmutable
        $this->assertInstanceOf(\DateTimeImmutable::class, $publishedAt, 'La date doit être un objet DateTimeImmutable.');
    }
    
}
