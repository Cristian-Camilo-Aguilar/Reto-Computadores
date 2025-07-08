<?php

class Estadisticas{
    public function consultarPedidoxCliente(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT categorias.nombre_categoria, COUNT(productos.id) AS cantidad_productos
                FROM categorias
                LEFT JOIN productos ON productos.tipo = categorias.id
                GROUP BY categorias.id;";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function consultarPedidosxMes(){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT DATE_FORMAT(fecha, '%Y-%m') AS mes, COUNT(*) AS total_pedidos
            FROM pedidos
            GROUP BY DATE_FORMAT(fecha, '%Y-%m')
            ORDER BY mes ASC;";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
}

?>