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
    public function CrearProducto(Productos $productos){
        $conexion = new Conexion();
        $conexion->abrir();
        $nombre = $productos->obtenerNombre();
        $marca = $productos->obtenerMarca();
        $modelo = $productos->obtenerModelo();
        $tipo = $productos->obtenerTipo();
        $precio = $productos->obtenerPrecio();
        $especificaciones = $productos->obtenerEspecificaciones();
        $sql = "INSERT INTO productos (nombre, marca, modelo, tipo, precio, especificaciones) 
                VALUES ('$nombre','$marca', '$modelo', '$tipo', '$precio', '$especificaciones')";
        $conexion->consulta($sql);
        $id_insertado = $conexion->obtenerInsertId();
        $conexion->cerrar();
        return $id_insertado;
    }
    public function guardarImagen($id_producto, $nombre_archivo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO imagenes_productos (id_producto, nombre_archivo) VALUES ('$id_producto', '$nombre_archivo')";
        $conexion->consulta($sql);
        $conexion->cerrar();
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
        $nombre_categoria=$categorias->obtenerNombre();
        $sql="INSERT INTO categorias VALUES (null, '$nombre_categoria')";
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
    public function actualizarEstadoPedido($id, $estado){
        $conexion = new Conexion();
        $conexion->abrir();
        $estado = $conexion->getMySQLI()->real_escape_string($estado);
        $id = intval($id);
        $sql = "UPDATE pedidos SET estado='$estado' WHERE id=$id";
        $conexion->consulta($sql);
        $resultado = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $resultado;
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
        $sql = "SELECT COUNT(*) as total FROM productos WHERE tipo = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function eliminarImagen($id_producto, $nombre_archivo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $id_producto = intval($id_producto);
        $nombre_archivo = $conexion->getMySQLI()->real_escape_string($nombre_archivo);
        $sql = "DELETE FROM imagenes_productos WHERE id_producto='$id_producto' AND nombre_archivo='$nombre_archivo'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }
    public function guardarImagenModificada($id_producto, $nombre_archivo) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO imagenes_productos (id_producto, nombre_archivo) VALUES ('$id_producto', '$nombre_archivo')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }
    public function esFormatoPermitido($tipo_mime) {
        $permitidos = ['image/jpg', 'image/jpeg', 'image/png'];
        return in_array($tipo_mime, $permitidos);
    }
    public function actualizarProducto($id, $marca, $modelo, $tipo, $precio, $especificaciones) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE productos 
                SET marca='$marca', modelo='$modelo', tipo='$tipo', precio='$precio', especificaciones='$especificaciones' 
                WHERE id='$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }
    public function crearPedidoDesdeCarrito(Pedidos $pedidos) {
        $conexion = new Conexion();
        $conexion->abrir();
        $id_usuario = $pedidos->obtenerIdUsuario();
        $id_producto = $pedidos->obtenerIdProducto();
        $cantidad = $pedidos->obtenerCantidad();
        $fecha = $pedidos->obtenerFecha();
        $estado = $pedidos->obtenerEstado();
        $sql = "INSERT INTO pedidos (id_usuario, id_producto, cantidad, fecha, estado)
                VALUES ('$id_usuario', '$id_producto', '$cantidad', '$fecha', '$estado')";
        $conexion->consulta($sql);
        $result = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $result;
    }

}

?>