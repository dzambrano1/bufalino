-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 10:53 PM
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
-- Table structure for table `bc_sal`
--

CREATE TABLE `bc_sal` (
  `id` int(11) NOT NULL,
  `bc_sal_nombre` varchar(30) NOT NULL,
  `bc_sal_etapa` varchar(30) NOT NULL,
  `bc_sal_racion` decimal(10,2) NOT NULL,
  `bc_sal_costo` decimal(10,2) NOT NULL,
  `bc_sal_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_sal`
--

INSERT INTO `bc_sal` (`id`, `bc_sal_nombre`, `bc_sal_etapa`, `bc_sal_racion`, `bc_sal_costo`, `bc_sal_vigencia`) VALUES
(1, 'Salvamin® Bovino', 'Inicio', 1.53, 0.70, 30),
(3, 'Nutrisal® Bovino	', 'Crecimiento', 0.90, 0.50, 32),
(4, 'Sal Proagro®', 'Finalizacion', 0.50, 0.30, 30),
(6, 'Salvabú®', 'Finalizacion', 0.50, 0.30, 30),
(7, 'Sal INSAI-Lab', 'Finalizacion', 0.50, 0.30, 30),
(8, 'Salmin® Tropical', 'Finalizacion', 0.50, 0.30, 30);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_sal`
--
ALTER TABLE `bc_sal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_sal`
--
ALTER TABLE `bc_sal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
