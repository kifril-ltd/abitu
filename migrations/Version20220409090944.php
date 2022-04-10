<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409090944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE student DROP CONSTRAINT fk_b723af336458bc80');
//        $this->addSql('DROP INDEX idx_b723af336458bc80');
        $this->addSql('ALTER TABLE student DROP specializations_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE student ADD specializations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT fk_b723af336458bc80 FOREIGN KEY (specializations_id) REFERENCES specialization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b723af336458bc80 ON student (specializations_id)');
    }
}
