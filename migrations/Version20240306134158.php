<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306134158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie_evenement (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE categorie_prod (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, titre_evenement VARCHAR(255) NOT NULL, type_evenement VARCHAR(255) NOT NULL, lieu_evenement VARCHAR(255) NOT NULL, date_evenement DATE NOT NULL, desc_evenement VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, id_cat_evenement_id INT DEFAULT NULL, INDEX IDX_B26681E4D418E9C (id_cat_evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE fiche_patient (id INT AUTO_INCREMENT NOT NULL, adresse VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, poids DOUBLE PRECISION NOT NULL, taille DOUBLE PRECISION NOT NULL, code_postal INT NOT NULL, ville VARCHAR(255) NOT NULL, maladie VARCHAR(255) NOT NULL, relation_patient_id INT DEFAULT NULL, relation_medecin_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2DB8C3181994860 (relation_patient_id), INDEX IDX_2DB8C31EEE3C09D (relation_medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, horaires_consultation VARCHAR(255) NOT NULL, id_specialite_id INT DEFAULT NULL, INDEX IDX_1BDA53C69FBD3195 (id_specialite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE para_pharmacie (id INT AUTO_INCREMENT NOT NULL, nom_para VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, nbr_pharmaciens INT NOT NULL, numtel INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, latitude VARCHAR(50) NOT NULL, longitude VARCHAR(50) NOT NULL, type_para VARCHAR(255) NOT NULL, horraire_ouverture TIME NOT NULL, horraire_fermeture TIME NOT NULL, ville_id INT DEFAULT NULL, INDEX IDX_404DC295A73F0036 (ville_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, nom_p VARCHAR(255) NOT NULL, prenom_p VARCHAR(255) NOT NULL, email_p VARCHAR(255) NOT NULL, num_tel_p INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom_prod VARCHAR(255) NOT NULL, prix_prod DOUBLE PRECISION NOT NULL, stock_prod INT NOT NULL, image VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, id_c_id INT NOT NULL, INDEX IDX_29A5EC271AF787D1 (id_c_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE reservation_rdv (id INT AUTO_INCREMENT NOT NULL, date_rdv DATE NOT NULL, statut VARCHAR(255) NOT NULL, motif VARCHAR(255) NOT NULL, remarques VARCHAR(255) NOT NULL, nbr_annulations INT DEFAULT NULL, patient_id INT DEFAULT NULL, medecin_id INT DEFAULT NULL, INDEX IDX_45C132596B899279 (patient_id), INDEX IDX_45C132594F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, sous_specialite VARCHAR(255) NOT NULL, annee_experience NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE zone (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(255) NOT NULL, num_rue INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E4D418E9C FOREIGN KEY (id_cat_evenement_id) REFERENCES categorie_evenement (id)');
        $this->addSql('ALTER TABLE fiche_patient ADD CONSTRAINT FK_2DB8C3181994860 FOREIGN KEY (relation_patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE fiche_patient ADD CONSTRAINT FK_2DB8C31EEE3C09D FOREIGN KEY (relation_medecin_id) REFERENCES medecin (id)');
        $this->addSql('ALTER TABLE medecin ADD CONSTRAINT FK_1BDA53C69FBD3195 FOREIGN KEY (id_specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE para_pharmacie ADD CONSTRAINT FK_404DC295A73F0036 FOREIGN KEY (ville_id) REFERENCES zone (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC271AF787D1 FOREIGN KEY (id_c_id) REFERENCES categorie_prod (id)');
        $this->addSql('ALTER TABLE reservation_rdv ADD CONSTRAINT FK_45C132596B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE reservation_rdv ADD CONSTRAINT FK_45C132594F31A84 FOREIGN KEY (medecin_id) REFERENCES medecin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E4D418E9C');
        $this->addSql('ALTER TABLE fiche_patient DROP FOREIGN KEY FK_2DB8C3181994860');
        $this->addSql('ALTER TABLE fiche_patient DROP FOREIGN KEY FK_2DB8C31EEE3C09D');
        $this->addSql('ALTER TABLE medecin DROP FOREIGN KEY FK_1BDA53C69FBD3195');
        $this->addSql('ALTER TABLE para_pharmacie DROP FOREIGN KEY FK_404DC295A73F0036');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC271AF787D1');
        $this->addSql('ALTER TABLE reservation_rdv DROP FOREIGN KEY FK_45C132596B899279');
        $this->addSql('ALTER TABLE reservation_rdv DROP FOREIGN KEY FK_45C132594F31A84');
        $this->addSql('DROP TABLE categorie_evenement');
        $this->addSql('DROP TABLE categorie_prod');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE fiche_patient');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE para_pharmacie');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reservation_rdv');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE zone');
    }
}
