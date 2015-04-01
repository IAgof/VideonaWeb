<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150402013328 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE social_facebook (id INT AUTO_INCREMENT NOT NULL, usr INT DEFAULT NULL, facebook_id VARCHAR(255) NOT NULL, facebook_access_token VARCHAR(255) NOT NULL, facebook_access_token_expires_in VARCHAR(50) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, gender VARCHAR(50) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, locale VARCHAR(50) DEFAULT NULL, realname VARCHAR(255) DEFAULT NULL, timezone INT DEFAULT NULL, updated_time VARCHAR(50) DEFAULT NULL, verified TINYINT(1) DEFAULT NULL, profile_picture VARCHAR(100) DEFAULT NULL, nickname VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_E5455CCC9BE8FD98 (facebook_id), UNIQUE INDEX UNIQ_E5455CCC1762498C (usr), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE social_facebook ADD CONSTRAINT FK_E5455CCC1762498C FOREIGN KEY (usr) REFERENCES User (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE social_facebook');
    }
}
