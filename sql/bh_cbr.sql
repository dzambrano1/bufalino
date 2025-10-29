-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:08 AM
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
-- Table structure for table `bh_cbr`
--

CREATE TABLE `bh_cbr` (
  `id` int(11) NOT NULL,
  `bh_cbr_tagid` varchar(10) NOT NULL,
  `bh_cbr_producto` varchar(50) NOT NULL,
  `bh_cbr_dosis` decimal(10,2) NOT NULL,
  `bh_cbr_costo` decimal(10,2) NOT NULL,
  `bh_cbr_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_cbr`
--

INSERT INTO `bh_cbr` (`id`, `bh_cbr_tagid`, `bh_cbr_producto`, `bh_cbr_dosis`, `bh_cbr_costo`, `bh_cbr_fecha`) VALUES
(1, '3000', 'Respivac 4	', 2.00, 0.68, '2025-09-05'),
(2, '3000', 'Pulmovac INSAI-Lab', 2.00, 0.78, '2025-09-01'),
(3, '3000', 'Pulmovac INSAI-Lab', 2.00, 0.78, '2025-09-01'),
(4, '3000', 'Bovimune Gold 5', 2.00, 0.85, '2025-09-07'),
(5, '3000', 'Bovilis® Bovigrip	', 2.00, 0.80, '2025-09-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_cbr`
--
ALTER TABLE `bh_cbr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_cbr`
--
ALTER TABLE `bh_cbr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
