-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2012 at 01:25 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zelfer`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignment`
--

CREATE TABLE IF NOT EXISTS `assignment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `release_date` date NOT NULL,
  `full_credit_expiry_date` date NOT NULL,
  `reduced_credit_expiry_date` date NOT NULL,
  `reduced_credit_percentage` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `assignment_type`
--

CREATE TABLE IF NOT EXISTS `assignment_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'วิทยาการคอมพิวเตอร์', 'คอร์สเรียนสำหรับผู้สนใจในรายวิชาต่างๆเกี่ยวกับวิทยาการ/วิศวกรรมคอมพิวเตอร์'),
(2, 'คณิตศาสตร์', 'คอร์สเรียนสำหรับผู้สนใจในคณิตศาสตร์แขนงต่างๆ');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `course_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `name`, `course_id`, `order`, `parent_id`, `type`) VALUES
(1, 'รู้จักกับอัลกอริทึม', 1, 0, -1, 0),
(2, 'อัลกอริทึมคืออะไร', 1, 1, 1, 1),
(3, 'เกี่ยวกับคอร์สนี้', 1, 2, 1, 1),
(4, 'การวิเคราะห์ประสิทธิภาพอัลกอริทึม', 1, 3, -1, 0),
(5, 'สัญกรณ์โอใหญ่', 1, 4, 4, 1),
(6, 'อัตราการเติบโตของฟังก์ชัน', 1, 5, 4, 1),
(7, 'โครงสร้างข้อมูลพื้นฐาน', 1, 6, -1, 0),
(8, 'อาเรย์และรายการเชื่อมโยง', 1, 7, 7, 1),
(9, 'การเรียงลำดับและการค้นข้อมูล', 1, 8, 7, 1),
(10, 'ลำดับย่อยร่วมกันที่ยาวที่สุด', 1, 10, 11, 1),
(11, 'ไดนามิกโปรแกรมมิ่ง', 1, 9, -1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `long_description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `thumbnail_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `short_description`, `long_description`, `category_id`, `thumbnail_url`, `intro_url`, `owner_id`, `status`) VALUES
(1, 'Computer Algorithm', 'พื้นฐานของการออกแบบและวิเคราะห์อัลกอริทึม', 'เพื่อเป็นการเตรียมพร้อมสำหรับการแข่งขันคอมพิวเตอร์โอลิมปิก คอร์สนี้จะสอนให้คุณได้รู้ถึงโครงสร้างข้อมูลพื้นฐานจนไปถึงการวิเคราะห์และการออกแบบอัลกอริทึมที่จำเป็นสำหรับการแข่งขัน', 1, '/zelfer/course/thumbnails/5086d886b1d2a.png', '5086d9d929a8d', 1, 1),
(2, 'Software as a Service', 'การออกแบบซอฟต์แวร์เชิงบริการ', 'เพื่อเป็นการเตรียมพร้อมสำหรับการแข่งขันคอมพิวเตอร์โอลิมปิก คอร์สนี้จะสอนให้คุณได้รู้ถึงโครงสร้างข้อมูลพื้นฐานจนไปถึงการวิเคราะห์และการออกแบบอัลกอริทึมที่จำเป็นสำหรับการแข่งขัน', 1, '/zelfer/course/thumbnails/50875c5165fc1.jpg', '5087648d641e9', 2, 1),
(3, 'Introduction to Mathematical Thinking', 'คอร์สเบื้องต้นสำหรับกระบวนการคิดแบบคณิตศาสตร์', 'เพื่อเป็นการเตรียมพร้อมสำหรับการแข่งขันคอมพิวเตอร์โอลิมปิก คอร์สนี้จะสอนให้คุณได้รู้ถึงโครงสร้างข้อมูลพื้นฐานจนไปถึงการวิเคราะห์และการออกแบบอัลกอริทึมที่จำเป็นสำหรับการแข่งขัน', 2, '/zelfer/course/thumbnails/50876716cbd00.png', '5087642a04180', 2, 1),
(4, 'Human Computer Interaction', 'การออกแบบการเชื่อมต่อระหว่างคอมพิวเตอร์และผู้ใช้งาน', 'เพื่อเป็นการเตรียมพร้อมสำหรับการแข่งขันคอมพิวเตอร์โอลิมปิก คอร์สนี้จะสอนให้คุณได้รู้ถึงโครงสร้างข้อมูลพื้นฐานจนไปถึงการวิเคราะห์และการออกแบบอัลกอริทึมที่จำเป็นสำหรับการแข่งขัน', 1, '/zelfer/course/thumbnails/5087636faed98.png', '508763c01ded3', 1, 1),
(5, 'Introduction to Logic', 'ตรรกศาสตร์เบื้องต้น', 'เพื่อเป็นการเตรียมพร้อมสำหรับการแข่งขันคอมพิวเตอร์โอลิมปิก คอร์สนี้จะสอนให้คุณได้รู้ถึงโครงสร้างข้อมูลพื้นฐานจนไปถึงการวิเคราะห์และการออกแบบอัลกอริทึมที่จำเป็นสำหรับการแข่งขัน', 2, '/zelfer/course/thumbnails/50876754bc4db.png', NULL, 2, 1),
(6, 'ทดสอบการใช้งาน', 'สำหรับทดสอบการใช้งาน', 'คอร์สนี้สร้างมาเพื่อทดสอบการใช้งานระบบ', 2, NULL, NULL, 2, 0),
(7, 'test test tes', 'test', 'test', 1, NULL, NULL, 2, 0),
(8, 'test', 'test', 'test', 1, NULL, NULL, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `course_open`
--

CREATE TABLE IF NOT EXISTS `course_open` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `open_status_id` int(1) NOT NULL,
  `start_date` date NOT NULL,
  `duration` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `open_status_id` (`open_status_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `course_open`
