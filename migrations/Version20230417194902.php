<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417194902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DFB8E54CD');
        $this->addSql('DROP INDEX IDX_773DE69DFB8E54CD ON car');
        $this->addSql('ALTER TABLE car DROP wishlist_id');
        $this->addSql('ALTER TABLE wishlist ADD car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE wishlist ADD CONSTRAINT FK_9CE12A31C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_9CE12A31C3C6F69F ON wishlist (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car ADD wishlist_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DFB8E54CD FOREIGN KEY (wishlist_id) REFERENCES wishlist (id)');
        $this->addSql('CREATE INDEX IDX_773DE69DFB8E54CD ON car (wishlist_id)');
        $this->addSql('ALTER TABLE wishlist DROP FOREIGN KEY FK_9CE12A31C3C6F69F');
        $this->addSql('DROP INDEX IDX_9CE12A31C3C6F69F ON wishlist');
        $this->addSql('ALTER TABLE wishlist DROP car_id');
    }
}
