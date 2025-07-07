<?php
require_once '../Modelo/verProductosFiltrados.php';
$nombre = isset($_POST['buscar']) ? $_POST['buscar'] : '';
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
$productos = obtenerProductosFiltrados($nombre, $categoria);
if ($productos) {
    foreach ($productos as $prod) {
    echo "<div class='producto card mb-4' style='width: 18rem; display:inline-block; margin:10px;'>";
    $img = !empty($prod['imagenes'][0]) ? $prod['imagenes'][0] : 'default.png';
    echo "<img src='uploads/" . htmlspecialchars($img) . "' class='card-img-top' style='max-height:180px;object-fit:contain;'>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . htmlspecialchars($prod['nombre']) . "</h5>";
    echo "<p class='card-text'>Marca: " . htmlspecialchars($prod['marca']) . "</p>";
    echo "<p class='card-text'>Modelo: " . htmlspecialchars($prod['modelo']) . "</p>";
    echo "<p class='card-text'>Especificaciones: " . htmlspecialchars($prod['especificaciones']) . "</p>";
    echo "<a href='index.php?accion=registro' class='btn btn-secondary'>Solicitar Compra</a>";
    echo "</div></div>";
    }
} else {
    echo "<p>No se encontraron productos.</p>";
}
?>