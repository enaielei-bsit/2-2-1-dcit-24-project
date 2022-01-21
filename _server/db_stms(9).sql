-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 10, 2019 at 10:14 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`Category ID`, `Category Title`) VALUES
(13, 'Long Test'),
(14, 'Multiple Item Quiz'),
(15, 'Activity'),
(16, 'Funny');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categorized_tasks`
--

DROP TABLE IF EXISTS `tbl_categorized_tasks`;
CREATE TABLE IF NOT EXISTS `tbl_categorized_tasks` (
  `Entry ID` int(11) NOT NULL AUTO_INCREMENT,
  `Category ID` int(11) NOT NULL,
  `Task ID` int(11) NOT NULL,
  PRIMARY KEY (`Entry ID`),
  KEY `Category ID` (`Category ID`),
  KEY `Task ID` (`Task ID`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_classes`
--

DROP TABLE IF EXISTS `tbl_classes`;
CREATE TABLE IF NOT EXISTS `tbl_classes` (
  `Class ID` int(11) NOT NULL AUTO_INCREMENT,
  `Handled Course ID` int(11) NOT NULL,
  `Section ID` varchar(100) NOT NULL,
  PRIMARY KEY (`Class ID`),
  KEY `Handled Course ID` (`Handled Course ID`),
  KEY `Section ID` (`Section ID`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_classes`
--

INSERT INTO `tbl_classes` (`Class ID`, `Handled Course ID`, `Section ID`) VALUES
(152, 147, 'BSBM 2-2'),
(153, 147, 'BSBM 2-3'),
(154, 150, 'BSPSYCH 2-2'),
(155, 150, 'BSPSYCH 2-3'),
(156, 150, 'BSPSYCH 2-5');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_class_students`
--

DROP TABLE IF EXISTS `tbl_class_students`;
CREATE TABLE IF NOT EXISTS `tbl_class_students` (
  `Class Student ID` int(11) NOT NULL AUTO_INCREMENT,
  `Class ID` int(11) NOT NULL,
  `Student Number` int(11) NOT NULL,
  PRIMARY KEY (`Class Student ID`),
  KEY `Class ID` (`Class ID`),
  KEY `Student Number` (`Student Number`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

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
  PRIMARY KEY (`Course Code`),
  KEY `Course Creator` (`Course Creator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_courses`
--

INSERT INTO `tbl_courses` (`Course Code`, `Course Category`, `Course Suffix`, `Course Title`, `Course Description`, `Course Type`, `Course Units`, `Course Prerequisites`, `Course Creator`) VALUES
('COSC 50', 'COSC', '50', 'General Mathematics', 'Math is a very interesting Subject. How about General Mathematics?', '[\"Laboratory\", \"Lecture\"]', '2', '[\"ITEC 55\"]', 'nila'),
('DCIT 21', 'DCIT', '21', 'Computer Programming 2', 'Out, I get a lovely view of the bay and a little private wharf belonging to the estate. There is a beautiful shaded lane that runs down there from the house. I always fancy I see people walking in these numerous paths and arbors, but John has cautioned me not to give way to fancy in the least. He says that with my imaginative power and habit of story-making a nervous weakness like mine is sure to lead to all manner of excited fancies and that I ought to use my will and good sense to c', '[\"Laboratory\", \"Lecture\"]', '3', '', 'nila'),
('DCIT 23', 'DCIT', '23', 'Computer Programming 2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', '[\"Laboratory\", \"Lecture\"]', '3', '', 'nila'),
('DCIT 24', 'DCIT', '24', 'Computer Programming 7', '2', '[\"Laboratory\"]', '3', '', 'floica'),
('DCIT 25', 'DCIT', '25', 'Fine Dining', 'A Fine Course', '[\"Laboratory\"]', '3', '[\"DCIT 21\",\"DCIT 23\"]', 'nila'),
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
  PRIMARY KEY (`Username`),
  KEY `tbl_educators_ibfk_1` (`Department ID`)
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
  PRIMARY KEY (`Handled Course ID`),
  KEY `Handler Username` (`Handler Username`),
  KEY `Course Code` (`Course Code`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_handled_courses`
--

INSERT INTO `tbl_handled_courses` (`Handled Course ID`, `Course Code`, `Handler Username`) VALUES
(147, 'COSC 50', 'nila'),
(150, 'DCIT 25', 'nila');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

DROP TABLE IF EXISTS `tbl_notifications`;
CREATE TABLE IF NOT EXISTS `tbl_notifications` (
  `Notification ID` int(11) NOT NULL AUTO_INCREMENT,
  `Handled Course ID` int(11) NOT NULL,
  `Task ID` int(11) NOT NULL,
  `Notification Type` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sender ID` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`Notification ID`),
  KEY `Handled Course ID` (`Handled Course ID`),
  KEY `Task ID` (`Task ID`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`Notification ID`, `Handled Course ID`, `Task ID`, `Notification Type`, `Sender ID`) VALUES
(25, 147, 0, 'join', '18010009'),
(26, 147, 0, 'join', '18010009'),
(27, 147, 50, 'task', 'nila'),
(28, 147, 51, 'task', 'nila'),
(29, 147, 0, 'join', '18010009'),
(30, 150, 0, 'join', '18010009');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification_entries`
--

DROP TABLE IF EXISTS `tbl_notification_entries`;
CREATE TABLE IF NOT EXISTS `tbl_notification_entries` (
  `Entry ID` int(11) NOT NULL AUTO_INCREMENT,
  `Notification ID` int(11) NOT NULL,
  `Class ID` int(11) NOT NULL,
  `Receiver ID` varchar(300) NOT NULL,
  `Seen` tinyint(1) NOT NULL,
  `Accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`Entry ID`),
  KEY `Notification ID` (`Notification ID`),
  KEY `Class ID` (`Class ID`)
) ENGINE=InnoDB AUTO_INCREMENT=323 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_notification_entries`
--

INSERT INTO `tbl_notification_entries` (`Entry ID`, `Notification ID`, `Class ID`, `Receiver ID`, `Seen`, `Accepted`) VALUES
(321, 29, 152, 'nila', 0, 0),
(322, 30, 155, 'nila', 0, 0);

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
  `Year Level ID` int(11) NOT NULL,
  `Section Number` varchar(10) NOT NULL,
  PRIMARY KEY (`Section ID`),
  KEY `Program ID` (`Program ID`),
  KEY `Year Level ID` (`Year Level ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_sections`
--

INSERT INTO `tbl_sections` (`Section ID`, `Program ID`, `Year Level ID`, `Section Number`) VALUES
('BSBM 2-2', 'BSBM', 2, '2'),
('BSBM 2-3', 'BSBM', 2, '3'),
('BSIT 2-2', 'BSIT', 2, '2'),
('BSPSYCH 2-2', 'BSPSYCH', 2, '2'),
('BSPSYCH 2-3', 'BSPSYCH', 2, '3'),
('BSPSYCH 2-5', 'BSPSYCH', 2, '5');

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
  `Section ID` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Password` varchar(200) NOT NULL,
  PRIMARY KEY (`Student Number`),
  KEY `Section ID` (`Section ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`Student Number`, `Given Name`, `Middle Name`, `Family Name`, `Address`, `Birthdate`, `Gender`, `Contact Number`, `Email`, `Section ID`, `Password`) VALUES
(18010009, 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'BSIT 2-2', '$2y$10$e4f7V/eyPktBxYUA/A.sLuEJwLUVHu6qTYo/osTg6AK91rHLP/T0W');

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
  `Item Count` int(11) NOT NULL,
  `Total Points` int(11) NOT NULL,
  `Content` json NOT NULL,
  `Disseminated` tinyint(1) NOT NULL,
  `Closed` tinyint(1) NOT NULL,
  `Timed` tinyint(1) NOT NULL,
  `Dissemination Date` datetime NOT NULL,
  `Deadline Date` datetime NOT NULL,
  `Time Limit` int(11) NOT NULL,
  PRIMARY KEY (`Task ID`),
  KEY `Handled Course ID` (`Handled Course ID`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_year_levels`
--

INSERT INTO `tbl_year_levels` (`Year Level ID`, `Student Description`, `Year Level Description`) VALUES
(1, 'Freshman', 'First Year'),
(2, 'Sophomore', 'Second Year'),
(3, 'Junior', 'Third Year'),
(4, 'Senior', 'Fourth Year');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_categorized_tasks`
--
ALTER TABLE `tbl_categorized_tasks`
  ADD CONSTRAINT `tbl_categorized_tasks_ibfk_1` FOREIGN KEY (`Category ID`) REFERENCES `tbl_categories` (`Category ID`),
  ADD CONSTRAINT `tbl_categorized_tasks_ibfk_2` FOREIGN KEY (`Task ID`) REFERENCES `tbl_tasks` (`Task ID`);

--
-- Constraints for table `tbl_classes`
--
ALTER TABLE `tbl_classes`
  ADD CONSTRAINT `tbl_classes_ibfk_1` FOREIGN KEY (`Section ID`) REFERENCES `tbl_sections` (`Section ID`),
  ADD CONSTRAINT `tbl_classes_ibfk_2` FOREIGN KEY (`Handled Course ID`) REFERENCES `tbl_handled_courses` (`Handled Course ID`);

--
-- Constraints for table `tbl_class_students`
--
ALTER TABLE `tbl_class_students`
  ADD CONSTRAINT `tbl_class_students_ibfk_1` FOREIGN KEY (`Class ID`) REFERENCES `tbl_classes` (`Class ID`),
  ADD CONSTRAINT `tbl_class_students_ibfk_2` FOREIGN KEY (`Student Number`) REFERENCES `tbl_students` (`Student Number`);

--
-- Constraints for table `tbl_courses`
--
ALTER TABLE `tbl_courses`
  ADD CONSTRAINT `tbl_courses_ibfk_1` FOREIGN KEY (`Course Creator`) REFERENCES `tbl_educators` (`Username`);

--
-- Constraints for table `tbl_educators`
--
ALTER TABLE `tbl_educators`
  ADD CONSTRAINT `tbl_educators_ibfk_1` FOREIGN KEY (`Department ID`) REFERENCES `tbl_departments` (`Department ID`);

--
-- Constraints for table `tbl_handled_courses`
--
ALTER TABLE `tbl_handled_courses`
  ADD CONSTRAINT `tbl_handled_courses_ibfk_1` FOREIGN KEY (`Course Code`) REFERENCES `tbl_courses` (`Course Code`),
  ADD CONSTRAINT `tbl_handled_courses_ibfk_2` FOREIGN KEY (`Handler Username`) REFERENCES `tbl_educators` (`Username`);

--
-- Constraints for table `tbl_notifications`
--
ALTER TABLE `tbl_notifications`
  ADD CONSTRAINT `tbl_notifications_ibfk_1` FOREIGN KEY (`Handled Course ID`) REFERENCES `tbl_handled_courses` (`Handled Course ID`),
  ADD CONSTRAINT `tbl_notifications_ibfk_2` FOREIGN KEY (`Task ID`) REFERENCES `tbl_tasks` (`Task ID`);

--
-- Constraints for table `tbl_notification_entries`
--
ALTER TABLE `tbl_notification_entries`
  ADD CONSTRAINT `tbl_notification_entries_ibfk_1` FOREIGN KEY (`Notification ID`) REFERENCES `tbl_notifications` (`Notification ID`),
  ADD CONSTRAINT `tbl_notification_entries_ibfk_2` FOREIGN KEY (`Class ID`) REFERENCES `tbl_classes` (`Class ID`);

--
-- Constraints for table `tbl_sections`
--
ALTER TABLE `tbl_sections`
  ADD CONSTRAINT `tbl_sections_ibfk_1` FOREIGN KEY (`Program ID`) REFERENCES `tbl_programs` (`Program ID`),
  ADD CONSTRAINT `tbl_sections_ibfk_2` FOREIGN KEY (`Year Level ID`) REFERENCES `tbl_year_levels` (`Year Level ID`);

--
-- Constraints for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `tbl_students_ibfk_1` FOREIGN KEY (`Section ID`) REFERENCES `tbl_sections` (`Section ID`);

--
-- Constraints for table `tbl_tasks`
--
ALTER TABLE `tbl_tasks`
  ADD CONSTRAINT `tbl_tasks_ibfk_1` FOREIGN KEY (`Handled Course ID`) REFERENCES `tbl_handled_courses` (`Handled Course ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
