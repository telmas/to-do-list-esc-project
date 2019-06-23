-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2019 at 06:34 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`ID`, `UserID`, `Name`) VALUES
(1, 1, 'Project1'),
(2, 1, 'Project2'),
(3, 1, 'Project 3'),
(4, 2, 'Project1');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `ID` int(11) NOT NULL,
  `Title` varchar(32) COLLATE utf8_bin NOT NULL,
  `Description` varchar(32) COLLATE utf8_bin DEFAULT NULL,
  `UserID` int(11) NOT NULL,
  `ProjectID` int(11) NOT NULL,
  `Category` tinyint(4) NOT NULL,
  `Done` tinyint(4) NOT NULL,
  `Difficulty` int(11) NOT NULL,
  `CreationDate` datetime DEFAULT NULL,
  `CompleteDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`ID`, `Title`, `Description`, `UserID`, `ProjectID`, `Category`, `Done`, `Difficulty`, `CreationDate`, `CompleteDate`) VALUES
(1, 'Task1', 'Task1 Desc', 1, 1, 0, 0, 0, '2019-06-23 18:25:33', '2019-08-04 00:00:00'),
(2, 'Task2', 'Task2 Desc', 1, 2, 1, 0, 2, '2019-06-23 18:25:58', '2019-06-30 00:00:00'),
(3, 'Task3', 'Task 3 Desc', 1, 3, 0, 1, 1, '2019-06-23 18:26:29', '2019-06-04 00:00:00'),
(4, 'Task4', 'Task 4 Desc', 1, 2, 1, 0, 1, '2019-06-23 18:26:50', '2019-06-04 00:00:00'),
(5, 'UserTask', 'UserTask Desc', 2, 4, 1, 0, 2, '2019-06-23 18:33:59', '2019-06-30 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `Username` varchar(64) COLLATE utf8_bin NOT NULL,
  `Password` varchar(64) COLLATE utf8_bin NOT NULL,
  `RegistrationDate` datetime DEFAULT NULL,
  `Email` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `Username`, `Password`, `RegistrationDate`, `Email`) VALUES
(1, 'Tedi', '123', '2019-06-23 18:25:01', 'tedi@gmail.com'),
(2, 'User', '123', '2019-06-23 18:33:36', 'newUser@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`ID`,`Name`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
