-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 26, 2023 at 08:17 AM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `localdatabase2`
--

-- --------------------------------------------------------

--
-- Table structure for table `blockip`
--

CREATE TABLE `blockip` (
  `ip` varchar(255) NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `candidate`
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
  `remarks` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`idCandidate`, `INE`, `name`, `firstName`, `nameParcours`, `yearOfFormation`, `isInActiveSearch`, `permisB`, `typeCompanySearch`, `cv`, `remarks`) VALUES
(3, NULL, 'Parent', 'Théo', 'Parcours Y - GIM', '2ème Année', 1, 1, 'Une alternance aled', NULL, 'Aigris boy');

-- --------------------------------------------------------

--
-- Table structure for table `candidateaddress`
--

CREATE TABLE `candidateaddress` (
  `idAddr` int(11) NOT NULL,
  `idCandidate` int(11) DEFAULT NULL,
  `cp` varchar(100) NOT NULL,
  `addressLabel` text NOT NULL,
  `city` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `candidateaddress`
--

INSERT INTO `candidateaddress` (`idAddr`, `idCandidate`, `cp`, `addressLabel`, `city`) VALUES
(29, 3, '56000', 'La ou vit théo la', 'Maubeuge');

-- --------------------------------------------------------

--
-- Table structure for table `candidatezone`
--

CREATE TABLE `candidatezone` (
  `idZone` int(11) NOT NULL,
  `idCandidate` int(11) DEFAULT NULL,
  `cityName` text NOT NULL,
  `radius` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `candidatezone`
--

INSERT INTO `candidatezone` (`idZone`, `idCandidate`, `cityName`, `radius`) VALUES
(25, 3, 'Lille', 60),
(26, 3, 'Douchy', 20);

-- --------------------------------------------------------

--
-- Table structure for table `connectionattempt`
--

CREATE TABLE `connectionattempt` (
  `idConn` int(11) NOT NULL,
  `ip` text,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `connectPass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `connectionattempt`
--

INSERT INTO `connectionattempt` (`idConn`, `ip`, `date`, `connectPass`) VALUES
(17, '::1', '2023-10-08 14:24:31', 1),
(19, '::1', '2023-10-09 09:55:29', 1),
(20, '::1', '2023-10-09 09:55:53', 1),
(21, '::1', '2023-10-09 09:56:09', 1),
(22, '::1', '2023-10-09 09:56:16', 1),
(24, '::1', '2023-10-24 13:15:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `formation`
--

CREATE TABLE `formation` (
  `nameFormation` varchar(255) NOT NULL,
  `decription` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formation`
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
-- Stand-in structure for view `infocandidate`
-- (See below for the actual view)
--
CREATE TABLE `infocandidate` (
`idCandidate` int(11)
,`INE` varchar(11)
,`name` text
,`firstName` text
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
-- Table structure for table `parcours`
--

CREATE TABLE `parcours` (
  `nameParcours` varchar(500) NOT NULL,
  `nameFormationParcours` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parcours`
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
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `idRole` int(11) NOT NULL,
  `nameRole` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idRole`, `nameRole`) VALUES
(1, 'Chef de département'),
(2, 'Secrétaire'),
(3, 'chargé de dev');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `login` varchar(255) NOT NULL,
  `pswrd` text NOT NULL,
  `userName` text NOT NULL,
  `firstName` text NOT NULL,
  `idRole` int(11) DEFAULT NULL,
  `nameFormation` varchar(255) DEFAULT NULL,
  `email` text NOT NULL,
  `token` text,
  `tokenExpiresAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `pswrd`, `userName`, `firstName`, `idRole`, `nameFormation`, `email`, `token`, `tokenExpiresAt`) VALUES
('alice.smith', '$2y$10$Iuiz1oMjN6itBLBYCGuq1.cBySuU9qetwCIgQwgOu8cjl1MNhTqsm', 'Alice', 'Smith', 2, NULL, 'nathan.strady.tra@gmail.com', NULL, NULL),
('bob.jones', 'motdepasse3', 'Bob', 'Jones', 3, NULL, 'bob@example.com', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure for view `infocandidate`
--
DROP TABLE IF EXISTS `infocandidate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `infocandidate`  AS SELECT `candidate`.`idCandidate` AS `idCandidate`, `candidate`.`INE` AS `INE`, `candidate`.`name` AS `name`, `candidate`.`firstName` AS `firstName`, `candidate`.`nameParcours` AS `nameParcours`, `formation`.`nameFormation` AS `nameFormation`, `candidate`.`yearOfFormation` AS `yearOfFormation`, `candidate`.`isInActiveSearch` AS `isInActiveSearch`, `candidate`.`permisB` AS `permisB`, `candidate`.`typeCompanySearch` AS `typeCompanySearch`, `candidate`.`cv` AS `cv`, `candidate`.`remarks` AS `remarks`, group_concat(distinct `candidateaddress`.`idAddr` separator ',') AS `AddressesIDs`, group_concat(distinct `candidatezone`.`idZone` separator ',') AS `ZonesRechercheIDs` FROM ((((`candidate` left join `candidateaddress` on((`candidate`.`idCandidate` = `candidateaddress`.`idCandidate`))) left join `candidatezone` on((`candidate`.`idCandidate` = `candidatezone`.`idCandidate`))) left join `parcours` on((`candidate`.`nameParcours` = `parcours`.`nameParcours`))) left join `formation` on((`parcours`.`nameFormationParcours` = `formation`.`nameFormation`))) GROUP BY `candidate`.`idCandidate``idCandidate`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blockip`
--
ALTER TABLE `blockip`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `candidate`
--
ALTER TABLE `candidate`
  ADD PRIMARY KEY (`idCandidate`),
  ADD UNIQUE KEY `INE` (`INE`),
  ADD KEY `nameParcours` (`nameParcours`);

--
-- Indexes for table `candidateaddress`
--
ALTER TABLE `candidateaddress`
  ADD PRIMARY KEY (`idAddr`),
  ADD KEY `idCandidate` (`idCandidate`);

--
-- Indexes for table `candidatezone`
--
ALTER TABLE `candidatezone`
  ADD PRIMARY KEY (`idZone`),
  ADD KEY `idCandidate` (`idCandidate`);

--
-- Indexes for table `connectionattempt`
--
ALTER TABLE `connectionattempt`
  ADD PRIMARY KEY (`idConn`);

--
-- Indexes for table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`nameFormation`);

--
-- Indexes for table `parcours`
--
ALTER TABLE `parcours`
  ADD PRIMARY KEY (`nameParcours`),
  ADD KEY `nameFormationParcours` (`nameFormationParcours`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`login`),
  ADD KEY `idRole` (`idRole`),
  ADD KEY `nameFormation` (`nameFormation`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `idCandidate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `candidateaddress`
--
ALTER TABLE `candidateaddress`
  MODIFY `idAddr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `candidatezone`
--
ALTER TABLE `candidatezone`
  MODIFY `idZone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `connectionattempt`
--
ALTER TABLE `connectionattempt`
  MODIFY `idConn` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate`
--
ALTER TABLE `candidate`
  ADD CONSTRAINT `candidate_ibfk_1` FOREIGN KEY (`nameParcours`) REFERENCES `parcours` (`nameParcours`);

--
-- Constraints for table `parcours`
--
ALTER TABLE `parcours`
  ADD CONSTRAINT `parcours_ibfk_1` FOREIGN KEY (`nameFormationParcours`) REFERENCES `formation` (`nameFormation`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `nameFormation` FOREIGN KEY (`nameFormation`) REFERENCES `formation` (`nameFormation`),
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`),
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`nameFormation`) REFERENCES `formation` (`nameFormation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
