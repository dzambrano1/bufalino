-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 10:50 PM
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
-- Table structure for table `bc_garrapatas`
--

CREATE TABLE `bc_garrapatas` (
  `id` int(11) NOT NULL,
  `bc_garrapatas_vacuna` varchar(30) NOT NULL,
  `bc_garrapatas_dosis` decimal(10,2) NOT NULL,
  `bc_garrapatas_costo` decimal(10,2) NOT NULL,
  `bc_garrapatas_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_garrapatas`
--

INSERT INTO `bc_garrapatas` (`id`, `bc_garrapatas_vacuna`, `bc_garrapatas_dosis`, `bc_garrapatas_costo`, `bc_garrapatas_vigencia`) VALUES
(1, 'Taktic® 12.5% EC', 2.00, 2.35, 180),
(3, 'Bayticol® 6% EC', 2.00, 0.88, 180),
(4, 'Doramec® L.A.', 2.00, 1.50, 180),
(5, 'Ivomec® Gold', 2.00, 1.50, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_garrapatas`
--
ALTER TABLE `bc_garrapatas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_garrapatas`
--
ALTER TABLE `bc_garrapatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
