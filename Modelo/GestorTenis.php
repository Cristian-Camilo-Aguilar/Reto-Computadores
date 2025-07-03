<?php

class GestorTenis{

    public function login($correo, $contrasena){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo='$correo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult(); 
        $conexion->cerrar();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); 
        } else {
            return false;
        }
    }
    public function loginCliente($correo, $contrasena){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM usuarios WHERE correo='$correo'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); 
        } else {
            return false;
        }
    }
    public function registrarCliente($nombre, $correo, $contrasena, $rol){
        $conexion = new Conexion();
        $conexion->abrir();
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios VALUES (null, '$nombre', '$correo', '$hash', '$rol')";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function CrearProducto (Productos $productos){
        $conexion = new Conexion();
        $conexion->abrir();
        $marca = $productos->obtenerMarca();
        $modelo = $productos->obtenerModelo();
        $tipo = $productos->obtenerTipo();
        $precio = $productos->obtenerPrecio();
        $especificaciones = $productos->obtenerEspecificaciones();
        $id_categoria = $productos->obtenerIdCategoria();
        $cover = $productos->obtenerImagen();
        $sql = "INSERT INTO productos (marca, modelo, tipo, precio, especificaciones, id_categoria, imagen) 
                VALUES ('$marca', '$modelo', '$tipo', '$precio', '$especificaciones', '$id_categoria', '$cover')";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function CrearPedido (Pedidos $pedidos){
        $conexion = new Conexion();
        $conexion->abrir();
        $id_usuario = $pedidos->obtenerIdUsuario();
        $id_producto = $pedidos->obtenerIdProducto();
        $cantidad = $pedidos->obtenerCantidad();
        $fecha = $pedidos->obtenerFecha();          
        $estado = $pedidos->obtenerEstado();
        $sql = "INSERT INTO pedidos (id_usuario, id_producto, cantidad, fecha, estado)
                VALUES ('$id_usuario','$id_producto','$cantidad','$fecha','$estado')";
        $conexion->consulta($sql);
        $result=$conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function CrearCategoria(Categorias $categorias){
        $conexion= new Conexion();
        $conexion->abrir();
        $nombre=$categorias->obtenerNombre();
        $sql="INSERT INTO categorias VALUES (null, '$nombre')";
        $conexion->consulta($sql);
        $result=$conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function eliminarCategoria($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM categorias WHERE id='$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function eliminarProducto($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM productos WHERE id='$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function cambiarEstadoPedido($id){
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE pedidos SET estado='Enviado' WHERE id=$id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function tieneRelacionesProductos($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT COUNT(*) as total FROM productos WHERE id = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function categoriaTieneProductos($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT COUNT(*) as total FROM productos WHERE id_categoria = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
}

?>