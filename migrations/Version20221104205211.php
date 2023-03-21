<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221104205211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidate (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, firstname VARCHAR(50) DEFAULT NULL, lastname VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_C8B28E44A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidature (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, job_offer_id INT NOT NULL, consultant_id INT DEFAULT NULL, validated TINYINT(1) NOT NULL, INDEX IDX_E33BD3B891BD8781 (candidate_id), INDEX IDX_E33BD3B83481D195 (job_offer_id), INDEX IDX_E33BD3B844F779A2 (consultant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_441282A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_offer (id INT AUTO_INCREMENT NOT NULL, recrutor_id INT NOT NULL, consultant_id INT DEFAULT NULL, title VARCHAR(200) NOT NULL, location VARCHAR(100) NOT NULL, detailled_description LONGTEXT NOT NULL, validated TINYINT(1) NOT NULL, INDEX IDX_288A3A4E1C2B9A94 (recrutor_id), INDEX IDX_288A3A4E44F779A2 (consultant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recrutor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, enterprise_address LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', enterprise_name VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_CDC13C7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidate ADD CONSTRAINT FK_C8B28E44A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B891BD8781 FOREIGN KEY (candidate_id) REFERENCES candidate (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B83481D195 FOREIGN KEY (job_offer_id) REFERENCES job_offer (id)');
        $this->addSql('ALTER TABLE candidature ADD CONSTRAINT FK_E33BD3B844F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id)');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A1A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E1C2B9A94 FOREIGN KEY (recrutor_id) REFERENCES recrutor (id)');
        $this->addSql('ALTER TABLE job_offer ADD CONSTRAINT FK_288A3A4E44F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id)');
        $this->addSql('ALTER TABLE recrutor ADD CONSTRAINT FK_CDC13C7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidate DROP FOREIGN KEY FK_C8B28E44A76ED395');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B891BD8781');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B83481D195');
        $this->addSql('ALTER TABLE candidature DROP FOREIGN KEY FK_E33BD3B844F779A2');
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A1A76ED395');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E1C2B9A94');
        $this->addSql('ALTER TABLE job_offer DROP FOREIGN KEY FK_288A3A4E44F779A2');
        $this->addSql('ALTER TABLE recrutor DROP FOREIGN KEY FK_CDC13C7A76ED395');
        $this->addSql('DROP TABLE candidate');
        $this->addSql('DROP TABLE candidature');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP TABLE job_offer');
        $this->addSql('DROP TABLE recrutor');
    }
}
