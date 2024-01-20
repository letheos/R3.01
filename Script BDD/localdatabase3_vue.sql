-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 20, 2024 at 11:49 AM
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
-- Stand-in structure for view `effectifsparcours`
-- (See below for the actual view)
--
CREATE TABLE `effectifsparcours` (
`nameParcours` varchar(500)
,`nombreetudiants` bigint(21)
,`alternants` decimal(23,0)
,`non_alternants` decimal(23,0)
,`actifs` decimal(23,0)
,`inactifs` decimal(23,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `effectif_formation`
-- (See below for the actual view)
--
CREATE TABLE `effectif_formation` (
`nameFormationParcours` varchar(255)
,`effectifFormation` bigint(21)
,`alternants` decimal(23,0)
,`non_alternants` decimal(23,0)
,`actifs` decimal(23,0)
,`inactifs` decimal(23,0)
);

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
,`phoneNumber` varchar(20)
,`candidateMail` text
,`nameParcours` varchar(500)
,`nameFormation` varchar(255)
,`yearOfFormation` text
,`isInActiveSearch` tinyint(1)
,`permisB` tinyint(1)
,`typeCompanySearch` text
,`cv` text
,`remarks` text
,`foundApp` tinyint(1)
,`AddressesIDs` text
,`ZonesRechercheIDs` text
);

-- --------------------------------------------------------

--
-- Structure for view `effectifsparcours`
--
DROP TABLE IF EXISTS `effectifsparcours`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `effectifsparcours`  AS SELECT `candidate`.`nameParcours` AS `nameParcours`, count(`candidate`.`name`) AS `nombreetudiants`, sum((`candidate`.`foundApp` = 1)) AS `alternants`, sum((`candidate`.`foundApp` = 0)) AS `non_alternants`, sum((`candidate`.`isInActiveSearch` = 1)) AS `actifs`, sum((`candidate`.`isInActiveSearch` = 0)) AS `inactifs` FROM `candidate` GROUP BY `candidate`.`nameParcours``nameParcours`  ;

-- --------------------------------------------------------

--
-- Structure for view `effectif_formation`
--
DROP TABLE IF EXISTS `effectif_formation`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `effectif_formation`  AS SELECT `parcours`.`nameFormationParcours` AS `nameFormationParcours`, count(`candidate`.`idCandidate`) AS `effectifFormation`, sum((`candidate`.`foundApp` = 1)) AS `alternants`, sum((`candidate`.`foundApp` = 0)) AS `non_alternants`, sum((`candidate`.`isInActiveSearch` = 1)) AS `actifs`, sum((`candidate`.`isInActiveSearch` = 0)) AS `inactifs` FROM (`parcours` join `candidate` on((`parcours`.`nameParcours` = `candidate`.`nameParcours`))) GROUP BY `parcours`.`nameFormationParcours``nameFormationParcours`  ;

-- --------------------------------------------------------

--
-- Structure for view `infocandidate`
--
DROP TABLE IF EXISTS `infocandidate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `infocandidate`  AS SELECT `candidate`.`idCandidate` AS `idCandidate`, `candidate`.`INE` AS `INE`, `candidate`.`name` AS `name`, `candidate`.`firstName` AS `firstName`, `candidate`.`phoneNumber` AS `phoneNumber`, `candidate`.`candidateMail` AS `candidateMail`, `candidate`.`nameParcours` AS `nameParcours`, `formation`.`nameFormation` AS `nameFormation`, `candidate`.`yearOfFormation` AS `yearOfFormation`, `candidate`.`isInActiveSearch` AS `isInActiveSearch`, `candidate`.`permisB` AS `permisB`, `candidate`.`typeCompanySearch` AS `typeCompanySearch`, `candidate`.`cv` AS `cv`, `candidate`.`remarks` AS `remarks`, `candidate`.`foundApp` AS `foundApp`, group_concat(distinct `candidateaddress`.`idAddr` separator ',') AS `AddressesIDs`, group_concat(distinct `candidatezone`.`idZone` separator ',') AS `ZonesRechercheIDs` FROM ((((`candidate` left join `candidateaddress` on((`candidate`.`idCandidate` = `candidateaddress`.`idCandidate`))) left join `candidatezone` on((`candidate`.`idCandidate` = `candidatezone`.`idCandidate`))) left join `parcours` on((`candidate`.`nameParcours` = `parcours`.`nameParcours`))) left join `formation` on((`parcours`.`nameFormationParcours` = `formation`.`nameFormation`))) GROUP BY `candidate`.`idCandidate``idCandidate`  ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
