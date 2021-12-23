<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222114803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contenu_etudiants (id INT AUTO_INCREMENT NOT NULL, depot_etudiant_id_id INT NOT NULL, fullname VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, brochure_filename VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D315952847B67461 (depot_etudiant_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contenu_etudiants ADD CONSTRAINT FK_D315952847B67461 FOREIGN KEY (depot_etudiant_id_id) REFERENCES depots_etudiants (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contenu_etudiants');
    }
}
