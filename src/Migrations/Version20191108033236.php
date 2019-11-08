<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108033236 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE personal_information (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, sur_name VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, phone_number VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, smart_meter TINYINT(1) NOT NULL, same_billing TINYINT(1) NOT NULL, special_requirements VARCHAR(255) DEFAULT NULL, holders_name VARCHAR(255) NOT NULL, sort_code VARCHAR(255) NOT NULL, account_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quote ADD personal_information_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF44848E76E FOREIGN KEY (personal_information_id) REFERENCES personal_information (id)');
        $this->addSql('CREATE INDEX IDX_6B71CBF44848E76E ON quote (personal_information_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quote DROP FOREIGN KEY FK_6B71CBF44848E76E');
        $this->addSql('DROP TABLE personal_information');
        $this->addSql('DROP INDEX IDX_6B71CBF44848E76E ON quote');
        $this->addSql('ALTER TABLE quote DROP personal_information_id');
    }
}
