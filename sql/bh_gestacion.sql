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
-- Table structure for table `bh_gestacion`
--

CREATE TABLE `bh_gestacion` (
  `id` int(11) NOT NULL,
  `bh_gestacion_tagid` varchar(10) NOT NULL,
  `bh_gestacion_numero` int(10) NOT NULL,
  `bh_gestacion_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_gestacion`
--

INSERT INTO `bh_gestacion` (`id`, `bh_gestacion_tagid`, `bh_gestacion_numero`, `bh_gestacion_fecha`) VALUES
(4, '3000', 1, '2024-06-01'),
(8, '10000', 1, '2024-01-01'),
(9, '15000', 1, '2024-02-01'),
(10, '22000', 1, '2024-04-01'),
(11, '9500', 2, '2025-09-01'),
(12, '24200', 1, '2023-06-01'),
(13, '23500', 1, '2024-06-01'),
(14, '24560', 1, '2024-05-01'),
(15, '8300', 1, '2023-02-01'),
(16, '4001', 1, '2023-01-01'),
(17, '4000', 1, '2024-06-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_gestacion`
--
ALTER TABLE `bh_gestacion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_gestacion`
--
ALTER TABLE `bh_gestacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
