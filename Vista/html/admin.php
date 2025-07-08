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
        <br><h1>Tienda de Computadores Y Respuestos</h1><br>
        <nav>
            <a class="activa" href="index.php?accion=admin">Inicio</a>
            <a href="index.php?accion=categorias">Categorias</a>
            <a href="index.php?accion=pedidosclientes">Pedidos</a>
            <a href="index.php?accion=dashboard">Estadisticas</a>
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
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="marca" placeholder="Marca" required>
            <input type="text" name="modelo" placeholder="Modelo" required>
            <input type="number" name="precio" placeholder="Precio" required>
            <input type="text" name="especificaciones" placeholder="Especificaciones" required>
            <select name="tipo" required>
                <option value="">Seleccionar categoría</option>
                <?php 
                foreach ($categorias as $cat) {
                $selected = $categoria == $cat['id'] ? 'selected' : '';
                echo "<option value='{$cat['id']}' $selected>" . htmlspecialchars($cat['nombre_categoria']) . "</option>";
                }
                ?>
            </select>
            <input type="file" name="cover[]" multiple>
            <button type="submit" class="guardarProdu">Guardar Producto</button>
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
                <th>Marca</th>
                <th>Modelo</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Especificaciones</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($productos) {
                for ($i = 0; $i < count($productos); $i++) {
                    ?>
                    <tr>
                        <td><?php echo $productos[$i]['id']; ?></td>
                        <td><?php echo $productos[$i]['marca']; ?></td>
                        <td><?php echo $productos[$i]['modelo']; ?></td>
                        <td><?php echo $productos[$i]['nombre_categoria']; ?></td>
                        <td><?php echo $productos[$i]['precio']; ?></td>
                        <td><?php echo $productos[$i]['especificaciones']; ?></td>
                        <td>
                            <a class="btnmodificar" href="index.php?accion=modificar&id=<?php echo $productos[$i]['id']; ?>">Modificar</a>
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