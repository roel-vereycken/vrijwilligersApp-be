<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518183243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE event ADD event_locatie_id INT DEFAULT NULL, ADD event_categorie_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA711A9BA23 FOREIGN KEY (event_locatie_id) REFERENCES locatie (id)');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA751E6EDDE FOREIGN KEY (event_categorie_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA711A9BA23 ON event (event_locatie_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA751E6EDDE ON event (event_categorie_id)');
        $this->addSql('ALTER TABLE event_taak ADD taak_id_id INT DEFAULT NULL, ADD event_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event_taak ADD CONSTRAINT FK_3541E75D867EB321 FOREIGN KEY (taak_id_id) REFERENCES taak (id)');
        $this->addSql('ALTER TABLE event_taak ADD CONSTRAINT FK_3541E75D3E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('CREATE INDEX IDX_3541E75D867EB321 ON event_taak (taak_id_id)');
        $this->addSql('CREATE INDEX IDX_3541E75D3E5F2F7B ON event_taak (event_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_event_taak');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA711A9BA23');
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA751E6EDDE');
        $this->addSql('DROP INDEX IDX_3BAE0AA711A9BA23 ON event');
        $this->addSql('DROP INDEX IDX_3BAE0AA751E6EDDE ON event');
        $this->addSql('ALTER TABLE event DROP event_locatie_id, DROP event_categorie_id');
        $this->addSql('ALTER TABLE event_taak DROP FOREIGN KEY FK_3541E75D867EB321');
        $this->addSql('ALTER TABLE event_taak DROP FOREIGN KEY FK_3541E75D3E5F2F7B');
        $this->addSql('DROP INDEX IDX_3541E75D867EB321 ON event_taak');
        $this->addSql('DROP INDEX IDX_3541E75D3E5F2F7B ON event_taak');
        $this->addSql('ALTER TABLE event_taak DROP taak_id_id, DROP event_id_id');
    }
}
