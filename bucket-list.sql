-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 29 mars 2023 à 21:27
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bucket-list`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Travel & Adventure'),
(2, 'Sport'),
(3, 'Entertainment'),
(4, 'Human Relations'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `pseudo`) VALUES
(1, 'sandra.lamire@live.fr', '[\"ROLE_ADMIN\"]', '$2y$13$6L0Eo4MRFzSqHQwmO.kqruYrS5cKyV9XGqJWrKRQxZmhXwRdqHW1m', ''),
(2, 'sl@live.fr', '[\"ROLE_USER\"]', '$2y$13$VCz6W6IrgB.FHmzwE2.H7uFW25O2CApBYoLLLqvv6uY4NHm4Qt6/y', 'sl');

-- --------------------------------------------------------

--
-- Structure de la table `wish`
--

DROP TABLE IF EXISTS `wish`;
CREATE TABLE IF NOT EXISTS `wish` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D7D174C912469DE2` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `wish`
--

INSERT INTO `wish` (`id`, `title`, `description`, `author`, `is_published`, `date_created`, `category_id`) VALUES
(2, 'Trouver une alternance', 'Continuer à envoyer des mails et explorer le réseau pour trouver une alternance', 'Sandra Lamiré', 1, '2023-02-10 14:30:12', 4),
(4, 'Garder la pêche', 'Ne pas déprimer', 'Sandra', 0, '2023-02-21 15:20:14', 4),
(5, 'Visiter l\'Egypte', 'Croisière sur le Nil', 'SL', 1, '2023-02-24 16:02:44', 1),
(6, 'Voir Avatar 2', 'Aller au cinéma', 'Sandra L', 1, '2023-02-24 16:22:06', 3),
(7, 'Refaire du sport', 'Se remettre au vélo d\'appartement', 'SL', 1, '2023-02-24 16:25:59', 2),
(8, 'S\'accomplir', 'Avoir une meilleur avenir', 'Sandra Lamiré', 1, '2023-02-24 16:50:39', 5),
(9, 'Voyage au Japon', 'Découvrir la culture japonaise', 'S.', 1, '2023-02-28 11:51:25', 3),
(10, '* de wish', 'si tu lis ça, je te dis *!!! et * et *', 'sl', 1, '2023-03-01 16:05:20', 3);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `wish`
--
ALTER TABLE `wish`
  ADD CONSTRAINT `FK_D7D174C912469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
