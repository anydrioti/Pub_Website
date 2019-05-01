-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2017 at 04:57 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `beerresdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `RESERVEID` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `TABLEID` int(11) NOT NULL,
  `TABLE2` varchar(20) DEFAULT NULL,
  `TABLE3` varchar(20) DEFAULT NULL,
  `RESMADEIN` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RESDATE` varchar(20) NOT NULL,
  `RESTIME` varchar(10) NOT NULL,
  `RESEND` varchar(10) NOT NULL,
  `CLOSEDBY` varchar(10) NOT NULL,
  `CLOSEDVIA` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`RESERVEID`, `USERID`, `TABLEID`, `TABLE2`, `TABLE3`, `RESMADEIN`, `RESDATE`, `RESTIME`, `RESEND`, `CLOSEDBY`, `CLOSEDVIA`) VALUES
(4, 1, 8, NULL, NULL, '2017-05-14 16:23:02', '05/14/2017', '20:00', '22:00', 'user', 'website'),
(5, 3, 2, NULL, NULL, '2017-05-15 09:01:31', '05/15/2017', '16:00', '18:00', 'user', 'website'),
(6, 3, 4, NULL, NULL, '2017-05-15 09:05:56', '05/16/2017', '19:00', '21:00', 'user', 'website'),
(7, 3, 5, NULL, NULL, '2017-05-15 09:12:07', '05/15/2017', '18:00', '20:00', 'user', 'website'),
(8, 3, 7, NULL, NULL, '2017-05-15 09:13:01', '05/15/2017', '18:00', '20:00', 'user', 'website'),
(9, 3, 3, NULL, NULL, '2017-05-15 09:22:01', '05/16/2017', '16:00', '18:00', 'user', 'website'),
(10, 3, 21, NULL, NULL, '2017-05-15 09:35:51', '05/16/2017', '16:00', '18:00', 'user', 'website'),
(11, 3, 30, NULL, NULL, '2017-05-15 09:35:56', '05/16/2017', '16:00', '18:00', 'user', 'website'),
(12, 3, 30, NULL, NULL, '2017-05-15 09:35:58', '05/16/2017', '16:00', '18:00', 'user', 'website'),
(13, 3, 10, NULL, NULL, '2017-05-15 09:43:31', '05/15/2017', '19:00', '21:00', 'user', 'website'),
(14, 3, 6, '16', NULL, '2017-05-15 09:49:44', '05/15/2017', '18:00', '20:00', 'user', 'website'),
(15, 3, 13, '20', NULL, '2017-05-15 10:11:53', '05/15/2017', '16:00', '18:00', 'user', 'website'),
(16, 3, 17, '16', '14', '2017-05-15 10:13:08', '05/15/2017', '19:00', '21:00', 'user', 'website'),
(17, 1, 11, NULL, NULL, '2017-05-21 16:31:35', '05/21/2017', '21:00', '23:00', 'user', 'website'),
(18, 1, 34, '37', '15', '2017-05-21 16:37:44', '05/24/2017', '20:00', '22:00', 'user', 'website'),
(19, 1, 37, '34', '13', '2017-05-21 16:45:37', '05/21/2017', '21:00', '23:00', 'Admin', 'website'),
(20, 1, 29, NULL, NULL, '2017-05-21 16:56:56', '05/22/2017', '16:00', '18:00', 'Admin', 'Telephone');

-- --------------------------------------------------------

--
-- Table structure for table `res_details`
--

