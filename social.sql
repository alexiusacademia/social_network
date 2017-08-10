-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2015 at 07:27 AM
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
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(255) NOT NULL,
  `article_body` longtext NOT NULL,
  `posted_by` int(11) NOT NULL,
  `date_posted` datetime NOT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `article_title`, `article_body`, `posted_by`, `date_posted`) VALUES
(1, 'Import Terrain Surface From Google Earth to Autocad Civil 3D', 'As the title says, we will input contours from google earth to autocad civil 3D 2010.\r\nFirst, you will need to have Autocad Civil 3D and Google earth installed in your system and an internet  connection as well. First go to google earth and zoom in to areas\r\nthat you&#039;re insterested in getting the terrain, then go to Cad to set up coordinate system. Go to Toolspace,then Settings, then right click on the drawing\r\nand click Edit Drawing Settings. On Units and Zone tab, select Philippines as categories (For philippines PRS92) then on Available Coordinate system select &#039;PRS92&#039; from the dropdown list. Click apply then click Ok.\r\n<br/>\r\nNow you&#039;re good to go. type &quot;importgesurface&quot; (Google earth must be openned and there should be an internet connection), choose coordinate system, then on the Create Surface window click Ok.\r\n<br/>\r\nThe topographic layout will now be imported. Click on the surface and on the ribbon click Surface Properties &gt; Edit Surface Style.\r\n<br/>\r\nOn the contour tabs, expand contour interval then set your desired intervals.\r\n<br/>\r\nThen enjoy exploring the rest.\r\n<br/>\r\nFor questions on creating profile and cross sections of a proposed alignment, just comment.', 1, '2015-09-21 20:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `blog_comments`
--

CREATE TABLE IF NOT EXISTS `blog_comments` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog` int(11) NOT NULL,
  `comment_by` int(11) NOT NULL,
  `comment_text` varchar(255) NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `blog` (`blog`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `conversation`
--

CREATE TABLE IF NOT EXISTS `conversation` (
  `conversation_id` int(11) NOT NULL AUTO_INCREMENT,
  `user1` varchar(255) NOT NULL,
  `user2` varchar(255) NOT NULL,
  `recent_poster` varchar(255) NOT NULL,
  `isread` tinyint(1) NOT NULL,
  PRIMARY KEY (`conversation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `conversation`
--

INSERT INTO `conversation` (`conversation_id`, `user1`, `user2`, `recent_poster`, `isread`) VALUES
(2, 'mary', 'syncster31', 'mary', 1),
(3, 'syncster31', 'Zyan', 'syncster31', 1),
(6, 'syncster31', 'johnjohn', 'johnjohn', 1),
(8, 'syncster31', 'hoven', 'syncster31', 1),
(9, 'syncster31', 'marialorena', 'syncster31', 1),
(10, 'syncster31', 'reinmacapagal', 'syncster31', 0),
(11, 'reinmacapagal', 'marialorena', 'reinmacapagal', 0),
(12, 'syncster31', 'tey', 'syncster31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `forum_cat`
--

CREATE TABLE IF NOT EXISTS `forum_cat` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `forum_cat`
--

INSERT INTO `forum_cat` (`cat_id`, `cat_name`) VALUES
(1, 'General Discussion'),
(2, 'Life Hacker'),
(3, 'Engineering'),
(4, 'Operation'),
(5, 'Institutional'),
(6, 'Administrative and Finance');

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` int(11) NOT NULL,
  `posted_by` int(11) NOT NULL,
  `post_body` longtext NOT NULL,
  `date_posted` datetime NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `topic` (`topic`),
  KEY `posted_by` (`posted_by`),
  KEY `topic_2` (`topic`),
  KEY `posted_by_2` (`posted_by`),
  KEY `posted_by_3` (`posted_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`post_id`, `topic`, `posted_by`, `post_body`, `date_posted`) VALUES
(4, 5, 1, '<b>1. Please use the search box!</b><br/>\r\n\r\nIt is possible that the topic or question you are about to post to has has already been created or addressed, in regard to this, please use the search box before creating any topic.<br/>\r\n\r\n\r\n\r\n<b>2. Be desciptive</b><br/>\r\n\r\nDo not create topics that has nothing to do or not related to your posts<br/>\r\n\r\n\r\n\r\n<b>3. No spam</b><br/>\r\n\r\nPlease do not post repetitive contents just to update the topics.<br/>\r\n\r\n\r\n\r\n<b>4. Do not post copyright-infringing materials</b><br/>\r\n\r\nProviding or asking illegally obtained copyright materials is prohibited in this site.<br/>\r\n\r\n\r\n\r\n<b>5. Respect one another at all times</b><br/>\r\n\r\nAlways be professional while creating topics or posts. Be courteous to others at all times.<br/> \r\n\r\nYou can disagree to other users by explaining your perspective where you should do in a nicely manner.<br/>', '2015-09-19 15:26:15');

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE IF NOT EXISTS `forum_topics` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat` int(11) NOT NULL,
  `topic_title` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`topic_id`),
  KEY `cat` (`cat`),
  KEY `cat_2` (`cat`),
  KEY `created_by` (`created_by`),
  KEY `created_by_2` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`topic_id`, `cat`, `topic_title`, `created_by`, `date_created`) VALUES
(2, 3, 'Backlog 2012', 'syncster31', '2015-09-14 15:02:00'),
(3, 3, 'Proposed Projects 2016', 'syncster31', '2015-09-14 15:16:00'),
(4, 4, 'Clearing at Main Canal of TARRIS', 'syncster31', '2015-09-14 14:32:00'),
(5, 1, 'Posting Guidelines', 'syncster31', '2015-09-17 07:58:55'),
(6, 1, 'Site Rules', 'syncster31', '2015-09-17 07:59:47'),
(7, 3, 'Program of Works 2016', 'syncster31', '2015-09-17 08:00:32'),
(8, 4, 'MC 55 WMR Geotagged', 'Zyan', '2015-09-17 22:04:46'),
(9, 1, 'End of the world', 'syncster31', '2015-09-18 16:35:35'),
(10, 3, 'Emergency Projects', 'syncster31', '2015-09-19 23:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE IF NOT EXISTS `friend_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `request_from` varchar(255) NOT NULL,
  `request_to` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `conversation` bigint(20) NOT NULL,
  `message_body` text NOT NULL,
  `date_sent` datetime NOT NULL,
  `sent_by` varchar(255) NOT NULL,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `conversation`, `message_body`, `date_sent`, `sent_by`) VALUES
