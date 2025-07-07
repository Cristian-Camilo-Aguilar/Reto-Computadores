<?php
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php?accion=logincliente");
    exit();
}

require_once 'Modelo/verProductos.php';
require_once 'Modelo/Conexion.php';

$id_usuario = $_SESSION['id_usuario'];
$productos = obtenerProductos();
$carrito_ids = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];

// Filtrar productos en el carrito
$carrito_productos = array_filter($productos, function($prod) use ($carrito_ids) {
    return in_array($prod['id'], $carrito_ids);
});

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=pedido">Catálogo</a>
            <a href="index.php?accion=pedidosrealizados">Mis Pedidos</a>
            <a href="index.php?accion=carrito">Carrito</a>
            <a href="index.php?accion=vaciarCarrito">Vaciar Carrito</a>
            <a href="index.php?accion=logout">Cerrar Sesión</a>
        </nav>
    </header>

    <section class="carrito">
        <h2 style="text-align:center;">Mi Carrito de Compras</h2>
        <?php if (count($carrito_productos) > 0): ?>
            <?php foreach ($carrito_productos as $prod): ?>
                <div class="carrito-card">
                    <h3><?php echo htmlspecialchars($prod['nombre']); ?></h3>
                    <p>Marca: <?php echo htmlspecialchars($prod['marca']); ?></p>
                    <p>Modelo: <?php echo htmlspecialchars($prod['modelo']); ?></p>
                    <p>Precio: $<?php echo htmlspecialchars($prod['precio']); ?></p>
                    <!-- Aquí puedes agregar cantidad o eliminar del carrito si gustas -->
                </div>
            <?php endforeach; ?>
            <div style="text-align:center;">
                <form action="index.php?accion=confirmarPedido" method="post">
                    <button type="submit">Confirmar Compra</button>
                </form>
            </div>
        <?php else: ?>
            <p style="text-align:center;">Tu carrito está vacío.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>