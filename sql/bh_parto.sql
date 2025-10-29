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
-- Table structure for table `bh_parto`
--

CREATE TABLE `bh_parto` (
  `id` int(11) NOT NULL,
  `bh_parto_tagid` varchar(10) NOT NULL,
  `bh_parto_numero` int(11) NOT NULL,
  `bh_parto_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_parto`
--

INSERT INTO `bh_parto` (`id`, `bh_parto_tagid`, `bh_parto_numero`, `bh_parto_fecha`) VALUES
(5, '3000', 1, '2025-03-01'),
(8, '10000', 1, '2024-06-01'),
(9, '15000', 1, '2024-11-01'),
(10, '22000', 1, '2025-01-01'),
(11, '9500', 1, '2025-04-01'),
(12, '24200', 1, '2024-03-01'),
(13, '23500', 1, '2025-03-01'),
(14, '24560', 1, '2025-02-01'),
(15, '4000', 1, '2025-03-01'),
(16, '4001', 1, '2023-10-01'),
(17, '8300', 1, '2023-11-01'),
(18, '9500', 1, '2025-09-08'),
(19, '9500', 2, '2026-02-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_parto`
--
ALTER TABLE `bh_parto`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_parto`
--
ALTER TABLE `bh_parto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
