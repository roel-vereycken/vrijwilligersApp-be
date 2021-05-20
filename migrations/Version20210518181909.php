<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518181909 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bericht ADD user_bericht_id INT DEFAULT NULL, ADD event_bericht_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bericht ADD CONSTRAINT FK_AC9D368E2D2F4B76 FOREIGN KEY (user_bericht_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE bericht ADD CONSTRAINT FK_AC9D368ED2A654B5 FOREIGN KEY (event_bericht_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_AC9D368E2D2F4B76 ON bericht (user_bericht_id)');
        $this->addSql('CREATE INDEX IDX_AC9D368ED2A654B5 ON bericht (event_bericht_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bericht DROP FOREIGN KEY FK_AC9D368E2D2F4B76');
        $this->addSql('ALTER TABLE bericht DROP FOREIGN KEY FK_AC9D368ED2A654B5');
        $this->addSql('DROP INDEX IDX_AC9D368E2D2F4B76 ON bericht');
        $this->addSql('DROP INDEX IDX_AC9D368ED2A654B5 ON bericht');
        $this->addSql('ALTER TABLE bericht DROP user_bericht_id, DROP event_bericht_id');
    }
}