(2, 1, 'some texts in here', '2015-09-16 03:12:18', 'syncster31'),
(3, 1, 'this is a messageg', '2015-09-16 07:22:25', 'syncster31'),
(4, 2, 'hello there', '2015-09-16 08:24:24', 'syncster31'),
(5, 1, 'Test message', '2015-09-16 18:31:43', 'syncster31'),
(6, 3, 'test message\r\n', '2015-09-16 18:36:04', 'Zyan'),
(7, 3, 'oh it works!haha', '2015-09-16 18:36:19', 'syncster31'),
(8, 3, 'sakit sa mata', '2015-09-16 18:36:31', 'Zyan'),
(9, 3, 'nung blue', '2015-09-16 18:36:37', 'Zyan'),
(10, 3, 'haha\r\n', '2015-09-16 18:36:46', 'syncster31'),
(11, 3, 'ano kulay pala\r\n', '2015-09-16 18:36:57', 'syncster31'),
(12, 3, 'background nung text', '2015-09-16 18:37:22', 'Zyan'),
(13, 3, 'test', '2015-09-16 18:38:37', 'Zyan'),
(14, 3, 'test', '2015-09-16 18:43:14', 'Zyan'),
(15, 3, 'test2', '2015-09-16 18:43:37', 'Zyan'),
(16, 1, 'anoter one', '2015-09-16 19:27:40', 'syncster31'),
(17, 3, 'hello', '2015-09-16 19:27:50', 'syncster31'),
(18, 3, 'toinkz', '2015-09-16 19:28:40', 'syncster31'),
(19, 3, 'msg', '2015-09-16 19:29:23', 'Zyan'),
(20, 3, 'test', '2015-09-16 19:29:41', 'Zyan'),
(21, 1, 'sg dtr hdr ', '2015-09-16 19:31:38', 'syncster31'),
(22, 1, 'dfsdgsdf', '2015-09-16 19:35:12', 'syncster31'),
(23, 1, 'aaaaa', '2015-09-16 19:45:58', 'syncster31'),
(24, 1, 'hi', '2015-09-16 19:49:49', 'johnjohn'),
(25, 3, 'zi test again', '2015-09-16 19:50:01', 'syncster31'),
(26, 3, 'test', '2015-09-16 19:51:43', 'Zyan'),
(27, 3, 'TRY', '2015-09-16 20:15:14', 'syncster31'),
(28, 0, '', '2015-09-16 20:43:53', 'syncster31'),
(29, 6, 'hello there!', '2015-09-16 21:31:20', 'syncster31'),
(30, 6, 'dfg dkjf dfg f', '2015-09-16 21:31:43', 'johnjohn'),
(31, 6, 'Test message again...', '2015-09-19 21:37:02', 'johnjohn'),
(32, 9, 'hello..hehe', '2015-09-21 13:46:14', 'syncster31'),
(33, 9, 'ano pa kaya idagdag marie?', '2015-09-21 14:18:07', 'syncster31'),
(34, 10, 'macapagal k pala.toinkz', '2015-09-21 15:13:50', 'syncster31'),
(35, 10, 'Opo. middle name po yung gracia\r\n', '2015-09-21 15:15:22', 'reinmacapagal'),
(36, 10, 'haha mas maganda un gracia. middle mo na lng ung reynalyn.hehe', '2015-09-21 15:16:19', 'syncster31'),
(37, 10, 'Rein nalang po para mas madali. :-D', '2015-09-21 15:18:33', 'reinmacapagal'),
(38, 10, 'hmm masyado sosyal un.toinks hehe\r\nsige kaw bahala.', '2015-09-21 15:19:07', 'syncster31'),
(39, 10, 'nagtry ka ba magpalit ng profile pic?hehe', '2015-09-21 15:19:51', 'syncster31'),
(40, 10, 'hindi po. wala po akong ipampapalit. ahaha', '2015-09-21 15:22:21', 'reinmacapagal'),
(41, 10, 'ahh.. nabura kasi ung default image eh.haha', '2015-09-21 15:24:02', 'syncster31'),
(42, 10, 'ahh.. nabura kasi ung default image eh.haha', '2015-09-21 15:24:02', 'syncster31'),
(43, 10, 'Para san po pala to? ', '2015-09-21 15:27:01', 'reinmacapagal'),
(44, 10, 'social site ng mga taga NIA.hehe', '2015-09-21 15:31:34', 'syncster31'),
(45, 11, 'Ate Marie?\r\n', '2015-09-21 15:35:03', 'reinmacapagal'),
(46, 10, 'Bago lang po no? Konti pa lang mga members e. ', '2015-09-21 15:37:04', 'reinmacapagal'),
(47, 10, 'oo bago pa. di pa nga tapos eh.. andito pa sa pc ko to di pa nakaupload.', '2015-09-21 15:39:09', 'syncster31'),
(48, 10, 'Ah. gawa niyo po?', '2015-09-21 15:46:55', 'reinmacapagal'),
(49, 10, 'oo ako gumagawa..', '2015-09-21 15:47:41', 'syncster31'),
(50, 10, 'may alam ka ba sa programming?', '2015-09-21 15:54:45', 'syncster31'),
(51, 10, 'Wala po. ahaha', '2015-09-21 16:02:13', 'reinmacapagal'),
(52, 10, 'hehe toinkz.. kala ko meron e', '2015-09-21 16:03:49', 'syncster31'),
(53, 10, 'Wala po. Di po kami tinuruan nung college. ahaha', '2015-09-21 16:04:50', 'reinmacapagal'),
(54, 10, 'ah.hehe.. la ka kakilala?', '2015-09-21 16:08:20', 'syncster31'),
(55, 10, 'Meron po. Kaso di ko din maintindahan Ahahah', '2015-09-21 16:17:22', 'reinmacapagal'),
(56, 10, 'haha', '2015-09-21 16:19:11', 'syncster31'),
(57, 12, 'Hi mam..hheehe', '2015-09-21 17:26:39', 'syncster31'),
(58, 10, 'upload kn pic u.haha', '2015-09-22 13:19:04', 'syncster31');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `date_added` date NOT NULL,
  `added_by` varchar(255) NOT NULL,
  `user_posted_to` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `body`, `date_added`, `added_by`, `user_posted_to`) VALUES
