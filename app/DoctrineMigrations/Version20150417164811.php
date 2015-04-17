<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150417164811 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Term CHANGE variation variation VARCHAR(255) DEFAULT NULL, CHANGE pronunciation pronunciation VARCHAR(255) DEFAULT NULL, CHANGE nature nature VARCHAR(255) DEFAULT NULL, CHANGE genre genre VARCHAR(255) DEFAULT NULL, CHANGE number number VARCHAR(255) DEFAULT NULL, CHANGE origin origin LONGTEXT DEFAULT NULL, CHANGE nbVotes nbVotes INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Term CHANGE variation variation VARCHAR(255) NOT NULL, CHANGE pronunciation pronunciation VARCHAR(255) NOT NULL, CHANGE nature nature VARCHAR(255) NOT NULL, CHANGE genre genre VARCHAR(255) NOT NULL, CHANGE number number VARCHAR(255) NOT NULL, CHANGE origin origin LONGTEXT NOT NULL, CHANGE nbVotes nbVotes INT NOT NULL');
    }
}
