-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2019 at 09:44 PM
-- Server version: 8.0.16
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_stms`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_educators`
--

DROP TABLE IF EXISTS `tbl_educators`;
CREATE TABLE IF NOT EXISTS `tbl_educators` (
  `Username` varchar(100) NOT NULL,
  `Given Name` varchar(100) NOT NULL,
  `Middle Name` varchar(100) NOT NULL,
  `Family Name` varchar(100) NOT NULL,
  `Block Number` varchar(100) NOT NULL,
  `Lot Number` varchar(100) NOT NULL,
  `Street` varchar(100) NOT NULL,
  `Subdivision` varchar(100) NOT NULL,
  `Barangay` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Province` varchar(100) NOT NULL,
  `Birthdate` varchar(10) NOT NULL,
  `Gender` varchar(6) NOT NULL,
  `Contact Number` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_programs`
--

DROP TABLE IF EXISTS `tbl_programs`;
CREATE TABLE IF NOT EXISTS `tbl_programs` (
  `Program ID` varchar(50) NOT NULL,
  `Program Title` varchar(50) NOT NULL,
  `Program Description` varchar(50) NOT NULL,
  `Program Objectives` varchar(50) NOT NULL,
  PRIMARY KEY (`Program ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_programs`
--

INSERT INTO `tbl_programs` (`Program ID`, `Program Title`, `Program Description`, `Program Objectives`) VALUES
('BSIT', 'Bachelor of Science in Information Technology', '', ''),
('BSCS', 'Bachelor of Science in Computer Science', '', ''),
('BSPSYCH', 'Bachelor of Science in Pyschology', '', ''),
('BSEDUC', 'Bachelor of Science in Secondary Education', '', ''),
('BSCRIM', 'Bachelor of Science in Criminology', '', ''),
('BSHRM', 'Bachelor of Science in Hotel and Restaurant Manage', '', ''),
('BSBM', 'Bachelor of Science in Business Management', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

DROP TABLE IF EXISTS `tbl_students`;
CREATE TABLE IF NOT EXISTS `tbl_students` (
  `Student Number` int(8) NOT NULL,
  `Given Name` varchar(100) NOT NULL,
  `Middle Name` varchar(100) NOT NULL,
  `Family Name` varchar(100) NOT NULL,
  `Block Number` int(100) NOT NULL,
  `Lot Number` int(100) NOT NULL,
  `Street` varchar(100) NOT NULL,
  `Subdivision` varchar(100) NOT NULL,
  `Barangay` varchar(100) NOT NULL,
  `City` varchar(100) NOT NULL,
  `Province` varchar(100) NOT NULL,
  `Birthdate` varchar(10) NOT NULL,
  `Gender` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Contact Number` varchar(13) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Program` varchar(100) NOT NULL,
  `Year Level` int(1) NOT NULL,
  `Block Section Number` int(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  PRIMARY KEY (`Student Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`Student Number`, `Given Name`, `Middle Name`, `Family Name`, `Block Number`, `Lot Number`, `Street`, `Subdivision`, `Barangay`, `City`, `Province`, `Birthdate`, `Gender`, `Contact Number`, `Email`, `Program`, `Year Level`, `Block Section Number`, `Password`) VALUES
(18010009, 'Nommel Isanar', 'Lavapie', 'Amolat', 3, 5, 'Silver', 'Camella North Springville', 'Molino III', 'Bacoor', 'Cavite', '10-2-1999', 'Male', '9984626403', 'ni.amolat@gmail.com', 'BSIT', 2, 2, '$2y$10$8t52Dzc5m/JTwc3Blr5Jr.MfXusVWBblpiIi2qJe.z.EjnSS3WUY6');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
