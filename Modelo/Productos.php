<?php

class Productos {

    private $nombre;
    private $marca;
    private $modelo;
    private $tipo;
    private $precio;
    private $especificaciones;
    
    public function __construct($nombre,$marca, $modelo, $tipo, $precio, $especificaciones){
        $this->nombre=$nombre;
        $this->marca=$marca;
        $this->modelo=$modelo;
        $this->tipo=$tipo;
        $this->precio=$precio;
        $this->especificaciones=$especificaciones;
        
    }
    public function obtenerNombre(){
        return $this->nombre;
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

}

?>