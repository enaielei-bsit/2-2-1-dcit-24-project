-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 17, 2019 at 12:14 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`Category ID`, `Category Title`) VALUES
(13, 'Long Test'),
(14, 'Multiple Item Quiz'),
(15, 'Activity'),
(16, 'Funny'),
(17, 'Final Examination'),
(18, '75-points'),
(19, '25-points'),
(20, 'Multiple-Item Seatwork'),
(21, '10-points'),
(22, 'Short Quiz');

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
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_categorized_tasks`
--

INSERT INTO `tbl_categorized_tasks` (`Entry ID`, `Category ID`, `Task ID`) VALUES
(126, 17, 54),
(127, 18, 54),
(128, 15, 54),
(129, 19, 55),
(130, 20, 55),
(131, 19, 56),
(132, 15, 56),
(133, 18, 56),
(134, 14, 57),
(135, 15, 58),
(136, 21, 58),
(139, 14, 60),
(140, 22, 60);

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
) ENGINE=InnoDB AUTO_INCREMENT=172 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_classes`
--

INSERT INTO `tbl_classes` (`Class ID`, `Handled Course ID`, `Section ID`) VALUES
(164, 152, 'BSEDUC 2-2'),
(165, 152, 'BSIT 2-2'),
(166, 152, 'BSCRIM 2-2'),
(167, 152, 'BSEDUC 2-1'),
(168, 153, 'BSIT 2-2'),
(169, 154, 'BSIT 2-2'),
(170, 154, 'BSCS 2-2'),
(171, 152, 'BSIT 2-3');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_class_students`
--

INSERT INTO `tbl_class_students` (`Class Student ID`, `Class ID`, `Student Number`) VALUES
(8, 165, 18010010),
(9, 168, 18010010),
(10, 165, 18010009),
(11, 169, 18010009);

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
('CSOC 50', 'CSOC', '50', 'General Mathematics', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', '[\"Lecture\"]', '2', '', 'DCS-1234'),
('DCIT 21', 'DCIT', '21', 'Information Management', 'A course that tackles about Computers. \"Computer\'s a Friend.\"', '[\"Laboratory\", \"Lecture\"]', '3', '', 'DCS-1234'),
('ITEC 55', 'ITEC', '55', 'Platform Technologies', '\"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.\"', '[\"Laboratory\", \"Lecture\"]', '3', '[\"DCIT 21\"]', 'DCS-1234');

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
('DCS-1234', 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Pr', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'DCS', '$2y$10$qZAmtQRZLFLgOm4x2OuePuxFk//frwVS86cOjOJGNgSk8b2umDa/m');

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
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_handled_courses`
--

INSERT INTO `tbl_handled_courses` (`Handled Course ID`, `Course Code`, `Handler Username`) VALUES
(152, 'DCIT 21', 'DCS-1234'),
(153, 'CSOC 50', 'DCS-1234'),
(154, 'ITEC 55', 'DCS-1234');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifications`
--

DROP TABLE IF EXISTS `tbl_notifications`;
CREATE TABLE IF NOT EXISTS `tbl_notifications` (
  `Notification ID` int(11) NOT NULL AUTO_INCREMENT,
  `Handled Course ID` int(11) NOT NULL,
  `Task ID` int(11) DEFAULT NULL,
  `Notification Type` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `Sender ID` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`Notification ID`),
  KEY `Handled Course ID` (`Handled Course ID`),
  KEY `Task ID` (`Task ID`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_notifications`
--

