-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 07, 2013 at 05:16 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autotest`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_answers`
--

CREATE TABLE IF NOT EXISTS `tb_answers` (
  `answer_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id cua bai tra loi',
  `question_id` int(11) NOT NULL COMMENT 'id cua cau hoi',
  `path` varchar(1000) NOT NULL,
  `upload_date` datetime NOT NULL,
  `is_markered` int(1) NOT NULL COMMENT '1: đã chấm, 0: chưa chấm, 2: deo phai cham',
  `marked_date` date NOT NULL COMMENT 'ngày chấm, nếu chấm lại thì thay đổi nó',
  `tester` varchar(100) NOT NULL,
  `org_manager_id` int(11) NOT NULL COMMENT 'ID of org manager',
  PRIMARY KEY (`answer_id`),
  KEY `marked_date` (`marked_date`),
  KEY `marked_date_2` (`marked_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=116 ;

--
-- Dumping data for table `tb_answers`
--

INSERT INTO `tb_answers` (`answer_id`, `question_id`, `path`, `upload_date`, `is_markered`, `marked_date`, `tester`, `org_manager_id`) VALUES
(101, 79, 'MathTest_79_20080002', '2013-04-07 17:32:41', 2, '0000-00-00', '20080002', 42),
(102, 79, 'MathTest_79_20080001', '2013-04-07 17:33:03', 2, '0000-00-00', '20080001', 42),
(103, 80, 'MathTest_80_20080001', '2013-04-07 17:41:40', 1, '2013-04-07', '20080001', 42),
(104, 80, 'MathTest_80_20080002', '2013-04-07 17:42:49', 1, '2013-04-08', '20080002', 42),
(105, 81, 'MathTest_81_20080002', '2013-04-07 17:46:19', 2, '0000-00-00', '20080002', 42),
(106, 81, 'MathTest_81_20080001', '2013-04-07 17:46:50', 2, '0000-00-00', '20080001', 42),
(107, 83, 'MathTest_83_20080006', '2013-04-07 17:50:49', 2, '0000-00-00', '20080006', 42),
(108, 83, 'MathTest_83_20080003', '2013-04-07 17:50:53', 2, '0000-00-00', '20080003', 42),
(109, 84, 'MathTest_84_20080001', '2013-04-07 17:53:42', 2, '0000-00-00', '20080001', 42),
(110, 84, 'MathTest_84_20080003', '2013-04-07 17:54:44', 2, '0000-00-00', '20080003', 42),
(111, 85, 'MathTest_85_20080001', '2013-04-07 18:36:21', 2, '0000-00-00', '20080001', 42),
(112, 87, 'MathTest_87_20080001', '2013-04-07 18:38:37', 2, '0000-00-00', '20080001', 42),
(113, 88, 'MathTest_88_20080001', '2013-04-07 23:27:05', 2, '0000-00-00', '20080001', 42),
(114, 88, 'MathTest_88_20080002', '2013-04-07 23:30:47', 2, '0000-00-00', '20080002', 42),
(115, 88, 'MathTest_88_20080003', '2013-04-07 23:32:16', 2, '0000-00-00', '20080003', 42);

-- --------------------------------------------------------

--
-- Table structure for table `tb_contracts`
--

CREATE TABLE IF NOT EXISTS `tb_contracts` (
  `contract_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'id cua org managers',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `info` longtext,
  KEY `contract_id` (`contract_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tb_contracts`
--

INSERT INTO `tb_contracts` (`contract_id`, `user_id`, `start_date`, `end_date`, `info`) VALUES
(11, 42, '2013-04-01', '2013-04-30', 'ハノイ工科大学の契約'),
(12, 43, '2013-04-01', '2015-04-01', 'SOSC契約');

-- --------------------------------------------------------

--
-- Table structure for table `tb_org_managers`
--

CREATE TABLE IF NOT EXISTS `tb_org_managers` (
  `org_manager_id` int(11) NOT NULL COMMENT 'id cua org manager',
  `user_id` int(11) NOT NULL COMMENT 'id cua test marker hoac test maker',
  PRIMARY KEY (`org_manager_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_org_managers`
--

INSERT INTO `tb_org_managers` (`org_manager_id`, `user_id`) VALUES
(42, 48),
(42, 49),
(43, 45),
(43, 46),
(43, 47);

-- --------------------------------------------------------

--
-- Table structure for table `tb_questions`
--

CREATE TABLE IF NOT EXISTS `tb_questions` (
  `question_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id cua cau hoi',
  `user_id` int(11) NOT NULL COMMENT 'id cua test maker',
  `path` varchar(1000) NOT NULL,
  `test_link` varchar(1000) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`question_id`),
  KEY `csv_id` (`question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=90 ;

--
-- Dumping data for table `tb_questions`
--

INSERT INTO `tb_questions` (`question_id`, `user_id`, `path`, `test_link`, `status`, `start_date`, `end_date`, `created`) VALUES
(79, 48, 'test/48/PTUF01-N01.csv', 'localhost/users/login/test/79', 1, '2013-04-07 17:30:00', '2013-04-07 17:50:00', '2013-04-07'),
(80, 48, 'test/48/PTUF02-N01.csv', 'localhost/users/login/test/80', 1, '2013-04-07 17:40:00', '2013-04-07 17:50:00', '2013-04-07'),
(81, 48, 'test/48/PTFX01-N01.csv', 'localhost/users/login/test/81', 1, '2013-04-07 17:45:00', '2013-04-07 17:46:00', '2013-04-07'),
(83, 48, 'test/48/PTFX02-N01.csv', 'localhost/users/login/test/83', 1, '2013-04-07 17:50:00', '2013-04-07 17:51:40', '2013-04-07'),
(84, 48, 'test/48/PTFX03-N01.csv', 'localhost/users/login/test/84', 1, '2013-04-07 17:53:17', '2013-04-07 17:54:17', '2013-04-07'),
(86, 0, '', '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-04-07'),
(88, 48, 'test/48/PTFX01-N02.csv', 'localhost/users/login/test/88', 1, '2013-04-07 23:27:00', '2013-04-08 00:27:00', '2013-04-07'),
(89, 48, 'test/48/PTFX02-N02.csv', 'localhost/users/login/test/89', 0, '2013-04-10 17:50:00', '2013-04-10 17:51:40', '2013-04-07');

-- --------------------------------------------------------

--
-- Table structure for table `tb_testees`
--

CREATE TABLE IF NOT EXISTS `tb_testees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `username` varchar(30) CHARACTER SET utf8 NOT NULL,
  `password` varchar(100) CHARACTER SET utf8 NOT NULL,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `test_time` datetime NOT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=273 ;

--
-- Dumping data for table `tb_testees`
--

INSERT INTO `tb_testees` (`id`, `test_id`, `username`, `password`, `name`, `test_time`, `flag`) VALUES
(266, 88, '20080006', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS3-Giang', '2013-04-07 23:27:00', 0),
(265, 88, '20080003', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS2-Cuong', '2013-04-07 23:27:00', 0),
(254, 84, '20080006', '30f33c62606df04ae08d72307fa5755fcaf8e8d2', 'AS3-Giang', '2013-04-07 17:53:17', 0),
(264, 88, '20080002', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS1-Binh', '2013-04-07 23:27:00', 0),
(263, 88, '20080001', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS1-Anh', '2013-04-07 23:27:00', 0),
(245, 83, '20080001', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS1-Anh', '2013-04-07 17:50:00', 0),
(246, 83, '20080002', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS1-Binh', '2013-04-07 17:50:00', 0),
(247, 83, '20080003', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS2-Cuong', '2013-04-07 17:50:00', 0),
(248, 83, '20080004', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS2-Duc', '2013-04-07 17:50:00', 0),
(249, 83, '20080006', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS3-Giang', '2013-04-07 17:50:00', 0),
(250, 84, '20080001', '30f33c62606df04ae08d72307fa5755fcaf8e8d2', 'AS1-Anh', '2013-04-07 17:53:17', 0),
(251, 84, '20080002', '30f33c62606df04ae08d72307fa5755fcaf8e8d2', 'AS1-Binh', '2013-04-07 17:53:17', 0),
(252, 84, '20080003', '30f33c62606df04ae08d72307fa5755fcaf8e8d2', 'AS2-Cuong', '2013-04-07 17:53:17', 1),
(236, 81, '20080001', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS1-Anh', '2013-04-07 17:45:00', 0),
(232, 80, '20080003', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS2-Cuong', '2013-04-07 17:40:00', 0),
(233, 80, '20080004', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS2-Duc', '2013-04-07 17:40:00', 0),
(234, 80, '20080005', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS3-Dung', '2013-04-07 17:40:00', 0),
(235, 80, '20080006', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS3-Giang', '2013-04-07 17:40:00', 0),
(237, 81, '20080002', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS1-Binh', '2013-04-07 17:45:00', 0),
(238, 81, '20080003', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS2-Cuong', '2013-04-07 17:45:00', 0),
(239, 81, '20080006', 'f7d88bd46ff43de7328089d9504b05c17dfafd7b', 'AS3-Giang', '2013-04-07 17:45:00', 0),
(253, 84, '20080004', '30f33c62606df04ae08d72307fa5755fcaf8e8d2', 'AS2-Duc', '2013-04-07 17:53:17', 0),
(224, 79, '20080001', 'a13a980b18f7bf0b9bcfba78cf3f11d280bf93d9', 'AS1-Anh', '2013-04-07 17:30:00', 0),
(225, 79, '20080002', 'a13a980b18f7bf0b9bcfba78cf3f11d280bf93d9', 'AS1-Binh', '2013-04-07 17:30:00', 0),
(226, 79, '20080003', 'a13a980b18f7bf0b9bcfba78cf3f11d280bf93d9', 'AS2-Cuong', '2013-04-07 17:30:00', 0),
(227, 79, '20080004', 'a13a980b18f7bf0b9bcfba78cf3f11d280bf93d9', 'AS2-Duc', '2013-04-07 17:30:00', 0),
(228, 79, '20080005', 'a13a980b18f7bf0b9bcfba78cf3f11d280bf93d9', 'AS3-Dung', '2013-04-07 17:30:00', 0),
(229, 79, '20080006', 'a13a980b18f7bf0b9bcfba78cf3f11d280bf93d9', 'AS3-Giang', '2013-04-07 17:30:00', 0),
(230, 80, '20080001', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS1-Anh', '2013-04-07 17:40:00', 0),
(231, 80, '20080002', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS1-Binh', '2013-04-07 17:40:00', 0),
(267, 0, '', '', '', '0000-00-00 00:00:00', 0),
(268, 89, '20080001', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS1-Anh', '2013-04-10 17:50:00', 0),
(269, 89, '20080002', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS1-Binh', '2013-04-10 17:50:00', 0),
(270, 89, '20080003', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS2-Cuong', '2013-04-10 17:50:00', 0),
(271, 89, '20080004', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS2-Duc', '2013-04-10 17:50:00', 0),
(272, 89, '20080006', 'cf2b6ea92b609ada1d0fd6e07759899daa29a213', 'AS3-Giang', '2013-04-10 17:50:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(100) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(25) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `bank_account` int(20) NOT NULL,
  `info` longtext NOT NULL,
  `kind` tinyint(4) NOT NULL COMMENT '1:admin 2:org manager 3:testmarker 4:test maker',
  `del_flg` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `firstname`, `lastname`, `address`, `phone`, `bank_account`, `info`, `kind`, `del_flg`, `created`, `modified`) VALUES
(5, 'root', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'duc', 'duong', NULL, NULL, 123, 'sddf', 1, 0, '2013-03-15 15:05:41', '2013-04-07 16:12:03'),
(42, 'HUST', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'HUST', 'Manager', 'No 1 - Dai Co Viet - Hai Ba Trung - Hanoi', '+841689959053', 523363636, 'ハノイ工科大学の団体管理者', 2, 0, '2013-04-07 09:37:55', '2013-04-07 16:12:55'),
(43, 'SOSC', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'SOSC', 'Manager', 'ハノイ・ハノイ工科大学', '+841689952905', 5666, 'SOSCの団体管理者.代表者のハイ様。', 2, 0, '2013-04-07 09:40:17', '2013-04-07 09:50:50'),
(45, 'sosc_maker1', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'SOSC', 'Maker1', 'ハノイ・ハノイ工科大学', '+841689952905', 0, 'SOSCの出題者', 4, 0, '2013-04-07 09:52:51', '2013-04-07 09:52:51'),
(46, 'sosc_maker2', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'SOSC', 'Maker2', 'ハノイ工科大学', '+841689952905', 0, '', 4, 0, '2013-04-07 09:53:44', '2013-04-07 09:53:44'),
(47, 'sosc_marker1', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'SOSC', 'Marker1', 'ハノイ工科大学', '+841689952905', 0, 'ハノイ工科大学', 3, 0, '2013-04-07 09:54:27', '2013-04-07 09:54:27'),
(48, 'hust_maker1', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'HUST', 'Maker1', 'ハノイ工科大学', '+841689952905', 0, 'ハノイ工科大学', 4, 0, '2013-04-07 09:56:22', '2013-04-07 09:56:22'),
(49, 'hust_marker1', 'dcfb6d84c040cd936e58d302abef0a3c9119c123', 'HUST', 'Marker1', 'ハノイ工科大学', '+841689952905', 0, 'ハノイ工科大学', 3, 0, '2013-04-07 09:57:28', '2013-04-07 09:57:28');
