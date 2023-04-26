<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230425162327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_paniers AS SELECT id, utilisateur_id, produit_id, quantite_panier FROM i23_paniers');
        $this->addSql('DROP TABLE i23_paniers');
        $this->addSql('CREATE TABLE i23_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, utilisateur_id INTEGER NOT NULL, produit_id INTEGER DEFAULT NULL, quantite_panier INTEGER DEFAULT NULL, CONSTRAINT FK_62571961FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES i23_users (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_62571961F347EFB FOREIGN KEY (produit_id) REFERENCES i23_produits (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO i23_paniers (id, utilisateur_id, produit_id, quantite_panier) SELECT id, utilisateur_id, produit_id, quantite_panier FROM __temp__i23_paniers');
        $this->addSql('DROP TABLE __temp__i23_paniers');
        $this->addSql('CREATE INDEX IDX_62571961F347EFB ON i23_paniers (produit_id)');
        $this->addSql('CREATE INDEX IDX_62571961FB88E14F ON i23_paniers (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__i23_paniers AS SELECT id, utilisateur_id, produit_id, quantite_panier FROM i23_paniers');
        $this->addSql('DROP TABLE i23_paniers');
        $this->addSql('CREATE TABLE i23_paniers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, utilisateur_id INTEGER NOT NULL, produit_id INTEGER DEFAULT NULL, quantite_panier INTEGER NOT NULL, CONSTRAINT FK_62571961FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES i23_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_62571961F347EFB FOREIGN KEY (produit_id) REFERENCES i23_produits (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO i23_paniers (id, utilisateur_id, produit_id, quantite_panier) SELECT id, utilisateur_id, produit_id, quantite_panier FROM __temp__i23_paniers');
        $this->addSql('DROP TABLE __temp__i23_paniers');
        $this->addSql('CREATE INDEX IDX_62571961FB88E14F ON i23_paniers (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_62571961F347EFB ON i23_paniers (produit_id)');
    }
}
