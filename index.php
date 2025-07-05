<?php

require_once 'Controlador/Controlador.php';
require_once 'Modelo/Conexion.php';
require_once 'Modelo/GestorTenis.php';
require_once 'Modelo/Productos.php';
require_once 'Modelo/Categorias.php';
require_once 'Modelo/Pedidos.php';

session_start();
$controlador = new Controlador;

if (isset($_GET["accion"])) {
    switch ($_GET["accion"]) {
        case "vista":
            $controlador->verpagina('Vista/html/catalogo.php');
            break;

        case "login":
            $controlador->login(
                $_POST["correo"],
                $_POST["contrasena"]
            );
            break;

        case "ingresarcliente":
            $controlador->loginCliente(
                $_POST["correo"],
                $_POST["contrasena"]
            );
            break;

        case "registrar":
            $controlador->registrarCliente(
                $_POST["nombre"],
                $_POST["correo"],
                $_POST["contrasena"],
                $_POST["rol"]
            );
            break;

        case "crearProducto":
            // Datos de la imagen y el producto
            $ruta_indexphp = "uploads";
            $extensiones = array('image/jpg', 'image/jpeg', 'image/png');
            $max_tamanyo = 1024 * 1024 * 16; // 16MB
            // Array para almacenar los nombres de las imágenes subidas
            $nombres_archivos = array(); 
            // Subir todas las imágenes
            foreach ($_FILES['cover']['name'] as $key => $nombre_archivo) {
                $tipo = $_FILES['cover']['type'][$key];
                $tamano = $_FILES['cover']['size'][$key];
                $tmp_name = $_FILES['cover']['tmp_name'][$key];

                // Verificamos que la extensión sea válida y el tamaño sea correcto
                if (in_array($tipo, $extensiones) && $tamano < $max_tamanyo) {
                    // Crear una ruta única para la imagen (puedes agregar un prefijo único para evitar sobreescribir)
                    $nombre_archivo = time() . '_' . basename($nombre_archivo);
                    $ruta_nuevo_destino = $ruta_indexphp . '/' . $nombre_archivo;
                } else {
                    echo 'El archivo no es una imagen válida.';
                    exit;
                }
                    // Mover el archivo a la carpeta de destino
                    if (move_uploaded_file($tmp_name, $ruta_nuevo_destino)) {
                        $nombres_archivos[] = $nombre_archivo; // Guardamos el nombre de la imagen para agregarla al producto
                    }
                }
            // Resto de los datos del formulario
            $nombre = $_POST["nombre"];
            $especificaciones = $_POST["especificaciones"];
            $precio = $_POST["precio"];
            $marca = $_POST["marca"];
            $modelo = $_POST["modelo"];
            $tipo = $_POST["tipo"];
            $id_producto = $controlador->crearProducto($nombre, $marca, $modelo, $tipo, $precio, $especificaciones);
            // Ahora guardamos las imágenes asociadas a ese producto
            foreach ($nombres_archivos as $file) {
                // Guardamos la imagen en la tabla de imágenes
                $controlador->guardarImagen($id_producto, $file);
            }
            break;

        case "crearCategoria":
            $controlador->crearCategoria(
                $_POST["nombre"]
            );
            break;

        case "crearPedido":
            $controlador->crearPedido(
                $_POST["id_usuario"],
                $_POST["id_producto"],
                $_POST["cantidad"],
                $_POST["fecha"],
                $_POST["estado"]
            );
            break;

        case "eliminarCategoria":
            $id = $_GET["id"];
            $controlador->eliminarCategoria($id);
            break;

        case "eliminarProducto":
            $id = $_GET["id"];
            $controlador->eliminarProducto($id);
            break;

        case "cambiarEstadoPedido":
            $id = $_GET["id"];
            $controlador->cambiarEstadoPedido($id);
            break;

        case "loginadmin":
            $controlador->verpagina('Vista/html/login.html');
            break;

        case "logincliente":
            $controlador->verpagina('Vista/html/logincliente.html');
            break;

        case "pedido":
            $controlador->verpagina('Vista/html/pedido.php');
            break;

        case "registro":
            $controlador->verpagina('Vista/html/registro.html');
            break;

        case "categorias":
            $controlador->verpagina('Vista/html/categorias.php');
            break;

        case "pedidosclientes":
            $controlador->verpagina('Vista/html/pedidosclientes.php');
            break;

        case "admin":
            $controlador->verpagina('Vista/html/admin.php');
            break;

        case "logout":
            session_unset();
            session_destroy();
            header("Location: index.php?accion=vista");
            break;

        default:
            $controlador->verpagina('Vista/html/catalogo.php');
            break;
    }
} else {
    $controlador->verpagina('Vista/html/catalogo.php');}

?>