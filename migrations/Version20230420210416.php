<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420210416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
       /* $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEF44CABFF');
        $this->addSql('DROP INDEX IDX_E00CEDDEF44CABFF ON booking');
        $this->addSql('ALTER TABLE booking DROP package_id');*/
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        /*$this->addSql('ALTER TABLE booking ADD package_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEF44CABFF FOREIGN KEY (package_id) REFERENCES package (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEF44CABFF ON booking (package_id)');*/
    }
}
