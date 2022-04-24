<?php

class DataBase{
    private const nombreServidor = "localhost"; // es igual a localhost
    private const nombreBaseDatos = "libreriaonline";
    private const nombreUsuario = "root";
    private const password = "";
    private $client;

    //Conexion a mysql
    function __construct(){
        $this->client = mysqli_connect(self::nombreServidor, self::nombreUsuario, self::password, self::nombreBaseDatos);
    }
    // checar conexion
    function connect(){
        
        if ( mysqli_connect_error($this->client)) {
            return false;
        }

        return true;
    }
//Libros
    function getBooks(){
        $books = [];

        if($this->connect()){
            $sql = "SELECT * FROM libro";
            $resultado= $this->client->query($sql);

            if ($resultado) {
                while($fila=$resultado->fetch_assoc()){
                    $books[]=$fila;
                }
            }
            return $books;
        }
        return $books;
    }

    function getBook($id){
        $book;

        if($this->connect()){
            $sql = "SELECT * FROM libro WHERE id={$id}";
            $resultado= $this->client->query($sql);

            if ($resultado) {
                while($fila=$resultado->fetch_assoc()){
                    $book=$fila;
                }
            }
            return $book;
        }
        return $book;
    }

    function createBook($book){

        if($this->connect()){
            $sql= sprintf("INSERT INTO libro VALUES(NULL,'%s','%s','%s','%s','%s',%d)",
            $book->titulo,
            $book->descripcion,
            $book->isbn,
            $book->año_publicacion,
            $book->tipo,
            $book->id_editorial
            );
            $resultado = $this->client->query($sql);
            if ($resultado) {
                $book->id = $this->client->insert_id;
            }
            return $book;
        }
        return $book;
    }

    function updateBook($id,$book){
        if ($this->connect()) {
            $newTittle=$book->titulo;
            $newDescription=$book->descripcion;
            $newIsbn=$book->isbn;
            $newAño=$book->año_publicacion;
            $newTipo=$book->tipo;
            $newIdEditorial=$book->id_editorial;
            $sql="UPDATE libro SET titulo='$newTittle',descripcion='$newDescription',isbn='$newIsbn',año_publicacion='$newAño',tipo='$newTipo',id_editorial='$newIdEditorial' WHERE id={$id}";
            $resultado = $this->client->query($sql);
            if ($resultado) {
                if($this->client->affected_rows > 0){
                    $book->id = $id;
                    return $book;
                }
            }
            return [];
        }
        return [];
    }

    function deleteBook($id){
        if ($this->connect()) {
            $sql = "DELETE FROM libro WHERE id={$id}";
            $resultado = $this->client->query($sql);
            if ($resultado) {
                $book=$resultado;
                return $book;
            }
        }
    }
//Genders

    function getGenders(){
        $genders = [];

        if($this->connect()){
            $sql = "SELECT * FROM genero";
            $resultado= $this->client->query($sql);

            if ($resultado) {
                while($fila=$resultado->fetch_assoc()){
                    $genders[]=$fila;
                }
            }
            return $genders;
        }
        return $genders;
    }

    function getGender($id){
        $gender;

        if($this->connect()){
            $sql = "SELECT * FROM genero WHERE id={$id}";
            $resultado= $this->client->query($sql);

            if ($resultado) {
                while($fila=$resultado->fetch_assoc()){
                    $gender=$fila;
                }
            }
            return $gender;
        }
        return $gender;
    }

    function createGender($gender){

        if($this->connect()){
            $sql= sprintf("INSERT INTO genero VALUES(NULL,'%s','%s')",
            $gender->nombre,
            $gender->descripcion
            );
            $resultado = $this->client->query($sql);
            if ($resultado) {
                $gender->id = $this->client->insert_id;
            }
            return $gender;
        }
        return $gender;
    }

    function updateGender($id,$gender){
        if ($this->connect()) {
            $newName=$gender->nombre;
            $newDesc=$gender->descripcion;
            $sql="UPDATE genero SET nombre='$newName',descripcion='$newDesc' WHERE id={$id}";
            $resultado = $this->client->query($sql);
            if ($resultado) {
                if($this->client->affected_rows > 0){
                    $gender->id = $id;
                    return $gender;
                }
            }
            return [];
        }
        return [];
    }

    function deleteGender($id){
        if ($this->connect()) {
            $sql = "DELETE FROM genero WHERE id={$id}";
            $resultado = $this->client->query($sql);
            if ($resultado) {
                $gender=$resultado;
                return $gender;
            }
        }
    }

    //Authors
    function getAuthors(){
        $authors = [];

        if($this->connect()){
            $sql = "SELECT * FROM autor";
            $resultado= $this->client->query($sql);

            if ($resultado) {
                while($fila=$resultado->fetch_assoc()){
                    $authors[]=$fila;
                }
            }
            return $authors;
        }
        return $authors;
    }

    function getAuthor($id){
        $author;

        if($this->connect()){
            $sql = "SELECT * FROM autor WHERE id={$id}";
            $resultado= $this->client->query($sql);

            if ($resultado) {
                while($fila=$resultado->fetch_assoc()){
                    $author=$fila;
                }
            }
            return $author;
        }
        return $author;
    }

    function createAuthor($author){

        if($this->connect()){
            $sql= sprintf("INSERT INTO autor VALUES(NULL,'%s','%d')",
            $author->url_web,
            $author->id_persona
            );
            $resultado = $this->client->query($sql);
            if ($resultado) {
                $author->id = $this->client->insert_id;
            }
            return $author;
        }
        return $author;
    }

    function updateAuthor($id,$author){
        if ($this->connect()) {
            $newUrl=$author->url_web;
            $newPer=$author->id_persona;
            $sql="UPDATE autor SET url_web='$newUrl',id_persona='$newPer' WHERE id={$id}";
            $resultado = $this->client->query($sql);
            if ($resultado) {
                if($this->client->affected_rows > 0){
                    $author->id = $id;
                    return $author;
                }
            }
            return [];
        }
        return [];
    }

    function deleteAuthor($id){
        if ($this->connect()) {
            $sql = "DELETE FROM autor WHERE id={$id}";
            $resultado = $this->client->query($sql);
            if ($resultado) {
                $author=$resultado;
                return $author;
            }
        }
    }

    function close(){
        mysqli_close($this->client);
    }
}