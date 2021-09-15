<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210915085207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, preview_image_id INT DEFAULT NULL, detail_image_id INT DEFAULT NULL, game_id INT DEFAULT NULL, popular_id INT DEFAULT NULL, header VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, og_title VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, key_words VARCHAR(255) DEFAULT NULL, time_to_read INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_23A0E66FAE957CD (preview_image_id), UNIQUE INDEX UNIQ_23A0E66CB7BCCB6 (detail_image_id), INDEX IDX_23A0E66E48FD905 (game_id), INDEX IDX_23A0E6674B286E (popular_id), INDEX article_slug_index (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_tag (article_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_919694F97294869C (article_id), INDEX IDX_919694F9BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_article (article_source INT NOT NULL, article_target INT NOT NULL, INDEX IDX_EFE84AD1354DE8F3 (article_source), INDEX IDX_EFE84AD12CA8B87C (article_target), PRIMARY KEY(article_source, article_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entity_permission (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, can_read TINYINT(1) NOT NULL, can_create TINYINT(1) NOT NULL, can_edit TINYINT(1) NOT NULL, can_delete TINYINT(1) NOT NULL, INDEX IDX_D2E780FCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, weight INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, og_title VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, key_words VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_232B318C3DA5256D (image_id), INDEX game_slug_index (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_permission (id INT AUTO_INCREMENT NOT NULL, entity_id INT DEFAULT NULL, user_id INT DEFAULT NULL, can_read TINYINT(1) NOT NULL, can_create TINYINT(1) NOT NULL, can_edit TINYINT(1) NOT NULL, can_delete TINYINT(1) NOT NULL, INDEX IDX_E95554781257D5D (entity_id), INDEX IDX_E955547A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, placeholder LONGTEXT DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, articles_quantity VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, og_title VARCHAR(255) DEFAULT NULL, og_description VARCHAR(255) DEFAULT NULL, key_words VARCHAR(255) DEFAULT NULL, INDEX IDX_389B783E48FD905 (game_id), INDEX tag_slug_index (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, media_object_id INT DEFAULT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, href VARCHAR(255) DEFAULT NULL, INDEX IDX_20F33ED164DE5A5 (media_object_id), INDEX IDX_20F33ED1E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649AA08CB10 (login), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66FAE957CD FOREIGN KEY (preview_image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66CB7BCCB6 FOREIGN KEY (detail_image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6674B286E FOREIGN KEY (popular_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_article ADD CONSTRAINT FK_EFE84AD1354DE8F3 FOREIGN KEY (article_source) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_article ADD CONSTRAINT FK_EFE84AD12CA8B87C FOREIGN KEY (article_target) REFERENCES article (id)');
        $this->addSql('ALTER TABLE entity_permission ADD CONSTRAINT FK_D2E780FCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C3DA5256D FOREIGN KEY (image_id) REFERENCES media_object (id)');
        $this->addSql('ALTER TABLE game_permission ADD CONSTRAINT FK_E95554781257D5D FOREIGN KEY (entity_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_permission ADD CONSTRAINT FK_E955547A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
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
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6674B286E');
        $this->addSql('ALTER TABLE game_permission DROP FOREIGN KEY FK_E95554781257D5D');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783E48FD905');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED1E48FD905');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66FAE957CD');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66CB7BCCB6');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C3DA5256D');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED164DE5A5');
        $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F9BAD26311');
        $this->addSql('ALTER TABLE entity_permission DROP FOREIGN KEY FK_D2E780FCA76ED395');
        $this->addSql('ALTER TABLE game_permission DROP FOREIGN KEY FK_E955547A76ED395');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('DROP TABLE article_article');
        $this->addSql('DROP TABLE entity_permission');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_permission');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tool');
        $this->addSql('DROP TABLE user');
    }
}
