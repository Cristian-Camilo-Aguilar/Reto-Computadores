<?php
require_once 'Modelo/verProductoPorId.php';
require_once 'Modelo/verImagenesProducto.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$producto = $id ? obtenerProductoPorId($id) : null;
$imagenes = $id ? obtenerImagenesProducto($id) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Producto</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="Vista/js/script.js"></script>
</head>
<body>
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente'): ?>
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a class="activa" href="index.php?accion=pedido">Catálogo</a>
            <a href="index.php?accion=pedidosrealizados">Mis Pedidos</a>
            <a href="index.php?accion=carrito">Mi Carrito</a>
            <a href="index.php?accion=vaciarCarrito">Vaciar Carrito</a>
            <a href="index.php?accion=logout">Cerrar Sesión</a>
        </nav>
    </header>
    <?php else: ?>
    <header>
        <br><h1>Tienda de Computadores Y Respuestos</h1><br>
        <nav>
            <a href="index.php?accion=vista">Inicio</a>
            <a class="activa" href="index.php?accion=vista">Catálogo</a>
            <a href="index.php?accion=logincliente">Login Cliente</a>
            <a href="index.php?accion=loginadmin">Login Admin</a>
        </nav>
    </header>
    <?php endif; ?>

    <section class="container py-5">
        <?php if ($producto): ?>
            <div class="row justify-content-center align-items-start g-4">
            <div class="col-md-6">
                <div id="carouselProducto" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if (!empty($imagenes)): ?>
                    <?php foreach ($imagenes as $index => $img): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                        <img src="uploads/<?php echo htmlspecialchars($img['nombre_archivo']); ?>" class="d-block w-100 rounded" style="max-height: 400px; object-fit: contain;" alt="Imagen producto">
                        </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="carousel-item active">
                        <img src="uploads/default.png" class="d-block w-100 rounded" style="max-height: 400px; object-fit: contain;" alt="Sin imagen">
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (count($imagenes) > 1): ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselProducto" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselProducto" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    </button>
                <?php endif; ?>
                </div>
            </div>

            <div class="col-md-6">
                <h2><?php echo htmlspecialchars($producto['nombre']); ?></h2>
                <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Marca:</strong> <?php echo htmlspecialchars($producto['marca']); ?></li>
                <li class="list-group-item"><strong>Modelo:</strong> <?php echo htmlspecialchars($producto['modelo']); ?></li>
                <li class="list-group-item"><strong>Categoría:</strong> <?php echo htmlspecialchars($producto['nombre_categoria']); ?></li>
                <li class="list-group-item"><strong>Precio:</strong> $<?php echo number_format($producto['precio'], 2); ?></li>
                <li class="list-group-item"><strong>Especificaciones:</strong> <?php echo htmlspecialchars($producto['especificaciones']); ?></li>
                </ul>
                <div class="mt-4">
                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente'): ?>
                    <a href="index.php?accion=agregarAlCarrito&id=<?php echo $producto['id']; ?>" class="btnaggProdu">
                    Agregar al carrito
                    </a>
                <?php else: ?>
                    <a href="index.php?accion=logincliente" class="btnaggProdu btn btn-warning">
                    Solicitar compra
                    </a>
                <?php endif; ?>
                <a href="index.php?accion=pedido" class="btn btn-outline-secondary ms-2">Regresar al catálogo</a>
                </div>
            </div>
            </div>
        <?php else: ?>
            <p class="text-center mt-5">Producto no encontrado o ID inválido.</p>
        <?php endif; ?>
        </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>