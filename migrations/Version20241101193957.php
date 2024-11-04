<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241101193957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP CONSTRAINT fk_c7440455f2c56620');
        $this->addSql('DROP SEQUENCE dette_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE dette DROP CONSTRAINT fk_831bc80819eb6921');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE dette');
        $this->addSql('DROP INDEX uniq_c7440455f2c56620');
        $this->addSql('ALTER TABLE client DROP compte_id');
        $this->addSql('ALTER TABLE client ALTER adresse TYPE TEXT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE dette_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(255) NOT NULL, login VARCHAR(25) NOT NULL, password VARCHAR(15) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE dette (id INT NOT NULL, client_id INT DEFAULT NULL, montant DOUBLE PRECISION NOT NULL, create_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, montant_verser DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_831bc80819eb6921 ON dette (client_id)');
        $this->addSql('COMMENT ON COLUMN dette.create_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE dette ADD CONSTRAINT fk_831bc80819eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE client ADD compte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ALTER adresse TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_c7440455f2c56620 FOREIGN KEY (compte_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_c7440455f2c56620 ON client (compte_id)');
    }
}
