-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : ven. 08 déc. 2023 à 09:09
-- Version du serveur : 5.7.24
-- Version de PHP : 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `localdatabase3`
--

-- --------------------------------------------------------

--
-- Structure de la table `blockip`
--

CREATE TABLE `blockip` (
  `ip` varchar(255) NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `candidate`
--

CREATE TABLE `candidate` (
  `idCandidate` int(11) NOT NULL,
  `INE` varchar(11) DEFAULT NULL,
  `name` text NOT NULL,
  `firstName` text NOT NULL,
  `nameParcours` varchar(500) DEFAULT NULL,
  `yearOfFormation` text,
  `isInActiveSearch` tinyint(1) NOT NULL,
  `permisB` tinyint(1) NOT NULL,
  `typeCompanySearch` text,
  `cv` blob,
  `remarks` text,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `candidateMail` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `candidateaddress`
--

CREATE TABLE `candidateaddress` (
  `idAddr` int(11) NOT NULL,
  `idCandidate` int(11) DEFAULT NULL,
  `cp` varchar(100) NOT NULL,
  `addressLabel` text NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `candidatezone`
--

CREATE TABLE `candidatezone` (
  `idZone` int(11) NOT NULL,
  `idCandidate` int(11) DEFAULT NULL,
  `cityName` text NOT NULL,
  `radius` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `connectionattempt`
--

CREATE TABLE `connectionattempt` (
  `idConn` int(11) NOT NULL,
  `ip` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `connectPass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dashboard`
--

CREATE TABLE `dashboard` (
  `nameOfDashBoard` varchar(255) NOT NULL,
  `idDashBoard` int(11) NOT NULL,
  `isPermis` tinyint(1) NOT NULL,
  `isIne` tinyint(1) NOT NULL,
  `isAddress` tinyint(1) NOT NULL,
  `isPhone` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `dashboardparcours`
--

CREATE TABLE `dashboardparcours` (
  `idDashBoard` int(11) NOT NULL,
  `nameParcours` varchar(255) NOT NULL,
  `yearOfFormation` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

CREATE TABLE `formation` (
  `nameFormation` varchar(255) NOT NULL,
  `decription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `formation`
--

INSERT INTO `formation` (`nameFormation`, `decription`) VALUES
('Génie électrique et informatique industrielle', 'Le département GEII forme 170 étudiants par an à temps plein et en alternance, aux métiers de l’automatique, l’électronique, l’informatique industrielle, le génie électrique. Ils sont compétents pour gérer et maintenir des réseaux informatiques industriels, analyser et développer des systèmes électroniques de traitement et de transmission de l’information'),
('Génie industriel et maintenance', 'Le département GIM forme 120 étudiants par an, à temps plein et en alternance. Leurs compétences portent sur l’installation, la maintenance en condition opérationnelle, la sécurisation, l’amélioration d’un système pluri-technique, et la gestion de moyens techniques et humains d’un service.'),
('Génie mécanique et productique', 'Les diplômés de Génie mécanique et productique assurent la mise sur le marché d’un nouveau produit à travers la conception, l’industrialisation, l’organisation industrielle.\r\n\r\nLe département GMP forme 200 étudiants par an à temps plein et en alternance.'),
('Gestion des entreprises et administrations', 'Le département GEA prépare aux métiers de la gestion, du management, de la comptabilité, des ressources humaines.\r\n\r\nIl forme 400 étudiants par an à temps plein et en alternance.'),
('Informatique', 'Le département informatique forme 180 étudiants par an à temps plein et en alternance, qui participent à la conception, le développement, la validation et l’intégration de solutions informatiques pour les organisations.'),
('Mesure Physique', 'Le département forme 60 étudiants par an à temps plein et en alternance, dont les compétences sont centrées sur le contrôle industriel, la métrologie, l’instrumentation, la caractérisation de grandeurs physiques et physico-chimiques et les mesures environnementales.'),
('Qualité, logistique industrielle et organisation', 'Le département QLIO prépare les étudiants aux démarches d’ingénierie collaborative, dans un contexte global de gestion du cycle de vie et d’amélioration continue, quels que soient les secteurs industriels et de service.'),
('Techniques de commercialisation (Cambrai)', 'Le département forme 300 étudiants par an, à temps plein et en alternance, qui interviennent dans toutes les étapes de la commercialisation d’un bien ou d’un service : étude de marché, vente, stratégie marketing, communication commerciale, négociation, relation client.'),
('Techniques de commercialisation (Valenciennes)', 'Le département forme 430 étudiants par an, à temps plein et en alternance, qui interviennent dans toutes les étapes de la commercialisation d’un bien ou d’un service : étude de marché, vente, stratégie marketing, communication commerciale, négociation, relation client.');

-- --------------------------------------------------------

--
-- Structure de la table `formationsutilisateurs`
--

CREATE TABLE `formationsutilisateurs` (
  `loginutilisateur` varchar(255) NOT NULL,
  `formationname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `infocandidate`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `infocandidate` (
`idCandidate` int(11)
,`INE` varchar(11)
,`name` text
,`firstName` text
,`phoneNumber` varchar(20)
,`candidateMail` text
,`nameParcours` varchar(500)
,`nameFormation` varchar(255)
,`yearOfFormation` text
,`isInActiveSearch` tinyint(1)
,`permisB` tinyint(1)
,`typeCompanySearch` text
,`cv` blob
,`remarks` text
,`AddressesIDs` text
,`ZonesRechercheIDs` text
);

-- --------------------------------------------------------

--
-- Structure de la table `parcours`
--

CREATE TABLE `parcours` (
  `nameParcours` varchar(500) NOT NULL,
  `nameFormationParcours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parcours`
--

INSERT INTO `parcours` (`nameParcours`, `nameFormationParcours`) VALUES
('Parcours A - GEII', 'Génie électrique et informatique industrielle'),
('Parcours B - GEII', 'Génie électrique et informatique industrielle'),
('Parcours Informatique A', 'Génie électrique et informatique industrielle'),
('Parcours X - GIM', 'Génie industriel et maintenance'),
('Parcours Y - GIM', 'Génie industriel et maintenance'),
('Parcours 1 - GMP', 'Génie mécanique et productique'),
('Parcours 2 - GMP', 'Génie mécanique et productique'),
('Parcours Informatique B', 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `idRole` int(11) NOT NULL,
  `nameRole` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `userdashboard`
--

CREATE TABLE `userdashboard` (
  `idDashBoard` int(11) NOT NULL,
  `login` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login` varchar(255) NOT NULL,
  `pswrd` text NOT NULL,
  `userName` text NOT NULL,
  `firstName` text NOT NULL,
  `idRole` int(11) DEFAULT NULL,
  `email` text NOT NULL,
  `token` text,
  `tokenExpiresAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la vue `infocandidate`
--
DROP TABLE IF EXISTS `infocandidate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `infocandidate`  AS SELECT `candidate`.`idCandidate` AS `idCandidate`, `candidate`.`INE` AS `INE`, `candidate`.`name` AS `name`, `candidate`.`firstName` AS `firstName`, `candidate`.`phoneNumber` AS `phoneNumber`, `candidate`.`candidateMail` AS `candidateMail`, `candidate`.`nameParcours` AS `nameParcours`, `formation`.`nameFormation` AS `nameFormation`, `candidate`.`yearOfFormation` AS `yearOfFormation`, `candidate`.`isInActiveSearch` AS `isInActiveSearch`, `candidate`.`permisB` AS `permisB`, `candidate`.`typeCompanySearch` AS `typeCompanySearch`, `candidate`.`cv` AS `cv`, `candidate`.`remarks` AS `remarks`, group_concat(distinct `candidateaddress`.`idAddr` separator ',') AS `AddressesIDs`, group_concat(distinct `candidatezone`.`idZone` separator ',') AS `ZonesRechercheIDs` FROM ((((`candidate` left join `candidateaddress` on((`candidate`.`idCandidate` = `candidateaddress`.`idCandidate`))) left join `candidatezone` on((`candidate`.`idCandidate` = `candidatezone`.`idCandidate`))) left join `parcours` on((`candidate`.`nameParcours` = `parcours`.`nameParcours`))) left join `formation` on((`parcours`.`nameFormationParcours` = `formation`.`nameFormation`))) GROUP BY `candidate`.`idCandidate``idCandidate`  ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `blockip`
--
ALTER TABLE `blockip`
  ADD PRIMARY KEY (`ip`);

--
-- Index pour la table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`idCandidate`),
  ADD UNIQUE KEY `INE` (`INE`),
  ADD KEY `nameParcours` (`nameParcours`);

--
-- Index pour la table `candidateaddress`
--
ALTER TABLE `candidateaddress`
  ADD PRIMARY KEY (`idAddr`),
  ADD KEY `idCandidate` (`idCandidate`);

--
-- Index pour la table `candidatezone`
--
ALTER TABLE `candidatezone`
  ADD PRIMARY KEY (`idZone`),
  ADD KEY `idCandidate` (`idCandidate`);

--
-- Index pour la table `connectionattempt`
--
ALTER TABLE `connectionattempt`
  ADD PRIMARY KEY (`idConn`);

--
-- Index pour la table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`idDashBoard`);

--
-- Index pour la table `dashboardparcours`
--
ALTER TABLE `dashboardparcours`
  ADD PRIMARY KEY (`idDashBoard`,`nameParcours`),
  ADD KEY `nameParcours` (`nameParcours`);

--
-- Index pour la table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`nameFormation`);

--
-- Index pour la table `formationsutilisateurs`
--
ALTER TABLE `formationsutilisateurs`
  ADD KEY `loginutilisateur` (`loginutilisateur`),
  ADD KEY `formationname` (`formationname`);

--
-- Index pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`nameParcours`),
  ADD KEY `nameFormationParcours` (`nameFormationParcours`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Index pour la table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD PRIMARY KEY (`idDashBoard`,`login`),
  ADD KEY `login` (`login`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`login`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `idCandidate` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `candidateaddress`
--
ALTER TABLE `candidateaddress`
  MODIFY `idAddr` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `candidatezone`
--
ALTER TABLE `candidatezone`
  MODIFY `idZone` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `connectionattempt`
--
ALTER TABLE `connectionattempt`
  MODIFY `idConn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `idDashBoard` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidate`
--
ALTER TABLE `candidate`
  ADD CONSTRAINT `candidate_ibfk_1` FOREIGN KEY (`nameParcours`) REFERENCES `parcours` (`nameParcours`);

--
-- Contraintes pour la table `dashboardparcours`
--
ALTER TABLE `dashboardparcours`
  ADD CONSTRAINT `dashboardparcours_ibfk_1` FOREIGN KEY (`idDashBoard`) REFERENCES `dashboard` (`idDashBoard`),
  ADD CONSTRAINT `dashboardparcours_ibfk_2` FOREIGN KEY (`nameParcours`) REFERENCES `parcours` (`nameParcours`);

--
-- Contraintes pour la table `formationsutilisateurs`
--
ALTER TABLE `formationsutilisateurs`
  ADD CONSTRAINT `formationsutilisateurs_ibfk_1` FOREIGN KEY (`loginutilisateur`) REFERENCES `utilisateur` (`login`),
  ADD CONSTRAINT `formationsutilisateurs_ibfk_2` FOREIGN KEY (`formationname`) REFERENCES `formation` (`nameFormation`);

--
-- Contraintes pour la table `parcours`
--
ALTER TABLE `parcours`
  ADD CONSTRAINT `parcours_ibfk_1` FOREIGN KEY (`nameFormationParcours`) REFERENCES `formation` (`nameFormation`);

--
-- Contraintes pour la table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD CONSTRAINT `userdashboard_ibfk_1` FOREIGN KEY (`idDashBoard`) REFERENCES `dashboard` (`idDashBoard`),
  ADD CONSTRAINT `userdashboard_ibfk_2` FOREIGN KEY (`login`) REFERENCES `utilisateur` (`login`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
