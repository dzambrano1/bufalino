-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 10:49 PM
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
-- Table structure for table `bc_cbr`
--

CREATE TABLE `bc_cbr` (
  `id` int(11) NOT NULL,
  `bc_cbr_vacuna` varchar(30) NOT NULL,
  `bc_cbr_dosis` decimal(10,2) NOT NULL,
  `bc_cbr_costo` decimal(10,2) NOT NULL,
  `bc_cbr_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_cbr`
--

INSERT INTO `bc_cbr` (`id`, `bc_cbr_vacuna`, `bc_cbr_dosis`, `bc_cbr_costo`, `bc_cbr_vigencia`) VALUES
(1, 'Bovilis® Bovigrip', 2.00, 0.50, 180),
(3, 'Respivac 4', 2.00, 0.88, 180),
(4, 'Pulmovac INSAI-Lab', 2.00, 0.88, 180),
(5, 'Bovimune Gold 5', 2.00, 0.88, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_cbr`
--
ALTER TABLE `bc_cbr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_cbr`
--
ALTER TABLE `bc_cbr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
