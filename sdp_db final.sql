-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 08, 2023 at 05:12 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance_records`
--

DROP TABLE IF EXISTS `attendance_records`;
CREATE TABLE IF NOT EXISTS `attendance_records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `date` date NOT NULL,
  `attendance_status` enum('Absent','Present') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance_records`
--

INSERT INTO `attendance_records` (`id`, `class_code`, `start_time`, `end_time`, `date`, `attendance_status`, `code`) VALUES
(55, 'Account', '23:47:00', '12:46:00', '2023-08-04', 'Absent', 916),
(54, 'Science', '12:38:00', '23:38:00', '2023-08-04', 'Absent', 350),
(52, 'Math', '12:34:00', '12:34:00', '2023-08-01', 'Absent', 757),
(56, 'Account', '11:51:00', '02:55:00', '2023-08-11', 'Absent', 498),
(57, 'Math', '06:18:00', '08:18:00', '2023-08-31', 'Present', 928),
(58, 'MAMA', '11:06:00', '01:04:00', '2023-09-20', 'Present', 266),
(59, 'TEST 7pm', '00:00:00', '00:00:00', '2023-09-08', 'Absent', 489);

-- --------------------------------------------------------

--
-- Table structure for table `bus_t`
--

DROP TABLE IF EXISTS `bus_t`;
CREATE TABLE IF NOT EXISTS `bus_t` (
  `no` int NOT NULL AUTO_INCREMENT,
  `bus_id` varchar(25) NOT NULL,
  `bus_driver` varchar(25) NOT NULL,
  `bus_dt` time NOT NULL,
  `bus_dl` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bus_des` varchar(50) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bus_t`
--

INSERT INTO `bus_t` (`no`, `bus_id`, `bus_driver`, `bus_dt`, `bus_dl`, `bus_des`) VALUES
(1, 'B001', 'Ian', '08:00:00', 'LRT Taman Emas', 'Pallas University'),
(2, 'B001', 'Ian', '08:30:00', 'Pallas University', 'LRT Taman Emas'),
(3, 'B002', 'Vinn', '08:00:00', 'MRT Taman Bunga', 'Pallas University'),
(4, 'B002', 'Vinn', '08:30:00', 'Pallas University', 'MRT Taman Bunga'),
(5, 'B003', 'Ray', '08:00:00', 'Tioman Park', 'Pallas University'),
(6, 'B003', 'Ray', '08:30:00', 'Pallas University', 'Tioman Park'),
(10, 'B001', 'Ian', '09:30:00', 'Pallas University', 'LRT Taman Emas'),
(9, 'B001', 'Ian', '09:00:00', 'LRT Taman Emas', 'Pallas University');

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
CREATE TABLE IF NOT EXISTS `cards` (
  `id` int NOT NULL AUTO_INCREMENT,
  `card_id` varchar(255) NOT NULL,
  `u_id` int NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `u_id` (`u_id`),
  KEY `u_id_2` (`u_id`),
  KEY `u_id_3` (`u_id`),
  KEY `card_id` (`card_id`,`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `card_id`, `u_id`, `balance`) VALUES
(1, 'L0001', 271, '3.00'),
(2, 'TP066529', 270, '136.00'),
(3, 'L0002', 275, '23.00'),
(4, 'ADMIN', 1, '204.00'),
(5, 'L0003', 277, '50.00'),
(6, 'TP1234', 276, '46.60'),
(7, 'TP0001', 278, '16.00');

-- --------------------------------------------------------

--
-- Table structure for table `classrooms`
--

