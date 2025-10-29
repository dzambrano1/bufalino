-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 11:02 PM
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
-- Table structure for table `bh_venta`
--

CREATE TABLE `bh_venta` (
  `id` int(11) NOT NULL,
  `bh_venta_tagid` varchar(10) NOT NULL,
  `bh_venta_peso` decimal(10,2) NOT NULL,
  `bh_venta_precio` decimal(10,2) NOT NULL,
  `bh_venta_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_venta`
--

INSERT INTO `bh_venta` (`id`, `bh_venta_tagid`, `bh_venta_peso`, `bh_venta_precio`, `bh_venta_fecha`) VALUES
(1, '3000', 250.00, 4.00, '2025-02-01'),
(2, '3000', 100.00, 4.00, '2025-02-01'),
(6, '3000', 500.00, 4.20, '2025-02-04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_venta`
--
ALTER TABLE `bh_venta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_venta`
--
ALTER TABLE `bh_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
