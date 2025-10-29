-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:07 AM
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
-- Table structure for table `bh_carbunco`
--

CREATE TABLE `bh_carbunco` (
  `id` int(11) NOT NULL,
  `bh_carbunco_tagid` varchar(10) NOT NULL,
  `bh_carbunco_producto` varchar(50) NOT NULL,
  `bh_carbunco_dosis` decimal(10,2) NOT NULL,
  `bh_carbunco_costo` decimal(10,2) NOT NULL,
  `bh_carbunco_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_carbunco`
--

INSERT INTO `bh_carbunco` (`id`, `bh_carbunco_tagid`, `bh_carbunco_producto`, `bh_carbunco_dosis`, `bh_carbunco_costo`, `bh_carbunco_fecha`) VALUES
(1, '3000', 'Carbunco FORTE', 2.00, 0.50, '2023-01-05'),
(2, '3000', 'Carbunco FORTE', 2.00, 0.50, '2024-01-06'),
(3, '3000', 'Carbunco FORTE', 2.00, 0.50, '2025-01-07'),
(4, '3000', 'Carbunco FORTE', 2.00, 0.50, '2025-01-07'),
(5, '3000', 'VAC-SULES CARBUNCO', 2.00, 0.50, '2025-01-16'),
(10, '3000', 'VAC-SULES CARBUNCO', 2.00, 0.50, '2025-01-21'),
(11, '10000', 'VAC-SULES CARBUNCO', 2.00, 0.25, '2025-09-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_carbunco`
--
ALTER TABLE `bh_carbunco`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_carbunco`
--
ALTER TABLE `bh_carbunco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
