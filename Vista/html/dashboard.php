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
    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script type="text/javascript" src="Vista/js/script.js"></script>
</head>
<body>
    <header>
        <h1>Tienda de Tenis</h1>
        <nav>
            <a href="index.php?accion=admin">Inicio</a>
            <a href="index.php?accion=categorias">Categorias</a>
            <a href="index.php?accion=pedidosclientes">Pedidos</a>
            <a class="activa" href="index.php?accion=dashboard">Estadisticas</a>
            <a href="index.php?accion=logout">Cerrar Sesion</a>
        </nav>
    </header>

    <section class="admin-section">
        
    </section>

    <footer>
        <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
    </footer>
</body>
</html>