DROP TABLE IF EXISTS `classrooms`;
CREATE TABLE IF NOT EXISTS `classrooms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `start_hour` int NOT NULL,
  `start_minute` int NOT NULL,
  `end_hour` int NOT NULL,
  `end_minute` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `classrooms`
--

INSERT INTO `classrooms` (`id`, `name`, `start_hour`, `start_minute`, `end_hour`, `end_minute`) VALUES
(16, 'Classroom1', 8, 30, 10, 30),
(18, 'Classroom3', 14, 30, 16, 30),
(17, 'Classroom2', 10, 30, 12, 30),
(19, 'Classroom4', 16, 30, 18, 30),
(20, 'Classroom5', 9, 45, 11, 45),
(21, 'Classroom6', 12, 45, 14, 45),
(22, 'Classroom7', 11, 45, 13, 45);

-- --------------------------------------------------------

--
-- Table structure for table `courses_t`
--

DROP TABLE IF EXISTS `courses_t`;
CREATE TABLE IF NOT EXISTS `courses_t` (
  `c_id` int NOT NULL AUTO_INCREMENT,
  `c_name` varchar(250) NOT NULL,
  `c_code` varchar(250) NOT NULL,
  `c_lname` varchar(250) NOT NULL,
  `c_assignments` varchar(250) NOT NULL,
  `c_exams` varchar(250) NOT NULL,
  `c_pic` text NOT NULL,
  `c_adate` date NOT NULL,
  `c_edate` date NOT NULL,
  `c_cdate` date NOT NULL,
  `c_intake` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `c_programme` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `c_description` varchar(225) NOT NULL,
  PRIMARY KEY (`c_id`),
  KEY `c_name` (`c_name`,`c_code`,`c_lname`),
  KEY `courses_t_ibfk_1` (`c_lname`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses_t`
--

INSERT INTO `courses_t` (`c_id`, `c_name`, `c_code`, `c_lname`, `c_assignments`, `c_exams`, `c_pic`, `c_adate`, `c_edate`, `c_cdate`, `c_intake`, `c_programme`, `c_description`) VALUES
(46, 'Instrumentation and Measurement ', 'INM320-062023', 'Shaun Tan', 'Chapter 1', 'R1 Measuring Units', 'uploads/apu_still01_entrance_0-1.jpg', '2023-11-06', '2023-09-27', '2023-12-06', '', '', ''),
(49, 'English For Academic Purposes', 'EAP12345679ICT', 'Goh Kwan Keat', 'Essay Writing', 'EAP Final Exam', 'uploads/amimir.png', '2023-09-12', '2023-09-05', '2023-09-20', '123', '213', 'English'),
(50, 'Financial Accounting ', 'FA601-062023', 'Chow Ai Ren', 'Accounting Tutorial Chapter 5', 'FA Final Exam', 'uploads/apu_logo.png', '2023-09-29', '2023-09-28', '2023-08-06', 'DIP6098ACT', 'Diploma in Accounting', 'Financial Accounting by Mdm. Chow ');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_t`
--

DROP TABLE IF EXISTS `feedback_t`;
CREATE TABLE IF NOT EXISTS `feedback_t` (
  `fb_id` int NOT NULL AUTO_INCREMENT,
  `u_id` int NOT NULL,
  `fb_description` longtext NOT NULL,
  PRIMARY KEY (`fb_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `feedback_t`
--

INSERT INTO `feedback_t` (`fb_id`, `u_id`, `fb_description`) VALUES
(240, 270, 'I found a lost Palcard on my way to the dorms, where do I need to go to pass this to the admin?');

-- --------------------------------------------------------

--
-- Table structure for table `fees_t`
--

