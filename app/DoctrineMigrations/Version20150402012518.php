<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150402012518 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Image (id INT AUTO_INCREMENT NOT NULL, usr INT DEFAULT NULL, real_uri VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, width BIGINT DEFAULT NULL, height BIGINT DEFAULT NULL, size BIGINT DEFAULT NULL, type VARCHAR(50) DEFAULT NULL, extension VARCHAR(50) DEFAULT NULL, INDEX IDX_4FC2B5B1762498C (usr), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, profile_picture INT DEFAULT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, username_change TINYINT(1) NOT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, twitter_id VARCHAR(255) DEFAULT NULL, videona_register TINYINT(1) NOT NULL, deleted_account DATETIME DEFAULT NULL, temp_disable_account TINYINT(1) NOT NULL, birthdate DATETIME DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, gender VARCHAR(50) DEFAULT NULL, locale VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_2DA1797792FC23A8 (username_canonical), UNIQUE INDEX UNIQ_2DA17977A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_2DA179779BE8FD98 (facebook_id), UNIQUE INDEX UNIQ_2DA1797776F5C865 (google_id), UNIQUE INDEX UNIQ_2DA17977C63E6FFF (twitter_id), UNIQUE INDEX UNIQ_2DA17977C5659115 (profile_picture), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_videos (user_id INT NOT NULL, video_id INT NOT NULL, INDEX IDX_264DEAA2A76ED395 (user_id), INDEX IDX_264DEAA229C1004E (video_id), PRIMARY KEY(user_id, video_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Video (id INT AUTO_INCREMENT NOT NULL, usr INT DEFAULT NULL, key_frame INT DEFAULT NULL, real_uri VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, title VARCHAR(100) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, size BIGINT DEFAULT NULL, duration BIGINT DEFAULT NULL, avg NUMERIC(10, 0) DEFAULT NULL, views BIGINT DEFAULT NULL, likes BIGINT DEFAULT NULL, resolution VARCHAR(255) DEFAULT NULL, metadata LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_BD06F5281762498C (usr), UNIQUE INDEX UNIQ_BD06F52857C64102 (key_frame), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Image ADD CONSTRAINT FK_4FC2B5B1762498C FOREIGN KEY (usr) REFERENCES User (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977C5659115 FOREIGN KEY (profile_picture) REFERENCES Image (id)');
        $this->addSql('ALTER TABLE users_videos ADD CONSTRAINT FK_264DEAA2A76ED395 FOREIGN KEY (user_id) REFERENCES User (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_videos ADD CONSTRAINT FK_264DEAA229C1004E FOREIGN KEY (video_id) REFERENCES Video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Video ADD CONSTRAINT FK_BD06F5281762498C FOREIGN KEY (usr) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Video ADD CONSTRAINT FK_BD06F52857C64102 FOREIGN KEY (key_frame) REFERENCES Image (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977C5659115');
        $this->addSql('ALTER TABLE Video DROP FOREIGN KEY FK_BD06F52857C64102');
        $this->addSql('ALTER TABLE Image DROP FOREIGN KEY FK_4FC2B5B1762498C');
        $this->addSql('ALTER TABLE users_videos DROP FOREIGN KEY FK_264DEAA2A76ED395');
        $this->addSql('ALTER TABLE Video DROP FOREIGN KEY FK_BD06F5281762498C');
        $this->addSql('ALTER TABLE users_videos DROP FOREIGN KEY FK_264DEAA229C1004E');
        $this->addSql('DROP TABLE Image');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE users_videos');
        $this->addSql('DROP TABLE Video');
    }
}
