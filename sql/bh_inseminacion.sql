-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:11 AM
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
-- Table structure for table `bh_inseminacion`
--

CREATE TABLE `bh_inseminacion` (
  `id` int(11) NOT NULL,
  `bh_inseminacion_tagid` varchar(10) NOT NULL,
  `bh_inseminacion_numero` int(10) NOT NULL,
  `bh_inseminacion_costo` decimal(10,2) NOT NULL,
  `bh_inseminacion_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_inseminacion`
--

INSERT INTO `bh_inseminacion` (`id`, `bh_inseminacion_tagid`, `bh_inseminacion_numero`, `bh_inseminacion_costo`, `bh_inseminacion_fecha`) VALUES
(1, '3000', 1, 7.00, '2023-01-01'),
(2, '3000', 2, 8.00, '2024-01-01'),
(3, '3000', 3, 9.00, '2025-01-01'),
(4, '3000', 1, 10.00, '2025-09-08'),
(5, '9500', 1, 2.00, '2025-09-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_inseminacion`
--
ALTER TABLE `bh_inseminacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_inseminacion`
--
ALTER TABLE `bh_inseminacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
