-- phpMyAdmin SQL Dump
-- version 4.7.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 24-05-2018 a las 14:57:35
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `raspytv`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `r_users`
--

CREATE TABLE `r_users` (
  `id` int(11) NOT NULL,
  `usuario` varchar(64) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `lema` varchar(32) NOT NULL DEFAULT '',
  `avatar` text NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  `playimg` int(11) NOT NULL DEFAULT '0',
  `playvideo` int(11) NOT NULL DEFAULT '0',
  `playmusic` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `r_users`
--

INSERT INTO `r_users` (`id`, `usuario`, `clave`, `lema`, `avatar`, `view`, `playimg`, `playvideo`, `playmusic`) VALUES
(1, 'halltv', '7e15d5d04e1c458dde0f453d0acef8e1', 'Administrador', 'whyd_avatar.png', 0, 0, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `r_users`
--
ALTER TABLE `r_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `r_users`
--
ALTER TABLE `r_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
