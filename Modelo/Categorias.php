<?php

class Categorias {

    private $nombre_categoria;
    
    public function __construct($nombre_categoria){
        $this->nombre_categoria=$nombre_categoria;
    }
    public function obtenerNombre(){
        return $this->nombre_categoria;
    }

}

?>