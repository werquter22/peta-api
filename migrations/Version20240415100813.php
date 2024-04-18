<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415100813 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add category table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_64C19C1B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE clinic ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_783F8B412469DE2 ON clinic (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B412469DE2');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1B03A8386');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP INDEX IDX_783F8B412469DE2 ON clinic');
        $this->addSql('ALTER TABLE clinic DROP category_id');
    }
}
