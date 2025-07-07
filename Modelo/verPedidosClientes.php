<?php
function obtenerPedidosClientes($id_usuario) {
    require_once 'Modelo/Conexion.php';
    $conexion = new Conexion();
    $conexion->abrir();
    $mysqli = $conexion->getMySQLI();
    $pedidoscliente = [];
    $stmt = $mysqli->prepare("SELECT p.id, pr.nombre AS nombre_producto, pr.marca, pr.modelo, p.cantidad, p.fecha, p.estado 
                            FROM pedidos p
                            JOIN productos pr ON p.id_producto = pr.id
                            WHERE p.id_usuario = ?");
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $pedidoscliente[] = $row;
    }
    $stmt->close();
    $conexion->cerrar();
    return $pedidoscliente;
}
?>