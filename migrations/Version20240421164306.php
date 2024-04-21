<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421164306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'delete room';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee DROP room');
        $this->addSql('ALTER TABLE `order` DROP order_number');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD room VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD order_number VARCHAR(255) NOT NULL');
    }
}
