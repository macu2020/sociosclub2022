-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2021 a las 22:12:45
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `socio`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `inserta` (IN `name` VARCHAR(255), IN `lastname` VARCHAR(255), IN `dni` VARCHAR(8), IN `perfil_id` BIGINT(20), IN `parentesco_id` BIGINT(20), IN `clase_id` BIGINT(20), IN `email` VARCHAR(255), IN `avatar` VARCHAR(255), IN `placa` VARCHAR(7))  BEGIN 
    declare siguiente_codigo int;
    DECLARE macuri varchar(255);
    set siguiente_codigo = (Select ifnull(max(convert(substring(clave, 5), signed integer)), 0) from socios) + 1;
    set macuri = concat('SOC-', LPAD( siguiente_codigo, 3, '0'));
    
    INSERT INTO  socios(name,lastname,dni,perfil_id,parentesco_id,clase_id,email,avatar,clave,placa)
	VALUES  (name,lastname,dni,perfil_id,parentesco_id,clase_id,email,avatar,macuri,placa);
SELECT LAST_INSERT_ID(),name,macuri,dni;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `insertsociodia` (IN `idsoci` VARCHAR(255), IN `clave` VARCHAR(255), IN `name` VARCHAR(255), IN `lastname` VARCHAR(255), IN `dni` INT, IN `perfil_id` BIGINT(20), IN `parentesco_id` BIGINT(20), IN `clase_id` BIGINT(20), IN `email` VARCHAR(255), IN `estado` INT, IN `avatar` VARCHAR(255), IN `horas` VARCHAR(255), IN `dia` VARCHAR(255))  BEGIN 
    
    INSERT INTO  reporte_soci_dias(idsoci,clave,name,lastname,dni,perfil_id,parentesco_id,clase_id,email,estado,avatar,horas,dia)
	VALUES  (idsoci,clave,name,lastname,dni,perfil_id,parentesco_id,clase_id,email,estado,avatar,horas,dia);

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clases`
--

CREATE TABLE `clases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clase` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clases`
--

