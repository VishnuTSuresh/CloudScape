-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 05, 2013 at 11:42 AM
-- Server version: 5.1.68-community
-- PHP Version: 5.4.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `intranet services website`
--

-- --------------------------------------------------------

--
-- Table structure for table `invisible`
--

CREATE TABLE IF NOT EXISTS `invisible` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(11) NOT NULL,
  `password` varchar(11) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `user_id` (`user_id`),
  KEY `username_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `invisible`
--

INSERT INTO `invisible` (`user_id`, `username`, `password`) VALUES
(1, 'v', '1'),
(2, 'q', 'q');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `token_no` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry_time` datetime NOT NULL,
  PRIMARY KEY (`token_no`),
  KEY `uid` (`token_no`),
  KEY `uuid` (`uuid`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`token_no`, `uuid`, `user_id`, `expiry_time`) VALUES
(3, '2a8cc902-8d63-11e2-9381-e8039abc3d8a', 1, '0000-00-00 00:00:00'),
(4, '97575b51-8d65-11e2-9381-e8039abc3d8a', 1, '0000-00-00 00:00:00'),
(5, 'ad90ef06-8d65-11e2-9381-e8039abc3d8a', 1, '0000-00-00 00:00:00'),
(6, 'afc1e198-8d65-11e2-9381-e8039abc3d8a', 1, '2013-03-15 00:00:00'),
(7, '4f2dd5f6-8d68-11e2-9381-e8039abc3d8a', 1, '2013-03-15 18:33:11'),
(8, '1228626155', 1, '2013-03-15 18:48:53'),
(9, '1308698523', 1, '2013-03-15 18:49:52'),
(10, 'bbbd6cc0-8d6c-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:04:52'),
(11, 'cf3b1f66-8d6c-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:05:24'),
(13, '4299276c-8d6d-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:08:38'),
(14, '53ca9f96-8d6d-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:09:07'),
(15, '848e815b-8d6d-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:10:28'),
(17, '220c1bc8-8d6e-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:14:53'),
(18, 'b8bcc359-8d6f-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:26:15'),
(19, 'c406627c-8d6f-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:26:34'),
(20, 'c5cc7d9b-8d6f-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:26:37'),
(21, 'c6937574-8d6f-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:26:38'),
(22, 'cd601bde-8d6f-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:26:50'),
(23, 'df571c51-8d6f-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:27:20'),
(24, 'f4851f55-8d6f-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:27:55'),
(25, '4adc2131-8d70-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:30:20'),
(26, '74832034-8d70-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:31:30'),
(27, '7cb17486-8d70-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:31:44'),
(28, '7ff30676-8d70-11e2-9381-e8039abc3d8a', 1, '2013-03-15 19:31:49'),
(29, 'df64c44b-8d7b-11e2-9599-c230a7b79ff6', 1, '2013-03-15 20:53:14'),
(30, '6492ce91-9061-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 13:21:14'),
(31, 'bf7f09cd-9062-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 13:30:56'),
(32, '4d325abe-9065-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 13:49:13'),
(33, '9ea0395a-9066-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 13:58:39'),
(34, 'c8584574-9068-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 14:14:08'),
(35, '9071a6ef-9069-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 14:19:44'),
(36, '6a39876d-906c-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 14:40:08'),
(37, '80922e94-906d-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 14:47:55'),
(38, '123a6187-9071-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 14:14:28'),
(39, '88bb2a90-9071-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 14:17:47'),
(40, '47eb2c40-9072-11e2-99da-d1aef4bdd5f5', 1, '2013-03-19 15:22:08'),
(41, 'af35a96c-911b-11e2-99da-d1aef4bdd5f5', 1, '2013-03-20 11:34:46'),
(42, 'd12a2e93-9194-11e2-99da-d1aef4bdd5f5', 1, '2013-03-21 02:01:52'),
(43, '5a70a100-919a-11e2-99da-d1aef4bdd5f5', 2, '2013-03-21 02:41:30'),
(44, 'e7f4bcc3-93f3-11e2-99da-d1aef4bdd5f5', 1, '2013-03-24 02:28:16'),
(45, '4a02d82e-945b-11e2-99da-d1aef4bdd5f5', 1, '2013-03-24 14:48:19'),
(46, 'c878ada2-945c-11e2-99da-d1aef4bdd5f5', 1, '2013-03-24 14:59:00'),
(47, '58bc4c80-9472-11e2-99da-d1aef4bdd5f5', 1, '2013-03-24 17:33:22'),
(48, 'ca886bf3-948f-11e2-99da-d1aef4bdd5f5', 1, '2013-03-24 21:04:08'),
(49, '7f136791-94aa-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 00:15:18'),
(50, 'cd2024be-94af-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 00:53:16'),
(51, '90e8da0d-94b7-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 01:48:51'),
(52, '1454e772-94c8-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 03:47:04'),
(53, '8384f6fe-94d4-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 05:16:04'),
(54, 'b3aa1935-952a-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 15:33:02'),
(55, '5a5a386c-9533-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 16:34:57'),
(56, 'edcb041b-953c-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 17:43:30'),
(57, 'd85b855e-9546-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 18:54:29'),
(58, 'f4d68c9c-9550-11e2-99da-d1aef4bdd5f5', 1, '2013-03-25 20:06:52'),
(59, 'e340ec22-9649-11e2-99da-d1aef4bdd5f5', 1, '2013-03-27 01:48:47'),
(60, 'f0c916b7-9649-11e2-99da-d1aef4bdd5f5', 1, '2013-03-27 01:49:10'),
(61, 'fc4d0f8a-966a-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 05:45:01'),
(62, '656f95dd-9675-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 06:59:33'),
(63, '3b7c3ebe-9683-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 08:38:35'),
(64, 'e3c1b513-968e-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 10:02:02'),
(65, 'f09322db-96c4-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 16:28:56'),
(66, '5aad307e-96ca-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 17:07:42'),
(67, '95d7ed5d-96cd-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 17:30:50'),
(68, '4e15ed8f-96d7-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 18:40:24'),
(69, '5311ff1c-96d7-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 18:40:33'),
(70, '440df3e3-96ff-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 23:26:27'),
(71, '4c36343a-96ff-11e2-ba8c-57a43313c5a5', 1, '2013-03-27 23:26:41'),
(72, '205e3501-9afd-11e2-b185-2fbb1f68ab23', 1, '2013-04-02 01:21:13'),
(73, 'e087b540-9c8a-11e2-bc07-59efa15be25e', 1, '2013-04-04 00:48:26');

-- --------------------------------------------------------

--
-- Table structure for table `signup_ug`
--

CREATE TABLE IF NOT EXISTS `signup_ug` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_2` (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `signup_ug`
--

INSERT INTO `signup_ug` (`user_id`, `firstname`, `lastname`) VALUES
(1, 'Vishnu', 'T Suresh'),
(2, 'Qwerty', 'Yuiop');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `invisible` (`user_id`);

--
-- Constraints for table `signup_ug`
--
ALTER TABLE `signup_ug`
  ADD CONSTRAINT `signup_ug_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `invisible` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
