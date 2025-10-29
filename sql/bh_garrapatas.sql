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
-- Table structure for table `bh_garrapatas`
--

CREATE TABLE `bh_garrapatas` (
  `id` int(11) NOT NULL,
  `bh_garrapatas_tagid` varchar(10) NOT NULL,
  `bh_garrapatas_producto` varchar(50) NOT NULL,
  `bh_garrapatas_dosis` decimal(10,2) NOT NULL,
  `bh_garrapatas_costo` decimal(10,2) NOT NULL,
  `bh_garrapatas_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_garrapatas`
--

INSERT INTO `bh_garrapatas` (`id`, `bh_garrapatas_tagid`, `bh_garrapatas_producto`, `bh_garrapatas_dosis`, `bh_garrapatas_costo`, `bh_garrapatas_fecha`) VALUES
(1, '3000', 'Doramec® L.A.', 2.00, 0.35, '2025-01-06'),
(2, '3000', 'Doramec® L.A.', 2.00, 0.54, '2025-01-13'),
(3, '3000', 'Ivomec® Gold', 2.00, 0.35, '2025-01-12'),
(4, '3000', 'Bayticol® 6% EC', 2.00, 0.60, '2025-01-21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_garrapatas`
--
ALTER TABLE `bh_garrapatas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_garrapatas`
--
ALTER TABLE `bh_garrapatas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
