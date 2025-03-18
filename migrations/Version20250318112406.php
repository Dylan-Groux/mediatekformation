<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318112406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formation_categorie (formation_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_830086E95200282E (formation_id), INDEX IDX_830086E9BCF5E72D (categorie_id), PRIMARY KEY(formation_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formation_categorie ADD CONSTRAINT FK_830086E95200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_categorie ADD CONSTRAINT FK_830086E9BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD6345200282E');
        $this->addSql('DROP INDEX IDX_497DD6345200282E ON categorie');
        $this->addSql('ALTER TABLE categorie DROP formation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation_categorie DROP FOREIGN KEY FK_830086E95200282E');
        $this->addSql('ALTER TABLE formation_categorie DROP FOREIGN KEY FK_830086E9BCF5E72D');
        $this->addSql('DROP TABLE formation_categorie');
        $this->addSql('ALTER TABLE categorie ADD formation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD6345200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_497DD6345200282E ON categorie (formation_id)');
    }
}
