-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 03:56 AM
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
-- Database: `acceso_rfid`
--

-- --------------------------------------------------------

--
-- Table structure for table `historico`
--

CREATE TABLE `historico` (
  `id` int(11) NOT NULL,
  `uid` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo_evento` enum('entrada','salida','denegado') NOT NULL,
  `fecha_hora` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `historico`
--

INSERT INTO `historico` (`id`, `uid`, `nombre`, `tipo_evento`, `fecha_hora`) VALUES
(4, '63808E35', 'Hector', 'entrada', '2025-12-09 17:20:21'),
(5, '63808E35', 'Hector', 'salida', '2025-12-09 17:21:03'),
(6, '63808E35', 'Hector', 'entrada', '2025-12-09 17:21:07'),
(7, '63808E35', 'Hector', 'salida', '2025-12-09 17:21:15'),
(8, '63808E35', 'Hector', 'entrada', '2025-12-09 17:21:24'),
(9, '63808E35', 'Hector', 'salida', '2025-12-09 17:27:49'),
(10, '63808E35', 'Hector', 'entrada', '2025-12-09 17:27:56'),
(11, '63808E35', 'Hector', 'salida', '2025-12-09 17:28:04'),
(12, '63808E35', 'Hector', 'entrada', '2025-12-09 17:35:16'),
(13, '63808E35', 'Hector', 'salida', '2025-12-09 17:35:23'),
(14, '63808E35', 'Hector', 'entrada', '2025-12-09 17:38:23'),
(15, '63808E35', 'Hector', 'salida', '2025-12-09 17:38:28'),
(16, 'C3E7B6', 'Juan', 'entrada', '2025-12-09 17:39:35'),
(17, 'C3E7B6', 'Juan', 'salida', '2025-12-09 17:39:40'),
(18, 'C3E7B6', 'Juan', 'entrada', '2025-12-09 17:42:44'),
(19, 'C3E7B6', 'Juan', 'salida', '2025-12-09 17:42:59'),
(20, 'C3E7B6', 'Juan', 'entrada', '2025-12-09 17:44:57'),
(21, 'C3E7B6', 'Juan', 'salida', '2025-12-09 17:45:06'),
(31, 'C3E7B6', 'Juan', 'entrada', '2025-12-09 20:13:01'),
(32, 'C3E7B6', 'Juan', 'salida', '2025-12-09 20:13:12'),
(40, 'D35E9813', 'Desconocido', 'denegado', '2025-12-09 20:31:05'),
(41, 'C3E7B6', 'Juan', 'entrada', '2025-12-09 20:39:34'),
(42, 'C3E7B6', 'Juan', 'salida', '2025-12-09 20:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `tipo` varchar(20) DEFAULT NULL,
  `hora` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo` enum('entrada','salida') DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `uid` varchar(50) DEFAULT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `correo` varchar(150) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `uid`, `apellido`, `correo`, `telefono`, `direccion`) VALUES
(4, 'Hector', '63808E35', 'Contreras', 'hector.cts@outlook.com', '7223519262', 'Calle Universidad'),
(5, 'Juan', 'C3E7B6', 'Perez', 'juanperez@gmail.com', '7221563295', 'Calle Venustiano Carranza');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `historico`
--
ALTER TABLE `historico`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tarjeta_uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `historico`
--
ALTER TABLE `historico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `registros_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
