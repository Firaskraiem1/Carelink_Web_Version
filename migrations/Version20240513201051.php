<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513201051 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY fk_organisateur_email');
        $this->addSql('DROP INDEX fk_organisateur_email ON evenement');
        $this->addSql('ALTER TABLE evenement DROP image, DROP organisateur_email');
        $this->addSql('ALTER TABLE patient ADD nom_p VARCHAR(255) NOT NULL, ADD prenom_p VARCHAR(255) NOT NULL, ADD email_p VARCHAR(255) NOT NULL, DROP nomP, DROP prenomP, DROP emailP, DROP blocked, DROP nbr_annulations, CHANGE numTelP num_tel_p INT NOT NULL');
        $this->addSql('DROP INDEX IDX_29A5EC27AEFA61D3 ON produit');
        $this->addSql('ALTER TABLE produit DROP para_produit_id');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC271AF787D1 FOREIGN KEY (id_c_id) REFERENCES categorie_prod (id)');
        $this->addSql('ALTER TABLE reservation_rdv DROP FOREIGN KEY FK_3');
        $this->addSql('ALTER TABLE reservation_rdv DROP FOREIGN KEY FK_2');
        $this->addSql('DROP INDEX FK_2 ON reservation_rdv');
        $this->addSql('DROP INDEX FK_3 ON reservation_rdv');
        $this->addSql('ALTER TABLE reservation_rdv ADD nbr_annulations INT DEFAULT NULL, ADD patient_id INT DEFAULT NULL, ADD medecin_id INT DEFAULT NULL, DROP patient, DROP medecin');
        $this->addSql('ALTER TABLE reservation_rdv ADD CONSTRAINT FK_45C132596B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE reservation_rdv ADD CONSTRAINT FK_45C132594F31A84 FOREIGN KEY (medecin_id) REFERENCES medecincabinet (id)');
        $this->addSql('CREATE INDEX IDX_45C132596B899279 ON reservation_rdv (patient_id)');
        $this->addSql('CREATE INDEX IDX_45C132594F31A84 ON reservation_rdv (medecin_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, specialité VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (email VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, firstname VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, lastname VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, password VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(200) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, phone VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, role VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, access TINYINT(1) NOT NULL, PRIMARY KEY(email)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement ADD image VARCHAR(255) DEFAULT NULL, ADD organisateur_email VARCHAR(30) DEFAULT NULL COLLATE `utf8mb4_general_ci`');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT fk_organisateur_email FOREIGN KEY (organisateur_email) REFERENCES user (email)');
        $this->addSql('CREATE INDEX fk_organisateur_email ON evenement (organisateur_email)');
        $this->addSql('ALTER TABLE patient ADD nomP VARCHAR(255) NOT NULL, ADD prenomP VARCHAR(255) NOT NULL, ADD emailP VARCHAR(255) NOT NULL, ADD blocked TINYINT(1) DEFAULT NULL, ADD nbr_annulations INT DEFAULT NULL, DROP nom_p, DROP prenom_p, DROP email_p, CHANGE num_tel_p numTelP INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC271AF787D1');
        $this->addSql('ALTER TABLE produit ADD para_produit_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_29A5EC27AEFA61D3 ON produit (para_produit_id)');
        $this->addSql('ALTER TABLE reservation_rdv DROP FOREIGN KEY FK_45C132596B899279');
        $this->addSql('ALTER TABLE reservation_rdv DROP FOREIGN KEY FK_45C132594F31A84');
        $this->addSql('DROP INDEX IDX_45C132596B899279 ON reservation_rdv');
        $this->addSql('DROP INDEX IDX_45C132594F31A84 ON reservation_rdv');
        $this->addSql('ALTER TABLE reservation_rdv ADD patient INT NOT NULL, ADD medecin INT NOT NULL, DROP nbr_annulations, DROP patient_id, DROP medecin_id');
        $this->addSql('ALTER TABLE reservation_rdv ADD CONSTRAINT FK_3 FOREIGN KEY (medecin) REFERENCES medecin (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_rdv ADD CONSTRAINT FK_2 FOREIGN KEY (patient) REFERENCES patient (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX FK_2 ON reservation_rdv (patient)');
        $this->addSql('CREATE INDEX FK_3 ON reservation_rdv (medecin)');
    }
}
