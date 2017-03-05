-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:8889
-- Généré le :  Dim 05 Mars 2017 à 23:31
-- Version du serveur :  5.6.28
-- Version de PHP :  7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `hero`
--

CREATE TABLE `hero` (
  `id` int(11) NOT NULL,
  `classe` varchar(45) DEFAULT NULL,
  `pv` int(11) DEFAULT NULL,
  `experience` tinyint(4) NOT NULL,
  `niveau` tinyint(4) NOT NULL,
  `pvitesse` int(11) DEFAULT NULL,
  `pdefense` int(11) DEFAULT NULL,
  `pattaque` int(11) DEFAULT NULL,
  `pmagie` int(11) DEFAULT NULL,
  `bourse` varchar(45) DEFAULT NULL,
  `joueur_id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `hero`
--

INSERT INTO `hero` (`id`, `classe`, `pv`, `experience`, `niveau`, `pvitesse`, `pdefense`, `pattaque`, `pmagie`, `bourse`, `joueur_id`, `nom`) VALUES
(1, NULL, NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 0, ''),
(2, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, ''),
(3, NULL, -20, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'jul'),
(4, NULL, -260, 8, 1, NULL, NULL, NULL, NULL, NULL, 0, 'lol'),
(5, NULL, 523, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'a'),
(6, NULL, -8, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'd'),
(7, NULL, 49, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'f'),
(8, NULL, -26, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'kkk'),
(9, NULL, -20, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'aaaa'),
(10, NULL, -8, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'h'),
(11, NULL, NULL, 0, 0, NULL, NULL, NULL, NULL, NULL, 0, 'l'),
(12, NULL, 0, 0, 23, NULL, NULL, NULL, NULL, NULL, 0, 'aaa');

-- --------------------------------------------------------

--
-- Structure de la table `Héros`
--

CREATE TABLE `Héros` (
  `idHéros` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `classe` varchar(45) DEFAULT NULL,
  `point_vie` int(11) DEFAULT NULL,
  `point_def` int(11) DEFAULT NULL,
  `point_att` int(11) DEFAULT NULL,
  `point_vit` int(11) DEFAULT NULL,
  `point_mag` int(11) DEFAULT NULL,
  `bourse_or` int(11) DEFAULT NULL,
  `magiciens` varchar(45) DEFAULT NULL,
  `barbare` varchar(45) DEFAULT NULL,
  `paladin` varchar(45) DEFAULT NULL,
  `niveau` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Joueurs`
--

CREATE TABLE `Joueurs` (
  `idJoueurs` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `pseudo` varchar(45) DEFAULT NULL,
  `description` longtext,
  `Héros_idHéros` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Monstres`
--

CREATE TABLE `Monstres` (
  `idMonstres` int(11) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `point_vie` int(11) DEFAULT NULL,
  `point_def` int(11) DEFAULT NULL,
  `point_att` int(11) DEFAULT NULL,
  `point_vit` int(11) DEFAULT NULL,
  `gobelins` varchar(45) DEFAULT NULL,
  `magicien_noir` varchar(45) DEFAULT NULL,
  `dragon` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `Niveaux`
--

CREATE TABLE `Niveaux` (
  `idNiveaux` int(11) NOT NULL,
  `salle` int(11) DEFAULT NULL,
  `coffres` int(11) DEFAULT NULL,
  `monstres` int(11) DEFAULT NULL,
  `héros` int(11) DEFAULT NULL,
  `portes` int(11) DEFAULT NULL,
  `Monstres_idMonstres` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `hero`
--
ALTER TABLE `hero`
  ADD PRIMARY KEY (`id`,`joueur_id`),
  ADD KEY `fk_hero_joueur1_idx` (`joueur_id`);

--
-- Index pour la table `Héros`
--
ALTER TABLE `Héros`
  ADD PRIMARY KEY (`idHéros`),
  ADD UNIQUE KEY `nom_UNIQUE` (`nom`);

--
-- Index pour la table `Joueurs`
--
ALTER TABLE `Joueurs`
  ADD PRIMARY KEY (`idJoueurs`,`Héros_idHéros`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `pseudo_UNIQUE` (`pseudo`),
  ADD KEY `fk_Joueurs_Héros1_idx` (`Héros_idHéros`);

--
-- Index pour la table `Monstres`
--
ALTER TABLE `Monstres`
  ADD PRIMARY KEY (`idMonstres`);

--
-- Index pour la table `Niveaux`
--
ALTER TABLE `Niveaux`
  ADD PRIMARY KEY (`idNiveaux`,`Monstres_idMonstres`),
  ADD UNIQUE KEY `héros_UNIQUE` (`héros`),
  ADD UNIQUE KEY `salle_UNIQUE` (`salle`),
  ADD KEY `fk_Niveaux_Monstres_idx` (`Monstres_idMonstres`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `hero`
--
ALTER TABLE `hero`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT pour la table `Héros`
--
ALTER TABLE `Héros`
  MODIFY `idHéros` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Joueurs`
--
ALTER TABLE `Joueurs`
  MODIFY `idJoueurs` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Monstres`
--
ALTER TABLE `Monstres`
  MODIFY `idMonstres` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `Niveaux`
--
ALTER TABLE `Niveaux`
  MODIFY `idNiveaux` int(11) NOT NULL AUTO_INCREMENT;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Joueurs`
--
ALTER TABLE `Joueurs`
  ADD CONSTRAINT `fk_Joueurs_Héros1` FOREIGN KEY (`Héros_idHéros`) REFERENCES `Héros` (`idHéros`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `Niveaux`
--
ALTER TABLE `Niveaux`
  ADD CONSTRAINT `fk_Niveaux_Monstres` FOREIGN KEY (`Monstres_idMonstres`) REFERENCES `Monstres` (`idMonstres`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
