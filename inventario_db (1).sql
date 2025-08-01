-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-07-2025 a las 00:52:40
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventario_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_brand`
--

CREATE TABLE `ims_brand` (
  `id` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `bname` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ims_brand`
--

INSERT INTO `ims_brand` (`id`, `categoryid`, `bname`, `status`) VALUES
(1, 2, 'Brand 1', 'active'),
(2, 2, 'Brand 2', 'active'),
(3, 2, 'Brand 3', 'active'),
(4, 1, 'Brand 201', 'active'),
(5, 1, 'Brand 202', 'active'),
(6, 1, 'Brand 203', 'active'),
(7, 3, 'Brand 301', 'active'),
(8, 3, 'Brand 302', 'active'),
(9, 3, 'Brand 303', 'active'),
(10, 1, 'IPhone', 'active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_category`
--

CREATE TABLE `ims_category` (
  `categoryid` int(11) NOT NULL,
  `name` varchar(250) CHARACTER SET latin1 NOT NULL,
  `status` enum('active','inactive') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ims_category`
--

INSERT INTO `ims_category` (`categoryid`, `name`, `status`) VALUES
(1, 'Smartphone', 'active'),
(2, 'Random Item', 'active'),
(3, 'Speaker', 'active'),
(4, 'Audifonos', 'active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_customer`
--

CREATE TABLE `ims_customer` (
  `id` int(11) NOT NULL,
  `codcli` varchar(20) CHARACTER SET utf8 NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `balance` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ims_customer`
--

INSERT INTO `ims_customer` (`id`, `codcli`, `name`, `address`, `mobile`, `balance`) VALUES
(1, '3001', 'Mark Cooper ', 'Sample Address ejemplo', 12121212, 25000.00),
(2, '3002', 'George Wilson', '2306 St, Here There', 2147483647, 35000.00),
(3, '3003', 'Clary Rivera', 'urb los cedros', 2147483647, 10.00),
(4, '3004', 'Ricardo Jose Rodriguez', 'Calle 1 Numero 5', 412929005, 20.00),
(5, '3005', 'Jhon  Linarez', 'Urbanizacion las trinitarias', 412663322, 30.00),
(11, '3022', 'Tomas Liscano', 'Direccion Los cedros', 412551122, 55.00),
(23, '3030', 'Carlos Enrique Villa', 'Urb El placer Cabudare', 42455112, 0.00),
(24, '3023', 'Angel Lopez S', 'Urb. El pedregal Barquisimeto', 414522000, 0.00),
(25, '3033', 'Jose Martinez R', 'Urba. El Pedregal II', 41226352, 0.00),
(26, '3040', 'Alexandra Perez', 'Valle Hondo casa 3', 414552112, 0.00),
(27, '3042', 'Carlos SSlim', 'Av. Palmira centro', 426552471, 0.00),
(28, '3041', 'Petra Paez', 'Sample Address ejemplo', 2147483647, 0.00),
(29, '3043', 'Juan Perlaez', 'Los cerrajones, Barquisimeto', 414552555, 0.00),
(30, '3044', 'Jose Daniel Arce', 'Urb. El Obelisco Barquisimeto', 2147483647, 0.00),
(31, '3045', 'Ramon Romero', 'Urb. La Fundacion', 41144552, 0.00),
(32, '3046', 'Carla Castro', 'Urb. El pedregal Barquisimeto', 414522111, 0.00),
(33, '3055', 'Mark Sanchez', 'Urb. Las Mercedes, calle 1', 412552255, 0.00),
(34, '3060', 'Froilan Alvarez', 'Urb. Patarata', 412782144, 0.00),
(35, '4040', 'Carlos Figueroa', 'Urb. Hurtado Higuera', 2147483647, 0.00),
(36, '4041', 'Ramon Linares', 'Av. Libertador, cruce con Hospital', 2147483647, 0.00),
(37, '4042', 'Wilfredo Lanz', 'El Tocuyo', 1231231231, 0.00),
(39, '2002', 'Charlie Brown P', 'Av. Rotaria con carrera 13 Barquisimeto', 424551221, 0.00),
(40, '2001', 'Cris Obregon', 'Carretera El cuji - Tamaca', 2147483647, 0.00),
(41, '2000', 'Jose Lozano', 'Urb Las colinas  av. Madrid ', 412263221, 0.00),
(42, '1999', 'Tecno Cc', 'av las palmas', 12421252, 0.00),
(43, '1998', 'Ramona Velez', 'El Tocuyo', 12412142, 0.00),
(44, '1997', 'Maria Rodriguez', 'Av. Libertador Patarata Barquisimeto', 2147483647, 0.00),
(45, '1996', 'Patrica Lemos', 'Av. La montaÃ±ita Cabudare', 2147483647, 0.00),
(46, '1995', 'Candido Harris', 'Urb. El Obelisco, calle 54', 2147483647, 0.00),
(47, '1994', 'Horacio Blanco', 'Url El Paraiso Caracas', 4245112211, 0.00),
(48, '1993', 'Rafael Prince', 'Urb. El Ujano', 4145112233, 0.00),
(49, '1991', 'Carla Pire', 'Av. Concordia Urb del este', 4141112233, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_order`
--

CREATE TABLE `ims_order` (
  `order_id` int(11) NOT NULL,
  `codcli` varchar(11) CHARACTER SET latin1 NOT NULL,
  `product_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `total_shipped` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ims_order`
--

INSERT INTO `ims_order` (`order_id`, `codcli`, `product_id`, `total_shipped`, `customer_id`, `order_date`) VALUES
(1, '', '1', 5, 1, '2022-06-20 08:20:40'),
(2, '', '2', 3, 2, '2022-06-20 08:20:48'),
(32, '', '3', 1, 0, '2025-02-09 14:06:38'),
(33, '', '1', 10, 0, '2025-02-09 14:08:10'),
(34, '', '1', 10, 0, '2025-03-10 15:15:16'),
(35, '', '3', 2, 0, '2025-03-10 15:53:12'),
(36, '', '3', 10, 13, '2025-03-11 15:24:51'),
(37, '', '3', 105, 0, '2025-03-12 13:00:11'),
(38, '', '3', 20, 0, '2025-03-12 13:01:00'),
(39, '', '4', 10, 11, '2025-03-12 15:01:24'),
(40, '', '4', 10, 9, '2025-04-25 16:52:03');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_product`
--

CREATE TABLE `ims_product` (
  `pid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `brandid` int(11) NOT NULL,
  `pname` varchar(300) CHARACTER SET latin1 NOT NULL,
  `model` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(150) CHARACTER SET latin1 NOT NULL,
  `base_price` double(10,2) NOT NULL,
  `tax` decimal(4,2) NOT NULL,
  `minimum_order` double(10,2) NOT NULL,
  `supplier` int(11) NOT NULL,
  `status` enum('active','inactive') CHARACTER SET latin1 NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ims_product`
--

INSERT INTO `ims_product` (`pid`, `categoryid`, `brandid`, `pname`, `model`, `description`, `quantity`, `unit`, `base_price`, `tax`, `minimum_order`, `supplier`, `status`, `date`) VALUES
(1, 2, 1, 'Xiamo 101 PRO', 'P-1001', 'usce auctor faucibus efficitur.', 10, 'Bottles', 520.00, '12.00', 1.00, 1, 'active', '0000-00-00'),
(2, 1, 4, 'Honor 2025 Lite', 'P-1002', 'Proin vehicula mi pulvinar ipsum ornare tincidunt.', 15, 'Box', 7500.00, '12.00', 1.00, 2, 'active', '0000-00-00'),
(3, 3, 7, 'Iphone 16 Ultra', 'P-1003', 'Integer interdum, odio eget mattis venenatis', 20, 'Bags', 350.00, '12.00', 1.00, 3, 'active', '0000-00-00'),
(4, 1, 4, 'Huawei P400', 'Mobile', 'Celular alta gama', 1200, 'Box', 1000.00, '3.00', 1.00, 1, 'active', '0000-00-00'),
(5, 2, 1, 'Samsung Galaxy A15', 'A15', 'Samsung Galaxie A15', 0, '', 190.00, '16.50', 0.00, 0, '', '0000-00-00'),
(6, 1, 4, 'Samsung Galaxy A55', 'A55', 'Samsung Galaxy A55', 0, 'unidad', 300.00, '16.50', 0.00, 3, 'active', '2025-06-14'),
(7, 3, 1, 'Xiaomi Redmi Note 13', 'Note13', 'Xiaomi Redmi Note 13', 0, 'unidad', 420.00, '16.50', 0.00, 1, 'active', '2025-06-01'),
(8, 1, 1, 'Xiaomi 14 Ultra', 'Ultra14', 'Xiaomi 14 Ultra', 0, '', 510.00, '0.00', 0.00, 0, '', '0000-00-00'),
(9, 3, 4, 'Iphone 15', '15', 'Iphone 15', 0, 'unidad', 450.00, '16.50', 0.00, 3, 'active', '2025-06-12'),
(10, 1, 1, 'Iphone 15 pro max', '15 pro max', 'Iphone 15 pro max', 1, '', 800.00, '16.50', 1.00, 3, 'active', '2025-06-09'),
(11, 3, 4, 'Honor Magic6 Lite', 'Magig 6', 'Honor Magic6 Lite', 1, 'unidad', 200.00, '16.50', 1.00, 1, 'active', '2025-06-01'),
(12, 2, 1, 'BLU BOLD K10 – 6.5', '', 'Teléfono Celular BLU BOLD K10 – 6.5? ', 1, 'unidad', 189.00, '16.50', 1.00, 2, 'active', '2025-06-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_purchase`
--

CREATE TABLE `ims_purchase` (
  `purchase_id` int(11) NOT NULL,
  `supplier_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `product_id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `quantity` varchar(255) CHARACTER SET latin1 NOT NULL,
  `purchase_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ims_purchase`
--

INSERT INTO `ims_purchase` (`purchase_id`, `supplier_id`, `product_id`, `quantity`, `purchase_date`) VALUES
(1, '1', '1', '25', '2022-06-20 08:20:07'),
(2, '2', '2', '35', '2022-06-20 08:20:14'),
(3, '3', '3', '10', '2022-06-20 08:20:29'),
(4, '1', '2', '10', '2025-05-26 12:46:00'),
(5, '3', '3', '5', '2025-05-26 12:46:21'),
(6, '1', '2', '10', '2025-05-26 12:47:38'),
(7, '1', '2', '10', '2025-05-26 12:47:52'),
(8, '1', '2', '10', '2025-05-26 12:48:06'),
(9, '2', '2', '10', '2025-05-26 12:48:22'),
(10, '3', '4', '5', '2025-05-26 12:48:43'),
(11, '3', '2', '10', '2025-05-26 12:49:20'),
(12, '1', '2', '10', '2025-05-26 12:49:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_supplier`
--

CREATE TABLE `ims_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `mobile` varchar(50) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `status` enum('active','inactive') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ims_supplier`
--

INSERT INTO `ims_supplier` (`supplier_id`, `supplier_name`, `mobile`, `address`, `status`) VALUES
(1, 'Supplier 101', '09645987123', 'Over Here', 'active'),
(2, 'Supplier 102', '094568791252', 'Over There', 'active'),
(3, 'Supplier 103', '09789897879', 'Anywhere There', 'active');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ims_user`
--

CREATE TABLE `ims_user` (
  `userid` int(11) NOT NULL,
  `email` varchar(200) CHARACTER SET latin1 NOT NULL,
  `password` varchar(200) CHARACTER SET latin1 NOT NULL,
  `name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `type` enum('admin','member') CHARACTER SET latin1 NOT NULL,
  `status` enum('Active','Inactive') CHARACTER SET latin1 NOT NULL,
  `id_rol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ims_user`
--

INSERT INTO `ims_user` (`userid`, `email`, `password`, `name`, `type`, `status`, `id_rol`) VALUES
(1, 'admin@mail.com', '0192023a7bbd73250516f069df18b500', 'Administrator', 'admin', 'Active', 1),
(2, 'sanchez@gmail.com', '0192023a7bbd73250516f069df18b500', 'Consultor', 'member', 'Active', 5),
(6, 'ricardojsanchez@lhotmail.com', '0192023a7bbd73250516f069df18b500', 'Ricardo Sanchez', 'admin', 'Active', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mov_ped`
--

CREATE TABLE `mov_ped` (
  `numped` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` double(10,2) NOT NULL,
  `total` double(10,2) NOT NULL,
  `iva_tax` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mov_ped`
--

INSERT INTO `mov_ped` (`numped`, `pid`, `cantidad`, `precio`, `total`, `iva_tax`) VALUES
(102, 4, 5, 105.00, 525.00, 86.62),
(119, 4, 15, 1000.00, 15000.00, 0.00),
(119, 1, 22, 500.00, 11000.00, 0.00),
(119, 1, 22, 500.00, 11000.00, 0.00),
(119, 1, 22, 500.00, 11000.00, 0.00),
(119, 1, 22, 500.00, 11000.00, 0.00),
(119, 1, 22, 500.00, 11000.00, 0.00),
(119, 4, 15, 1000.00, 15000.00, 0.00),
(119, 4, 15, 1000.00, 15000.00, 0.00),
(121, 4, 22, 1000.00, 22000.00, 0.00),
(121, 4, 22, 1000.00, 22000.00, 0.00),
(121, 4, 22, 1000.00, 22000.00, 0.00),
(121, 4, 22, 1000.00, 22000.00, 0.00),
(123, 4, 2, 1000.00, 2000.00, 0.00),
(123, 1, 1, 500.00, 500.00, 0.00),
(123, 1, 1, 500.00, 500.00, 0.00),
(124, 1, 1, 500.00, 500.00, 82.50),
(124, 2, 1, 7500.00, 7500.00, 0.00),
(124, 2, 1, 7500.00, 7500.00, 0.00),
(124, 3, 1, 350.00, 350.00, 0.00),
(124, 4, 1, 1000.00, 1000.00, 0.00),
(125, 1, 1, 500.00, 500.00, 0.00),
(125, 3, 1, 350.00, 350.00, 0.00),
(125, 2, 2, 7500.00, 15000.00, 0.00),
(125, 4, 1, 1000.00, 1000.00, 0.00),
(126, 1, 2, 500.00, 1000.00, 0.00),
(137, 1, 1, 500.00, 500.00, 0.00),
(140, 4, 10, 1000.00, 10000.00, 1650.00),
(150, 4, 2, 1000.00, 2000.00, 330.00),
(150, 2, 20, 7500.00, 150000.00, 24750.00),
(153, 3, 2, 350.00, 700.00, 115.50),
(160, 1, 15, 500.00, 7500.00, 1237.50),
(160, 4, 1, 1000.00, 1000.00, 0.00),
(160, 3, 1, 350.00, 350.00, 0.00),
(161, 1, 1, 500.00, 500.00, 82.50),
(162, 1, 1, 500.00, 500.00, 82.50),
(162, 2, 2, 7500.00, 15000.00, 2475.00),
(163, 4, 1, 1000.00, 1000.00, 165.00),
(164, 4, 2, 1000.00, 2000.00, 330.00),
(164, 1, 15, 500.00, 7500.00, 0.00),
(165, 4, 1, 1000.00, 1000.00, 165.00),
(165, 1, 2, 500.00, 1000.00, 0.00),
(166, 1, 2, 500.00, 1000.00, 165.00),
(167, 1, 2, 500.00, 1000.00, 165.00),
(168, 1, 1, 500.00, 500.00, 82.50),
(168, 2, 20, 7500.00, 150000.00, 0.00),
(169, 4, 2, 1000.00, 2000.00, 0.00),
(170, 1, 15, 500.00, 7500.00, 1237.50),
(171, 1, 2, 500.00, 1000.00, 165.00),
(172, 4, 2, 1000.00, 2000.00, 330.00),
(172, 1, 15, 500.00, 7500.00, 0.00),
(173, 3, 2, 350.00, 700.00, 0.00),
(173, 2, 1, 7500.00, 7500.00, 1237.50),
(184, 4, 1, 1000.00, 1000.00, 165.00),
(185, 4, 2, 1000.00, 2000.00, 330.00),
(186, 1, 2, 500.00, 1000.00, 165.00),
(187, 4, 1, 1000.00, 1000.00, 165.00),
(187, 2, 1, 7500.00, 7500.00, 0.00),
(188, 4, 1, 1000.00, 1000.00, 165.00),
(188, 1, 1, 500.00, 500.00, 0.00),
(189, 4, 1, 1000.00, 1000.00, 165.00),
(189, 2, 1, 7500.00, 7500.00, 0.00),
(206, 2, 1, 7500.00, 7500.00, 0.00),
(206, 4, 1, 1000.00, 1000.00, 165.00),
(209, 3, 1, 350.00, 350.00, 0.00),
(209, 4, 2, 1000.00, 2000.00, 330.00),
(219, 2, 15, 7500.00, 112500.00, 18562.50),
(219, 1, 15, 500.00, 7500.00, 0.00),
(224, 2, 1, 7500.00, 7500.00, 1237.50),
(224, 4, 1, 1000.00, 1000.00, 165.00),
(225, 1, 1, 500.00, 500.00, 82.50),
(225, 2, 1, 7500.00, 7500.00, 1237.50),
(218, 2, 10, 7500.00, 75000.00, 12375.00),
(218, 1, 1, 500.00, 500.00, 82.50),
(213, 4, 10, 1000.00, 10000.00, 1650.00),
(215, 1, 15, 500.00, 7500.00, 1237.50),
(208, 2, 10, 7500.00, 75000.00, 12375.00),
(213, 1, 15, 500.00, 7500.00, 1237.50),
(208, 3, 1, 350.00, 350.00, 57.75),
(208, 1, 1, 500.00, 500.00, 82.50),
(117, 2, 1, 7500.00, 7500.00, 1237.50),
(169, 2, 10, 7500.00, 75000.00, 12375.00),
(104, 4, 1, 1000.00, 1000.00, 165.00),
(235, 2, 15, 7500.00, 112500.00, 18562.50),
(235, 4, 1, 1000.00, 1000.00, 165.00),
(236, 2, 1, 7500.00, 7500.00, 1237.50),
(236, 4, 1, 1000.00, 1000.00, 165.00),
(237, 2, 1, 7500.00, 7500.00, 1237.50),
(237, 3, 1, 350.00, 350.00, 57.75),
(238, 2, 1, 7500.00, 7500.00, 1237.50),
(239, 2, 1, 7500.00, 7500.00, 1237.50),
(241, 2, 12, 7500.00, 90000.00, 14850.00),
(241, 4, 20, 1000.00, 20000.00, 3300.00),
(242, 6, 1, 300.00, 300.00, 49.50),
(242, 12, 1, 189.00, 189.00, 31.18),
(242, 11, 1, 200.00, 200.00, 33.00),
(242, 7, 1, 420.00, 420.00, 69.30),
(242, 5, 1, 190.00, 190.00, 31.35),
(243, 12, 10, 189.00, 1890.00, 311.85),
(243, 2, 5, 7500.00, 37500.00, 6187.50),
(243, 4, 1, 1000.00, 1000.00, 165.00),
(243, 3, 1, 350.00, 350.00, 57.75),
(243, 8, 15, 510.00, 7650.00, 1262.25),
(145, 12, 1, 189.00, 189.00, 31.18),
(146, 12, 1, 189.00, 189.00, 31.18),
(147, 7, 12, 420.00, 5040.00, 831.60),
(149, 5, 5, 190.00, 950.00, 156.75),
(151, 12, 1, 189.00, 189.00, 31.18),
(4, 3, 1, 350.00, 350.00, 57.75),
(154, 6, 10, 300.00, 3000.00, 495.00),
(155, 3, 1, 350.00, 350.00, 57.75),
(157, 8, 1, 510.00, 510.00, 84.15),
(159, 1, 2, 500.00, 1000.00, 165.00),
(5, 12, 1, 189.00, 189.00, 31.18),
(5, 2, 1, 7500.00, 7500.00, 1237.50),
(244, 1, 10, 520.00, 5200.00, 858.00),
(245, 1, 1, 520.00, 520.00, 85.80),
(246, 2, 10, 7500.00, 75000.00, 12375.00),
(198, 11, 1, 200.00, 200.00, 33.00),
(177, 7, 1, 420.00, 420.00, 69.30),
(174, 1, 1, 520.00, 520.00, 85.80),
(38, 8, 1, 510.00, 510.00, 84.15),
(59, 5, 1, 190.00, 190.00, 31.35),
(60, 4, 1, 1000.00, 1000.00, 165.00),
(63, 2, 1, 7500.00, 7500.00, 1237.50),
(64, 10, 1, 800.00, 800.00, 132.00),
(86, 8, 1, 510.00, 510.00, 84.15),
(72, 7, 1, 420.00, 420.00, 69.30),
(65, 12, 1, 189.00, 189.00, 31.18),
(74, 8, 1, 510.00, 510.00, 84.15),
(71, 1, 1, 520.00, 520.00, 85.80),
(195, 2, 1, 7500.00, 7500.00, 1237.50),
(196, 6, 1, 300.00, 300.00, 49.50),
(66, 5, 1, 190.00, 190.00, 31.35),
(67, 1, 10, 520.00, 5200.00, 858.00),
(85, 11, 5, 200.00, 1000.00, 165.00),
(84, 8, 1, 510.00, 510.00, 84.15),
(247, 1, 1, 520.00, 520.00, 85.80),
(248, 7, 5, 420.00, 2100.00, 346.50),
(235, 6, 10, 300.00, 3000.00, 495.00),
(256, 1, 1, 520.00, 520.00, 85.80),
(256, 2, 1, 7500.00, 7500.00, 1237.50),
(257, 1, 1, 520.00, 520.00, 85.80),
(263, 1, 1, 520.00, 520.00, 85.80),
(327, 5, 1, 190.00, 190.00, 31.35),
(328, 1, 1, 520.00, 520.00, 85.80),
(331, 2, 1, 7500.00, 7500.00, 1237.50),
(331, 1, 10, 520.00, 5200.00, 858.00),
(331, 8, 5, 510.00, 2550.00, 420.75),
(331, 10, 1, 800.00, 800.00, 132.00),
(331, 12, 1, 189.00, 189.00, 31.18),
(332, 2, 1, 7500.00, 7500.00, 1237.50),
(336, 1, 1, 520.00, 520.00, 85.80),
(337, 5, 1, 190.00, 190.00, 31.35),
(338, 2, 1, 7500.00, 7500.00, 1237.50),
(339, 2, 10, 7500.00, 75000.00, 12375.00),
(340, 1, 1, 520.00, 520.00, 85.80),
(342, 4, 1, 1000.00, 1000.00, 165.00),
(342, 8, 1, 510.00, 510.00, 84.15),
(343, 1, 10, 520.00, 5200.00, 858.00),
(343, 9, 1, 450.00, 450.00, 74.25),
(343, 11, 1, 200.00, 200.00, 33.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `numeros`
--

CREATE TABLE `numeros` (
  `numpedido` int(11) NOT NULL,
  `iva` double(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `numeros`
--

INSERT INTO `numeros` (`numpedido`, `iva`) VALUES
(343, 16.50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `codcli` varchar(11) CHARACTER SET utf8 NOT NULL,
  `fecha_ped` date NOT NULL,
  `numped` int(11) NOT NULL,
  `status` varchar(1) CHARACTER SET utf8 NOT NULL,
  `subtotal` double(10,2) NOT NULL,
  `iva_t` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`codcli`, `fecha_ped`, `numped`, `status`, `subtotal`, `iva_t`) VALUES
('3022', '2025-03-03', 55, 'A', 0.00, 0.00),
('3001', '2025-04-19', 4, 'I', 350.00, 57.75),
('3001', '2025-04-19', 5, 'I', 7689.00, 1268.68),
('3003', '2025-04-20', 38, 'I', 510.00, 84.15),
('3003', '2025-04-21', 59, 'I', 190.00, 31.35),
('3003', '2025-04-21', 60, 'I', 1000.00, 165.00),
('3003', '2025-04-21', 63, 'I', 7500.00, 1237.50),
('3003', '2025-04-21', 64, 'I', 800.00, 132.00),
('3003', '2025-04-21', 65, 'I', 189.00, 31.18),
('3002', '2025-04-21', 66, 'I', 190.00, 31.35),
('3002', '2025-04-21', 67, 'I', 5200.00, 858.00),
('3003', '2025-04-21', 71, 'I', 520.00, 85.80),
('3003', '2025-04-21', 72, 'I', 420.00, 69.30),
('3003', '2025-04-21', 74, 'I', 510.00, 84.15),
('3004', '2025-04-21', 75, 'I', 0.00, 0.00),
('3002', '2025-04-21', 84, 'I', 510.00, 84.15),
('3002', '2025-04-21', 85, 'I', 1000.00, 165.00),
('3003', '2025-04-21', 86, 'I', 510.00, 84.15),
('3003', '2025-04-22', 97, 'I', 0.00, 0.00),
('3003', '2025-04-22', 102, 'I', 525.00, 86.62),
('3002', '2025-04-22', 104, 'I', 1000.00, 165.00),
('3003', '2025-04-24', 105, 'I', 0.00, 0.00),
('3003', '2025-04-24', 106, 'I', 0.00, 0.00),
('3003', '2025-04-24', 107, 'I', 0.00, 0.00),
('3003', '2025-04-24', 108, 'I', 0.00, 0.00),
('3003', '2025-04-24', 109, 'I', 0.00, 0.00),
('3003', '2025-04-24', 110, 'I', 0.00, 0.00),
('3003', '2025-04-24', 112, 'I', 0.00, 0.00),
('3003', '2025-04-25', 113, 'I', 0.00, 0.00),
('3003', '2025-04-25', 114, 'I', 0.00, 0.00),
('3003', '2025-04-25', 115, 'I', 0.00, 0.00),
('3003', '2025-04-25', 116, 'I', 0.00, 0.00),
('3002', '2025-04-25', 117, 'I', 7500.00, 1237.50),
('3003', '2025-04-28', 119, 'I', 0.00, 0.00),
('3003', '2025-04-28', 120, 'I', 0.00, 0.00),
('3003', '2025-04-28', 121, 'I', 0.00, 0.00),
('3003', '2025-04-28', 122, 'I', 0.00, 0.00),
('3003', '2025-04-28', 123, 'I', 0.00, 0.00),
('3004', '2025-04-28', 124, 'I', 16850.00, 82.50),
('3003', '2025-04-28', 125, 'I', 0.00, 0.00),
('3003', '2025-04-29', 126, 'I', 0.00, 0.00),
('3003', '2025-04-29', 131, 'I', 0.00, 0.00),
('3003', '2025-04-29', 132, 'I', 0.00, 0.00),
('3003', '2025-04-29', 134, 'I', 0.00, 0.00),
('3003', '2025-04-29', 135, 'I', 0.00, 0.00),
('3003', '2025-04-29', 136, 'I', 0.00, 0.00),
('3003', '2025-04-29', 137, 'I', 0.00, 0.00),
('3003', '2025-05-03', 140, 'I', 10000.00, 1650.00),
('3003', '0000-00-00', 142, 'I', 0.00, 0.00),
('3003', '2025-05-04', 145, 'I', 189.00, 31.18),
('3003', '2025-05-04', 146, 'I', 189.00, 31.18),
('3003', '2025-05-04', 147, 'I', 5040.00, 831.60),
('3003', '2025-05-04', 149, 'I', 950.00, 156.75),
('3003', '2025-05-04', 150, 'I', 152000.00, 25080.00),
('3003', '2025-05-05', 151, 'I', 189.00, 31.18),
('3003', '2025-05-05', 153, 'I', 700.00, 115.50),
('3003', '2025-05-05', 154, 'I', 3000.00, 495.00),
('3003', '2025-05-05', 155, 'I', 350.00, 57.75),
('3003', '2025-05-05', 157, 'I', 510.00, 84.15),
('3001', '2025-05-05', 159, 'I', 1000.00, 165.00),
('3003', '2025-05-05', 160, 'I', 8850.00, 1237.50),
('3001', '2025-05-05', 161, 'I', 500.00, 82.50),
('3001', '2025-05-05', 162, 'I', 15500.00, 2557.50),
('3001', '2025-05-05', 163, 'I', 1000.00, 165.00),
('3003', '2025-05-05', 164, 'I', 9500.00, 330.00),
('3003', '2025-05-05', 165, 'I', 2000.00, 165.00),
('3003', '2025-05-05', 166, 'I', 1000.00, 165.00),
('3003', '2025-05-06', 167, 'I', 1000.00, 165.00),
('3003', '2025-05-06', 168, 'I', 150500.00, 82.50),
('3001', '2025-05-06', 169, 'I', 77000.00, 12375.00),
('3003', '2025-05-07', 170, 'I', 7500.00, 1237.50),
('3003', '2025-05-07', 171, 'I', 1000.00, 165.00),
('3003', '2025-05-07', 172, 'I', 9500.00, 330.00),
('3003', '2025-05-08', 173, 'I', 8200.00, 1237.50),
('3003', '2025-05-08', 174, 'I', 520.00, 85.80),
('3003', '2025-05-08', 177, 'I', 420.00, 69.30),
('3003', '2025-05-08', 184, 'I', 1000.00, 165.00),
('3003', '2025-05-08', 185, 'I', 2000.00, 330.00),
('3003', '2025-05-08', 186, 'I', 1000.00, 165.00),
('3003', '2025-05-09', 187, 'I', 8500.00, 165.00),
('3003', '2025-05-09', 188, 'I', 1500.00, 165.00),
('3003', '2025-05-10', 189, 'I', 8500.00, 165.00),
('3003', '2025-05-13', 195, 'I', 7500.00, 1237.50),
('3003', '2025-05-13', 196, 'I', 300.00, 49.50),
('3003', '2025-05-13', 198, 'I', 200.00, 33.00),
('3003', '2025-05-13', 206, 'I', 8500.00, 165.00),
('3005', '2025-05-13', 207, 'I', 0.00, 0.00),
('3030', '2025-05-13', 208, 'A', 75850.00, 12515.25),
('3003', '2025-05-13', 209, 'I', 2350.00, 330.00),
('3030', '2025-05-14', 213, 'I', 17500.00, 2887.50),
('3030', '2025-05-14', 215, 'I', 7500.00, 1237.50),
('3030', '2025-05-14', 218, 'I', 75500.00, 12457.50),
('3033', '2025-05-14', 219, 'I', 120000.00, 18562.50),
('3030', '2025-05-15', 224, 'I', 8500.00, 1402.50),
('3005', '2025-05-15', 225, 'I', 8000.00, 1320.00),
('3030', '2025-06-06', 235, 'I', 116500.00, 19222.50),
('3042', '2025-06-06', 236, 'I', 8500.00, 1402.50),
('3040', '2025-06-06', 237, 'I', 7850.00, 1295.25),
('4040', '2025-06-11', 238, 'I', 7500.00, 1237.50),
('4040', '2025-06-12', 239, 'I', 7500.00, 1237.50),
('1995', '2025-06-13', 241, 'I', 110000.00, 18150.00),
('2002', '2025-06-14', 242, 'I', 1299.00, 214.34),
('1991', '2025-06-14', 243, 'I', 48390.00, 7984.35),
('3046', '2025-06-22', 244, 'I', 5200.00, 858.00),
('1991', '2025-06-23', 245, 'I', 520.00, 85.80),
('1991', '2025-06-23', 246, 'I', 75000.00, 12375.00),
('2002', '2025-06-25', 247, 'I', 520.00, 85.80),
('4040', '2025-06-25', 248, 'I', 2100.00, 346.50),
('3042', '2025-06-26', 256, 'I', 8020.00, 1323.30),
('3040', '2025-06-26', 256, 'I', 8020.00, 1323.30),
('1995', '2025-06-26', 257, 'I', 520.00, 85.80),
('3042', '2025-06-26', 263, 'I', 520.00, 85.80),
('3040', '2025-06-26', 263, 'I', 520.00, 85.80),
('3060', '2025-06-26', 327, 'I', 190.00, 31.35),
('3040', '2025-06-26', 328, 'I', 520.00, 85.80),
('3060', '2025-06-30', 331, 'I', 16239.00, 2679.43),
('3003', '2025-06-30', 332, 'I', 7500.00, 1237.50),
('2001', '2025-06-30', 336, 'I', 520.00, 85.80),
('3022', '2025-06-30', 337, 'I', 190.00, 31.35),
('3042', '2025-07-01', 338, 'I', 7500.00, 1237.50),
('3046', '2025-07-01', 339, 'I', 75000.00, 12375.00),
('3003', '2025-07-01', 340, 'I', 520.00, 85.80),
('3046', '2025-07-01', 342, 'I', 1510.00, 249.15),
('3002', '2025-07-01', 343, 'I', 5850.00, 965.25);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_roles`
--

CREATE TABLE `permisos_roles` (
  `id_rol` int(11) NOT NULL,
  `permiso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos_roles`
--

INSERT INTO `permisos_roles` (`id_rol`, `permiso`) VALUES
(1, 'Actualizar_Estado'),
(1, 'Categorias'),
(1, 'Clientes'),
(1, 'Cliente_Pedido'),
(1, 'Consultar_Tablas'),
(1, 'Eliminar_Pedidos'),
(1, 'Generar_Factura'),
(1, 'Incluir_Pedidos'),
(1, 'Lista_Pedidos'),
(1, 'Marcas'),
(1, 'Modificar_Cliente'),
(1, 'Modificar_Pedidos'),
(1, 'Pedidos_Cliente'),
(1, 'Pedidos_Producto'),
(1, 'Productos'),
(1, 'Registrar_Nueva_Categoria'),
(1, 'Registrar_Nueva_Marca'),
(1, 'Registrar_Nuevo_Cliente'),
(1, 'Registrar_Nuevo_Pedido'),
(1, 'Registrar_Nuevo_Usuario'),
(1, 'Usuarios'),
(4, 'Actualizar_Estado'),
(4, 'Categorias'),
(4, 'Clientes'),
(4, 'Cliente_Pedido'),
(4, 'Consultar_Tablas'),
(4, 'Eliminar_Pedidos'),
(4, 'Incluir_Pedidos'),
(4, 'Lista_Pedidos'),
(4, 'Marcas'),
(4, 'Modificar_Pedidos'),
(4, 'Pedidos_Cliente'),
(4, 'Pedidos_Producto'),
(4, 'Productos'),
(4, 'Registrar_Nuevo_Pedido'),
(5, 'Cliente_Pedido'),
(5, 'Consultar_Tablas'),
(5, 'Consultar_Todo'),
(5, 'Lista_Pedidos'),
(5, 'Marcas'),
(5, 'Pedidos_Cliente'),
(5, 'Pedidos_Producto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre_rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre_rol`) VALUES
(1, 'Administrador'),
(4, 'Creador'),
(5, 'Visor');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ims_brand`
--
ALTER TABLE `ims_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ims_category`
--
ALTER TABLE `ims_category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indices de la tabla `ims_customer`
--
ALTER TABLE `ims_customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `icodcli` (`id`);

--
-- Indices de la tabla `ims_order`
--
ALTER TABLE `ims_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `ims_product`
--
ALTER TABLE `ims_product`
  ADD PRIMARY KEY (`pid`);

--
-- Indices de la tabla `ims_purchase`
--
ALTER TABLE `ims_purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indices de la tabla `ims_supplier`
--
ALTER TABLE `ims_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indices de la tabla `ims_user`
--
ALTER TABLE `ims_user`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `mov_ped`
--
ALTER TABLE `mov_ped`
  ADD KEY `numped` (`numped`),
  ADD KEY `pid` (`pid`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD KEY `codcli` (`codcli`),
  ADD KEY `numped` (`numped`),
  ADD KEY `fecha` (`fecha_ped`);

--
-- Indices de la tabla `permisos_roles`
--
ALTER TABLE `permisos_roles`
  ADD PRIMARY KEY (`id_rol`,`permiso`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_rol` (`nombre_rol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ims_brand`
--
ALTER TABLE `ims_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `ims_category`
--
ALTER TABLE `ims_category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `ims_customer`
--
ALTER TABLE `ims_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `ims_order`
--
ALTER TABLE `ims_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `ims_product`
--
ALTER TABLE `ims_product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ims_purchase`
--
ALTER TABLE `ims_purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `ims_supplier`
--
ALTER TABLE `ims_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ims_user`
--
ALTER TABLE `ims_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `mov_ped`
--
ALTER TABLE `mov_ped`
  ADD CONSTRAINT `mov_ped_ibfk_1` FOREIGN KEY (`numped`) REFERENCES `pedido` (`numped`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `permisos_roles`
--
ALTER TABLE `permisos_roles`
  ADD CONSTRAINT `permisos_roles_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