INSERT INTO `tbl_notifications` (`Notification ID`, `Handled Course ID`, `Task ID`, `Notification Type`, `Sender ID`) VALUES
(48, 152, 0, 'task', 'DCS-1234'),
(49, 152, 1, 'join', '18010010'),
(50, 153, 1, 'join', '18010010'),
(51, 152, 0, 'task', 'DCS-1234'),
(52, 153, 0, 'task', 'DCS-1234'),
(53, 154, 0, 'task', 'DCS-1234'),
(54, 152, 1, 'join', '18010009'),
(55, 154, 1, 'join', '18010009'),
(56, 154, 1, 'join', '18010009'),
(57, 152, 0, 'task', 'DCS-1234'),
(58, 152, 0, 'task', 'DCS-1234'),
(59, 152, 0, 'task', 'DCS-1234');

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
) ENGINE=InnoDB AUTO_INCREMENT=362 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_notification_entries`
--

INSERT INTO `tbl_notification_entries` (`Entry ID`, `Notification ID`, `Class ID`, `Receiver ID`, `Seen`, `Accepted`) VALUES
(343, 49, 165, 'DCS-1234', 0, 1),
(344, 48, 165, '18010010', 0, 0),
(345, 50, 168, 'DCS-1234', 0, 1),
(346, 51, 165, '18010010', 0, 0),
(347, 52, 168, '18010010', 0, 0),
(348, 54, 165, 'DCS-1234', 0, 1),
(349, 48, 165, '18010009', 0, 0),
(350, 51, 165, '18010009', 0, 0),
(352, 56, 169, 'DCS-1234', 0, 1),
(353, 53, 169, '18010009', 0, 0),
(354, 57, 165, '18010010', 0, 0),
(355, 57, 165, '18010009', 0, 0),
(356, 58, 165, '18010010', 0, 0),
(357, 58, 165, '18010009', 0, 0),
(358, 59, 165, '18010010', 0, 0),
(359, 59, 165, '18010010', 0, 0),
(360, 59, 165, '18010009', 0, 0),
(361, 59, 165, '18010009', 0, 0);

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
('BSBM 4-3', 'BSBM', 4, '3'),
('BSCRIM 2-2', 'BSCRIM', 2, '2'),
('BSCS 2-2', 'BSCS', 2, '2'),
('BSCS 4-1', 'BSCS', 4, '1'),
('BSEDUC 1-2', 'BSEDUC', 1, '2'),
('BSEDUC 2-1', 'BSEDUC', 2, '1'),
('BSEDUC 2-2', 'BSEDUC', 2, '2'),
('BSEDUC 4-2', 'BSEDUC', 4, '2'),
('BSIT 2-1', 'BSIT', 2, '1'),
('BSIT 2-2', 'BSIT', 2, '2'),
('BSIT 2-3', 'BSIT', 2, '3'),
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
(18010009, 'Nommel Isanar', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1999-10-02', 'Male', '9984626403', 'ni.amolat@gmail.com', 'BSIT 2-2', '$2y$10$e4f7V/eyPktBxYUA/A.sLuEJwLUVHu6qTYo/osTg6AK91rHLP/T0W'),
(18010010, 'Floica', 'Lavapie', 'Amolat', 'Block 3 Lot 5, Silver Street, Camella North Springville, Barangay Molino III, Bacoor City, Cavite Province', '1994-09-26', 'Female', '9984626403', 'ni.amolat@gmail.com', 'BSCS 4-1', '$2y$10$hBDezTjJV4qJ5qdY0yYE2.A7ihY1PEXo5Y82alJhVJFEsAYevnvYO');

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
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_tasks`
--

