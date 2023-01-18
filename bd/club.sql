-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-01-2023 a las 12:21:14
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `club`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `socio` bigint(20) UNSIGNED NOT NULL,
  `servicio` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`socio`, `servicio`, `fecha`, `hora`) VALUES
(1, 1, '2022-11-22', '19:00:00'),
(1, 2, '2022-11-20', '17:00:00'),
(5, 1, '2022-11-18', '18:00:00'),
(7, 2, '2022-11-17', '17:00:00'),
(9, 4, '2022-12-05', '11:30:00'),
(10, 1, '2022-12-09', '19:00:00'),
(11, 3, '2022-12-01', '18:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `noticia`
--

CREATE TABLE `noticia` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `titulo` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `contenido` varchar(800) COLLATE latin1_spanish_ci NOT NULL,
  `imagen` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_publicacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `noticia`
--

INSERT INTO `noticia` (`id`, `titulo`, `contenido`, `imagen`, `fecha_publicacion`) VALUES
(1, 'Una noticia muy interesante.', 'Hola soy una noticia muy interesante.', '1.jpg', '2022-11-15'),
(2, 'Olympia Gym seleccionado por la Comisión Económica Europea de Naciones Unidas.', 'Los valores fundamentales, el modelo de negocio y los logros de la empresa se presentaron en un estudio de caso en el 6º Foro Internacional de CPP de la UNECE, en Barcelona. El evento destacó Colaboraciones Público Privadas exitosas que priorizan a las personas y que tienen el potencial de mover a las poblaciones hacia los Objetivos de Desarrollo Sostenible (ODS) establecidos por las Naciones Unidas en su Agenda 2030.', '2.jpg', '2022-11-16'),
(3, 'Otra noticia muy interesante', 'Yo soy otra noticia muy interesante.', '3.jpg', '2022-11-15'),
(4, 'En Olympia Gym, entrenar tiene premio.', 'Como sabes, cada día que vienes a Olympia Gym haces mucho por tu salud. Por ello, queremos darte un motivo más para que no faltes a tu cita con nosotros y premiarte por elegir vivir más y mejor.\r\n\r\nCon nuestro programa de fidelización gana puntos y canjéalos por fantásticos premios.\r\n\r\nVive tu experiencia con nosotros al completo, suma puntos y canjéalos por lo que tú quieras: toallas, gafas de natación, welcome packs… ¡y mucho más!', '4.jpg', '2022-11-17'),
(5, '¡Lanzamos nuestros planes Olympia!', 'Que consigas tus objetivos es siempre nuestro mayor propósito y cada día, seguimos trabajando para ofrecerte la mejor experiencia y que consigas disfrutar de una vida más plena, más feliz y más capaz.\r\n\r\nTe hemos escuchado y ya puedes ampliar los servicios de tu abono Olympia con el\r\nPlan Plus y el Plan Premium. ¡Aprovecha la oferta de lanzamiento!', '5.jpg', '2022-11-15'),
(6, 'cacho de notisia parse', 'awdawdwaawdaw', '6.jpg', '2023-01-12'),
(7, 'peaso notisia parsero', 'noticia para probar y tal', '7.jpg', '2023-01-12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `precio` double(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `precio`) VALUES
(3, 'Batido de proteinas', 5.95),
(4, 'Bebida Energética', 3.99),
(7, 'Camiseta Olympia', 15.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `descripcion` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `duracion` int(3) UNSIGNED NOT NULL,
  `precio` double(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `servicio`
--

INSERT INTO `servicio` (`id`, `descripcion`, `duracion`, `precio`) VALUES
(1, 'Boxing', 60, 10.00),
(2, 'Biking', 120, 15.00),
(3, 'Musculación libre y guiada', 60, 35.00),
(4, 'Natación libre', 60, 10.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socio`
--

CREATE TABLE `socio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `edad` int(2) UNSIGNED DEFAULT NULL,
  `usuario` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `pass` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `telefono` int(9) UNSIGNED DEFAULT NULL,
  `foto` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `socio`
--

INSERT INTO `socio` (`id`, `nombre`, `edad`, `usuario`, `pass`, `telefono`, `foto`) VALUES
(0, 'Administrador', NULL, 'admin', 'admin', NULL, NULL),
(1, 'Ricardo Romero', 27, 'ricardorb1', 'ricardor1', 689546783, 'ricardorb1.jpg'),
(5, 'Jesus Romero Bustos', 34, 'jesusr1', 'jesusr1', 689914567, 'jesusr1.jpg'),
(7, 'Pedro Gomez Gutierrez', 25, 'pedrog1', 'pedrog1', 654437698, 'pedrog1.jpg'),
(8, 'Javier Terrones', 35, 'javiert1', 'javiert1', 654346598, 'javiert1.jpg'),
(9, 'Roberto Carlos', 41, 'robertoc1', 'robertoc1', 645434576, 'robertoc1.jpg'),
(10, 'Zinedine Zidane', 43, 'zinedin1', 'zinedin1', 678345456, 'zinedin1.jpg'),
(11, 'Messi', 34, 'messi23', 'messi23', 689546723, 'messi23.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonio`
--

CREATE TABLE `testimonio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `autor` bigint(20) UNSIGNED NOT NULL,
  `contenido` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `testimonio`
--

INSERT INTO `testimonio` (`id`, `autor`, `contenido`, `fecha`) VALUES
(1, 1, 'Mi gym es el mejor.', '2022-11-22'),
(2, 8, 'Me han obligado a hacer una reseña positiva.', '2022-11-22'),
(3, 7, 'El mejor gym de mi poblo.', '2022-11-22'),
(4, 5, 'El gym de mi hermano es el mas mejor.', '2022-11-22'),
(5, 9, 'Yo solo voy porque esta cerca mi casa.', '2022-12-01'),
(6, 11, 'No puedo tengo furbo', '2022-12-01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`socio`,`servicio`,`fecha`),
  ADD KEY `socio` (`socio`),
  ADD KEY `socio_2` (`socio`,`servicio`,`fecha`),
  ADD KEY `ce_cita_servicio` (`servicio`);

--
-- Indices de la tabla `noticia`
--
ALTER TABLE `noticia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socio`
--
ALTER TABLE `socio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ce_testi_socio` (`autor`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `noticia`
--
ALTER TABLE `noticia`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `socio`
--
ALTER TABLE `socio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `testimonio`
--
ALTER TABLE `testimonio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `ce_cita_servicio` FOREIGN KEY (`servicio`) REFERENCES `servicio` (`id`),
  ADD CONSTRAINT `ce_cita_socio` FOREIGN KEY (`socio`) REFERENCES `socio` (`id`);

--
-- Filtros para la tabla `testimonio`
--
ALTER TABLE `testimonio`
  ADD CONSTRAINT `ce_testi_socio` FOREIGN KEY (`autor`) REFERENCES `socio` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
