-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:12 AM
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
-- Table structure for table `bh_melaza`
--

CREATE TABLE `bh_melaza` (
  `id` int(11) NOT NULL,
  `bh_melaza_tagid` varchar(10) NOT NULL,
  `bh_melaza_etapa` varchar(25) NOT NULL,
  `bh_melaza_producto` varchar(50) NOT NULL,
  `bh_melaza_racion` decimal(10,2) NOT NULL,
  `bh_melaza_costo` decimal(10,2) NOT NULL,
  `bh_melaza_fecha_inicio` date NOT NULL,
  `bh_melaza_fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_melaza`
--

INSERT INTO `bh_melaza` (`id`, `bh_melaza_tagid`, `bh_melaza_etapa`, `bh_melaza_producto`, `bh_melaza_racion`, `bh_melaza_costo`, `bh_melaza_fecha_inicio`, `bh_melaza_fecha_fin`) VALUES
(160, '10000', 'CRECIMIENTO', 'Agromel®', 0.05, 3.00, '2025-07-02', '2024-11-03'),
(331, '15000', 'CRECIMIENTO', 'Melaza INSAI-Lab', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(332, '22000', 'CRECIMIENTO', 'Agromel®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(333, '23500', 'ENGORDE', 'Melaza INSAI-Lab', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(334, '24200', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(335, '24560', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(336, '33000', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(337, '4001', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(338, '45000', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(339, '8300', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(340, '9500', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(341, '11111', 'ENGORDE', 'Melaza El Palmar', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(342, '15500', 'CRECIMIENTO', 'Melazuca®	', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(343, '20000', 'CRECIMIENTO', 'NutriMel® Bovino', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(344, '23000', 'CRECIMIENTO', 'Melaza El Palmar', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(345, '27500', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(346, '3000', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(347, '4000', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(348, '5000', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(349, '599', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03'),
(350, '8210', 'CRECIMIENTO', 'Melaza Proagro®', 0.05, 3.00, '2024-07-02', '2024-11-03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_melaza`
--
ALTER TABLE `bh_melaza`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_melaza`
--
ALTER TABLE `bh_melaza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=351;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
