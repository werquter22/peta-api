<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414144955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add chat and message tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_by_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_659DF2AAA76ED395 (user_id), INDEX IDX_659DF2AAB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, chat_id INT NOT NULL, created_by_id INT NOT NULL, text LONGTEXT NOT NULL, order_status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_B6BD307F1A9A7125 (chat_id), INDEX IDX_B6BD307FB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE clinic ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B43DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_783F8B43DA5256D ON clinic (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAA76ED395');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAB03A8386');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F1A9A7125');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB03A8386');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B43DA5256D');
        $this->addSql('DROP INDEX IDX_783F8B43DA5256D ON clinic');
        $this->addSql('ALTER TABLE clinic DROP image_id');
    }
}
