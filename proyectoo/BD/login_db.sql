-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2025 a las 06:25:35
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
-- Base de datos: `login_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario_violencia`
--

CREATE TABLE `formulario_violencia` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `violencia` varchar(2) NOT NULL,
  `lugar` varchar(20) NOT NULL,
  `agresor` text DEFAULT NULL,
  `consciente` varchar(2) NOT NULL,
  `fecha_suceso` date NOT NULL,
  `evidencia_nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formulario_violencia`
--

INSERT INTO `formulario_violencia` (`id`, `nombre`, `edad`, `telefono`, `email`, `genero`, `violencia`, `lugar`, `agresor`, `consciente`, `fecha_suceso`, `evidencia_nombre`) VALUES
(1, 'isra', 17, '5565265629', 'isra@gmail', 'Hombre', 'No', 'otro', 'iuu', 'No', '2025-02-25', 'logo.jpg'),
(2, 'Josue Aranda', 16, '5565265629', 'josuejosafath@gmail.com', 'Hombre', 'Sí', 'trabajo', 'pequeño', 'No', '2025-05-13', 'logo.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opiniones`
--

CREATE TABLE `opiniones` (
  `id` int(11) NOT NULL,
  `sitio` varchar(10) NOT NULL,
  `mejoras` text NOT NULL,
  `parte_mejorar` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opiniones`
--

INSERT INTO `opiniones` (`id`, `sitio`, `mejoras`, `parte_mejorar`, `fecha_envio`) VALUES
(1, 'si', 'que todos trabajen', 'ponganlos a chambear', '2025-05-14 14:53:23'),
(2, 'si', 'agregar informacion', 'diseño', '2025-05-14 15:54:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `email`, `contraseña`) VALUES
(1, 'israel', 'isra@gmail', '$2y$10$JGUoDaTaull5Rl1dl9CVT.awV3Ze1AUWOXRwtWvjtfUS89IX41P0C'),
(2, 'alex', 'Alexander@gmail.com', '$2y$10$TlwjSflTzxiy2xCx0hhPH.0RiaFzGg32xt0l/aOFWFe2ZsJbl0J2C'),
(3, 'angelito', 'angelito@gmail.com', '$2y$10$R1u9Bs9ZmpZVJHkzec0Ho.5z7ogckE8h2QzldknmUDsL6rwZl77F6'),
(4, 'josuesito', 'josuejosafath@gmail.com', '$2y$10$HM203VH7dwg/Vm.V2kZM/eG7m4hZg/kB9MY7ERdX2kUc2KMPWXrBK'),
(8, 'isra', 'isra@gmail', '$2y$10$gqLa0tGY9IfjLxFsWLB38OLhy/dG9.fwo4NDrh6ASTyCuPhXedCiW'),
(10, 'josue', 'josue@gmail.com', '$2y$10$Z2K4Ia.20mTrj3bZoQy.i.slkCWtALb8GQr9JO/6jEUZJbGE4T0bO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `formulario_violencia`
--
ALTER TABLE `formulario_violencia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `formulario_violencia`
--
ALTER TABLE `formulario_violencia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `opiniones`
--
ALTER TABLE `opiniones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
