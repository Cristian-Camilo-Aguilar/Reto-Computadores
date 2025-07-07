<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tienda de Tenis</title>
  <link rel="stylesheet" href="Vista/css/styles.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <div class="filtro">
      <form id="filtro-form" class="d-flex flex-row gap-3 flex-wrap">
        <input type="text" name="buscar" id="buscar" class="form-control" placeholder="Buscar por nombre">
        <select name="categoria" id="categoria" class="form-select" style="max-width:200px;">
          <option value="">Todas las categorías</option>
          <?php
            require_once 'Modelo/verCategorias.php';
            $categorias = obtenerCategorias();
            foreach ($categorias as $cat) {
              echo "<option value='{$cat['id']}'>" . htmlspecialchars($cat['nombre_categoria']) . "</option>";
            }
          ?>
        </select>
        <button type="submit" class="btn btn-primary">Filtrar</button>
      </form>
    </div>

    <?php
      require_once 'Modelo/verProductosFiltrados.php';
      $busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
      $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
      $productos = obtenerProductosFiltrados($busqueda, $categoria);
    ?>

    <div class="productos">
      <?php
      if ($productos) {
        for ($i = 0; $i < count($productos); $i++) {
          $imagenes = $productos[$i]['imagenes'];
          $carouselId = "carouselProducto" . $i;
      ?>
      <div class="producto card mb-4" style="width: 18rem; display:inline-block; vertical-align:top; margin:10px;">
        <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php
              if (!empty($imagenes)) {
                foreach ($imagenes as $idx => $img) {
            ?>
              <div class="carousel-item <?php if ($idx === 0) echo 'active'; ?>">
                <img src="uploads/<?php echo htmlspecialchars($img); ?>" class="d-block w-100" style="max-height:180px;object-fit:contain;">
              </div>
            <?php
                }
              } else {
            ?>
              <div class="carousel-item active">
                <img src="uploads/default.png" class="d-block w-100" style="max-height:180px;object-fit:contain;">
              </div>
            <?php } ?>
          </div>
          <?php if (!empty($imagenes) && count($imagenes) > 1) { ?>
            <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
              <span class="carousel-control-next-icon"></span>
            </button>
          <?php } ?>
        </div>
        <div class="card-body">
          <h5 class="card-title"><?php echo $productos[$i]['nombre']; ?></h5>
          <p class="card-text">Marca: <?php echo $productos[$i]['marca']; ?></p>
          <p class="card-text">Modelo: <?php echo $productos[$i]['modelo']; ?></p>
          <p class="card-text">Especificaciones: <?php echo $productos[$i]['especificaciones']; ?></p>
          <a href="index.php?accion=registro" class="btn btn-secondary">Solicitar Compra</a>
        </div>
      </div>
      <?php
        }
      } else {
        echo "<p>No se encontraron productos para el filtro aplicado.</p>";
      }
      ?>
    </div>
  </section>



  <footer>
    <p>&copy; 2025 Tienda de Tenis. Todos los derechos reservados.</p>
  </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>