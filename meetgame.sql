-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 25 mai 2024 à 19:00
-- Version du serveur : 5.7.24
-- Version de PHP : 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `meetgame`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(255) NOT NULL COMMENT 'Identifiant unique pour chaque administrateur',
  `username` varchar(50) NOT NULL COMMENT 'Nom d''admin',
  `password` varchar(255) NOT NULL COMMENT 'Mot de passe de l''admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'Admin', '$2y$10$M2ibXMDIGBm4MZKBGHC2x.hig3KzhGNGwRj5UYXsjCpX5gvRiHDCu');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(255) NOT NULL COMMENT 'Identifiant unique pour chaque message',
  `sender_id` int(255) NOT NULL COMMENT 'ID de l''expéditeur du message',
  `receiver_id` int(255) NOT NULL COMMENT 'ID du destinataire du message',
  `message` text NOT NULL COMMENT 'Contenu du message',
  `sent_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date et heure d''envoi du message',
  `signalement` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'valeur pour le signalement\r\n'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `sent_at`, `signalement`) VALUES
(2, 9, 6, 'salut', '2024-05-24 15:09:59', 1),
(3, 9, 8, 'salut', '2024-05-24 15:10:08', 0),
(4, 8, 5, 'salut', '2024-05-24 15:11:42', 1),
(5, 8, 9, 'yo', '2024-05-25 10:34:10', 0),
(6, 8, 9, 'salut', '2024-05-25 10:53:10', 0),
(9, 8, 9, 'yo', '2024-05-25 18:34:07', 0),
(10, 8, 9, 'yo', '2024-05-25 18:50:48', 0),
(11, 8, 9, 'ss', '2024-05-25 18:54:16', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL COMMENT 'Identifiant unique pour chaque utilisateur.',
  `username` varchar(50) NOT NULL COMMENT 'Nom d''utilisateur unique.',
  `email` varchar(100) NOT NULL COMMENT 'Adresse email unique.',
  `password` varchar(255) NOT NULL COMMENT 'Mot de passe de l''utilisateur.',
  `gender` enum('male','female','other') NOT NULL COMMENT 'Genre de l''utilisateur.',
  `birthdate` date NOT NULL COMMENT 'Date de naissance de l''utilisateur.',
  `profession` varchar(100) NOT NULL COMMENT 'Profession de l''utilisateur.',
  `residence` varchar(255) NOT NULL COMMENT 'Lieu de résidence de l''utilisateur.',
  `relationship_status` varchar(255) NOT NULL COMMENT 'Statut relationnel de l''utilisateur.',
  `physical_description` text NOT NULL,
  `personal_info` text NOT NULL,
  `photos` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT ' Date et heure de création de l''enregistrement.',
  `abonnement` enum('aucun','basic','standard','premium') NOT NULL COMMENT 'type d''abonnement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `gender`, `birthdate`, `profession`, `residence`, `relationship_status`, `physical_description`, `personal_info`, `photos`, `created_at`, `abonnement`) VALUES
(6, 'Yassine', 'aitdaood@gmail.com', '$2y$10$pl5EkKqr1diureq0iZ4xAuI4yffPXmSz8uxv4zD5oGrMbJ61V8qT.', 'male', '2007-02-22', 'étudiant', 'Cergy', 'En couple', 'Petit', 'aaa', 'uploads/6c930cbcb9fa9fd84523f4f7e9112ae3.jpg', '2024-05-24 10:33:36', 'basic'),
(7, 'Marcus', 'obihellothere@gmail.com', '$2y$10$T7JD2VCbNEX0a88geLMmUeud4N3QkHApL85tZ9DOLgu7T9NJW6Jpy', 'male', '2004-02-22', 'étudiant', 'Osny', 'Célibataire', 'Très petit', 'Musculation', 'uploads/6650b5e6d713d-8ffe1c45e8cde4ef505370a3dd0eca6d.jpg', '2024-05-24 10:34:47', 'aucun'),
(8, 'adil', 'adil@gmail.com', '$2y$10$q44usQL.WnY9BXML/4mWp.nT7oH001bNET2usq3Rzqp.NiB24Ro3S', 'female', '2004-02-22', 'étudiant', 'Argenteuil', 'En couple', 'barbus', 'muslim', 'uploads/6650ae05dece8-564da4679ff08ff900c073c9ff2c7afb.jpg', '2024-05-24 13:09:19', 'aucun'),
(9, 'Reda', 'rrr@gmail.com', '$2y$10$wkQjTB14yh5uGMDsOkm4MOG6k7w8apjhtoXg6zBTrGOBcJ6mxjBv2', 'male', '2004-02-22', 'étudiant', 'Colombe', 'Célibataire', 'Kotei', 'Foot', 'uploads/66509900a3e0a-82f5e6770d34710b2695b0ebf90521c8.jpg', '2024-05-24 13:41:20', 'aucun');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique pour chaque administrateur', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique pour chaque message', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique pour chaque utilisateur.', AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
