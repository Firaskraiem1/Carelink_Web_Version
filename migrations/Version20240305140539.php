<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305140539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE para_pharmacie (id INT AUTO_INCREMENT NOT NULL, nom_para VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nbr_pharmaciens INT NOT NULL, numtel INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, latitude VARCHAR(50) NOT NULL, longitude VARCHAR(50) NOT NULL, type_para VARCHAR(255) NOT NULL, horraire_ouverture TIME NOT NULL, horraire_fermeture TIME NOT NULL, ville_id INT DEFAULT NULL, INDEX IDX_404DC295A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(255) NOT NULL, num_rue INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE para_pharmacie ADD CONSTRAINT FK_404DC295A73F0036 FOREIGN KEY (ville_id) REFERENCES zone (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE para_pharmacie DROP FOREIGN KEY FK_404DC295A73F0036');
        $this->addSql('DROP TABLE para_pharmacie');
        $this->addSql('DROP TABLE zone');
    }
}
