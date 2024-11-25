<?php

require_once "../PHP/conexion.php";

class Producto extends Conexion{
    function obtenerproductos(){
        $query = $this->obtenerConexion()->query("SELECT * FROM Producto");
       
        return $query;
       
    }
}
?>