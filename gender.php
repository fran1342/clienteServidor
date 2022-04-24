<?php

class Gender{
    public $id;
    public $nombre;
    public $descripcion;

    function __construct($gender){
        $this->id=$gender['id'];
        $this->nombre=$gender['nombre'];
        $this->descripcion=$gender['descripcion'];
    }
}