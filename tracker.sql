-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 04, 2022 at 08:05 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracker`
--
CREATE DATABASE IF NOT EXISTS `tracker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `tracker`;

-- --------------------------------------------------------

--
-- Table structure for table `behaviours`
--

CREATE TABLE `behaviours` (
  `id` int(11) NOT NULL,
  `studentname` varchar(256) NOT NULL,
  `behaviour` varchar(256) NOT NULL,
  `severity` int(11) NOT NULL,
  `timewhen` datetime NOT NULL,
  `lastedhour` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `behaviours`
--

INSERT INTO `behaviours` (`id`, `studentname`, `behaviour`, `severity`, `timewhen`, `lastedhour`) VALUES
(1, 'Kevin', 'Screaming', 5, '2022-03-04 15:04:51', 'No'),
(2, 'Diana', 'Crying', 2, '2022-03-03 14:20:51', 'No'),
(3, 'Nyra', 'Hitting', 3, '2022-03-04 14:33:00', 'No'),
(4, 'Nageeb', 'Tantrum', 1, '2022-03-04 18:07:00', 'No');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `behaviours`
--
ALTER TABLE `behaviours`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `behaviours`
--
ALTER TABLE `behaviours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
