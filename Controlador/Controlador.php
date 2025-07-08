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
        if ($result && password_verify($contrasena, $result['contrasena']) && $result['rol'] === 'cliente') {
            $_SESSION["correo"] = $correo;
            $_SESSION["nombre"] = $result['nombre'];
            $_SESSION["id_usuario"] = $result['id'];
            $_SESSION["rol"] = $result['rol'];
            require_once "Vista/html/pedido.php";
        } else {
            echo "<script>alert('Usuario, contraseña o rol incorrecto');</script>";
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
    public function actualizarEstadoPedido($id, $estado){
        $gestorTenis = new GestorTenis();
        return $gestorTenis->actualizarEstadoPedido($id, $estado);
    }
    public function eliminarImagen($id_producto, $nombre_archivo) {
        $gestorTenis = new GestorTenis();
        $gestorTenis->eliminarImagen($id_producto, $nombre_archivo);
        $ruta = "uploads/" . $nombre_archivo;
        if (file_exists($ruta)) {
            unlink($ruta);
        }
        header("Location: index.php?accion=modificar&id=" . $id_producto);
        exit();
    }
    public function agregarImagen($id_producto, $archivo) {
        $gestorTenis = new GestorTenis();
        if ($gestorTenis->esFormatoPermitido($archivo["type"])) {
            $nombre_archivo = time() . '_' . basename($archivo["name"]);
            $ruta = "uploads/" . $nombre_archivo;

            if (move_uploaded_file($archivo["tmp_name"], $ruta)) {
                $gestorTenis->guardarImagenModificada($id_producto, $nombre_archivo);
                echo "<script>alert('Imagen agregada exitosamente');</script>";
            } else {
                echo "<script>alert('Error al guardar la imagen en el servidor');</script>";
            }
        } else {
            echo "<script>alert('Formato de imagen no permitido');</script>";
        }
        require_once "Vista/html/modificar.php";
    }

    public function modificarProducto($id, $marca, $modelo, $tipo, $precio, $especificaciones) {
        $gestor = new GestorTenis();
        $result = $gestor->actualizarProducto($id, $marca, $modelo, $tipo, $precio, $especificaciones);
        if ($result > 0) {
            echo "<script>alert('Producto modificado correctamente');</script>";
        } else {
            echo "<script>alert('No se pudo modificar el producto');</script>";
        }
        require_once "Vista/html/modificar.php";
    }


    public function agregarAlCarrito($id_producto) {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        if (!in_array($id_producto, $_SESSION['carrito'])) {
            $_SESSION['carrito'][] = $id_producto;
        }

        header("Location: index.php?accion=carrito");
        exit();
    }

    public function verCarrito() {
        $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : [];
        $productos = obtenerProductos();

        $seleccionados = array_filter($productos, function($prod) use ($carrito) {
            return in_array($prod['id'], $carrito);
        });

        require_once "Vista/html/carrito.php";
    }

    public function vaciarCarrito() {
        unset($_SESSION['carrito']);
        header("Location: index.php?accion=carrito");
        exit();
    }

    public function confirmarPedido() {
        if (!isset($_SESSION['id_usuario']) || !isset($_SESSION['carrito'])) {
            echo "<script>alert('No hay productos en el carrito');</script>";
            require_once "Vista/html/carrito.php";
            return;
        }
        $id_usuario = $_SESSION['id_usuario'];
        $carrito = $_SESSION['carrito'];
        $fecha = date("Y-m-d");
        $estado = "Solicitado";
        $gestorTenis = new GestorTenis();
        foreach ($carrito as $id_producto => $cantidad) {
            $pedido = new Pedidos($id_usuario, $id_producto, $cantidad, $fecha, $estado);
            $resultado = $gestorTenis->crearPedidoDesdeCarrito($pedido);

            if ($resultado <= 0) {
                echo "<script>alert('Ocurrió un problema al registrar el pedido del producto ID $id_producto');</script>";
            }
        }
        unset($_SESSION['carrito']);
        echo "<script>alert('Compra realizada con éxito');</script>";
        require_once "Vista/html/carrito.php";
    }


}

?>