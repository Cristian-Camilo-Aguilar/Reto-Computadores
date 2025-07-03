<?php
function obtenerCategorias() {
    require_once 'Modelo/Conexion.php';
    $conexion = new Conexion();
    $conexion->abrir();
    $sql = "SELECT id, nombre FROM categorias";
    $conexion->consulta($sql);
    $result = $conexion->obtenerResult();
    $categorias = [];
    if ($result) {
        while ($cat = $result->fetch_assoc()) {
            $categorias[] = $cat;
        }
    }
    $conexion->cerrar();
    return $categorias;
}
?>