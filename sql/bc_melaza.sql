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
-- Table structure for table `bc_melaza`
--

CREATE TABLE `bc_melaza` (
  `id` int(11) NOT NULL,
  `bc_melaza_nombre` varchar(30) NOT NULL,
  `bc_melaza_etapa` varchar(30) NOT NULL,
  `bc_melaza_racion` decimal(10,2) NOT NULL,
  `bc_melaza_costo` decimal(10,2) NOT NULL,
  `bc_melaza_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_melaza`
--

INSERT INTO `bc_melaza` (`id`, `bc_melaza_nombre`, `bc_melaza_etapa`, `bc_melaza_racion`, `bc_melaza_costo`, `bc_melaza_vigencia`) VALUES
(8, 'Melazuca®	', 'CRECIMIENTO', 0.01, 0.03, 30),
(9, 'Melaza INSAI-Lab', 'CRECIMIENTO', 0.01, 0.03, 30),
(10, 'Agromel®', 'CRECIMIENTO', 0.01, 0.03, 30),
(11, 'Melaza El Palmar', 'FINALIZACION', 0.01, 0.03, 30),
(12, 'NutriMel® Bovino', 'FINALIZACION', 0.01, 0.03, 30),
(13, 'Melaza Proagro®', 'FINALIZACION', 0.01, 0.03, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_melaza`
--
ALTER TABLE `bc_melaza`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_melaza`
--
ALTER TABLE `bc_melaza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
