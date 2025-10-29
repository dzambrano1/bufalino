-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:09 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bufalino`
--

-- --------------------------------------------------------

--
-- Table structure for table `bh_destete`
--

CREATE TABLE `bh_destete` (
  `id` int(11) NOT NULL,
  `bh_destete_tagid` varchar(10) NOT NULL,
  `bh_destete_peso` decimal(10,2) NOT NULL,
  `bh_destete_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_destete`
--

INSERT INTO `bh_destete` (`id`, `bh_destete_tagid`, `bh_destete_peso`, `bh_destete_fecha`) VALUES
(1, '3000', 250.00, '2025-01-12'),
(2, '3000', 100.00, '2025-01-13'),
(3, '5000', 200.00, '2024-11-01'),
(4, '20000', 200.00, '2024-11-01'),
(5, '8210', 200.00, '2024-11-01'),
(6, '27500', 250.00, '2024-11-01'),
(7, '24200', 210.00, '2024-11-01'),
(8, '45000', 200.00, '2024-11-01'),
(9, '599', 210.00, '2024-11-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_destete`
--
ALTER TABLE `bh_destete`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_destete`
--
ALTER TABLE `bh_destete`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
