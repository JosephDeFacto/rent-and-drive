<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321155451 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEC3C6F69F ON booking (car_id)');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D3301C60');
        $this->addSql('DROP INDEX IDX_773DE69D3301C60 ON car');
        $this->addSql('ALTER TABLE car DROP booking_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEC3C6F69F');
        $this->addSql('DROP INDEX IDX_E00CEDDEC3C6F69F ON booking');
        $this->addSql('ALTER TABLE booking DROP car_id');
        $this->addSql('ALTER TABLE car ADD booking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_773DE69D3301C60 ON car (booking_id)');
    }
}
