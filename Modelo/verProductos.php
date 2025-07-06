<?php
function obtenerProductos() {
    require_once 'Modelo/Conexion.php';
    $conexion = new Conexion();
    $conexion->abrir();
    $mysqli = $conexion->getMySQLI();
    $sql = "SELECT p.*, c.nombre_categoria AS nombre_categoria 
            FROM productos p 
            LEFT JOIN categorias c ON p.tipo = c.id";
    $result = $mysqli->query($sql);
    $productos = array();
    while ($row = $result->fetch_assoc()) {
        // Obtener imágenes relacionadas
        $id_producto = $row['id'];
        $imagenes = array();
        $sql_img = "SELECT nombre_archivo FROM imagenes_productos WHERE id_producto = $id_producto";
        $result_img = $mysqli->query($sql_img);
        while ($img = $result_img->fetch_assoc()) {
            $imagenes[] = $img['nombre_archivo'];
        }
        $row['imagenes'] = $imagenes;
        $productos[] = $row;
    }
    $conexion->cerrar();
    return $productos;
}
?>