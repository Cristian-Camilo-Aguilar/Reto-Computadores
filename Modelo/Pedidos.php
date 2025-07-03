<?php

class Pedidos {

    private $id_usuario;
    private $id_producto;
    private $cantidad;
    private $fecha;
    private $estado;
    
    public function __construct($id_usuario, $id_producto, $cantidad, $fecha, $estado){
        $this->id_usuario=$id_usuario;
        $this->id_producto=$id_producto;
        $this->cantidad=$cantidad;
        $this->fecha=$fecha;
        $this->estado=$estado;
        
    }
    public function obtenerIdUsuario(){
        return $this->id_usuario;
    }
    public function obtenerIdProducto(){
        return $this->id_producto;
    }
    public function obtenerCantidad(){
        return $this->cantidad;
    }

    public function obtenerFecha(){
        return $this->fecha;
    }
    public function obtenerEstado(){
        return $this->estado;
    }

}

?>