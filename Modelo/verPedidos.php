<?php
function obtenerPedidos() {
    require_once 'Modelo/Conexion.php';
    $conexion = new Conexion();
    $conexion->abrir();
    $sql = "SELECT pedidos.id, usuarios.nombre AS cliente, productos.nombre AS producto, pedidos.cantidad, pedidos.fecha, pedidos.estado 
    FROM pedidos 
    JOIN usuarios ON pedidos.id_usuario = usuarios.id 
    JOIN productos ON pedidos.id_producto = productos.id";
    $conexion->consulta($sql);
    $result = $conexion->obtenerResult();
    $pedidos = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $pedidos[] = $row;
        }
    }
    $conexion->cerrar();
    return $pedidos;
}
?>