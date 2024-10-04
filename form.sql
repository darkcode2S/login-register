-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2024 at 03:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `email`, `password`) VALUES
(1, 'anthony@gmail.com', '$2y$10$igRYlbeMPdDFIkdli1D/vOoAN7x9Lx766dJ6rrVSXNhCTqErIuzF2'),
(2, 'anthony123@gmail.com', '$2y$10$lkW3VBrEPMMuLzuqdxGHZuWHErxD0LvP./d.aD42Fdp60STdSao4W'),
(3, 'mama@gmail.com', '$2y$10$rbgwRDOMjcP/oKpkCVmOdO59ZNX6GAbDJpCx8wPWpdQ7GYcz8pETi'),
(4, 'papa@gmail.comasd', '$2y$10$KPKkgu2uXOist6NcmjbhIOKAZlfJvaAjnVYvv6DMDsgDZAETZTVou'),
(5, 'anthony.com@gmail.com', '$2y$10$95j2yqRHLLDVzK.dzaUQz.wcIZz0h9kSrpF8WTnZ61mWKxtGPr7iC'),
(6, 'rose@gmail.com', '$2y$10$dA6W22IImvj6674HaygraOYSN.dlPM7WYvPjm6kAjXhx3brPG3o9S'),
(7, 'anthony.dev@gmail.com', '$2y$10$LlLoxIob8TcqKxtMG0Gx.en1cuXofCBcEz1P541X.gLgUnCDZoUGW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
