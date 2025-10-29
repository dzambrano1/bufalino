-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2025 at 10:47 PM
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
-- Table structure for table `bufalino`
--

CREATE TABLE `bufalino` (
  `id` int(10) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image2` varchar(255) NOT NULL,
  `image3` varchar(255) NOT NULL,
  `video` varchar(255) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `especie` varchar(50) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `tagid` varchar(50) DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `clase` varchar(50) DEFAULT NULL,
  `raza` varchar(50) DEFAULT NULL,
  `grupo` varchar(50) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT NULL,
  `etapa` varchar(100) NOT NULL,
  `edad` int(11) DEFAULT NULL,
  `peso_nacimiento` double(5,2) NOT NULL,
  `fecha_compra` date DEFAULT NULL,
  `peso_compra` double(5,2) NOT NULL,
  `precio_compra` decimal(10,2) NOT NULL,
  `fecha_venta` date DEFAULT NULL,
  `peso_venta` double(5,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `deceso_causa` varchar(30) NOT NULL,
  `deceso_fecha` date DEFAULT NULL,
  `descarte_fecha` date DEFAULT NULL,
  `descarte_peso` decimal(10,2) NOT NULL,
  `descarte_precio` decimal(10,2) NOT NULL,
  `destete_fecha` date DEFAULT NULL,
  `destete_peso` decimal(10,2) NOT NULL,
  `fecha_publicacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bufalino`
--

INSERT INTO `bufalino` (`id`, `image`, `image2`, `image3`, `video`, `fecha_nacimiento`, `especie`, `nombre`, `tagid`, `genero`, `clase`, `raza`, `grupo`, `estatus`, `etapa`, `edad`, `peso_nacimiento`, `fecha_compra`, `peso_compra`, `precio_compra`, `fecha_venta`, `peso_venta`, `precio_venta`, `deceso_causa`, `deceso_fecha`, `descarte_fecha`, `descarte_peso`, `descarte_precio`, `destete_fecha`, `destete_peso`, `fecha_publicacion`) VALUES
(600, 'uploads/67fc192a57e69_1744574762.jpg', 'uploads/67fc192a58377_1744574762.png', 'uploads/67fc192a5868a_1744574762.png', 'uploads/videos/67fc1aec54c7f_1744575212.mp4', '2023-08-12', 'Bufalino', 'Lola', '3000', 'Hembra', 'Bufala', 'Jafarabadi', 'Sanos', 'Activo', 'Crecimiento', 16, 60.00, '2025-03-19', 300.00, 500.00, '2025-07-01', 245.00, 490.00, 'Golpe', '2025-05-11', '2025-01-01', 150.00, 4.00, NULL, 0.00, NULL),
(601, 'uploads/Bufalo2.jpg', 'uploads/67fc1d0740a11_1744575751.jpg', 'uploads/67fc1d0740e5a_1744575751.jpg', 'uploads/videos/67fc1d074153f_1744575751.mp4', '2022-11-01', 'Bufalino', 'Flora', '4000', 'Hembra', 'Bufala', 'Mediterranea', 'Paridas', 'Muerto', 'Finalizacion', 25, 50.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 378.00, 756.00, 'Rayo', '2025-09-08', '2025-02-10', 210.00, 4.00, NULL, 0.00, NULL),
(602, 'uploads/Bufalo3.jpeg', 'uploads/67fc1e55b687e_1744576085.jpg', 'uploads/67fc1e55b6b87_1744576085.jpg', '', '2024-06-01', 'Bufalino', 'Tomas', '5000', 'Macho', 'Bubillo', 'Mediterranea', 'Lactantes', 'Activo', 'Inicio', 23, 48.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 378.00, 756.00, 'Palo cochinero', '2025-08-17', '2025-03-05', 250.00, 4.00, NULL, 0.00, NULL),
(605, 'uploads/Bufalo7.jpeg', 'uploads/67fc1ee34c762_1744576227.jpg', '', '', '2023-01-01', 'Bufalino', 'Alegria', '9500', 'Hembra', 'Bubilla', 'Mediterranea', 'Vacias', 'Descartado', 'Crecimiento', 23, 54.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 378.00, 756.00, 'Diarrea', '2025-04-22', '2025-04-25', 300.00, 4.00, NULL, 0.00, NULL),
(606, 'uploads/Bufalo6.jpg', 'uploads/67fc52fe460c6_1744589566.jpg', 'uploads/67fc52fe469e7_1744589566.png', '', '2023-07-01', 'Bufalino', 'Victoria', '10000', 'Hembra', 'Bufala', 'Mediterranea', 'Paridas', 'Descartado', 'Finalizacion', 17, 61.00, '2023-12-13', 0.00, 0.00, '2025-08-17', 160.00, 4.00, 'Infarto', '2025-08-17', '2025-08-17', 220.00, 4.00, NULL, 0.00, NULL),
(609, 'uploads/Bufalo4.jpg', 'uploads/67fc539217f5f_1744589714.jpeg', 'uploads/67fc539218495_1744589714.jpeg', '', '2023-06-19', 'Bufalino', 'Jeny', '8300', 'Hembra', 'Bubulla', 'Mediterranea', 'Paridas', 'Activo', 'Crecimiento', 18, 54.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(611, 'uploads/Mediterranea-Bufala-1.jpg', 'uploads/67fc543b02c4f_1744589883.jpg', 'uploads/67fc543b0320c_1744589883.jpg', '', '2022-07-01', 'Bufalino', 'Liz', '15000', 'Hembra', 'Bubulla', 'Mediterranea', 'Gestacion', 'Activo', 'Crecimiento', 29, 50.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 245.00, 490.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(621, 'uploads/Bufalo5.jpg', 'uploads/67fc54f805e06_1744590072.jpg', 'uploads/67fc54f806328_1744590072.png', '', '2023-06-16', 'Bufalino', 'Roky', '15500', 'Macho', 'Bufalo', 'Mediterranea', 'Sanos', 'Activo', 'Finalizacion', 18, 75.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 245.00, 490.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(622, 'uploads/Bufalo-Murrah-1.jpg', 'uploads/67fc5592cb44e_1744590226.jpeg', 'uploads/67fc5592cb84a_1744590226.png', '', '2024-06-01', 'Bufalino', 'Domingo', '20000', 'Macho', 'Bubillo', 'Mediterranea', 'Sanos', 'Activo', 'Inicio', 34, 54.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 245.00, 490.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(623, 'uploads/Bucerro-Murrah-1.jpg', 'uploads/67fc5640bbd30_1744590400.jpg', 'uploads/67fc5640bc02f_1744590400.jpg', '', '2024-04-10', 'Bufalino', 'Fernanda', '22000', 'Hembra', 'Bufala', 'Mediterranea', 'Vacias', 'Vendido', 'Finalizacion', 8, 50.00, '0000-00-00', 0.00, 0.00, '2025-08-01', 400.00, 800.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(624, 'uploads/Bufalo3.jpeg', 'uploads/67fc56e5db36e_1744590565.jpg', 'uploads/67fc56e5dd2b5_1744590565.jpg', '', '2023-02-18', 'Bufalino', 'Oscar', '23000', 'Macho', 'Bubillo', 'Mediterranea', 'Sanos', 'Activo', 'Crecimiento', 22, 52.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 245.00, 490.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(625, 'uploads/Bufalo10.jpg', 'uploads/67fc57add155f_1744590765.png', 'uploads/67fc57add1c6b_1744590765.png', '', '2024-01-04', 'Bufalino', 'Lento', '33000', 'Macho', 'Bubullo', 'Mediterranea', 'Sanos', 'Activo', 'Crecimiento', 11, 56.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(626, 'uploads/Bufalo11.jpg', 'uploads/67fc58fcbe6ae_1744591100.png', 'uploads/67fc58fcbf10e_1744591100.jpg', '', '2023-01-04', 'Bufalino', 'Dinya', '23500', 'Hembra', 'Bubilla', 'Mediterranea', 'Gestacion', 'Activo', 'Crecimiento', 23, 57.00, '2024-03-06', 250.00, 0.00, '2025-07-01', 245.00, 490.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(627, 'uploads/Bufalo14.jpeg', 'uploads/67fc59821f27f_1744591234.jpg', 'uploads/67fc59821f789_1744591234.png', '', '2022-12-15', 'Bufalino', 'Rosa', '24560', 'Hembra', 'Bufala', 'Mediterranea', 'Sanos', 'Activo', 'Finalizacion', 24, 53.00, '2024-04-18', 300.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(628, 'uploads/Bufalo15.jpeg', 'uploads/67fc5a4132835_1744591425.png', 'uploads/67fc5a4133513_1744591425.png', '', '2022-06-01', 'Bufalino', 'Humo', '27500', 'Macho', 'Bufalo', 'Mediterranea', 'Sanos', 'Vendido', 'Finalizacion', 30, 65.00, '2024-04-01', 400.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(630, 'uploads/Bufalo20.jpg', 'uploads/67fc5b58994b0_1744591704.png', 'uploads/67fc5b5899bc9_1744591704.png', '', '2024-06-01', 'Bufalino', 'Lester', '8210', 'Macho', 'Bucerro', 'Mediterranea', 'Sanos', 'Activo', 'Inicio', 8, 56.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 368.00, 736.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(633, 'uploads/Bufalo21.jpeg', 'uploads/67fc5c2aa404a_1744591914.png', 'uploads/67fc5c2aa4aaf_1744591914.png', '', '2024-06-01', 'Bufalino', 'Blanca', '24200', 'Hembra', 'Becerra', 'Mediterranea', 'Sanos', 'Descartado', 'Inicio', 30, 0.00, '2024-04-19', 0.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, '2025-09-08', 100.00, 500.00, NULL, 0.00, NULL),
(634, 'uploads/Bufalo22.jpg', 'uploads/67fc5cfaa4a27_1744592122.png', 'uploads/67fc5cfaa4daf_1744592122.jpg', '', '2024-06-01', 'Bufalino', 'Cantor', '45000', 'Macho', 'Bucerro', 'Mediterranea', 'Sanos', 'Activo', 'Inicio', 18, 0.00, '2023-06-01', 0.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(635, 'uploads/Bufalo23.png', 'uploads/67fc5ebc929ff_1744592572.jpg', 'uploads/67fc5ebc9316b_1744592572.png', '', '2024-06-01', 'Bufalino', 'Pedro', '599', 'Macho', 'Bucerro', 'Mediterranea', 'Sanos', 'Activo', 'Inicio', 2, 25.00, '0000-00-00', 0.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(641, 'uploads/Bufalo26.jpg', 'uploads/67fc5f578b4db_1744592727.png', 'uploads/67fc5f578b7fb_1744592727.png', '', '2024-01-02', 'Bufalino', 'Carla', '4001', 'Hembra', 'Bufala', 'Mediterranea', 'Paridas', 'Activo', 'Finalizacion', NULL, 0.00, '2024-11-30', 0.00, 0.00, '2025-07-01', 378.00, 756.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(646, 'uploads/681ffa564a16a_bufalo-image.jpeg', 'uploads/681ffa564acbf_bufalo-image2.jpg', 'uploads/681ffa564b286_bufalo-image3.jpg', 'uploads/681ffa564b925_bufalo-video-final.mp4', '2024-01-10', '', 'Unico', '11111', 'Macho', NULL, 'Mediterranea', 'Sanos', 'Activo', 'Finalizacion', NULL, 0.00, '2024-12-01', 535.00, 800.00, '2025-07-01', 245.00, 490.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(647, 'uploads/68a1d1e8e12e0_1755435496.jpg', 'uploads/68a1d1e8e1620_1755435496.jpg', 'uploads/68a1d1e8e18bd_1755435496.jpg', '', '2024-01-01', '', 'Cuernos', '86957', 'Macho', NULL, 'Mediterranea', 'Sanos', 'Activo', 'Finalizacion', NULL, 0.00, '2025-01-01', 450.00, 3.50, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL),
(648, 'uploads/68a1d719169eb_bufalo4-image.jpg', 'uploads/68a1d71916cdb_bufalo5-image.jpg', 'uploads/68a1d71916eea_bufalo6-image.jpeg', NULL, '2024-01-15', '', 'KARON', '7778', 'Macho', NULL, 'Jafarabadi', 'Sanos', 'Activo', 'Inicio', NULL, 460.00, NULL, 0.00, 0.00, NULL, 0.00, 0.00, '', NULL, NULL, 0.00, 0.00, NULL, 0.00, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bufalino`
--
ALTER TABLE `bufalino`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `tagid` (`tagid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bufalino`
--
ALTER TABLE `bufalino`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=649;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
