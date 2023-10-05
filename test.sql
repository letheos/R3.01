-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 05, 2023 at 04:41 PM
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
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `blockip`
--

CREATE TABLE `blockip` (
  `IP` varchar(255) NOT NULL,
  `expiration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

CREATE TABLE `candidates` (
  `INE` int(11) NOT NULL,
  `name` text NOT NULL,
  `firstName` text NOT NULL,
  `address` text NOT NULL,
  `ville` text NOT NULL,
  `radius` float NOT NULL,
  `permisB` tinyint(1) NOT NULL,
  `nameFormation` varchar(255) NOT NULL,
  `typeEntrepriseRecherchee` text,
  `isInActiveSearch` tinyint(1) NOT NULL,
  `cv` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`INE`, `name`, `firstName`, `address`, `ville`, `radius`, `permisB`, `nameFormation`, `typeEntrepriseRecherchee`, `isInActiveSearch`, `cv`) VALUES
(1, 'John Doe', 'Jane', '123 Main Street', 'Paris', 2.5, 1, 'Computer Science', 'Software Development', 0, NULL),
(2, 'Alice Smith', 'Bob', '456 Elm Avenue', 'Marseille', 3, 0, 'Electrical Engineering', 'Hardware Design', 1, NULL),
(3, 'Eva Johnson', 'Michael', '789 Oak Lane', 'Lyon', 2, 1, 'Mechanical Engineering', 'Product Design', 0, NULL),
(4, 'Sarah Brown', 'David', '101 Pine Road', 'Toulouse', 2.8, 1, 'Marketing', 'Market Research', 1, NULL),
(5, 'Daniel Wilson', 'Emily', '210 Cedar Drive', 'Bordeaux', 2.2, 0, 'Finance', 'Investment Banking', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `formation`
--

CREATE TABLE `formation` (
  `nameFormation` varchar(255) NOT NULL,
  `descriptionFormation` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `formation`
--

INSERT INTO `formation` (`nameFormation`, `descriptionFormation`) VALUES
('Computer Science', 'Science des ordis'),
('Electrical Engineering', 'C\'est les ingénieurs'),
('Finance', 'C\'est du Messager tier'),
('Marketing', 'Fin cringe tu sais'),
('Mechanical Engineering', 'C\'est la mécanique');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `idRole` int(11) NOT NULL,
  `nom` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idRole`, `nom`) VALUES
(1, 'Chef de département'),
(2, 'Secrétaire'),
(3, 'chargé de dev');

-- --------------------------------------------------------

--
-- Table structure for table `tentativeconnection`
--

CREATE TABLE `tentativeconnection` (
  `idConn` bigint(20) UNSIGNED NOT NULL,
  `ip` text,
  `login` varchar(64) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `connectPass` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `name` text,
  `surname` text,
  `email` text,
  `login` varchar(64) NOT NULL,
  `pswrd` varchar(255) NOT NULL,
  `idRole` int(11) NOT NULL,
  `formation` varchar(255) NOT NULL,
  `token` varchar(64) DEFAULT NULL,
  `tokenExpiresAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blockip`
--
ALTER TABLE `blockip`
  ADD PRIMARY KEY (`IP`);

--
-- Indexes for table `candidates`
--
ALTER TABLE `candidates`
  ADD PRIMARY KEY (`INE`),
  ADD KEY `nameFormation` (`nameFormation`);

--
-- Indexes for table `formation`
--
ALTER TABLE `formation`
  ADD PRIMARY KEY (`nameFormation`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD KEY `idRole` (`idRole`),
  ADD KEY `formation` (`formation`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `candidates`
--
ALTER TABLE `candidates`
  ADD CONSTRAINT `candidates_ibfk_1` FOREIGN KEY (`nameFormation`) REFERENCES `formation` (`nameFormation`);

--
-- Constraints for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `utilisateur_ibfk_1` FOREIGN KEY (`idRole`) REFERENCES `role` (`idRole`),
  ADD CONSTRAINT `utilisateur_ibfk_2` FOREIGN KEY (`formation`) REFERENCES `formation` (`nameFormation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
