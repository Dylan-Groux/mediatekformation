<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250325144552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Migration pour la création des tables et insertion des données initiales.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE categorie (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                PRIMARY KEY(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
        $this->addSql('
            CREATE TABLE doctrine_migration_versions (
                version VARCHAR(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
                executed_at DATETIME DEFAULT NULL,
                execution_time INT DEFAULT NULL,
                PRIMARY KEY(version)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
        ');

        $this->addSql('
            CREATE TABLE formation (
                id INT AUTO_INCREMENT NOT NULL,
                playlist_id INT DEFAULT NULL,
                published_at DATETIME DEFAULT NULL,
                title VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                description LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                video_id VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                PRIMARY KEY(id),
                KEY IDX_404021BF6BBD148 (playlist_id),
                CONSTRAINT FK_404021BF6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->addSql('
            CREATE TABLE formation_categorie (
                formation_id INT NOT NULL,
                categorie_id INT NOT NULL,
                PRIMARY KEY(formation_id, categorie_id),
                KEY IDX_830086E95200282E (formation_id),
                KEY IDX_830086E9BCF5E72D (categorie_id),
                CONSTRAINT FK_830086E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE,
                CONSTRAINT FK_830086E9BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->addSql('
            CREATE TABLE playlist (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                description LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
                PRIMARY KEY(id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->addSql('
            CREATE TABLE playlist_categorie (
                playlist_id INT NOT NULL,
                categorie_id INT NOT NULL,
                PRIMARY KEY(playlist_id, categorie_id),
                KEY IDX_7A8316176BBD148 (playlist_id),
                KEY IDX_7A831617BCF5E72D (categorie_id),
                CONSTRAINT FK_7A8316176BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE,
                CONSTRAINT FK_7A831617BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->addSql('
            CREATE TABLE user (
                id INT AUTO_INCREMENT NOT NULL,
                email VARCHAR(180) COLLATE utf8mb4_unicode_ci NOT NULL,
                roles JSON NOT NULL,
                password VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                PRIMARY KEY(id),
                UNIQUE KEY UNIQ_IDENTIFIER_EMAIL (email)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        $this->addSql('
            CREATE TABLE messenger_messages (
                id BIGINT AUTO_INCREMENT NOT NULL,
                body LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                headers LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                queue_name VARCHAR(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
                created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                PRIMARY KEY(id),
                KEY IDX_75EA56E0FB7336F0 (queue_name),
                KEY IDX_75EA56E0E3BD61CE (available_at),
                KEY IDX_75EA56E016BA31DB (delivered_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');

        // Ajout des données initiales
        $this->addSql('
            INSERT INTO categorie (id, name) VALUES
            (1, \'Java\'),
            (2, \'UML\'),
            (3, \'C#\'),
            (4, \'Python\'),
            (5, \'MCD\'),
            (6, \'Android\'),
            (7, \'POO\'),
            (8, \'SQL\'),
            (9, \'Cours\'),
            (10, \'Ruby\'),
            (18, \'C++\');
        ');

        // Ajout des autres données (formation, playlist, etc.) ici si nécessaire
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE playlist_categorie');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE formation_categorie');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE doctrine_migration_versions');
        $this->addSql('DROP TABLE categorie');
    }
}
