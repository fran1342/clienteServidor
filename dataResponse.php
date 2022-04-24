<?php

class DataResponse{
    private $code;
    private $data;

    function __construct($code,$data){
        $this->code = $code;
        $this->data = $data;
    }

    function getCode(){
        return $this->code;
    }

    function getData(){
        return $this->data;
    }
}