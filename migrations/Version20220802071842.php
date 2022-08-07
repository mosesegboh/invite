<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220802071842 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invitations DROP FOREIGN KEY FK_232710AE6061F7CF');
        $this->addSql('ALTER TABLE invitations DROP FOREIGN KEY FK_232710AEBE20CAB0');
        $this->addSql('DROP INDEX IDX_232710AE6061F7CF ON invitations');
        $this->addSql('DROP INDEX IDX_232710AEBE20CAB0 ON invitations');
        $this->addSql('ALTER TABLE invitations ADD sender_id_id INT DEFAULT NULL, ADD receiver_id_id INT DEFAULT NULL, DROP sender_id, DROP receiver_id');
        $this->addSql('ALTER TABLE invitations ADD CONSTRAINT FK_232710AE6061F7CF FOREIGN KEY (sender_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invitations ADD CONSTRAINT FK_232710AEBE20CAB0 FOREIGN KEY (receiver_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_232710AE6061F7CF ON invitations (sender_id_id)');
        $this->addSql('CREATE INDEX IDX_232710AEBE20CAB0 ON invitations (receiver_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invitations DROP FOREIGN KEY FK_232710AE6061F7CF');
        $this->addSql('ALTER TABLE invitations DROP FOREIGN KEY FK_232710AEBE20CAB0');
        $this->addSql('DROP INDEX IDX_232710AE6061F7CF ON invitations');
        $this->addSql('DROP INDEX IDX_232710AEBE20CAB0 ON invitations');
        $this->addSql('ALTER TABLE invitations ADD sender_id INT DEFAULT NULL, ADD receiver_id INT DEFAULT NULL, DROP sender_id_id, DROP receiver_id_id');
        $this->addSql('ALTER TABLE invitations ADD CONSTRAINT FK_232710AE6061F7CF FOREIGN KEY (sender_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE invitations ADD CONSTRAINT FK_232710AEBE20CAB0 FOREIGN KEY (receiver_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_232710AE6061F7CF ON invitations (sender_id)');
        $this->addSql('CREATE INDEX IDX_232710AEBE20CAB0 ON invitations (receiver_id)');
    }
}
