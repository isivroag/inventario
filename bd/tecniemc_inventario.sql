-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.21-log - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para tecniemc_inventario
CREATE DATABASE IF NOT EXISTS `tecniemc_inventario` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `tecniemc_inventario`;

-- Volcando estructura para tabla tecniemc_inventario.mov_prod
CREATE TABLE IF NOT EXISTS `mov_prod` (
  `id_movp` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_prod` bigint(20) DEFAULT NULL,
  `fecha_movp` date DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `tipo_movp` varchar(50) DEFAULT NULL,
  `saldoini` decimal(10,2) DEFAULT NULL,
  `cantidad` decimal(10,2) DEFAULT NULL,
  `saldofin` decimal(10,2) DEFAULT NULL,
  `estado_movp` tinyint(1) DEFAULT '1',
  `folio_vta` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_movp`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tecniemc_inventario.mov_prod: ~3 rows (aproximadamente)
DELETE FROM `mov_prod`;
/*!40000 ALTER TABLE `mov_prod` DISABLE KEYS */;
INSERT INTO `mov_prod` (`id_movp`, `id_prod`, `fecha_movp`, `descripcion`, `tipo_movp`, `saldoini`, `cantidad`, `saldofin`, `estado_movp`, `folio_vta`) VALUES
	(1, 1, '2021-04-09', 'INVENTARIO INICIAL 8 ABRIL 21', 'Inventario Inicial', 0.00, 100.00, 100.00, 1, NULL),
	(2, 1, '2021-04-09', 'SALIDA POR AJUSTE', 'Salida', 100.00, 2.00, 98.00, 1, NULL),
	(3, 1, '2021-04-09', 'COMPRA DE MATERIAL', 'Entrada', 98.00, 25.00, 123.00, 1, NULL),
	(4, 2, '2021-04-09', 'INVENTARIO INICIAL 8 ABR 21', 'Inventario Inicial', 0.00, 50.00, 50.00, 1, NULL);
/*!40000 ALTER TABLE `mov_prod` ENABLE KEYS */;

-- Volcando estructura para tabla tecniemc_inventario.producto
CREATE TABLE IF NOT EXISTS `producto` (
  `id_prod` bigint(20) NOT NULL AUTO_INCREMENT,
  `clave_prod` varchar(50) NOT NULL,
  `nom_prod` varchar(150) NOT NULL,
  `umedida` varchar(150) NOT NULL,
  `precio_prod` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cant_prod` decimal(10,2) NOT NULL DEFAULT '0.00',
  `estado_prod` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tecniemc_inventario.producto: ~1 rows (aproximadamente)
DELETE FROM `producto`;
/*!40000 ALTER TABLE `producto` DISABLE KEYS */;
INSERT INTO `producto` (`id_prod`, `clave_prod`, `nom_prod`, `umedida`, `precio_prod`, `cant_prod`, `estado_prod`) VALUES
	(1, 'PR6020', 'PISO LAMINADO COLOR MADERA', 'PZA', 180.00, 123.00, 1),
	(2, 'PM3500', 'PISO DE MADERA COLOR CAOBA', 'PZA', 250.00, 50.00, 1);
/*!40000 ALTER TABLE `producto` ENABLE KEYS */;

-- Volcando estructura para tabla tecniemc_inventario.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla tecniemc_inventario.rol: ~2 rows (aproximadamente)
DELETE FROM `rol`;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` (`id`, `rol`) VALUES
	(1, 'usuario'),
	(2, 'administrador');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;

-- Volcando estructura para tabla tecniemc_inventario.umedida
CREATE TABLE IF NOT EXISTS `umedida` (
  `id_umedida` int(11) NOT NULL AUTO_INCREMENT,
  `nom_umedida` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estado_umedida` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_umedida`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla tecniemc_inventario.umedida: ~4 rows (aproximadamente)
DELETE FROM `umedida`;
/*!40000 ALTER TABLE `umedida` DISABLE KEYS */;
INSERT INTO `umedida` (`id_umedida`, `nom_umedida`, `estado_umedida`) VALUES
	(1, 'ML', 1),
	(2, 'M2', 1),
	(3, 'PZA', 1),
	(4, 'SERVICIO', 1);
/*!40000 ALTER TABLE `umedida` ENABLE KEYS */;

-- Volcando estructura para tabla tecniemc_inventario.w_usuario
CREATE TABLE IF NOT EXISTS `w_usuario` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `password` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edo_usuario` tinyint(1) NOT NULL DEFAULT '0',
  `rol_usuario` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_usuario`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- Volcando datos para la tabla tecniemc_inventario.w_usuario: ~1 rows (aproximadamente)
DELETE FROM `w_usuario`;
/*!40000 ALTER TABLE `w_usuario` DISABLE KEYS */;
INSERT INTO `w_usuario` (`id_usuario`, `username`, `nombre`, `email`, `password`, `edo_usuario`, `rol_usuario`) VALUES
	(1, 'admin', 'Sistemas', 'correo@correo.com', '98f815d654114526e522edb08dfe1453', 1, 2),
	(2, 'ventas', 'Ventas', 'ventas@tecniem.com', '530b350d414da3378a15b3149b322908', 0, 1);
/*!40000 ALTER TABLE `w_usuario` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
