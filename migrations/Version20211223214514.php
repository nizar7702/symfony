<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211223214514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, rubrique_id_id INT NOT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_64C19C1ACEC0FEF (rubrique_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu_depot (id INT AUTO_INCREMENT NOT NULL, depot_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, brochure_filename VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A20D4DA19B5CDF0 (depot_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenu_etudiants (id INT AUTO_INCREMENT NOT NULL, depot_etudiant_id_id INT NOT NULL, fullname VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, brochure_filename VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D315952847B67461 (depot_etudiant_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depots (id INT AUTO_INCREMENT NOT NULL, category_id_id INT NOT NULL, title VARCHAR(255) NOT NULL, nb_likes DOUBLE PRECISION NOT NULL, INDEX IDX_D99EA4279777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depots_etudiants (id INT AUTO_INCREMENT NOT NULL, contenu_depot_id_id INT NOT NULL, full_name VARCHAR(255) NOT NULL, class VARCHAR(255) NOT NULL, INDEX IDX_7F7888EA9709BEF3 (contenu_depot_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE likes (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, contenu_depot_id_id INT DEFAULT NULL, INDEX IDX_49CA4E7D9D86650F (user_id_id), INDEX IDX_49CA4E7D9709BEF3 (contenu_depot_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rubriques (id INT AUTO_INCREMENT NOT NULL, rubrique VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1ACEC0FEF FOREIGN KEY (rubrique_id_id) REFERENCES rubriques (id)');
        $this->addSql('ALTER TABLE contenu_depot ADD CONSTRAINT FK_A20D4DA19B5CDF0 FOREIGN KEY (depot_id_id) REFERENCES depots (id)');
        $this->addSql('ALTER TABLE contenu_etudiants ADD CONSTRAINT FK_D315952847B67461 FOREIGN KEY (depot_etudiant_id_id) REFERENCES depots_etudiants (id)');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA4279777D11E FOREIGN KEY (category_id_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE depots_etudiants ADD CONSTRAINT FK_7F7888EA9709BEF3 FOREIGN KEY (contenu_depot_id_id) REFERENCES contenu_depot (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE likes ADD CONSTRAINT FK_49CA4E7D9709BEF3 FOREIGN KEY (contenu_depot_id_id) REFERENCES depots (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depots DROP FOREIGN KEY FK_D99EA4279777D11E');
        $this->addSql('ALTER TABLE depots_etudiants DROP FOREIGN KEY FK_7F7888EA9709BEF3');
        $this->addSql('ALTER TABLE contenu_depot DROP FOREIGN KEY FK_A20D4DA19B5CDF0');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D9709BEF3');
        $this->addSql('ALTER TABLE contenu_etudiants DROP FOREIGN KEY FK_D315952847B67461');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1ACEC0FEF');
        $this->addSql('ALTER TABLE likes DROP FOREIGN KEY FK_49CA4E7D9D86650F');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE contenu_depot');
        $this->addSql('DROP TABLE contenu_etudiants');
        $this->addSql('DROP TABLE depots');
        $this->addSql('DROP TABLE depots_etudiants');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE rubriques');
        $this->addSql('DROP TABLE user');
    }
}
