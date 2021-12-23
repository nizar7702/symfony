<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211222105504 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depots_etudiants (id INT AUTO_INCREMENT NOT NULL, contenu_depot_id_id INT NOT NULL, full_name VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, INDEX IDX_7F7888EA9709BEF3 (contenu_depot_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE depots_etudiants ADD CONSTRAINT FK_7F7888EA9709BEF3 FOREIGN KEY (contenu_depot_id_id) REFERENCES contenu_depot (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE depots_etudiants');
    }
}
