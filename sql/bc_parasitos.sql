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
-- Table structure for table `bc_parasitos`
--

CREATE TABLE `bc_parasitos` (
  `id` int(11) NOT NULL,
  `bc_parasitos_vacuna` varchar(30) NOT NULL,
  `bc_parasitos_dosis` decimal(10,2) NOT NULL,
  `bc_parasitos_costo` decimal(10,2) NOT NULL,
  `bc_parasitos_vigencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bc_parasitos`
--

INSERT INTO `bc_parasitos` (`id`, `bc_parasitos_vacuna`, `bc_parasitos_dosis`, `bc_parasitos_costo`, `bc_parasitos_vigencia`) VALUES
(1, 'Trivexan® Gold', 2.00, 2.35, 180),
(3, 'Fasiver® Plus', 2.00, 0.88, 180),
(4, 'Endex® 10%', 2.00, 1.50, 180),
(5, 'Doramec® L.A.', 2.00, 1.50, 180),
(6, 'Ivermic® F', 2.00, 1.50, 180),
(7, 'Closamectin®', 0.50, 1.50, 180);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bc_parasitos`
--
ALTER TABLE `bc_parasitos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bc_parasitos`
--
ALTER TABLE `bc_parasitos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
