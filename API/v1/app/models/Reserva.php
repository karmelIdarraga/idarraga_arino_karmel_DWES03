<?php

class Reserva implements JsonSerializable{

    private $id;
    private $pista;
    private $fecha;
    private $hora_inicio;
    private $hora_fin;
    private $cliente;
    private $estado;
    private $jugador2;
    private $jugador3;
    private $jugador4;

    function __construct($id, $pista,$fecha, $hora_inicio, $hora_fin, $cliente, $estado, $jugador2, $jugador3, $jugador4){
        $this->id = $id;
        $this->pista = $pista;
        $this->fecha = $fecha;
        $this->hora_inicio = $hora_inicio;
        $this->hora_fin = $hora_fin;
        $this->cliente = $cliente;
        $this->estado = $estado;
        $this->jugador2 = $jugador2;
        $this->jugador3 = $jugador3;
        $this->jugador4 = $jugador4;        
    }

    public function getId(){
        return $this->id;
    }

    public function setEstado ($estado){
        $this->estado = $estado;
    }

    public function getEstado (){
        return $this->estado;
    }

    public function setJugador2 ($jugador){
        $this->jugador2 = $jugador;
    }

    public function setJugador3 ($jugador){
        $this->jugador3 = $jugador;
    }

    public function setJugador4 ($jugador){
        $this->jugador4 = $jugador;
    }


    public function jsonSerialize() {
        $reserva = get_object_vars( $this );
        return $reserva;
    }

}

?>