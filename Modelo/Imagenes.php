<?php

class Imagenes {

    private $id_producto;
    private $nombre_archivo;

    public function __construct($id_producto, $nombre_archivo) {
        $this->id_producto = $id_producto;
        $this->nombre_archivo = $nombre_archivo;
    }

    public function obtenerIdProducto() {
        return $this->id_producto;
    }

    public function obtenerNombreArchivo() {
        return $this->nombre_archivo;
    }
}

?>