(1, 'This is a sample post...', '2015-09-10', 'syncster31', 'syncster31'),
(2, 'This is another post', '2015-09-10', 'syncster31', 'syncster31'),
(3, 'Hi johnjohn!', '2015-09-10', 'syncster31', 'johnjohn'),
(4, 'Hi syncster!', '2015-09-10', 'johnjohn', 'syncster31'),
(5, 'Hi syncster!', '2015-09-10', 'johnjohn', 'syncster31'),
(6, 'hello there!', '2015-09-10', 'johnjohn', 'syncster31'),
(7, 'This is another message', '2015-09-10', 'johnjohn', 'johnjohn'),
(8, 'trying to spam you!\r\n', '2015-09-10', 'johnjohn', 'johnjohn'),
(9, 'hi there!', '2015-09-10', 'johnjohn', 'syncster31'),
(10, 'i want to send  u spam msg!', '2015-09-10', 'johnjohn', 'syncster31'),
(11, 'try to fill ur inbox', '2015-09-10', 'johnjohn', 'syncster31'),
(12, 'how can i do that?', '2015-09-10', 'johnjohn', 'johnjohn'),
(13, 'how can i do?', '2015-09-10', 'johnjohn', 'syncster31'),
(14, 'a,tjdfghlos jljdfg kjdfjg', '2015-09-10', 'johnjohn', 'syncster31'),
(15, 'zsfgjdg jdshfjg sdfjg ksdfjg dghjf', '2015-09-10', 'johnjohn', 'syncster31'),
(16, 'xfdj gxdh dfjhg jhdfgjsdf jdfsgj dfghfj jsd', '2015-09-10', 'johnjohn', 'syncster31'),
(17, 'jhssgrhsdg dffjhg jdfgl d', '2015-09-10', 'johnjohn', 'syncster31');

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE IF NOT EXISTS `timeline` (
  `timeline_id` int(11) NOT NULL AUTO_INCREMENT,
  `poster` int(11) NOT NULL,
  `post` longtext NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`timeline_id`),
  KEY `poster` (`poster`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `timeline`
--

INSERT INTO `timeline` (`timeline_id`, `poster`, `post`, `post_date`) VALUES
(2, 1, 'This is my first post to timeline.. I hope this works because I have done so much coding in this...', '2015-09-13 13:50:36'),
(3, 1, 'This is my first post to timeline.. I hope this works because I have done so much coding in this...', '2015-09-13 13:52:32'),
(4, 1, 'This is another timeline post.. This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..   This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post..  This is another timeline post.. ', '2015-09-13 14:38:11'),
(5, 1, 'wegkufej erriifj .lerkj flr fkjj  This is another timeline post..  HMAGD,K3H. 3KRF KJ3F JL FGKDFJ  jdfg kj dfjg jkl', '2015-09-13 14:39:18'),
(6, 3, 'Hello! This is my first post on my blog!!!!!!!!!', '2015-09-13 14:53:53'),
(7, 3, 'dddddddddddddddddddddddddddddddddddddddddddddddddddddddd,,,,,ddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddvdddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', '2015-09-13 15:55:05'),
(9, 1, 'ok ill try another post!', '2015-09-13 23:22:21'),
(10, 1, 'Try another post!', '2015-09-14 05:23:28'),
(11, 1, 'This wil be error\r\n', '2015-09-14 05:23:45'),
(12, 1, 'This wil be error\r\n', '2015-09-14 05:24:40'),
(13, 2, 'i want to post this', '2015-09-15 19:14:57'),
(14, 1, 'this is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nthis is a long l\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nthis is a long l\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nthis is a long l\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nthis is a long l\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nthis is a long l\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nv\r\nthis is a long long post for blog\r\nthis is a long l', '2015-09-15 21:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `sex` varchar(6) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `sign_up_date` datetime NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `activated` enum('0','1') NOT NULL,
  `region` enum('CAR','Region 1','Region 2','Region 2','MRIIS','Region 3','UPRIIS','Region 4A','Region 4B','Region 5','Region 6','Region 7','Region 8','Region 9','Region 10','Region 11','Region 12','Region 13','Central Office') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `sex`, `email`, `password`, `sign_up_date`, `avatar`, `activated`, `region`) VALUES
(1, 'syncster31', 'Alexius S. ', 'Academia', 'male', 'alexius.academia@gmail.com', '0f5b1ce0cfd7b187d64d1a75901559e1', '2015-09-09 10:00:00', 'avatar/7UTaixVFepPIQcs/binary-code-image.jpg', '1', 'Region 3'),
(2, 'johnjohn', 'John Alfred', 'Academia', 'male', 'syncster31@gmail.com', '01d533ae1fe67f7043daa1386e2ad4f6', '2015-09-10 00:00:00', 'img/male.jpg', '0', 'CAR'),
(3, 'mary', 'Mary Desilou', 'Academia', 'female', 'marydesilou@yahoo.com', '5e6a46b76e3e5edb7ba8c3ca570fb651', '2015-09-10 00:00:00', 'img/female.jpg', '0', 'CAR'),
(5, 'Zyan', 'Zyan', 'dela Cruz', 'male', 'zyandellbertdelacruz@ymail.com', '249513a1870d5be6aef855f2676377b7', '2015-09-14 19:46:04', 'avatar/6QDkHGuRCKzoWd5/MacLogo.jpg', '1', 'Region 3'),
(6, 'hoven', 'hoven', 'dela cruz', 'male', 'hovendelacruz@yahoo.com', '98bdde046250c5fcefdcae44c78d2952', '2015-09-14 19:59:48', 'avatar/9DwROih2kTdUjrg/transformers_4_bumblebee_by_cbpitts-d7l1dri.png', '1', 'Region 3'),
(7, 'marialorena', 'Maria Lorena', 'Bagorio', 'female', 'bagorio.lorena@yahoo.com', 'c84964985a4eaa03015959dcfdb22c58', '2015-09-21 13:45:52', 'avatar/mRH1v9SrZgpsOhT/IMG_20140502_021958.jpg', '1', 'Region 3'),
(8, 'reinmacapagal', 'Reinalyn', 'Macapagal', 'female', 'macapagalreinalyn@gmail.com', '7ad802f85fa7dce50cfe713180ab3e00', '2015-09-21 15:11:36', 'img/female.jpg', '1', 'Region 3'),
(9, 'tey', 'Rachelle', 'Dizon', 'female', 'teygd72@yahoo.com', '8148fa6ef3a819424730b4c1f8465928', '2015-09-21 17:20:37', 'img/female.jpg', '1', 'Region 3');

-- --------------------------------------------------------

--
-- Table structure for table `users_log`
--

CREATE TABLE IF NOT EXISTS `users_log` (
  `log_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `last_active` timestamp NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `users_log`
--

INSERT INTO `users_log` (`log_id`, `session_id`, `username`, `last_active`, `status`) VALUES
(20, 'g6u3tu2tbgu7d5lu8edgcufkl3', 'syncster31', '2015-09-22 03:07:37', 0),
(21, 'g6u3tu2tbgu7d5lu8edgcufkl3', 'syncster31', '2015-09-22 03:59:34', 0),
(22, '2pb148froqug9nig9174ojo4l3', 'reinmacapagal', '2015-09-22 05:17:29', 1),
(23, 'g6u3tu2tbgu7d5lu8edgcufkl3', 'syncster31', '2015-09-22 05:26:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `message_id` bigint(20) NOT NULL,
  KEY `message_id` (`message_id`),
  KEY `message_id_2` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_messages`
--

INSERT INTO `user_messages` (`sender`, `receiver`, `message_id`) VALUES
(1, 2, 2);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_comments`
--
ALTER TABLE `blog_comments`
  ADD CONSTRAINT `blog_comments_ibfk_1` FOREIGN KEY (`blog`) REFERENCES `timeline` (`timeline_id`);

--
-- Constraints for table `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD CONSTRAINT `forum_posts_ibfk_1` FOREIGN KEY (`topic`) REFERENCES `forum_topics` (`topic_id`) ON DELETE CASCADE;

--
-- Constraints for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD CONSTRAINT `forum_topics_ibfk_1` FOREIGN KEY (`cat`) REFERENCES `forum_cat` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timeline`
--
ALTER TABLE `timeline`
  ADD CONSTRAINT `timeline_ibfk_1` FOREIGN KEY (`poster`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_messages`
--
ALTER TABLE `user_messages`
  ADD CONSTRAINT `user_messages_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
