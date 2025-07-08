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
    <title>Categorias</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="Vista/js/script.js"></script>
</head>
<body>
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=admin">Inicio</a>
            <a class="activa" href="index.php?accion=categorias">Categorias</a>
            <a href="index.php?accion=pedidosclientes">Pedidos</a>
            <a href="index.php?accion=dashboard">Estadisticas</a>
            <a href="index.php?accion=logout">Cerrar Sesion</a>
        </nav>
    </header>
    <section>
        <div class="admin-section">
            <?php
                require_once 'Modelo/verCategorias.php';
                $categorias = obtenerCategorias();
            ?>
            <h3>Categorías</h3>
            <ul>
            <?php
            if ($categorias) {
                for ($i = 0; $i < count($categorias); $i++) {
                    ?>
                    <li>
                        <?php echo $categorias[$i]['nombre_categoria']; ?>
                        <button type="button" class="eliminarCate" onclick="eliminarCategoria(<?php echo $categorias[$i]['id']; ?>)">Eliminar</button>
                    </li>
                    <?php
                }
            }
            ?>
            </ul><br>
            <h4>Agregar Categoría</h4>
            <form action="index.php?accion=crearCategoria" class="form-admin" method="post">
                <input type="text" name="nombre_categoria" placeholder="Nombre de la categoría" required>
                <button type="submit" class="guardarCate">Guardar Categoría</button>
            </form>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>