DROP TABLE IF EXISTS `fees_t`;
CREATE TABLE IF NOT EXISTS `fees_t` (
  `f_id` int NOT NULL AUTO_INCREMENT,
  `s_id` varchar(255) NOT NULL,
  `f_total` decimal(20,2) NOT NULL,
  `f_paid` decimal(20,2) NOT NULL,
  `f_pending` decimal(20,2) NOT NULL,
  PRIMARY KEY (`f_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fees_t`
--

INSERT INTO `fees_t` (`f_id`, `s_id`, `f_total`, `f_paid`, `f_pending`) VALUES
(6, 'TP066529', '10000.00', '0.00', '10000.00'),
(7, 'TP1234', '20.00', '11.00', '9.00');

-- --------------------------------------------------------

--
-- Table structure for table `lecturer_t`
--

DROP TABLE IF EXISTS `lecturer_t`;
CREATE TABLE IF NOT EXISTS `lecturer_t` (
  `l_id` varchar(255) NOT NULL,
  `l_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `l_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `l_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `l_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`l_id`),
  KEY `l_email` (`l_email`),
  KEY `l_name` (`l_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `lecturer_t`
--

INSERT INTO `lecturer_t` (`l_id`, `l_email`, `l_password`, `l_name`, `l_image`) VALUES
('L0001', 'lec@gmail.com', '123', 'Shaun Tan', 'uploads/@E898N ikeee.jpg'),
('L0002', 'lec1@gmail.com', '123', 'Goh Kwan Keat', 'uploads/apu_logo.png'),
('L0003', 'lec2@gmail.com', '123', 'Chow Ai Ren', 'uploads/apu_still01_entrance_0-1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `news_t`
--

DROP TABLE IF EXISTS `news_t`;
CREATE TABLE IF NOT EXISTS `news_t` (
  `n_id` int NOT NULL AUTO_INCREMENT,
  `n_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `n_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `n_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `n_date` date NOT NULL,
  `n_time` time NOT NULL,
  `n_location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`n_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news_t`
--

INSERT INTO `news_t` (`n_id`, `n_image`, `n_title`, `n_description`, `n_date`, `n_time`, `n_location`) VALUES
(1, 'newsupload/amimir.png', 'Amimir Competition', 'Welcome to Pallas University\'s Grand Amimir Competition where contestants will compete to see who is the greatest at sleeping!! A total prize of RM1000 is available for the TOP 3 winners.', '2023-12-05', '01:00:00', 'Atrium of Pallas University'),
(2, 'newsupload/catlove.jpg', 'Cat Exhibition', 'Are you an average cat enthusiast? Welcome to Pallas University\'s Cat Love Exhibition where you can interact with over 50 different cats.\r\nThis event allows you to pet, feed, as well as take pictures with all the cats!!\r\nWhat are you waiting for? Register now!', '2023-10-10', '13:00:00', 'Atrium'),
(3, 'newsupload/merdeka.jpg', 'Hari Merdeka', 'Hari Merdeka, also known as National Day, marks the Day of Independence of Malaysia in the year 1956. Celebrate this day with your friends and family by singing the National Anthem, wear traditional costumes, wave the Jalur Gemilang and so on.', '2023-08-31', '00:00:00', '-'),
(11, 'newsupload/apu_still01_entrance_0-1.jpg', 'Bagus School', 'Bagus School just newly openned in Technology Park! Come and visit us for more info.', '2023-09-28', '20:56:00', 'Technology Park, Bukit Jalil'),
(13, 'newsupload/panchoooo.png', 'Pancho', 'Pancho has arrive at campus!! Come and pay your respects to him :)', '2023-09-14', '09:00:00', 'Lobby');

-- --------------------------------------------------------

--
-- Table structure for table `result_t`
--

DROP TABLE IF EXISTS `result_t`;
CREATE TABLE IF NOT EXISTS `result_t` (
  `r_id` int NOT NULL AUTO_INCREMENT,
  `r_s_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `r_c_name` varchar(255) NOT NULL,
  `r_grade` char(5) NOT NULL,
  `r_gpa` decimal(5,2) NOT NULL,
  `r_cgpa` decimal(5,2) NOT NULL,
  `r_status` enum('Pass','Fail') NOT NULL,
  `r_semester` int NOT NULL,
  `r_date` date NOT NULL,
  PRIMARY KEY (`r_id`),
  KEY `r_s_name` (`r_s_id`,`r_c_name`),
  KEY `r_c_name` (`r_c_name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `result_t`
--

INSERT INTO `result_t` (`r_id`, `r_s_id`, `r_c_name`, `r_grade`, `r_gpa`, `r_cgpa`, `r_status`, `r_semester`, `r_date`) VALUES
(4, 'TP066529', 'English For Academic Purposes', 'F', '0.00', '0.00', 'Fail', 2, '2023-09-28'),
(5, 'TP066529', 'Instrumentation and Measurement ', 'A', '3.40', '3.40', 'Pass', 2, '2023-09-27'),
(6, 'TP066529', 'Instrumentation and Measurement ', 'B', '3.40', '3.40', 'Pass', 2, '2023-09-27'),
(7, 'TP1234', 'English For Academic Purposes', 'A', '0.00', '0.01', 'Pass', 2, '2023-10-04'),
(9, 'TP1234', 'Financial Accounting ', 'A', '3.70', '3.70', 'Pass', 3, '2023-09-20');

-- --------------------------------------------------------

--
-- Table structure for table `students_t`
--

DROP TABLE IF EXISTS `students_t`;
CREATE TABLE IF NOT EXISTS `students_t` (
  `s_id` varchar(255) NOT NULL,
  `s_email` varchar(255) NOT NULL,
  `s_password` varchar(255) NOT NULL,
  `s_name` varchar(255) NOT NULL,
  `s_image` varchar(500) NOT NULL,
  `s_intake` varchar(255) NOT NULL,
  `s_programme` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`s_id`),
  KEY `s_email` (`s_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students_t`
--

INSERT INTO `students_t` (`s_id`, `s_email`, `s_password`, `s_name`, `s_image`, `s_intake`, `s_programme`) VALUES
('TP0001', 'student1@gmail.com', '123', 'Jamie', 'uploads/panchoooo.png', 'DIP1090GED', 'Diploma in Graphic Design'),
('TP066529', 'testing@gmail.com', '123', 'Jenna', 'uploads/amimir.png', 'DIP3002CEN', 'Diploma in Computer Engineering'),
('TP1234', 'student@gmail.com', '123', 'Flayon ', 'uploads/kokomi uweee.png', 'DIP6098ACT', 'Diploma in Accounting ');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

DROP TABLE IF EXISTS `student_attendance`;
CREATE TABLE IF NOT EXISTS `student_attendance` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_code` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `date` date DEFAULT NULL,
  `code` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`id`, `class_code`, `start_time`, `end_time`, `date`, `code`) VALUES
(13, 'Account', '23:47:00', '12:46:00', '2023-08-04', 916),
(12, 'Science', '12:38:00', '23:38:00', '2023-08-04', 350),
(10, 'Math', '12:34:00', '12:34:00', '2023-08-01', 757),
(14, 'Account', '11:51:00', '02:55:00', '2023-08-11', 498),
(15, 'Math', '06:18:00', '08:18:00', '2023-08-31', 928),
(16, 'MAMA', '11:06:00', '01:04:00', '2023-09-20', 266),
(17, 'TEST 7pm', '00:00:00', '00:00:00', '2023-09-08', 489);

-- --------------------------------------------------------

--
-- Table structure for table `timetable_t`
--

DROP TABLE IF EXISTS `timetable_t`;
CREATE TABLE IF NOT EXISTS `timetable_t` (
  `tt_id` int NOT NULL AUTO_INCREMENT,
  `course_id` int NOT NULL,
  `tt_location` varchar(50) NOT NULL,
  `tt_day` varchar(25) NOT NULL,
  `tt_stime` time NOT NULL,
  `tt_etime` time NOT NULL,
  PRIMARY KEY (`tt_id`),
  KEY `fk_timetable_course` (`course_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `timetable_t`
--

INSERT INTO `timetable_t` (`tt_id`, `course_id`, `tt_location`, `tt_day`, `tt_stime`, `tt_etime`) VALUES
(9, 46, 'Class 1', 'Wednesday', '08:00:00', '09:30:00'),
(11, 49, 'Class A', 'Thursday', '08:00:00', '10:30:00'),
(12, 49, 'Class 1', 'Thursday', '14:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

DROP TABLE IF EXISTS `transaction_history`;
CREATE TABLE IF NOT EXISTS `transaction_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `card_id` varchar(255) NOT NULL,
  `u_id` int NOT NULL,
  `transaction_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `card_id` (`card_id`),
  KEY `u_id` (`u_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `card_id`, `u_id`, `transaction_date`, `amount`) VALUES
(1, 'ADMIN', 1, '2023-09-08 04:56:54', '4.00'),
(2, 'L0002', 275, '2023-09-08 04:57:15', '20.00'),
(3, 'L0003', 277, '2023-09-20 04:57:22', '50.00'),
(52, '0', 1, '2023-09-08 04:58:14', '5.00'),
(53, '0', 1, '2023-09-08 05:09:41', '2.00'),
(54, '0', 1, '2023-09-08 05:09:47', '2.00');

-- --------------------------------------------------------

--
-- Table structure for table `user_t`
--

DROP TABLE IF EXISTS `user_t`;
CREATE TABLE IF NOT EXISTS `user_t` (
  `u_id` int NOT NULL AUTO_INCREMENT,
  `u_email` varchar(255) NOT NULL,
  `u_password` varchar(255) NOT NULL,
  `u_role` varchar(255) NOT NULL,
  `u_card_id` varchar(255) NOT NULL,
  PRIMARY KEY (`u_id`),
  KEY `u_email` (`u_email`),
  KEY `u_card_id` (`u_card_id`)
) ENGINE=InnoDB AUTO_INCREMENT=279 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_t`
--

INSERT INTO `user_t` (`u_id`, `u_email`, `u_password`, `u_role`, `u_card_id`) VALUES
(1, 'admin@gmail.com', '123', 'admin', 'ADMIN'),
(270, 'testing@gmail.com', '123', 'student', 'TP066529'),
(271, 'lec@gmail.com', '123', 'lecturer', 'L0001'),
(275, 'lec1@gmail.com', '123', 'lecturer', 'L0002'),
(276, 'student@gmail.com', '123', 'student', 'TP1234'),
(277, 'lec2@gmail.com', '123', 'lecturer', 'L0003'),
(278, 'student1@gmail.com', '123', 'student', 'TP0001');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cards`
--
ALTER TABLE `cards`
  ADD CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user_t` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cards_ibfk_2` FOREIGN KEY (`card_id`) REFERENCES `user_t` (`u_card_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_t`
--
ALTER TABLE `courses_t`
  ADD CONSTRAINT `courses_t_ibfk_1` FOREIGN KEY (`c_lname`) REFERENCES `lecturer_t` (`l_name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback_t`
--
ALTER TABLE `feedback_t`
  ADD CONSTRAINT `feedback_t_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user_t` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lecturer_t`
--
ALTER TABLE `lecturer_t`
  ADD CONSTRAINT `lecturer_t_ibfk_1` FOREIGN KEY (`l_email`) REFERENCES `user_t` (`u_email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `result_t`
--
ALTER TABLE `result_t`
  ADD CONSTRAINT `result_t_ibfk_1` FOREIGN KEY (`r_c_name`) REFERENCES `courses_t` (`c_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_t_ibfk_2` FOREIGN KEY (`r_s_id`) REFERENCES `students_t` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students_t`
--
ALTER TABLE `students_t`
  ADD CONSTRAINT `students_t_ibfk_1` FOREIGN KEY (`s_email`) REFERENCES `user_t` (`u_email`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timetable_t`
--
ALTER TABLE `timetable_t`
  ADD CONSTRAINT `fk_timetable_course` FOREIGN KEY (`course_id`) REFERENCES `courses_t` (`c_id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`u_id`) REFERENCES `user_t` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
