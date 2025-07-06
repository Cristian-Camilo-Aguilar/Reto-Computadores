<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: index.php?accion=loginadmin");
    exit();
}

require_once 'Modelo/verProductos.php';
require_once 'Modelo/Conexion.php';

// Obtener productos y categorías
$productos = obtenerProductos();

$conexion = new Conexion();
$conexion->abrir();
$mysqli = $conexion->getMySQLI();
$categorias = [];
$result = $mysqli->query("SELECT id, nombre_categoria FROM categorias");
while ($row = $result->fetch_assoc()) {
    $categorias[] = $row;
}
$conexion->cerrar();

// Modificar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar_producto'])) {
    $id = $_POST['id'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $tipo = $_POST['tipo'];
    $precio = $_POST['precio'];
    $especificaciones = $_POST['especificaciones'];

    $conexion = new Conexion();
    $conexion->abrir();
    $mysqli = $conexion->getMySQLI();
    $stmt = $mysqli->prepare("UPDATE productos SET marca=?, modelo=?, tipo=?, precio=?, especificaciones=? WHERE id=?");
    $stmt->bind_param("ssidsi", $marca, $modelo, $tipo, $precio, $especificaciones, $id);
    $stmt->execute();
    $stmt->close();
    $conexion->cerrar();

    echo "<script>
        alert('Producto modificado correctamente');
        window.location.href = 'index.php?accion=modificar';
    </script>";
    exit();
}

// Agregar imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_imagen']) && isset($_POST['id'])) {
    $id_producto = intval($_POST['id']);
    if (isset($_FILES['nueva_imagen']) && $_FILES['nueva_imagen']['error'] === UPLOAD_ERR_OK) {
        $nombre_archivo = time() . '_' . basename($_FILES['nueva_imagen']['name']);
        $ruta_destino = "uploads/" . $nombre_archivo;
        $tipo = $_FILES['nueva_imagen']['type'];
        $permitidos = ['image/jpg', 'image/jpeg', 'image/png'];
        if (in_array($tipo, $permitidos)) {
            if (move_uploaded_file($_FILES['nueva_imagen']['tmp_name'], $ruta_destino)) {
                $conexion = new Conexion();
                $conexion->abrir();
                $mysqli = $conexion->getMySQLI();
                $stmt = $mysqli->prepare("INSERT INTO imagenes_productos (id_producto, nombre_archivo) VALUES (?, ?)");
                $stmt->bind_param("is", $id_producto, $nombre_archivo);
                $stmt->execute();
                $stmt->close();
                $conexion->cerrar();
            }
        }
    }
    header("Location: index.php?accion=modificar");
    exit();
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
                <form method="post" action="" enctype="multipart/form-data">
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
                            echo '<a class="delete-btn" href="index.php?accion=eliminar_imagen&id_producto=' . $producto['id'] . '&nombre_archivo=' . urlencode($img) . '" onclick="return confirm(\'¿Eliminar esta imagen?\')">✖</a>';
                            echo '</div>';
                        }
                    } else {
                    echo '<em>No hay imágenes cargadas.</em>';
                    }
                    ?>
                </div>
                <form method="post" action="" enctype="multipart/form-data" class="img-form">
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
