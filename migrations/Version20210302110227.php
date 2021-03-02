<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210302110227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activitesequencetheorique ADD idsequencetheorique_id INT NOT NULL, ADD idatelier_id INT NOT NULL, ADD ordre INT NOT NULL');
        $this->addSql('ALTER TABLE activitesequencetheorique ADD CONSTRAINT FK_4EDF561A549B9888 FOREIGN KEY (idsequencetheorique_id) REFERENCES sequencetheorique (id)');
        $this->addSql('ALTER TABLE activitesequencetheorique ADD CONSTRAINT FK_4EDF561A4F4BD20F FOREIGN KEY (idatelier_id) REFERENCES atelier (id)');
        $this->addSql('CREATE INDEX IDX_4EDF561A549B9888 ON activitesequencetheorique (idsequencetheorique_id)');
        $this->addSql('CREATE INDEX IDX_4EDF561A4F4BD20F ON activitesequencetheorique (idatelier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activitesequencetheorique DROP FOREIGN KEY FK_4EDF561A549B9888');
        $this->addSql('ALTER TABLE activitesequencetheorique DROP FOREIGN KEY FK_4EDF561A4F4BD20F');
        $this->addSql('DROP INDEX IDX_4EDF561A549B9888 ON activitesequencetheorique');
        $this->addSql('DROP INDEX IDX_4EDF561A4F4BD20F ON activitesequencetheorique');
        $this->addSql('ALTER TABLE activitesequencetheorique DROP idsequencetheorique_id, DROP idatelier_id, DROP ordre');
    }
}
