-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2015 at 04:36 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `social`
--

-- --------------------------------------------------------

--
-- Table structure for table `gallery_uploads`
--

CREATE TABLE IF NOT EXISTS `gallery_uploads` (
  `upload_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `date_uploaded` datetime NOT NULL,
  PRIMARY KEY (`upload_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `gallery_uploads`
--

INSERT INTO `gallery_uploads` (`upload_id`, `image_url`, `image_name`, `album_name`, `owner`, `date_uploaded`) VALUES
(3, 'litrato/pDYvIA58y76BGmX/5607640dbf5311443324941.jpg', '5607640dbf53b1443324941.jpg', 'Family', 'syncster31', '2015-09-27 11:35:41'),
(4, 'litrato/2QZb5nOigL7lTFS/5607645173bd91443325009.jpg', '5607645173bdf1443325009.jpg', 'My Pets', 'syncster31', '2015-09-27 11:36:49'),
(5, 'litrato/vCrKMJmt4W6bksY/5607647a7fe861443325050.jpg', '5607647a7fea51443325050.jpg', 'My Self', 'syncster31', '2015-09-27 11:37:30'),
(6, 'litrato/Pm3qntM5fy6YaGH/56077be8d70ff1443331048.jpg', '56077be8d71051443331048.jpg', 'Travel', 'syncster31', '2015-09-27 13:17:28'),
(7, 'litrato/rHtKEX5zYyj1d6V/56078e7a9625b1443335802.jpg', '56078e7a962911443335802.jpg', 'Vacation', 'syncster31', '2015-09-27 14:36:42'),
(8, 'litrato/FbEHf8ktBxwpaYh/5607d219996261443353113.jpg', '5607d2199962e1443353113.jpg', 'Family', 'syncster31', '2015-09-27 19:25:13'),
(9, 'litrato/COnFhMGVTLeu5kW/5607fbba1b0e21443363770.jpg', '5607fbba1b0e91443363770.jpg', 'Vacation', 'syncster31', '2015-09-27 22:22:50'),
(10, 'litrato/YfQHo85EzIlej4A/5607fbcfc96081443363791.jpg', '5607fbcfc960f1443363791.jpg', 'Vacation', 'syncster31', '2015-09-27 22:23:11'),
(11, 'litrato/scBz3j2GRtoylnb/5607fd187253c1443364120.jpg', '5607fd18725431443364120.jpg', 'Vacation', 'syncster31', '2015-09-27 22:28:40'),
(12, 'litrato/FphvPm2VWOyu9bj/5607fd2275bd61443364130.jpg', '5607fd2275bdc1443364130.jpg', 'Vacation', 'syncster31', '2015-09-27 22:28:50');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
