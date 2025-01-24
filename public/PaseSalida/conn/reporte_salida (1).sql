-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-03-2024 a las 22:58:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reporte_salida`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `choferes`
--

CREATE TABLE `choferes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ficha` text NOT NULL,
  `no_licencia` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `choferes`
--

INSERT INTO `choferes` (`id`, `nombre`, `ficha`, `no_licencia`) VALUES
(1, 'ESTEBAN RAMON DE LA CRUZ', '0000000', '8CH1465050'),
(2, 'SEVERIANO MENDEZ LOPEZ', '0000000', '8CH1569044'),
(3, 'MAURICIO MAGAÑA GONZALEZ', '0000000', '1CH1500146'),
(4, 'HIBIS HERNANDEZ SANTOS', '0000000', '8CH1462286');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jefe_depto`
--

CREATE TABLE `jefe_depto` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL,
  `dep` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `jefe_depto`
--

INSERT INTO `jefe_depto` (`id`, `nombre`, `dep`) VALUES
(1, 'MARIA GUADALUPE ESCAMILLA DURAN', 'CEMENTACIONES'),
(2, 'RAFAEL CARDENAS LOPEZ', 'CEMENTACIONES');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pdf`
--

CREATE TABLE `pdf` (
  `id` int(11) NOT NULL,
  `destino` text NOT NULL,
  `motivo` text NOT NULL,
  `folio` varchar(50) NOT NULL,
  `fecha` text NOT NULL,
  `hora` varchar(50) NOT NULL,
  `ruta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pdf`
--

INSERT INTO `pdf` (`id`, `destino`, `motivo`, `folio`, `fecha`, `hora`, `ruta`) VALUES
(43, 'REFORMA', 'HERRAMIENTAS', 'QB1A7OS508', ' 20/03/24 ', ' 8:28 pm ', 'pdfs/Reporte_de_salida_Folio_QB1A7OS508.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal`
--

CREATE TABLE `personal` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `ficha` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `personal`
--

INSERT INTO `personal` (`id`, `nombre`, `ficha`) VALUES
(39, 'MOISES DE JESUS GARCIA HERNANDEZ', 963254);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidad`
--

CREATE TABLE `unidad` (
  `id` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `No_inventario1` varchar(255) NOT NULL,
  `No.inventario2` varchar(255) NOT NULL,
  `placa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidad`
--

INSERT INTO `unidad` (`id`, `tipo`, `No_inventario1`, `No.inventario2`, `placa`) VALUES
(1, 'TOYOTA HIACE', '66V', '', 'WW-A-768-A'),
(2, 'TRACTOCAMION/PLANA', '400000787 / 420000175', '', 'CV-6651-D / 1-BT-1743'),
(4, 'atos', '552vf', '', '635vg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `ficha` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `num` varchar(11) NOT NULL,
  `email` text NOT NULL,
  `img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `ficha`, `nombre`, `apellido`, `password`, `num`, `email`, `img`) VALUES
(14, 840158, 'MOISES de jesus', 'GARCIA hernandez', '$2y$10$HJX4OvFL/E3iLeJoAMgTMe4szE9VhYO00MMpNDD8UKb7B7ULbpeSO', '9613727059', 'moisesgrcia37@gmail.com', 'img/80489789_2260020570766343_5105947466121871360_n.jpg.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `choferes`
--
ALTER TABLE `choferes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jefe_depto`
--
ALTER TABLE `jefe_depto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pdf`
--
ALTER TABLE `pdf`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `unidad`
--
ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `choferes`
--
ALTER TABLE `choferes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `jefe_depto`
--
ALTER TABLE `jefe_depto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pdf`
--
ALTER TABLE `pdf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `personal`
--
ALTER TABLE `personal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `unidad`
--
ALTER TABLE `unidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
