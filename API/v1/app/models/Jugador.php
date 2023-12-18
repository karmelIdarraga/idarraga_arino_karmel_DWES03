<?php

class Jugador implements JsonSerializable{

    protected $nombre;
    protected $edad;
    protected $nivel;

    function __construct($nombre, $edad, $nivel){
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->nivel = $nivel;

    }

    public function getNivel(){
        return $this->nivel;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function getEdad(){
        return $this->edad;
    }

    public function jsonSerialize() {
        $jugador = get_object_vars( $this );
        return $jugador;
    }

}
?>