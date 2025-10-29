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
-- Table structure for table `bc_brucelosis`
--

CREATE TABLE `bc_brucelosis` (
  `id` int(11) NOT NULL,
  `bc_brucelosis_vacuna` varchar(50) NOT NULL,
  `bc_brucelosis_dosis` decimal(10,2) NOT NULL,
  `bc_brucelosis_costo` decimal(10,2) NOT NULL,
  `bc_brucelosis_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_brucelosis`
--

INSERT INTO `bc_brucelosis` (`id`, `bc_brucelosis_vacuna`, `bc_brucelosis_dosis`, `bc_brucelosis_costo`, `bc_brucelosis_vigencia`) VALUES
(1, 'Brucelvac RB51', 2.00, 0.60, 180),
(3, 'Brucella B19 VET', 2.00, 0.70, 180),
(4, 'Brucelina INSAI-Lab', 2.00, 0.50, 180),
(5, 'Brucelvac B19', 2.00, 0.88, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_brucelosis`
--
ALTER TABLE `bc_brucelosis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_brucelosis`
--
ALTER TABLE `bc_brucelosis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
