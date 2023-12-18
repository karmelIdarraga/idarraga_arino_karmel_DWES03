<?php

class ReservasController {

    const PATH_RESERVAS = '../app/models/reservas.json';
    private $reservas = array();

    function __construct(){

        $jsonString = file_get_contents($this::PATH_RESERVAS);
        $datos = json_decode($jsonString,true);
        foreach ($datos as $reserva){
            $jugador2 = null;
            $jugador3 = null;
            $jugador4 = null;
            if (!empty($reserva['jugador2'])) {
                $jugador2 = new Jugador($reserva['jugador2']['nombre'], $reserva['jugador2']['edad'], $reserva['jugador2']['nivel']);
            }
            if (!empty($reserva['jugador3'])) {
                $jugador3 = new Jugador($reserva['jugador3']['nombre'], $reserva['jugador3']['edad'], $reserva['jugador3']['nivel']);
            }
            if (!empty($reserva['jugador4'])) {
                $jugador4 = new Jugador($reserva['jugador4']['nombre'], $reserva['jugador4']['edad'], $reserva['jugador4']['nivel']);
            }
            array_push($this->reservas, new Reserva($reserva['id'], $reserva['pista'],$reserva['fecha'], $reserva['hora_inicio'], $reserva['hora_fin'], $reserva['cliente'], $reserva['estado'], $jugador2, $jugador3, $jugador4));
        }
    }


    public function getAll(){
        if (!empty($this->reservas)){
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_OK));
            $response = new Response(CodigosRespuesta::HTTP_OK, $this->reservas );
            echo json_encode ($response);
        }else{
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_NO_CONTENT));
            $response = new Response(CodigosRespuesta::HTTP_NO_CONTENT, "No se han encontrado reservas");
            echo json_encode ($response);
        }        
    }

    public function addReserva ($reserva){
        $reservaObj = new Reserva($this->getNextId(), $reserva['id_pista'],$reserva['fecha'], $reserva['hora_inicio'], $reserva['hora_fin'], $reserva['cliente'], "pendiente", null, null, null);
        // Al crear una nueva reserva se crea en estado pendiente y sin jugadores más allá del cliente que la realiza
        array_push($this->reservas, $reservaObj);
        $this->guardarReservas();
        header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_CREATED));
        $response = new Response(CodigosRespuesta::HTTP_CREATED, $reservaObj);
        echo json_encode ($response);
    }

    public function confirmarReserva ($id, $datos){
        $encontrado = false;
        for ($i=0; $i<sizeof($this->reservas);$i++){
            if (intval($this->reservas[$i]->getId()) == intval($id)){
                if ($this->reservas[$i]->getEstado()=='pendiente'){
                    if (!empty($datos['jugador2'])) {
                        $jugador2 = new Jugador($datos['jugador2']['nombre'], $datos['jugador2']['edad'], $datos['jugador2']['nivel']);
                        $this->reservas[$i]->setJugador2($jugador2);
                    }
                    if (!empty($datos['jugador3'])) {
                        $jugador3 = new Jugador($datos['jugador3']['nombre'], $datos['jugador3']['edad'], $datos['jugador3']['nivel']);
                        $this->reservas[$i]->setJugador3($jugador3);
                    }
                    if (!empty($datos['jugador4'])) {
                        $jugador4 = new Jugador($datos['jugador4']['nombre'], $datos['jugador4']['edad'], $datos['jugador4']['nivel']);
                        $this->reservas[$i]->setJugador4($jugador4);
                    }
                    $this->reservas[$i]->setEstado("confirmada");
                    $encontrado = true;
                    $this->guardarReservas();
                    header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_ACCEPTED));
                    $response = new Response(CodigosRespuesta::HTTP_ACCEPTED, $this->reservas[$i]);
                    echo json_encode ($response);
                    break;
                }else{
                    header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_NOT_ACCEPTABLE));
                    $response = new Response(CodigosRespuesta::HTTP_NOT_ACCEPTABLE, "La reserva con id ". $id . " ya esta confirmada por lo que no se puede confirmar");
                    echo json_encode ($response);
                    $encontrado = true;
                    break;
                }
                
            }
        }
        if (!$encontrado){
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_ACCEPTED));
            $response = new Response(CodigosRespuesta::HTTP_NO_CONTENT, "No se ha encontrado ninguna reserva con id ". $id);
            echo json_encode ($response);
        }
    }

    public function deleteReserva($id){
        $encontrado = false;
        for ($i=0; $i<sizeof($this->reservas);$i++){
            if (intval($this->reservas[$i]->getId()) == intval($id)){
                unset($this->reservas[$i]);
                $encontrado = true;
                $this->guardarReservas();
                header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_OK));
                $response = new Response(CodigosRespuesta::HTTP_OK,"Se ha eliminado de la lista la reserva con id ". $id);
                echo json_encode ($response);
                break;
            }
        }
        if (!$encontrado){
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_ACCEPTED));
            $response = new Response(CodigosRespuesta::HTTP_NO_CONTENT, "No se ha encontrado ninguna reserva con id ". $id);
            echo json_encode ($response);
        }  
    }


    private function getNextId(){
        $idMayor = 0;
        foreach ($this->reservas as $reserva){
            if (intval($reserva->getId()) > intval($idMayor)){
                $idMayor = $reserva->getId();
            }
        }
        return $idMayor+1;
    }

    private function guardarReservas(){
        $json_string = json_encode($this->reservas);
        file_put_contents($this::PATH_RESERVAS, $json_string);
    }

}

?>