-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 10:51 PM
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
-- Table structure for table `bc_ibr`
--

CREATE TABLE `bc_ibr` (
  `id` int(11) NOT NULL,
  `bc_ibr_vacuna` varchar(30) NOT NULL,
  `bc_ibr_dosis` decimal(10,2) NOT NULL,
  `bc_ibr_costo` decimal(10,2) NOT NULL,
  `bc_ibr_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_ibr`
--

INSERT INTO `bc_ibr` (`id`, `bc_ibr_vacuna`, `bc_ibr_dosis`, `bc_ibr_costo`, `bc_ibr_vigencia`) VALUES
(1, 'Bovilis® IBR Marker', 2.00, 0.50, 180),
(3, 'Respivac IBR', 2.00, 0.88, 180),
(4, 'Pulmovac INSAI-Lab', 2.00, 0.60, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_ibr`
--
ALTER TABLE `bc_ibr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_ibr`
--
ALTER TABLE `bc_ibr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
