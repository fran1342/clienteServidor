<?php

class ErrorResponse{

    private $code;
    private $error;
    private $message;

    function __construct($code,$error,$message){
        $this->code = $code;
        $this->error = $error;
        $this->message = $message;
    }

    public function getCode(){
        return $this->code;
    }

    public function getError(){
        return $this->error;
    }

    public function getMessage(){
        return $this->message;
    }

}