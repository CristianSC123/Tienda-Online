-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2024 a las 05:49:29
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
-- Base de datos: `tienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `token_password` varchar(40) DEFAULT NULL,
  `password_request` tinyint(4) NOT NULL DEFAULT 0,
  `activo` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `password`, `nombre`, `email`, `token_password`, `password_request`, `activo`, `fecha_alta`) VALUES
(1, 'admin', '$2y$10$QJrR.dyWG6EjUMIsugo0d.YUl9zaxR3SmYe63vgRZ8nRyjeb7RVYG', 'Administrador', 'jhonataasantacruz@gmail.com', NULL, 0, 1, '2024-04-25 18:45:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`) VALUES
(1, 'Ropa', 0),
(2, 'Electrodomesticos', 0),
(3, 'Calzados', 0),
(4, 'Electronica', 0),
(5, 'Vehiculos', 0),
(6, 'Motores', 1),
(7, 'Sensores', 1),
(8, 'Microcontroladores', 1),
(9, 'Placas', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombres` varchar(80) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `ci` varchar(20) NOT NULL,
  `estatus` tinyint(4) NOT NULL,
  `fecha_alta` datetime NOT NULL,
  `fecha_modifica` datetime NOT NULL,
  `fecha_baja` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombres`, `apellidos`, `email`, `telefono`, `ci`, `estatus`, `fecha_alta`, `fecha_modifica`, `fecha_baja`) VALUES