CREATE TABLE `res_details` (
  `RESDETID` int(11) NOT NULL,
  `RESID` int(11) NOT NULL,
  `PARTY` int(11) NOT NULL,
  `FIRSTNAME` varchar(20) NOT NULL,
  `LASTNAME` varchar(20) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PHONE` varchar(10) NOT NULL,
  `OCCASION` varchar(20) NOT NULL,
  `REQUESTS` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_details`
--

INSERT INTO `res_details` (`RESDETID`, `RESID`, `PARTY`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PHONE`, `OCCASION`, `REQUESTS`) VALUES
(3, 4, 1, 'Loukas', 'Boruch', 'lboruch@yahoo.com', '2106512345', 'visit', '1Lt Cups only'),
(4, 5, 8, 'Loukas', 'Boruch', 'lboruch@yahoo.com', '2106512345', 'bday', 'Greet us in spanish'),
(5, 6, 7, 'Theodoros', 'Boruch', 'tliaskos@yahoo.gr', '2106512345', 'thanksgiving', 'I\'ll bring a cake for our friend. keep it chilled until I signal you'),
(6, 7, 7, 'Loukas', 'Boruch', 'lboruch@yahoo.com', '2106512345', 'visit', 'nothing special'),
(7, 8, 3, 'Loukas', 'Boruch', 'lboruch@yahoo.com', '2106512345', 'visit', 'nothing special'),
(8, 9, 7, 'Loukas', 'Glitsas', 'thouser@gmail.com', '2106512345', 'visit', ''),
(9, 10, 6, 'Loukas', 'Glitsas', 'thouser@gmail.com', '2106512345', 'visit', ''),
(10, 11, 6, 'Loukas', 'Glitsas', 'thouser@gmail.com', '2106512345', 'visit', ''),
(11, 12, 6, 'Loukas', 'Glitsas', 'tliaskos@yahoo.gr', '2106512345', 'visit', ''),
(12, 13, 4, 'Loukas', 'Glitsas', 'tliaskos@yahoo.gr', '2106512345', 'visit', ''),
(13, 14, 6, 'Theodoros', 'Glitsas', 'tliaskos@yahoo.gr', '2106512345', 'visit', 'nothing special'),
(14, 15, 11, 'YHJGJGH', 'HGJGHJH', 'tliaskos@yahoo.gr', '2106512345', 'thanksgiving', 'Have a card ready! name : kwstas'),
(15, 16, 11, 'YHJGJGH', 'HGJGHJH', 'tliaskos@yahoo.gr', '2106512345', 'backelor', 'Have your strongest beer served to us,once every 3 rounds'),
(16, 17, 4, 'filippos', 'georgiou', 'fgeorgiou@yahoo.gr', '6934423432', 'bday', 'HELLO'),
(17, 18, 10, 'filippos', 'georgiou', 'filippos1908@yahoo.com', '6934423432', 'anniv', 'My Fiancee adores street cats. Please fill the place'),
(18, 19, 10, 'filippos', 'georgiou', 'fgeorgiou@yahoo.gr', '6934423432', 'bday', 'Cake Please'),
(19, 20, 1, 'filippos', 'georgiou', 'fgeorgiou@yahoo.gr', '6934423432', 'thanksgiving', '');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `SECTIONID` int(11) NOT NULL,
  `SECNAME` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`SECTIONID`, `SECNAME`) VALUES
(1, 'Smoker_Area'),
(2, 'Non_Smoker_Area');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `TABLEID` int(11) NOT NULL,
  `SECTIONID` int(11) NOT NULL,
  `SEATS` varchar(1) NOT NULL,
  `STATUS` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`TABLEID`, `SECTIONID`, `SEATS`, `STATUS`) VALUES
(1, 1, '2', 'Available'),
(2, 1, '2', 'Available'),
(3, 1, '2', 'Available'),
(4, 1, '2', 'Available'),
(5, 1, '2', 'Available'),
(6, 1, '2', 'Available'),
(7, 1, '2', 'Available'),
(8, 1, '2', 'Available'),
(9, 1, '2', 'Available'),
(10, 1, '2', 'Available'),
(11, 1, '4', 'Available'),
(12, 1, '4', 'Available'),
(13, 1, '4', 'Available'),
(14, 1, '4', 'Available'),
(15, 1, '4', 'Available'),
(16, 1, '4', 'Available'),
(17, 1, '4', 'Available'),
(18, 1, '4', 'Available'),
(19, 1, '4', 'Available'),
(20, 1, '4', 'Available'),
(21, 2, '2', 'Available'),
(22, 2, '2', 'Available'),
(23, 2, '2', 'Available'),
(24, 2, '2', 'Available'),
(25, 2, '2', 'Available'),
(26, 2, '2', 'Available'),
(27, 2, '2', 'Available'),
(28, 2, '2', 'Available'),
(29, 2, '2', 'Available'),
(30, 2, '2', 'Available'),
(31, 2, '4', 'Available'),
(32, 2, '4', 'Available'),
(33, 2, '4', 'Available'),
(34, 2, '4', 'Available'),
(35, 2, '4', 'Available'),
(36, 2, '4', 'Available'),
(37, 2, '4', 'Available'),
(38, 2, '4', 'Available'),
(39, 2, '4', 'Available'),
(40, 2, '4', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USERID` int(11) NOT NULL,
  `FIRSTNAME` varchar(30) NOT NULL,
  `LASTNAME` varchar(30) NOT NULL,
  `EMAIL` varchar(50) NOT NULL,
  `PASSWORD` varchar(50) NOT NULL,
  `PHONE` varchar(10) NOT NULL,
  `GENDER` varchar(10) NOT NULL,
  `AGE` varchar(5) NOT NULL,
  `ISADMIN` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`USERID`, `FIRSTNAME`, `LASTNAME`, `EMAIL`, `PASSWORD`, `PHONE`, `GENDER`, `AGE`, `ISADMIN`) VALUES
(1, 'Amaryllis', 'Nydrioti', 'anydrioti@onkelfelipe.org', 'adminpass123', '6921436587', 'Female', '18-25', 'Admin'),
(2, 'Filippos', 'Georgiou', 'fgeorgiou@gmail.com', 'Phgasos321', '6912345678', 'Male', '18-25', 'SimpleUser'),
(3, 'Thodoris', 'Liaskos', 'tliaskos@yahoo.com', 'Lelos123', '2106512345', 'Male', '26-35', 'SimpleUser');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`RESERVEID`),
  ADD KEY `USERID` (`USERID`),
  ADD KEY `TABLEID` (`TABLEID`);

--
-- Indexes for table `res_details`
--
ALTER TABLE `res_details`
  ADD PRIMARY KEY (`RESDETID`),
  ADD KEY `RESID` (`RESID`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`SECTIONID`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`TABLEID`),
  ADD KEY `SECTIONID` (`SECTIONID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USERID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `RESERVEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `res_details`
--
ALTER TABLE `res_details`
  MODIFY `RESDETID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `SECTIONID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `TABLEID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USERID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`USERID`) REFERENCES `users` (`USERID`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`TABLEID`) REFERENCES `tables` (`TABLEID`);

--
-- Constraints for table `res_details`
--
ALTER TABLE `res_details`
  ADD CONSTRAINT `res_details_ibfk_1` FOREIGN KEY (`RESID`) REFERENCES `reservations` (`RESERVEID`);

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_ibfk_1` FOREIGN KEY (`SECTIONID`) REFERENCES `sections` (`SECTIONID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
