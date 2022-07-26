-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-07-2022 a las 17:29:47
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `formulario`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `form_list`
--

CREATE TABLE `form_list` (
  `id` int(30) NOT NULL,
  `form_code` varchar(100) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `fname` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `form_list`
--

INSERT INTO `form_list` (`id`, `form_code`, `title`, `description`, `fname`, `date_created`, `date_updated`) VALUES
(7, '2425059741', 'Examen PHP', 'Con este sistema de preguntar vamos a concluir tus conocimientos en PHP', '2425059741.html', '2021-07-02 12:34:49', NULL),
(8, '7929514222', 'Entrevista de trabajo', 'Única pregunta abierta', '7929514222.html', '2021-07-03 09:55:35', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responses`
--

CREATE TABLE `responses` (
  `id` int(30) NOT NULL,
  `rl_id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `responses`
--

INSERT INTO `responses` (`id`, `rl_id`, `meta_field`, `meta_value`) VALUES
(2, 1, '1', 'Ingresar Opción,Ingresar Opción'),
(14, 14, '0', 'PHP (acrónimo recursivo de PHP: Hypertext Preprocessor) es un lenguaje de código abierto muy popular especialmente adecuado para el desarrollo web y que puede ser incrustado en HTML.'),
(15, 14, '1', 'Ingresar Opción, Ingresar Opción, Ingresar Opción'),
(16, 14, '2', 'Ingresar Opción'),
(17, 14, '3', '1625247488_1.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `response_list`
--

CREATE TABLE `response_list` (
  `id` int(30) NOT NULL,
  `form_code` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `response_list`
--

INSERT INTO `response_list` (`id`, `form_code`, `date_created`) VALUES
(14, '2425059741', '2021-07-02 12:38:08');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `form_list`
--
ALTER TABLE `form_list`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `responses`
--
ALTER TABLE `responses`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `response_list`
--
ALTER TABLE `response_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `form_list`
--
ALTER TABLE `form_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `responses`
--
ALTER TABLE `responses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `response_list`
--
ALTER TABLE `response_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
