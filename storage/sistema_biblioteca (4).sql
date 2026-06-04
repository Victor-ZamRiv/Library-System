-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-06-2026 a las 08:20:28
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
-- Base de datos: `sistema_biblioteca`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `ID_Actividad` int(11) NOT NULL,
  `ID_Admin` int(11) DEFAULT NULL,
  `Organizador` varchar(50) NOT NULL,
  `Categoria` varchar(50) DEFAULT NULL,
  `Descripcion` text NOT NULL,
  `Asistentes` int(11) DEFAULT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Fecha_Registro` timestamp NULL DEFAULT current_timestamp(),
  `Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `actividades`
--

INSERT INTO `actividades` (`ID_Actividad`, `ID_Admin`, `Organizador`, `Categoria`, `Descripcion`, `Asistentes`, `Estado`, `Fecha`, `Fecha_Registro`, `Activo`) VALUES
(4, 1, 'División de cultura', 'Educativa', 'Se realizó una actividad educativa con niños de la comunidad Casco histórico', 32, 'Completado', '2026-05-19', NULL, 1),
(5, 1, 'Biblioteca Pública A.Z.B', 'Reunión', 'Reunión para planificación del mes de junio', 16, 'Completado', '2026-05-20', '2026-05-20 23:47:03', 1),
(8, 1, 'Biblioteca Pública A.Z.B', 'Cultural', 'Actividad especial por aniversario de la biblioteca', 22, 'Completado', '2026-05-20', '2026-05-21 00:41:20', 1),
(9, 1, 'Instituto Autónomo de Cultura', 'Cultural', 'Actividad difundiendo la lectura entre niños, niñas y adolescentes', 45, 'Completado', '2026-05-21', '2026-05-21 07:27:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `ID_Admin` int(11) NOT NULL,
  `ID_Persona` int(11) NOT NULL,
  `Nombre_Usuario` varchar(50) NOT NULL,
  `ContrasenaHash` varchar(255) NOT NULL,
  `Rol` varchar(30) NOT NULL,
  `ID_Pregunta` int(11) DEFAULT NULL,
  `RespuestaHash` varchar(250) DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`ID_Admin`, `ID_Persona`, `Nombre_Usuario`, `ContrasenaHash`, `Rol`, `ID_Pregunta`, `RespuestaHash`, `Activo`) VALUES
