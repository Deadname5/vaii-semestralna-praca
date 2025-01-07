SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`
(
    `id`      int(11)      NOT NULL AUTO_INCREMENT,
    `jazyk`   char(3) NOT NULL,
    `zaciatok` date NOT NULL,
    `koniec` date,

    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
     `id` int(11) NOT NULL AUTO_INCREMENT,
     `login` text NOT NULL,
     `password` text NOT NULL,
     PRIMARY KEY (`id`)
) ;

INSERT INTO `students` (`id`, `jazyk`, `zaciatok`, `koniec`) VALUES
    (1, 'ANJ', '2024-6-11', NULL),
    (2, 'SPJ', '2024-6-18', NULL),
    (3, 'SPJ', '2024-3-12', '2024-8-12');

INSERT INTO `users` (`id`, `login`, `password`) VALUES
    (1,	'login',	'123456');