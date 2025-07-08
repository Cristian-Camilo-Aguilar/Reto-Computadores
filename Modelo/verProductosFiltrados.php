<?php
function obtenerProductosFiltrados($buscar, $categoria, $inicio, $limite) {
    $conexion = new Conexion();
    $conexion->abrir();
    $buscar = $conexion->getMySQLI()->real_escape_string($buscar);
    $categoria = intval($categoria);
    $condiciones = [];
    if (!empty($buscar)) {
        $condiciones[] = "(p.nombre LIKE '%$buscar%' OR p.marca LIKE '%$buscar%' OR p.modelo LIKE '%$buscar%')";
    }
    if ($categoria > 0) {
        $condiciones[] = "p.tipo = $categoria";
    }
    $where = count($condiciones) > 0 ? 'WHERE ' . implode(' AND ', $condiciones) : '';
    $sql = "SELECT p.*, nombre_categoria
            FROM productos p
            JOIN categorias c ON p.tipo = c.id
            $where
            ORDER BY p.id DESC
            LIMIT $inicio, $limite";
    $resultado = $conexion->getMySQLI()->query($sql);
    $productos = [];
    while ($row = $resultado->fetch_assoc()) {
        $row['imagenes'] = obtenerImagenesProducto($row['id']);
        $productos[] = $row;
    }
    $conexion->cerrar();
    return $productos;
}
function obtenerImagenesProducto($id_producto, $mysqli = null) {
    if (!$mysqli) {
        $conexion = new Conexion();
        $conexion->abrir();
        $mysqli = $conexion->getMySQLI();
    }
    $imagenes = [];
    $stmt = $mysqli->prepare("SELECT nombre_archivo FROM imagenes_productos WHERE id_producto = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($img = $result->fetch_assoc()) {
            $imagenes[] = $img['nombre_archivo'];
        }
        $stmt->close();
    }
    return $imagenes;
}
function contarProductosFiltrados($buscar, $categoria) {
    $conexion = new Conexion();
    $conexion->abrir();
    $buscar = $conexion->getMySQLI()->real_escape_string($buscar);
    $categoria = intval($categoria);
    $condiciones = [];
    if (!empty($buscar)) {
        $condiciones[] = "(nombre LIKE '%$buscar%' OR marca LIKE '%$buscar%' OR modelo LIKE '%$buscar%')";
    }
    if ($categoria > 0) {
        $condiciones[] = "tipo = $categoria";
    }
    $where = count($condiciones) > 0 ? 'WHERE ' . implode(' AND ', $condiciones) : '';
    $sql = "SELECT COUNT(*) AS total FROM productos $where";
    $resultado = $conexion->getMySQLI()->query($sql);
    $fila = $resultado->fetch_assoc();
    $conexion->cerrar();
    return intval($fila['total']);
}
?>