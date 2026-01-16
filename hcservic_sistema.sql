-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-09-2025 a las 12:19:36
-- Versión del servidor: 8.0.34
-- Versión de PHP: 8.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `hcservic_sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo` enum('PERSONA','EMPRESA') COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` enum('CI','NIT','PASAPORTE','OTRO') COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ciudad` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Santa Cruz',
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `tipo`, `nombre`, `tipo_documento`, `numero_documento`, `telefono_1`, `telefono_2`, `telefono_3`, `email`, `ciudad`, `direccion`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'EMPRESA', 'Arturo Rocha / Ci Control', 'OTRO', '0', '72194508', NULL, NULL, NULL, 'Santa Cruz', 'Sin direccion', '2025-08-19 13:40:25', '2025-08-19 13:40:25', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizaciones`
--

CREATE TABLE `cotizaciones` (
  `id` bigint UNSIGNED NOT NULL,
  `recepcion_id` bigint UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `subtotal` decimal(12,2) NOT NULL DEFAULT '0.00',
  `descuento` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizaciones`
--

INSERT INTO `cotizaciones` (`id`, `recepcion_id`, `fecha`, `subtotal`, `descuento`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-08-19', 51.00, 0.00, 51.00, '2025-08-19 14:13:57', '2025-08-21 19:32:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_equipos`
--

CREATE TABLE `cotizacion_equipos` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_id` bigint UNSIGNED NOT NULL,
  `equipo_id` bigint UNSIGNED NOT NULL,
  `trabajo_realizar` text COLLATE utf8mb4_unicode_ci,
  `precio_trabajo` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total_repuestos` decimal(12,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizacion_equipos`
--

INSERT INTO `cotizacion_equipos` (`id`, `cotizacion_id`, `equipo_id`, `trabajo_realizar`, `precio_trabajo`, `total_repuestos`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'DIAGNOSTICO', 50.00, 1.00, '2025-08-21 19:32:55', '2025-08-21 19:32:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_equipo_fotos`
--

CREATE TABLE `cotizacion_equipo_fotos` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_equipo_id` bigint UNSIGNED NOT NULL,
  `fotos_equipos_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizacion_equipo_fotos`
--

INSERT INTO `cotizacion_equipo_fotos` (`id`, `cotizacion_equipo_id`, `fotos_equipos_id`, `created_at`, `updated_at`) VALUES
(8, 3, 3, NULL, NULL),
(9, 3, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_repuestos`
--

CREATE TABLE `cotizacion_repuestos` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_equipo_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int NOT NULL DEFAULT '1',
  `precio_unitario` decimal(12,2) NOT NULL,
  `subtotal` decimal(12,2) GENERATED ALWAYS AS ((`cantidad` * `precio_unitario`)) VIRTUAL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizacion_repuestos`
--

INSERT INTO `cotizacion_repuestos` (`id`, `cotizacion_equipo_id`, `nombre`, `cantidad`, `precio_unitario`, `created_at`, `updated_at`) VALUES
(3, 3, 'DIAGNOSTICO', 1, 1.00, '2025-08-21 19:32:55', '2025-08-21 19:32:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cotizacion_servicios`
--

CREATE TABLE `cotizacion_servicios` (
  `id` bigint UNSIGNED NOT NULL,
  `cotizacion_equipo_id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cotizacion_servicios`
--

INSERT INTO `cotizacion_servicios` (`id`, `cotizacion_equipo_id`, `nombre`, `created_at`, `updated_at`) VALUES
(3, 3, 'DIAGNOSTICO', '2025-08-21 19:32:55', '2025-08-21 19:32:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `egresos`
--

CREATE TABLE `egresos` (
  `id` bigint UNSIGNED NOT NULL,
  `cuenta_id` bigint UNSIGNED NOT NULL,
  `glosa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_factura` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `responsable` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodo_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `descuento` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id` bigint UNSIGNED NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `recepcion_id` bigint UNSIGNED DEFAULT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo` enum('MOTOR_ELECTRICO','MAQUINA_SOLDADORA','GENERADOR_DINAMO','OTROS') COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marca` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_serie` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `potencia` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `potencia_unidad` enum('Watts','kW','HP/CV') COLLATE utf8mb4_unicode_ci NOT NULL,
  `voltaje` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rpm` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hz` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amperaje` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cable_positivo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cable_negativo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kva_kw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `partes_faltantes` text COLLATE utf8mb4_unicode_ci,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `equipos`
--

INSERT INTO `equipos` (`id`, `cliente_id`, `recepcion_id`, `nombre`, `tipo`, `modelo`, `marca`, `color`, `numero_serie`, `potencia`, `potencia_unidad`, `voltaje`, `hp`, `rpm`, `hz`, `amperaje`, `cable_positivo`, `cable_negativo`, `kva_kw`, `partes_faltantes`, `observaciones`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Motor eléctrico', 'MOTOR_ELECTRICO', 'Acople', 'Sew - Eurodrive', 'Azul', NULL, NULL, 'Watts', '220', '1', '1680', '50', NULL, 'No', 'No', NULL, NULL, NULL, '2025-08-19 14:02:18', '2025-08-19 14:02:18', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos_equipos`
--

CREATE TABLE `fotos_equipos` (
  `id` bigint UNSIGNED NOT NULL,
  `equipo_id` bigint UNSIGNED NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `fotos_equipos`
--

INSERT INTO `fotos_equipos` (`id`, `equipo_id`, `ruta`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 1, 'equipos_fotos/equipo_1_1755612138_fM5NpdNz.jpg', 'Foto subida', '2025-08-19 14:02:19', '2025-08-19 14:02:19'),
(2, 1, 'equipos_fotos/equipo_1_1755612139_WDj7flk4.jpg', 'Foto subida', '2025-08-19 14:02:20', '2025-08-19 14:02:20'),
(3, 1, 'equipos_fotos/equipo_1_1755612140_vpn0BtXc.jpg', 'Foto subida', '2025-08-19 14:02:22', '2025-08-19 14:02:22'),
(4, 1, 'equipos_fotos/equipo_1_1755612142_BVsSnn6o.jpg', 'Foto subida', '2025-08-19 14:02:24', '2025-08-19 14:02:24'),
(5, 1, 'equipos_fotos/equipo_1_1755612144_Ku5Qva5R.jpg', 'Foto subida', '2025-08-19 14:02:25', '2025-08-19 14:02:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE `ingresos` (
  `id` bigint UNSIGNED NOT NULL,
  `tipo_ingreso` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `glosa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `razon_social` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_recibo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodo_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `descuento` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total` decimal(15,2) NOT NULL,
  `estado_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_19_164719_crear_tabla_clientes', 1),
(5, '2025_06_19_164936_crear_tabla_recepciones', 1),
(6, '2025_06_19_165004_crear_tabla_equipos', 1),
(7, '2025_06_19_165109_crear_tabla_fotos_equipos', 1),
(8, '2025_07_09_203624_crear_tabla_cotizaciones', 1),
(9, '2025_08_01_092748_crear_tabla_ingresos', 1),
(10, '2025_08_01_213809_crear_tabla_egresos', 1),
(11, '2025_08_05_094504_crear_tabla_sueldos', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nombre_cuentas`
--

CREATE TABLE `nombre_cuentas` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre_cuenta` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `nombre_cuentas`
--

INSERT INTO `nombre_cuentas` (`id`, `nombre_cuenta`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Banco bissa LP', 'Credito casa', '2025-08-22 19:25:03', '2025-08-22 19:25:03'),
(2, 'Alquiler', 'Alquiler taller y almacen', '2025-08-22 19:28:59', '2025-08-22 19:28:59'),
(3, 'Atencion medica externa', 'Hospital', '2025-08-22 19:30:01', '2025-08-22 19:30:01'),
(4, 'Aguinaldos', 'Aguinaldo', '2025-08-22 19:30:37', '2025-08-22 19:30:37'),
(5, 'Combustible y lubricantes', 'Gasolina, aceite y otros lubricantes', '2025-08-22 19:31:40', '2025-08-22 19:31:40'),
(6, 'Materia prima', 'Materiales que usamos pero es en general', '2025-08-22 19:32:27', '2025-08-22 19:32:27'),
(7, 'Materia prima alambre', 'Alambre', '2025-08-22 19:32:42', '2025-08-22 19:32:42'),
(8, 'Materia prima capacitor', 'Capacitores', '2025-08-22 19:32:58', '2025-08-22 19:32:58'),
(9, 'Materia prima rodamiento', 'Rodamientos en general', '2025-08-22 19:45:10', '2025-08-22 19:45:10'),
(10, 'Material de escritorio', 'Material de escritorio', '2025-08-22 19:45:52', '2025-08-22 19:45:52'),
(11, 'Material de limpieza', 'Material de limpieza', '2025-08-22 19:46:18', '2025-08-22 19:46:18'),
(12, 'Otros gastos', 'Gastos varios, torneria y otros', '2025-08-22 19:46:58', '2025-08-22 19:46:58'),
(13, 'Refrigerio y alimentacion', 'Almuerzo cena para el personal HC', '2025-08-22 19:47:33', '2025-08-22 19:47:33'),
(14, 'Sueldos y salarios', 'Sueldos', '2025-08-22 19:47:49', '2025-08-22 19:47:49'),
(15, 'Suministros agua', 'Agua', '2025-08-22 19:48:08', '2025-08-22 19:48:08'),
(16, 'Telefono', 'Carga de creditos', '2025-08-22 19:48:22', '2025-08-22 19:48:22'),
(17, 'Transporte', 'Pasaje y viaticos', '2025-08-22 19:49:52', '2025-08-22 19:49:52'),
(18, 'Uniformes', 'Uniformes', '2025-08-22 19:50:13', '2025-08-22 19:50:13'),
(19, 'Internet', 'Internet taller y galpon', '2025-08-22 19:50:29', '2025-08-22 19:50:29'),
(20, 'Servicios basicos', 'Agua y luz', '2025-08-22 19:50:45', '2025-08-22 19:50:45'),
(21, 'Donaciones', 'Donaciones', '2025-08-22 19:50:58', '2025-08-22 19:50:58'),
(22, 'Mantenimiento vehiculo', 'Mantenimiento vehiculo', '2025-08-22 19:51:19', '2025-08-22 19:51:19'),
(23, 'Gastos no deducibles', 'Gastos no relacione con el taller', '2025-08-22 19:51:44', '2025-08-22 19:51:44'),
(24, 'Servicios externos', 'Servicios que se realiza fuera del taller', '2025-08-22 19:52:09', '2025-08-22 19:52:09'),
(25, 'Herramientas', 'Herramientas', '2025-08-22 19:52:21', '2025-08-22 19:52:21'),
(26, 'Beneficios sociales', 'Beneficios sociales', '2025-08-22 19:52:39', '2025-08-22 19:52:39'),
(27, 'IUE', 'IUE', '2025-08-22 19:52:48', '2025-08-22 19:52:48'),
(28, 'Impuestos', 'Iva e it y otros', '2025-08-22 19:53:08', '2025-08-22 19:53:08'),
(29, 'Provision aguinaldos', 'Provision aguinaldos', '2025-08-22 19:53:25', '2025-08-22 19:53:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepciones`
--

CREATE TABLE `recepciones` (
  `id` bigint UNSIGNED NOT NULL,
  `numero_recepcion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cliente_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_ingreso` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hora_ingreso` time NOT NULL,
  `estado` enum('RECIBIDO','DIAGNOSTICADO','EN_REPARACION','REPARADO','ENTREGADO') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'RECIBIDO',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `recepciones`
--

INSERT INTO `recepciones` (`id`, `numero_recepcion`, `cliente_id`, `user_id`, `fecha_ingreso`, `hora_ingreso`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'REC-005512', 1, 4, '2025-08-19 00:00:00', '09:54:00', 'DIAGNOSTICADO', '2025-08-19 14:02:18', '2025-08-19 14:13:57', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3gYuwonxVVwmbF2fQdFvI4Ws4qr8pnywsdEssV6w', NULL, '192.223.122.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiTElVT01pUmJZRTlyTDBzWlN2b091QTA1azRnUVhhWW1hVnVQUUliWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756416761),
('4yOUS8i7F1jIpLzeqGeG9E5t1dUpKQGSstjxIl58', NULL, '44.193.254.10', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 Edg/134.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT05hWFdqOVpWSklOYTlRT3NUekM0d2dOMWNSZmdxODRlbWRmQTd4MiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3Lmhjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756468459),
('5fO1SqkXvsKhJUBN5P0voOBFO78gO4oSV3JwIw6k', NULL, '2a06:98c0:3600::103', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnRybDNtb0U1OFRZbXBpQ2VJTUhwRHptbmV4Sm1LdzVUWnhiVVFnYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756837662),
('6rWByDn4bRMQmvIil9cZe22uh9SXGthXx7T7T0A8', NULL, '52.39.155.218', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZktqbVNlZHhKaXVpRVlnOFJUVTQyMnpxdXE5RkpqQWU2cmZLaFIyViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756648665),
('6uSjPrRs3zY4UyGOiRlkXwSkS3Pj43I9ffedk5IO', NULL, '167.94.146.54', 'Mozilla/5.0 (compatible; CensysInspect/1.1; +https://about.censys.io/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibjAzeE9sWGNUYnVGY3MwbXlnbnljQUxqQXZvWnpPMTExV0hxUWVaZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756748285),
('7Ge9Engvqr328Bd8Vqa3nQ7p0NINwbtbUdY2lXCT', NULL, '44.250.224.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUM3NXBpbW9raFJJZ3EzU1I0bkIwM0Z3QU1HeFJQa3RCd2puMWlGOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756558493),
('7h5xLQwLwnl1JzKWIyJOGuwxBIYH5moRxTYsjwOC', NULL, '198.98.50.128', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.90 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ3RDeWhwNUdsczU2RHN6VEZPdGRsVm41TzVxOHFSbm9tUTdhOTV0diI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756679712),
('7msvJs0YpGJ9VOFYNixHVnkGVUJrnSpLv8EiVxm8', NULL, '138.68.160.201', 'Mozilla/5.0 (X11; Linux x86_64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUmJScWZSMjhscmdSSGs4VEpDaVNJbEs0M0RLRFRvMWVaVWFGY01WaiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHBzOi8vbWFpbC5oY3NlcnZpY2lvaW5kdXN0cmlhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756820310),
('8WkOStgypsIYy6VPw5tEXUaY0RREI8QSPvFaJY0q', NULL, '177.222.99.27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWNpTmJlUVBmb2FQSkhNUGV4bjV1aXZSNnNoRDFHYTAzaTVJdkhiciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756739451),
('9HSTDsOqkNtCgb6kNDmlVCo5qRCmzVNwex0F7P7q', NULL, '177.222.99.14', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicEtwcGlETFdBM1I1aE5jTTdCZk1ZRTVWUGVyY0dKcVBvSHBwNjBkZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1757000289),
('b0T0OjeQdCImg7jggtKj7jZCALIymUXU24bS0CVo', NULL, '148.113.202.94', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOGFoUldrcVByWUtxMHEyc3dnZ2oyQnNuellxSVNoZGZrb2I4d21rTyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756283646),
('bhmTRtEl3fPVFFemjHCtRhmAzDFOfNdWUw5vHIhG', NULL, '109.172.93.45', 'Mozilla/5.0 (X11; Linux x86_64) Chrome/19.0.1084.9 Safari/536.5', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOTVkU1NOSFNITTd1MloxN1hWeUpOd0hRaDhnNnpIUjBJV3N5S3JzNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756912805),
('BhS91yjT8BkfWfQL0B2z8XC7hQsFRnDZALuwIXrY', NULL, '138.68.164.73', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWG9YMmNCTDVBZkRiblljTG13Y3lFYXBYQlJFV2ZKeXlSWHNQNW42ZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756627084),
('CcIGVRbdEnzf3pg5gH3gW0vdnsw8eAiJyQHJHFSS', NULL, '162.120.186.120', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoidXZlbWJXcEVFcWwwd2hwcFhUSDdqc2haY3dCT1BjMkpHdjdRVDhlMyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756838944),
('cQZlyG8MVtnhVokHxRqqfObC6cAILloZpaFgEGWN', NULL, '52.39.155.218', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamMzYWVKTExjTUhGWEhoOVpBWjJTZWNrN2Q2a2dMUjFqWnA5ZzBSeiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756648666),
('CVIcor4mJv2kYpJM99aJRqb0Uo5fAMGIFIJ1fe1t', NULL, '54.190.94.132', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3lBVlBqdGtUMk9Sa1JreGJLU1ZWZDc1Ym43ZkVRQXlZRGRHcmxHYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756815045),
('dNGFjlKgQPOiTmv9vcY2eaMAOygMT8C38zU2YfZ3', NULL, '181.115.215.20', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWlQZmlid1lqaEV3TWMzb21qSksyb2dOQUp2dDFOc0c2WHZEVzdNeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9fQ==', 1756340219),
('g1XtaRq4Egmgyx8NUvs8FNO3JGQ7dGvEFPPBAuAB', NULL, '104.248.0.54', 'Mozilla/5.0 (X11; Linux x86_64; rv:139.0) Gecko/20100101 Firefox/139.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQmRvYmt5a0hRWnQwS1dVMjBhaTFTbG9MWFFwR1dvZHU2SzlLRHhnTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756277515),
('hkz1RGFcjmiFvGOkC42Al7N6rpE7j2vyXMczFvWv', NULL, '34.141.215.20', 'Scrapy/2.12.0 (+https://scrapy.org)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVU13VnlxMHlETFZ4ZGR4MUk0RU5QSng1OVVQNU1YYmdPWjNXOWNVNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756953763),
('HvapPDghoNnowhE6rkg3FMyewVNXaXqR4YUB2tFr', NULL, '177.222.98.129', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidW1VTnZ6dHhzdk11ODFiRUlxREZnanI2d1BROG5Yd1lZOXhheXlnayI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756405559),
('Hz7fQusw196fj8KhIPUpUB9RoTHjjFCzxBWgvl1g', NULL, '54.198.208.251', 'Mozilla/5.0 (X11; Linux i686; rv:28.0) Gecko/20100101 Firefox/28.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2xneHBPTnN3Y0VpeVZlcDRqT2ptV3FJR2p5dUY4WVJXUUpjQlk4MyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756908983),
('Ibg7lqKC0xLRpOY7o6lbNkdV520PQoWd3a6u7jru', NULL, '34.6.36.27', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoienkwT1g2MVJxSUxFQ25ldTdINnZrNEVEWHpmMlBuS0x6UzhOTDNmSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756938969),
('IPQxX7SN9HZ632WYY0nQyGwXsrTrcGL4yv2uxFjj', NULL, '34.133.193.78', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicmYzMjN3NXF0ZVFhQUFiVmMwcVNId0U4UFY4c2RlaXlDR3QwZ1didyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756506297),
('iuEIAoGswem9F7bVoFLJThZlWeJskH4iN76OB1Ob', NULL, '44.250.224.173', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidExnQjZOMWpBaVNxdjZqNXBMNXA5VVVVUzJQY3dkRjVJS05lQnV4YyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756558494),
('J1dwDW2miYZnM8ebvBjBP8mtHS7oIOJwcyVFRvP3', NULL, '54.201.209.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoid3pPTlhJc2JUOW9yc3dmeGpaQThoZzRsSkVmR2NvYXcwVkpoWUdnMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756467342),
('jd5GSN1UJnF8hnBxIlBjkSByyZpA6VFXTmIwNrzL', NULL, '181.115.215.85', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2tKeEt1dElLbkZ3U0MxaFYwWktpSVJ0bFBvRWJLd0l3d1Q0RlNHZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756839260),
('JQ29hfryBcV1voSuMtFsIpxQsZp6kocRse6NPvIX', NULL, '200.87.246.132', 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.6 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicjNERXQzVjAyS2NxS1V3cm5vU0l0aGF3eTViWG8wbGJMS05LVHZsVSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NToiaHR0cHM6Ly9oY3NlcnZpY2lvaW5kdXN0cmlhbC5jb20vY290aXphY2lvbmVzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756234283),
('jXbenOy3cu6OyeSgZIyseAVJdr1xYB3n9IZGSziB', NULL, '34.21.35.100', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGpBbUlsaXRBdW1vdmZpcm1wb2JuSkhxNFIyR1d2SmZpMzNXMmdPYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756246976),
('kmJYZiCNpf7XoWG055vyzzckaZP641HcHBhsyYrt', NULL, '185.130.227.201', 'Mozilla/5.0 (Linux; Android 10; Redmi Note 7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.101 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWk5kdFF1bkpDZjhvejFNWk1KWGpCWXoyblJ5WnB4bVF2QlZRRnZlViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756454546),
('kv8nGoc3qf9TKmVjURhTHwvkemmwyiELaTjCzhYe', NULL, '200.87.246.139', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_1_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.1.1 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidlRCNGVabWtUVW5PQ2pSVzdibmd1cWRBY21BaERtUVhNcUcxbmxUdCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cHM6Ly9oY3NlcnZpY2lvaW5kdXN0cmlhbC5jb20vcmVjZXBjaW9uZXMvMSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjMyOiJodHRwczovL2hjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756234193),
('LFDo7uUA0va4XjIvaBuqvkqXla6eZLQqxKZtDsrl', NULL, '35.237.130.127', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWVpiTkNuRWVldzJLZnhXaDNScFhLR2ZjZHpoekhIVHBYVldveVJWTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756850730),
('lHH3MyzaxQ0mb0NwdasexFxgcrGcPoA9ePZ4xo8Q', NULL, '209.38.36.21', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlc0NUtlaktMVjlhVFliMGdFVlFMVEEyUFJNZDVjSWNoRDk2SGluTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3Lmhjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756891509),
('MARszrEzfksjCvimK6iWq95HdeOW1NyVGKNlOBAM', NULL, '54.147.55.217', 'okhttp/4.9.2', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTGJsSjJINTF2TWpLMnNYRmRzdkdYTTltaXpNUXNjY3dhS3ZwdFZWWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756933744),
('Mk3HtwP19ESYt6UeQiWihTPlXh4OgHmg4vKkr9Hu', NULL, '66.249.73.98', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.7204.183 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNGZ1THJnMW5xYnRQVWpNV1VGVWRGR25FdWpXeVBNNktvQlZBRVo1byI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3Lmhjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756583365),
('MoELqnnePud0CJ4nb7WcuMoW4rfHcfDDjSi60MZt', NULL, '23.27.145.82', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNk1YcG5MZFFLQ2VubEFTelpiZDVQT21kUE9UNUhFN2FDcHJHZzYxYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756943086),
('NofUnNu0lAX18KXQloA10JDfdHKjdTkCPrpeWhfa', NULL, '174.138.12.106', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRzZzS1dobFhQUDhzNmVtdWg1V2x2VGtONTdISklrdk5EanJ6SWs5QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756455058),
('NWlDv3hR8FUtRXzbSq3ijKJZxdIg3HW8MjDecuv1', NULL, '37.59.22.99', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/123.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZHFrdzlndU5BSzdkSmV5YlRGcjZ2SkR3bW5KZWpnTEhZeTZzRzNieiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756693802),
('nzalEOO0p6tnpHqHdlYJHMGdB0VE0xMV86kzxjjU', NULL, '181.115.215.85', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmpFQUxvZGNldUhNTkg2aTZya0lISUtYMTVFVGFRcTVwZkFoaTVIQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9fQ==', 1756908156),
('o0XIzfMlqgngoTGGA5CgbhbGLU7w138r3KPx7Zhi', NULL, '34.217.68.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY1pDMVJPSTlpUzQ5ZU5hUERVN0VUWGJuSFZkZW15NnhpOUpNQ0xlbCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756729604),
('ooWHkLHxeLEp7MKUOqsEzcOy5gllBdxN5c2IZn64', NULL, '35.202.78.26', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQUVCcWhVdGNZRjNENnd3dmFaMWV5NnJvQ2tlNFhNV1ZMenY5d1g0UCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756678481),
('pJC9cwWs1cGH43M2QmgUMeHJfBvFYjoIXEJ6U24z', NULL, '181.115.215.85', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYnRPZ1J5c0N5bWJFNHNhTVhkY3p4THBvSWo3dGpNNXVUczYzUmpVUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3Lmhjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756837089),
('PyCBYZKEs3fqs0ps5511mfrI3prgtpwOof7QrI9p', NULL, '186.175.49.186', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT0pBd1NGSzg2M2g0SEIwN21CT2dVSFBUY3lhUnplMUtySEh5UGZUTiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3Lmhjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756485149),
('Q24kDRL1NDQxKvClFdP8xfrwt4goru7sIvfMYGYg', NULL, '49.12.147.139', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1c5c1hDRnRsQ3dHeWViWXFNOFpub0ZtZUVESEo1TGpLb3VKTm9HRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756724851),
('QnSsEwhePpkceyaHQiUX8dmZU3TFhRNCjCzWDORp', NULL, '134.209.174.108', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidmJCekZvaGRvWXU2U0U2MzFCTnI4YnEycWRLOWJHeXNLcmIyZWdoaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756968125),
('QOEyz5PqBbFwEP2SfiswSE9f533gYBVtvqNCRQVV', NULL, '35.231.54.31', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTXNwQTMyNzc0bVg3aU03Mkh5SGR5UGpwd3dzNEJWdGs4MmJ6UWpKUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756332896),
('rDpSaQE7TsfIitMJNDpfdj6HrjCx9yGZOuGVxVgR', NULL, '18.237.165.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaWlMQkFiS09iRjNiQnJmclpkSUl6Vm9tYkY3TUI1WGRKSzhyV3dhNiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756291588),
('RdSKHGrnFC00uLbxm3uY3gkjrC9cPqJMJq07Qn7Y', NULL, '18.237.165.77', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY0h0TEtld0VxekZFSGNZSTZldjdaaGhackJDSU9nRFUwNjJITlZyWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756291590),
('smXO3J1JV3pgfWYSi9HmTQuYK8bDzOmXvaIswdCl', NULL, '66.249.73.98', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.7204.183 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic2V4Y3RTclBoOFU2RkZoa2ZxeExsd3V5czRjcFRHRGNLakxqMzdFQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3Lmhjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756556413),
('spYnzEjRa1XNjs5sdZyqBc8jgVtBZyB8ePskEF8R', NULL, '66.249.73.99', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.7204.183 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1dWN0VWbWxrdUZsTUdVVlFHdlJXQ2sxbkdCWnEyWHI5a2FET0Z1RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vd3d3Lmhjc2VydmljaW9pbmR1c3RyaWFsLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1756410509),
('SvqyG1LFwDBqaxoXfN8rBTFIczsvqmwfPetYXU8w', NULL, '193.186.4.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiVU53enRYWVVMMDIzbnhZSnJFeU84OVczcXpGTnpuekFSaWZCTEg5eCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756836991),
('SWb4al8y2FkCHiSjk5pFMUZJO4lwcglEQkF7d3es', NULL, '192.223.122.211', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlBOVTlOc2xMQkhpYW1UVlNiSUF0UGJiQmRTWnZyOFo3RjJiTFkxeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756988695),
('TDcr0VmfLvzIXhycWbWDbx8TlLmti5x4jRhP5cwa', NULL, '66.249.73.64', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.7204.183 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0xERXdVNjNKSXBLemlQM2dCdHVvb2IxTVRtVDRIQWprQjRWZGF6TCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756517295),
('tR2cklUe6t9fIm79ehwpzENDqvz2Cqkr7yrz1ELi', NULL, '185.130.227.201', 'Mozilla/5.0 (Linux; Android 9; SM-J530FM) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.101 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidWV2cVR3UmlyNkJsaTZhS1pndXVKMncyVEFSdk1GemtUckhuRzROZSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756279844),
('TTdMznt7RJ0o8NjcazRUIBwhJS8WcyzMgfOmCZhz', NULL, '54.190.94.132', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWlBxRG94QXhHWEpLWjdXMTdhZDNvVkNQR0lRV1ZReTlKOHZmeEhEQiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756815044),
('uEym7w6fApT646cXU6VTeiIaIilN7HQ9q1UkOvlu', NULL, '185.130.227.201', 'Mozilla/5.0 (iPhone; CPU iPhone OS 13_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.1.1 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib2hacmpkeFRjZVllMWZqR1h5WWhvcGtmMUN4MFZBQTBrYW9lWUxVcSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756530419),
('uuToEQOGTsDa2DIHjgm4jzsfMj5QKDNs6eO2aJ95', NULL, '34.11.184.102', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRkpHZHd0NGhzQXNZOU9CMWlVSEJFaFpWaW0xaUJ4U214Z2hCU3dxUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756413555),
('uXETzR6EVwPX3JS8NY2McBBHKyzhx7yjgUkb186w', NULL, '192.254.250.165', 'Mozilla/5.0 (Windows NT 11.0; Win64; x64; rv:126.0) Gecko/20100101 Firefox/126.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNHA4YkZiTlp6dm14NEFQS3BSNndHdVhBTnJlbmY1c0NaMk5lbFVjUSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756415114),
('UxMev6SkKs9lKej7YWzG2ILHvpobCJvQRhNSSjh4', NULL, '189.28.74.56', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNlBETlRrWEhTSUZEUWNXSDJiUDJLMlVmM3dtdTE3aUQ4a2ZMc2pScSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MToiaHR0cHM6Ly9oY3NlcnZpY2lvaW5kdXN0cmlhbC5jb20vdXN1YXJpb3MiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czozMjoiaHR0cHM6Ly9oY3NlcnZpY2lvaW5kdXN0cmlhbC5jb20iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1756473789),
('XBCVS7hTQ8Fbhm84iDZ53j37AAjxHFodQXRc4dC4', NULL, '192.36.136.8', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:109.0) Gecko/20100101 Firefox/115', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicGlzQU94ZHdlWUdaeDVPZU1TcjlWejQ5NDZpakk4ZThlYjBFTFhxYiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756724713),
('xcBDqKCiCvHn1pdSuyIeYnehdI1x8SRdZXZ2d9Ga', NULL, '128.90.128.9', 'Go-http-client/1.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN3ZEMHBhNWdsRmlxQnBPejM1cEN3ZTBHdGJYYmlkeUZWNndWbW1pbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756285111),
('XfFYjZMGCszcCs9KOn1FobJib2grTpb7iqCdINju', NULL, '54.201.209.214', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoienVQYkRzSWJnR2xrdFRUcjdzTHpFWjZGSVVYN0RwaFExU1plcHZEMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756467341),
('XGgWNF92a2MKtbapzKIyf6e23D6GYdvIMO5EmpUF', NULL, '172.111.197.3', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/109.0.5414.46 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNURhWVNVZlVndUtWOW0xVW5FOXBaYXFOWWRyMUJYdUtkN2lnTWVtZyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756472823),
('yW5cMKeP4cEPB7SIsr6fDmz6V6TypDUrnzQmq3bv', NULL, '34.217.68.46', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVlMwSzlUZzJKMUZscVI2Y3JXa2RxcWppV0RyZkZMc3BjcDkxbkpGbyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756729603),
('zaz8D2Vm8Vr6x05ydVj0eF0MW8GmKTS3hpsYdxCk', NULL, '54.147.55.217', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/138.0.7204.23 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiem82Sm1RUjJWV2E3RmUwNkFIcm1Nc0txc1UyTlJJMkpRSDhQT2JGYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzI6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1756933760),
('ZcwfSZ3jUkzRM09wiMX4qsbQa4S4UiUm9mCMofof', 3, '181.41.157.41', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_6_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/139.0.7258.76 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiN01TbEVXVVllcXVnRjFpZEl5Nmk3cHlzWlFHOUxOS0l1WEVMOUt2bSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHBzOi8vaGNzZXJ2aWNpb2luZHVzdHJpYWwuY29tL3VzdWFyaW9zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1756234296);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sueldos`
--

CREATE TABLE `sueldos` (
  `id` bigint UNSIGNED NOT NULL,
  `trabajador_id` bigint UNSIGNED NOT NULL,
  `mes_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salario` decimal(10,2) NOT NULL,
  `descuento` decimal(10,2) NOT NULL DEFAULT '0.00',
  `horas_extras` decimal(10,2) NOT NULL DEFAULT '0.00',
  `anticipo` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_liquido` decimal(10,2) NOT NULL,
  `fecha_pago` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trabajadores`
--

CREATE TABLE `trabajadores` (
  `id` bigint UNSIGNED NOT NULL,
  `nombres` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `rol` enum('Gerente','Contabilidad','Supervisor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Supervisor',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `nombre`, `email`, `email_verified_at`, `rol`, `activo`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Tito Herbas', 'titoherbas@hcservicioindustrial.com', NULL, 'Gerente', 1, '$2y$12$4HH70Th74AA5FJwaBuaScum7dxvf4tr6MGCVTGI6w.jSrxilr2d4C', NULL, '2025-08-11 15:02:28', '2025-08-26 18:16:22'),
(4, 'Augusto Velasquez', 'augustovelasquez@hcservicioindustrial.com', NULL, 'Contabilidad', 1, '$2y$12$qQNcf34LI0GQTT0KMcx/KONHlh3Qy5qRkzbbHxhvVMeZB3zQ745ZC', NULL, '2025-08-11 15:03:10', '2025-08-26 18:17:25'),
(5, 'Jose Ito', 'joseito@hcservicioindustrial.com', NULL, 'Supervisor', 1, '$2y$12$uJSWSP4/6Tiyenqm56rDp.v7PSTXtyQ9QwoV4UKCeSYS1apdXdXx2', NULL, '2025-08-11 15:03:59', '2025-08-26 18:17:58');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `clientes_numero_documento_unique` (`numero_documento`);

--
-- Indices de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizaciones_recepcion_id_foreign` (`recepcion_id`);

--
-- Indices de la tabla `cotizacion_equipos`
--
ALTER TABLE `cotizacion_equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_equipos_cotizacion_id_foreign` (`cotizacion_id`),
  ADD KEY `cotizacion_equipos_equipo_id_foreign` (`equipo_id`);

--
-- Indices de la tabla `cotizacion_equipo_fotos`
--
ALTER TABLE `cotizacion_equipo_fotos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cot_eq_foto_unique` (`cotizacion_equipo_id`,`fotos_equipos_id`),
  ADD KEY `cotizacion_equipo_fotos_fotos_equipos_id_foreign` (`fotos_equipos_id`);

--
-- Indices de la tabla `cotizacion_repuestos`
--
ALTER TABLE `cotizacion_repuestos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_repuestos_cotizacion_equipo_id_foreign` (`cotizacion_equipo_id`);

--
-- Indices de la tabla `cotizacion_servicios`
--
ALTER TABLE `cotizacion_servicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cotizacion_servicios_cotizacion_equipo_id_foreign` (`cotizacion_equipo_id`);

--
-- Indices de la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `egresos_cuenta_id_foreign` (`cuenta_id`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipos_cliente_id_foreign` (`cliente_id`),
  ADD KEY `equipos_recepcion_id_foreign` (`recepcion_id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `fotos_equipos`
--
ALTER TABLE `fotos_equipos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fotos_equipos_equipo_id_foreign` (`equipo_id`);

--
-- Indices de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indices de la tabla `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nombre_cuentas`
--
ALTER TABLE `nombre_cuentas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `recepciones`
--
ALTER TABLE `recepciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recepciones_cliente_id_foreign` (`cliente_id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indices de la tabla `sueldos`
--
ALTER TABLE `sueldos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sueldos_trabajador_id_foreign` (`trabajador_id`);

--
-- Indices de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cotizacion_equipos`
--
ALTER TABLE `cotizacion_equipos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cotizacion_equipo_fotos`
--
ALTER TABLE `cotizacion_equipo_fotos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cotizacion_repuestos`
--
ALTER TABLE `cotizacion_repuestos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `cotizacion_servicios`
--
ALTER TABLE `cotizacion_servicios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `egresos`
--
ALTER TABLE `egresos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `equipos`
--
ALTER TABLE `equipos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fotos_equipos`
--
ALTER TABLE `fotos_equipos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `ingresos`
--
ALTER TABLE `ingresos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `nombre_cuentas`
--
ALTER TABLE `nombre_cuentas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `recepciones`
--
ALTER TABLE `recepciones`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `sueldos`
--
ALTER TABLE `sueldos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `trabajadores`
--
ALTER TABLE `trabajadores`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cotizaciones`
--
ALTER TABLE `cotizaciones`
  ADD CONSTRAINT `cotizaciones_recepcion_id_foreign` FOREIGN KEY (`recepcion_id`) REFERENCES `recepciones` (`id`);

--
-- Filtros para la tabla `cotizacion_equipos`
--
ALTER TABLE `cotizacion_equipos`
  ADD CONSTRAINT `cotizacion_equipos_cotizacion_id_foreign` FOREIGN KEY (`cotizacion_id`) REFERENCES `cotizaciones` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotizacion_equipos_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`);

--
-- Filtros para la tabla `cotizacion_equipo_fotos`
--
ALTER TABLE `cotizacion_equipo_fotos`
  ADD CONSTRAINT `cotizacion_equipo_fotos_cotizacion_equipo_id_foreign` FOREIGN KEY (`cotizacion_equipo_id`) REFERENCES `cotizacion_equipos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cotizacion_equipo_fotos_fotos_equipos_id_foreign` FOREIGN KEY (`fotos_equipos_id`) REFERENCES `fotos_equipos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizacion_repuestos`
--
ALTER TABLE `cotizacion_repuestos`
  ADD CONSTRAINT `cotizacion_repuestos_cotizacion_equipo_id_foreign` FOREIGN KEY (`cotizacion_equipo_id`) REFERENCES `cotizacion_equipos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `cotizacion_servicios`
--
ALTER TABLE `cotizacion_servicios`
  ADD CONSTRAINT `cotizacion_servicios_cotizacion_equipo_id_foreign` FOREIGN KEY (`cotizacion_equipo_id`) REFERENCES `cotizacion_equipos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `egresos`
--
ALTER TABLE `egresos`
  ADD CONSTRAINT `egresos_cuenta_id_foreign` FOREIGN KEY (`cuenta_id`) REFERENCES `nombre_cuentas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `equipos_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `equipos_recepcion_id_foreign` FOREIGN KEY (`recepcion_id`) REFERENCES `recepciones` (`id`);

--
-- Filtros para la tabla `fotos_equipos`
--
ALTER TABLE `fotos_equipos`
  ADD CONSTRAINT `fotos_equipos_equipo_id_foreign` FOREIGN KEY (`equipo_id`) REFERENCES `equipos` (`id`);

--
-- Filtros para la tabla `recepciones`
--
ALTER TABLE `recepciones`
  ADD CONSTRAINT `recepciones_cliente_id_foreign` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);

--
-- Filtros para la tabla `sueldos`
--
ALTER TABLE `sueldos`
  ADD CONSTRAINT `sueldos_trabajador_id_foreign` FOREIGN KEY (`trabajador_id`) REFERENCES `trabajadores` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