(3, 'Marvin', 'Salvador', 'marvincortezaranda@gmail.com', '74034550', '123456', 1, '2024-04-26 10:37:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Jair', 'Santa Cruz', 'jaairsantacruz@gmail.com', '65678474', '13693494', 1, '2024-04-29 16:45:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Cristian', 'Santa Cruz', 'cristiaansantacruz@gmail.com', '65673891', '13693493', 1, '2024-04-29 17:03:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Diego', 'Lucana', 'neodotas@gmail.com', '12346578', '147852', 1, '2024-05-01 21:30:28', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Jhonatan', 'Laura', 'jhonataansantacruz@gmail.com', '65673891', '13693493', 1, '2024-05-15 10:12:57', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra`
--

CREATE TABLE `compra` (
  `id` int(11) NOT NULL,
  `id_transaccion` varchar(20) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `email` varchar(60) NOT NULL,
  `id_cliente` varchar(20) NOT NULL,
  `ciudad_envio` varchar(20) DEFAULT NULL,
  `direccion_envio` varchar(50) DEFAULT NULL,
  `nro_puerta` varchar(4) DEFAULT NULL,
  `id_courier` int(5) DEFAULT NULL,
  `estado_envio` varchar(20) NOT NULL DEFAULT 'no enviado',
  `fecha_envio` datetime NOT NULL,
  `medio_pago` varchar(20) NOT NULL,
  `totalUSD` decimal(10,2) NOT NULL,
  `totalBOB` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `compra`
--

INSERT INTO `compra` (`id`, `id_transaccion`, `fecha`, `status`, `email`, `id_cliente`, `ciudad_envio`, `direccion_envio`, `nro_puerta`, `id_courier`, `estado_envio`, `fecha_envio`, `medio_pago`, `totalUSD`, `totalBOB`) VALUES
(93, '2CP51545RP112611M', '2024-05-15 11:16:48', 'COMPLETED', 'cristiaansantacruz@gmail.com', '13', 'La Paz', 'Avenida alfonso ugarte Zona 16 de julio', '12', NULL, 'Procesando pedido', '0000-00-00 00:00:00', 'paypal', 3355.30, 23140.00),
(94, '35448535XC201680K', '2024-05-17 10:28:48', 'COMPLETED', 'jhonataansantacruz@gmail.com', '15', 'La Paz', 'Alfonso ugarte zona 16 de julio', '95', 9, 'enviado', '2024-05-17 10:43:08', 'paypal', 1396.35, 9630.00),
(95, '8MX52900AW820654U', '2024-05-20 08:52:39', 'COMPLETED', 'jhonataansantacruz@gmail.com', '15', 'La Paz', 'Avenida Alfonso Ugarte', '95', NULL, 'Procesando pedido', '0000-00-00 00:00:00', 'paypal', 1350.68, 9315.03),
(96, '2B316241GN690032D', '2024-05-20 08:55:45', 'COMPLETED', 'jhonataansantacruz@gmail.com', '15', 'Oruro', 'ejemplo', '125', NULL, 'Procesando pedido', '0000-00-00 00:00:00', 'paypal', 92.80, 640.00),
(97, '3VL01472F89088925', '2024-05-20 09:06:11', 'COMPLETED', 'jhonataansantacruz@gmail.com', '15', 'La Paz', 'Zona 16 de julio Avenida Alfonso ugarte', '95', 9, 'enviado', '2024-05-20 09:07:52', 'paypal', 1350.68, 9315.03),
(98, '8W435166LP9146849', '2024-06-09 23:02:51', 'COMPLETED', 'cristiaansantacruz@gmail.com', '13', 'La Paz', 'Alfonso Ugarte', '95', NULL, 'Procesando pedido', '0000-00-00 00:00:00', 'paypal', 11.60, 80.00),
(99, '27C44794T0327045G', '2024-06-09 23:05:11', 'COMPLETED', 'jhonataansantacruz@gmail.com', '15', 'La Paz', 'Alfonso Ugarte', '95', NULL, 'Procesando pedido', '0000-00-00 00:00:00', 'paypal', 2.90, 20.00),
(100, '39573658B23268541', '2024-06-10 00:33:54', 'COMPLETED', 'cristiaansantacruz@gmail.com', '13', 'La Paz', 'Alfonso Ugarte', '95', 11, 'entregado', '2024-06-10 01:00:56', 'paypal', 30.45, 210.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `valor` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `valor`) VALUES
(1, 'tienda_nombre', 'Mi Tienda Online'),
(2, 'correo_email', 'csantacruz@womenspeedup.com'),
(3, 'correo_smtp', 'mail.womenspeedup.com'),
(4, 'correo_password', '3YWD/j4HWtCrYl0Y6K3j0Q==:e/OJpS7z7g0ALZlJV9IeGw=='),
(9, 'correo_puerto', '465');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `couriers`
--

CREATE TABLE `couriers` (
  `id` int(11) NOT NULL,
  `carnet` varchar(15) DEFAULT NULL,
  `nombre` varchar(50) NOT NULL,
  `celular` varchar(8) NOT NULL,
  `empresa` varchar(50) DEFAULT NULL,
  `activo` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `couriers`
--

INSERT INTO `couriers` (`id`, `carnet`, `nombre`, `celular`, `empresa`, `activo`) VALUES
(9, '13693494', 'Juan Pérez', '71234567', 'ABC Company', 1),
(10, NULL, 'María García', '62876543', 'XYZ Corporation', 1),
(11, NULL, 'Carlos Rodríguez', '71234568', 'PQR Enterprises', 1),
(12, NULL, 'Ana López', '62765432', 'DEF Industries', 0),
(13, '13241241', 'Felipe Huanca', '79614331', NULL, 1),
(14, '136934934', 'Jair', '62472211', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `id` int(11) NOT NULL,
  `nombre_departamento` varchar(50) NOT NULL,
  `costo` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`id`, `nombre_departamento`, `costo`) VALUES
(1, 'La Paz', 5.00),
(2, 'Oruro', 10.00),
(3, 'Potosí', 20.00),
(4, 'Cochabamba', 15.00),
(5, 'Chuquisaca', 25.00),
(6, 'Tarija', 30.00),
(7, 'Santa Cruz', 35.00),
(8, 'Beni', 40.00),
(9, 'Pando', 50.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(50) NOT NULL,
  `id_producto` int(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `id_compra`, `id_producto`, `nombre`, `precio`, `cantidad`) VALUES
(1, 76, 2, 'Laptop', 4200.00, 1),
(2, 77, 16, 'Laptop Windows 11', 9310.00, 1),
(3, 78, 1, 'Zapatos', 315.00, 4),
(4, 78, 16, 'Laptop Windows 11', 9310.00, 2),
(5, 78, 17, 'Pantalon de mezclilla', 190.00, 1),
(6, 79, 1, 'Zapatos', 315.00, 1),
(7, 80, 17, 'Pantalon de mezclilla', 190.00, 4),
(8, 81, 1, 'Zapatos', 315.00, 1),
(9, 82, 1, 'Zapatos', 315.00, 1),
(10, 83, 1, 'Zapatos', 315.00, 1),
(11, 84, 19, 'Chaqueta Negra Talla M', 170.00, 1),
(12, 85, 2, 'Laptop', 4200.00, 1),
(13, 86, 3, 'Celular', 2700.00, 1),
(14, 87, 2, 'Laptop', 4200.00, 1),
(15, 87, 3, 'Celular', 2700.00, 1),
(16, 88, 1, 'Zapatos', 315.00, 1),
(17, 88, 2, 'Laptop', 4200.00, 1),
(18, 88, 3, 'Celular', 2700.00, 1),
(19, 88, 16, 'Laptop Windows 11', 9310.00, 1),
(20, 88, 19, 'Chaqueta Negra Talla M', 170.00, 1),
(21, 89, 3, 'Celular', 2700.00, 1),
(22, 90, 3, 'Celular', 2700.00, 1),
(23, 90, 2, 'Laptop', 4200.00, 1),
(24, 91, 16, 'Laptop Windows 11', 9310.00, 1),
(25, 91, 19, 'Chaqueta Negra Talla M', 170.00, 1),
(26, 92, 1, 'Zapatos', 315.00, 1),
(27, 93, 1, 'Zapatos', 315.00, 1),
(28, 93, 2, 'Laptop', 4200.00, 1),
(29, 93, 16, 'Laptop Windows 11', 9310.00, 2),
(30, 94, 16, 'Laptop Windows 11', 9310.00, 1),
(31, 94, 1, 'Calzado para varon 100% cuero', 315.00, 1),
(32, 95, 16, 'Laptop Windows 11', 9310.00, 1),
(33, 96, 1, 'Calzado para varon 100% cuero', 315.00, 2),
(34, 97, 16, 'Laptop Windows 11', 9310.00, 1),
(35, 98, 23, 'Arduino Uno', 75.00, 1),
(36, 99, 22, 'Motor DC', 15.00, 1),
(37, 100, 22, 'Motor DC', 15.00, 2),
(38, 100, 23, 'Arduino Uno', 75.00, 1),
(39, 100, 24, 'Arduino nano', 50.00, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `descuento` tinyint(2) NOT NULL DEFAULT 0,
  `stock` int(11) NOT NULL DEFAULT 0,
  `id_categoria` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `precio`, `descuento`, `stock`, `id_categoria`, `activo`) VALUES
(1, 'Calzado para varon 100% cuero', '<p>Calzado importado desde Italia con la mas alta calidad en estandares</p>', 350.00, 10, 15, 3, 0),
(2, 'Laptop', 'Laptop', 4200.00, 0, 5, 1, 0),
(3, 'Celular', 'Celular', 2700.00, 0, 10, 1, 0),
(9, 'Control de Tv', 'Control de Tv Samsung', 55.00, 0, 10, 2, 0),
(16, 'Laptop Windows 11', '<p><strong>RAM Ampliable:</strong> Mejora el rendimiento multitarea con RAM ampliable para una experiencia fluida y sin interrupciones.</p><p><strong>Tarjeta de Video Potente:</strong> Disfruta de gráficos impresionantes y juegos fluidos con una tarjeta de video de alto rendimiento.</p><p><strong>Disco Duro de Alta Velocidad:</strong> Almacenamiento rápido en SSD para tiempos de carga rápidos y una mayor capacidad de almacenamiento.</p><p><strong>Conectividad Versátil:</strong> Puertos USB-C, HDMI y Bluetooth para una conectividad sin cables y la posibilidad de conectar dispositivos externos fácilmente.</p>', 9500.00, 2, 5, 2, 0),
(17, 'Pantalon de mezclilla', '<p><i><strong>Caracteristicas</strong></i></p><ul><li>Material 100% algodon</li><li>Tiro medio</li><li>Corte recto</li></ul>', 190.00, 0, 0, 1, 0),
(19, 'Chaqueta Negra Talla M', '<p>Chaqueta 100% cuero</p>', 170.00, 0, 2, 1, 0),
(21, 'Motor Brushless 2200kv', '<p>Potencia y eficiencia en un solo motor. Perfecto para drones y modelos de alta velocidad. Este motor brushless de 2200kV ofrece rendimiento superior y durabilidad. ¡Desata la velocidad!</p><p><strong>Aspectos Técnicos:</strong></p><ul><li>KV (RPM por Voltio): 2200kV</li><li>Tipo: Brushless (sin escobillas)</li><li>Eficiencia: Alta eficiencia energética</li><li>Aplicaciones: Drones, UAVs, Modelismo</li><li>Peso: Ligero para un mejor rendimiento</li></ul>', 100.00, 0, 15, 6, 1),
(22, 'Motor DC', '<p>Versátil y fiable, el Motor DC es ideal para tus proyectos de robótica y automatización. Compacto y potente, asegura un control preciso y eficiente. ¡Impulsa tus ideas con confianza!</p><p><strong>Aspectos Técnicos:</strong></p><ul><li>Tipo: Motor de Corriente Continua (DC)</li><li>Voltaje de Operación: 6V - 12V</li><li>Velocidad: Variable con control de voltaje</li><li>Aplicaciones: Robótica, Automatización, Pequeños dispositivos electrónicos</li><li>Construcción: Compacto y Duradero</li></ul>', 15.00, 0, 27, 6, 1),
(23, 'Arduino Uno', '<p>El Arduino Uno es la plataforma perfecta para tus proyectos electrónicos. Fácil de usar y versátil, con 14 pines digitales, 6 entradas analógicas y un puerto USB. ¡Empieza a crear hoy mismo!</p><p><strong>Aspectos Técnicos:</strong></p><ul><li>Microcontrolador: ATmega328P</li><li>Pines Digitales I/O: 14 (6 PWM)</li><li>Entradas Analógicas: 6</li><li>Velocidad del Reloj: 16 MHz</li><li>Conexión: USB tipo B</li><li>Voltaje de Operación: 5V</li></ul>', 75.00, 0, 13, 9, 1),
(24, 'Arduino nano', '<p>Compacto pero poderoso, el Arduino Nano es ideal para proyectos donde el espacio es limitado. Con 14 pines digitales y 8 entradas analógicas, lleva tus ideas al siguiente nivel con facilidad.</p><p><strong>Aspectos Técnicos:</strong></p><ul><li>Microcontrolador: ATmega328</li><li>Pines Digitales I/O: 14 (6 PWM)</li><li>Entradas Analógicas: 8</li><li>Velocidad del Reloj: 16 MHz</li><li>Conexión: Mini USB</li><li>Voltaje de Operación: 5V</li></ul>', 50.00, 0, 33, 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(30) NOT NULL,
  `password` varchar(120) NOT NULL,
  `activacion` int(11) NOT NULL DEFAULT 1,
  `token` varchar(40) NOT NULL,
  `token_password` varchar(40) DEFAULT NULL,
  `password_request` int(11) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `activacion`, `token`, `token_password`, `password_request`, `id_cliente`) VALUES
(3, 'Marv', '$2y$10$5kOGaczqeW7Raepe8eNOkejD4MiUzmMp1m8FWp1RnwtlCuN1gPXHK', 1, '1c09b8f1db1decf32c66172d21818e7b', NULL, 0, 3),
(6, 'Jailito', '$2y$10$ahDDOtj7cfhYihmfTZhIs.eJYtdxF2dJV5OyB54HkMwHiu3nYGV8a', 0, '59c5ebcba674797fa45b6c40135ffe95', NULL, 0, 6),
(9, 'Criss', '$2y$10$JEx8.qdM.4/K6Bpqr8s3U.2t7eWrzPq/wdAfNDZAAWvoQEz8fdoEy', 1, '8cc67f635b831bcdd05505648238ddb5', '52a13fd3bf53b4dad8d48ab9d49e8cbb', 1, 13),
(10, 'Diego', '$2y$10$hyJ4mk47jRJ8xMLn68dqaeQ8K5OKN0TJpPA.fd34mKU8MoFUg2k0y', 1, 'b216a2c7808450e572e8b432d2fd70f6', NULL, 0, 14),
(11, 'Jhonatan', '$2y$10$afMSulj07yf8s/77gr8FFucVKcSAsa7V7ceZY913ANG5hUaoVStbS', 1, 'f989b818c0019eca599ad20df04d848c', NULL, 0, 15);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compra`
--
ALTER TABLE `compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `couriers`
--
ALTER TABLE `couriers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `compra`
--
ALTER TABLE `compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `couriers`
--
ALTER TABLE `couriers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
