-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 17, 2019 at 12:31 PM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE IF EXISTS `rapidsTest`;
CREATE DATABASE IF NOT EXISTS `rapidsTest` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `rapidsTest`;

--
-- Database: `rapidsTest`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminUsers`
--

CREATE TABLE `adminUsers` (
  `id` int(11) NOT NULL,
  `username` varchar(12) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `type` char(1) COLLATE utf8_bin NOT NULL,
  `sqa1` text COLLATE utf8_bin NOT NULL,
  `sqa2` text COLLATE utf8_bin NOT NULL,
  `sqa3` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `adminUsers`
--

INSERT INTO `adminUsers` (`id`, `username`, `password`, `type`, `sqa1`, `sqa2`, `sqa3`) VALUES
(3, 'admin', '$2y$12$/x/OHya5Mlqod1EThCnZ7u8zNmZJz.5tIqFc8LbJqioKri/vUi0CG', 'A', 'a', 'b', 'c');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL,
  `contact_name` text COLLATE utf8_bin NOT NULL,
  `message` text COLLATE utf8_bin NOT NULL,
  `contact_email` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`contact_id`, `contact_name`, `message`, `contact_email`) VALUES
(1, 'Johnny C', 'I like Rapids Cemetery.  It is cool.', 'johnnyc@gmail.com'),
(2, 'Betty F', 'I like the flowers and meditation garden.  Super cool!', 'bettyf@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `faq_id` int(11) NOT NULL,
  `question` text COLLATE utf8_bin NOT NULL,
  `answer` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`faq_id`, `question`, `answer`) VALUES
(1, 'What is Rapids Cemetery?', 'A very cool place.'),
(2, 'Who is buried here?', 'Some cool people.'),
(3, 'How old is Rapids Cemetery?', 'It it very old.');

-- --------------------------------------------------------

--
-- Table structure for table `global`
--

CREATE TABLE `global` (
  `global_id` int(11) NOT NULL,
  `name` varchar(20) COLLATE utf8_bin NOT NULL,
  `data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `global`
--

INSERT INTO `global` (`global_id`, `name`, `data`) VALUES
(1, 'map_api_key', 'pk.eyJ1Ijoic3BlbmNlcmdyZWVuIiwiYSI6ImNqcmIwbG1ycTAwcTE0OXBma3M2cXZlOXYifQ.GwKx_RQjXh_-ZZ7SeXob5g');

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `hlID` int(11) NOT NULL,
  `hl_name` text COLLATE utf8_bin NOT NULL,
  `hl_desc` text COLLATE utf8_bin NOT NULL,
  `hl_url` text COLLATE utf8_bin NOT NULL,
  `is_trail` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`hlID`, `hl_name`, `hl_desc`, `hl_url`, `is_trail`) VALUES
