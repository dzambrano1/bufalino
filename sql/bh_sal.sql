-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2025 at 05:13 AM
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
-- Table structure for table `bh_sal`
--

CREATE TABLE `bh_sal` (
  `id` int(11) NOT NULL,
  `bh_sal_tagid` varchar(10) NOT NULL,
  `bh_sal_etapa` varchar(25) NOT NULL,
  `bh_sal_producto` varchar(50) NOT NULL,
  `bh_sal_racion` decimal(10,2) NOT NULL,
  `bh_sal_costo` decimal(10,2) NOT NULL,
  `bh_sal_fecha_inicio` date NOT NULL,
  `bh_sal_fecha_fin` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bh_sal`
--

INSERT INTO `bh_sal` (`id`, `bh_sal_tagid`, `bh_sal_etapa`, `bh_sal_producto`, `bh_sal_racion`, `bh_sal_costo`, `bh_sal_fecha_inicio`, `bh_sal_fecha_fin`) VALUES
(160, '10000', 'CRECIMIENTO', 'Nutrisal® Bovino	', 1.00, 0.50, '2025-09-01', '2025-09-30'),
(331, '15000', 'CRECIMIENTO', 'Sal Proagro®', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(332, '22000', 'CRECIMIENTO', 'Salvamin® Bovino', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(333, '23500', 'CRECIMIENTO', 'Sal INSAI-Lab', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(334, '24200', 'CRECIMIENTO', 'Salvamin® Bovino', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(335, '24560', 'CRECIMIENTO', 'Nutrisal® Bovino	', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(336, '33000', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(337, '4001', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(338, '45000', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(339, '8300', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(340, '9500', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(341, '11111', 'ENGORDE', 'Sal INSAI-Lab', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(342, '15500', 'CRECIMIENTO', 'Salmin® Tropical', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(343, '20000', 'CRECIMIENTO', 'Salvabú®', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(344, '23000', 'CRECIMIENTO', 'Nutrisal® Bovino	', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(345, '27500', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(346, '3000', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(347, '4000', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(348, '5000', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(349, '599', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(350, '8210', 'CRECIMIENTO', 'VITASAL', 1.00, 0.50, '2024-07-02', '2024-11-03'),
(351, '10000', 'CRECIMIENTO', 'Salmin® Tropical', 1.00, 0.60, '2025-07-01', '2025-08-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bh_sal`
--
ALTER TABLE `bh_sal`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bh_sal`
--
ALTER TABLE `bh_sal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=352;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
