<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302193226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activitesequencetheorique (id INT AUTO_INCREMENT NOT NULL, idsequencetheorique_id INT NOT NULL, idatelier_id INT NOT NULL, perfObjectif DOUBLE PRECISION NOT NULL, ordre INT NOT NULL, INDEX IDX_4EDF561A549B9888 (idsequencetheorique_id), INDEX IDX_4EDF561A4F4BD20F (idatelier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categoriesequence (id INT AUTO_INCREMENT NOT NULL, titre TEXT NOT NULL, image TEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sequencetheorique (id INT AUTO_INCREMENT NOT NULL, idcategoriesequence_id INT NOT NULL, titre TEXT NOT NULL, niveau INT NOT NULL, INDEX IDX_3107E7DE5FEF9641 (idcategoriesequence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activitesequencetheorique ADD CONSTRAINT FK_4EDF561A549B9888 FOREIGN KEY (idsequencetheorique_id) REFERENCES sequencetheorique (id)');
        $this->addSql('ALTER TABLE activitesequencetheorique ADD CONSTRAINT FK_4EDF561A4F4BD20F FOREIGN KEY (idatelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE sequencetheorique ADD CONSTRAINT FK_3107E7DE5FEF9641 FOREIGN KEY (idcategoriesequence_id) REFERENCES categoriesequence (id)');
        $this->addSql('ALTER TABLE utilisateur CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sequencetheorique DROP FOREIGN KEY FK_3107E7DE5FEF9641');
        $this->addSql('ALTER TABLE activitesequencetheorique DROP FOREIGN KEY FK_4EDF561A549B9888');
        $this->addSql('DROP TABLE activitesequencetheorique');
        $this->addSql('DROP TABLE categoriesequence');
        $this->addSql('DROP TABLE sequencetheorique');
        $this->addSql('ALTER TABLE Utilisateur CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
