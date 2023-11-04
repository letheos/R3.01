-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 04, 2023 at 01:12 PM
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
-- Structure for view `infocandidate`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `infocandidate`  AS SELECT `candidate`.`idCandidate` AS `idCandidate`, `candidate`.`INE` AS `INE`, `candidate`.`name` AS `name`, `candidate`.`firstName` AS `firstName`, `candidate`.`nameParcours` AS `nameParcours`, `formation`.`nameFormation` AS `nameFormation`, `candidate`.`yearOfFormation` AS `yearOfFormation`, `candidate`.`isInActiveSearch` AS `isInActiveSearch`, `candidate`.`permisB` AS `permisB`, `candidate`.`typeCompanySearch` AS `typeCompanySearch`, `candidate`.`cv` AS `cv`, `candidate`.`remarks` AS `remarks`, group_concat(distinct `candidateaddress`.`idAddr` separator ',') AS `AddressesIDs`, group_concat(distinct `candidatezone`.`idZone` separator ',') AS `ZonesRechercheIDs` FROM ((((`candidate` left join `candidateaddress` on((`candidate`.`idCandidate` = `candidateaddress`.`idCandidate`))) left join `candidatezone` on((`candidate`.`idCandidate` = `candidatezone`.`idCandidate`))) left join `parcours` on((`candidate`.`nameParcours` = `parcours`.`nameParcours`))) left join `formation` on((`parcours`.`nameFormationParcours` = `formation`.`nameFormation`))) GROUP BY `candidate`.`idCandidate``idCandidate`  ;

--
-- VIEW `infocandidate`
-- Data: None
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
