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

// filtrar productos en el carrito según los ID
$carrito_productos = array_filter($productos, function($prod) use ($carrito_ids) {
    return array_key_exists($prod['id'], $carrito_ids);
});


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header>
        <br><h1>Tienda de Computadores Y Respuestos</h1><br>
        <nav>
            <a href="index.php?accion=pedido">Catálogo</a>
            <a href="index.php?accion=pedidosrealizados">Mis Pedidos</a>
            <a class="activa" href="index.php?accion=carrito">Mi Carrito</a>
            <a href="index.php?accion=vaciarCarrito">Vaciar Carrito</a>
            <a href="index.php?accion=logout">Cerrar Sesión</a>
        </nav>
    </header>

    <section>
        <div class="container">
            <h2 class="text-center mt-4 mb-5">Mi Carrito de Compras</h2>
            <?php if (count($carrito_productos) > 0): ?>
                <div class="row">
                    <?php foreach ($carrito_productos as $index => $prod): ?>
                        <div class="col-md-6 col-sm-12 mb-4">
                            <div class="card carrito-card p-3 shadow-sm">
                                <h4 class="mb-2"><?php echo htmlspecialchars($prod['nombre']); ?></h4>
                                <p><strong>Marca:</strong> <?php echo htmlspecialchars($prod['marca']); ?></p>
                                <p><strong>Modelo:</strong> <?php echo htmlspecialchars($prod['modelo']); ?></p>
                                <p><strong>Precio:</strong> $<?php echo htmlspecialchars($prod['precio']); ?></p>
                                <p><strong>Cantidad solicitada:</strong> <?php echo $_SESSION['carrito'][$prod['id']]; ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="text-center mt-4">
                    <form action="index.php?accion=confirmarPedido" method="post">
                        <button type="submit" class="btnaggProdu">Confirmar Compra</button>
                    </form>
                </div>
            <?php else: ?>
                <p class="text-center">Tu carrito está vacío.</p>
            <?php endif; ?>
        </div>
    </section>


    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>