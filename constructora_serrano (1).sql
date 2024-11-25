-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-11-2024 a las 21:33:59
-- Versión del servidor: 8.0.40
-- Versión de PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `constructora_serrano`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `ID` int NOT NULL,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  `TelefonoCelular` varchar(15) DEFAULT NULL,
  `Rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arquitecto`
--

DROP TABLE IF EXISTS `arquitecto`;
CREATE TABLE IF NOT EXISTS `arquitecto` (
  `ID` int NOT NULL,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `ProyectosAsignados` varchar(255) DEFAULT NULL,
  `Especializacion` varchar(50) DEFAULT NULL,
  `Certificaciones` varchar(255) DEFAULT NULL,
  `FechaInicioProyecto` date DEFAULT NULL,
  `Estado` enum('activo','inactivo') DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

DROP TABLE IF EXISTS `asignaciones`;
CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trabajo_id` int DEFAULT NULL,
  `usuario_id` int DEFAULT NULL,
  `rol_asignado` enum('Gerente','Supervisor','Trabajador') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trabajo_id` (`trabajo_id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `ID` int NOT NULL,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `Direccion` varchar(255) DEFAULT NULL,
  `ProyectoContratado` varchar(255) DEFAULT NULL,
  `FechaInicioProyecto` date DEFAULT NULL,
  `EstadoProyecto` enum('activo','inactivo') DEFAULT NULL,
  `ComentariosValoraciones` text,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contador`
--

DROP TABLE IF EXISTS `contador`;
CREATE TABLE IF NOT EXISTS `contador` (
  `ID` int NOT NULL,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `ProyectosAsignados` varchar(255) DEFAULT NULL,
  `ReportesFinancieros` varchar(255) DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `Estado` enum('activo','inactivo') DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `costes`
--

DROP TABLE IF EXISTS `costes`;
CREATE TABLE IF NOT EXISTS `costes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `trabajo_id` int DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trabajo_id` (`trabajo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gerenteproyectos`
--

DROP TABLE IF EXISTS `gerenteproyectos`;
CREATE TABLE IF NOT EXISTS `gerenteproyectos` (
  `ID` int NOT NULL,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  `TelefonoCelular` varchar(15) DEFAULT NULL,
  `ProyectosAsignados` varchar(255) DEFAULT NULL,
  `FechaInicio` date DEFAULT NULL,
  `Estado` enum('activo','inactivo') DEFAULT NULL,
  `Experiencia` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingenieroobra`
--

DROP TABLE IF EXISTS `ingenieroobra`;
CREATE TABLE IF NOT EXISTS `ingenieroobra` (
  `ID` int NOT NULL,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `ProyectosAsignados` varchar(255) DEFAULT NULL,
  `Especializacion` varchar(50) DEFAULT NULL,
  `Certificaciones` varchar(255) DEFAULT NULL,
  `FechaInicioProyecto` date DEFAULT NULL,
  `Estado` enum('activo','inactivo') DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

DROP TABLE IF EXISTS `materiales`;
CREATE TABLE IF NOT EXISTS `materiales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `cantidad_disponible` int NOT NULL,
  `unidad` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `nombre`, `cantidad_disponible`, `unidad`) VALUES
(1, 'sullu', 3, '3'),
(2, 'sullu', 3, '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recursoshumanos`
--

DROP TABLE IF EXISTS `recursoshumanos`;
CREATE TABLE IF NOT EXISTS `recursoshumanos` (
  `ID` int NOT NULL,
  `NombreCompleto` varchar(255) DEFAULT NULL,
  `Usuario` varchar(50) DEFAULT NULL,
  `Contrasena` varchar(255) DEFAULT NULL,
  `CorreoElectronico` varchar(100) DEFAULT NULL,
  `Telefono` varchar(15) DEFAULT NULL,
  `EmpleadosACargo` varchar(255) DEFAULT NULL,
  `ContratosGestionados` varchar(255) DEFAULT NULL,
  `FechaIngreso` date DEFAULT NULL,
  `Estado` enum('activo','inactivo') DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Usuario` (`Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajos`
--

DROP TABLE IF EXISTS `trabajos`;
CREATE TABLE IF NOT EXISTS `trabajos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text,
  `costo` decimal(10,2) NOT NULL,
  `gerente_asignado` varchar(255) DEFAULT NULL,
  `estado` enum('en progreso','completado','pendiente') DEFAULT 'pendiente',
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `trabajos`
--

INSERT INTO `trabajos` (`id`, `nombre`, `descripcion`, `costo`, `gerente_asignado`, `estado`, `fecha_inicio`, `fecha_fin`) VALUES
(1, 'Construcción de Edificio', 'Edificio de 10 pisos en centro urbano.', 1200000.50, 'Pedro López', 'pendiente', '2024-11-01', '2025-11-01'),
(2, 'Construcción de Edificio', 'Edificio de 10 pisos en centro urbano.', 1200000.50, 'Pedro López', 'pendiente', '2024-11-01', '2025-11-01'),
(3, 'Construcción de Edificio', 'Edificio de 10 pisos en centro urbano.', 1200000.50, 'Pedro López', 'pendiente', '2024-11-01', '2025-11-01'),
(4, 'sullu 2', NULL, 31000.00, 'Jaimito', 'en progreso', NULL, NULL),
(10, 'sullu3', NULL, 23333.00, 'Jaimito', 'completado', NULL, NULL),
(11, 'sullu3', NULL, 23333.00, 'Jaimito', 'completado', NULL, NULL),
(12, 'sullu_barato', NULL, 100.00, 'Jaimito', 'completado', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uso_materiales`
--

DROP TABLE IF EXISTS `uso_materiales`;
CREATE TABLE IF NOT EXISTS `uso_materiales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `material_id` int NOT NULL,
  `cantidad_usada` int NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `fecha_uso` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(255) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Contrasena` varchar(255) NOT NULL,
  `Rol` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Correo` (`Correo`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Correo`, `Contrasena`, `Rol`) VALUES
(3, 'Rassiel', 'Rasiel@gmail.com', '$2y$10$Bifir.4y4zlYWKqgrArBsuK9kUWsVfy4.QEsWyGABFp6Eo0jXorDu', 'Administrador del Sistema'),
(5, 'Alex', 'Alex@example.com', '$2y$10$Gi3ALpkuMYa8cSZEoTFYwOKhEphsZ2dZ5b15t9jCF8XBoTUjyv.M.', 'Comprador / Responsable de Suministros'),
(8, 'Omar', 'Omar@example.com', '$2y$10$ouNzD9jgcrHY8LnAvPEHOuvav.50mv6sFepjsSn.6OTc0s4rZXn.G', 'Administrador del Sistema'),
(9, 'Juan Pérez', 'juan.perez@example.com', '1234segura', 'Administrador'),
(10, 'Hola', '123@example.com', '$2y$10$RYoWbojAp0xZP/buIPZPxub2GBVK9RpIQeYhB6.AYXZKy80XaOwai', 'Administrador del Sistema'),
(11, 'Administrador', 'admin@constructora.com', 'adminpass', 'Administrador del Sistema'),
(12, 'Gerente de Proyecto', 'gerente@constructora.com', 'gerentepass', 'Gerente de Proyectos'),
(13, 'Contador', 'contador@constructora.com', 'contadord123', 'Contador / Responsable Financiero'),
(14, 'Empleado', 'empleado@constructora.com', 'empleadopass', 'Empleado');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `asignaciones_ibfk_1` FOREIGN KEY (`trabajo_id`) REFERENCES `trabajos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `asignaciones_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`ID`) ON DELETE CASCADE;

--
-- Filtros para la tabla `costes`
--
ALTER TABLE `costes`
  ADD CONSTRAINT `costes_ibfk_1` FOREIGN KEY (`trabajo_id`) REFERENCES `trabajos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `uso_materiales`
--
ALTER TABLE `uso_materiales`
  ADD CONSTRAINT `uso_materiales_ibfk_1` FOREIGN KEY (`material_id`) REFERENCES `materiales` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
