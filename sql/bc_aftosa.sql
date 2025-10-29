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
-- Table structure for table `bc_aftosa`
--

CREATE TABLE `bc_aftosa` (
  `id` int(11) NOT NULL,
  `bc_aftosa_vacuna` varchar(30) NOT NULL,
  `bc_aftosa_dosis` decimal(10,2) NOT NULL,
  `bc_aftosa_costo` decimal(10,2) NOT NULL,
  `bc_aftosa_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_aftosa`
--

INSERT INTO `bc_aftosa` (`id`, `bc_aftosa_vacuna`, `bc_aftosa_dosis`, `bc_aftosa_costo`, `bc_aftosa_vigencia`) VALUES
(1, 'Aftovac Plus', 2.00, 0.20, 180),
(3, 'Aftosa Bivalente', 2.00, 0.70, 180),
(4, 'Aftomune', 2.00, 0.50, 180),
(5, 'Aftosa VET', 2.00, 0.60, 180),
(6, 'Aftosa INSAI-Lab', 2.00, 0.80, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_aftosa`
--
ALTER TABLE `bc_aftosa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_aftosa`
--
ALTER TABLE `bc_aftosa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
