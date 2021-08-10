<?php
declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20210831000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO app.game (id, name) VALUES (1, 'Game_1')");
        $this->addSql("INSERT INTO app.game (id, name) VALUES (2, 'Game_2')");
        $this->addSql("INSERT INTO app.game (id, name) VALUES (3, 'Game_3')");

        $this->addSql("INSERT INTO app.tag (id, game_id, name) VALUES (1, 1, 'Tag_1')");
        $this->addSql("INSERT INTO app.tag (id, game_id, name) VALUES (2, 3, 'Tag_2')");
        $this->addSql("INSERT INTO app.tag (id, game_id, name) VALUES (3, null, 'Tag_3')");
        $this->addSql("INSERT INTO app.tag (id, game_id, name) VALUES (4, null, 'Tag_4')");
        $this->addSql("INSERT INTO app.tag (id, game_id, name) VALUES (5, null, 'Tag_5')");

        $this->addSql("INSERT INTO app.tool (id, media_id, game_id, name, href) VALUES (1, null, 1, 'Tool_1', 'tools.com/1')");
        $this->addSql("INSERT INTO app.tool (id, media_id, game_id, name, href) VALUES (2, null, 2, 'Tool_2', 'tools.com/2')");
        $this->addSql("INSERT INTO app.tool (id, media_id, game_id, name, href) VALUES (3, null, 2, 'Tool_3', 'tools.com/3')");


        $this->addSql("INSERT INTO app.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (1, null, 'header_1', 'George Washington was born on February 11, 1731 in America. He is known in American history as the ‘Father of the Country’. For nearly 20 years he guided his country.  In three important ways, Washington helped shape the beginning of the United States. Firstly, he commanded the army that won American independence from Great Britain. Secondly. Washington served as President when the United States Constitution was written. Thirdly, he was elected as the first President of the United States.  When Washington became President there were only 11 states in the Union. By the end of his time in power, there were 16. He died in 1799 at the age of 67.', 33, '2021-08-09 19:49:15', '2021-08-09 19:52:05');");
        $this->addSql("INSERT INTO app.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (2, null, 'Header_2', 'Halloween is a festival celebrated on October 31. It began long ago in Britain, when bonfires were lit to keep spirits and ghosts away. Today it is celebrated in many countries and has become a time for parties and games.  One game is called ‘trick or treat’, when children dress up in costumes and masks as ghosts or witches. Then they go to all the houses in their street and knock on the door. When the door is opened, they ask for ‘treats’ (sweets or pocket money). If they aren’t given anything, they’ll try to scare their neighbours.  One of the traditional decorations is the jack-o-lantern. This is made from a pumpkin, which has a scary face cut into it and a lit candle inside.', 38, '2021-08-09 19:53:07', '2021-08-09 19:53:07');");
        $this->addSql("INSERT INTO app.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (3, null, 'Header_3', 'Neptune is known as the blue planet. It gets its colour because it is surrounded by methane gas. There are lots of interesting facts about Neptune.  You might think that where you live is windy, but Neptune is the windiest planet in our solar system, with winds of over 2,200 kph! For some reason, these winds always travel from east to west across the surface of the planet. It is also very cold on Neptune, with temperatures as low as 235 C.  When Voyager 2 passed Neptune, it observed four faint rings around the planet. It also discovered new moons. Neptune has eight moons — half as many as Jupiter. The largest of these moons is called Triton. This moon orbits in the opposite direction to all the other moons.', 39, '2021-08-09 19:53:56', '2021-08-09 19:55:25');");
        $this->addSql("INSERT INTO app.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (4, null, 'Header_4', 'Television has many advantages and disadvantages. First the advantages: it keeps us informed about the latest news. You don’t have to buy a newspaper to know about the current news or weather forecast. Secondly, television provides entertainment in the home; you can watch a movie that you like without going to the cinema, or you can enjoy various music channels when you come back home tired. Besides this, it helps us to know more about the world, the people that live in it, and the cultures that they represent. All of these widen people’s outlook. On the other hand, television has been blamed for the violent behaviour of some young people. The violent movies that are shown on TV affect teenagers badly. In addition, television encourages children to sit indoors, instead of taking exercise. Research shows that in the past two decades, children’s interest in reading has decreased by 45%. Some people believe that television has killed the art of conversation.  In conclusion, we can say that television has both good and bad features. One thing is sure, it has definitely brought changes to our lives.', 56, '2021-08-09 19:58:26', '2021-08-09 19:58:26');");
        $this->addSql("INSERT INTO app.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (5, null, 'Header_5', 'When you look at the sky at night you can see millions of stars, which are known as the Milky Way. Our Sun is one of the 100 billion stars in our galaxy. More than a million Earth-sized planets could fit into the Sun.  The Earth and the other planets in our solar system orbit the Sun and get light and heat from it. It takes eight minutes for light to travel from the Sun to Earth, five and a half hours for it to reach Pluto and more than four years to reach the next star, Alpha Centuria.  Each planet moves on its own orbit around the Sun. It takes the Earth one year to go around the Sun and it takes Pluto 248 Earth-years to do the same.  Mercury is the closest planet to the Sun. Venus spins the opposite way to the Earth, so the Sun rises in the west and sets in the east. The next planet is ours. It’s the only planet that we know has life — maybe there is life on another planet but we don’t know yet. Mars is like a bright red star. Jupiter is the biggest planet in our solar system and has fifteen more moons than the Earth. To reach it from the Earth you have to go through the asteroid belt that lies between Mars and Jupiter. Saturn looks beautiful with its coloured rings, but it is very cold and has lots of strong storms. The last three planets are Uranus, Neptune and Pluto. Pluto is the farthest. They are all part of our solar system.', 81, '2021-08-09 19:59:03', '2021-08-09 19:59:03');");
        $this->addSql("INSERT INTO app.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (6, null, 'header_1', 'When you look at the sky at night you can see millions of stars, which are known as the Milky Way. Our Sun is one of the 100 billion stars in our galaxy. More than a million Earth-sized planets could fit into the Sun.The Earth and the other planets in our solar system orbit the Sun and get light and heat from it. It takes eight minutes for light to travel from the Sun to Earth, five and a half hours for it to reach Pluto and more than four years to reach the next star, Alpha Centuria.Each planet moves on its own orbit around the Sun. It takes the Earth one year to go around the Sun and it takes Pluto 248 Earth-years to do the same.Mercury is the closest planet to the Sun. Venus spins the opposite way to the Earth, so the Sun rises in the west and sets in the east. The next planet is ours. It’s the only planet that we know has life — maybe there is life on another planet but we don’t know yet. Mars is like a bright red star. Jupiter is the biggest planet in our solar system and has fifteen more moons than the Earth. To reach it from the Earth you have to go through the asteroid belt that lies between Mars and Jupiter. Saturn looks beautiful with its coloured rings, but it is very cold and has lots of strong storms. The last three planets are Uranus, Neptune and Pluto. Pluto is the farthest. They are all part of our solar system.', 79, '2021-08-09 20:06:42', '2021-08-09 20:06:42');");

        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (2, 3)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (2, 4)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (3, 1)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (3, 5)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (4, 2)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (4, 3)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (5, 4)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (6, 2)");
        $this->addSql("INSERT INTO app.article_tag (article_id, tag_id) VALUES (6, 5)");

//        $this->addSql("");
    }
}
