-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-04-2022 a las 03:11:57
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alquiler`
--

CREATE TABLE `alquiler` (
  `codigo` int(10) NOT NULL,
  `fecha` datetime NOT NULL,
  `monto` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alquiler`
--

INSERT INTO `alquiler` (`codigo`, `fecha`, `monto`) VALUES
(1, '2022-04-22 21:10:33', 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallealquiler`
--

CREATE TABLE `detallealquiler` (
  `alquiler_codigo` int(10) NOT NULL,
  `pelicula_codigo` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `detallealquiler`
--

INSERT INTO `detallealquiler` (`alquiler_codigo`, `pelicula_codigo`) VALUES
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero`
--

CREATE TABLE `genero` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `genero`
--

INSERT INTO `genero` (`id`, `nombre`) VALUES
(1, 'negativo'),
(3, 'comedia'),
(4, 'infantil'),
(40, 'accion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `codigo` int(10) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `duracion` time NOT NULL,
  `genero_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`codigo`, `nombre`, `duracion`, `genero_id`) VALUES
(1, 'avengers', '03:02:00', 40),
(2, 'la vida es bella', '02:03:20', 4),
(3, 'avengers 2', '02:00:15', 40),
(4, 'barbie', '21:20:00', 1),
(5, 'tarzan', '01:30:00', 4),
(6, 'tarzan 2', '01:30:00', 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alquiler`
--
ALTER TABLE `alquiler`
  ADD PRIMARY KEY (`codigo`);

--
-- Indices de la tabla `detallealquiler`
--
ALTER TABLE `detallealquiler`
  ADD PRIMARY KEY (`alquiler_codigo`,`pelicula_codigo`) USING BTREE,
  ADD KEY `alquiler_codigo` (`alquiler_codigo`),
  ADD KEY `pelicula_codigo` (`pelicula_codigo`);

--
-- Indices de la tabla `genero`
--
ALTER TABLE `genero`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `genero_id` (`genero_id`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallealquiler`
--
ALTER TABLE `detallealquiler`
  ADD CONSTRAINT `detallealquiler_ibfk_1` FOREIGN KEY (`alquiler_codigo`) REFERENCES `alquiler` (`codigo`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `detallealquiler_ibfk_2` FOREIGN KEY (`pelicula_codigo`) REFERENCES `pelicula` (`codigo`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD CONSTRAINT `pelicula_ibfk_1` FOREIGN KEY (`genero_id`) REFERENCES `genero` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
