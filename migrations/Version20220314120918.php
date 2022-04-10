<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314120918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX un_lib ON repa');
        $this->addSql('ALTER TABLE repa CHANGE id id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE repa MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE repa DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE repa CHANGE id id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX un_lib ON repa (lib_prod)');
    }
}
