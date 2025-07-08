<?php
header('Content-Type: application/json');
require_once 'Modelo/Conexion.php';
$conexion = new Conexion();
$conexion->abrir();
$sql = "SELECT MONTH(fecha) AS mes, COUNT(*) AS pedidos FROM pedidos GROUP BY MONTH(fecha)";
$resultado = $conexion->getMySQLI()->query($sql);
$meses = [1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
        7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'];
$data = [];
while ($fila = $resultado->fetch_assoc()) {
    $data[] = [
        'mes' => $meses[(int)$fila['mes']],
        'valor' => (int)$fila['pedidos']
    ];
}
echo json_encode($data);