<?php

require_once 'Controlador/Controlador.php';
require_once 'Modelo/Conexion.php';
require_once 'Modelo/GestorTenis.php';
require_once 'Modelo/Productos.php';
require_once 'Modelo/Categorias.php';
require_once 'Modelo/Pedidos.php';
require_once 'Modelo/Estadisticas.php';

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
            $ruta_indexphp = "uploads";
            $extensiones = array('image/jpg', 'image/jpeg', 'image/png');
            $max_tamanyo = 1024 * 1024 * 16; // 16MB
            $nombres_archivos = array();

            // Normaliza para que siempre sea un array
            $files = $_FILES['cover'];
            if (!is_array($files['name'])) {
                // Si solo hay un archivo, lo convertimos a array
                foreach ($files as $k => $v) {
                    $files[$k] = array($v);
                }
            }

            foreach ($files['name'] as $key => $nombre_archivo) {
                $tipo = $files['type'][$key];
                $tamano = $files['size'][$key];
                $tmp_name = $files['tmp_name'][$key];

                if (in_array($tipo, $extensiones) && $tamano < $max_tamanyo) {
                    $nombre_archivo = time() . '_' . basename($nombre_archivo);
                    $ruta_nuevo_destino = $ruta_indexphp . '/' . $nombre_archivo;
                } else {
                    echo 'El archivo no es una imagen válida.';
                    exit;
                }
                if (move_uploaded_file($tmp_name, $ruta_nuevo_destino)) {
                    $nombres_archivos[] = $nombre_archivo;
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
                $_POST["nombre_categoria"]
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

        case "eliminar_imagen":
            $controlador->eliminarImagen($_GET['id_producto'], $_GET['nombre_archivo']);
            header("Location: index.php?accion=modificar&editar=" . $_GET['id_producto']);
            break;

        case "eliminarCategoria":
            $id = $_GET["id"];
            $controlador->eliminarCategoria($id);
            break;

        case "eliminarProducto":
            $id = $_GET["id"];
            $controlador->eliminarProducto($id);
            break;

        case "actualizarEstadoPedido":
            $id = $_POST["id"];
            $estado = $_POST["estado"];
            $resultado = $controlador->actualizarEstadoPedido($id, $estado);
            header('Content-Type: application/json');
            echo json_encode([
                'title' => $resultado ? 'Actualizado' : 'Error',
                'text' => $resultado ? 'Estado actualizado correctamente.' : 'No se pudo actualizar el estado.',
                'icon' => $resultado ? 'success' : 'error'
            ]);
            exit();
        
        case "agregarImagenModificada":
            $id = $_POST["id"];
            $archivo = $_FILES["nueva_imagen"];
            $controlador->agregarImagen($id, $archivo);
            break;

        case "modificarProducto":
            $controlador->modificarProducto(
                $_POST["id"],
            $_POST["marca"],
                $_POST["modelo"],
                $_POST["tipo"],
                $_POST["precio"],
                $_POST["especificaciones"]
            );
            break;

        case "agregarAlCarrito":
            if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
                $id_producto = intval($_GET["id"]);
                if (!isset($_SESSION['carrito'])) {
                    $_SESSION['carrito'] = [];
                }
                if (isset($_SESSION['carrito'][$id_producto])) {
                    $_SESSION['carrito'][$id_producto]++;
                } else {
                    $_SESSION['carrito'][$id_producto] = 1;
                }
            }
            header("Location: index.php?accion=carrito");
            exit();

        case "vaciarCarrito":
            $controlador->vaciarCarrito();
            break;

        case "confirmarPedido":
            $controlador->confirmarPedido();
            break;

        case "verProducto":
            $id = $_GET["id"] ?? null;
            if ($id && is_numeric($id)) {
                $controlador->verpagina('Vista/html/verProducto.php');
            }
            break;

        case "carrito":
            $controlador->verpagina('Vista/html/carrito.php');
            break;

        case "verEstadisticas":
            $controlador->consultarEstadisticas();
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

        case "pedidosrealizados":
            $controlador->verpagina('Vista/html/pedidosrealizados.php');
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

        case "modificar":
            $controlador->verpagina('Vista/html/modificar.php');
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