<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213090224 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_race DROP FOREIGN KEY FK_9D42FA9B6E59D40D');
        $this->addSql('ALTER TABLE animal_race DROP FOREIGN KEY FK_9D42FA9B8E962C16');
        $this->addSql('ALTER TABLE animal_race ADD created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD percent INT NOT NULL');
        $this->addSql('ALTER TABLE animal_race ADD CONSTRAINT FK_9D42FA9B6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal_race ADD CONSTRAINT FK_9D42FA9B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');

        $this->addSql('UPDATE animal_race SET percent = animal_id * 2');

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_race DROP FOREIGN KEY FK_9D42FA9B8E962C16');
        $this->addSql('ALTER TABLE animal_race DROP FOREIGN KEY FK_9D42FA9B6E59D40D');
        $this->addSql('ALTER TABLE animal_race DROP created_at, DROP percent');
        $this->addSql('ALTER TABLE animal_race ADD CONSTRAINT FK_9D42FA9B8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_race ADD CONSTRAINT FK_9D42FA9B6E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE');
    }
}
