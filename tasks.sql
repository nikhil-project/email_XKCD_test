-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 27, 2021 at 07:02 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tasks`
--

-- --------------------------------------------------------

--
-- Table structure for table `unique_codes`
--

CREATE TABLE `unique_codes` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `unique_codes`
--

INSERT INTO `unique_codes` (`id`, `emp_id`, `code`) VALUES
(7, 7, 3010),
(8, 8, 6220),
(9, 9, 6247),
(10, 10, 1757),
(11, 11, 7699),
(12, 12, 1744),
(13, 13, 9189),
(14, 14, 7948),
(15, 15, 5891),
(16, 16, 4765),
(17, 17, 5089),
(18, 18, 6574),
(19, 19, 6736),
(20, 20, 7284),
(21, 21, 4772),
(22, 22, 4143),
(23, 23, 9505),
(24, 24, 2298),
(25, 25, 467328),
(26, 26, 981569),
(27, 27, 737965);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`) VALUES
(7, 'nijil', 'nikhilm288@gmail.com'),
(8, 'nikhil', 'nkhilm288@gmail.com'),
(9, 'ankit', 'ankitbaldwa1992@gmail.com'),
(10, 'ankit', 'anikitbaldwa1992@gmail.com'),
(11, 'nikhil', 'nikhilm288@gmail.com'),
(12, 'nikhil', 'nikhilm288@gmail.com'),
(13, 'Nikhil', 'nikhilm288@gmail.com'),
(14, 'nikhil', 'nikhilm288@gmail.com'),
(15, 'Nikhil', 'nikhilm288@gmail.com'),
(16, 'Nikhil', 'nikhilm288@gmail.com'),
(17, 'asdsg', 'nikhilm288@gmail.com'),
(18, 'Nikhil', 'nikhilm288@gmail.com'),
(19, 'qwerty', 'nikhilm288@gmail.com'),
(20, 'Nikhil', 'nikhilm288@gmail.com'),
(21, 'abc', 'nikhilm288@gmail.com'),
(22, 'abc', 'nikhilm288@gmail.com'),
(23, 'abc', 'nikhilm288@gmail.com'),
(24, 'abc', 'nikhilm288@gmail.com'),
(25, 'Nikhil', 'nikhilm288@gmail.com'),
(26, 'abc', 'nikhilm288@gmail.com'),
(27, 'viplav', 'viplavsoni3333@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `unique_codes`
--
ALTER TABLE `unique_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `unique_codes`
--
ALTER TABLE `unique_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
