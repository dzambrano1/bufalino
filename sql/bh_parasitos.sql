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
-- Table structure for table `bh_parasitos`
--

CREATE TABLE `bh_parasitos` (
  `id` int(11) NOT NULL,
  `bh_parasitos_tagid` varchar(10) NOT NULL,
  `bh_parasitos_producto` varchar(50) NOT NULL,
  `bh_parasitos_dosis` decimal(10,2) NOT NULL,
  `bh_parasitos_costo` decimal(10,2) NOT NULL,
  `bh_parasitos_fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_parasitos`
--

INSERT INTO `bh_parasitos` (`id`, `bh_parasitos_tagid`, `bh_parasitos_producto`, `bh_parasitos_dosis`, `bh_parasitos_costo`, `bh_parasitos_fecha`) VALUES
(1, '3000', 'Doramec® L.A.', 2.00, 0.35, '2025-09-01'),
(2, '3000', 'Closamectin®', 2.00, 0.55, '2025-08-10'),
(3, '10000', 'Fasiver® Plus', 2.00, 0.54, '2025-09-08'),
(4, '11111', 'Ivermic® F', 2.00, 0.26, '2025-09-08'),
(5, '15000', 'Trivexan® Gold', 2.00, 0.35, '2025-09-08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_parasitos`
--
ALTER TABLE `bh_parasitos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_parasitos`
--
ALTER TABLE `bh_parasitos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
