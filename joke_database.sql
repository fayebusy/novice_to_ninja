-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 28 déc. 2021 à 18:40
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `joke_database`
--

-- --------------------------------------------------------

--
-- Structure de la table `author`
--

CREATE TABLE `author` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `author`
--

INSERT INTO `author` (`id`, `name`, `email`, `password`) VALUES
(1, 'Youssoupha FAYE', 'fayeyousso@gmail.com', '$2y$10$ewqgrTB1Yt0m1NXBVGdpM.ZAR2F1hlNKnGI5ZMCGT4gAbt8wwzCRa'),
(2, 'Tom Butler', 'tom@r.je', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `joke`
--

CREATE TABLE `joke` (
  `id` int(11) NOT NULL,
  `joketext` text DEFAULT NULL,
  `jokedate` date NOT NULL,
  `authorId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `joke`
--

INSERT INTO `joke` (`id`, `joketext`, `jokedate`, `authorId`) VALUES
(1, 'How many programmers does it take to screw in a lightbulb? None, it\'s a hardware problem.', '2017-04-01', 1),
(2, 'Why did the programmer quit his job? He didn\'t get arrays', '2017-04-01', 1),
(3, 'Why was the empty array stuck outside? It didn\'t have any keys', '2017-04-01', 2),
(4, 'this is a new joke', '2021-12-24', 1),
(6, 'pour faire peur a un informaticien dites quil a oublie un point virgule ', '2021-12-28', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `joke`
--
ALTER TABLE `joke`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `joke`
--
ALTER TABLE `joke`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
