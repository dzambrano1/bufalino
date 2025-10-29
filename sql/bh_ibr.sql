-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:10 AM
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
-- Table structure for table `bh_ibr`
--

CREATE TABLE `bh_ibr` (
  `id` int(11) NOT NULL,
  `bh_ibr_tagid` varchar(10) NOT NULL,
  `bh_ibr_producto` varchar(50) NOT NULL,
  `bh_ibr_dosis` decimal(10,2) NOT NULL,
  `bh_ibr_costo` decimal(10,2) NOT NULL,
  `bh_ibr_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_ibr`
--

INSERT INTO `bh_ibr` (`id`, `bh_ibr_tagid`, `bh_ibr_producto`, `bh_ibr_dosis`, `bh_ibr_costo`, `bh_ibr_fecha`) VALUES
(1, '3000', 'Pulmovac INSAI-Lab	', 2.00, 0.80, '2023-01-05'),
(2, '3000', 'Bovilis® IBR Marker', 2.00, 0.56, '2024-01-06'),
(3, '3000', 'Respivac IBR', 0.70, 0.85, '2025-07-01'),
(4, '3000', 'Bovilis® IBR Marker', 0.80, 0.55, '2025-07-16'),
(7, '3000', 'Pulmovac INSAI-Lab	', 2.00, 0.85, '2025-09-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_ibr`
--
ALTER TABLE `bh_ibr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_ibr`
--
ALTER TABLE `bh_ibr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