(1, 'Susan B. Anthony House', 'Susan B. Anthony House, in Rochester, New York, was the home of Susan B. Anthony for forty years, while she was a national figure in the women\'s rights movement. She was arrested in the front parlor after attempting to vote in the 1872 Presidential Election. She resided here until her death.', 'http://susanbanthonyhouse.org/index.php', 0),
(2, 'Heritage Trail', 'Come and explore history in downtown Rochester on The Heritage Trail, a 1.25-mile long walking path that leads visitors to 15 points of historical significance. This self-guided tour follows an 8” wide line of either granite or blue paint on city sidewalks, along the way visitors will find historical markers, plaques, and interpretive signs telling some of the stories that make up Rochester’s rich history.', 'https://www.cityofrochester.gov/article.aspx?id=8589951966', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loc_coordinate`
--

CREATE TABLE `loc_coordinate` (
  `loc_point_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `lat` double NOT NULL,
  `long` double NOT NULL,
  `hlID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `loc_coordinate`
--

INSERT INTO `loc_coordinate` (`loc_point_id`, `order`, `lat`, `long`, `hlID`) VALUES
(21, 0, 43.131303400918, -77.652053833008, 2),
(26, 0, 43.175635224539, -77.582702636719, 1);

-- --------------------------------------------------------

--
-- Table structure for table `loc_media`
--

CREATE TABLE `loc_media` (
  `media_id` int(11) NOT NULL,
  `hlID` int(11) NOT NULL,
  `filename` text COLLATE utf8_bin NOT NULL,
  `type` varchar(5) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `loc_media`
--

INSERT INTO `loc_media` (`media_id`, `hlID`, `filename`, `type`) VALUES
(1, 1, '../media/sue.jpg', 'image'),
(2, 2, '../media/htrail.gif', 'image');

-- --------------------------------------------------------

--
-- Table structure for table `point_of_interest`
--

CREATE TABLE `point_of_interest` (
  `poiID` int(11) NOT NULL,
  `poiName` text COLLATE utf8_bin,
  `poiDescription` text COLLATE utf8_bin,
  `poiLocation` text COLLATE utf8_bin,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `point_of_interest`
--

INSERT INTO `point_of_interest` (`poiID`, `poiName`, `poiDescription`, `poiLocation`, `visible`) VALUES
(3, 'Bartlett, Eliot', 'Born 1759; died 1851 ; age 87.\r\n\r\nDr. DeMarle raises the question whether Eliot (or Elliot) Bartlett is recognized as a\r\nRevolutionary War Veteran (Vermont Militia).\r\n\r\n“Bartlett: Significantly there is very strong evidence pointing to the fact that Eliott Bartlett\r\nserved in the Revolutionary war, or to state it another way, that the Eliott Bartlett who served in\r\nthe revolutionary war, is the Eliott Bartlett who is in the Rapids cemetery.”\r\n\r\nSon: Orange Bartlett Born Dec. 16, 1789 in Vermont - (mother: Abigail).\r\nDied in Gates, NY Jan. 6, 1847.\r\n\r\nDaughter: Hannah Rose Bartlett (1818 -1902); born in Mass.', 'Rapids Cemetery Plot J - 7', 1),
(4, 'Black, Andrew', 'no headstone found', 'Rapids Cemetery Plot T - 9', 0),
(5, 'Bartlett, Cyrus S.', 'Son of Cyrus W. & Sara (second wife?); born 1829; died Aug.3, 1830; age 11 months', 'unknown', 0),
(6, 'Hulin, Charlotte', '- daughter of Truman & Charlotte; born 1837; died Jan. 25, 1862 ; age 25\r\n\r\n2-piece restorable Headstone (unearthed 2017)', 'Rapids Cemetery Plot H - 7', 1);

-- --------------------------------------------------------

--
-- Table structure for table `poi_coordinate`
--

CREATE TABLE `poi_coordinate` (
  `point_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `lat` double NOT NULL,
  `long` double NOT NULL,
  `poiID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `poi_coordinate`
--

INSERT INTO `poi_coordinate` (`point_id`, `order`, `lat`, `long`, `poiID`) VALUES
(7, 1, 87.9, 67.89, 4),
(8, 1, 123.45, 10.578, 5),
(24, 0, 43.129579386406, -77.639035731554, 6),
(30, 0, 43.129562365317, -77.639558762312, 3),
(31, 1, 43.129423382518, -77.639553397894, 3),
(32, 2, 43.129505597733, -77.639322727919, 3);

-- --------------------------------------------------------

--
-- Table structure for table `poi_media`
--

CREATE TABLE `poi_media` (
  `media_id` int(11) NOT NULL,
  `poiID` int(11) NOT NULL,
  `filename` text COLLATE utf8_bin NOT NULL,
  `type` varchar(5) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `poi_media`
--

INSERT INTO `poi_media` (`media_id`, `poiID`, `filename`, `type`) VALUES
(1, 3, '../media/image1.png', 'image'),
(2, 3, '../media/audio1.mp3', 'audio');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `poiID` int(11) NOT NULL,
  `tag_name` text COLLATE utf8_bin NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`poiID`, `tag_name`, `tag_id`) VALUES
(4, 'Civil War', 3),
(4, 'Cool', 4),
(5, 'War of 1812', 5),
(6, 'Civil War', 22),
(3, 'Burial', 25);

-- --------------------------------------------------------

--
-- Table structure for table `timeline`
--

CREATE TABLE `timeline` (
  `timeID` int(11) NOT NULL,
  `point_name` text COLLATE utf8_bin NOT NULL,
  `point_year` int(4) NOT NULL,
  `point_tooltip` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `timeline`
--

INSERT INTO `timeline` (`timeID`, `point_name`, `point_year`, `point_tooltip`) VALUES
(1, 'Civil War', 1861, 'The Civil War started Apr 12, 1861 and ended on Apr 9, 1865.'),
(2, 'Susan B. Anthony', 1906, 'Susan B. Anthony Died: March 13, 1906, Rochester, NY');

-- --------------------------------------------------------

--
-- Table structure for table `tour`
--

CREATE TABLE `tour` (
  `poiID` int(11) NOT NULL,
  `tour_order` int(11) NOT NULL,
  `tour_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tour`
--

INSERT INTO `tour` (`poiID`, `tour_order`, `tour_id`) VALUES
(3, 1, 1),
(4, 2, 2),
(5, 3, 3),
(6, 4, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminUsers`
--
ALTER TABLE `adminUsers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `global`
--
ALTER TABLE `global`
  ADD PRIMARY KEY (`global_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`hlID`);

