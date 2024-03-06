<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306024820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_evenement (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, titre_evenement VARCHAR(255) NOT NULL, type_evenement VARCHAR(255) NOT NULL, lieu_evenement VARCHAR(255) NOT NULL, date_evenement DATE NOT NULL, desc_evenement VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, id_cat_evenement_id INT DEFAULT NULL, INDEX IDX_B26681E4D418E9C (id_cat_evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, horaires_consultation VARCHAR(255) NOT NULL, id_specialite_id INT DEFAULT NULL, INDEX IDX_1BDA53C69FBD3195 (id_specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE para_pharmacie (id INT AUTO_INCREMENT NOT NULL, nom_para VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nbr_pharmaciens INT NOT NULL, numtel INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, latitude VARCHAR(50) NOT NULL, longitude VARCHAR(50) NOT NULL, type_para VARCHAR(255) NOT NULL, horraire_ouverture TIME NOT NULL, horraire_fermeture TIME NOT NULL, ville_id INT DEFAULT NULL, INDEX IDX_404DC295A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, sous_specialite VARCHAR(255) NOT NULL, annee_experience NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(255) NOT NULL, num_rue INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E4D418E9C FOREIGN KEY (id_cat_evenement_id) REFERENCES categorie_evenement (id)');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C69FBD3195 FOREIGN KEY (id_specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE para_pharmacie ADD CONSTRAINT FK_404DC295A73F0036 FOREIGN KEY (ville_id) REFERENCES zone (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E4D418E9C');
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C69FBD3195');
        $this->addSql('ALTER TABLE para_pharmacie DROP FOREIGN KEY FK_404DC295A73F0036');
        $this->addSql('DROP TABLE categorie_evenement');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE para_pharmacie');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE zone');
    }
}
