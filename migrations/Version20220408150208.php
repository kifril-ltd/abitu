<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408150208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE specialization_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE student_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE university_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE specialization (id INT NOT NULL, university_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9ED9F26A309D1878 ON specialization (university_id)');
        $this->addSql('CREATE TABLE student (id INT NOT NULL, specializations_id INT DEFAULT NULL, passport VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, birthday DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B723AF336458BC80 ON student (specializations_id)');
        $this->addSql('CREATE TABLE university (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE specialization ADD CONSTRAINT FK_9ED9F26A309D1878 FOREIGN KEY (university_id) REFERENCES university (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF336458BC80 FOREIGN KEY (specializations_id) REFERENCES specialization (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF336458BC80');
        $this->addSql('ALTER TABLE specialization DROP CONSTRAINT FK_9ED9F26A309D1878');
        $this->addSql('DROP SEQUENCE specialization_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE student_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE university_id_seq CASCADE');
        $this->addSql('DROP TABLE specialization');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE university');
    }
}
