<?php
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php?accion=logincliente");
    exit();
}

require_once 'Modelo/verProductos.php';
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : '';
$productos = obtenerProductos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=vista">Inicio</a>
            <a href="index.php?accion=vista">Catálogo</a>
        </nav>
    </header>

    <section>
        <div class="pedido">
            <h2>Solicitud de Compra</h2>
            <p><strong>Registro de Pedido: </strong></p>
            <form action="index.php?accion=crearPedido" method="post">
                <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($id_usuario); ?>">
                <label for="id_producto">Producto:</label>
                <select name="id_producto" id="id_producto" required>
                    <option value="">Selecciona un producto</option>
                    <?php foreach ($productos as $prod): ?>
                        <option value="<?php echo $prod['id']; ?>">
                            <?php echo htmlspecialchars($prod['nombre']) . " - Talla: " . htmlspecialchars($prod['talla']) . " - $" . htmlspecialchars($prod['precio']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="cantidad" placeholder="Cantidad" min="1" required>
                <input type="date" name="fecha" required>
                <input type="hidden" name="estado" value="Solicitado">
                <button type="submit">Realizar Pedido</button>
            </form>
            <a href="index.php?accion=logout">Cerrar Sesion</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>