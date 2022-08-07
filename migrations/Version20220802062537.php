<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802062537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invitations (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, subject VARCHAR(255) DEFAULT NULL, message VARCHAR(255) DEFAULT NULL, status SMALLINT DEFAULT NULL, INDEX IDX_232710AE6061F7CF (sender_id), INDEX IDX_232710AEBE20CAB0 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invitations ADD CONSTRAINT FK_232710AE6061F7CF FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitations ADD CONSTRAINT FK_232710AEBE20CAB0 FOREIGN KEY (receiver_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE invitations');
    }
}
