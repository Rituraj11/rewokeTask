-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2020 at 11:43 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task1`
--

-- --------------------------------------------------------

--
-- Table structure for table `convert_logs`
--

CREATE TABLE `convert_logs` (
  `logid` int(11) NOT NULL,
  `userip` varchar(255) NOT NULL,
  `docxfile` varchar(255) NOT NULL,
  `pdffile` varchar(255) NOT NULL,
  `time_log` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `convert_logs`
--

INSERT INTO `convert_logs` (`logid`, `userip`, `docxfile`, `pdffile`, `time_log`) VALUES
(5, '::1', '479539586Hi Name is Rituraj.docx', '479539586Hi Name is Rituraj.pdf', '2020-12-16 10:43:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `convert_logs`
--
ALTER TABLE `convert_logs`
  ADD PRIMARY KEY (`logid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `convert_logs`
--
ALTER TABLE `convert_logs`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
