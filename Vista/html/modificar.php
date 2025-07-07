<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: index.php?accion=loginadmin");
    exit();
}

require_once 'Modelo/verProductos.php';
require_once 'Modelo/verCategorias.php';
require_once 'Modelo/Conexion.php';

$productos = obtenerProductos();
$categorias = obtenerCategorias();

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
            <a href="index.php?accion=logout">Cerrar Sesión</a>
        </nav>
    </header>

    <section id="panel-admin">
        <h2>Modificar Productos</h2>

        <?php
        foreach ($productos as $producto):
        ?>
        <div class="producto-card-horizontal">
            <h3>Producto #<?php echo $producto['id']; ?></h3>
            <div class="producto-row">
                
                <div class="producto-formulario">
                <form method="post" action="index.php?accion=modificarProducto" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

                    <label>Marca</label>
                    <input type="text" name="marca" value="<?php echo htmlspecialchars($producto['marca']); ?>" required>

                    <label>Modelo</label>
                    <input type="text" name="modelo" value="<?php echo htmlspecialchars($producto['modelo']); ?>" required>

                    <label>Categoría</label>
                    <select name="tipo" required>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($producto['tipo'] == $cat['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($cat['nombre_categoria']); ?>
                        </option>
                    <?php endforeach; ?>
                    </select>

                    <label>Precio</label>
                    <input type="number" step="0.01" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>

                    <label>Especificaciones</label>
                    <textarea name="especificaciones" rows="3" required><?php echo htmlspecialchars($producto['especificaciones']); ?></textarea>

                    <div class="botones-form">
                    <button type="submit" name="modificar_producto">Guardar Cambios</button>
                    <a href="index.php?accion=admin">Cancelar</a>
                    </div>
                </form>
                </div>

                <div class="galeria-imagenes">
                <strong>Imágenes del producto</strong>
                <div class="img-wrapper">
                    <?php
                    if (!empty($producto['imagenes'])) {
                        foreach ($producto['imagenes'] as $img) {
                            echo '<div class="img-box">';
                            echo '<img src="uploads/' . htmlspecialchars($img) . '" alt="img">';
                            echo '<a class="delete-btn" href="index.php?accion=eliminar_imagen&id_producto=' . $producto['id'] . '&nombre_archivo=' . urlencode($img) . '" onclick="return confirm(\'¿Deseas Eliminar esta imagen?\')">✖</a>';
                            echo '</div>';
                        }
                    } else {
                    echo '<em>No hay imágenes cargadas.</em>';
                    }
                    ?>
                </div>
                <form method="post" action="index.php?accion=agregarImagenModificada" enctype="multipart/form-data" class="img-form">
                    <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                    <input type="file" name="nueva_imagen" accept="image/*" required>
                    <button type="submit" name="agregar_imagen">Agregar Imagen</button>
                </form>
                </div>

            </div>
            </div>
        <?php endforeach; ?>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
