<?php

class Pista implements JsonSerializable{
    private $id;
    private $nombre;
    private $tipo;
    private $disponibilidad;

    function  __construct($id, $nombre, $tipo, $disponibilidad){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->disponibilidad = $disponibilidad;
    }

    public function getId(){
        return $this->id;
    }

    public function getNombre(){
        return $this->nombre;
    }
    
    public function getTipo(){
        return $this->tipo;
    }

    public function isDisponible(){
        return $this->disponibilidad;
    }

    public function reservar(){
        $this->disponibilidad = false;
    }

    public function jsonSerialize() {
        $pista = get_object_vars( $this );
        return $pista;
    }
}
?>