--
-- Indexes for table `loc_coordinate`
--
ALTER TABLE `loc_coordinate`
  ADD PRIMARY KEY (`loc_point_id`),
  ADD KEY `hlID` (`hlID`);

--
-- Indexes for table `loc_media`
--
ALTER TABLE `loc_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `hlID` (`hlID`);

--
-- Indexes for table `point_of_interest`
--
ALTER TABLE `point_of_interest`
  ADD PRIMARY KEY (`poiID`);

--
-- Indexes for table `poi_coordinate`
--
ALTER TABLE `poi_coordinate`
  ADD PRIMARY KEY (`point_id`),
  ADD KEY `poiID` (`poiID`);

--
-- Indexes for table `poi_media`
--
ALTER TABLE `poi_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `poiID` (`poiID`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD KEY `poiID` (`poiID`);

--
-- Indexes for table `timeline`
--
ALTER TABLE `timeline`
  ADD PRIMARY KEY (`timeID`);

--
-- Indexes for table `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `poiID` (`poiID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminUsers`
--
ALTER TABLE `adminUsers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `global`
--
ALTER TABLE `global`
  MODIFY `global_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `hlID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `loc_coordinate`
--
ALTER TABLE `loc_coordinate`
  MODIFY `loc_point_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `loc_media`
--
ALTER TABLE `loc_media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `point_of_interest`
--
ALTER TABLE `point_of_interest`
  MODIFY `poiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `poi_coordinate`
--
ALTER TABLE `poi_coordinate`
  MODIFY `point_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `poi_media`
--
ALTER TABLE `poi_media`
  MODIFY `media_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `timeline`
--
ALTER TABLE `timeline`
  MODIFY `timeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tour`
--
ALTER TABLE `tour`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `loc_coordinate`
--
ALTER TABLE `loc_coordinate`
  ADD CONSTRAINT `loc_coordinate_ibfk_1` FOREIGN KEY (`hlID`) REFERENCES `location` (`hlID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `loc_media`
--
ALTER TABLE `loc_media`
  ADD CONSTRAINT `loc_media_ibfk_1` FOREIGN KEY (`hlID`) REFERENCES `location` (`hlID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poi_coordinate`
--
ALTER TABLE `poi_coordinate`
  ADD CONSTRAINT `poi_coordinate_ibfk_1` FOREIGN KEY (`poiID`) REFERENCES `point_of_interest` (`poiID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poi_media`
--
ALTER TABLE `poi_media`
  ADD CONSTRAINT `poi_media_ibfk_1` FOREIGN KEY (`poiID`) REFERENCES `point_of_interest` (`poiID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tag`
--
ALTER TABLE `tag`
  ADD CONSTRAINT `tag_ibfk_1` FOREIGN KEY (`poiID`) REFERENCES `point_of_interest` (`poiID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `tour_ibfk_1` FOREIGN KEY (`poiID`) REFERENCES `point_of_interest` (`poiID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
