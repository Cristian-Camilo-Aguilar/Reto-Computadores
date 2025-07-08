<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: index.php?accion=loginadmin");
    exit();
}

require_once 'Modelo/verProductos.php';
require_once 'Modelo/verCategorias.php';

$productos = obtenerProductos();
$categorias = obtenerCategorias();
$id_modificar = $_GET['id'] ?? ($_POST['id'] ?? null);
$producto_seleccionado = null;

foreach ($productos as $p) {
    if ($p['id'] == $id_modificar) {
        $producto_seleccionado = $p;
        break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Producto</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
<header>
    <h1>Tienda de Tenis</h1>
    <nav>
        <a href="index.php?accion=admin">Inicio</a>
        <a href="index.php?accion=categorias">Categorías</a>
        <a href="index.php?accion=pedidosclientes">Pedidos</a>
        <a href="index.php?accion=dashboard">Estadisticas</a>
        <a href="index.php?accion=logout">Cerrar Sesión</a>
    </nav>
</header>

<section id="panel-admin">
    <h2>Modificar Producto</h2>

    <?php if ($producto_seleccionado): ?>
    <div class="producto-card-horizontal">
        <h3>Producto #<?php echo $producto_seleccionado['id']; ?></h3>
        <div class="producto-row">

            <!-- Formulario de edición -->
            <div class="producto-formulario">
                <form method="post" action="index.php?accion=modificarProducto" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $producto_seleccionado['id']; ?>">

                    <label>Marca</label>
                    <input type="text" name="marca" value="<?php echo htmlspecialchars($producto_seleccionado['marca']); ?>" required>

                    <label>Modelo</label>
                    <input type="text" name="modelo" value="<?php echo htmlspecialchars($producto_seleccionado['modelo']); ?>" required>

                    <label>Categoría</label>
                    <select name="tipo" required>
                        <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($producto_seleccionado['tipo'] == $cat['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($cat['nombre_categoria']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>

                    <label>Precio</label>
                    <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto_seleccionado['precio']); ?>" required>

                    <label>Especificaciones</label>
                    <textarea name="especificaciones" rows="3" required><?php echo htmlspecialchars($producto_seleccionado['especificaciones']); ?></textarea>

                    <div class="botones-form">
                        <button type="submit" name="modificar_producto">Guardar Cambios</button>
                        <a href="index.php?accion=admin">Cancelar</a>
                    </div>
                </form>
            </div>

            <!-- Galería de imágenes -->
            <div class="galeria-imagenes">
                <strong>Imágenes del producto</strong>
                <div class="img-wrapper">
                    <?php if (!empty($producto_seleccionado['imagenes'])): ?>
                        <?php foreach ($producto_seleccionado['imagenes'] as $img): ?>
                        <div class="img-box">
                            <img src="uploads/<?php echo htmlspecialchars($img); ?>" alt="img">
                            <a class="delete-btn" href="index.php?accion=eliminar_imagen&id_producto=<?php echo $producto_seleccionado['id']; ?>&nombre_archivo=<?php echo urlencode($img); ?>" onclick="return confirm('¿Deseas Eliminar esta imagen?')">✖</a>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <em>No hay imágenes cargadas.</em>
                    <?php endif; ?>
                </div>

                <form method="post" action="index.php?accion=agregarImagenModificada" enctype="multipart/form-data" class="img-form">
                    <input type="hidden" name="id" value="<?php echo $producto_seleccionado['id']; ?>">
                    <input type="file" name="nueva_imagen" accept="image/*" required>
                    <button type="submit" name="agregar_imagen">Agregar Imagen</button>
                </form>
            </div>
        </div>
    </div>
    <?php else: ?>
        <p style="text-align:center;">No se encontró el producto seleccionado.</p>
    <?php endif; ?>
</section>

<footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
</footer>
</body>
</html>
