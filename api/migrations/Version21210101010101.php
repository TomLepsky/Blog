<?php

namespace DoctrineMigrations;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version21210101010101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $gamesCount = 4;
        $tagsCount = 10;
        $articlesCount = 40;
        $gameTags = [];
        $articlesGame = [];
        $date = new DateTime();

        for ($i = 1; $i <= $gamesCount; $i++) {
            $weight = rand(0, 200);
            $this->addSql(
                "INSERT INTO blogapi.game
                    (id, image_id, name, slug, weight, title, description, og_title, og_description, key_words) VALUES
                    ({$i}, null, 'game_{$i}', 'game_slug_{$i}', {$weight}, 'title_{$i}', 'description_{$i}', 'og_title_{$i}', 'og_description_{$i}', 'key_word_{$i}')"
            );
        }

        for ($i = 1; $i <= $tagsCount; $i++) {
            $gameId = rand(1, $gamesCount);
            $gameTags["{$gameId}"][] = $i;

            $this->addSql(
                "INSERT INTO blogapi.tag
                (id, game_id, name, slug, title, description, og_title, og_description, key_words) VALUES
                ({$i}, {$gameId}, 'tag_{$i}', 'tag_slug_{$i}', 'title_{$i}', 'description_{$i}', 'og_title_{$i}', 'og_description_{$i}', 'key_word_{$i}')"
            );
        }

        for ($i = 1; $i <= $articlesCount; $i++) {
            $updatedAt = $date->format(DateTimeInterface::W3C);
            $createdAt = $date->format(DateTimeInterface::W3C);
            $date = $date->modify("+1 min");
            $gameId = rand(1, $gamesCount);
            $articlesGame["{$i}"] = $gameId;

            $sentences = [
                'The rivers served as passageways for explorers and traders over the following two centuries.',
                'During the War of 1812 between Britain and the United States, the Rideau provided the British with a safe shipping route from the Ottawa River to Kingston, on Lake Ontario, thus spurring settlement of Ottawa. ',
                'Metal may also be cast in solid, hammered, carved, or incised forms. ',
                'The mobile is a construction that moves and is intended to be seen in motion. ',
                'Mobiles utilize a wide variety of materials and techniques (see also stabile). ',
                'Contemporary practice emphasizes the beauty of materials and the expression of their nature in the work. ',
                'Bronze casting is also a technique of extreme antiquity (see bronze sculpture). ',
                'The Greeks and Chinese mastered the cire perdue (lost-wax) process, which was revived in the Renaissance and widely practiced until modern times. '
            ];
            $content = '';
            $size = rand(8, 21);
            $n = count($sentences) - 1;
            for ($j = 0; $j < $size; $j++) {
                $content .= $sentences[rand(0, $n)];
            }

            $timeToRead = (int) count(explode(" ", $content)) * 0.3;
            $this->addSql(
                "INSERT INTO blogapi.article
                (id, preview_image_id, detail_image_id, game_id, popular_id, header, content, slug, time_to_read, created_at, updated_at, title, description, og_title, og_description, key_words) VALUES
                ({$i}, null, null, {$gameId}, null , 'header_{$i}', '{$content}', 'article_slug_{$i}', {$timeToRead}, '{$createdAt}', '{$updatedAt}', 'article_title_{$i}', 'article_description_{$i}', 'article_og_title_{$i}', 'article_og_description_{$i}', 'article_key_word_{$i}')"
            );

            if (rand(1, 2) === 1) {
                $this->addSql("UPDATE blogapi.article SET popular_id = {$gameId} WHERE id = {$i}");
            }
        }

        for ($i = 1; $i <= $articlesCount; $i++) {
            $gameId = $articlesGame["{$i}"];
            if (!isset($gameTags["{$gameId}"])) {
                continue;
            }
            $tags = $gameTags["{$gameId}"];
            if (empty($tags)) {
                continue;
            }

            $tagsSize = count($tags);
            $tagsNum = rand(1, $tagsSize <= 5 ? $tagsSize : 5);
            for ($j = 0; $j < $tagsNum; $j++) {
                $index = rand(0, $tagsSize - 1 -$j);
                $this->addSql(
                    "INSERT INTO blogapi.article_tag
                    (article_id, tag_id) VALUES
                    ({$i}, {$tags[$index]})"
                );
                $temp = $tags[$index];
                $tags[$index] = $tags[$tagsSize - 1 - $j];
                $tags[$tagsSize - 1 - $j] = $temp;
            }
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM table blogapi.article_tag");
        $this->addSql("DELETE FROM table blogapi.article");
        $this->addSql("DELETE FROM table blogapi.tag");
        $this->addSql("DELETE FROM table blogapi.game");
    }
}
