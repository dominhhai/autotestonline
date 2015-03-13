-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 10, 2013 at 09:33 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autotestonline`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `tb_answers`
--

INSERT INTO `tb_answers` (`answer_id`, `question_id`, `path`, `upload_date`, `is_markered`, `marked_date`, `tester`, `org_manager_id`) VALUES
(111, 85, 'MathTest_85_20080001', '2013-04-07 18:36:21', 2, '0000-00-00', '20080001', 42),
(112, 87, 'MathTest_87_20080001', '2013-04-07 18:38:37', 2, '0000-00-00', '20080001', 42);

-- --------------------------------------------------------

--
-- Table structure for table `tb_contracts`
--

CREATE TABLE IF NOT EXISTS `tb_contracts` (
  `contract_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'id cua org managers',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `info` varchar(50) NOT NULL,
  KEY `contract_id` (`contract_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tb_contracts`
--

INSERT INTO `tb_contracts` (`contract_id`, `user_id`, `start_date`, `end_date`, `info`) VALUES
(16, 52, '2013-04-08', '2013-04-09', 'kinhte'),
(17, 53, '2013-04-08', '2016-04-08', 'OK'),
(18, 61, '2013-04-03', '2013-04-19', '1223432'),
(19, 62, '2013-04-30', '2013-04-30', 'bachkho');

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
(52, 58),
(52, 59),
(52, 60),
(53, 55),
(53, 56),
(53, 57);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

--
-- Dumping data for table `tb_questions`
--

INSERT INTO `tb_questions` (`question_id`, `user_id`, `path`, `test_link`, `status`, `start_date`, `end_date`, `created`) VALUES
(86, 0, '', '', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2013-04-07'),
(92, 58, 'test/58/PTUF02-N01.csv', '172.28.134.103/autotestonline/users/login/test/92', 0, '2013-04-08 18:50:00', '2013-04-08 19:00:00', '2013-04-08');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=294 ;

--
-- Dumping data for table `tb_testees`
--

INSERT INTO `tb_testees` (`id`, `test_id`, `username`, `password`, `name`, `test_time`, `flag`) VALUES
(293, 92, '20080006', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS3-Giang', '2013-04-08 18:50:00', 0),
(292, 92, '20080005', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS3-Dung', '2013-04-08 18:50:00', 0),
(291, 92, '20080004', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS2-Duc', '2013-04-08 18:50:00', 0),
(290, 92, '20080003', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS2-Cuong', '2013-04-08 18:50:00', 0),
(289, 92, '20080002', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS1-Binh', '2013-04-08 18:50:00', 0),
(288, 92, '20080001', '73f84e4698e59c1c814088a0357092658bcc7a07', 'AS1-Anh', '2013-04-08 18:50:00', 0);

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
  `bank_account` varchar(20) NOT NULL DEFAULT '0',
  `info` longtext NOT NULL,
  `kind` tinyint(4) NOT NULL COMMENT '1:admin 2:org manager 3:testmarker 4:test maker',
  `del_flg` tinyint(2) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `username`, `password`, `firstname`, `lastname`, `address`, `phone`, `bank_account`, `info`, `kind`, `del_flg`, `created`, `modified`) VALUES
(5, 'root', '46f4cfdbdb6ae330d1adf29ee6f49815e1ed569f', 'duc', 'duong', NULL, NULL, '123', 'sddf', 1, 0, '2013-03-15 15:05:41', '2013-04-08 17:14:25'),
(52, 'HUST', '46f4cfdbdb6ae330d1adf29ee6f49815e1ed569f', 'HUST ハノイ工科大学', 'グエン', 'Dai co Viet', '+841234567890', '1234567890', 'OKOK', 2, 0, '2013-04-08 17:17:44', '2013-04-10 20:03:08'),
(53, 'SOSC', '46f4cfdbdb6ae330d1adf29ee6f49815e1ed569f', 'SOSC', '病院', 'Hanoi kimma', '+842345678902', '2147483647', 'OKOK\r\n', 2, 0, '2013-04-08 17:20:06', '2013-04-10 19:29:07'),
(55, 'Anh', '4f9c67f7c809c155c396ca4677f496b9bd3edd7c', 'Anh', 'Nguyen', 'Hanoi ', '+844567890123', '0', 'SOSC Anh', 4, 0, '2013-04-08 17:38:09', '2013-04-08 17:38:09'),
(56, 'Binh', '58c49c5fc13832eb18b5c0cd3bf6cc363b1b780b', 'Binh', 'le', 'hanoi', '+811111111111', '0', 'SOSC Binh', 4, 0, '2013-04-08 17:41:39', '2013-04-08 17:41:39'),
(57, 'Cuong', '34c53ecd1f8da7eb54d6df5faaf932e823fb79cf', 'Cuong', 'Ta', 'Tokyo', '+812222222222', '0', 'SOSC Cuong', 4, 0, '2013-04-08 17:43:02', '2013-04-08 17:43:02'),
(58, 'Anh', '688a44cf853042e090a249e796796dee8f7986f8', 'Anh', 'Anh', 'aaaaa', '+821111111111', '0', 'HUST Anh', 4, 1, '2013-04-08 17:58:02', '2013-04-10 20:03:09'),
(59, 'Binh', '58c49c5fc13832eb18b5c0cd3bf6cc363b1b780b', 'Binh', 'Binh', 'hanoi', '+881111111111', '0', 'HUST Binh', 4, 1, '2013-04-08 17:59:37', '2013-04-10 20:03:09'),
(60, 'Cuong', '34c53ecd1f8da7eb54d6df5faaf932e823fb79cf', 'Cuong', 'Cuong', 'Hanoi', '+891111111111', '0', 'HUST Cuong', 4, 1, '2013-04-08 18:00:46', '2013-04-10 20:03:09'),
(61, 'dantai1', '46f4cfdbdb6ae330d1adf29ee6f49815e1ed569f', 'sdfsd', 'sdf', 'fds', '+84234567890233', '12345678900000', 'sfdas', 2, 0, '2013-04-10 19:30:43', '2013-04-10 19:39:51'),
(62, 'root', '46f4cfdbdb6ae330d1adf29ee6f49815e1ed569f', 'ｓｄｆ', 'ｓｄｆ', 'ｆｓｆ', '+84234567890233', '523412432432423', 'zdfdsf', 2, 1, '2013-04-10 19:48:11', '2013-04-10 19:48:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
