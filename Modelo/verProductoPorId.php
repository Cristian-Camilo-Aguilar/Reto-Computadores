<?php
function obtenerProductoPorId($id) {
    $conexion = new Conexion();
    $conexion->abrir();
    $id = intval($id);
    $sql = "SELECT p.*, nombre_categoria
            FROM productos p
            JOIN categorias c ON p.tipo = c.id
            WHERE p.id = $id";
    $resultado = $conexion->getMySQLI()->query($sql);
    $conexion->cerrar();
    return $resultado->fetch_assoc();
}