INSERT INTO `tbl_tasks` (`Task ID`, `Handled Course ID`, `Title`, `Description`, `Item Count`, `Total Points`, `Content`, `Disseminated`, `Closed`, `Timed`, `Dissemination Date`, `Deadline Date`, `Time Limit`) VALUES
(54, 152, 'Final Exam', 'This is our final examination for the School\'s current semester. \"Computer\'s a Friend.\"', 2, 75, '{\"item_1\": {\"point\": \"40\", \"choice_1\": \"Bill Gates\", \"choice_2\": \"Steve Jobs\", \"question\": \"Who is the founder of Microsoft?\", \"correct_choice\": \"choice_1\"}, \"item_2\": {\"point\": \"35\", \"choice_1\": \"Bill Gates\", \"choice_2\": \"Steve Jobs\", \"question\": \"Who is the founder of Apple?\", \"correct_choice\": \"choice_2\"}}', 1, 0, 1, '2019-12-15 17:03:00', '2019-12-17 03:00:00', 2),
(55, 152, 'Seatwork 1', 'A quick set of questions for yesterday\'s lesson.', 2, 35, '{\"item_1\": {\"point\": \"15\", \"choice_1\": \"saf\", \"choice_2\": \"asf\", \"choice_3\": \"saf\", \"question\": \"gggggggggddddd\", \"correct_choice\": \"choice_3\"}, \"item_2\": {\"point\": \"20\", \"choice_1\": \"asdasd\", \"choice_2\": \"233\", \"question\": \"sadasd\", \"correct_choice\": \"choice_1\"}}', 1, 0, 1, '2019-12-15 17:26:00', '2019-12-15 20:25:00', 3),
(56, 153, 'Math-Think', 'A challenging problems for you guys.', 2, 25, '{\"item_1\": {\"point\": \"20\", \"choice_1\": \"3\", \"choice_2\": \"5\", \"question\": \"1 + 2\", \"correct_choice\": \"choice_1\"}, \"item_2\": {\"point\": \"5\", \"choice_1\": \"-1\", \"choice_2\": \"0\", \"question\": \"0 - 1\", \"correct_choice\": \"choice_1\"}}', 1, 0, 1, '2019-12-15 17:41:00', '2019-12-15 20:40:00', 3),
(57, 154, 'Quiz 2', 'A short quiz.', 1, 5, '{\"item_1\": {\"point\": \"5\", \"choice_1\": \"CPU\", \"choice_2\": \"Motherboard\", \"question\": \"What is the brain of the computer?\", \"correct_choice\": \"choice_1\"}}', 1, 0, 1, '2019-12-15 17:45:00', '2019-12-15 20:45:00', 3),
(58, 152, 'Activity 2', 'A very very short Activity for my Beloved Students.', 2, 10, '{\"item_1\": {\"point\": \"5\", \"choice_1\": \"A machine.\", \"choice_2\": \"A very interesting object.\", \"choice_3\": \"A tool for destruction.\", \"question\": \"What is Computer?\", \"correct_choice\": \"choice_1\"}, \"item_2\": {\"point\": \"5\", \"choice_1\": \"Central Processor Unit\", \"choice_2\": \"Central Power Unit\", \"choice_3\": \"Centered Processing Unit\", \"choice_4\": \"Concise Power Unit\", \"question\": \"What is the meaning of CPU?\", \"correct_choice\": \"choice_1\"}}', 1, 0, 1, '2019-12-16 17:22:00', '2019-12-16 20:20:00', 2),
(60, 152, 'Quiz 1', 'This is our first quiz for this semester for this academic year.', 10, 31, '{\"item_1\": {\"point\": \"1\", \"choice_1\": \"Complementary Metal Oxide Semi-Conductor\", \"choice_2\": \"Complementary Mental Oxide Semi-Conductor\", \"choice_3\": \"Complementary Metal Oxygenated Semi-Conductive\", \"choice_4\": \"Complementary Metal Oxide Semi-Conductive\", \"question\": \"Meaning of CMOS.\", \"correct_choice\": \"choice_1\"}, \"item_2\": {\"point\": \"3\", \"choice_1\": \"MOBO, CPU, HDD\", \"choice_2\": \"MOBO, PSU, HDD\", \"choice_3\": \"MOBO, PSU, Chassis\", \"choice_4\": \"MOBO, RAM, CPU\", \"question\": \"Parts of the System Unit that must have the same form factors.\", \"correct_choice\": \"choice_3\"}, \"item_3\": {\"point\": \"2\", \"choice_1\": \"True\", \"choice_2\": \"False\", \"question\": \"Is SSD faster than HDD? True or False.\", \"correct_choice\": \"choice_1\"}, \"item_4\": {\"point\": \"5\", \"choice_1\": \"Asus and Intel\", \"choice_2\": \"Intel and Gigabyte\", \"choice_3\": \"Intel and AMD\", \"choice_4\": \"AMD and Nvidia\", \"question\": \"What are the two Companies that are well-known for their Graphics Cards?\", \"correct_choice\": \"choice_4\"}, \"item_5\": {\"point\": \"2\", \"choice_1\": \"True\", \"choice_2\": \"False\", \"question\": \"Does AMD provide CPUs? True or False.\", \"correct_choice\": \"choice_1\"}, \"item_6\": {\"point\": \"2\", \"choice_1\": \"True\", \"choice_2\": \"False\", \"question\": \"Bill Gates is the founder of Apple? True or False.\", \"correct_choice\": \"choice_2\"}, \"item_7\": {\"point\": \"3\", \"choice_1\": \"Firefox, Chrome, Gmail\", \"choice_2\": \"Blender, Unity, Unreal\", \"choice_3\": \"Internet Explorer, Chrome, Edge\", \"choice_4\": \"Firefox, Chrome, Outlook\", \"question\": \"What from the following set of choices are sets of internet browsers?\", \"correct_choice\": \"choice_3\"}, \"item_8\": {\"point\": \"5\", \"choice_1\": \"Windows 1.0\", \"choice_2\": \"Windows 10\", \"choice_3\": \"Windows Beta\", \"choice_4\": \"Windows v0.0.56\", \"question\": \"What is the first version of Windows?\", \"correct_choice\": \"choice_1\"}, \"item_9\": {\"point\": \"3\", \"choice_1\": \"Bill Gates\", \"choice_2\": \"Steve Jobs\", \"choice_3\": \"Elon Musk\", \"choice_4\": \"Tony Stark\", \"question\": \"Who is the founder of Microsoft?\", \"correct_choice\": \"choice_1\"}, \"item_10\": {\"point\": \"5\", \"choice_1\": \"Oreo\", \"choice_2\": \"Gingerbread\", \"choice_3\": \"Ice Cream Sandwich\", \"choice_4\": \"Pie\", \"question\": \"What is the latest version of Android that is available in public?\", \"correct_choice\": \"choice_4\"}}', 1, 0, 1, '2019-12-17 02:28:00', '2019-12-18 05:15:00', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_task_entries`
--

DROP TABLE IF EXISTS `tbl_task_entries`;
CREATE TABLE IF NOT EXISTS `tbl_task_entries` (
  `Task Entry ID` int(11) NOT NULL AUTO_INCREMENT,
  `Task ID` int(11) NOT NULL,
  `Class Student ID` int(11) NOT NULL,
  `Answer Content` json DEFAULT NULL,
  `Right Answers` int(11) DEFAULT NULL,
  `Wrong Answers` int(11) DEFAULT NULL,
  `Time Remaining` int(11) DEFAULT NULL,
  `Score` int(11) NOT NULL,
  `Submitted` tinyint(4) NOT NULL,
  PRIMARY KEY (`Task Entry ID`),
  KEY `Task ID` (`Task ID`),
  KEY `Class Student ID` (`Class Student ID`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_task_entries`
--

INSERT INTO `tbl_task_entries` (`Task Entry ID`, `Task ID`, `Class Student ID`, `Answer Content`, `Right Answers`, `Wrong Answers`, `Time Remaining`, `Score`, `Submitted`) VALUES
(9, 54, 8, '{\"item_1\": {\"answered_choice\": \"choice_1\"}}', 0, 0, NULL, 0, 0),
(10, 54, 10, '{\"item_1\": {\"answered_choice\": \"choice_1\"}, \"item_2\": {\"answered_choice\": \"choice_1\"}}', 1, 1, NULL, 40, 1),
(11, 55, 8, '{\"item_1\": {\"answered_choice\": \"choice_1\"}}', 0, 0, NULL, 0, 0),
(12, 55, 10, '{\"item_1\": {\"answered_choice\": \"choice_1\"}}', 0, 0, NULL, 0, 0),
(13, 56, 9, '{\"item_1\": {\"answered_choice\": \"choice_1\"}}', 0, 0, NULL, 0, 0),
(14, 57, 11, '{\"item_1\": {\"answered_choice\": \"choice_1\"}}', 1, 0, NULL, 0, 1),
(15, 58, 8, '{\"item_1\": {\"answered_choice\": \"choice_1\"}}', 0, 0, NULL, 0, 0),
(16, 58, 10, '{\"item_1\": {\"answered_choice\": \"choice_1\"}}', 0, 0, NULL, 0, 0),
(17, 60, 8, NULL, NULL, NULL, NULL, 0, 0),
(18, 60, 10, '{\"item_1\": {\"answered_choice\": \"choice_2\"}, \"item_2\": {\"answered_choice\": \"choice_3\"}, \"item_3\": {\"answered_choice\": \"choice_2\"}, \"item_4\": {\"answered_choice\": \"choice_4\"}, \"item_5\": {\"answered_choice\": \"choice_1\"}, \"item_6\": {\"answered_choice\": \"choice_2\"}, \"item_7\": {\"answered_choice\": \"choice_3\"}, \"item_8\": {\"answered_choice\": \"choice_1\"}, \"item_9\": {\"answered_choice\": \"choice_1\"}, \"item_10\": {\"answered_choice\": \"choice_4\"}}', 8, 2, NULL, 28, 1);

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

--
-- Constraints for table `tbl_task_entries`
--
ALTER TABLE `tbl_task_entries`
  ADD CONSTRAINT `tbl_task_entries_ibfk_1` FOREIGN KEY (`Task ID`) REFERENCES `tbl_tasks` (`Task ID`),
  ADD CONSTRAINT `tbl_task_entries_ibfk_2` FOREIGN KEY (`Class Student ID`) REFERENCES `tbl_class_students` (`Class Student ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
