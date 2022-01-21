-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 18, 2019 at 07:15 PM
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
-- Table structure for table `tbl_departments`
--

DROP TABLE IF EXISTS `tbl_departments`;
CREATE TABLE IF NOT EXISTS `tbl_departments` (
  `Department ID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Department Title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`Department ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`Department ID`, `Department Title`) VALUES
('DCS', 'Department of Computer Studies'),
('DCRIM', 'Department of Criminology'),
('DTED', 'Department of Teacher-Education'),
('DPSYCH', 'Department of Psychology'),
('DBM', 'Department of Business Management');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_educators`
--

DROP TABLE IF EXISTS `tbl_educators`;
CREATE TABLE IF NOT EXISTS `tbl_educators` (
  `Username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Given Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Middle Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Family Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Gender` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Birthdate` date NOT NULL,
  `Contact Number` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Department ID` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_educators`
--

INSERT INTO `tbl_educators` (`Username`, `Given Name`, `Middle Name`, `Family Name`, `Address`, `Gender`, `Birthdate`, `Contact Number`, `Email`, `Department ID`, `Password`) VALUES
('nila', 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Molino III, Bacoor City, Cavite Province', 'Male', '1999-10-02', '9984626403', 'ni.amolat@gmail.com', 'DCS', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_programs`
--

DROP TABLE IF EXISTS `tbl_programs`;
CREATE TABLE IF NOT EXISTS `tbl_programs` (
  `Program ID` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Program Title` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Program Description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Program Objectives` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`Program ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_programs`
--

INSERT INTO `tbl_programs` (`Program ID`, `Program Title`, `Program Description`, `Program Objectives`) VALUES
('BSIT', 'Bachelor of Science in Information Technology', '', ''),
('BSCS', 'Bachelor of Science in Computer Science', '', ''),
('BSPSYCH', 'Bachelor of Science in Pyschology', '', ''),
('BSEDUC', 'Bachelor of Science in Secondary Education', '', ''),
('BSCRIM', 'Bachelor of Science in Criminology', '', ''),
('BSHRM', 'Bachelor of Science in Hotel and Restaurant Management', '', ''),
('BSBM', 'Bachelor of Science in Business Management', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

DROP TABLE IF EXISTS `tbl_students`;
CREATE TABLE IF NOT EXISTS `tbl_students` (
  `Student Number` int(11) NOT NULL,
  `Given Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Middle Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Family Name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Birthdate` date NOT NULL,
  `Gender` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Contact Number` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Program ID` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Year Level` int(1) NOT NULL,
  `Block Section` int(100) NOT NULL,
  `Password` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`Student Number`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`Student Number`, `Given Name`, `Middle Name`, `Family Name`, `Address`, `Birthdate`, `Gender`, `Contact Number`, `Email`, `Program ID`, `Year Level`, `Block Section`, `Password`) VALUES
(18010009, 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'BSIT', 2, 2, '$2y$10$rMbTaU3pWOA/D84eA1SrnuwWI.aDoxKWcV2/dJbPXNfUjH4fMpe8C'),
(18010001, 'Filemon', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1998-06-21', 'Male', '9984626403', 'filam@gmail.com', 'BSHRM', 3, 3, '$2y$10$DYjhQFaz15uNjL781z15m.POr4yXgh.b1n7HIrZaaIWrObMU0RJza'),
(18010006, 'Floica', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Mayumi Street, Camella West Springville, Barangay Molino IV, Bacoor City, Cavite Province', '1994-09-26', 'Female', '9984626403', 'amolatfloica@gmail.com', 'BSCS', 4, 1, '$2y$10$4TkHsy3DJ9glSUIPUPAHDOs5rQ7hgS/F4mGzmj4hJu2UOPbDZ7Hm6'),
(18009969, 'Imelda', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1964-08-26', 'Female', '9064526403', 'imee@gmail.com', 'BSBM', 2, 1, '$2y$10$SZgCJHCpxdaHfmDYVnQYh.mZdQjNzUcK2zc3hFhg9PRuqERvmeyGC'),
(18237999, 'asdf', 'asd', 'asd', 'Block 2 Lot 1, Silver Street, C213, Barangay 123, 12312 City, 3213 Province', '0000-00-00', 'Male', '2939', '213123@email.com', 'BSCS', 2, 3, '$2y$10$HXkoNn8F5OV7SlcNvIgpHeZwSwa1Sp7afsKhIDAC7W0tgesNhwNQK'),
(21312213, 'ss', 'ss', 'ss', 'Block 3 Lot 5, ss Street, ss, Barangay ss, ss City, ss Province', '0188-02-01', 'Male', '18', 'n@email.com', 'BSEDUC', 4, 54, '$2y$10$5BQlT/utrqziXcICuNR2F.TocJN6c1gj72WTvdcXlad01N3ylyU1G'),
(18010007, 'Imelda', 'asd', 'Rinoldo', 'Block 3 Lot 2, Mayumi Street, C213, Barangay Molino III, Bacoor City, Cavite Province', '1892-10-02', 'Male', '9984626405', 'imrin@email.com', 'BSEDUC', 3, 4, '$2y$10$nOsuBiYYkq7GkTxOxcmLh.U8lCQpR8ojJsQlpJXXZIEI/uTq1WhRS');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
