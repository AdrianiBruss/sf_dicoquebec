<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150417164534 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE DayWord (id INT AUTO_INCREMENT NOT NULL, wordId INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Definition (id INT AUTO_INCREMENT NOT NULL, term_id INT DEFAULT NULL, description LONGTEXT NOT NULL, INDEX IDX_276D2C08E2C35FC (term_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Example (id INT AUTO_INCREMENT NOT NULL, term_id INT DEFAULT NULL, example LONGTEXT NOT NULL, translation LONGTEXT NOT NULL, INDEX IDX_A151A203E2C35FC (term_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Term (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, variation VARCHAR(255) NOT NULL, pronunciation VARCHAR(255) NOT NULL, nature VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, origin LONGTEXT NOT NULL, dateCreated DATETIME NOT NULL, nbVotes INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TermBackup (id INT AUTO_INCREMENT NOT NULL, term_id INT DEFAULT NULL, dateModified DATETIME NOT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, variation VARCHAR(255) NOT NULL, pronunciation VARCHAR(255) NOT NULL, nature VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, origin LONGTEXT NOT NULL, INDEX IDX_C80B445EE2C35FC (term_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Definition ADD CONSTRAINT FK_276D2C08E2C35FC FOREIGN KEY (term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE Example ADD CONSTRAINT FK_A151A203E2C35FC FOREIGN KEY (term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE TermBackup ADD CONSTRAINT FK_C80B445EE2C35FC FOREIGN KEY (term_id) REFERENCES Term (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Definition DROP FOREIGN KEY FK_276D2C08E2C35FC');
        $this->addSql('ALTER TABLE Example DROP FOREIGN KEY FK_A151A203E2C35FC');
        $this->addSql('ALTER TABLE TermBackup DROP FOREIGN KEY FK_C80B445EE2C35FC');
        $this->addSql('DROP TABLE DayWord');
        $this->addSql('DROP TABLE Definition');
        $this->addSql('DROP TABLE Example');
        $this->addSql('DROP TABLE Term');
        $this->addSql('DROP TABLE TermBackup');
    }
}
