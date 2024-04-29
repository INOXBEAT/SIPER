-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2024 a las 17:08:37
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
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalleproducto_proveedor`
--

CREATE TABLE `detalleproducto_proveedor` (
  `id` int(11) NOT NULL,
  `idProveedor` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `vendedor` int(11) NOT NULL,
  `producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `precio_total` decimal(10,2) NOT NULL,
  `forma_pago` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `cantidad` int(10) NOT NULL,
  `precio` decimal(65,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `cantidad`, `precio`) VALUES
(1, 'colores', 'caja x 24', 99, 5000),
(2, 'lapicero bic negro', 'caja x 24', 220, 550),
(4, 'plastilina', 'caja x 24', 65, 450),
(5, 'crayolas', 'caja x 24', 100, 750),
(6, 'colbon', '100ml', 46, 650),
(7, 'lapiz rojo', 'caja x 12', 99, 200),
(8, 'papel cartón', 'resma x 50', 396, 150),
(9, 'tempera', 'caja x 6', 20, 7000),
(10, 'cuaderno cuadriculado cocido', '100 hojas', 200, 8000),
(12, 'cuaderno ferrocarríl cocido', '50 hojas', 23, 4500),
(13, 'carpeta plastica tamaño carta', 'colores variados', 50, 550),
(14, 'clip', 'caja x 100', 30, 400),
(15, 'bloc cuadriculado', '50 hojas', 35, 3200),
(17, 'cartulina negra por octavos', 'resma x 50', 200, 200),
(18, 'cuaderno cuadriculado argollado', '100 hojas', 50, 8000),
(19, 'resaltador', 'colores variados', 45, 500),
(20, 'corrector', 'tipo lapicero', 20, 650),
(21, 'sobre de manila', 'tamaño oficio', 50, 150),
(23, 'lapicero', 'color rojo', 25, 500),
(24, 'limpiapipas', 'colores variados', 100, 300),
(25, 'pincel', 'calibre 5mm', 20, 1200),
(26, 'regla', '30 cms', 50, 450),
(27, 'plumón', 'caja de 12 colores', 50, 4800),
(28, 'cinta métrica', '100 cms', 25, 650),
(29, 'cuaderno ', 'cuadriculado grande 100 hojas', 50, 10000),
(30, 'papel mantequilla', 'resma x 50', 20, 100),
(31, 'papel carbón', 'sobre x 50', 19, 100),
(32, 'calculadora', 'científica', 19, 20000),
(33, 'escarcha', 'caja x 12', 50, 1000),
(35, 'papel bond', 'resma x 100', 39, 3500),
(36, 'marcador', 'caja x 24', 238, 5000),
(37, 'chinches', 'caja x 50', 8, 450),
(38, 'pliego de cartulina', 'rollo x 100', 200, 250);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedor`
--

CREATE TABLE `proveedor` (
  `id` int(11) NOT NULL,
  `contacto` varchar(250) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `proveedor` varchar(250) NOT NULL,
  `estado` enum('1','2','3','4') NOT NULL,
  `telefono` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `proveedor`
--

INSERT INTO `proveedor` (`id`, `contacto`, `direccion`, `proveedor`, `estado`, `telefono`) VALUES
(1, 'Santiago Rendón', 'Libertades 123, Ciudad Central', 'Papelmania S.A.', '1', '(555) 123-4567'),
(2, 'Rocío Jimenez', 'Calle Primavera 456, Barrio Flores', 'Suministros Escolares López', '1', '(555) 987-6543'),
(3, 'Carolina Paez', 'Av. Revolución 789, Colonia Moderna', 'Distribuidora Papel & Más', '1', '(555) 321-7890'),
(5, 'María Sepúlveda', 'Av. Benito Juárez 1234, Colonia Vista Hermosa', 'Papelería El Libro Abierto', '1', '(555) 890-1234'),
(7, 'Felipe García', 'Carrera 100 # 20 - 51', 'Papeles Nacionales S.A.S', '1', '(555) 430-0425'),
(8, 'Carolina Herrera', 'Avenida 34 # 25 - 10', 'Insumos para papelerias García Márquez S.A.S ', '1', '(555) 252 - 1564');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `password`, `nombre`, `tipo_usuario`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Administrador', 1),
(2, 'usuario', 'b665e217b51994789b02b1838e730d6b93baa30f', 'Usuario Estandar', 2),
(7, 'test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'Desarrollador', 1),
(10, 'asistente', '55e5b6b1299763ee823c9648c03637dac1235563', 'Secretaria', 1),
(11, 'vendedor', '88d6818710e371b461efff33d271e0d2fb6ccf47', 'Asesor Comercial', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalleproducto_proveedor`
--
ALTER TABLE `detalleproducto_proveedor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detalleproducto_proveedor_ibfk_2` (`idProveedor`),
  ADD KEY `detalleproducto_porveedor_ibfk_1` (`idProducto`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendedor` (`vendedor`),
  ADD KEY `producto` (`producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `direccion` (`direccion`),
  ADD UNIQUE KEY `direccion_2` (`direccion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalleproducto_proveedor`
--
ALTER TABLE `detalleproducto_proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `proveedor`
--
ALTER TABLE `proveedor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalleproducto_proveedor`
--
ALTER TABLE `detalleproducto_proveedor`
  ADD CONSTRAINT `detalleproducto_porveedor_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `detalleproducto_proveedor_ibfk_2` FOREIGN KEY (`idProveedor`) REFERENCES `proveedor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`vendedor`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`producto`) REFERENCES `productos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
