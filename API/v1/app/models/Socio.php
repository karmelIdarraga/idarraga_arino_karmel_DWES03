<?php
    class Socio extends Jugador{
        private $id;
        private $antiguedad;

        function __construct ($nombre, $edad, $nivel, $id, $antiguedad){
            parent::__construct($nombre, $edad, $nivel);
            $this->id=$id;
            $this->antiguedad=$antiguedad;
        }

        public function getId(){
            return $this->id;
        }

        public function getAntiguedad(){
            return $this->antiguedad;
        }
    }
?>