(1, 1, 'VictorZR', '$2y$10$fpcduv5ALCBdD.emBf.m7uQAxcGErP88Ew1MWAALqJxuce31djgGq', 'Director', 1, '$2y$10$Tw9nq58ZSFJziMZugfxBr.GwoQIaN5fms3oGCxm61xZnjFOI3HzGi', 1),
(3, 14, 'admin', '$2y$10$JU0MPFJbuB226Jt0kCt06u2hCUkwpP3cQK5W05JXsa6wY0gdfIGZm', 'Bibliotecario', 1, '$2y$10$Tw9nq58ZSFJziMZugfxBr.GwoQIaN5fms3oGCxm61xZnjFOI3HzGi', 1),
(5, 17, 'Administrador', '$2y$10$mLbd5feLfRI5uHormip6uu864c7s.fYz4P2niIqk.5i20wpVthR0S', 'Bibliotecario', 2, '$2y$10$NRk.ojKOoZUGXxMLQN.8ie0eT9hzQ5LGN/OEYt1RgwlVV5SsKzMEC', 1),
(6, 19, 'JoseZR', '$2y$10$dsQQdcvown3pPdt.OZxoP.2tcKL9ew8GEF.yhfgNMwC/N7IMHWgnq', 'Jefe de sala', NULL, '$2y$10$7XN7zDu4kY7uLQSF9cwXN.45IshPP.zc10ua6jSClBYjPa2FT6tSG', 1),
(7, 24, 'JosePB', '$2y$10$OeWlJ06a0Oo7Mr0iC0iNGuNsxHoSuHiLYiJYVcPbnRMExxROvyB.6', 'Jefe de sala', 3, '$2y$10$Sp4zCo10FxiH6.6yus38IOTQAsjElm5qz1JEhQubtXblJRGosb4US', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas_de_conocimiento`
--

CREATE TABLE `areas_de_conocimiento` (
  `ID_Area` varchar(5) NOT NULL,
  `Nombre_Area` varchar(150) NOT NULL,
  `ID_Clasificacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `areas_de_conocimiento`
--

INSERT INTO `areas_de_conocimiento` (`ID_Area`, `Nombre_Area`, `ID_Clasificacion`) VALUES
('000', 'Generalidades', 2),
('100', 'Filosofia', 2),
('200', 'Religion', 2),
('300', 'Ciencias sociales', 2),
('400', 'Lenguas e idiomas', 2),
('500', 'Ciencias básicas', 2),
('600', 'Tecnología', 2),
('700', 'Arte y recreación', 2),
('800', 'Literatura', 2),
('900', 'Historia y Geografía', 2),
('Biog', 'Biografías', 2),
('N', 'Novela', 1),
('NV', 'Novela Venezolana', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `area_color`
--

CREATE TABLE `area_color` (
  `ID_Area_color` int(11) NOT NULL,
  `ID_Area` varchar(5) NOT NULL,
  `ID_Color` int(11) NOT NULL,
  `Orden` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autores`
--

CREATE TABLE `autores` (
  `ID_Autor` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `autores`
--

INSERT INTO `autores` (`ID_Autor`, `Nombre`) VALUES
(1, 'Gabriel García Márquez'),
(2, 'Kishimoto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `ID_Color` int(11) NOT NULL,
  `nombre_color` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuraciones_sistema`
--

CREATE TABLE `configuraciones_sistema` (
  `ID_Configuracion` int(11) NOT NULL,
  `Dias_Prestamo` int(11) NOT NULL DEFAULT 3,
  `Dias_Prestamo_Novelas` int(1) NOT NULL DEFAULT 7,
  `Monto_Multa_Dia` decimal(10,2) NOT NULL DEFAULT 0.50,
  `Limite_Prestamos_Simultaneos` int(11) NOT NULL DEFAULT 3,
  `Max_Renovaciones` int(11) NOT NULL DEFAULT 2,
  `poblacion_objetivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `configuraciones_sistema`
--

INSERT INTO `configuraciones_sistema` (`ID_Configuracion`, `Dias_Prestamo`, `Dias_Prestamo_Novelas`, `Monto_Multa_Dia`, `Limite_Prestamos_Simultaneos`, `Max_Renovaciones`, `poblacion_objetivo`) VALUES
(1, 3, 7, 0.50, 1, 1, 200);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion_dashboard`
--

CREATE TABLE `configuracion_dashboard` (
  `ID_Configuracion_Dashboard` int(11) NOT NULL DEFAULT 1,
  `mostrar_cobertura` tinyint(1) DEFAULT 1,
  `mostrar_referencia` tinyint(1) DEFAULT 1,
  `mostrar_grafico_consultas` tinyint(1) DEFAULT 1,
  `mostrar_cumplimiento` tinyint(1) DEFAULT 1,
  `mostrar_ocupacion` tinyint(1) DEFAULT 1,
  `mostrar_rotacion` tinyint(1) DEFAULT 1,
  `mostrar_estado_fisico` tinyint(1) DEFAULT 1,
  `mostrar_asistencia_estatal` tinyint(1) DEFAULT 1,
  `mostrar_coleccion` tinyint(1) DEFAULT 1,
  `mostrar_actividades` tinyint(1) DEFAULT 1,
  `mostrar_iiur` tinyint(1) NOT NULL DEFAULT 1,
  `mostrar_idcar` tinyint(1) NOT NULL DEFAULT 1,
  `mostrar_ipe` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `configuracion_dashboard`
--

INSERT INTO `configuracion_dashboard` (`ID_Configuracion_Dashboard`, `mostrar_cobertura`, `mostrar_referencia`, `mostrar_grafico_consultas`, `mostrar_cumplimiento`, `mostrar_ocupacion`, `mostrar_rotacion`, `mostrar_estado_fisico`, `mostrar_asistencia_estatal`, `mostrar_coleccion`, `mostrar_actividades`, `mostrar_iiur`, `mostrar_idcar`, `mostrar_ipe`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_area_diarias`
--

CREATE TABLE `consultas_area_diarias` (
  `ID_Consulta_Area` int(11) NOT NULL,
  `ID_Sala` varchar(3) NOT NULL,
  `ID_Area` varchar(5) NOT NULL,
  `Fecha` date NOT NULL,
  `Cantidad_Consultada` int(11) NOT NULL,
  `Turno` varchar(7) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `consultas_area_diarias`
--

INSERT INTO `consultas_area_diarias` (`ID_Consulta_Area`, `ID_Sala`, `ID_Area`, `Fecha`, `Cantidad_Consultada`, `Turno`, `ID_Admin`, `Activo`) VALUES
(2, 'R', '000', '2026-04-06', 2, '', 1, 1),
(3, 'R', '800', '2026-04-06', 6, '', 1, 1),
(4, 'G', '000', '2026-04-17', 4, '', 1, 1),
(5, 'G', '300', '2026-04-17', 6, '', 1, 1),
(6, 'G', '900', '2026-04-17', 2, '', 1, 1),
(7, 'G', 'Biog', '2026-04-17', 1, '', 1, 1),
(8, 'R', '200', '2026-05-17', 2, '', 1, 1),
(9, 'G', '000', '2026-05-18', 5, '', 1, 1),
(10, 'G', '300', '2026-05-18', 6, '', 1, 1),
(11, 'G', '900', '2026-05-18', 2, '', 1, 1),
(12, 'SE', '000', '2026-05-18', 3, '', 1, 1),
(13, 'SE', '300', '2026-05-18', 2, '', 1, 1),
(18, 'SE', '300', '2026-05-19', 4, '', 1, 1),
(19, 'G', '000', '2026-05-19', 3, '', 1, 1),
(20, 'G', '300', '2026-05-19', 4, '', 1, 1),
(21, 'G', 'NV', '2026-05-19', 2, '', 1, 1),
(22, 'G', '300', '2026-05-20', 3, 'Tarde', 1, 1),
(23, 'G', '400', '2026-05-20', 1, 'Tarde', 1, 1),
(24, 'G', '800', '2026-05-20', 2, 'Tarde', 1, 1),
(28, 'R', '300', '2026-05-20', 3, 'Mañana', 1, 1),
(29, 'G', '800', '2026-05-29', 2, 'Mañana', 1, 1),
(30, 'G', '900', '2026-05-29', 3, 'Mañana', 1, 1),
(31, 'G', 'N', '2026-05-29', 6, 'Mañana', 1, 1),
(32, 'G', 'N', '2026-06-01', 5, 'Mañana', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `conteo_diario_visitantes`
--

CREATE TABLE `conteo_diario_visitantes` (
  `ID_Conteo` int(11) NOT NULL,
  `ID_Sala` varchar(3) NOT NULL,
  `Fecha` date NOT NULL,
  `Niños_Hombres` int(11) NOT NULL DEFAULT 0,
  `Niños_Mujeres` int(11) NOT NULL DEFAULT 0,
  `Adolescentes_Hombres` int(11) NOT NULL DEFAULT 0,
  `Adolescentes_Mujeres` int(11) NOT NULL DEFAULT 0,
  `Adultos_Hombres` int(11) NOT NULL DEFAULT 0,
  `Adultos_Mujeres` int(11) NOT NULL DEFAULT 0,
  `Turno` varchar(7) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `conteo_diario_visitantes`
--

INSERT INTO `conteo_diario_visitantes` (`ID_Conteo`, `ID_Sala`, `Fecha`, `Niños_Hombres`, `Niños_Mujeres`, `Adolescentes_Hombres`, `Adolescentes_Mujeres`, `Adultos_Hombres`, `Adultos_Mujeres`, `Turno`, `ID_Admin`, `Activo`) VALUES
(3, 'R', '2026-04-06', 0, 23, 0, 23, 0, 0, 'Mañana', 1, 1),
(11, 'G', '2026-04-17', 1, 1, 3, 4, 6, 4, 'Mañana', 1, 1),
(12, 'R', '2026-05-17', 0, 0, 0, 0, 1, 2, 'Tarde', 1, 1),
(13, 'G', '2026-05-18', 0, 0, 5, 3, 2, 4, 'Mañana', 1, 1),
(15, 'SE', '2026-05-18', 0, 0, 3, 2, 2, 1, 'Mañana', 1, 1),
(16, 'G', '2026-05-20', 1, 2, 4, 3, 1, 1, 'Mañana', 1, 1),
(17, 'SE', '2026-05-19', 0, 0, 0, 0, 2, 2, 'Tarde', 1, 1),
(18, 'G', '2026-05-19', 0, 0, 1, 4, 2, 3, 'Tarde', 1, 1),
(24, 'G', '2026-05-20', 0, 0, 2, 2, 3, 1, 'Tarde', 1, 1),
(28, 'R', '2026-05-20', 0, 0, 0, 0, 2, 1, 'Mañana', 1, 1),
(29, 'G', '2026-05-29', 3, 2, 3, 4, 3, 2, 'Mañana', 1, 1),
(33, 'G', '2026-06-01', 3, 2, 2, 4, 2, 1, 'Mañana', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `editoriales`
--

CREATE TABLE `editoriales` (
  `ID_Editorial` int(11) NOT NULL,
  `Nombre` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `editoriales`
--

INSERT INTO `editoriales` (`ID_Editorial`, `Nombre`) VALUES
(7, ''),
(8, 'Monte Avila'),
(2, 'Planeta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplares`
--

CREATE TABLE `ejemplares` (
  `ID_Ejemplar` int(11) NOT NULL,
  `ID_Libro` int(11) NOT NULL,
  `Numero_Ejemplar` int(11) NOT NULL,
  `Estado` enum('Disponible','Prestado','Descatalogado','En Reparación','Dañado') NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `ejemplares`
--

INSERT INTO `ejemplares` (`ID_Ejemplar`, `ID_Libro`, `Numero_Ejemplar`, `Estado`, `Activo`) VALUES
(17, 25, 1, 'Disponible', 1),
(18, 25, 2, 'Disponible', 1),
(19, 27, 1, 'Disponible', 1),
(20, 27, 2, 'Disponible', 1),
(21, 28, 1, 'Disponible', 1),
(22, 28, 2, 'Disponible', 1),
(23, 29, 1, 'Disponible', 1),
(24, 29, 2, 'Disponible', 1),
(25, 30, 1, 'Disponible', 1),
(26, 30, 2, 'Disponible', 1),
(27, 31, 1, 'Disponible', 1),
(28, 31, 2, 'Disponible', 1),
(29, 37, 1, 'Disponible', 1),
(30, 37, 2, 'Disponible', 1),
(31, 38, 1, 'Disponible', 1),
(32, 38, 2, 'Disponible', 1),
(33, 39, 1, 'Disponible', 1),
(34, 39, 2, 'En Reparación', 1),
(35, 40, 1, 'Disponible', 1),
(36, 42, 1, 'Disponible', 1),
(37, 43, 1, 'Disponible', 1),
(38, 44, 1, 'Disponible', 1),
(39, 45, 1, 'Disponible', 1),
(40, 48, 1, 'Disponible', 1),
(41, 39, 3, 'En Reparación', 0),
(42, 51, 1, 'Disponible', 1),
(43, 51, 2, 'Disponible', 1),
(44, 56, 1, 'Disponible', 1),
(45, 56, 2, 'Disponible', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejemplar_prestamo`
--

CREATE TABLE `ejemplar_prestamo` (
  `ID_Prestamo_Ejemplar` int(11) NOT NULL,
  `ID_Prestamo` int(11) NOT NULL,
  `ID_Ejemplar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `ejemplar_prestamo`
--

INSERT INTO `ejemplar_prestamo` (`ID_Prestamo_Ejemplar`, `ID_Prestamo`, `ID_Ejemplar`) VALUES
(4, 4, 18),
(5, 5, 20),
(6, 6, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado_cuantificable`
--

CREATE TABLE `estado_cuantificable` (
  `ID_Estado_Q` int(11) NOT NULL,
  `ID_Ejemplar` int(11) NOT NULL,
  `ID_Danio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_actividad`
--

CREATE TABLE `historial_actividad` (
  `ID_Historial_Actividad` int(11) NOT NULL,
  `ID_Actividad` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Viejo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Viejo_Valor`)),
  `Nuevo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Nuevo_Valor`)),
  `Fecha_Cambio` datetime NOT NULL,
  `Tipo_Cambio` enum('INSERT','UPDATE','DELETE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `historial_actividad`
--

INSERT INTO `historial_actividad` (`ID_Historial_Actividad`, `ID_Actividad`, `ID_Admin`, `Viejo_Valor`, `Nuevo_Valor`, `Fecha_Cambio`, `Tipo_Cambio`) VALUES
(1, 8, 1, '[]', '{\"idActividad\":null,\"idAdmin\":1,\"organizador\":\"Biblioteca Pública A.Z.B\",\"categoria\":\"Cultural\",\"estado\":\"Completado\",\"asistentes\":22,\"descripcion\":\"Actividad especial por aniversario de la biblioteca\",\"fecha\":\"2026-05-20\"}', '2026-05-21 02:41:20', 'INSERT'),
(2, 5, 1, '{\"idActividad\":5,\"idAdmin\":1,\"organizador\":\"Biblioteca Pública A.Z.B\",\"categoria\":\"Reunión\",\"estado\":\"Pendiente\",\"asistentes\":12,\"descripcion\":\"Reunión para planificación del mes de junio\",\"fecha\":\"2026-05-22\"}', '{\"idActividad\":5,\"idAdmin\":1,\"organizador\":\"Biblioteca Pública A.Z.B\",\"categoria\":\"Reunión\",\"estado\":\"Completado\",\"asistentes\":12,\"descripcion\":\"Reunión para planificación del mes de junio\",\"fecha\":\"2026-05-20\"}', '2026-05-21 02:46:51', 'UPDATE'),
(3, 4, 1, '{\"idActividad\":4,\"idAdmin\":1,\"organizador\":\"División de cultura\",\"categoria\":\"Educativa\",\"estado\":\"Completado\",\"asistentes\":32,\"descripcion\":\"Se realizó una actividad educativa con niños de la comunidad\",\"fecha\":\"2026-04-30\"}', '{\"idActividad\":4,\"idAdmin\":1,\"organizador\":\"División de cultura\",\"categoria\":\"Educativa\",\"estado\":\"Completado\",\"asistentes\":32,\"descripcion\":\"Se realizó una actividad educativa con niños de la comunidad Casco histórico\",\"fecha\":\"2026-05-19\"}', '2026-05-21 04:43:49', 'UPDATE'),
(4, 5, 1, '{\"idActividad\":5,\"idAdmin\":1,\"organizador\":\"Biblioteca Pública A.Z.B\",\"categoria\":\"Reunión\",\"estado\":\"Completado\",\"asistentes\":12,\"descripcion\":\"Reunión para planificación del mes de junio\",\"fecha\":\"2026-05-20\"}', '{\"idActividad\":5,\"idAdmin\":1,\"organizador\":\"Biblioteca Pública A.Z.B\",\"categoria\":\"Reunión\",\"estado\":\"Completado\",\"asistentes\":16,\"descripcion\":\"Reunión para planificación del mes de junio\",\"fecha\":\"2026-05-20\"}', '2026-05-21 04:44:32', 'UPDATE'),
(5, 9, 1, '[]', '{\"idActividad\":null,\"idAdmin\":1,\"organizador\":\"Instituto Autónomo de Cultura\",\"categoria\":\"Cultural\",\"estado\":\"Completado\",\"asistentes\":45,\"descripcion\":\"Actividad difundiendo la lectura entre niños, niñas y adolescentes\",\"fecha\":\"2026-05-21\"}', '2026-05-21 09:27:00', 'INSERT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_daño_ejemplar`
--

CREATE TABLE `historial_daño_ejemplar` (
  `ID_Historial_Dano` int(11) NOT NULL,
  `ID_Ejemplar` int(11) NOT NULL,
  `ID_Danio` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Fecha_Cambio` datetime NOT NULL,
  `Tipo_Cambio` enum('REGISTRO','ELIMINACION') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_lector`
--

CREATE TABLE `historial_lector` (
  `ID_Historial_Lector` int(11) NOT NULL,
  `ID_Persona` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Viejo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Viejo_Valor`)),
  `Nuevo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Nuevo_Valor`)),
  `Fecha_Cambio` datetime NOT NULL,
  `Tipo_Cambio` enum('INSERT','UPDATE','DELETE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_libro`
--

CREATE TABLE `historial_libro` (
  `ID_Historial_Libro` int(11) NOT NULL,
  `ID_Libro` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Viejo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Viejo_Valor`)),
  `Nuevo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Nuevo_Valor`)),
  `Fecha_Cambio` datetime NOT NULL,
  `Tipo_Cambio` enum('INSERT','UPDATE','DELETE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_multa`
--

CREATE TABLE `historial_multa` (
  `ID_Historial_Multa` int(11) NOT NULL,
  `ID_Multa` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Viejo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Viejo_Valor`)),
  `Nuevo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Nuevo_Valor`)),
  `Fecha_Cambio` datetime NOT NULL,
  `Tipo_Cambio` enum('INSERT','UPDATE','DELETE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_prestamo`
--

CREATE TABLE `historial_prestamo` (
  `ID_Historial_Prestamo` int(11) NOT NULL,
  `ID_Prestamo` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Viejo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Viejo_Valor`)),
  `Nuevo_Valor` longtext DEFAULT NULL CHECK (json_valid(`Nuevo_Valor`)),
  `Fecha_Cambio` datetime NOT NULL,
  `Tipo_Cambio` enum('INSERT','UPDATE','DELETE') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lectores`
--

CREATE TABLE `lectores` (
  `ID_Lector` int(11) NOT NULL,
  `ID_Persona` int(11) NOT NULL,
  `Carnet` varchar(50) DEFAULT NULL,
  `Sexo` char(1) DEFAULT NULL,
  `Direccion` varchar(150) DEFAULT NULL,
  `Profesion` varchar(100) DEFAULT NULL,
  `Telefono_Profesion` varchar(20) DEFAULT NULL,
  `Direccion_Profesion` varchar(150) DEFAULT NULL,
  `Ref_Personal` varchar(100) DEFAULT NULL,
  `Ref_Personal_Tel` varchar(20) DEFAULT NULL,
  `Ref_Legal` varchar(100) DEFAULT NULL,
  `Ref_Legal_Tel` varchar(20) DEFAULT NULL,
  `Vencimiento_Carnet` date DEFAULT NULL,
  `Fecha_Registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `Estado` enum('Activo','Inactivo','Inhabilitado') NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `lectores`
--

INSERT INTO `lectores` (`ID_Lector`, `ID_Persona`, `Carnet`, `Sexo`, `Direccion`, `Profesion`, `Telefono_Profesion`, `Direccion_Profesion`, `Ref_Personal`, `Ref_Personal_Tel`, `Ref_Legal`, `Ref_Legal_Tel`, `Vencimiento_Carnet`, `Fecha_Registro`, `Estado`, `Activo`) VALUES
(1, 7, '1234567890', 'M', 'Caiguire, calle El Cementerio', 'Panadero', '02934318929', 'Avenida Gran Mariscal', NULL, NULL, NULL, NULL, NULL, '2026-01-22 22:13:10', 'Activo', 1),
(2, 9, '1234567898', 'M', 'Caiguire, calle El Cementerio', 'Peluquero', '02934318929', 'Avenida Gran Mariscal', '', '', 'Jesús Pérez', '04123216549', NULL, '2026-01-22 23:19:16', 'Activo', 1),
(3, 11, '1334567898', 'F', 'Caiguire, calle El Cementerio', 'Peluquera', '02934318929', 'A.V Gran Mariscal', '', '', 'Jesús Pérez  ', '04123216549', NULL, '2026-01-23 01:48:47', 'Activo', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `ID_Libro` int(11) NOT NULL,
  `Titulo` varchar(255) NOT NULL,
  `ID_Editorial` int(11) DEFAULT NULL,
  `ID_Area` varchar(5) DEFAULT NULL,
  `ID_Sala` varchar(3) NOT NULL,
  `Cota` varchar(50) NOT NULL,
  `Edicion` int(11) NOT NULL,
  `Ciudad` varchar(50) NOT NULL,
  `ISBN` varchar(20) DEFAULT NULL,
  `Paginas` int(11) DEFAULT NULL,
  `volumen` varchar(6) DEFAULT NULL,
  `Observaciones` text DEFAULT NULL,
  `Anio_Publicacion` year(4) DEFAULT NULL,
  `Fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`ID_Libro`, `Titulo`, `ID_Editorial`, `ID_Area`, `ID_Sala`, `Cota`, `Edicion`, `Ciudad`, `ISBN`, `Paginas`, `volumen`, `Observaciones`, `Anio_Publicacion`, `Fecha_registro`, `Activo`) VALUES
(25, 'Cien años de soledad', 2, 'N', 'R', 'N G455', 0, '', '123-5435-42-X', 354, NULL, '', '2008', '2025-12-29 06:08:29', 1),
(27, 'Cien años de soledad', 2, 'N', 'G', 'N G452', 2, 'Bogota', '123-5435-42-9', 354, NULL, '', '2008', '2025-12-29 06:10:08', 1),
(28, 'Cien años de soledad', 2, 'N', 'R', 'N G466', 0, '', '123-5435-42-5', 354, NULL, '', '2008', '2026-01-05 07:05:00', 1),
(29, 'Cien años de soledad', 2, 'N', 'R', 'N G465', 0, '', '123-5435-42-2', 354, NULL, '', '2008', '2026-01-05 07:33:12', 1),
(30, 'Cien años de soledad', 2, 'N', 'G', 'N M465', 0, '', '123-5435-42-1', 354, NULL, '', '2008', '2026-01-06 19:59:13', 1),
(31, 'Cien años de soledad', 2, 'N', 'SE', 'N M365', 0, '', '123-5435-46-1', 354, NULL, '', '2008', '2026-01-11 05:55:57', 1),
(37, 'Cien años de soledad', 2, 'N', 'SE', 'N M165', 0, '', '122-5435-46-1', 354, NULL, '', '2008', '2026-01-11 06:22:29', 1),
(38, 'Cien años de soledad', 2, 'N', 'SE', 'N M125', 6, 'Bogota', '122-5435-49-1', 354, NULL, '', '2008', '2026-01-11 06:34:13', 1),
(39, 'Cien años de soledad', 8, 'N', 'G', 'N M025', 3, 'Bogota', '122-5405-49-1', 354, '', '', '2009', '2026-01-12 02:46:25', 1),
(40, 'Cien años de soledad', 2, 'N', 'R', 'N G025', 6, 'Bogota', '222-5405-49-1', 354, NULL, '', '2008', '2026-01-12 06:14:34', 1),
(42, 'Cien años de soledad', 2, 'N', 'R', 'N M035', 6, 'Bogota', '232-5405-49-1', 354, NULL, '', '2008', '2026-01-12 06:22:09', 1),
(43, 'Cien años de soledad', 2, 'N', 'R', 'N M036', 6, 'Bogota', '232-5405-49-X', 354, NULL, '', '2008', '2026-01-12 06:26:08', 1),
(44, 'Cien años de soledad', 2, 'N', 'R', 'N G021', 6, 'Bogota', '222-5405-49-4', 354, NULL, '', '2008', '2026-01-12 06:31:48', 1),
(45, 'Cien años de soledad', 2, 'N', 'G', 'N G543', 6, 'Bogota', '222-5405-49-6', 354, NULL, '', '2008', '2026-01-16 04:40:25', 1),
(48, 'Cien años de soledad', 7, 'N', 'R', '', 0, '', NULL, 0, NULL, NULL, NULL, '2026-01-21 23:34:37', 1),
(51, 'NARUTO', 2, 'N', 'G', 'N M542', 6, 'Tokio', '123-5435-22-9', 354, NULL, '', '2008', '2026-02-13 09:50:32', 1),
(56, 'Cien años de soledad', 2, 'N', 'R', 'N G4522008', 6, 'Bogota', '177-5435-42-X', 354, NULL, '', '2008', '2026-05-06 12:57:53', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros_autores`
--

CREATE TABLE `libros_autores` (
  `ID_Libro_Autor` int(11) NOT NULL,
  `ID_Libro` int(11) NOT NULL,
  `ID_Autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `libros_autores`
--

INSERT INTO `libros_autores` (`ID_Libro_Autor`, `ID_Libro`, `ID_Autor`) VALUES
(9, 25, 1),
(76, 27, 1),
(11, 28, 1),
(12, 29, 1),
(13, 30, 1),
(14, 31, 1),
(15, 37, 1),
(16, 38, 1),
(74, 39, 1),
(18, 40, 1),
(19, 42, 1),
(20, 43, 1),
(21, 44, 1),
(22, 45, 1),
(75, 51, 2),
(77, 56, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logros`
--

CREATE TABLE `logros` (
  `ID_Logro` int(11) NOT NULL,
  `ID_Admin` int(11) DEFAULT NULL,
  `Descripcion` text NOT NULL,
  `Involucrados` text DEFAULT NULL,
  `Fecha` date NOT NULL,
  `Activo` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `logros`
--

INSERT INTO `logros` (`ID_Logro`, `ID_Admin`, `Descripcion`, `Involucrados`, `Fecha`, `Activo`) VALUES
(1, NULL, 'Se recuperó un aire acondicionado para la sala Estatal', 'Equipo de mantenimiento', '2026-01-22', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multas`
--

CREATE TABLE `multas` (
  `ID_Multa` int(11) NOT NULL,
  `ID_Prestamo` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Monto` decimal(10,2) NOT NULL,
  `Fecha_Cancelacion` date DEFAULT NULL,
  `Estado` enum('Pendiente','Pagada','Cancelada') NOT NULL,
  `Fecha_Generacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `multas`
--

INSERT INTO `multas` (`ID_Multa`, `ID_Prestamo`, `ID_Admin`, `Monto`, `Fecha_Cancelacion`, `Estado`, `Fecha_Generacion`, `Activo`) VALUES
(1, 4, 1, 0.50, '2026-05-06', 'Pagada', '2026-05-06 05:34:46', 1),
(2, 6, 1, 0.50, NULL, 'Pendiente', '2026-05-06 06:15:22', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `ID_Persona` int(11) NOT NULL,
  `Cedula` varchar(20) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Apellido` varchar(100) NOT NULL,
  `Telefono` varchar(20) DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`ID_Persona`, `Cedula`, `Nombre`, `Apellido`, `Telefono`, `Activo`) VALUES
(1, '27458925', 'Victor Alfredo', 'Zambrano Rivero', '04248630743', 1),
(7, '27458926', 'José Manuel', 'Perez Brito', '04127896543', 1),
(9, '26458922', 'José Luis', 'Perez Brito', '04127896543', 1),
(11, '25458922', 'Maria Alejandra', 'Rodríguez Brito', '04127896543', 1),
(14, '26458944', 'José Luis', 'Perez Brito', '04248630743', 1),
(17, '26458942', 'José Luis', 'Perez Brito', '04248630743', 1),
(19, '27458425', 'José Alfredo', 'Zambrano Rivero', '04148630743', 1),
(24, '27458426', 'José Manuel', 'Rivero Zambrano', '04148630743', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_seguridad`
--

CREATE TABLE `preguntas_seguridad` (
  `ID_Pregunta` int(11) NOT NULL,
  `Pregunta` varchar(150) DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `preguntas_seguridad`
--

INSERT INTO `preguntas_seguridad` (`ID_Pregunta`, `Pregunta`, `Activo`) VALUES
(1, '¿Cuál es el nombre de tu primera mascota?', 1),
(2, '¿Cuál era el título de tu libro favorito?', 1),
(3, '¿En qué ciudad viven tus padres?', 1),
(4, '¿Qué ciudad es tu viaje soñado?', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `ID_Prestamo` int(11) NOT NULL,
  `ID_Lector` int(11) NOT NULL,
  `ID_Admin` int(11) NOT NULL,
  `Fecha_Entrega` date NOT NULL,
  `Fecha_Recepcion_Estipulada` date NOT NULL,
  `Fecha_Recepcion_Real` date DEFAULT NULL,
  `Renovaciones` int(11) NOT NULL DEFAULT 0,
  `Estado_Entrega` enum('Pendiente','Devuelto','Vencido','Perdido') NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`ID_Prestamo`, `ID_Lector`, `ID_Admin`, `Fecha_Entrega`, `Fecha_Recepcion_Estipulada`, `Fecha_Recepcion_Real`, `Renovaciones`, `Estado_Entrega`, `Activo`) VALUES
(4, 1, 1, '2026-05-04', '2026-05-05', '2026-05-06', 0, 'Vencido', 1),
(5, 2, 1, '0000-00-00', '2026-05-20', '2026-05-06', 0, 'Devuelto', 1),
(6, 1, 1, '2026-05-06', '2026-05-05', '2026-05-06', 0, 'Vencido', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salas`
--

CREATE TABLE `salas` (
  `ID_Sala` varchar(3) NOT NULL,
  `Nombre` varchar(40) NOT NULL,
  `Capacidad` int(11) NOT NULL DEFAULT 20,
  `Disponible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `salas`
--

INSERT INTO `salas` (`ID_Sala`, `Nombre`, `Capacidad`, `Disponible`) VALUES
('G', 'Sala General', 30, 1),
('R', 'Sala de Referencia', 20, 1),
('SE', 'Sala Estatal', 20, 1),
('X', 'Sala Infantil', 20, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_de_clasificacion`
--

CREATE TABLE `tipos_de_clasificacion` (
  `ID_Clasificacion` int(11) NOT NULL,
  `Nombre_Clasificacion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `tipos_de_clasificacion`
--

INSERT INTO `tipos_de_clasificacion` (`ID_Clasificacion`, `Nombre_Clasificacion`) VALUES
(3, 'Areas infantiles'),
(2, 'Decimal de Dewey'),
(1, 'Sistema Nacional');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_de_daño`
--

CREATE TABLE `tipos_de_daño` (
  `ID_Danio` int(11) NOT NULL,
  `Nombre_Danio` varchar(100) NOT NULL,
  `Puntos_Demerito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`ID_Actividad`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`ID_Admin`),
  ADD UNIQUE KEY `ID_Persona` (`ID_Persona`),
  ADD UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`),
  ADD KEY `fk_pregunta_seguridad` (`ID_Pregunta`);

--
-- Indices de la tabla `areas_de_conocimiento`
--
ALTER TABLE `areas_de_conocimiento`
  ADD PRIMARY KEY (`ID_Area`),
  ADD UNIQUE KEY `Nombre_Area` (`Nombre_Area`),
  ADD KEY `ID_Clasificacion` (`ID_Clasificacion`);

--
-- Indices de la tabla `area_color`
--
ALTER TABLE `area_color`
  ADD PRIMARY KEY (`ID_Area_color`),
  ADD UNIQUE KEY `UQ_Area_Color` (`ID_Area`,`ID_Color`),
  ADD KEY `ID_Color` (`ID_Color`);

--
-- Indices de la tabla `autores`
--
ALTER TABLE `autores`
  ADD PRIMARY KEY (`ID_Autor`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`ID_Color`),
  ADD UNIQUE KEY `nombre_color` (`nombre_color`);

--
-- Indices de la tabla `configuraciones_sistema`
--
ALTER TABLE `configuraciones_sistema`
  ADD PRIMARY KEY (`ID_Configuracion`);

--
-- Indices de la tabla `configuracion_dashboard`
--
ALTER TABLE `configuracion_dashboard`
  ADD PRIMARY KEY (`ID_Configuracion_Dashboard`);

--
-- Indices de la tabla `consultas_area_diarias`
--
ALTER TABLE `consultas_area_diarias`
  ADD PRIMARY KEY (`ID_Consulta_Area`),
  ADD UNIQUE KEY `UQ_Area_Dia_Sala` (`ID_Sala`,`ID_Area`,`Fecha`),
  ADD KEY `ID_Area` (`ID_Area`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `conteo_diario_visitantes`
--
ALTER TABLE `conteo_diario_visitantes`
  ADD PRIMARY KEY (`ID_Conteo`),
  ADD UNIQUE KEY `UQ_Conteo_Dia_Sala` (`ID_Sala`,`Fecha`,`Turno`) USING BTREE,
  ADD KEY `conteo_diario_visitantes_ibfk_2` (`ID_Admin`);

--
-- Indices de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  ADD PRIMARY KEY (`ID_Editorial`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  ADD PRIMARY KEY (`ID_Ejemplar`),
  ADD UNIQUE KEY `UQ_Ejemplar_Num` (`ID_Libro`,`Numero_Ejemplar`);

--
-- Indices de la tabla `ejemplar_prestamo`
--
ALTER TABLE `ejemplar_prestamo`
  ADD PRIMARY KEY (`ID_Prestamo_Ejemplar`),
  ADD UNIQUE KEY `UQ_Prestamo_Ejemplar` (`ID_Prestamo`,`ID_Ejemplar`),
  ADD KEY `ID_Ejemplar` (`ID_Ejemplar`);

--
-- Indices de la tabla `estado_cuantificable`
--
ALTER TABLE `estado_cuantificable`
  ADD PRIMARY KEY (`ID_Estado_Q`),
  ADD UNIQUE KEY `UQ_Estado_Danio` (`ID_Ejemplar`,`ID_Danio`),
  ADD KEY `ID_Danio` (`ID_Danio`);

--
-- Indices de la tabla `historial_actividad`
--
ALTER TABLE `historial_actividad`
  ADD PRIMARY KEY (`ID_Historial_Actividad`),
  ADD KEY `ID_Actividad` (`ID_Actividad`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `historial_daño_ejemplar`
--
ALTER TABLE `historial_daño_ejemplar`
  ADD PRIMARY KEY (`ID_Historial_Dano`),
  ADD KEY `ID_Ejemplar` (`ID_Ejemplar`),
  ADD KEY `ID_Danio` (`ID_Danio`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `historial_lector`
--
ALTER TABLE `historial_lector`
  ADD PRIMARY KEY (`ID_Historial_Lector`),
  ADD KEY `ID_Persona` (`ID_Persona`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `historial_libro`
--
ALTER TABLE `historial_libro`
  ADD PRIMARY KEY (`ID_Historial_Libro`),
  ADD KEY `ID_Libro` (`ID_Libro`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `historial_multa`
--
ALTER TABLE `historial_multa`
  ADD PRIMARY KEY (`ID_Historial_Multa`),
  ADD KEY `ID_Multa` (`ID_Multa`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `historial_prestamo`
--
ALTER TABLE `historial_prestamo`
  ADD PRIMARY KEY (`ID_Historial_Prestamo`),
  ADD KEY `ID_Prestamo` (`ID_Prestamo`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `lectores`
--
ALTER TABLE `lectores`
  ADD PRIMARY KEY (`ID_Lector`),
  ADD UNIQUE KEY `Carnet` (`Carnet`),
  ADD KEY `lectores_ibfk_1` (`ID_Persona`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`ID_Libro`),
  ADD UNIQUE KEY `Cota` (`Cota`),
  ADD UNIQUE KEY `ISBN` (`ISBN`),
  ADD KEY `ID_Editorial` (`ID_Editorial`),
  ADD KEY `ID_Area` (`ID_Area`),
  ADD KEY `ID_Sala` (`ID_Sala`) USING BTREE;

--
-- Indices de la tabla `libros_autores`
--
ALTER TABLE `libros_autores`
  ADD PRIMARY KEY (`ID_Libro_Autor`),
  ADD UNIQUE KEY `UQ_Libro_Autor` (`ID_Libro`,`ID_Autor`),
  ADD KEY `ID_Autor` (`ID_Autor`);

--
-- Indices de la tabla `logros`
--
ALTER TABLE `logros`
  ADD PRIMARY KEY (`ID_Logro`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `multas`
--
ALTER TABLE `multas`
  ADD PRIMARY KEY (`ID_Multa`),
  ADD KEY `ID_Prestamo` (`ID_Prestamo`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`ID_Persona`),
  ADD UNIQUE KEY `Cedula` (`Cedula`);

--
-- Indices de la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  ADD PRIMARY KEY (`ID_Pregunta`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`ID_Prestamo`),
  ADD KEY `ID_Lector` (`ID_Lector`),
  ADD KEY `ID_Admin` (`ID_Admin`);

--
-- Indices de la tabla `salas`
--
ALTER TABLE `salas`
  ADD PRIMARY KEY (`ID_Sala`),
  ADD UNIQUE KEY `Nombre` (`Nombre`);

--
-- Indices de la tabla `tipos_de_clasificacion`
--
ALTER TABLE `tipos_de_clasificacion`
  ADD PRIMARY KEY (`ID_Clasificacion`),
  ADD UNIQUE KEY `Nombre_Clasificacion` (`Nombre_Clasificacion`);

--
-- Indices de la tabla `tipos_de_daño`
--
ALTER TABLE `tipos_de_daño`
  ADD PRIMARY KEY (`ID_Danio`),
  ADD UNIQUE KEY `Nombre_Danio` (`Nombre_Danio`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `ID_Actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `ID_Admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `area_color`
--
ALTER TABLE `area_color`
  MODIFY `ID_Area_color` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `autores`
--
ALTER TABLE `autores`
  MODIFY `ID_Autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `ID_Color` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `configuraciones_sistema`
--
ALTER TABLE `configuraciones_sistema`
  MODIFY `ID_Configuracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `consultas_area_diarias`
--
ALTER TABLE `consultas_area_diarias`
  MODIFY `ID_Consulta_Area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `conteo_diario_visitantes`
--
ALTER TABLE `conteo_diario_visitantes`
  MODIFY `ID_Conteo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `editoriales`
--
ALTER TABLE `editoriales`
  MODIFY `ID_Editorial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  MODIFY `ID_Ejemplar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `ejemplar_prestamo`
--
ALTER TABLE `ejemplar_prestamo`
  MODIFY `ID_Prestamo_Ejemplar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `estado_cuantificable`
--
ALTER TABLE `estado_cuantificable`
  MODIFY `ID_Estado_Q` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_actividad`
--
ALTER TABLE `historial_actividad`
  MODIFY `ID_Historial_Actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `historial_daño_ejemplar`
--
ALTER TABLE `historial_daño_ejemplar`
  MODIFY `ID_Historial_Dano` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_lector`
--
ALTER TABLE `historial_lector`
  MODIFY `ID_Historial_Lector` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_libro`
--
ALTER TABLE `historial_libro`
  MODIFY `ID_Historial_Libro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_multa`
--
ALTER TABLE `historial_multa`
  MODIFY `ID_Historial_Multa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial_prestamo`
--
ALTER TABLE `historial_prestamo`
  MODIFY `ID_Historial_Prestamo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lectores`
--
ALTER TABLE `lectores`
  MODIFY `ID_Lector` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `ID_Libro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de la tabla `libros_autores`
--
ALTER TABLE `libros_autores`
  MODIFY `ID_Libro_Autor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `logros`
--
ALTER TABLE `logros`
  MODIFY `ID_Logro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `multas`
--
ALTER TABLE `multas`
  MODIFY `ID_Multa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `ID_Persona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  MODIFY `ID_Pregunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `ID_Prestamo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `tipos_de_clasificacion`
--
ALTER TABLE `tipos_de_clasificacion`
  MODIFY `ID_Clasificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipos_de_daño`
--
ALTER TABLE `tipos_de_daño`
  MODIFY `ID_Danio` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD CONSTRAINT `administradores_ibfk_1` FOREIGN KEY (`ID_Persona`) REFERENCES `persona` (`ID_Persona`),
  ADD CONSTRAINT `fk_pregunta_seguridad` FOREIGN KEY (`ID_Pregunta`) REFERENCES `preguntas_seguridad` (`ID_Pregunta`);

--
-- Filtros para la tabla `areas_de_conocimiento`
--
ALTER TABLE `areas_de_conocimiento`
  ADD CONSTRAINT `areas_de_conocimiento_ibfk_1` FOREIGN KEY (`ID_Clasificacion`) REFERENCES `tipos_de_clasificacion` (`ID_Clasificacion`);

--
-- Filtros para la tabla `area_color`
--
ALTER TABLE `area_color`
  ADD CONSTRAINT `area_color_ibfk_1` FOREIGN KEY (`ID_Area`) REFERENCES `areas_de_conocimiento` (`ID_Area`),
  ADD CONSTRAINT `area_color_ibfk_2` FOREIGN KEY (`ID_Color`) REFERENCES `colores` (`ID_Color`);

--
-- Filtros para la tabla `consultas_area_diarias`
--
ALTER TABLE `consultas_area_diarias`
  ADD CONSTRAINT `consultas_area_diarias_ibfk_1` FOREIGN KEY (`ID_Sala`) REFERENCES `salas` (`ID_Sala`),
  ADD CONSTRAINT `consultas_area_diarias_ibfk_2` FOREIGN KEY (`ID_Area`) REFERENCES `areas_de_conocimiento` (`ID_Area`),
  ADD CONSTRAINT `consultas_area_diarias_ibfk_3` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `conteo_diario_visitantes`
--
ALTER TABLE `conteo_diario_visitantes`
  ADD CONSTRAINT `conteo_diario_visitantes_ibfk_1` FOREIGN KEY (`ID_Sala`) REFERENCES `salas` (`ID_Sala`),
  ADD CONSTRAINT `conteo_diario_visitantes_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `ejemplares`
--
ALTER TABLE `ejemplares`
  ADD CONSTRAINT `ejemplares_ibfk_1` FOREIGN KEY (`ID_Libro`) REFERENCES `libros` (`ID_Libro`);

--
-- Filtros para la tabla `ejemplar_prestamo`
--
ALTER TABLE `ejemplar_prestamo`
  ADD CONSTRAINT `ejemplar_prestamo_ibfk_1` FOREIGN KEY (`ID_Prestamo`) REFERENCES `prestamos` (`ID_Prestamo`),
  ADD CONSTRAINT `ejemplar_prestamo_ibfk_2` FOREIGN KEY (`ID_Ejemplar`) REFERENCES `ejemplares` (`ID_Ejemplar`);

--
-- Filtros para la tabla `estado_cuantificable`
--
ALTER TABLE `estado_cuantificable`
  ADD CONSTRAINT `estado_cuantificable_ibfk_1` FOREIGN KEY (`ID_Ejemplar`) REFERENCES `ejemplares` (`ID_Ejemplar`),
  ADD CONSTRAINT `estado_cuantificable_ibfk_2` FOREIGN KEY (`ID_Danio`) REFERENCES `tipos_de_daño` (`ID_Danio`);

--
-- Filtros para la tabla `historial_actividad`
--
ALTER TABLE `historial_actividad`
  ADD CONSTRAINT `historial_actividad_ibfk_1` FOREIGN KEY (`ID_Actividad`) REFERENCES `actividades` (`ID_Actividad`),
  ADD CONSTRAINT `historial_actividad_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `historial_daño_ejemplar`
--
ALTER TABLE `historial_daño_ejemplar`
  ADD CONSTRAINT `historial_daño_ejemplar_ibfk_1` FOREIGN KEY (`ID_Ejemplar`) REFERENCES `ejemplares` (`ID_Ejemplar`),
  ADD CONSTRAINT `historial_daño_ejemplar_ibfk_2` FOREIGN KEY (`ID_Danio`) REFERENCES `tipos_de_daño` (`ID_Danio`),
  ADD CONSTRAINT `historial_daño_ejemplar_ibfk_3` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `historial_lector`
--
ALTER TABLE `historial_lector`
  ADD CONSTRAINT `historial_lector_ibfk_1` FOREIGN KEY (`ID_Persona`) REFERENCES `persona` (`ID_Persona`),
  ADD CONSTRAINT `historial_lector_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `historial_libro`
--
ALTER TABLE `historial_libro`
  ADD CONSTRAINT `historial_libro_ibfk_1` FOREIGN KEY (`ID_Libro`) REFERENCES `libros` (`ID_Libro`),
  ADD CONSTRAINT `historial_libro_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `historial_multa`
--
ALTER TABLE `historial_multa`
  ADD CONSTRAINT `historial_multa_ibfk_1` FOREIGN KEY (`ID_Multa`) REFERENCES `multas` (`ID_Multa`),
  ADD CONSTRAINT `historial_multa_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `historial_prestamo`
--
ALTER TABLE `historial_prestamo`
  ADD CONSTRAINT `historial_prestamo_ibfk_1` FOREIGN KEY (`ID_Prestamo`) REFERENCES `prestamos` (`ID_Prestamo`),
  ADD CONSTRAINT `historial_prestamo_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `lectores`
--
ALTER TABLE `lectores`
  ADD CONSTRAINT `lectores_ibfk_1` FOREIGN KEY (`ID_Persona`) REFERENCES `persona` (`ID_Persona`);

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`ID_Editorial`) REFERENCES `editoriales` (`ID_Editorial`),
  ADD CONSTRAINT `libros_ibfk_2` FOREIGN KEY (`ID_Area`) REFERENCES `areas_de_conocimiento` (`ID_Area`),
  ADD CONSTRAINT `libros_ibfk_3` FOREIGN KEY (`ID_Sala`) REFERENCES `salas` (`ID_Sala`);

--
-- Filtros para la tabla `libros_autores`
--
ALTER TABLE `libros_autores`
  ADD CONSTRAINT `libros_autores_ibfk_1` FOREIGN KEY (`ID_Libro`) REFERENCES `libros` (`ID_Libro`),
  ADD CONSTRAINT `libros_autores_ibfk_2` FOREIGN KEY (`ID_Autor`) REFERENCES `autores` (`ID_Autor`);

--
-- Filtros para la tabla `logros`
--
ALTER TABLE `logros`
  ADD CONSTRAINT `logros_ibfk_1` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `multas`
--
ALTER TABLE `multas`
  ADD CONSTRAINT `multas_ibfk_1` FOREIGN KEY (`ID_Prestamo`) REFERENCES `prestamos` (`ID_Prestamo`),
  ADD CONSTRAINT `multas_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`ID_Lector`) REFERENCES `lectores` (`ID_Lector`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`ID_Admin`) REFERENCES `administradores` (`ID_Admin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
