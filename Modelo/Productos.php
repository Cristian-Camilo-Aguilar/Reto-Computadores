<?php

class Productos {

    private $nombre;
    private $descripcion;
    private $precio;
    private $id_categoria;
    private $cover;
    
    public function __construct($nombre,$precio, $descripcion,$id_categoria, $cover){
        $this->nombre=$nombre;
        $this->precio=$precio;
        $this->descripcion=$descripcion;
        $this->id_categoria=$id_categoria;
        $this->cover=$cover;
        
    }
    public function obtenerNombre(){
        return $this->nombre;
    }
    public function obtenerDescripcion(){
        return $this->descripcion;
    }
    public function obtenerPrecio(){
        return $this->precio;
    }
    public function obtenerIdCategoria(){
        return $this->id_categoria;
    }
    public function obtenerImagen(){
        return $this->cover;
    }

}

?>