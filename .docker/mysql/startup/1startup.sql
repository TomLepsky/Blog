# создаем базу
CREATE DATABASE IF NOT EXISTS `blogapi`;

# добавляем права руту
CREATE USER 'root'@'*' IDENTIFIED BY 'Lpt98t3333';
GRANT ALL ON *.* TO 'root'@'%';
