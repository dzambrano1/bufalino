-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 10:48 PM
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
-- Database: `ganagram`
--

-- --------------------------------------------------------

--
-- Table structure for table `bc_carbunco`
--

CREATE TABLE `bc_carbunco` (
  `id` int(11) NOT NULL,
  `bc_carbunco_vacuna` varchar(30) NOT NULL,
  `bc_carbunco_dosis` decimal(10,2) NOT NULL,
  `bc_carbunco_costo` decimal(10,2) NOT NULL,
  `bc_carbunco_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_carbunco`
--

INSERT INTO `bc_carbunco` (`id`, `bc_carbunco_vacuna`, `bc_carbunco_dosis`, `bc_carbunco_costo`, `bc_carbunco_vigencia`) VALUES
(1, 'Carbunco FORTE', 2.00, 0.66, 180),
(3, 'Anthravac B19', 2.00, 0.55, 180),
(4, 'Carbunco INSAI-Lab', 2.00, 0.70, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_carbunco`
--
ALTER TABLE `bc_carbunco`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_carbunco`
--
ALTER TABLE `bc_carbunco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
