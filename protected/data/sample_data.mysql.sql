-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 07, 2012 at 03:24 AM
-- Server version: 5.5.22
-- PHP Version: 5.3.10-1ubuntu3.1

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

INSERT INTO `course` (`id`, `name`, `description`, `category_id`) VALUES
(1, 'คอมพิวเตอร์โอลิมปิก', 'คอร์สสำหรับการเตรียมตัวแข่งขันคอมพิวเตอร์โอลิมปิก', 1),
(2, 'คณิตศาสตร์โอลิมปิก', 'คอร์สสำหรับการเตรียมตัวแข่งขันคณิตศาสตร์โอลิมปิก', 1),
(3, 'เตรียมพร้อมการสอน', 'คอร์สสำหรับการเตรียมตัวสำหรับการสอน', 2),
(4, 'เคมีโอลิมปิก', 'คอร์สสำหรับการเตรียมตัวแข่งขันเคมีโอลิมปิก', 1),
(5, 'จิตวิทยาในการสอน', 'คอร์สสำหรับการเรียนรู้จิตวิทยาในการสอน', 2);

--
-- Dumping data for table `lecture`
--

INSERT INTO `lecture` (`id`, `name`, `chapter_id`) VALUES
(1, 'สัญกรณ์โอใหญ่', 2),
(2, 'อัตราการเติบโตของฟังก์ชัน', 2),
(3, 'อาเรย์และรายการเชื่อมโยง', 3),
(4, 'อัลกอริทึมคืออะไร', 1);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `role`, `active`) VALUES
(1, 'admin', '$2a$08$fWJc9zjpMTwjE/k/ZMKznOFQZTfcpjS/j7Ka.QmtPZMYTlBCftZZa', 'admin@example.com', 1, 1),
(2, 'demo', '$2a$08$Ap944io4kt3jZBL35oxN/.lSp8TMAc7Q0iQ4ZGI8Of2SKg4eUsq4m', 'demo@example.com', 2, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
