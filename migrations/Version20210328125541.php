<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210328125541 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sequencetheorique ADD proprietaire_id INT DEFAULT NULL, ADD partage TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE sequencetheorique ADD CONSTRAINT FK_3107E7DE76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES Utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_3107E7DE76C50E4A ON sequencetheorique (proprietaire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sequencetheorique DROP FOREIGN KEY FK_3107E7DE76C50E4A');
        $this->addSql('DROP INDEX IDX_3107E7DE76C50E4A ON sequencetheorique');
        $this->addSql('ALTER TABLE sequencetheorique DROP proprietaire_id, DROP partage');
        $this->addSql('ALTER TABLE Utilisateur CHANGE password password TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
