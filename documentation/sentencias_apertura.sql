-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-04-2018 a las 23:13:50
-- Versión del servidor: 10.1.31-MariaDB
-- Versión de PHP: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dbchat`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sentencias_apertura`
--

CREATE TABLE `sentencias_apertura` (
  `id` int(11) NOT NULL,
  `sentencia` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `atributo` tinyint(4) DEFAULT NULL,
  `habilidad` tinyint(4) DEFAULT NULL,
  `subhabilidad` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `sentencias_apertura`
--

INSERT INTO `sentencias_apertura` (`id`, `sentencia`, `atributo`, `habilidad`, `subhabilidad`) VALUES
(1, 'Preguntemos al profesor', 1, 1, 1),
(2, 'Todas las posturas son validas', 2, 1, 2),
(3, 'A mi me parece bien', 1, 1, 1),
(4, 'Estoy en desacuerdo', 4, 1, 2),
(5, 'En lugar de eso podriamos', 5, 1, 2),
(6, 'Entonces', 6, 1, 2),
(7, 'Supongamos que', 7, 1, 2),
(8, 'Pero podria ocurrir que', 8, 1, 2),
(9, 'No estoy seguro', 9, 1, 2),
(10, 'Vamos por buen camino', 10, 2, 3),
(11, 'Esto va bien sigamos', 11, 2, 3),
(12, 'En otras palabras', 12, 2, 4),
(13, 'Intentemos', 13, 2, 4),
(14, 'Yo pienso que', 14, 2, 4),
(15, 'Hay que hacer lo siguiente', 15, 2, 4),
(16, 'Yo lo explicaria asi', 16, 2, 4),
(17, 'Yo creo que porque', 17, 2, 4),
(18, 'Yo lo dejaria asi', 18, 2, 4),
(19, 'Que falta considerar', 19, 2, 5),
(20, 'Que hacemos ahora', 20, 2, 5),
(21, 'Por favor expliquenme', 21, 2, 5),
(22, 'Por que', 22, 2, 5),
(23, 'Se puede', 23, 2, 5),
(24, 'Por favor muestrenme', 24, 2, 5),
(25, 'Gracias amigos', 25, 3, 6);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `sentencias_apertura`
--
ALTER TABLE `sentencias_apertura`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `sentencias_apertura`
--
ALTER TABLE `sentencias_apertura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
