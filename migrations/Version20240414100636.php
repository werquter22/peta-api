<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240414100636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'add many tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clinic (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_783F8B4B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, service_id INT NOT NULL, clinic_id INT NOT NULL, created_by_id INT NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5D9F75A1A76ED395 (user_id), INDEX IDX_5D9F75A1ED5CA9E6 (service_id), INDEX IDX_5D9F75A1CC22AD4 (clinic_id), INDEX IDX_5D9F75A1B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, created_by_id INT NOT NULL, order_number VARCHAR(255) NOT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F52993988C03F15C (employee_id), INDEX IDX_F5299398B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, name VARCHAR(255) NOT NULL, room VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_E19D9AD2B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE clinic ADD CONSTRAINT FK_783F8B4B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1CC22AD4 FOREIGN KEY (clinic_id) REFERENCES clinic (id)');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD image_id INT DEFAULT NULL, ADD given_name VARCHAR(255) NOT NULL, ADD family_name VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6493DA5256D ON user (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493DA5256D');
        $this->addSql('ALTER TABLE clinic DROP FOREIGN KEY FK_783F8B4B03A8386');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1A76ED395');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1ED5CA9E6');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1CC22AD4');
        $this->addSql('ALTER TABLE employee DROP FOREIGN KEY FK_5D9F75A1B03A8386');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988C03F15C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398B03A8386');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2B03A8386');
        $this->addSql('DROP TABLE clinic');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP INDEX IDX_8D93D6493DA5256D ON user');
        $this->addSql('ALTER TABLE user DROP image_id, DROP given_name, DROP family_name, DROP phone');
    }
}
