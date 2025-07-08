<?php
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php?accion=logincliente");
    exit();
}

require_once 'Modelo/verProductos.php';
require_once 'Modelo/verPedidosClientes.php';
require_once 'Modelo/Conexion.php';

$id_usuario = $_SESSION['id_usuario'];
$productos = obtenerProductos();
$pedidoscliente = obtenerPedidosClientes($id_usuario);

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
        <br><h1>Tienda de Computadores Y Respuestos</h1><br>
        <nav>
            <a href="index.php?accion=pedido">Catálogo</a>
            <a class="activa" href="index.php?accion=pedidosrealizados">Mis Pedidos</a>
            <a href="index.php?accion=carrito">Mi Carrito</a>
            <a href="index.php?accion=vaciarCarrito">Vaciar Carrito</a>
            <a href="index.php?accion=logout">Cerrar Sesión</a>
        </nav>
    </header>

    <section>
        <h2 style="text-align:center;">Mis Pedidos Realizados</h2>
        <?php if (!empty($pedidoscliente)): ?>
            <table class="pedido-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidoscliente as $p): ?>
                        <tr>
                            <td><?php echo $p['id']; ?></td>
                            <td><?php echo htmlspecialchars($p['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($p['marca']); ?></td>
                            <td><?php echo htmlspecialchars($p['modelo']); ?></td>
                            <td><?php echo $p['cantidad']; ?></td>
                            <td><?php echo $p['fecha']; ?></td>
                            <td><?php echo $p['estado']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="sin-pedidos">No has realizado ningún pedido aún.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>