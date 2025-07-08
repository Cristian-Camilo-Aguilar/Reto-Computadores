<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: index.php?accion=loginadmin");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos Clientes</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="Vista/js/script.js"></script>
</head>
<body>
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=admin">Inicio</a>
            <a href="index.php?accion=categorias">Categorias</a>
            <a class="activa" href="index.php?accion=pedidosclientes">Pedidos</a>
            <a href="index.php?accion=dashboard">Estadisticas</a>
            <a href="index.php?accion=logout">Cerrar Sesion</a>
        </nav>
    </header>
    <section>
        <div class="admin-section">
            <h3>Pedidos</h3>
            <?php
                require_once 'Modelo/verPedidos.php';
                $pedidos = obtenerPedidos();
            ?>
            <table>
                <thead>
                <tr>
                    <th>ID Pedido</th>
                    <th>Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Cambiar Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($pedidos) {
                    for ($i = 0; $i < count($pedidos); $i++) {
                        ?>
                        <tr>
                            <td><?php echo $pedidos[$i]['id']; ?></td>
                            <td><?php echo $pedidos[$i]['cliente']; ?></td>
                            <td><?php echo $pedidos[$i]['producto']; ?></td>
                            <td><?php echo $pedidos[$i]['cantidad']; ?></td>
                            <td><?php echo $pedidos[$i]['fecha']; ?></td>
                            <td><?php echo $pedidos[$i]['estado']; ?></td>
                            <td>
                                <select class="estadoPedido" data-id="<?php echo $pedidos[$i]['id']; ?>">
                                    <option value="Pendiente" <?php echo $pedidos[$i]['estado'] == 'Pendiente' ? 'selected' : ''; ?>>Pendiente</option>
                                    <option value="Enviado" <?php echo $pedidos[$i]['estado'] == 'Enviado' ? 'selected' : ''; ?>>Enviado</option>
                                    <option value="Cancelado" <?php echo $pedidos[$i]['estado'] == 'Cancelado' ? 'selected' : ''; ?>>Cancelado</option>
                                    <option value="Solicitado" <?php echo $pedidos[$i]['estado'] == 'Solicitado' ? 'selected' : ''; ?>>Solicitado</option>
                                </select>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>