<?php

class PistasController {

    const PATH_PISTAS = '../app/models/pistas.json';
    private $pistas = array();

    function __construct(){

        $jsonString = file_get_contents($this::PATH_PISTAS);
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
            $response = new Response(CodigosRespuesta::HTTP_NO_CONTENT, "No se han encontrado pistas");
            echo json_encode ($response);
        }        
    }

    public function getPistaById($id){
        $pista = null;
        foreach ($this->pistas as $pistaSel){
            if ($pistaSel->getId()==$id){
                $pista = $pistaSel;
                break;
            }
        }
        if ($pista != null){
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_OK));
            $response = new Response(CodigosRespuesta::HTTP_OK, $pista );
            echo json_encode ($response);
        }else{
            header(CodigosRespuesta::httpHeaderFor(CodigosRespuesta::HTTP_OK));
            $response = new Response(CodigosRespuesta::HTTP_NO_CONTENT, "No se ha encontrado pista con id ". $id);
            echo json_encode ($response);
        }

    }

}

?>