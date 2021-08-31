<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210831104126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("DROP PROCEDURE IF EXISTS calculation_articles_quantity_per_tag;");

        $this->addSql("
            CREATE PROCEDURE calculation_articles_quantity_per_tag(IN tag_id INT)
            MODIFIES SQL DATA
                BEGIN
                    UPDATE blogapi.tag
                    SET tag.articles_quantity = (
                        SELECT COUNT(at.article_id) AS article_quantity
                        FROM blogapi.article_tag at
                        WHERE at.tag_id = tag_id
                        GROUP BY at.tag_id
                    )
                    WHERE tag.id = tag_id;
                END;
        ");

        $this->addSql("DROP TRIGGER IF EXISTS calculation_article_after_insert;");

        $this->addSql("
            CREATE TRIGGER calculation_article_after_insert
            AFTER INSERT
            ON blogapi.article_tag FOR EACH ROW
                BEGIN
                    CALL calculation_articles_quantity_per_tag(NEW.tag_id);
                END;
        ");

        $this->addSql("DROP TRIGGER IF EXISTS calculation_article_after_delete;");

        $this->addSql("
            CREATE TRIGGER calculation_article_after_delete
                AFTER DELETE
                ON blogapi.article_tag FOR EACH ROW
            BEGIN
                CALL calculation_articles_quantity_per_tag(OLD.tag_id);
            END;
        ");

        $this->addSql("DROP TRIGGER IF EXISTS calculation_article_after_update;");

        $this->addSql("
            CREATE TRIGGER calculation_article_after_update
                AFTER UPDATE
                ON blogapi.article_tag FOR EACH ROW
            BEGIN
                CALL calculation_articles_quantity_per_tag(OLD.tag_id);
                CALL calculation_articles_quantity_per_tag(NEW.tag_id);
            END;
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP PROCEDURE IF EXISTS calculation_articles_quantity_per_tag;");
        $this->addSql("DROP TRIGGER IF EXISTS calculation_article_after_insert;");
        $this->addSql("DROP TRIGGER IF EXISTS calculation_article_after_delete;");
        $this->addSql("DROP TRIGGER IF EXISTS calculation_article_after_update;");
    }
}
