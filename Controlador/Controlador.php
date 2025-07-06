<?php

class Controlador {
    public function verpagina($ruta){
            require_once $ruta;
    }
    public function login($correo, $contrasena){
        $gestorTenis = new GestorTenis();
        $result = $gestorTenis->login($correo, $contrasena); 
        if ($result && isset($result['rol']) && $result['rol'] == 'admin' && password_verify($contrasena, $result['contrasena'])) {
            $_SESSION["correo"] = $correo;
            $_SESSION["rol"] = $result['rol'];
            require_once "Vista/html/admin.php";
        } else {
            echo "<script>alert('Usuario o Contraseña incorrectos');</script>";
            require_once "Vista/html/login.html";
        }
    }

    public function loginCliente($correo, $contrasena){
        $gestorTenis = new GestorTenis();
        $result = $gestorTenis->logincliente($correo, $contrasena); 
        if ($result && password_verify($contrasena, $result['contrasena'])) {
            $_SESSION["correo"] = $correo;
            $_SESSION["nombre"] = $result['nombre'];
            $_SESSION["id_usuario"] = $result['id'];
            require_once "Vista/html/pedido.php";
        } else {
            echo "<script>alert('Usuario o Contraseña incorrectos');</script>";
            require_once "Vista/html/logincliente.html";
        }
    }
    public function registrarCliente($nombre, $correo, $contrasena, $rol){
        $gestorTenis= new GestorTenis();
        $result=$gestorTenis->registrarCliente($nombre, $correo, $contrasena, $rol);
        if ($result>0){
            echo"<script>alert('Usuario Registrado con Exito');
            window.location.href = 'index.php?accion=pedido';</script>";
        }
        else{
            echo"<script>alert('El Usuario no se Registro')</script>";
            require_once "Vista/html/registro.html";
        }
    }
    public function crearProducto($nombre, $marca, $modelo, $tipo, $precio, $especificaciones){
        $productos = new Productos($nombre, $marca, $modelo, $tipo, $precio, $especificaciones);
        $gestorTenis = new GestorTenis();
        $id_producto = $gestorTenis->CrearProducto($productos);
        if ($id_producto > 0){
            echo"<script>alert('Producto agregado con Exito')</script>";
        } else {
            echo"<script>alert('Producto no se Guardó')</script>";
        }
        require_once "Vista/html/admin.php";
        return $id_producto; 
    }
    public function guardarImagen($id_producto, $nombre_archivo) {
        $gestorTenis = new GestorTenis();
        $gestorTenis->guardarImagen($id_producto, $nombre_archivo);
    }
    public function crearPedido ($id_usuario, $id_producto, $cantidad, $fecha, $estado){
        $pedidos = new Pedidos ($id_usuario, $id_producto, $cantidad, $fecha, $estado);
        $gestorTenis= new GestorTenis();
        $result=$gestorTenis->CrearPedido($pedidos);
        if ($result>0){
            echo"<script>alert('Pedido agregado con Exito')</script>";
        }
        else{
            echo"<script>alert('Pedido no se Guardó')</script>";
        }
        require_once "Vista/html/pedido.php";
    }
    public function crearCategoria($nombre_categoria){
        $categorias = new Categorias ($nombre_categoria);
        $gestorTenis= new GestorTenis();
        $result=$gestorTenis->CrearCategoria($categorias);
        if ($result>0){
            echo"<script>alert('Categoria agregada con Exito')</script>";
        }
        else{
            echo"<script>alert('La Categoria no se guardó')</script>";
        }
        require_once "Vista/html/categorias.php";
    }
    public function eliminarCategoria($id){
        $gestorTenis = new GestorTenis();
        if ($gestorTenis->categoriaTieneProductos($id)) {
            echo "<script>alert('No se puede eliminar la Categoría porque está asociada a Productos');</script>";
            require_once "Vista/html/categorias.php";
            return;
        }
        $result = $gestorTenis->eliminarCategoria($id);
        if ($result > 0) {
            echo "<script>alert('Categoría eliminada con éxito');</script>";
        } else {
            echo "<script>alert('Error al eliminar la categoría');</script>";
        }
        require_once "Vista/html/categorias.php";
}
    public function eliminarProducto($id){
        $gestorTenis = new GestorTenis();
        if ($gestorTenis->tieneRelacionesProductos($id)) {
            echo "<script>alert('No se puede eliminar el producto porque está relacionado con una Categoria');</script>";
            require_once "Vista/html/admin.php";
            return;
        }
        $result = $gestorTenis->eliminarProducto($id);
        if ($result > 0) {
            echo "<script>alert('Producto eliminado con éxito');</script>";
        } else {
            echo "<script>alert('Error al eliminar el Producto');</script>";
        }
        require_once "Vista/html/admin.php";
    }

    public function cambiarEstadoPedido($id){
        $gestorTenis = new GestorTenis();
        $result = $gestorTenis->cambiarEstadoPedido($id);
        if ($result > 0) {
            echo "<script>alert('Estado del pedido actualizado a Enviado');</script>";
        } else {
            echo "<script>alert('No se pudo actualizar el estado del pedido');</script>";
        }
        require_once "Vista/html/pedidosclientes.php";
    }
    public function eliminarImagen($id_producto, $nombre_archivo) {
        $gestorTenis = new GestorTenis();
        $gestorTenis->eliminarImagen($id_producto, $nombre_archivo);
        $ruta = "uploads/" . $nombre_archivo;
        if (file_exists($ruta)) {
            unlink($ruta);
        }
        header("Location: index.php?accion=modificar&editar=" . $id_producto);
        exit();
    }

}

?>