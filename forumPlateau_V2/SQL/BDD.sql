-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour forum
CREATE DATABASE IF NOT EXISTS `forum` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `forum`;

-- Listage de la structure de table forum. category
CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `picture` varchar(255) NOT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.category : ~9 rows (environ)
INSERT INTO `category` (`id_category`, `name`, `picture`) VALUES
	(1, 'Taverne', 'public/img/65e992bb051718.19870077.webp'),
	(2, 'Adventure', 'public/img/65e992bb051718.19870077.webp'),
	(3, 'MMORPG', 'public/img/65e992bb051718.19870077.webp'),
	(4, 'Roleplay', 'public/img/65e992bb051718.19870077.webp'),
	(5, 'Cars games', 'public/img/65e992bb051718.19870077.webp'),
	(6, 'Retrogaming', 'public/img/65e992bb051718.19870077.webp'),
	(7, 'Rogue like', 'public/img/65e992bb051718.19870077.webp'),
	(8, 'Narrative', 'public/img/65e992bb051718.19870077.webp'),
	(9, 'Puzzle', 'public/img/65e992bb051718.19870077.webp');

-- Listage de la structure de table forum. post
CREATE TABLE IF NOT EXISTS `post` (
  `id_post` int NOT NULL AUTO_INCREMENT,
  `post` text NOT NULL,
  `dateCreation` datetime DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id_post`),
  KEY `user_id` (`user_id`),
  KEY `post_ibfk_1` (`topic_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id_topic`) ON DELETE CASCADE,
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.post : ~9 rows (environ)
INSERT INTO `post` (`id_post`, `post`, `dateCreation`, `topic_id`, `user_id`) VALUES
	(5, 'teste 2', '2024-03-18 10:44:55', 13, 1),
	(6, 'Salut, des fran&ccedil;ais par ici ?55', '2024-03-18 10:47:41', 14, 1),
	(10, 'Coucou Everyone ! 55', '2024-03-18 14:17:55', 2, 1),
	(13, 'Hello Admin! how are you ?', '2024-03-19 13:45:50', 2, 15),
	(23, 'aaa', '2024-03-21 21:01:42', 14, 1),
	(24, 'Hello everyone !', '2024-03-22 10:51:39', 17, 1),
	(25, 'Lorem', '2024-03-22 13:44:29', 18, 15),
	(26, 'Heyoose', '2024-03-22 16:43:28', 19, 15),
	(27, 'Heyo', '2024-03-22 16:43:42', 20, 15);

-- Listage de la structure de table forum. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id_topic` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `closed` tinyint NOT NULL,
  `creationDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `nbView` int DEFAULT NULL,
  PRIMARY KEY (`id_topic`),
  KEY `user_id` (`user_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `topic_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`),
  CONSTRAINT `topic_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.topic : ~7 rows (environ)
INSERT INTO `topic` (`id_topic`, `title`, `closed`, `creationDate`, `user_id`, `category_id`, `nbView`) VALUES
	(2, 'Second Topic 2', 1, '2024-03-18 10:05:25', 1, 1, 5),
	(13, 'New mmorpg !', 0, '2024-03-18 10:44:55', 1, 3, 6),
	(14, 'Salut tout le monde !', 0, '2024-03-18 10:47:41', 1, 1, 7),
	(17, 'Latest Topic', 0, '2024-03-22 10:51:39', 1, 6, 4),
	(18, 'Testing', 0, '2024-03-22 13:44:29', 15, 2, 2),
	(19, 'First topic Puzzle', 0, '2024-03-22 16:43:28', 15, 9, 8),
	(20, 'Second topic Puzzle', 0, '2024-03-22 16:43:42', 15, 9, 15);

-- Listage de la structure de table forum. user
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `nickName` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `dateRegistration` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ban` tinyint NOT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Listage des données de la table forum.user : ~4 rows (environ)
INSERT INTO `user` (`id_user`, `nickName`, `avatar`, `password`, `role`, `dateRegistration`, `ban`, `email`) VALUES
	(1, 'Admin', './public/img/avatar/6609b4f4cd3310.14507592.webp', '$2y$10$TNAMmOt7TA7zkgy08FOD1.zb.Q.doL6LLavMbExIct1EI0XaDWj/G', 'ADMIN', '2024-03-15 14:48:48', 0, 'test@test.fr'),
	(14, 'User1', './public/img/avatar/default.webp', '$2y$10$ueKYtewZUtqSPkrMn0hnf.3qupuaUQUyL2n1o.p.1/WySXA6aDs2a', 'user', '2024-03-15 16:50:10', 0, 'test2@test.fr'),
	(15, 'AlexUser', './public/img/avatar/65faf7dacc8287.04328252.webp', '$2y$10$q.F9CIBKZDkfglNUYwU/GeLS6chGLW4FywvkoLMhQF/iGg.f67iKO', 'moderator', '2024-03-19 08:37:52', 0, 'test3@test.fr'),
	(19, 'UserTest', './public/img/avatar/65fd408b724787.03748158.webp', '$2y$10$8CaKOuvLU84MxB.8ttOOHu/5IFn3xQJbX/HQeR5hiQXs4tKSE5Z9m', 'user', '2024-03-22 09:25:06', 0, 'test88@test.fr');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
