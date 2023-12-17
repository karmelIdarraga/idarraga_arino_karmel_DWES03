<?php

class Response implements JsonSerializable{

    private $code;
    private $body;
        
    function __construct($code, $body){
        $this->code = $code;
        $this->body = $body;
    }

    public function jsonSerialize() {
        $response = get_object_vars( $this );
        return $response;
    }
    
}

?>
