-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 20, 2024 at 11:48 AM
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
-- Database: `localdatabase3`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert`
--

CREATE TABLE `alert` (
  `idAlert` int(11) NOT NULL,
  `remindAt` date NOT NULL,
  `note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alert`
--

INSERT INTO `alert` (`idAlert`, `remindAt`, `note`) VALUES
(11, '2024-01-19', 'RDV 2024'),
(28, '2024-01-20', 'Test d\'alertes prévues au 20/01/2024'),
(29, '2024-01-20', 'Encore un test');

-- --------------------------------------------------------

--
-- Table structure for table `alertutilisateur`
--

CREATE TABLE `alertutilisateur` (
  `idAlert` int(11) DEFAULT NULL,
  `login` varchar(255) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `alertutilisateur`
--

INSERT INTO `alertutilisateur` (`idAlert`, `login`, `seen`) VALUES
(9, 'user1', 0),
(11, 'user1', 0),
(28, 'admin', 0),
(29, 'admin', 0);

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
  `cv` text,
  `remarks` text,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `candidateMail` text,
  `foundApp` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `candidate`
--

INSERT INTO `candidate` (`idCandidate`, `INE`, `name`, `firstName`, `nameParcours`, `yearOfFormation`, `isInActiveSearch`, `permisB`, `typeCompanySearch`, `cv`, `remarks`, `phoneNumber`, `candidateMail`, `foundApp`) VALUES
(8, '123456789AB', 'Strady', 'Nathan', 'Déploiement d’applications communicantes et sécurisées (DACS)', '2ème Année', 1, 0, 'Entreprise dans le JV', '../upload/cv_Nathan_Strady_2.pdf', 'N\'a aucun problème de santé', '06050546', 'nathan.strady@sfr.fr', 0),
(9, NULL, 'Timothée', 'Allix', 'Réalisations d applications : conception, développement, validation (RACDV)', '2ème Année', 1, 0, 'Le réseau', '../upload/cv_Nathan_Strady_2_stage_avec_photo.pdf', 'Oui', '062615210', 'timothee.allix@uphf.fr', 0),
(10, NULL, 'CandidatTest', 'CandidatTest', 'Organisation et Supply Chain (OSC)', '3ème Année', 1, 0, NULL, '../upload/png-transparent-rick-astley-whenever-you-need-somebody-musician-cry-for-help-walshamlewillows-necktie-musician-lyrics-thumbnail (1).png', NULL, '56456546', 'candidat.test@test.com', 0),
(11, NULL, 'Parent', 'Théo', 'Déploiement d’applications communicantes et sécurisées (DACS)', '1ère Année', 1, 0, NULL, NULL, NULL, '06546996', 'nintendoplayeraddict@gmail.com', 0),
(12, '987654321EB', 'Massy', 'Benjamin', 'Matériaux et contrôles physico-chimiques', '2ème Année', 1, 0, NULL, NULL, NULL, '06545652', 'massy.benjamin@uphf.fr', 0);

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
(55, 8, '59220', '26 place ferrer', 'Wavrechain-sous-Denain'),
(56, 9, '59600', 'Maubeuge', 'Maubeuge'),
(57, 9, '89520', 'Un autre endroit', 'endroit'),
(58, 10, '56000', 'Maubeuge', 'Maubeuge'),
(59, 11, '56000', 'Maubeuge', 'Maubeuge'),
(60, 11, '59210', 'Nord', 'Nord'),
(61, 12, '56000', 'Maubeuge', 'Maubeuge'),
(62, 12, '59150', 'Wattrelos', 'Wattrelos');

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
(90, 8, 'Lille', 60),
(91, 8, 'Paris', 80),
(92, 8, 'Toulouse', 100),
(93, 9, 'Lille', 100),
(94, 10, 'Zone de recherche ', 52),
(95, 11, 'Test', 90),
(96, 12, 'Lille ', 100),
(97, 12, 'Paris ', 150);

-- --------------------------------------------------------

--
-- Table structure for table `communication`
--

CREATE TABLE `communication` (
  `idMessage` int(11) NOT NULL,
  `dateCommunication` timestamp NULL DEFAULT NULL,
  `note` text,
  `img` text,
  `idCandidate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `communication`
--

INSERT INTO `communication` (`idMessage`, `dateCommunication`, `note`, `img`, `idCandidate`) VALUES
(8, '2024-01-19 13:19:24', 'qesqe', NULL, 8);

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

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `nameOfDashBoard` varchar(255) NOT NULL,
  `idDashBoard` int(11) NOT NULL,
  `isPermis` tinyint(1) NOT NULL,
  `isIne` tinyint(1) NOT NULL,
  `isAddress` tinyint(1) NOT NULL,
  `isPhone` tinyint(1) NOT NULL,
  `isHeadcount` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`nameOfDashBoard`, `idDashBoard`, `isPermis`, `isIne`, `isAddress`, `isPhone`, `isHeadcount`) VALUES
