<?php

class PistasController {

    private $pistas = array();

    function __construct(){

        $jsonString = file_get_contents('../app/models/pistas.json');
        $datos = json_decode($jsonString,true);
        foreach ($datos as $pista){
            array_push($this->pistas, new Pista($pista['id'], $pista['nombre'], $pista['tipo'], $pista['disponibilidad']));
        }
    }

    public function getAll(){
        if (!empty($this->pistas)){
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_OK));
            $response = new Response(CodigosRespuesta::HTTP_OK, $this->pistas );
            echo json_encode ($response);
        }else{
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_NO_CONTENT));
            $response = new Response(CodigosRespuesta::HTTP_NO_CONTENT, $this->pistas);
            echo json_encode ($response);
        }
        
    }

}

?>