<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250130111535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nutrient (id INT AUTO_INCREMENT NOT NULL, nutrient_type_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_A9962C5ACBF7D9B1 (nutrient_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nutrient_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, unit VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE nutrient ADD CONSTRAINT FK_A9962C5ACBF7D9B1 FOREIGN KEY (nutrient_type_id) REFERENCES nutrient_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nutrient DROP FOREIGN KEY FK_A9962C5ACBF7D9B1');
        $this->addSql('DROP TABLE nutrient');
        $this->addSql('DROP TABLE nutrient_type');
    }
}
