<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415173209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add user_name property';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD user_name VARCHAR(255) NOT NULL, DROP email, DROP given_name, DROP family_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD given_name VARCHAR(255) NOT NULL, ADD family_name VARCHAR(255) NOT NULL, CHANGE user_name email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE category DROP description');
    }
}
