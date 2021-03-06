-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 27, 2012 at 02:39 AM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zelfer`
--

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`) VALUES
(1, 'โครงการโอลิมปิกวิชาการ', 'คอร์สเรียนสำหรับผู้สนใจในรายวิชาต่างๆของโครงการโอลิมปิกวิชาการ'),
(2, 'โครงการครูต้นแบบ', 'คอร์สเรียนสำหรับการเตรียมการสอนสำหรับครูต้นแบบ');

--
-- Dumping data for table `chapter`
--

INSERT INTO `chapter` (`id`, `name`, `course_id`) VALUES
(1, 'รู้จักกับอัลกอริทึม', 1),
(2, 'การวิเคราะห์ประสิทธิภาพอัลกอริทึม', 1),
(3, 'โครงสร้างข้อมูลพื้นฐาน', 1),
(4, 'การเรียงลำดับและการค้นข้อมูล', 1);

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `name`, `short_description`, `long_description`, `category_id`) VALUES
(1, 'คอมพิวเตอร์โอลิมปิก', 'คอร์สสำหรับการเตรียมตัวแข่งขันคอมพิวเตอร์โอลิมปิก', 'เพื่อเป็นการเตรียมพร้อมสำหรับการแข่งขันคอมพิวเตอร์โอลิมปิก คอร์สนี้จะสอนให้คุณได้รู้ถึงโครงสร้างข้อมูลพื้นฐานจนไปถึงการวิเคราะห์และการออกแบบอัลกอริทึมที่จำเป็นสำหรับการแข่งขัน', 1),
(2, 'คณิตศาสตร์โอลิมปิก', 'คอร์สสำหรับการเตรียมตัวแข่งขันคณิตศาสตร์โอลิมปิก', '', 1),
(3, 'เตรียมพร้อมการสอน', 'คอร์สสำหรับการเตรียมตัวสำหรับการสอน', '', 2),
(4, 'เคมีโอลิมปิก', 'คอร์สสำหรับการเตรียมตัวแข่งขันเคมีโอลิมปิก', '', 1),
(5, 'จิตวิทยาในการสอน', 'คอร์สสำหรับการเรียนรู้จิตวิทยาในการสอน', '', 2);

--
-- Dumping data for table `course_open`
--

INSERT INTO `course_open` (`id`, `course_id`, `open_status_id`, `start_date`, `duration`) VALUES
(1, 1, 1, '2012-06-12', '');

--
-- Dumping data for table `instructor_course`
--

INSERT INTO `instructor_course` (`id`, `user_id`, `course_id`, `instructor_career`, `instructor_description`) VALUES
(1, 1, 1, 'Operations Manager at Larngear Technology', 'Supasate Choochaisri is a co-founder and managing director of Larngear Technology Co., Ltd. His company has\r\nwon several regional and international awards. He receives B. Eng., M. Eng., and Ph.D. in Computer Engineering, from Chulalongkorn University. \r\n\r\nCurrently, he has received a grant CP CU\r\nAcademic Excellence Scholarship. His research interests include various topics in augmented reality and ubiquitous computing with emphasis\r\non wireless sensor network, mobile computing, and distributed algorithms.\r\n'),
(2, 2, 1, 'Tester Account at Larngear Technology', 'This is only an account for system testing.'),
(3, 2, 2, '', ''),
(4, 2, 3, '', ''),
(5, 1, 4, '', ''),
(6, 3, 5, '', '');

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`id`, `name`, `chapter_id`) VALUES
(1, 'สัญกรณ์โอใหญ่', 2),
(2, 'อัตราการเติบโตของฟังก์ชัน', 2),
(3, 'อาเรย์และรายการเชื่อมโยง', 3),
(4, 'อัลกอริทึมคืออะไร', 1),
(5, 'Lecture XYZ', 1);

--
-- Dumping data for table `open_status`
--

INSERT INTO `open_status` (`id`, `name`) VALUES
(1, 'open'),
(2, 'close'),
(3, 'running');

--
-- Dumping data for table `student_course`
--

INSERT INTO `student_course` (`id`, `user_id`, `course_id`) VALUES
(1, 2, 1);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `fullname`, `role`, `status`) VALUES
(1, 'admin@zelfer.com', '$2a$08$AlQ93iTsZOZ6vQv7CRiwheS3gh16gRw5e2Ngw6q5qVc/PkVPQ0DHC', 'admin', 1, 1),
(2, 'demo@zelfer.com', '$2a$08$gA137nB8.aZqbRBNjbur3OXWlyf7zv8MWnzFVzge06IPTNnJKFXdi', 'demo', 2, 1),
(3, 'test1@test.com', '$2a$08$I2Clo09T8bNf0FoDtDfj4uvQnlCUcYkbhgql.0tFlfuRy9ioZKQQe', 'test1', 2, 1),
(4, 'test2@test.com', '$2a$08$xWAk15KGjyeKRMRqwxmSTuMXvj3Yy256Laeoo7RVjxPH6UzW3dx.a', 'test2', 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
