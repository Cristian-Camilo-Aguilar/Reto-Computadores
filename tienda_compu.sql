-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-07-2025 a las 16:09:44
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
-- Base de datos: `tienda_tenis`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre_categoria`) VALUES
(1, 'Portátiles'),
(2, 'Computadores de escritorio'),
(3, 'Repuestos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_productos`
--

CREATE TABLE `imagenes_productos` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `imagenes_productos`
--

INSERT INTO `imagenes_productos` (`id`, `id_producto`, `nombre_archivo`) VALUES
(1, 1, '1751742098_asus2.png'),
(8, 2, '1751899362_hp1.png'),
(13, 2, '1751899995_hp2.jpeg'),
(15, 3, '1751900400_leno2.png'),
(16, 3, '1751900400_leno.png'),
(18, 1, '1751943776_asus1.png'),
(19, 4, '1751981277_charge2.jpg'),
(20, 4, '1751981277_charge1.png'),
(22, 5, '1751981810_ram2-removebg-preview.png'),
(23, 6, '1751982353_gpu1-removebg-preview.png'),
(24, 6, '1751982353_gpu2-removebg-preview.png'),
(25, 6, '1751982353_gpu3-removebg-preview.png'),
(29, 5, '1751982690_ram3-removebg-preview.png'),
(30, 6, '1751987483_gpu4-removebg-preview.png'),
(31, 7, '1751995702_mouse2.jpg'),
(32, 7, '1751995708_mouse1.jpg'),
(33, 7, '1751995714_mouse3.jpg'),
(34, 8, '1751996993_monitor1.png'),
(35, 8, '1751997031_monitor2.png'),
(36, 9, '1751997895_caja3.png'),
(37, 9, '1751997900_caja1.png'),
(39, 9, '1751997949_caja2.png'),
(40, 10, '1751999056_tecla2.png'),
(41, 10, '1751999061_tecla3.png'),
(42, 10, '1751999066_tecla1.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id`, `id_usuario`, `id_producto`, `cantidad`, `fecha`, `estado`) VALUES
(1, 2, 1, 1, '2025-06-18', 'Cancelado'),
(27, 2, 0, 1, '2025-05-09', 'Solicitado'),
(28, 2, 1, 2, '2025-07-07', 'Enviado'),
(29, 2, 5, 1, '2025-07-08', 'Solicitado'),
(30, 3, 10, 1, '2025-07-08', 'Pendiente'),
(31, 2, 6, 1, '2025-07-09', 'Pendiente'),
(32, 2, 10, 2, '2025-07-09', 'Enviado'),
(33, 2, 9, 1, '2025-07-09', 'Cancelado'),
(34, 2, 8, 1, '2025-07-09', 'Enviado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `marca` varchar(100) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `especificaciones` varchar(255) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `precio`, `marca`, `modelo`, `especificaciones`, `tipo`) VALUES
(1, 'Portátil ASUS Vivobook Go', 1400000.00, 'ASUS', '2025', 'Procesador: Intel Core i3 Memoria RAM: 8GB Capacidad de almacenamiento: 512 GB Tamaño de la pantalla: 15 Marca tarjeta gráfica: Integrada', 1),
(2, 'PORTATIL CORPORATIVO HP PROBOOK', 3000000.00, 'HP', '2024', 'Procesador: Intel Core i5  1355U Gráficos: TARJETA DE VIDEO GEFORCE RTX 2050 4G DDR6  Conjunto de chips: Plataforma Intel SoC Memoria RAM:  32 GB DDR4-3200 Almacenamiento: SSD de UN TERA  M.2 2242 PCIe 4.0×4 NVMe Pantalla: 14″ FHD (1920 x 1080) TN 250 nit', 1),
(3, 'Portátil Lenovo IDEAPAD', 2500000.00, 'Lenovo', 'IdeaPad Slim 3', 'Procesador: Intel Core I5 Memoria RAM: 16GB Unidad de estado sólido SSD: 512GB Resolución de la pantalla: FHD (1.920 x 1.080) Tamaño de la pantalla: 15.6 pulgadas Disco duro HDD: No aplica Núcleos del procesador: Octa core Memoria total (RAM + Intel Optan', 1),
(4, 'Cargador Para Portátil Jaltech Punta Aguja', 65000.00, 'HP', 'HP Pavilion DMI1, DM3 Series', 'VOLTAJE	:19.5V  Amperaje:  2.31A  Conector de Salida: 7.4*5.0', 3),
(5, 'Memoria Ram Kingston', 45500.00, 'Kingston', 'LINEA DDR3', 'Capacidad total: 4 GB Tipo de memoria: RAM DDR3 SDRAM Formato de la memoria: RAM UDIMM Velocidad de la memoria: RAM 1,33 GHz Con memoria gráfica ECC: No', 3),
(6, 'Tarjeta Gráfica VBESTLIFE RX 580', 808489.00, 'Vbestlife', 'Vbestlife3fca4bxzmt7761', 'Dimensiones del paquete:11,81 x 7,8 x 3,03 pulgadas (30 x 19,8 x 7,7 cm) Peso del artículo:1,96 libras (890 gramos) Con Procesador Gráfico:AMD Radeon RX 580  Ram Tamaño: 8 GB Velocidad del reloj de la GPU	1284 MHz Interfaz de salida de video:DisplayPort, ', 3),
(7, 'Mouse de Bluetooth', 68900.00, 'HP', '2025', 'Peso: 0,0542 kg Dimensiones mínimas (anch. x prof. x alt.): 107 x 60,5 x 29,31 mm Contenido de la caja: Mouse inalámbrico; 1 batería AA; ', 3),
(8, 'Monitor de Juegos Curvo', 770900.00, 'CRUA', 'CR270C', 'Color: Negro mate Patrón de montaje VESA	100 x 100 Velocidad de actualización: 180 Hz Brillo: 280 Nits Relación de aspecto: 16: 9 Rango de Relación de Contraste: 3000: 1 Entradas y salidas	DP, HDMI, AUDIO, DC Profundidad (sin soporte)	0.31 en ( 0.8 cm ) P', 2),
(9, 'Gabinete Gamer Antec', 500000.00, ' Antec', 'CX300 ARGB', 'Tipo de estructura: Mid tower Puertos: Hd-audio, Led control button, Mic, Power, Usb2.0 x 2, Usb3.0 x 1 Bahías 3.5 in Materiales de la caja: Acero, Vidrio templado Placas madre: compatibles ATX, ITX, Micro-ATX Accesorios incluidos: 4 ventiladores ARGB Alt', 2),
(10, 'Teclado Gamer Corsair', 517000.00, ' Corsair', ' K65', 'Color de la retroiluminación: RGB Layout QWERTY Tipo de switch: Cherry MX Speed RGB Arquitectura: Mecánico Tipo de conector: USB 3.0 ', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('admin','cliente') NOT NULL DEFAULT 'cliente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `correo`, `contrasena`, `rol`) VALUES
(1, 'cristian', 'ca6918950@gmail.com', '$2y$10$f/uyMJrSoBNUETql4EQKDO5ajF3bse3zxYX6oLLpguSgIK1vi4EZe', 'admin'),
(2, 'camila', 'camila@gmail.com', '$2y$10$JEAJ5kbAVq5R0B.xfN5z2ejf4/uAosZ8uadzZjcK8HkskBrjrxU7a', 'cliente'),
(3, 'freyder', 'freyder@gmail.com', '$2y$10$DVo4zmGTFuNhVyf46L.oy.3t2/HGRDsQy3fDm7Eh6jMYNMLBW5xnm', 'cliente'),
(4, 'yan', 'yan@gmail.com', '$2y$10$Rorgkzpzxq0BwFD5C8opAeuWqzbNm2lOmgzt5/6win96CGeV6xtrq', 'cliente');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tipo_categoria` (`tipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `imagenes_productos`
--
ALTER TABLE `imagenes_productos`
  ADD CONSTRAINT `imagenes_productos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_tipo_categoria` FOREIGN KEY (`tipo`) REFERENCES `categorias` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
