SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`
(
    `id`      int(11)      NOT NULL AUTO_INCREMENT,
    `role` text NOT NULL UNIQUE,
    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students`
(
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` text NOT NULL,
    `surname` text NOT NULL,

    PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `login` text NOT NULL UNIQUE,
    `password` text NOT NULL,
    `roles_id` int(11) NOT NULL,
    `teacher_id` int(11) UNIQUE,
    PRIMARY KEY (`id`)
) ;

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
    `id` int(11) NOT NULL UNIQUE AUTO_INCREMENT,
    `teacher_id` int(11) NOT NULL,
    `student_id` int(11) NOT NULL,
    `language` char(3) NOT NULL,
    `start` date NOT NULL,
    `end` date
) ;

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` text NOT NULL,
    `surname` text NOT NULL,
    `language` char(3) NOT NULL,
    PRIMARY KEY (`id`)
) ;

ALTER TABLE users ADD CONSTRAINT user_teacher FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE;
ALTER TABLE users ADD CONSTRAINT user_role FOREIGN KEY (roles_id) REFERENCES roles (id) ON DELETE CASCADE;
ALTER TABLE schedules ADD CONSTRAINT FK_teacher FOREIGN KEY (teacher_id) REFERENCES teachers (id) ON DELETE CASCADE;
ALTER TABLE schedules ADD CONSTRAINT FK_student FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE CASCADE;



INSERT INTO `students` (`id`, `name`, `surname`) VALUES
    (1, 'Martin', 'Martin'),
    (2, 'Richard', 'Richard'),
    (3, 'Clarence', 'Second');

INSERT INTO `roles` (`id`, `role`) VALUES
    (1,	'admin'),
    (2, 'teacher');

INSERT INTO `teachers` (`id`, `name`, `surname`, `language`) VALUES
    (1,	'John',	'Doe', 'ANJ'),
    (2, 'Jane', 'Doe', 'NEJ');


INSERT INTO `users` (`id`, `login`, `password`, `roles_id`, `teacher_id`) VALUES
    (1,	'admin',	'$2y$10$WLHfLCcaWz2rrOtIjGn0zej1smOeEfLy8Ater1Dp38s.2SGWYSu3K',	1,	NULL), /*password adminn*/
    (2,	'login',	'$2y$10$7mIPCean.9ap5zpHxWi16OtxYcVGFKqxUx1fbqqFe4gNIwIVtPI.u',	2,	1), /*password 123456*/
    (3,	'lmao',	'$2y$10$0l1QcazPbVHj6W8eL4vutuacX7OsLMsGDvI23LKcnMZAIqdry8zk.',	2,	2); /*password asdfgh*/

INSERT INTO `schedules` (`id`, `teacher_id`, `student_id`, `language`, `start`, `end`) VALUES
    (1, 1,	1, 'ANJ', '2024-6-11', NULL),
    (2, 1,	2, 'ANJ', '2024-6-18', NULL),
    (3, 2,	3, 'NEJ', '2024-3-12', '2024-8-12');