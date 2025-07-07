<?php
function obtenerProductosFiltrados($nombre = "", $categoria = "") {
    $conexion = new Conexion();
    $conexion->abrir();
    $mysqli = $conexion->getMySQLI();
    $sql = "SELECT * FROM productos WHERE 1";
    $params = [];
    $types = "";
    if ($nombre !== "") {
        $sql .= " AND nombre LIKE ?";
        $params[] = "%" . $nombre . "%";
        $types .= "s";
    }
    if ($categoria !== "") {
        $sql .= " AND tipo = ?";
        $params[] = $categoria;
        $types .= "s";
    }
    $stmt = $mysqli->prepare($sql);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $row['imagenes'] = obtenerImagenesProducto($row['id'], $mysqli);
        $productos[] = $row;
    }
    $stmt->close();
    $conexion->cerrar();
    return $productos;
}
function obtenerImagenesProducto($id_producto, $mysqli) {
    $imagenes = [];
    $stmt = $mysqli->prepare("SELECT nombre_archivo FROM imagenes_productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($img = $result->fetch_assoc()) {
        $imagenes[] = $img['nombre_archivo'];
    }
    $stmt->close();
    return $imagenes;
}
?>