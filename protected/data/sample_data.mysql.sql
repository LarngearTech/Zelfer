-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 05, 2012 at 12:44 PM
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
(1, 'อัลกอริทึมคืออะไร', 1),
(2, 'ประสิทธิภาพของอัลกอริทึม', 2),
(3, 'สัญกรณ์โอใหญ่ (Big O)', 2),
(4, 'โครงสร้างข้อมูลแบบต่อเนื่อง', 3),
(5, 'โครงสร้างข้อมูลแบบเชื่อมโยง', 3),
(6, 'กองซ้อน (Stack)', 3),
(7, 'แถวคอย (Queue)', 3);

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin@example.com'),
(2, 'demo', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 'demo@example.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
