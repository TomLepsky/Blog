<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20210823170000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO blogapi.game (id, name) VALUES (1, 'game_1')");
        $this->addSql("INSERT INTO blogapi.game (id, name) VALUES (2, 'game_2')");
        $this->addSql("INSERT INTO blogapi.game (id, name) VALUES (3, 'game_3')");
        $this->addSql("INSERT INTO blogapi.game (id, name) VALUES (4, 'game_4')");
        $this->addSql("INSERT INTO blogapi.game (id, name) VALUES (5, 'game_5')");
        $this->addSql("INSERT INTO blogapi.game (id, name) VALUES (6, 'game_6')");

        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (1, 1, 'tag_1')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (2, 6, 'tag_2')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (3, 2, 'tag_3')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (4, 2, 'tag_4')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (5, 4, 'tag_5')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (6, 3, 'tag_6')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (7, 1, 'tag_7')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (8, 1, 'tag_8')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (9, 5, 'tag_9')");
        $this->addSql("INSERT INTO blogapi.tag (id, game_id, name) VALUES (10, 1, 'tag_10')");

        $this->addSql("INSERT INTO blogapi.tool (id, media_object_id, game_id, name, href) VALUES (1, null, 1, 'tool_1', 'tools.com/1')");
        $this->addSql("INSERT INTO blogapi.tool (id, media_object_id, game_id, name, href) VALUES (2, null, 3, 'tool_2', 'tools.com/2')");
        $this->addSql("INSERT INTO blogapi.tool (id, media_object_id, game_id, name, href) VALUES (3, null, 5, 'tool_3', 'tools.com/3')");
        $this->addSql("INSERT INTO blogapi.tool (id, media_object_id, game_id, name, href) VALUES (4, null, 2, 'tool_4', 'tools.com/4')");
        $this->addSql("INSERT INTO blogapi.tool (id, media_object_id, game_id, name, href) VALUES (5, null, 2, 'tool_5', 'tools.com/5')");

        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (1, 1, 'header_1', 'Avatar premiered in London on December 10, 2009, and was internationally released on December 16 and in the United States and Canada on December 18, to critical acclaim and commercial success. The film broke several box office records during its release and became the highest-grossing film of all time in the U.S. and Canada and also worldwide, surpassing Titanic, which had held the records for the previous 12 years. It also became the first film to gross more than $2 billion. Avatar was nominated for nine Academy Awards, including Best Picture and Best Director, and won three, for Best Cinematography, Best Visual Effects, and Best Art Direction. The film''s home release went on to break opening sales records and became the top-selling Blu-ray of all time. Following the film''s success, Cameron signed with 20th Century Fox to produce two sequels, making Avatar the first of a planned trilogy', 79, '2021-08-20 08:04:49', '2021-08-20 08:04:49')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (2, 3, 'header_2', 'Avatar premiered in London on December 10, 2009, and was internationally released on December 16 and in the United States and Canada on December 18, to critical acclaim and commercial success. The film broke several box office records during its release and became the highest-grossing film of all time in the U.S. and Canada and also worldwide, surpassing Titanic, which had held the records for the previous 12 years. It also became the first film to gross more than $2 billion. Avatar was nominated for nine Academy Awards, including Best Picture and Best Director, and won three, for Best Cinematography, Best Visual Effects, and Best Art Direction. The film''s home release went on to break opening sales records and became the top-selling Blu-ray of all time. Following the film''s success, Cameron signed with 20th Century Fox to produce two sequels, making Avatar the first of a planned trilogy', 0, '2021-08-23 13:38:23', '2021-08-23 13:38:23')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (3, 2, 'header_3', 'Avatar premiered in London on December 10, 2009, and was internationally released on December 16 and in the United States and Canada on December 18, to critical acclaim and commercial success. The film broke several box office records during its release and became the highest-grossing film of all time in the U.S. and Canada and also worldwide, surpassing Titanic, which had held the records for the previous 12 years. It also became the first film to gross more than $2 billion. Avatar was nominated for nine Academy Awards, including Best Picture and Best Director, and won three, for Best Cinematography, Best Visual Effects, and Best Art Direction. The film''s home release went on to break opening sales records and became the top-selling Blu-ray of all time. Following the film''s success, Cameron signed with 20th Century Fox to produce two sequels, making Avatar the first of a planned trilogy', 44, '2021-08-23 13:39:44', '2021-08-23 13:39:44')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (4, 2, 'header_4', 'Avatar premiered in London on December 10, 2009, and was internationally released on December 16 and in the United States and Canada on December 18, to critical acclaim and commercial success. The film broke several box office records during its release and became the highest-grossing film of all time in the U.S. and Canada and also worldwide, surpassing Titanic, which had held the records for the previous 12 years. It also became the first film to gross more than $2 billion. Avatar was nominated for nine Academy Awards, including Best Picture and Best Director, and won three, for Best Cinematography, Best Visual Effects, and Best Art Direction. The film''s home release went on to break opening sales records and became the top-selling Blu-ray of all time. Following the film''s success, Cameron signed with 20th Century Fox to produce two sequels, making Avatar the first of a planned trilogy', 44, '2021-08-23 13:40:45', '2021-08-23 13:40:45')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (5, 2, 'header_5', 'Ottawa might still be a modest city had not political quarrels between Quebec city and Toronto and between Montreal and Kingston induced leaders to call upon Queen Victoria to designate a capital for United Canada. In 1855 Bytown was incorporated and rechristened Ottawa after the Indian tribe. It became the fastest growing metropolis in eastern Canada, a development due largely to the presence of the national government. In 1937 Prime Minister William L. Mackenzie King brought the architect Jacques Grйber from France to begin the redevelopment of the national capital district.', 27, '2021-08-23 13:41:22', '2021-08-23 13:41:22')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (6, 1, 'header_6', 'Ottawa might still be a modest city had not political quarrels between Quebec city and Toronto and between Montreal and Kingston induced leaders to call upon Queen Victoria to designate a capital for United Canada. In 1855 Bytown was incorporated and rechristened Ottawa after the Indian tribe. It became the fastest growing metropolis in eastern Canada, a development due largely to the presence of the national government. In 1937 Prime Minister William L. Mackenzie King brought the architect Jacques Grйber from France to begin the redevelopment of the national capital district.Ottawa might still be a modest city had not political quarrels between Quebec city and Toronto and between Montreal and Kingston induced leaders to call upon Queen Victoria to designate a capital for United Canada. In 1855 Bytown was incorporated and rechristened Ottawa after the Indian tribe. It became the fastest growing metropolis in eastern Canada, a development due largely to the presence of the national government. In 1937 Prime Minister William L. Mackenzie King brought the architect Jacques Grйber from France to begin the redevelopment of the national capital district.Ottawa might still be a modest city had not political quarrels between Quebec city and Toronto and between Montreal and Kingston induced leaders to call upon Queen Victoria to designate a capital for United Canada. In 1855 Bytown was incorporated and rechristened Ottawa after the Indian tribe. It became the fastest growing metropolis in eastern Canada, a development due largely to the presence of the national government. In 1937 Prime Minister William L. Mackenzie King brought the architect Jacques Grйber from France to begin the redevelopment of the national capital district.', 81, '2021-08-23 13:41:41', '2021-08-23 13:41:41')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (7, 5, 'header_7', 'The first descriptions of Ottawa''s future site were written by the founder of New France, Samuel de Champlain, in 1613. The rivers served as passageways for explorers and traders over the following two centuries. The Napoleonic Wars increased Britain''s need for shipbuilding timber, and the Ottawa Valley offered just such resources. In 1800 an American, Philemon Wright, had begun timbering across the Ottawa River in what became the city of Hull. During the War of 1812 between Britain and the United States, the Rideau provided the British with a safe shipping route from the Ottawa River to Kingston, on Lake Ontario, thus spurring settlement of Ottawa. It was hastened by the arrival in 1826 of Lt. Col. John By of the Royal Engineers to work on canalizing the river, and the town became Bytown.', 40, '2021-08-23 13:42:11', '2021-08-23 13:42:11')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (8, 4, 'header_8', 'The first descriptions of Ottawa''s future site were written by the founder of New France, Samuel de Champlain, in 1613. The rivers served as passageways for explorers and traders over the following two centuries. The Napoleonic Wars increased Britain''s need for shipbuilding timber, and the Ottawa Valley offered just such resources. In 1800 an American, Philemon Wright, had begun timbering across the Ottawa River in what became the city of Hull. During the War of 1812 between Britain and the United States, the Rideau provided the British with a safe shipping route from the Ottawa River to Kingston, on Lake Ontario, thus spurring settlement of Ottawa. It was hastened by the arrival in 1826 of Lt. Col. John By of the Royal Engineers to work on canalizing the river, and the town became Bytown.The first descriptions of Ottawa''s future site were written by the founder of New France, Samuel de Champlain, in 1613. The rivers served as passageways for explorers and traders over the following two centuries. The Napoleonic Wars increased Britain''s need for shipbuilding timber, and the Ottawa Valley offered just such resources. In 1800 an American, Philemon Wright, had begun timbering across the Ottawa River in what became the city of Hull. During the War of 1812 between Britain and the United States, the Rideau provided the British with a safe shipping route from the Ottawa River to Kingston, on Lake Ontario, thus spurring settlement of Ottawa. It was hastened by the arrival in 1826 of Lt. Col. John By of the Royal Engineers to work on canalizing the river, and the town became Bytown.', 80, '2021-08-23 13:42:23', '2021-08-23 13:42:23')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (9, 4, 'header_9', 'Bronze casting is also a technique of extreme antiquity (see bronze sculpture). The Greeks and Chinese mastered the cire perdue (lost-wax) process, which was revived in the Renaissance and widely practiced until modern times. Little Greek sculpture in bronze has survived, apparently because the metal was later melted down for other purposes, but the material itself resists exposure better than stone and was preferred by the Greeks for their extensive art of public sculpture. Metal may also be cast in solid, hammered, carved, or incised forms. The mobile is a construction that moves and is intended to be seen in motion. Mobiles utilize a wide variety of materials and techniques (see also stabile). Contemporary practice emphasizes the beauty of materials and the expression of their nature in the work.', 38, '2021-08-23 13:43:21', '2021-08-23 13:43:21')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (10, 5, 'header_10', 'Bronze casting is also a technique of extreme antiquity (see bronze sculpture). The Greeks and Chinese mastered the cire perdue (lost-wax) process, which was revived in the Renaissance and widely practiced until modern times. Little Greek sculpture in bronze has survived, apparently because the metal was later melted down for other purposes, but the material itself resists exposure better than stone and was preferred by the Greeks for their extensive art of public sculpture. Metal may also be cast in solid, hammered, carved, or incised forms. The mobile is a construction that moves and is intended to be seen in motion. Mobiles utilize a wide variety of materials and techniques (see also stabile). Contemporary practice emphasizes the beauty of materials and the expression of their nature in the work.Bronze casting is also a technique of extreme antiquity (see bronze sculpture). The Greeks and Chinese mastered the cire perdue (lost-wax) process, which was revived in the Renaissance and widely practiced until modern times. Little Greek sculpture in bronze has survived, apparently because the metal was later melted down for other purposes, but the material itself resists exposure better than stone and was preferred by the Greeks for their extensive art of public sculpture. Metal may also be cast in solid, hammered, carved, or incised forms. The mobile is a construction that moves and is intended to be seen in motion. Mobiles utilize a wide variety of materials and techniques (see also stabile). Contemporary practice emphasizes the beauty of materials and the expression of their nature in the work.', 77, '2021-08-23 13:43:35', '2021-08-23 13:43:35')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (11, 3, 'header_11', 'Bronze casting is also a technique of extreme antiquity (see bronze sculpture). The Greeks and Chinese mastered the cire perdue (lost-wax) process, which was revived in the Renaissance and widely practiced until modern times. Little Greek sculpture in bronze has survived, apparently because the metal was later melted down for other purposes, but the material itself resists exposure better than stone and was preferred by the Greeks for their extensive art of public sculpture. Metal may also be cast in solid, hammered, carved, or incised forms. The mobile is a construction that moves and is intended to be seen in motion. Mobiles utilize a wide variety of materials and techniques (see also stabile). Contemporary practice emphasizes the beauty of materials and the expression of their nature in the work.Bronze casting is also a technique of extreme antiquity (see bronze sculpture). The Greeks and Chinese mastered the cire perdue (lost-wax) process, which was revived in the Renaissance and widely practiced until modern times. Little Greek sculpture in bronze has survived, apparently because the metal was later melted down for other purposes, but the material itself resists exposure better than stone and was preferred by the Greeks for their extensive art of public sculpture. Metal may also be cast in solid, hammered, carved, or incised forms. The mobile is a construction that moves and is intended to be seen in motion. Mobiles utilize a wide variety of materials and techniques (see also stabile). Contemporary practice emphasizes the beauty of materials and the expression of their nature in the work.', 77, '2021-08-23 13:43:47', '2021-08-23 13:43:47')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (12, 6, 'header_12', 'The freestanding and relief sculpture of the ancient Greeks developed from the rigidity of archaic forms. It became, during the classical and Hellenistic eras, the representation of the intellectual idealization of its principal subject, the human form. The concept was so magnificently realized by means of naturalistic handling as to become the inspiration for centuries of European art. Roman sculpture borrowed and copied wholesale from the Greek in style and techniques, but it made an important original contribution in its extensive art of portraiture, forsaking the Greek ideal by particularizing the individual (see Greek art; Etruscan art; Roman art).', 29, '2021-08-23 13:44:09', '2021-08-23 13:44:09')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (13, 3, 'header_12', 'The freestanding and relief sculpture of the ancient Greeks developed from the rigidity of archaic forms. It became, during the classical and Hellenistic eras, the representation of the intellectual idealization of its principal subject, the human form. The concept was so magnificently realized by means of naturalistic handling as to become the inspiration for centuries of European art. Roman sculpture borrowed and copied wholesale from the Greek in style and techniques, but it made an important original contribution in its extensive art of portraiture, forsaking the Greek ideal by particularizing the individual (see Greek art; Etruscan art; Roman art).The freestanding and relief sculpture of the ancient Greeks developed from the rigidity of archaic forms. It became, during the classical and Hellenistic eras, the representation of the intellectual idealization of its principal subject, the human form. The concept was so magnificently realized by means of naturalistic handling as to become the inspiration for centuries of European art. Roman sculpture borrowed and copied wholesale from the Greek in style and techniques, but it made an important original contribution in its extensive art of portraiture, forsaking the Greek ideal by particularizing the individual (see Greek art; Etruscan art; Roman art).', 59, '2021-08-23 13:44:25', '2021-08-23 13:44:25')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (14, 1, 'header_14', 'In Europe the great religious architectural sculptures of the Romanesque and Gothic periods form integral parts of the church buildings, and often a single cathedral incorporates thousands of figural and narrative carvings. Outstanding among the Romanesque sculptural programs of the cathedrals and churches of Europe are those at Vezelay, Moissac, and Autun (France); Hildesheim (Germany); and Santiago de Compostela (Spain). Remarkable sculptures of the Gothic era are to be found at Chartres and Reims (France); Bamberg and Cologne (Germany). Most of this art is anonymous, but as early as the 13th cent. the individual sculptor gained prominence in Italy with Nicola and Giovanni Pisano .', 31, '2021-08-23 13:44:54', '2021-08-23 13:44:54')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (15, 6, 'header_15', 'In Europe the great religious architectural sculptures of the Romanesque and Gothic periods form integral parts of the church buildings, and often a single cathedral incorporates thousands of figural and narrative carvings. Outstanding among the Romanesque sculptural programs of the cathedrals and churches of Europe are those at Vezelay, Moissac, and Autun (France); Hildesheim (Germany); and Santiago de Compostela (Spain). Remarkable sculptures of the Gothic era are to be found at Chartres and Reims (France); Bamberg and Cologne (Germany). Most of this art is anonymous, but as early as the 13th cent. the individual sculptor gained prominence in Italy with Nicola and Giovanni Pisano .In Europe the great religious architectural sculptures of the Romanesque and Gothic periods form integral parts of the church buildings, and often a single cathedral incorporates thousands of figural and narrative carvings. Outstanding among the Romanesque sculptural programs of the cathedrals and churches of Europe are those at Vezelay, Moissac, and Autun (France); Hildesheim (Germany); and Santiago de Compostela (Spain). Remarkable sculptures of the Gothic era are to be found at Chartres and Reims (France); Bamberg and Cologne (Germany). Most of this art is anonymous, but as early as the 13th cent. the individual sculptor gained prominence in Italy with Nicola and Giovanni Pisano .', 62, '2021-08-23 13:45:06', '2021-08-23 13:45:06')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (16, 5, 'header_16', 'Among the gifted 20th-century sculptors who have explored different and highly original applications of the art are sculptors working internationally, including Pablo Picasso, Constantin Brancusi, Jacques Lipschitz, Naum Gabo, Antoine Pevsner, Ossip Zadkine, Alberto Giacometti, and Ivan Mestrovic. Important contributions have also been made by the sculptors Jacob Epstein, Henry Moore, and Barbara Hepworth (English); Aristide Maillol, Charles Despiau, and Jean Arp (French); Ernst Barlach, Wilhelm Lehmbruck, and Georg Kolbe (German); Julio Gonzalez (Spanish); Giacomo Manzu and Marino Marini (Italian); and Alexander Calder, William Zorach, David Smith, Richard Lippold, Eva Hesse, and Louise Nevelson (American)..', 28, '2021-08-23 13:45:31', '2021-08-23 13:45:31')");
        $this->addSql("INSERT INTO blogapi.article (id, game_id, header, content, seconds_for_reading, created_at, updated_at) VALUES (17, 3, 'header_17', 'Among the gifted 20th-century sculptors who have explored different and highly original applications of the art are sculptors working internationally, including Pablo Picasso, Constantin Brancusi, Jacques Lipschitz, Naum Gabo, Antoine Pevsner, Ossip Zadkine, Alberto Giacometti, and Ivan Mestrovic. Important contributions have also been made by the sculptors Jacob Epstein, Henry Moore, and Barbara Hepworth (English); Aristide Maillol, Charles Despiau, and Jean Arp (French); Ernst Barlach, Wilhelm Lehmbruck, and Georg Kolbe (German); Julio Gonzalez (Spanish); Giacomo Manzu and Marino Marini (Italian); and Alexander Calder, William Zorach, David Smith, Richard Lippold, Eva Hesse, and Louise Nevelson (American).Among the gifted 20th-century sculptors who have explored different and highly original applications of the art are sculptors working internationally, including Pablo Picasso, Constantin Brancusi, Jacques Lipschitz, Naum Gabo, Antoine Pevsner, Ossip Zadkine, Alberto Giacometti, and Ivan Mestrovic. Important contributions have also been made by the sculptors Jacob Epstein, Henry Moore, and Barbara Hepworth (English); Aristide Maillol, Charles Despiau, and Jean Arp (French); Ernst Barlach, Wilhelm Lehmbruck, and Georg Kolbe (German); Julio Gonzalez (Spanish); Giacomo Manzu and Marino Marini (Italian); and Alexander Calder, William Zorach, David Smith, Richard Lippold, Eva Hesse, and Louise Nevelson (American)..', 56, '2021-08-23 13:45:50', '2021-08-23 13:45:50')");

        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (2, 1)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (2, 2)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (3, 2)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (3, 5)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (4, 2)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (4, 6)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (5, 7)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (6, 10)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (7, 9)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (8, 3)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (9, 4)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (10, 5)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (11, 2)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (12, 6)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (13, 3)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (13, 6)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (13, 8)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (14, 1)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (14, 7)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (15, 1)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (15, 2)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (16, 10)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (17, 3)");
        $this->addSql("INSERT INTO blogapi.article_tag (article_id, tag_id) VALUES (17, 9)");

        $this->addSql("INSERT INTO blogapi.article_article (article_source, article_target) VALUES (1, 2)");
        $this->addSql("INSERT INTO blogapi.article_article (article_source, article_target) VALUES (2, 4)");
        $this->addSql("INSERT INTO blogapi.article_article (article_source, article_target) VALUES (5, 10)");
        $this->addSql("INSERT INTO blogapi.article_article (article_source, article_target) VALUES (11, 13)");
    }
}