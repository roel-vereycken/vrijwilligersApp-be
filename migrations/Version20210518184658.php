<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518184658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opmerking ADD opmerking_bericht_id INT DEFAULT NULL, ADD opmerking_user_id INT DEFAULT NULL, ADD opmerking_opmerking_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE opmerking ADD CONSTRAINT FK_7B40F9577B779CD7 FOREIGN KEY (opmerking_bericht_id) REFERENCES bericht (id)');
        $this->addSql('ALTER TABLE opmerking ADD CONSTRAINT FK_7B40F957FC796C8F FOREIGN KEY (opmerking_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE opmerking ADD CONSTRAINT FK_7B40F9579377069F FOREIGN KEY (opmerking_opmerking_id) REFERENCES opmerking (id)');
        $this->addSql('CREATE INDEX IDX_7B40F9577B779CD7 ON opmerking (opmerking_bericht_id)');
        $this->addSql('CREATE INDEX IDX_7B40F957FC796C8F ON opmerking (opmerking_user_id)');
        $this->addSql('CREATE INDEX IDX_7B40F9579377069F ON opmerking (opmerking_opmerking_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE opmerking DROP FOREIGN KEY FK_7B40F9577B779CD7');
        $this->addSql('ALTER TABLE opmerking DROP FOREIGN KEY FK_7B40F957FC796C8F');
        $this->addSql('ALTER TABLE opmerking DROP FOREIGN KEY FK_7B40F9579377069F');
        $this->addSql('DROP INDEX IDX_7B40F9577B779CD7 ON opmerking');
        $this->addSql('DROP INDEX IDX_7B40F957FC796C8F ON opmerking');
        $this->addSql('DROP INDEX IDX_7B40F9579377069F ON opmerking');
        $this->addSql('ALTER TABLE opmerking DROP opmerking_bericht_id, DROP opmerking_user_id, DROP opmerking_opmerking_id');
    }
}
