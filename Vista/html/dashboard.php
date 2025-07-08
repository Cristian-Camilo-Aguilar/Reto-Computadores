<?php
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php?accion=loginadmin");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas</title>
    <link rel="stylesheet" href="Vista/css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="Vista/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <br><h1>Tienda de Computadores y Repuestos</h1><br>
        <nav>
            <a href="index.php?accion=admin">Inicio</a>
            <a href="index.php?accion=categorias">Categorías</a>
            <a href="index.php?accion=pedidosclientes">Pedidos</a>
            <a class="activa" href="index.php?accion=verEstadisticas">Estadísticas</a>
            <a href="index.php?accion=logout">Cerrar Sesión</a>
        </nav>
    </header>

    <?php
    $categoriaVentas = [];
    $productosCategoria = [];
    while ($produxcate = $productoCategoria->fetch_assoc()){
        $categoriaVentas[] = $produxcate["nombre_categoria"];
        $productosCategoria[] = $produxcate["cantidad_productos"];
    }

    $fechaMes = [];
    $pedidosMes = [];
    while ($pedixmes = $pedidosxMes->fetch_assoc()){
        $fechaMes[] = $pedixmes["mes"];
        $pedidosMes[] = $pedixmes["total_pedidos"];
    }
    ?>

    <section>
        <div class="container">
            <div class="row">

                <!-- Productos por Categoria -->
                <div class="col-md-6 mb-4">
                    <h3 class="text-center">Productos por Categoría</h3>
                    <canvas class="circle" id="productosxCategoria"></canvas>
                </div>

                <!-- Pedidos por Mes -->
                <div class="col-md-6 mb-4">
                    <h3 class="text-center">Pedidos por Mes</h3>
                    <canvas class="circle" id="pedidosxMes"></canvas>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Computadores y Repuestos. Todos los derechos reservados.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Productos por Categoria
            const ctxPro = document.getElementById('productosxCategoria');
            new Chart(ctxPro, {
                type: 'polarArea',
                data: {
                    labels: <?php echo json_encode($categoriaVentas); ?>,
                    datasets: [{
                        label: 'Productos por Categoría',
                        data: <?php echo json_encode($productosCategoria); ?>,
                        backgroundColor: [
                        'rgb(214, 14, 57)',
                        'rgb(22, 214, 214)',
                        'rgb(249, 196, 72)',
                        'rgb(161, 161, 161)',
                        'rgb(67, 163, 226)'
                        ]
                    }]
                    },
                    options: {
                        reponsive: true,
                    }
                }
            )

            // Pedidos por Mes
            const pedxMes = document.getElementById('pedidosxMes');
            new Chart(pedxMes, {
                type: 'doughnut',
                data: {
                    labels: <?php echo json_encode($fechaMes); ?>,
                    datasets: [{
                        label: 'Pedidos por Mes',
                        data: <?php echo json_encode($pedidosMes); ?>,
                        backgroundColor: [
                        'rgb(214, 14, 57)',
                        'rgb(22, 214, 214)',
                        'rgb(249, 196, 72)',
                        'rgb(161, 161, 161)',
                        'rgb(67, 163, 226)'
                        ],
                        hoverOffset: 4
                    }]
                    },
                    options: {
                        reponsive: true,
                    }
                }
            )
        });
    </script>
</body>
</html>