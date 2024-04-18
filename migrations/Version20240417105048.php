<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417105048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'change room';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD room VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE service DROP room');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP room');
        $this->addSql('ALTER TABLE service ADD room VARCHAR(255) NOT NULL');
    }
}
