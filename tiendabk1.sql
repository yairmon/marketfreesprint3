-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 06, 2015 at 09:23 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tienda`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniqueNombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`, `descripcion`) VALUES
(3, 'Salones', 'Poltronas mesas'),
(4, 'Perfumes', 'Encuentra perfumes de todas las fragancias'),
(5, 'Celulares', 'Encuentra celulares de todas las gamas'),
(6, 'Camas', 'Encuentra la cama que desees'),
(7, 'Almohadas', 'Encuentra almohadas ortopedicas'),
(8, 'Inmuebles', 'Encuentra desde casas hasta mansiones'),
(9, 'Ocio', 'Para juegos de mesa');

-- --------------------------------------------------------

--
-- Table structure for table `comision`
--

CREATE TABLE IF NOT EXISTS `comision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `porcentaje` varchar(191) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `comision`
--

INSERT INTO `comision` (`id`, `porcentaje`, `fecha`) VALUES
(1, '0.01', '2015-04-09 05:00:30'),
(2, '0.16', '2015-05-05 02:15:49'),
(3, '0.1', '2015-05-05 20:46:51'),
(4, '0.1', '2015-05-05 20:48:03'),
(5, '0.1', '2015-05-05 20:48:37'),
(6, '0.1', '2015-05-05 20:48:50'),
(7, '0.1', '2015-05-05 21:03:38'),
(8, '0.1', '2015-05-05 21:03:53'),
(9, '0.1', '2015-05-05 21:04:33'),
(10, '0.2', '2015-05-05 21:09:52'),
(11, '0.2', '2015-05-05 21:10:24'),
(12, '0.2', '2015-05-05 21:10:49'),
(13, '0.2', '2015-05-05 21:15:30'),
(14, '0.2', '2015-05-05 21:17:41'),
(15, '0.16', '2015-05-05 21:24:31'),
(16, '0.01', '2015-05-05 21:25:06'),
(17, '1.0', '2015-05-05 22:08:36'),
(18, '1.1', '2015-05-05 22:09:21'),
(19, '1.0', '2015-05-05 22:10:02');

-- --------------------------------------------------------

--
-- Table structure for table `detalle`
--

CREATE TABLE IF NOT EXISTS `detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_producto` (`id_producto`),
  KEY `fk_id_factura` (`id_factura`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) unsigned NOT NULL,
  `id_comision` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `estado` varchar(30) NOT NULL DEFAULT 'pendiente',
  `total` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_comision` (`id_comision`),
  KEY `fk_id_cliente` (`id_cliente`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permiso_gestionar_usuarios` tinyint(1) DEFAULT NULL,
  `permiso_vender` tinyint(1) DEFAULT NULL,
  `permiso_gestionar_perfiles` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`id`, `nombre`, `permiso_gestionar_usuarios`, `permiso_vender`, `permiso_gestionar_perfiles`) VALUES
(1, 'Admin', 1, 1, 1),
(2, 'Default', 0, 1, 0),
(3, 'Krusty', 1, 1, 0),
(4, 'Popeto', 1, 1, 0),
(5, 'hola mund', 1, 1, 1),
(9, 'Super Admin', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `producto`
--

CREATE TABLE IF NOT EXISTS `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_username` varchar(30) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `cantidad` int(4) NOT NULL,
  `valor_unitario` int(5) NOT NULL,
  `estado` varchar(30) NOT NULL DEFAULT 'En venta',
  `url_imagen` varchar(200) NOT NULL,
  `usuario_id` varchar(191) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoria_id` (`categoria_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=93 ;

-- --------------------------------------------------------

--
-- Table structure for table `seguir`
--

CREATE TABLE IF NOT EXISTS `seguir` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seguidor` int(11) unsigned NOT NULL,
  `seguido` int(11) unsigned NOT NULL,
  `estado` bit(1) DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `seguidor` (`seguidor`),
  KEY `seguido` (`seguido`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `documento` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `apellidos` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nombre_usuario` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tipo_perfil` int(11) DEFAULT '2',
  `estado` int(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `documento` (`documento`),
  UNIQUE KEY `nombre_usuario` (`nombre_usuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `documento`, `nombre`, `apellidos`, `email`, `nombre_usuario`, `password`, `tipo_perfil`, `estado`) VALUES
(1, '116264525', 'Juanito', 'Velasquez', 'Velasquez94@hotmail.com', 'juanTwo', '1234asdf', 2, 1),
(5, '888834343', 'Oscar', 'Morocho', 'morocho@oscar.com', 'morochoscar', 'morocho', 2, 1),
(9, '12331231', 'Pepeto', 'pepone', 'vadfgdfgsfdg', 'popocho', 'poposito', 2, 1),
(10, '436523676', 'Barrera', 'Sebastian', 'barreroide@barrera', 'barreroide', 'barreroide', 2, 1),
(11, '12345678431', 'Carlos Andres', 'Moreno', 'camv_123@hotmail.com', 'camv', 'camv', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vogoo_ads`
--

CREATE TABLE IF NOT EXISTS `vogoo_ads` (
  `ad_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `mini` int(11) NOT NULL,
  KEY `ad_id` (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vogoo_ads_products`
--

CREATE TABLE IF NOT EXISTS `vogoo_ads_products` (
  `ad_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  KEY `ad_id` (`ad_id`),
  KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vogoo_links`
--

CREATE TABLE IF NOT EXISTS `vogoo_links` (
  `item_id1` int(11) NOT NULL,
  `item_id2` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `cnt` int(11) DEFAULT NULL,
  `diff_slope` float DEFAULT NULL,
  UNIQUE KEY `vogoo_links_ix` (`item_id1`,`item_id2`,`category`),
  KEY `vogoo_links_i1ix` (`item_id1`),
  KEY `vogoo_links_i2ix` (`item_id2`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `vogoo_ratings`
--

CREATE TABLE IF NOT EXISTS `vogoo_ratings` (
  `member_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `rating` float NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `vogoo_ratings_mpix` (`member_id`,`product_id`,`category`),
  KEY `vogoo_ratings_mix` (`member_id`),
  KEY `vogoo_ratings_pix` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detalle`
--
ALTER TABLE `detalle`
  ADD CONSTRAINT `fk_id_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_producto` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `fk_id_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_comision` FOREIGN KEY (`id_comision`) REFERENCES `comision` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_categoria_id` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seguir`
--
ALTER TABLE `seguir`
  ADD CONSTRAINT `seguir_ibfk_1` FOREIGN KEY (`seguidor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `seguir_ibfk_2` FOREIGN KEY (`seguido`) REFERENCES `usuario` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