('IUT Maubeuge', 32, 1, 1, 1, 1, 1),
('Je test', 34, 1, 1, 1, 1, 1),
('ENCORE', 35, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dashboardparcours`
--

CREATE TABLE `dashboardparcours` (
  `idDashBoard` int(11) NOT NULL,
  `nameParcours` varchar(500) NOT NULL,
  `yearOfFormation` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `dashboardparcours`
--

INSERT INTO `dashboardparcours` (`idDashBoard`, `nameParcours`, `yearOfFormation`) VALUES
(32, 'Automatisme et Informatique Industrielle (AII)', NULL),
(32, 'Chargé d’affaires industrielles (CAI)', NULL),
(32, 'Conception et production durables (CPD)', NULL),
(32, 'Ingénierie des systèmes pluri-techniques (ISPT)', NULL),
(32, 'Innovation pour l’industrie (II)', NULL),
(32, 'Management des process industriels (MPI)', NULL),
(32, 'Management, méthodes, maintenance innovante (3MI)', NULL),
(34, 'Automatisme et Informatique Industrielle (AII)', '1er'),
(34, 'Déploiement d’applications communicantes et sécurisées (DACS)', '1er'),
(34, 'Réalisations d applications : conception, développement, validation (RACDV)', '1er'),
(35, 'Déploiement d’applications communicantes et sécurisées (DACS)', '1er'),
(35, 'Ingénierie des systèmes pluri-techniques (ISPT)', '1er'),
(35, 'Management, méthodes, maintenance innovante (3MI)', '1er'),
(35, 'Réalisations d applications : conception, développement, validation (RACDV)', '1er');

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
('Génie électrique et informatique industrielle', 'La formation Génie électrique et informatique industrielle comprend environ 200 étudiants'),
('Génie industriel et maintenance', 'La formation Génie industriel et maintenance comprend environ 180 étudiants'),
('Génie mécanique et productique', 'La formation Génie mécanique et productique comprend environ 220 étudiants'),
('Gestion des Entreprises et des Administrations', 'La formation Gestion des Entreprises et des Administrations comprend environ 170 étudiants'),
('Informatique', 'La formation Informatique comprend environ 130 étudiants'),
('Mesures Physiques', 'La formation Mesures Physiques comprend environ 110 étudiants'),
('qualité, logistique industrielle et organisation', 'La formation qualité, logistique industrielle et organisation comprend environ 160 étudiants'),
('technicien conseil vente', 'La formation technicien conseil vente comprend environ 120 étudiants'),
('Techniques de commercialisation', 'La formation Techniques de commercialisation comprend environ 140 étudiants');

-- --------------------------------------------------------

--
-- Table structure for table `formationsutilisateurs`
--

CREATE TABLE `formationsutilisateurs` (
  `loginutilisateur` varchar(255) NOT NULL,
  `formationname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
('Automatisme et Informatique Industrielle (AII)', 'Génie électrique et informatique industrielle'),
('Ingénierie des systèmes pluri-techniques (ISPT)', 'Génie industriel et maintenance'),
('Management, méthodes, maintenance innovante (3MI)', 'Génie industriel et maintenance'),
('Chargé d’affaires industrielles (CAI)', 'Génie mécanique et productique'),
('Conception et production durables (CPD)', 'Génie mécanique et productique'),
('Innovation pour l’industrie (II)', 'Génie mécanique et productique'),
('Management des process industriels (MPI)', 'Génie mécanique et productique'),
('Gestion comptable, fiscale et financière (GCFF)', 'Gestion des Entreprises et des Administrations'),
('Gestion entrepreneuriat et management d activités (GEMA)', 'Gestion des Entreprises et des Administrations'),
('Gestion et pilotage des ressources humaines (GPRH)', 'Gestion des Entreprises et des Administrations'),
('Déploiement d’applications communicantes et sécurisées (DACS)', 'Informatique'),
('Réalisations d applications : conception, développement, validation (RACDV)', 'Informatique'),
('Matériaux et contrôles physico-chimiques', 'Mesures Physiques'),
('Organisation et Supply Chain (OSC)', 'qualité, logistique industrielle et organisation'),
('Qualité et Management Intégré (QMI)', 'qualité, logistique industrielle et organisation'),
('Business développement et management de la relation client - technicien conseil vente  (RC)', 'technicien conseil vente'),
('Marketing digital, e-business et entrepreneuriat (MD)  - technicien conseil vente ', 'technicien conseil vente'),
('Business développement et management de la relation client - Techniques de commercialisation (RC)', 'Techniques de commercialisation'),
('Marketing digital, e-business et entrepreneuriat (MD) - Techniques de commercialisation', 'Techniques de commercialisation'),
('Stratégie de marque et évènementiel (SME)', 'Techniques de commercialisation');

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
(1, 'Chef de service'),
(2, 'Secretaire'),
(3, 'Chargé de développement'),
(4, 'Chef de département');

-- --------------------------------------------------------

--
-- Table structure for table `userdashboard`
--

CREATE TABLE `userdashboard` (
  `idDashBoard` int(11) NOT NULL,
  `login` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userdashboard`
--

INSERT INTO `userdashboard` (`idDashBoard`, `login`) VALUES
(32, 'admin'),
(34, 'admin'),
(35, 'admin');

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
  `email` text NOT NULL,
  `token` text,
  `tokenExpiresAt` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`login`, `pswrd`, `userName`, `firstName`, `idRole`, `email`, `token`, `tokenExpiresAt`) VALUES
('admin', '$2y$10$A7ZKkr/60gr2sqXLAgbNe.ZYpOYCum0odgWCHbp5.KHHK7zvtXm3u', 'Administrator', 'Admin', 1, 'nathan.strady.tra@gmail.com', NULL, NULL),
('user1', 'user123', 'User One', 'User', 2, 'user1@example.com', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert`
--
ALTER TABLE `alert`
  ADD PRIMARY KEY (`idAlert`);

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
-- Indexes for table `communication`
--
ALTER TABLE `communication`
  ADD PRIMARY KEY (`idMessage`),
  ADD KEY `idCandidate` (`idCandidate`);

--
-- Indexes for table `connectionattempt`
--
ALTER TABLE `connectionattempt`
  ADD PRIMARY KEY (`idConn`);

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`idDashBoard`);

--
-- Indexes for table `dashboardparcours`
--
ALTER TABLE `dashboardparcours`
  ADD PRIMARY KEY (`idDashBoard`,`nameParcours`),
  ADD KEY `nameParcours` (`nameParcours`);

--
-- Indexes for table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`nameFormation`);

