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
-- Table structure for table `bh_mastitis`
--

CREATE TABLE `bh_mastitis` (
  `id` int(11) NOT NULL,
  `bh_mastitis_tagid` varchar(10) NOT NULL,
  `bh_mastitis_producto` varchar(50) NOT NULL,
  `bh_mastitis_dosis` decimal(10,2) NOT NULL,
  `bh_mastitis_costo` decimal(10,2) NOT NULL,
  `bh_mastitis_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_mastitis`
--

INSERT INTO `bh_mastitis` (`id`, `bh_mastitis_tagid`, `bh_mastitis_producto`, `bh_mastitis_dosis`, `bh_mastitis_costo`, `bh_mastitis_fecha`) VALUES
(1, '3000', 'Spectramast® LC	', 2.00, 0.65, '2025-01-01'),
(2, '3000', 'Mastijet® Forte', 2.00, 0.36, '2025-01-13'),
(3, '3000', 'MastiVet® LC	', 2.00, 0.65, '2025-01-13'),
(4, '3000', 'Lactobay®	', 2.00, 0.65, '2025-09-01'),
(5, '9500', 'Mastijet® Forte', 2.00, 0.35, '2025-09-08'),
(6, '24200', 'Mastilab INSAI	', 2.00, 0.60, '2025-09-08'),
(7, '4001', 'Lactobay®	', 2.00, 0.36, '2025-09-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_mastitis`
--
ALTER TABLE `bh_mastitis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_mastitis`
--
ALTER TABLE `bh_mastitis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
