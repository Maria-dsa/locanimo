<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230201131642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD species_id INT DEFAULT NULL, ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F7E3C61F9 ON animal (owner_id)');
        $this->addSql('ALTER TABLE availablity ADD animal_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE availablity ADD CONSTRAINT FK_BD0630818E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_BD0630818E962C16 ON availablity (animal_id)');
        $this->addSql('ALTER TABLE schedule_rental ADD animal_id INT DEFAULT NULL, ADD customer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule_rental ADD CONSTRAINT FK_743886628E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE schedule_rental ADD CONSTRAINT FK_743886629395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_743886628E962C16 ON schedule_rental (animal_id)');
        $this->addSql('CREATE INDEX IDX_743886629395C3F3 ON schedule_rental (customer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F7E3C61F9');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860 ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231F7E3C61F9 ON animal');
        $this->addSql('ALTER TABLE animal DROP species_id, DROP owner_id');
        $this->addSql('ALTER TABLE availablity DROP FOREIGN KEY FK_BD0630818E962C16');
        $this->addSql('DROP INDEX IDX_BD0630818E962C16 ON availablity');
        $this->addSql('ALTER TABLE availablity DROP animal_id');
        $this->addSql('ALTER TABLE schedule_rental DROP FOREIGN KEY FK_743886628E962C16');
        $this->addSql('ALTER TABLE schedule_rental DROP FOREIGN KEY FK_743886629395C3F3');
        $this->addSql('DROP INDEX IDX_743886628E962C16 ON schedule_rental');
        $this->addSql('DROP INDEX IDX_743886629395C3F3 ON schedule_rental');
        $this->addSql('ALTER TABLE schedule_rental DROP animal_id, DROP customer_id');
    }
}
