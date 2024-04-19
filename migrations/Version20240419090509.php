<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240419090509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'change many tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE employee ADD room VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE message ADD has_seen TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD is_home TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE service DROP room');
        $this->addSql('ALTER TABLE user ADD user_name VARCHAR(255) NOT NULL, DROP email, DROP given_name, DROP family_name');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP room, CHANGE price price INT NOT NULL');
        $this->addSql('ALTER TABLE `order` DROP is_home');
        $this->addSql('ALTER TABLE service ADD room VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD given_name VARCHAR(255) NOT NULL, ADD family_name VARCHAR(255) NOT NULL, CHANGE user_name email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE message DROP has_seen');
        $this->addSql('ALTER TABLE category DROP description');
    }
}
