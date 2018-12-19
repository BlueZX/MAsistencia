<?php 
require "../config/Conexion.php";

Class Permiso{
    public function __construct(){

    }

    public function listar(){
        $sql="SELECT * FROM permiso";
        return ejecutarConsulta($sql);
    }

}
?>