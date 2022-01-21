-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 07, 2019 at 12:42 AM
-- Server version: 8.0.18
-- PHP Version: 7.4.0

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
-- Table structure for table `tbl_categories`
--

DROP TABLE IF EXISTS `tbl_categories`;
CREATE TABLE IF NOT EXISTS `tbl_categories` (
  `Category ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category Title` varchar(200) NOT NULL,
  PRIMARY KEY (`Category ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`Category ID`, `Category Title`) VALUES
(1, 'Long Test');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categorized_tasks`
--

DROP TABLE IF EXISTS `tbl_categorized_tasks`;
CREATE TABLE IF NOT EXISTS `tbl_categorized_tasks` (
  `Entry ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category ID` int(11) NOT NULL,
  `Task ID` int(11) NOT NULL,
  PRIMARY KEY (`Entry ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classes`
--

DROP TABLE IF EXISTS `tbl_classes`;
CREATE TABLE IF NOT EXISTS `tbl_classes` (
  `Class ID` int(11) NOT NULL AUTO_INCREMENT,
  `Handled Course ID` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Section ID` varchar(100) NOT NULL,
  PRIMARY KEY (`Class ID`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_classes`
--

INSERT INTO `tbl_classes` (`Class ID`, `Handled Course ID`, `Section ID`) VALUES
(42, '68', 'BSIT 4-3'),
(41, '68', 'BSIT 3-2'),
(40, '68', 'BSPSYCH 2-2'),
(39, '68', 'BSIT 4-2'),
(43, '68', 'BSIT 4-5'),
(44, '69', 'BSPSYCH 2-4'),
(45, '69', 'BSBM 2-4'),
(46, '69', 'BSBM 3-4'),
(47, '69', 'BSEDUC 4-4'),
(48, '69', 'BSEDUC 1-4'),
(49, '69', 'BSHRM 2-4'),
(50, '70', 'BSEDUC 2-2'),
(58, '81', 'BSIT 1-3'),
(57, '81', 'BSIT 2-2'),
(60, '81', 'BSIT 1-34'),
(59, '81', 'BSIT 1-4'),
(61, '81', 'BSBM 1-1'),
(62, '81', 'BSIT 1-1'),
(63, '81', 'BSEDUC 2-2'),
(64, '81', 'BSEDUC 2-1'),
(65, '82', 'BSEDUC 2-2'),
(66, '81', 'BSIT 1-2'),
(67, '81', 'BSEDUC 1-2'),
(68, '81', 'BSBM 2-2'),
(73, '89', 'BSEDUC 3-3'),
(72, '89', 'BSEDUC 2-3'),
(74, '92', 'BSEDUC 4-2'),
(75, '92', 'BSEDUC 4-3'),
(76, '89', 'BSEDUC 2-4');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_students`
--

DROP TABLE IF EXISTS `tbl_class_students`;
CREATE TABLE IF NOT EXISTS `tbl_class_students` (
  `Class Student ID` int(11) NOT NULL AUTO_INCREMENT,
  `Class ID` int(11) NOT NULL,
  `Student Number` int(11) NOT NULL,
  PRIMARY KEY (`Class Student ID`)
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
('COSC 50', 'COSC', '50', 'General Mathematics', 'Math is a very interesting Subject. How about General Mathematics?', '[\"Laboratory\", \"Lecture\"]', '2', '[\"ITEC 55\"]', 'nila'),
('DCIT 21', 'DCIT', '21', 'Computer Programming 2', 'Out, I get a lovely view of the bay and a little private wharf belonging to the estate. There is a beautiful shaded lane that runs down there from the house. I always fancy I see people walking in these numerous paths and arbors, but John has cautioned me not to give way to fancy in the least. He says that with my imaginative power and habit of story-making a nervous weakness like mine is sure to lead to all manner of excited fancies and that I ought to use my will and good sense to c', '[\"Laboratory\", \"Lecture\"]', '3', '', 'nila'),
('DCIT 23', 'DCIT', '23', 'Computer Programming 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '[\"Laboratory\", \"Lecture\"]', '3', '', 'nila'),
('DCIT 24', 'DCIT', '24', 'Computer Programming 7', '2', '[\"Laboratory\"]', '3', '', 'floica'),
('DCIT 26', 'DCIT', '26', 'Computer Programming 4', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '[\"Laboratory\"]', '3', '[\"DCIT 23\",\"DCIT 21\"]', 'nila'),
('GNED 21', 'GNED', '21', 'Purposive Communication', 'A very fun Subject.', '[\"Lecture\"]', '3', '[\"ITEC 55\",\"DCIT 21\",\"DCIT 23\",\"DCIT 26\",\"DCIT 24\",\"GNED 21\"]', 'nila'),
('ITEC 55', 'ITEC', '55', 'Information Management', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '[\"Laboratory\", \"Lecture\"]', '2', '[\"GNED 21\",\"DCIT 24\",\"DCIT 23\"]', 'nila');

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
  `Password` varchar(200) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_educators`
--

INSERT INTO `tbl_educators` (`Username`, `Given Name`, `Middle Name`, `Family Name`, `Address`, `Birthdate`, `Gender`, `Contact Number`, `Email`, `Department ID`, `Password`) VALUES
('abugs', 'Roneson', 'Angelo', 'Abug', 'Block 4 Lot 2, Magdiwang Street, Queensrow, Barangay Queensrow Central, Bacoor City, Cavite Province', '1521-01-08', 'Male', '76437564852462', 'abug@gmail.com', 'DCS', '$2y$10$uasdIBtNij7atiz1aGUTXOTLfMY8UL1QxIvoxVoGsIWtOf4f6XcTq'),
('aica', 'Floica', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Pr', '1994-09-26', 'Female', '9984626403', 'amolatfloica@gmail.com', 'DCS', '$2y$10$Ycws3xBfESujmcfQDtLRwOiJT5JAHp3lPwX2pveq/nG9Gml4I2/aK'),
('enzoveran', 'Enzo ', 'Galia', 'Veran', 'Block 2 Lot 4, Catleya Street, Bonair, Barangay Molino 3, Bacoor City, cavite Province', '1997-01-03', 'Male', '9337514362', 'enzo@gmail.com', 'DCS', '$2y$10$Th8f0kIi92lT7ZwZ/1syse9Fi/I8bCOHv4bDuIxJD9DJYDLAdvsGi'),
('floica', 'Floica', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Pr', '1999-10-02', 'Male', '9984626403', 'amolatfloica@gmail.com', 'DCS', '$2y$10$hxe.uzzRFHwgfeoW6rMAF.xmEkNSoUS6uJTSMB6/CafjzQH.TY5tW'),
('nila', 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Pr', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'DCS', '$2y$10$OAnwYAjPSMF7GUcWz2OPh.nfRYOMQ8gsC836cO2rkbGz28Vki2ehe'),
('user1', 'khween', 'jdhadj', 'dhadhaj', 'dhjad, jajd City, dhajdkha Province', '1990-02-04', 'Male', '9337514362', 'jajhahd@gmail.com', 'DCS', '$2y$10$N.xueUC1a7xiNpwlHxWSTelguT0wHKvy5OAUCh5sK0aGCaTcnrVNS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_handled_courses`
--

DROP TABLE IF EXISTS `tbl_handled_courses`;
CREATE TABLE IF NOT EXISTS `tbl_handled_courses` (
  `Handled Course ID` int(11) NOT NULL AUTO_INCREMENT,
  `Course Code` varchar(150) NOT NULL,
  `Handler Username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`Handled Course ID`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_handled_courses`
--

INSERT INTO `tbl_handled_courses` (`Handled Course ID`, `Course Code`, `Handler Username`) VALUES
(92, 'ITEC 55', 'nila'),
(68, 'DCIT 21', 'floica'),
(81, 'DCIT 21', 'nila'),
(69, 'DCIT 23', 'floica'),
(70, 'DCIT 24', 'floica'),
(89, 'COSC 50', 'nila'),
(82, 'DCIT 24', 'nila'),
(99, 'GNED 21', 'nila'),
(100, 'DCIT 26', 'nila'),
(101, 'DCIT 23', 'nila');

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
  `Program ID` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Year Level ID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Section Number` varchar(10) NOT NULL,
  PRIMARY KEY (`Section ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sections`
--

INSERT INTO `tbl_sections` (`Section ID`, `Program ID`, `Year Level ID`, `Section Number`) VALUES
('BSIT 2-2', 'BSIT', '2', '2'),
('BSIT 4-2', 'BSIT', '4', '2'),
('BSIT 1-2', 'BSIT', '1', '2'),
('BSBM 2-2', 'BSBM', '2', '2'),
('BSBM 2-3', 'BSBM', '2', '3'),
('BSBM 2-5', 'BSBM', '2', '5'),
('BSBM 4-2', 'BSBM', '4', '2'),
('BSIT 4-1', 'BSIT', '4', '1'),
('BSIT 3-3', 'BSIT', '3', '3'),
('BSIT 2-3', 'BSIT', '2', '3'),
('BSIT 2-10', 'BSIT', '2', '10'),
('BSIT 2-5', 'BSIT', '2', '5'),
('BSIT 2-1', 'BSIT', '2', '1'),
('BSPSYCH 2-2', 'BSPSYCH', '2', '2'),
('BSIT 3-2', 'BSIT', '3', '2'),
('BSIT 4-3', 'BSIT', '4', '3'),
('BSIT 4-5', 'BSIT', '4', '5'),
('BSPSYCH 2-4', 'BSPSYCH', '2', '4'),
('BSBM 2-4', 'BSBM', '2', '4'),
('BSBM 3-4', 'BSBM', '3', '4'),
('BSEDUC 4-4', 'BSEDUC', '4', '4'),
('BSEDUC 1-4', 'BSEDUC', '1', '4'),
('BSHRM 2-4', 'BSHRM', '2', '4'),
('BSEDUC 2-2', 'BSEDUC', '2', '2'),
('BSIT 3-5', 'BSIT', '3', '5'),
('BSPSYCH 3-2', 'BSPSYCH', '3', '2'),
('BSBM 3-2', 'BSBM', '3', '2'),
('BSIT 1-3', 'BSIT', '1', '3'),
('BSIT 1-4', 'BSIT', '1', '4'),
('BSIT 1-34', 'BSIT', '1', '34'),
('BSBM 1-1', 'BSBM', '1', '1'),
('BSIT 1-1', 'BSIT', '1', '1'),
('BSEDUC 2-1', 'BSEDUC', '2', '1'),
('BSEDUC 1-2', 'BSEDUC', '1', '2'),
('BSIT 1-23', 'BSIT', '1', '23'),
('BSEDUC 2-3', 'BSEDUC', '2', '3'),
('BSEDUC 3-3', 'BSEDUC', '3', '3'),
('BSEDUC 4-2', 'BSEDUC', '4', '2'),
('BSEDUC 4-3', 'BSEDUC', '4', '3'),
('BSEDUC 2-4', 'BSEDUC', '2', '4');

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
  `Section ID` varchar(150) NOT NULL,
  `Password` varchar(200) NOT NULL,
  PRIMARY KEY (`Student Number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`Student Number`, `Given Name`, `Middle Name`, `Family Name`, `Address`, `Birthdate`, `Gender`, `Contact Number`, `Email`, `Section ID`, `Password`) VALUES
(18010009, 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'BSIT 2-2', '$2y$10$WF29NCbdHVrhZ071dg3K/u4u7tGIiVzPRAR38rJir9czTegLAb0we');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tasks`
--

DROP TABLE IF EXISTS `tbl_tasks`;
CREATE TABLE IF NOT EXISTS `tbl_tasks` (
  `Task ID` int(11) NOT NULL AUTO_INCREMENT,
  `Handled Course ID` int(11) NOT NULL,
  `Title` varchar(200) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `Content` json NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Dissemination Date` date NOT NULL,
  `Deadline Date` date NOT NULL,
  `Time Limit` int(11) NOT NULL,
  PRIMARY KEY (`Task ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_year_levels`
--

DROP TABLE IF EXISTS `tbl_year_levels`;
CREATE TABLE IF NOT EXISTS `tbl_year_levels` (
  `Year Level ID` int(11) NOT NULL AUTO_INCREMENT,
  `Student Description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Year Level Description` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`Year Level ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_year_levels`
--

INSERT INTO `tbl_year_levels` (`Year Level ID`, `Student Description`, `Year Level Description`) VALUES
(1, 'Freshman', 'First Year'),
(2, 'Sophomore', 'Second Year'),
(3, 'Junior', 'Third Year'),
(4, 'Senior', 'Fourth Year');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
