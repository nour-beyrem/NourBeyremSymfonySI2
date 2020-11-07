<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201105001523 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hobbie (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_hobbie (personne_id INT NOT NULL, hobbie_id INT NOT NULL, INDEX IDX_29E6911AA21BD112 (personne_id), INDEX IDX_29E6911A50B678B7 (hobbie_id), PRIMARY KEY(personne_id, hobbie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece_identite (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(20) NOT NULL, identifiant INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne_hobbie ADD CONSTRAINT FK_29E6911AA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personne_hobbie ADD CONSTRAINT FK_29E6911A50B678B7 FOREIGN KEY (hobbie_id) REFERENCES hobbie (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE hobbies_personne');
        $this->addSql('DROP TABLE piece_idntity');
        $this->addSql('ALTER TABLE job ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD piece_identite_id INT DEFAULT NULL, ADD path VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, CHANGE name name VARCHAR(65) NOT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF1B21CC5E FOREIGN KEY (piece_identite_id) REFERENCES piece_identite (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FCEC9EF1B21CC5E ON personne (piece_identite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne_hobbie DROP FOREIGN KEY FK_29E6911A50B678B7');
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF1B21CC5E');
        $this->addSql('CREATE TABLE hobbies_personne (hobbies_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_FD42312BB2242D72 (hobbies_id), INDEX IDX_FD42312BA21BD112 (personne_id), PRIMARY KEY(hobbies_id, personne_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE piece_idntity (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, code SMALLINT NOT NULL, UNIQUE INDEX UNIQ_EB42F34FA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE piece_idntity ADD CONSTRAINT FK_EB42F34FA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id)');
        $this->addSql('DROP TABLE hobbie');
        $this->addSql('DROP TABLE personne_hobbie');
        $this->addSql('DROP TABLE piece_identite');
        $this->addSql('ALTER TABLE job DROP created_at, DROP updated_at');
        $this->addSql('DROP INDEX UNIQ_FCEC9EF1B21CC5E ON personne');
        $this->addSql('ALTER TABLE personne DROP piece_identite_id, DROP path, DROP created_at, DROP updated_at, CHANGE name name VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
