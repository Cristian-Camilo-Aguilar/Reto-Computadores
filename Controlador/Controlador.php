<?php
function mostrarSweetAlert($mensaje, $tipo = 'info', $redireccion = 'index.php') {
    $urlAbsoluta = "http://localhost/computadores_cristian/" . ltrim($redireccion, '/');
    $msg = urlencode($mensaje);
    $tipo = urlencode($tipo);
    $redir = urlencode($urlAbsoluta);
    header("Location: Vista/html/alerta.php?msg=$msg&tipo=$tipo&redir=$redir");
    exit();
}
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
            mostrarSweetAlert('Usuario o Contraseña incorrectos', 'error', 'index.php?accion=loginadmin');
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
            mostrarSweetAlert('Usuario incorrecto', 'error', 'index.php?accion=logincliente');
        }
    }
    public function registrarCliente($nombre, $correo, $contrasena, $rol){
        $gestorTenis= new GestorTenis();
        $result=$gestorTenis->registrarCliente($nombre, $correo, $contrasena, $rol);
        if ($result > 0) {
            mostrarSweetAlert('Usuario registrado con éxito', 'success', 'index.php?accion=pedido');
        } else {
            mostrarSweetAlert('El usuario no se registró', 'error', 'index.php?accion=registro');
        }
    }
    public function crearProducto($nombre, $marca, $modelo, $tipo, $precio, $especificaciones){
        $productos = new Productos($nombre, $marca, $modelo, $tipo, $precio, $especificaciones);
        $gestorTenis = new GestorTenis();
        $id_producto = $gestorTenis->CrearProducto($productos);
        if ($id_producto > 0) {
            mostrarSweetAlert('Producto agregado con éxito', 'success', 'index.php?accion=admin');
        } else {
            mostrarSweetAlert('Producto no se guardó', 'error', 'index.php?accion=admin');
        }
        return $id_producto;
    }
    public function guardarImagen($id_producto, $nombre_archivo) {
        $gestorTenis = new GestorTenis();
        $gestorTenis->guardarImagen($id_producto, $nombre_archivo);
    }
    public function crearPedido($id_usuario, $id_producto, $cantidad, $fecha, $estado){
        $pedido = new Pedidos($id_usuario, $id_producto, $cantidad, $fecha, $estado);
        $gestorTenis = new GestorTenis();
        $result = $gestorTenis->CrearPedido($pedido);
        if ($result > 0) {
            mostrarSweetAlert('Pedido agregado con éxito', 'success', 'index.php?accion=pedido');
        } else {
            mostrarSweetAlert('Pedido no se guardó', 'error', 'index.php?accion=pedido');
        }
    }
    public function crearCategoria($nombre_categoria){
        $categoria = new Categorias($nombre_categoria);
        $gestorTenis = new GestorTenis();
        $result = $gestorTenis->CrearCategoria($categoria);
        if ($result > 0) {
            mostrarSweetAlert('Categoría agregada con éxito', 'success', 'index.php?accion=categorias');
        } else {
            mostrarSweetAlert('La categoría no se guardó', 'error', 'index.php?accion=categorias');
        }
    }
    public function eliminarCategoria($id){
        $gestorTenis = new GestorTenis();
        if ($gestorTenis->categoriaTieneProductos($id)) {
            mostrarSweetAlert('No se puede eliminar la categoría porque está asociada a productos', 'warning', 'index.php?accion=categorias');
            return;
        }
        $result = $gestorTenis->eliminarCategoria($id);
        if ($result > 0) {
            mostrarSweetAlert('Categoría eliminada con éxito', 'success', 'index.php?accion=categorias');
        } else {
            mostrarSweetAlert('Error al eliminar la categoría', 'error', 'index.php?accion=categorias');
        }
    }
    public function eliminarProducto($id){
        $gestorTenis = new GestorTenis();
        if ($gestorTenis->tieneRelacionesProductos($id)) {
            mostrarSweetAlert('No se puede eliminar el producto porque está relacionado con una categoría', 'warning', 'index.php?accion=admin');
            return;
        }
        $result = $gestorTenis->eliminarProducto($id);
        if ($result > 0) {
            mostrarSweetAlert('Producto eliminado con éxito', 'success', 'index.php?accion=admin');
        } else {
            mostrarSweetAlert('Error al eliminar el producto', 'error', 'index.php?accion=admin');
        }
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
                mostrarSweetAlert('Imagen agregada exitosamente', 'success', 'index.php?accion=modificar&id=' . $id_producto);
            } else {
                mostrarSweetAlert('Error al guardar la imagen en el servidor', 'error', 'index.php?accion=modificar&id=' . $id_producto);
            }
        } else {
            mostrarSweetAlert('Formato de imagen no permitido', 'warning', 'index.php?accion=modificar&id=' . $id_producto);
        }
    }
    public function modificarProducto($id, $marca, $modelo, $tipo, $precio, $especificaciones) {
        $gestor = new GestorTenis();
        $result = $gestor->actualizarProducto($id, $marca, $modelo, $tipo, $precio, $especificaciones);
        if ($result > 0) {
            mostrarSweetAlert('Producto modificado correctamente', 'success', 'index.php?accion=modificar&id=' . $id);
        } else {
            mostrarSweetAlert('No se pudo modificar el producto', 'error', 'index.php?accion=modificar&id=' . $id);
        }
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
            mostrarSweetAlert('No hay productos en el carrito', 'warning', 'index.php?accion=carrito');
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
                mostrarSweetAlert("Error al registrar el producto ID $id_producto", 'error', 'index.php?accion=carrito');
                return;
            }
        }
        unset($_SESSION['carrito']);
        mostrarSweetAlert('Compra realizada con éxito', 'success', 'index.php?accion=carrito');
    }

}

?>