<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107214644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quote ADD gas_money_spend DOUBLE PRECISION DEFAULT NULL, ADD gas_money_per_type VARCHAR(255) DEFAULT NULL, ADD gas_use_kwh DOUBLE PRECISION DEFAULT NULL, ADD elec_money_spend DOUBLE PRECISION DEFAULT NULL, ADD elec_money_per_type VARCHAR(255) DEFAULT NULL, ADD elec_use_kwh DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE quote DROP gas_money_spend, DROP gas_money_per_type, DROP gas_use_kwh, DROP elec_money_spend, DROP elec_money_per_type, DROP elec_use_kwh');
    }
}
