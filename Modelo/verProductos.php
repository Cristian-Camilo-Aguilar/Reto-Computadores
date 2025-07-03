<?php
function obtenerProductos() {
    require_once 'Modelo/Conexion.php';
    $conexion = new Conexion();
    $conexion->abrir();
    $sql = "SELECT productos.id, productos.nombre, categorias.nombre AS categoria, productos.precio, productos.imagen, productos.descripcion AS talla 
    FROM productos 
    JOIN categorias ON productos.id_categoria = categorias.id";
    $conexion->consulta($sql);
    $result = $conexion->obtenerResult();
    $productos = [];
    if ($result) {
        while ($prod = $result->fetch_assoc()) {
            $productos[] = $prod;
        }
    }
    $conexion->cerrar();
    return $productos;
}
?>