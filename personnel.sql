-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2020 at 04:29 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `personnel`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `event_ID` int(11) NOT NULL,
  `0` varchar(1) DEFAULT NULL,
  `1` varchar(1) DEFAULT NULL,
  `2` varchar(1) DEFAULT NULL,
  `3` varchar(1) DEFAULT NULL,
  `4` varchar(1) DEFAULT NULL,
  `5` varchar(1) DEFAULT NULL,
  `6` varchar(1) DEFAULT NULL,
  `7` varchar(1) DEFAULT NULL,
  `8` varchar(1) DEFAULT NULL,
  `9` varchar(1) DEFAULT NULL,
  `10` varchar(1) DEFAULT NULL,
  `11` varchar(1) DEFAULT NULL,
  `12` varchar(1) DEFAULT NULL,
  `13` varchar(1) DEFAULT NULL,
  `14` varchar(1) DEFAULT NULL,
  `15` varchar(1) DEFAULT NULL,
  `16` varchar(1) DEFAULT NULL,
  `17` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`event_ID`, `0`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`) VALUES
(0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'L', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `attendance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_ID`, `name`, `date`, `attendance`) VALUES
(0, 'test event', '2020-03-17', 0),
(1, 'event1', '2020-03-17', 0),
(2, 'event2', '2020-04-02', 0),
(3, 'past_event', '2020-02-10', 12),
(4, 'new_event', '2020-03-18', 0),
(7, 'test event', '2020-03-17', 0);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `ID` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL,
  `supervisor_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`ID`, `group_name`, `supervisor_ID`) VALUES
(1, 'Sales', 6),
(2, 'Marketing', 3),
(3, 'Administrators', 7);

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `user_ID` int(11) NOT NULL,
  `First_Name` varchar(30) NOT NULL,
  `Last_Name` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Activation_Date` date NOT NULL,
  `Pay_Grade` int(11) NOT NULL,
  `Organization` int(11) NOT NULL,
  `Extra_1` int(11) NOT NULL,
  `Extra_2` int(11) NOT NULL,
  `Extra_3` int(11) NOT NULL,
  `Extra_4` int(11) NOT NULL,
  `Extra_5` int(11) NOT NULL,
  `permissions` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`user_ID`, `First_Name`, `Last_Name`, `Email`, `Activation_Date`, `Pay_Grade`, `Organization`, `Extra_1`, `Extra_2`, `Extra_3`, `Extra_4`, `Extra_5`, `permissions`) VALUES
(0, 'Justin', 'Case', 'just_in_case@email.com', '2020-02-12', 2, 2, 0, 0, 0, 0, 0, 'user'),
(1, 'John', 'Doe', 'John_Doe@comcast.net', '2020-01-01', 1, 1, 0, 0, 0, 0, 0, 'user'),
(2, 'Joe', 'Average', 'average.joe@email.com', '2019-09-17', 2, 1, 0, 0, 0, 0, 0, 'user'),
(3, 'Jerry', 'Jones', 'JJones@me.com', '2018-05-21', 6, 2, 0, 0, 0, 0, 0, 'supervisor'),
(4, 'Eddie', 'Taxpayer', 'tax_ed@gmail.com', '2019-10-01', 1, 1, 0, 0, 0, 0, 0, 'user'),
(5, 'Jason', 'Admin', 'admin@personnel.net', '2017-08-10', 5, 1, 0, 0, 0, 0, 0, 'admin'),
(6, 'Cindy', 'Supervisor', 'supervisor@personnel.net', '2017-08-15', 4, 1, 0, 0, 0, 0, 0, 'supervisor'),
(7, 'Alex', 'Whitaker', 'cwhita11@vols.utk.edu', '2018-01-01', 4, 3, 1, 0, 0, 2, 0, 'admin'),
(8, 'Cainan', 'Howard', 'chowar32@vols.utk.edu', '2018-01-01', 4, 3, 0, 0, 0, 0, 0, 'admin'),
(9, 'Sammy', 'Awad', 'sawad1@vols.utk.edu', '2018-01-01', 4, 3, 0, 0, 0, 0, 0, 'admin'),
(10, 'Timothy', 'Krenz', 'fhm352@vols.utk.edu', '2018-01-01', 4, 3, 0, 0, 0, 0, 0, 'admin'),
(11, 'Rae', 'Bernaola', 'rbernaol@vols.utk.edu', '2020-02-04', 3, 1, 0, 0, 0, 0, 0, 'user'),
(12, 'Jackson', 'Pot', 'the_gambler@email.com', '2020-02-12', 1, 2, 0, 0, 0, 0, 0, 'user'),
(13, 'Miles', 'Tone', 'step_one@email.com', '2020-02-12', 1, 2, 0, 0, 0, 0, 0, 'user'),
(14, 'Hilary', 'Ouse', 'laughing_stock@email.com', '2020-02-12', 1, 2, 0, 0, 0, 0, 0, 'user'),
(15, 'Hugh', 'Saturation', 'tickledPink@email.com', '2020-02-12', 2, 1, 0, 0, 0, 0, 0, 'user'),
(16, 'Will', 'Barrow', 'one_wheel@email.com', '2020-02-12', 3, 1, 0, 0, 0, 0, 0, 'user'),
(17, 'Test', 'User', 'test_user@email.com', '2020-03-02', 1, 1, 0, 0, 0, 0, 0, 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD UNIQUE KEY `event_ID` (`event_ID`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_ID`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD UNIQUE KEY `ID` (`ID`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`user_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
