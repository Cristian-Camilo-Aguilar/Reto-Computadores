<?php
if (!isset($_SESSION['id_usuario'])) {
    header("Location: index.php?accion=logincliente");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script type="text/javascript" src="Vista/js/script.js"></script>
</head>
<body>
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=vista">Inicio</a>
            <a class="activa" href="index.php?accion=vista">Catálogo</a>
            <a href="index.php?accion=logincliente">Login Cliente</a>
            <a href="index.php?accion=loginadmin">Login Admin</a>
        </nav>
    </header>

    <section class="admin-section">
        <?php
        require_once 'Modelo/verProductoPorId.php';
        require_once 'Modelo/verImagenesProducto.php';

        $id = $_SESSION['productoId'] ?? null;
        $producto = $id ? obtenerProductoPorId($id) : null;
        $imagenes = $id ? obtenerImagenesProducto($id) : [];
        ?>

        <h2>Producto #<?php echo $producto['id']; ?></h2>

        <?php if ($producto): ?>
            <div class="producto-detalle">
                <p><strong>Marca:</strong> <?php echo htmlspecialchars($producto['marca']); ?></p>
                <p><strong>Modelo:</strong> <?php echo htmlspecialchars($producto['modelo']); ?></p>
                <p><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['nombre_categoria']); ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?></p>
                <p><strong>Especificaciones:</strong> <?php echo htmlspecialchars($producto['especificaciones']); ?></p>

                <div class="galeria-imagenes">
                    <h3>Imágenes del producto</h3>
                    <?php if ($imagenes): ?>
                        <?php foreach ($imagenes as $img): ?>
                            <img src="uploads/<?php echo $img['nombre_archivo']; ?>" alt="Imagen del producto" class="imagen-producto">
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay imágenes disponibles para este producto.</p>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <p>Producto no encontrado.</p>
        <?php endif; ?>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>