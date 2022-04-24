<?php

class Author{
    public $id;
    public $url_web;
    public $id_persona;

    function __construct($author){
        $this->id=$author['id'];
        $this->url_web=$author['url_web'];
        $this->id_persona=$author['id_persona'];
    }
}