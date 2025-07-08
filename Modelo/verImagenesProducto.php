<?php
function obtenerImagenesProducto($id_producto) {
    $conexion = new Conexion();
    $conexion->abrir();
    $id_producto = intval($id_producto);
    $sql = "SELECT nombre_archivo FROM imagenes_productos WHERE id_producto = $id_producto";
    $resultado = $conexion->getMySQLI()->query($sql);
    $imagenes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $imagenes[] = $fila;
    }
    $conexion->cerrar();
    return $imagenes;
}
