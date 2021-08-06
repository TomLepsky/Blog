<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 *      TEST DATA
 * DELETE THIS MIGRATION BEFORE PROD!!
 */
final class Version202108302000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO app.locale (id, name) VALUES (1, 'en')");
        $this->addSql("INSERT INTO app.locale (id, name) VALUES (2, 'ru')");

        $this->addSql("INSERT INTO app.tag (id) VALUES (1)");
        $this->addSql("INSERT INTO app.tag (id) VALUES (2)");
        $this->addSql("INSERT INTO app.tag (id) VALUES (3)");
        $this->addSql("INSERT INTO app.tag (id) VALUES (4)");
        $this->addSql("INSERT INTO app.tag (id) VALUES (5)");

//        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, translatable_id, name) VALUES (1, 1, 1, 'tag 1')");
//        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, translatable_id, name) VALUES (2, 1, 2, 'tag 2')");
//        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, translatable_id, name) VALUES (3, 1, 3, 'tag 3')");

        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, tag_id, name) VALUES (1, 1, 1, 'tag 1')");
        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, tag_id, name) VALUES (2, 1, 2, 'tag 2')");
        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, tag_id, name) VALUES (3, 1, 3, 'tag 3')");
        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, tag_id, name) VALUES (4, 2, 3, 'tag 3')");
        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, tag_id, name) VALUES (5, 2, 4, 'tag 4')");
        $this->addSql("INSERT INTO app.tag_translation (id, locale_id, tag_id, name) VALUES (6, 2, 5, 'tag 5')");

        $this->addSql("INSERT INTO app.game (id) VALUES (1)");
        $this->addSql("INSERT INTO app.game (id) VALUES (2)");

        $this->addSql("INSERT INTO app.game_translation (id, game_id, locale_id, name) VALUES (1, 1, 1, 'game_1 en')");
        $this->addSql("INSERT INTO app.game_translation (id, game_id, locale_id, name) VALUES (2, 1, 2, 'game_1 ru')");
        $this->addSql("INSERT INTO app.game_translation (id, game_id, locale_id, name) VALUES (3, 2, 1, 'game_2 en')");

        $this->addSql("INSERT INTO app.tool (id, media_id, game_id, href) VALUES (1, null, 1, 'http://tools.com/1')");
        $this->addSql("INSERT INTO app.tool (id, media_id, game_id, href) VALUES (2, null, 2, 'http://tools.com/2')");

        $this->addSql("INSERT INTO app.tool_translation (id, locale_id, tool_id, name) VALUES (1, 1, 1, 'Tool_1 en')");
        $this->addSql("INSERT INTO app.tool_translation (id, locale_id, tool_id, name) VALUES (2, 2, 1, 'Tool_1 ru')");
        $this->addSql("INSERT INTO app.tool_translation (id, locale_id, tool_id, name) VALUES (3, 1, 2, 'Tool_2 en')");

        $this->addSql("INSERT INTO app.article (id, game_id, created_at) VALUES (1, null, '2021-08-04 13:01:08')");
        $this->addSql("INSERT INTO app.article (id, game_id, created_at) VALUES (2, null, '2021-08-04 13:02:08')");

//        $this->addSql("INSERT INTO app.article_article (article_source, article_target) VALUES (2, 1)");

        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (1, 1)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (1, 2)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (2, 2)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (2, 3)");

        $this->addSql("INSERT INTO app.article_translation (id, article_id, locale_id, header, content, seconds_for_reading, updated_at) VALUES (1, 1, 1, 'Article_1 en', 'Content en', null, null)");
        $this->addSql("INSERT INTO app.article_translation (id, article_id, locale_id, header, content, seconds_for_reading, updated_at) VALUES (2, 1, 2, 'Article_1 ru', 'Content ru', null, null)");
        $this->addSql("INSERT INTO app.article_translation (id, article_id, locale_id, header, content, seconds_for_reading, updated_at) VALUES (3, 2, 1, 'Article_2 en', 'Content en', null, null)");

//        $this->addSql("");
    }

    public function down(Schema $schema): void
    {

    }
}
