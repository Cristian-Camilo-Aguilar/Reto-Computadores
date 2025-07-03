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
    <title>Admin</title>
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
            <a href="index.php?accion=pedidosclientes">Pedidos</a>
            <a href="index.php?accion=logout">Cerrar Sesion</a>
        </nav>
    </header>

    <section id="panel-admin">
    <h2>Panel de Administración</h2>

        <div class="admin-section">
        <h2>Productos</h2>
        <h5>Agregar Productos</h5>
        <?php
            require_once 'Modelo/verCategorias.php';
            $categorias = obtenerCategorias();
        ?>
        <form action="index.php?accion=crearProducto" class="form-admin" method="post" enctype="multipart/form-data">
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <input type="number" name="precio" placeholder="Precio" required>
            <input type="text" name="descripcion" placeholder="Talla" required>
            <select name="id_categoria" required>
                <option value="">Seleccionar categoría</option>
                <?php
                foreach ($categorias as $cat) {
                    echo '<option value="' . $cat['id'] . '">' . htmlspecialchars($cat['nombre']) . '</option>';
                }
                ?>
            </select>
            <input type="text" name="marca" placeholder="Marca" required>
            <input type="text" name="modelo" placeholder="Modelo" required>
            <input type="text" name="tipo" placeholder="Tipo" required>
            <input type="text" name="especificaciones" placeholder="Especificaciones" required>
            <input type="file" name="cover" class="upload">
            <button type="submit">Guardar Producto</button>
        </form>
        <h5>Productos Registrados</h5>
        <?php
            require_once 'Modelo/verProductos.php';
            $productos = obtenerProductos();
        ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Talla</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($productos) {
                for ($i = 0; $i < count($productos); $i++) {
                    ?>
                    <tr>
                        <td><?php echo $productos[$i]['id']; ?></td>
                        <td><?php echo $productos[$i]['nombre']; ?></td>
                        <td><?php echo $productos[$i]['categoria']; ?></td>
                        <td><?php echo $productos[$i]['precio']; ?></td>
                        <td><?php echo $productos[$i]['talla']; ?></td>
                        <td>
                            <button>Editar</button>
                            <button type="button" onclick="eliminarProducto(<?php echo $productos[$i]['id']; ?>)">Eliminar</button>
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