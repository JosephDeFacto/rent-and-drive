<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230419183326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE package ADD CONSTRAINT FK_DE6867953301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_DE6867953301C60 ON package (booking_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE package DROP FOREIGN KEY FK_DE6867953301C60');
        $this->addSql('DROP INDEX IDX_DE6867953301C60 ON package');
        $this->addSql('ALTER TABLE package DROP booking_id');
    }
}
