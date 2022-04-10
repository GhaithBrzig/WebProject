<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220322191440 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(90) NOT NULL, commentaire VARCHAR(160) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX categorie ON categories');
        $this->addSql('ALTER TABLE repa DROP FOREIGN KEY fk_categorie');
        $this->addSql('ALTER TABLE repa DROP FOREIGN KEY fk_cat');
        $this->addSql('DROP INDEX fk_cat ON repa');
        $this->addSql('ALTER TABLE repa CHANGE categorie categorie VARCHAR(60) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE avis');
        $this->addSql('CREATE UNIQUE INDEX categorie ON categories (categorie)');
        $this->addSql('ALTER TABLE repa CHANGE categorie categorie VARCHAR(60) DEFAULT \'autre\'');
        $this->addSql('ALTER TABLE repa ADD CONSTRAINT fk_categorie FOREIGN KEY (categorie) REFERENCES categories (categorie)');
        $this->addSql('ALTER TABLE repa ADD CONSTRAINT fk_cat FOREIGN KEY (categorie) REFERENCES categories (categorie) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX fk_cat ON repa (categorie)');
    }
}
