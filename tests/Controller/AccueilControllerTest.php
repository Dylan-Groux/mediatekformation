<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccueilControllerTest extends WebTestCase
{
    public function testAccueilPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
    
        // Vérifie que la réponse HTTP est 200 (OK)
        $this->assertResponseIsSuccessful();
    
        // Vérifie que le titre de la page contient le texte exact
        $this->assertSelectorTextContains('h1', 'Bienvenue sur le site de MediaTek86 consacré aux formations en ligne');
    
        // Vérifie que la liste des formations est affichée
        $this->assertGreaterThan(0, $crawler->filter('.formation-item')->count()); // Suppose que chaque formation a une classe "formation-item"
    }
}