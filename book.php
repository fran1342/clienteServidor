<?php

class Book{
    public $id;
    public $titulo;
    public $descripcion;
    public $isbn;
    public $año_publicacion;
    public $tipo;
    public $id_editorial;

    function __construct($book){
        $this->id=$book['id'];
        $this->titulo=$book['titulo'];
        $this->descripcion=$book['descripcion'];
        $this->isbn=$book['isbn'];
        $this->año_publicacion=$book['año_publicacion'];
        $this->tipo=$book['tipo'];
        $this->id_editorial=$book['id_editorial'];
    }
}