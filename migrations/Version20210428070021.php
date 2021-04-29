<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428070021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire_boisson (id INT AUTO_INCREMENT NOT NULL, proprietaire_id INT DEFAULT NULL, boisson_id INT NOT NULL, titre LONGTEXT NOT NULL, message LONGTEXT NOT NULL, date DATETIME NOT NULL, INDEX IDX_F85F5A1E76C50E4A (proprietaire_id), INDEX IDX_F85F5A1E734B8089 (boisson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire_boisson ADD CONSTRAINT FK_F85F5A1E76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES Utilisateur (id)');
        $this->addSql('ALTER TABLE commentaire_boisson ADD CONSTRAINT FK_F85F5A1E734B8089 FOREIGN KEY (boisson_id) REFERENCES boisson (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE commentaire_boisson');
    }
}
