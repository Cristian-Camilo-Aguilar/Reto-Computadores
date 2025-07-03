<?php

class Productos {

    private $marca;
    private $modelo;
    private $tipo;
    private $precio;
    private $especificaciones;
    private $id_categoria;
    private $cover;
    
    public function __construct($marca, $modelo, $tipo, $precio, $especificaciones, $id_categoria, $cover){
        $this->marca=$marca;
        $this->modelo=$modelo;
        $this->tipo=$tipo;
        $this->precio=$precio;
        $this->especificaciones=$especificaciones;
        $this->id_categoria=$id_categoria;
        $this->cover=$cover;
        
    }
    public function obtenerMarca(){
        return $this->marca;
    }
    public function obtenerModelo(){
        return $this->modelo;
    }
    public function obtenerTipo(){
        return $this->tipo;
    }
    public function obtenerPrecio(){
        return $this->precio;
    }
    public function obtenerEspecificaciones(){
        return $this->especificaciones;
    }
    public function obtenerIdCategoria(){
        return $this->id_categoria;
    }
    public function obtenerImagen(){
        return $this->cover;
    }

}

?>