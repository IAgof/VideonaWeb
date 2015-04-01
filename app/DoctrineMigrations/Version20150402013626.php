<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150402013626 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE social_twitter (id INT AUTO_INCREMENT NOT NULL, usr INT DEFAULT NULL, twitter_id VARCHAR(255) NOT NULL, twitter_access_token VARCHAR(255) NOT NULL, twitter_access_token_secret VARCHAR(255) NOT NULL, twitter_access_token_expires_in BIGINT DEFAULT NULL, realname VARCHAR(255) DEFAULT NULL, screen_name VARCHAR(255) DEFAULT NULL, followers_count INT DEFAULT NULL, friends_count INT DEFAULT NULL, listed_count INT DEFAULT NULL, created_at VARCHAR(60) DEFAULT NULL, favourites_count INT DEFAULT NULL, locale VARCHAR(50) DEFAULT NULL, profile_picture VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_9911AE2BC63E6FFF (twitter_id), UNIQUE INDEX UNIQ_9911AE2B1762498C (usr), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE social_twitter ADD CONSTRAINT FK_9911AE2B1762498C FOREIGN KEY (usr) REFERENCES User (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE social_twitter');
    }
}
