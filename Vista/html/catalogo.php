<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Tenis</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
</head>
<body>
  <header>
    <h1>Tienda de Tenis</h1>
    <nav>
      <a href="index.php?accion=vista">Catálogo</a>
      <a href="index.php?accion=loginadmin">Login Admin</a>
    </nav>
  </header>

  <section id="catalogo">
    <h2>Catálogo de Productos</h2>
    <?php
        require_once 'Modelo/verProductos.php';
        $productos = obtenerProductos();
    ?>
    <div class="productos">
        <?php
          if ($productos) {
              for ($i = 0; $i < count($productos); $i++) {
                  ?>
                  <div class="producto">
                      <img src="uploads/<?php echo htmlspecialchars($productos[$i]['imagen']); ?>">
                      <h3><?php echo $productos[$i]['nombre']; ?></h3>
                      <p>Categoría: <?php echo $productos[$i]['categoria']; ?></p>
                      <p>Talla: <?php echo $productos[$i]['talla']; ?></p>
                      <p><?php echo $productos[$i]['precio']; ?></p>
                      <a href="index.php?accion=registro">Solicitar Compra</a>
                  </div>
                  <?php
              }
          }

          // $contrasena = '123';
          // $hash = password_hash($contrasena, PASSWORD_DEFAULT);
          // echo $hash;

        ?>
    </div>
  </section>



  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
</body>
</html>