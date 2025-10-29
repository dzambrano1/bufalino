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
-- Table structure for table `bc_concentrado`
--

CREATE TABLE `bc_concentrado` (
  `id` int(11) NOT NULL,
  `bc_concentrado_nombre` varchar(30) NOT NULL,
  `bc_concentrado_etapa` varchar(30) NOT NULL,
  `bc_concentrado_racion` decimal(10,2) NOT NULL,
  `bc_concentrado_costo` decimal(10,2) NOT NULL,
  `bc_concentrado_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_concentrado`
--

INSERT INTO `bc_concentrado` (`id`, `bc_concentrado_nombre`, `bc_concentrado_etapa`, `bc_concentrado_racion`, `bc_concentrado_costo`, `bc_concentrado_vigencia`) VALUES
(1, 'Grupo Merino – ABA', 'Inicio', 1.53, 2.35, 30),
(3, 'NutriAr – MIXAR	', 'Crecimiento', 0.90, 0.90, 32),
(4, 'MERSAN®', 'Inicio', 0.50, 1.50, 30),
(5, 'Proagro® Bovino', 'Finalizacion', 0.85, 0.65, 33),
(6, 'Nutrición Animal INSAI', 'Gestacion', 0.85, 0.65, 33),
(7, 'Purolomo', 'Lactancia (Madres)', 0.85, 0.65, 33),
(8, 'Alipa', 'Engorde', 0.85, 0.65, 33),
(9, 'Las Tunas', 'Crecimiento', 0.85, 0.65, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_concentrado`
--
ALTER TABLE `bc_concentrado`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_concentrado`
--
ALTER TABLE `bc_concentrado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
