<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210806121917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_23A0E66E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_tag (article_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_919694F97294869C (article_id), INDEX IDX_919694F9BAD26311 (tag_id), PRIMARY KEY(article_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_article (article_source INT NOT NULL, article_target INT NOT NULL, INDEX IDX_EFE84AD1354DE8F3 (article_source), INDEX IDX_EFE84AD12CA8B87C (article_target), PRIMARY KEY(article_source, article_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_translation (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, locale_id INT NOT NULL, header VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, seconds_for_reading INT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2EEA2F087294869C (article_id), INDEX IDX_2EEA2F08E559DFD1 (locale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_translation (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, locale_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6A3C076DE48FD905 (game_id), INDEX IDX_6A3C076DE559DFD1 (locale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locale (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_library (id INT AUTO_INCREMENT NOT NULL, media LONGBLOB NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, INDEX IDX_389B783E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_translation (id INT AUTO_INCREMENT NOT NULL, locale_id INT NOT NULL, tag_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_A8A03F8FE559DFD1 (locale_id), INDEX IDX_A8A03F8FBAD26311 (tag_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool (id INT AUTO_INCREMENT NOT NULL, media_id INT DEFAULT NULL, game_id INT DEFAULT NULL, href VARCHAR(255) DEFAULT NULL, INDEX IDX_20F33ED1EA9FDD75 (media_id), INDEX IDX_20F33ED1E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tool_translation (id INT AUTO_INCREMENT NOT NULL, locale_id INT NOT NULL, tool_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_2E5B5B31E559DFD1 (locale_id), INDEX IDX_2E5B5B318F7B22CC (tool_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F97294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_tag ADD CONSTRAINT FK_919694F9BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_article ADD CONSTRAINT FK_EFE84AD1354DE8F3 FOREIGN KEY (article_source) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_article ADD CONSTRAINT FK_EFE84AD12CA8B87C FOREIGN KEY (article_target) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_translation ADD CONSTRAINT FK_2EEA2F087294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE article_translation ADD CONSTRAINT FK_2EEA2F08E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id)');
        $this->addSql('ALTER TABLE game_translation ADD CONSTRAINT FK_6A3C076DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE game_translation ADD CONSTRAINT FK_6A3C076DE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id)');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT FK_389B783E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE tag_translation ADD CONSTRAINT FK_A8A03F8FE559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id)');
        $this->addSql('ALTER TABLE tag_translation ADD CONSTRAINT FK_A8A03F8FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED1EA9FDD75 FOREIGN KEY (media_id) REFERENCES media_library (id)');
        $this->addSql('ALTER TABLE tool ADD CONSTRAINT FK_20F33ED1E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE tool_translation ADD CONSTRAINT FK_2E5B5B31E559DFD1 FOREIGN KEY (locale_id) REFERENCES locale (id)');
        $this->addSql('ALTER TABLE tool_translation ADD CONSTRAINT FK_2E5B5B318F7B22CC FOREIGN KEY (tool_id) REFERENCES tool (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F97294869C');
        $this->addSql('ALTER TABLE article_article DROP FOREIGN KEY FK_EFE84AD1354DE8F3');
        $this->addSql('ALTER TABLE article_article DROP FOREIGN KEY FK_EFE84AD12CA8B87C');
        $this->addSql('ALTER TABLE article_translation DROP FOREIGN KEY FK_2EEA2F087294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66E48FD905');
        $this->addSql('ALTER TABLE game_translation DROP FOREIGN KEY FK_6A3C076DE48FD905');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY FK_389B783E48FD905');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED1E48FD905');
        $this->addSql('ALTER TABLE article_translation DROP FOREIGN KEY FK_2EEA2F08E559DFD1');
        $this->addSql('ALTER TABLE game_translation DROP FOREIGN KEY FK_6A3C076DE559DFD1');
        $this->addSql('ALTER TABLE tag_translation DROP FOREIGN KEY FK_A8A03F8FE559DFD1');
        $this->addSql('ALTER TABLE tool_translation DROP FOREIGN KEY FK_2E5B5B31E559DFD1');
        $this->addSql('ALTER TABLE tool DROP FOREIGN KEY FK_20F33ED1EA9FDD75');
        $this->addSql('ALTER TABLE article_tag DROP FOREIGN KEY FK_919694F9BAD26311');
        $this->addSql('ALTER TABLE tag_translation DROP FOREIGN KEY FK_A8A03F8FBAD26311');
        $this->addSql('ALTER TABLE tool_translation DROP FOREIGN KEY FK_2E5B5B318F7B22CC');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_tag');
        $this->addSql('DROP TABLE article_article');
        $this->addSql('DROP TABLE article_translation');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_translation');
        $this->addSql('DROP TABLE locale');
        $this->addSql('DROP TABLE media_library');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_translation');
        $this->addSql('DROP TABLE tool');
        $this->addSql('DROP TABLE tool_translation');
    }
}
