<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409091916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student_specialization (student_id INT NOT NULL, specialization_id INT NOT NULL, PRIMARY KEY(student_id, specialization_id))');
        $this->addSql('CREATE INDEX IDX_893BD0D1CB944F1A ON student_specialization (student_id)');
        $this->addSql('CREATE INDEX IDX_893BD0D1FA846217 ON student_specialization (specialization_id)');
        $this->addSql('ALTER TABLE student_specialization ADD CONSTRAINT FK_893BD0D1CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student_specialization ADD CONSTRAINT FK_893BD0D1FA846217 FOREIGN KEY (specialization_id) REFERENCES specialization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE student_specialization');
    }
}
