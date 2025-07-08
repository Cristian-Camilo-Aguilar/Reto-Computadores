<?php
if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: index.php?accion=logincliente");
    exit();
}
require_once 'Modelo/verCategorias.php';
require_once 'Modelo/verProductosFiltrados.php';
require_once 'Modelo/Conexion.php';

$productosPorPagina = 9;
$paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($paginaActual - 1) * $productosPorPagina;

$busqueda = $_GET['buscar'] ?? '';
$categoria = $_GET['categoria'] ?? '';

$productos = obtenerProductosFiltrados($busqueda, $categoria, $inicio, $productosPorPagina);
$totalProductos = contarProductosFiltrados($busqueda, $categoria);
$totalPaginas = ceil($totalProductos / $productosPorPagina);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo Cliente</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <br><h1>Tienda de Computadores Y Respuestos</h1><br>
        <nav>
        <a class="activa" href="index.php?accion=pedido">Catálogo</a>
        <a href="index.php?accion=pedidosrealizados">Mis Pedidos</a>
        <a href="index.php?accion=carrito">Mi Carrito</a>
        <a href="index.php?accion=vaciarCarrito">Vaciar Carrito</a>
        <a href="index.php?accion=logout">Cerrar Sesión</a>
        </nav>
    </header>

    <section class="container py-4">
        <h2 class="text-center mb-4">Catálogo de Productos</h2>

        <!-- Filtro -->
        <div class="filtro container text-center mb-4">
        <form id="filtro-form" method="get">
            <div class="row justify-content-center align-items-center gy-3 gx-3">
            <div class="col-auto">
                <input type="text" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>" class="form-control" placeholder="Buscar por nombre">
            </div>
            <div class="col-auto">
                <select name="categoria" class="form-select">
                <option value="">Todas las categorías</option>
                <?php
                $categorias = obtenerCategorias();
                foreach ($categorias as $cat) {
                    $selected = $categoria == $cat['id'] ? 'selected' : '';
                    echo "<option value='{$cat['id']}' $selected>" . htmlspecialchars($cat['nombre_categoria']) . "</option>";
                }
                ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
            </div>
        </form>
        </div>

        <!-- Productos -->
        <div class="d-flex flex-wrap justify-content-center">
        <?php if ($productos): ?>
            <?php foreach ($productos as $i => $producto): ?>
            <?php $imagenes = $producto['imagenes']; $carouselId = "carouselCliente" . $i; ?>
            <div class="card mb-4 mx-2" style="width: 18rem;">
                <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if (!empty($imagenes)): ?>
                    <?php foreach ($imagenes as $idx => $img): ?>
                        <div class="carousel-item <?php echo $idx === 0 ? 'active' : ''; ?>">
                        <img src="uploads/<?php echo htmlspecialchars($img); ?>" class="d-block w-100" style="max-height:180px;object-fit:contain;">
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="carousel-item active">
                        <img src="uploads/default.png" class="d-block w-100" style="max-height:180px;object-fit:contain;">
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (count($imagenes) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                <?php endif; ?>
                </div>

                <div class="card-body text-center">
                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                <p class="card-text"><strong>Marca:</strong> <?php echo htmlspecialchars($producto['marca']); ?></p>
                <p class="card-text"><strong>Modelo:</strong> <?php echo htmlspecialchars($producto['modelo']); ?></p>
                <p class="card-text"><strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?></p>
                <a href="index.php?accion=verProducto&id=<?php echo $producto['id']; ?>" class="btnverProdu mt-2">Ver producto</a>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">No se encontraron productos.</p>
        <?php endif; ?>
        </div>

        <!-- Paginación -->
        <nav aria-label="Paginación">
            <ul class="pagination justify-content-center mt-4">
            <?php if ($paginaActual > 1): ?>
                <li class="page-item">
                <a class="page-link" href="index.php?accion=pedido&pagina=<?php echo $paginaActual - 1; ?>&buscar=<?php echo urlencode($busqueda); ?>&categoria=<?php echo urlencode($categoria); ?>">&laquo;</a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?php echo $i == $paginaActual ? 'active' : ''; ?>">
                <a class="page-link" href="index.php?accion=pedido&pagina=<?php echo $i; ?>&buscar=<?php echo urlencode($busqueda); ?>&categoria=<?php echo urlencode($categoria); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <?php if ($paginaActual < $totalPaginas): ?>
                <li class="page-item">
                <a class="page-link" href="index.php?accion=pedido&pagina=<?php echo $paginaActual + 1; ?>&buscar=<?php echo urlencode($busqueda); ?>&categoria=<?php echo urlencode($categoria); ?>">&raquo;</a>
                </li>
            <?php endif; ?>
            </ul>
        </nav>
    </section>

    <footer class="text-center mt-4">
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>