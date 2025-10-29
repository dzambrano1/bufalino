-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:09 AM
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
-- Table structure for table `bh_descarte`
--

CREATE TABLE `bh_descarte` (
  `id` int(11) NOT NULL,
  `bh_descarte_tagid` varchar(10) NOT NULL,
  `bh_descarte_peso` decimal(10,2) NOT NULL,
  `bh_descarte_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_descarte`
--

INSERT INTO `bh_descarte` (`id`, `bh_descarte_tagid`, `bh_descarte_peso`, `bh_descarte_fecha`) VALUES
(2, '3000', 265.00, '2025-01-01'),
(3, '3000', 300.00, '2025-01-13'),
(4, '3000', 400.00, '2025-01-22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_descarte`
--
ALTER TABLE `bh_descarte`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_descarte`
--
ALTER TABLE `bh_descarte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
