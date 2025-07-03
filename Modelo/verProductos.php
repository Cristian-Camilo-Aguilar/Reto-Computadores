<?php
function obtenerProductos() {
    require_once 'Modelo/Conexion.php';
    $conexion = new Conexion();
    $conexion->abrir();
    $sql = "SELECT productos.id, productos.marca, productos.modelo, productos.tipo, productos.precio, productos.especificaciones, categorias.nombre AS categoria 
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