-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 24, 2019 at 11:00 PM
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
-- Table structure for table `tbl_classes`
--

DROP TABLE IF EXISTS `tbl_classes`;
CREATE TABLE IF NOT EXISTS `tbl_classes` (
  `Class ID` int(11) NOT NULL AUTO_INCREMENT,
  `Educator Username` varchar(100) NOT NULL,
  `Section ID` varchar(100) NOT NULL,
  `Course Code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Students` json NOT NULL,
  PRIMARY KEY (`Class ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_courses`
--

DROP TABLE IF EXISTS `tbl_courses`;
CREATE TABLE IF NOT EXISTS `tbl_courses` (
  `Course Code` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Course Category` varchar(100) NOT NULL,
  `Course Suffix` varchar(50) NOT NULL,
  `Course Title` varchar(200) NOT NULL,
  `Course Description` varchar(500) NOT NULL,
  `Course Type` json NOT NULL,
  `Course Units` varchar(50) NOT NULL,
  `Course Prerequisites` varchar(200) NOT NULL,
  `Course Creator` varchar(100) NOT NULL,
  PRIMARY KEY (`Course Code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`Course Code`, `Course Category`, `Course Suffix`, `Course Title`, `Course Description`, `Course Type`, `Course Units`, `Course Prerequisites`, `Course Creator`) VALUES
('DCIT 21', 'DCIT', '21', 'Computer Programming 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '[\"Laboratory\", \"Lecture\"]', '3', '', 'aica'),
('GNED 4', 'GNED', '4', 'Introduction to Communication', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', '[\"Lecture\"]', '1', '', 'aica'),
('ITEC 55', 'ITEC', '55', 'Information Management', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.', '[\"Laboratory\", \"Lecture\"]', '3', '[\"DCIT 21\"]', 'nila');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_departments`
--

DROP TABLE IF EXISTS `tbl_departments`;
CREATE TABLE IF NOT EXISTS `tbl_departments` (
  `Department ID` varchar(50) NOT NULL,
  `Department Title` varchar(200) NOT NULL,
  PRIMARY KEY (`Department ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_departments`
--

INSERT INTO `tbl_departments` (`Department ID`, `Department Title`) VALUES
('DBM', 'Depertment of Business Management'),
('DCRIM', 'Department of Criminology'),
('DCS', 'Department of Computer Studies'),
('DPSYCH', 'Department of Psychology'),
('DTED', 'Department of Teacher-Education');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_educators`
--

DROP TABLE IF EXISTS `tbl_educators`;
CREATE TABLE IF NOT EXISTS `tbl_educators` (
  `Username` varchar(50) NOT NULL,
  `Given Name` varchar(100) NOT NULL,
  `Middle Name` varchar(100) NOT NULL,
  `Family Name` varchar(100) NOT NULL,
  `Address` varchar(100) NOT NULL,
  `Birthdate` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Contact Number` varchar(20) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Department ID` varchar(20) NOT NULL,
  `Courses` json NOT NULL,
  `Classes` json NOT NULL,
  `Password` varchar(200) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_educators`
--

INSERT INTO `tbl_educators` (`Username`, `Given Name`, `Middle Name`, `Family Name`, `Address`, `Birthdate`, `Gender`, `Contact Number`, `Email`, `Department ID`, `Courses`, `Classes`, `Password`) VALUES
('abugs', 'Roneson', 'Angelo', 'Abug', 'Block 4 Lot 2, Magdiwang Street, Queensrow, Barangay Queensrow Central, Bacoor City, Cavite Province', '1521-01-08', 'Male', '76437564852462', 'abug@gmail.com', 'DCS', 'null', 'null', '$2y$10$uasdIBtNij7atiz1aGUTXOTLfMY8UL1QxIvoxVoGsIWtOf4f6XcTq'),
('aica', 'Floica', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Pr', '1994-09-26', 'Female', '9984626403', 'amolatfloica@gmail.com', 'DCS', '[\"DCIT 21\", \"GNED 4\"]', 'null', '$2y$10$Ycws3xBfESujmcfQDtLRwOiJT5JAHp3lPwX2pveq/nG9Gml4I2/aK'),
('enzoveran', 'Enzo ', 'Galia', 'Veran', 'Block 2 Lot 4, Catleya Street, Bonair, Barangay Molino 3, Bacoor City, cavite Province', '1997-01-03', 'Male', '9337514362', 'enzo@gmail.com', 'DCS', 'null', 'null', '$2y$10$Th8f0kIi92lT7ZwZ/1syse9Fi/I8bCOHv4bDuIxJD9DJYDLAdvsGi'),
('nila', 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Pr', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'DCS', '[]', 'null', '$2y$10$OAnwYAjPSMF7GUcWz2OPh.nfRYOMQ8gsC836cO2rkbGz28Vki2ehe'),
('user1', 'khween', 'jdhadj', 'dhadhaj', 'dhjad, jajd City, dhajdkha Province', '1990-02-04', 'Male', '9337514362', 'jajhahd@gmail.com', 'DCS', 'null', 'null', '$2y$10$N.xueUC1a7xiNpwlHxWSTelguT0wHKvy5OAUCh5sK0aGCaTcnrVNS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

DROP TABLE IF EXISTS `tbl_notifications`;
CREATE TABLE IF NOT EXISTS `tbl_notifications` (
  `Notification ID` int(11) NOT NULL AUTO_INCREMENT,
  `Target ID` varchar(200) NOT NULL,
  `Title` varchar(300) NOT NULL,
  `Message` varchar(500) NOT NULL,
  `Status` varchar(100) NOT NULL,
  PRIMARY KEY (`Notification ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_programs`
--

DROP TABLE IF EXISTS `tbl_programs`;
CREATE TABLE IF NOT EXISTS `tbl_programs` (
  `Program ID` varchar(50) NOT NULL,
  `Program Title` varchar(200) NOT NULL,
  PRIMARY KEY (`Program ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_programs`
--

INSERT INTO `tbl_programs` (`Program ID`, `Program Title`) VALUES
('BSBM', 'Bachelor of Science in Business Management'),
('BSCRIM', 'Bachelor of Science in Criminology'),
('BSCS', 'Bachelor of Science in Computer Science'),
('BSEDUC', 'Bachelor of Science in Secondary Education'),
('BSHRM', 'Bachelor of Science in Hotel and Restaurant Management'),
('BSIT', 'Bachelor of Science in Information Technology'),
('BSPSYCH', 'Bachelor of Science in Psychology');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sections`
--

DROP TABLE IF EXISTS `tbl_sections`;
CREATE TABLE IF NOT EXISTS `tbl_sections` (
  `Section ID` varchar(200) NOT NULL,
  `Students` varchar(900) NOT NULL,
  PRIMARY KEY (`Section ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

DROP TABLE IF EXISTS `tbl_students`;
CREATE TABLE IF NOT EXISTS `tbl_students` (
  `Student Number` int(11) NOT NULL,
  `Given Name` varchar(100) NOT NULL,
  `Middle Name` varchar(100) NOT NULL,
  `Family Name` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `Birthdate` date NOT NULL,
  `Gender` varchar(50) NOT NULL,
  `Contact Number` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Program ID` varchar(20) NOT NULL,
  `Year Level` varchar(5) NOT NULL,
  `Block Section` varchar(20) NOT NULL,
  `Password` varchar(200) NOT NULL,
  PRIMARY KEY (`Student Number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`Student Number`, `Given Name`, `Middle Name`, `Family Name`, `Address`, `Birthdate`, `Gender`, `Contact Number`, `Email`, `Program ID`, `Year Level`, `Block Section`, `Password`) VALUES
(18010009, 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'BSIT', '2', '2', '$2y$10$xouk.txQt3T.42HCQQzeoeK6SEztj/.kRQowQGxKYOuiBg2J88hQy'),
(18010387, 'Lorenzo', 'Galia', 'Veran', 'Block 12 Lot 15, Catleya Street, Bonair, Barangay Molino III, Bacoor City, Cavite Province', '1999-07-12', 'Male', '54344434332', 'veranenzo@gmail.com', 'BSCS', '2', '2', '$2y$10$SeKLR7NltXeSND1gbh4eYuuaLVcrLTV6aqRt/kMZu1i5bvCEsqzAe');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