--
-- Indexes for table `formationsutilisateurs`
--
ALTER TABLE `formationsutilisateurs`
  ADD KEY `loginutilisateur` (`loginutilisateur`),
  ADD KEY `formationname` (`formationname`);

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
-- Indexes for table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD PRIMARY KEY (`idDashBoard`,`login`),
  ADD KEY `login` (`login`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`login`),
  ADD KEY `idRole` (`idRole`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alert`
--
ALTER TABLE `alert`
  MODIFY `idAlert` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `candidate`
--
ALTER TABLE `candidate`
  MODIFY `idCandidate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `candidateaddress`
--
ALTER TABLE `candidateaddress`
  MODIFY `idAddr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `candidatezone`
--
ALTER TABLE `candidatezone`
  MODIFY `idZone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `communication`
--
ALTER TABLE `communication`
  MODIFY `idMessage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `connectionattempt`
--
ALTER TABLE `connectionattempt`
  MODIFY `idConn` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `idDashBoard` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidate`
--
ALTER TABLE `candidate`
  ADD CONSTRAINT `candidate_ibfk_1` FOREIGN KEY (`nameParcours`) REFERENCES `parcours` (`nameParcours`);

--
-- Constraints for table `communication`
--
ALTER TABLE `communication`
  ADD CONSTRAINT `communication_ibfk_1` FOREIGN KEY (`idCandidate`) REFERENCES `candidate` (`idCandidate`);

--
-- Constraints for table `dashboardparcours`
--
ALTER TABLE `dashboardparcours`
  ADD CONSTRAINT `dashboardparcours_ibfk_1` FOREIGN KEY (`idDashBoard`) REFERENCES `dashboard` (`idDashBoard`),
  ADD CONSTRAINT `dashboardparcours_ibfk_2` FOREIGN KEY (`nameParcours`) REFERENCES `parcours` (`nameParcours`);

--
-- Constraints for table `formationsutilisateurs`
--
ALTER TABLE `formationsutilisateurs`
  ADD CONSTRAINT `formationsutilisateurs_ibfk_1` FOREIGN KEY (`loginutilisateur`) REFERENCES `utilisateur` (`login`),
  ADD CONSTRAINT `formationsutilisateurs_ibfk_2` FOREIGN KEY (`formationname`) REFERENCES `formation` (`nameFormation`);

--
-- Constraints for table `parcours`
--
ALTER TABLE `parcours`
  ADD CONSTRAINT `parcours_ibfk_1` FOREIGN KEY (`nameFormationParcours`) REFERENCES `formation` (`nameFormation`);

--
-- Constraints for table `userdashboard`
--
ALTER TABLE `userdashboard`
  ADD CONSTRAINT `userdashboard_ibfk_1` FOREIGN KEY (`idDashBoard`) REFERENCES `dashboard` (`idDashBoard`),
  ADD CONSTRAINT `userdashboard_ibfk_2` FOREIGN KEY (`login`) REFERENCES `utilisateur` (`login`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
