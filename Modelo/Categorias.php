<?php

class Categorias {

    private $nombre;
    
    public function __construct($nombre){
        $this->nombre=$nombre;
    }
    public function obtenerNombre(){
        return $this->nombre;
    }

}

?>