--

INSERT INTO `course_open` (`id`, `course_id`, `open_status_id`, `start_date`, `duration`) VALUES
(1, 1, 1, '2012-06-12', '');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_course`
--

CREATE TABLE IF NOT EXISTS `instructor_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `instructor_career` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `instructor_description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `instructor_course`
--

INSERT INTO `instructor_course` (`id`, `user_id`, `course_id`, `instructor_career`, `instructor_description`) VALUES
(1, 1, 1, 'Operations Manager at Larngear Technology', 'Supasate Choochaisri is a co-founder and managing director of Larngear Technology Co., Ltd. His company has\r\nwon several regional and international awards. He receives B. Eng., M. Eng., and Ph.D. in Computer Engineering, from Chulalongkorn University. \r\n\r\nCurrently, he has received a grant CP CU\r\nAcademic Excellence Scholarship. His research interests include various topics in augmented reality and ubiquitous computing with emphasis\r\non wireless sensor network, mobile computing, and distributed algorithms.\r\n'),
(2, 2, 1, 'Tester Account at Larngear Technology', 'This is only an account for system testing.'),
(3, 2, 2, '', ''),
(4, 2, 3, '', ''),
(5, 1, 4, '', ''),
(6, 3, 5, '', ''),
(7, 2, 6, '', ''),
(8, 2, 7, '', ''),
(9, 2, 8, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `open_status`
--

CREATE TABLE IF NOT EXISTS `open_status` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `open_status`
--

INSERT INTO `open_status` (`id`, `name`) VALUES
(1, 'open'),
(2, 'close'),
(3, 'running');

-- --------------------------------------------------------

--
-- Table structure for table `slide`
--

CREATE TABLE IF NOT EXISTS `slide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lecture_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `student_assessmentitem`
--

CREATE TABLE IF NOT EXISTS `student_assessmentitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `lecture_id` int(11) NOT NULL,
  `assessmentitem_id` int(11) NOT NULL,
  `chosen_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `student_assessmentitem`
--

INSERT INTO `student_assessmentitem` (`id`, `user_id`, `lecture_id`, `assessmentitem_id`, `chosen_value`) VALUES
(1, 2, 5, 1, '2'),
(2, 2, 5, 2, '1'),
(3, 2, 5, 3, '3'),
(4, 2, 5, 4, '1');

-- --------------------------------------------------------

--
-- Table structure for table `student_course`
--

CREATE TABLE IF NOT EXISTS `student_course` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`course_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`id`, `user_id`, `course_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profile_image_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `career` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `role` int(2) NOT NULL,
  `status` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `fullname`, `profile_image_url`, `career`, `description`, `role`, `status`) VALUES
(1, 'admin@zelfer.com', '$2a$08$AlQ93iTsZOZ6vQv7CRiwheS3gh16gRw5e2Ngw6q5qVc/PkVPQ0DHC', 'admin', '/zelfer/user/1.jpg', 'Operations Manager at Larngear Technology', 'Supasate Choochaisri is a co-founder and managing director of Larngear Technology Co., Ltd. His company has\r\nwon several regional and international awards. He receives B. Eng., M. Eng., and Ph.D. in Computer Engineering, from Chulalongkorn University. \r\n\r\nCurrently, he has received a grant CP CU\r\nAcademic Excellence Scholarship. His research interests include various topics in augmented reality and ubiquitous computing with emphasis\r\non wireless sensor network, mobile computing, and distributed algorithms.\r\n', 1, 1),
(2, 'demo@zelfer.com', '$2a$08$gA137nB8.aZqbRBNjbur3OXWlyf7zv8MWnzFVzge06IPTNnJKFXdi', 'demo', '/zelfer/user/2.jpg', 'Tester Account at Larngear Technology', 'This is only an account for system testing.', 2, 1),
(3, 'test1@test.com', '$2a$08$I2Clo09T8bNf0FoDtDfj4uvQnlCUcYkbhgql.0tFlfuRy9ioZKQQe', '/zelfer/user/3.jpg', '', '', '', 2, 1),
(4, 'test2@test.com', '$2a$08$xWAk15KGjyeKRMRqwxmSTuMXvj3Yy256Laeoo7RVjxPH6UzW3dx.a', 'test2', '', '', '', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lecture_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
