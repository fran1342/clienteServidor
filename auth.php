<?php

class Auth{

    private $curl;

    function __construct($token){

        $this->curl = curl_init('http://localhost:8001');

        curl_setopt(
            $this->curl,
            CURLOPT_HTTPHEADER,
            [
                "X-TOKEN: {$token}",
            ]
        );

        curl_setopt(
            $this->curl,
            CURLOPT_RETURNTRANSFER,
            true
        );

    }

    public function responseAuth(){
        return curl_exec($this->curl);
    }

    public function errorAuth(){
        return curl_errno($this->curl);
    }
}