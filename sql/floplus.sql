-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 27 jan. 2025 à 13:07
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `floplus`
--

-- --------------------------------------------------------

--
-- Structure de la table `animes`
--

DROP TABLE IF EXISTS `animes`;
CREATE TABLE IF NOT EXISTS `animes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `genres` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `release_year` int DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pepite` tinyint(1) DEFAULT '0',
  `classique` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `animes`
--

INSERT INTO `animes` (`id`, `title`, `description`, `genres`, `release_year`, `thumbnail`, `created_at`, `pepite`, `classique`) VALUES
(1, 'Attack on Titan', 'Anime de guerre et de mystère.', 'Action, Aventure', 2013, 'aot.jpg', '2025-01-07 11:28:09', 1, 0),
(2, 'Demon Slayer', 'Un jeune garçon lutte contre les démons.', 'Action, Fantastique', 2019, 'demonslayer.jpg', '2025-01-07 11:28:09', 1, 0),
(3, 'One Piece', 'Luffy et son équipage cherchent le trésor ultime.', 'Action, Aventure, Comédie', 1999, 'onepiece.jpg', '2025-01-07 11:28:09', 1, 1),
(4, 'Naruto', 'Un ninja rêve de devenir Hokage.', 'Action, Aventure', 2002, 'naruto.jpg', '2025-01-07 11:28:09', 1, 1),
(5, 'Death Note', 'Un cahier qui tue quiconque y est nommé.', 'Thriller, Mystère', 2006, 'deathnote.jpg', '2025-01-07 11:28:09', 1, 1),
(6, 'Dragon Ball Z', 'Les aventures de Goku et de ses amis.', 'Action, Arts martiaux', 1989, 'dbz.jpg', '2025-01-07 11:28:09', 0, 1),
(7, 'Jujutsu Kaisen', 'Un étudiant affronte des malédictions.', 'Action, Fantastique', 2020, 'jujutsu.jpg', '2025-01-07 11:28:09', 1, 0),
(8, 'My Hero Academia', 'Des étudiants s’entraînent pour devenir des héros.', 'Action, Comédie', 2016, 'mha.jpg', '2025-01-07 11:28:09', 1, 0),
(9, 'Sword Art Online', 'Des joueurs piégés dans un MMORPG mortel.', 'Action, Fantastique', 2012, 'sao.jpg', '2025-01-07 11:28:09', 0, 0),
(10, 'Fullmetal Alchemist: Brotherhood', 'Deux frères cherchent la pierre philosophale.', 'Action, Drame, Fantastique', 2009, 'fma.jpg', '2025-01-07 11:28:09', 1, 1),
(11, 'Bleach', 'Un lycéen devient un shinigami.', 'Action, Aventure', 2004, 'bleach.jpg', '2025-01-07 11:28:09', 1, 1),
(12, 'Hunter x Hunter', 'Un garçon devient un chasseur professionnel.', 'Action, Aventure', 1999, 'hxh.jpg', '2025-01-07 11:28:09', 1, 1),
(13, 'Tokyo Ghoul', 'Un jeune homme devient un mi-humain mi-ghoul.', 'Horreur, Thriller', 2014, 'tokyoghoul.jpg', '2025-01-07 11:28:09', 1, 0),
(14, 'Re:Zero', 'Un garçon revit encore et encore après sa mort.', 'Fantastique, Drame', 2016, 'rezero.jpg', '2025-01-07 11:28:09', 1, 0),
(15, 'Black Clover', 'Deux orphelins rêvent de devenir empereur-mage.', 'Action, Fantastique', 2017, 'blackclover.jpg', '2025-01-07 11:28:09', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `anime_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `anime_id` (`anime_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('user','admin') COLLATE utf8mb4_general_ci DEFAULT 'user',
  `favorite_anime_1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `favorite_anime_2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `favorite_anime_3` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `created_at`, `role`, `favorite_anime_1`, `favorite_anime_2`, `favorite_anime_3`) VALUES
(6, 'admin', 'admin@admin', '$2y$10$x/FLmMwwEOet0II9yDryoObARTc09SvPX5Yc.1RLHaPs3sdHDmC36', '2025-01-27 11:01:24', 'admin', 'Attack on Titan', 'Demon Slayer', 'Bleach');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