INSERT INTO `clases` (`id`, `clase`, `created_at`, `updated_at`) VALUES
(1, 'Adulto', NULL, NULL),
(2, 'Niño', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `invitados`
--

CREATE TABLE `invitados` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `socio_id` bigint(20) UNSIGNED NOT NULL,
  `clase_id` bigint(20) UNSIGNED NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `horas` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Disparadores `invitados`
--
DELIMITER $$
CREATE TRIGGER `triggerinvitado` AFTER INSERT ON `invitados` FOR EACH ROW BEGIN   
	INSERT INTO reporte_invi_dias(idinvi,clave,name,lastname, dni,horas,dia,socio_id,clase_id,estado) 
	VALUES (new.id, 
        (SELECT socios.clave FROM socios INNER JOIN invitados on socios.id = invitados.socio_id WHERE invitados.id = new.id) 
         ,
         new.name,new.lastname, new.dni,CURTIME(), CURDATE(),new.socio_id,
          new.clase_id, new.estado );  
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(88, '2014_10_12_000000_create_users_table', 1),
(89, '2014_10_12_100000_create_password_resets_table', 1),
(90, '2019_08_19_000000_create_failed_jobs_table', 1),
(91, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(92, '2021_11_22_210930_create_clases_table', 1),
(93, '2021_11_22_211055_create_perfils_table', 1),
(94, '2021_11_22_211153_create_parentescos_table', 1),
(95, '2021_11_22_211417_create_socios_table', 1),
(96, '2021_11_22_212336_create_invitados_table', 1),
(97, '2021_11_25_200532_create_roles_table', 1),
(98, '2021_11_30_170326_add_column_horassoci', 1),
(99, '2021_11_30_211347_add_colum_horinvi', 1),
(100, '2021_11_30_222706_create_reporte_soci_dias_table', 1),
(101, '2021_12_01_043516_create_reporte_invi_dias_table', 1),
(102, '2021_12_10_013538_add_column_placasocio', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parentescos`
--

CREATE TABLE `parentescos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo_parentesco` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `parentescos`
--

INSERT INTO `parentescos` (`id`, `tipo_parentesco`, `created_at`, `updated_at`) VALUES
(1, 'Papa', NULL, NULL),
(2, 'Mama', NULL, NULL),
(3, 'Hijo', NULL, NULL),
(4, 'Primo', NULL, NULL),
(5, 'Otros', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfils`
--

CREATE TABLE `perfils` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `perfils`
--

INSERT INTO `perfils` (`id`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Titular', NULL, NULL),
(2, 'Conyuge', NULL, NULL),
(3, 'Familiar', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_invi_dias`
--

CREATE TABLE `reporte_invi_dias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idinvi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `horas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `dia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `socio_id` bigint(20) UNSIGNED NOT NULL,
  `clase_id` bigint(20) UNSIGNED NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reporte_invi_dias`
--

INSERT INTO `reporte_invi_dias` (`id`, `idinvi`, `clave`, `name`, `lastname`, `dni`, `horas`, `dia`, `socio_id`, `clase_id`, `estado`, `created_at`, `updated_at`) VALUES
(1, '1', 'SOC-002', 'jorge', 'macuri', '12345678', '02:40:35', '2021-12-10', 2, 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reporte_soci_dias`
--

CREATE TABLE `reporte_soci_dias` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `idsoci` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil_id` bigint(20) UNSIGNED NOT NULL,
  `parentesco_id` bigint(20) UNSIGNED NOT NULL,
  `clase_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `horas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `dia` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `reporte_soci_dias`
--

INSERT INTO `reporte_soci_dias` (`id`, `idsoci`, `clave`, `name`, `lastname`, `dni`, `perfil_id`, `parentesco_id`, `clase_id`, `email`, `estado`, `avatar`, `horas`, `dia`, `created_at`, `updated_at`) VALUES
(1, '1', 'SOC-001', 'jorge', 'macuri', '44786190', 1, 1, 1, 'macuri516@gmail.com', 1, NULL, '02:40:20', '2021-12-10', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `tipo`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', NULL, NULL),
(2, 'Inspector', NULL, NULL),
(3, 'Recepcionista', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `socios`
--

CREATE TABLE `socios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `clave` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dni` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil_id` bigint(20) UNSIGNED NOT NULL,
  `parentesco_id` bigint(20) UNSIGNED NOT NULL,
  `clase_id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `horas` int(11) NOT NULL DEFAULT 0,
  `placa` varchar(7) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `socios`
--

INSERT INTO `socios` (`id`, `clave`, `name`, `lastname`, `dni`, `perfil_id`, `parentesco_id`, `clase_id`, `email`, `estado`, `avatar`, `created_at`, `updated_at`, `horas`, `placa`) VALUES
(1, 'SOC-001', 'jorge', 'macuri', '44786190', 1, 1, 1, 'macuri516@gmail.com', 1, NULL, '2021-12-10 07:40:20', '2021-12-10 07:40:20', 2, 'asd-125'),
(2, 'SOC-002', 'jorge', 'macuri', '10455625', 1, 1, 1, 'tortamacuri123@gmail.com', 1, '646_wl9me5yn-400x400.jpg', '2021-12-10 07:40:28', '2021-12-10 07:40:28', 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perfil` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 0,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `lastname`, `perfil`, `email`, `email_verified_at`, `password`, `estado`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'jorge', 'macuri', '1', 'macuri516@gmail.com', NULL, '$2y$10$ogEIoXC3WGn//Zw7pAvIp.DhmcF2AbKi8GJa7roWuoR5HpH6dA9Ga', 0, NULL, NULL, '2021-12-10 06:50:16', '2021-12-10 06:50:16'),
(2, 1, 'jorge', 'macuri', '3', 'fio@gmail.com', NULL, '$2y$10$aafMn4XSP.yV6ei8tkI2R.0y5AJR/EuQtw4P20Xt03HI3uaz6Md8W', 0, '882_esposa2.JPG', NULL, '2021-12-10 07:49:27', '2021-12-10 07:49:27'),
(3, 1, 'jorge', 'macuri', '2', 'maton@gmail.com', NULL, '$2y$10$/zw882QSLN9G7O1.uyEbsO2FuGNFFfZRrAzY28CChYIK1Pf.Basqi', 0, NULL, NULL, '2021-12-10 12:43:47', '2021-12-10 12:43:47');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clases`
--
ALTER TABLE `clases`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indices de la tabla `invitados`
--
ALTER TABLE `invitados`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invitados_dni_unique` (`dni`),
  ADD KEY `invitados_socio_id_foreign` (`socio_id`),
  ADD KEY `invitados_clase_id_foreign` (`clase_id`);

--
-- Indices de la tabla `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parentescos`
--
ALTER TABLE `parentescos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indices de la tabla `perfils`
--
ALTER TABLE `perfils`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indices de la tabla `reporte_invi_dias`
--
ALTER TABLE `reporte_invi_dias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reporte_invi_dias_socio_id_foreign` (`socio_id`),
  ADD KEY `reporte_invi_dias_clase_id_foreign` (`clase_id`);

--
-- Indices de la tabla `reporte_soci_dias`
--
ALTER TABLE `reporte_soci_dias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reporte_soci_dias_perfil_id_foreign` (`perfil_id`),
  ADD KEY `reporte_soci_dias_parentesco_id_foreign` (`parentesco_id`),
  ADD KEY `reporte_soci_dias_clase_id_foreign` (`clase_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `socios`
--
ALTER TABLE `socios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `socios_dni_unique` (`dni`),
  ADD UNIQUE KEY `socios_email_unique` (`email`),
  ADD KEY `socios_perfil_id_foreign` (`perfil_id`),
  ADD KEY `socios_parentesco_id_foreign` (`parentesco_id`),
  ADD KEY `socios_clase_id_foreign` (`clase_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clases`
--
ALTER TABLE `clases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `invitados`
--
ALTER TABLE `invitados`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `parentescos`
--
ALTER TABLE `parentescos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `perfils`
--
ALTER TABLE `perfils`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `reporte_invi_dias`
--
ALTER TABLE `reporte_invi_dias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `reporte_soci_dias`
--
ALTER TABLE `reporte_soci_dias`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `socios`
--
ALTER TABLE `socios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `invitados`
--
ALTER TABLE `invitados`
  ADD CONSTRAINT `invitados_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invitados_socio_id_foreign` FOREIGN KEY (`socio_id`) REFERENCES `socios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte_invi_dias`
--
ALTER TABLE `reporte_invi_dias`
  ADD CONSTRAINT `reporte_invi_dias_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_invi_dias_socio_id_foreign` FOREIGN KEY (`socio_id`) REFERENCES `socios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `reporte_soci_dias`
--
ALTER TABLE `reporte_soci_dias`
  ADD CONSTRAINT `reporte_soci_dias_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_soci_dias_parentesco_id_foreign` FOREIGN KEY (`parentesco_id`) REFERENCES `parentescos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reporte_soci_dias_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfils` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `socios`
--
ALTER TABLE `socios`
  ADD CONSTRAINT `socios_clase_id_foreign` FOREIGN KEY (`clase_id`) REFERENCES `clases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `socios_parentesco_id_foreign` FOREIGN KEY (`parentesco_id`) REFERENCES `parentescos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `socios_perfil_id_foreign` FOREIGN KEY (`perfil_id`) REFERENCES `perfils` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
