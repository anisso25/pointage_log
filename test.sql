-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 19 juin 2023 à 12:03
-- Version du serveur : 5.7.39
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `historique_pointages`
--

CREATE TABLE `historique_pointages` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `date_pointage` date NOT NULL,
  `heure_pointage` time NOT NULL,
  `heure_fin_pointage` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `historique_pointages`
--

INSERT INTO `historique_pointages` (`id`, `utilisateur_id`, `date_pointage`, `heure_pointage`, `heure_fin_pointage`) VALUES
(171, 4, '2023-06-09', '18:43:45', '18:50:57'),
(172, 4, '2023-06-09', '18:44:32', '18:50:57'),
(173, 4, '2023-06-09', '18:47:58', '18:50:57'),
(174, 4, '2023-06-09', '18:48:54', '18:50:57'),
(175, 3, '2023-06-09', '18:49:25', '18:49:29'),
(176, 4, '2023-06-09', '18:50:52', '18:50:57'),
(177, 4, '2023-06-19', '11:27:57', '11:28:24'),
(178, 1, '2023-06-19', '11:40:44', '11:40:56');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`, `nom`) VALUES
(1, 'sarah', '1234', 'Sarah Djabri'),
(3, 'root', '12345678', 'Nom Utilisateur 1'),
(4, 'user', '12345678', 'Nom Utilisateur 2');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `historique_pointages`
--
ALTER TABLE `historique_pointages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `historique_pointages`
--
ALTER TABLE `historique_pointages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=179;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `historique_pointages`
--
ALTER TABLE `historique_pointages`
  ADD CONSTRAINT `historique_pointages_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
