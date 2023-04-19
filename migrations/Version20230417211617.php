<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417211617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE package_options (id INT AUTO_INCREMENT NOT NULL, package_id INT DEFAULT NULL, INDEX IDX_5F6E9F0BF44CABFF (package_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE package_options ADD CONSTRAINT FK_5F6E9F0BF44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package_options DROP FOREIGN KEY FK_5F6E9F0BF44CABFF');
        $this->addSql('DROP TABLE package_options');
    }
}
