<?php

$nombreServidor = "127.0.0.1";
$nombreBaseDatos = "libreriaOnLine";
$nombreUsuario = "root";
$password = "chocolate";
// Conexion a mysql
$conexion = mysqli_connect($nombreServidor, $nombreUsuario, $password, $nombreBaseDatos);
// checar conexion
if(!$conexion) {
    die("La conexion fallo " . mysqli_connect_error());
}

echo "Conexion exitosa";
$query = "SELECT * FROM libros";
$resultado = $conexion->query($sql);
if($resultado){
    while($fila = $resultado->fetch_assoc()){
        echo $fila["title"].PHP_EOL;
    }
}