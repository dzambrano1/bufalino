-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:06 AM
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
-- Table structure for table `bh_aftosa`
--

CREATE TABLE `bh_aftosa` (
  `id` int(11) NOT NULL,
  `bh_aftosa_tagid` varchar(10) NOT NULL,
  `bh_aftosa_producto` varchar(50) NOT NULL,
  `bh_aftosa_dosis` decimal(10,2) NOT NULL,
  `bh_aftosa_costo` decimal(10,2) NOT NULL,
  `bh_aftosa_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_aftosa`
--

INSERT INTO `bh_aftosa` (`id`, `bh_aftosa_tagid`, `bh_aftosa_producto`, `bh_aftosa_dosis`, `bh_aftosa_costo`, `bh_aftosa_fecha`) VALUES
(1, '3000', 'Brucelina INSAI-Lab', 2.00, 0.55, '2022-01-01'),
(2, '3000', 'Brucelvac RB51', 2.00, 0.55, '2023-05-01'),
(3, '3000', 'Brucella B19 VET	', 2.00, 0.60, '2025-01-01'),
(4, '3000', 'Brucelvac B19', 2.00, 0.40, '2025-01-01'),
(5, '3000', 'Brucelina INSAI-Lab', 2.00, 0.50, '2025-09-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_aftosa`
--
ALTER TABLE `bh_aftosa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_aftosa`
--
ALTER TABLE `bh_aftosa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
