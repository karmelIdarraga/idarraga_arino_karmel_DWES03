<?php

class Jugador implements JsonSerializable{

    protected $nombre;
    protected $edad;
    protected $nivel;

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