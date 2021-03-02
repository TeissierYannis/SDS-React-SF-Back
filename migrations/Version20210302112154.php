<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302112154 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sequencetheorique ADD idcategoriesequence_id INT NOT NULL');
        $this->addSql('ALTER TABLE sequencetheorique ADD CONSTRAINT FK_3107E7DE5FEF9641 FOREIGN KEY (idcategoriesequence_id) REFERENCES categoriesequence (id)');
        $this->addSql('CREATE INDEX IDX_3107E7DE5FEF9641 ON sequencetheorique (idcategoriesequence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sequencetheorique DROP FOREIGN KEY FK_3107E7DE5FEF9641');
        $this->addSql('DROP INDEX IDX_3107E7DE5FEF9641 ON sequencetheorique');
        $this->addSql('ALTER TABLE sequencetheorique DROP idcategoriesequence_id');
    }
}
