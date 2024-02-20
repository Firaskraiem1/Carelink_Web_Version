<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220211840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_evenement (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, id_cat_evenement_id INT DEFAULT NULL, titre_evenement VARCHAR(255) NOT NULL, type_evenement VARCHAR(255) NOT NULL, lieu_evenement VARCHAR(255) NOT NULL, date_evenement VARCHAR(255) NOT NULL, desc_evenement VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_B26681E4D418E9C (id_cat_evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E4D418E9C FOREIGN KEY (id_cat_evenement_id) REFERENCES evenement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E4D418E9C');
        $this->addSql('DROP TABLE category_evenement');
        $this->addSql('DROP TABLE evenement');
    }
}
