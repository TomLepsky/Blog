<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825120157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, preview_image_id INT DEFAULT NULL, detail_image_id INT DEFAULT NULL, game_id INT DEFAULT NULL, popular_id INT DEFAULT NULL, header VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, time_to_read INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, og_title VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, key_words VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_23A0E66FAE957CD (preview_image_id), UNIQUE INDEX UNIQ_23A0E66CB7BCCB6 (detail_image_id), INDEX IDX_23A0E66E48FD905 (game_id), INDEX IDX_23A0E6642800F07 (popular_id), INDEX article_slug_index (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_tag (article_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_919694F97294869C (article_id), INDEX IDX_919694F9BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_article (article_source INT NOT NULL, article_target INT NOT NULL, INDEX IDX_EFE84AD1354DE8F3 (article_source), INDEX IDX_EFE84AD12CA8B87C (article_target), PRIMARY KEY(article_source, article_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, weight INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, og_title VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, key_words VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_232B318C3DA5256D (image_id), INDEX game_slug_index (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, file_size INT NOT NULL, placeholder LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, articles_quantity INT DEFAULT 0, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, og_title VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, key_words VARCHAR(255) DEFAULT NULL, INDEX IDX_389B783E48FD905 (game_id), INDEX tag_slug_index (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, media_object_id INT DEFAULT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, href VARCHAR(255) DEFAULT NULL, INDEX IDX_20F33ED164DE5A5 (media_object_id), INDEX IDX_20F33ED1E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FAE957CD FOREIGN KEY (preview_image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66CB7BCCB6 FOREIGN KEY (detail_image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6642800F07 FOREIGN KEY (popular_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_article ADD CONSTRAINT FK_EFE84AD1354DE8F3 FOREIGN KEY (article_source) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_article ADD CONSTRAINT FK_EFE84AD12CA8B87C FOREIGN KEY (article_target) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED164DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F97294869C');
        $this->addSql('ALTER TABLE article_article DROP FOREIGN KEY FK_EFE84AD1354DE8F3');
        $this->addSql('ALTER TABLE article_article DROP FOREIGN KEY FK_EFE84AD12CA8B87C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66E48FD905');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6642800F07');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783E48FD905');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED1E48FD905');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FAE957CD');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66CB7BCCB6');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C3DA5256D');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED164DE5A5');
        $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F9BAD26311');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('DROP TABLE article_article');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tool');
    }
}
