<?php

require_once 'Controlador/Controlador.php';
require_once 'Modelo/Conexion.php';
require_once 'Modelo/GestorTenis.php';
require_once 'Modelo/Productos.php';
require_once 'Modelo/Categorias.php';
require_once 'Modelo/Pedidos.php';

session_start();
$controlador = new Controlador;
if (isset($_GET["accion"])){
    if ($_GET["accion"]== "vista"){
        $controlador ->verpagina('Vista/html/catalogo.php');
    
    }
    elseif($_GET["accion"] == "login"){
        $controlador->login(
            $_POST["correo"],
            $_POST["contrasena"]
        );
    }elseif($_GET["accion"] == "ingresarcliente"){
        $controlador->loginCliente(
            $_POST["correo"],
            $_POST["contrasena"]
        );
    }elseif ($_GET["accion"] == "registrar"){
        $controlador ->registrarCliente(
            $_POST["nombre"],
            $_POST["correo"],
            $_POST["contrasena"],
            $_POST["rol"]
        );

    }elseif ($_GET["accion"] == "crearProducto") {
        $ruta_indexphp = "uploads";
        $extensiones = array('image/jpg', 'image/jpeg', 'image/png');
        $max_tamanyo = 1024 * 1024 * 8; 
        $cover = $_FILES['cover']['name'];
        $ruta_fichero_origen = $_FILES['cover']['tmp_name'];
        $ruta_nuevo_destino = $ruta_indexphp . '/' . $cover;
        $subida_correcta = false;
        if (in_array($_FILES['cover']['type'], $extensiones)) {
            if ($_FILES['cover']['size'] < $max_tamanyo) {
                if (move_uploaded_file($ruta_fichero_origen, $ruta_nuevo_destino)) {
                    $subida_correcta = true;
                } else {
                    echo "<script>alert('Error al subir la imagen');</script>";
                }
            } else {
                echo "<script>alert('La imagen es demasiado grande');</script>";
            }
        } 
            $controlador->crearProducto(
                $_POST["nombre"],
                $_POST["precio"],
                $_POST["descripcion"],
                $_POST["id_categoria"],
                $cover
            );

    }elseif ($_GET["accion"] == "crearCategoria"){
        $controlador->crearCategoria(
                $_POST["nombre"]
            );

    }elseif ($_GET["accion"] == "crearPedido"){
        $controlador->crearPedido(
                $_POST["id_usuario"],
                $_POST["id_producto"],
                $_POST ["cantidad"],
                $_POST ["fecha"],
                $_POST ["estado"]
            );

    }elseif ($_GET["accion"] == "eliminarCategoria"){
        $id = $_GET["id"];
        $controlador ->eliminarCategoria($id);
    }elseif ($_GET["accion"] == "eliminarProducto"){
        $id = $_GET["id"];
        $controlador ->eliminarProducto($id);
    }elseif ($_GET["accion"] == "cambiarEstadoPedido") {
        $id = $_GET["id"];
        $controlador->cambiarEstadoPedido($id);
    }elseif ($_GET["accion"] == "loginadmin"){
        $controlador ->verpagina('Vista/html/login.html');
    }elseif ($_GET["accion"] == "logincliente"){
        $controlador ->verpagina('Vista/html/logincliente.html');
    }elseif ($_GET["accion"] == "pedido"){
        $controlador ->verpagina('Vista/html/pedido.php');
    }elseif ($_GET["accion"] == "registro"){
        $controlador ->verpagina('Vista/html/registro.html');
    }elseif ($_GET["accion"] == "categorias"){
        $controlador ->verpagina('Vista/html/categorias.php');
    }elseif ($_GET["accion"] == "pedidosclientes"){
        $controlador ->verpagina('Vista/html/pedidosclientes.php');
    }elseif ($_GET["accion"] == "admin"){
        $controlador ->verpagina('Vista/html/admin.php');
    }elseif ($_GET["accion"] == "logout") {
        session_unset();
        session_destroy();
        header("Location: index.php?accion=vista");
        exit();
    }
}
else {
    $controlador -> verpagina('Vista/html/catalogo.php');
}

?>