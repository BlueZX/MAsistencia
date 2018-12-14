<?php
require "../config/conexion.php"; // Conexion a la base de datos

class cuadrilla
{
    public function _construct()
    {
        // vacio porque al crear un objeto de la clase no se le pasa nada
    }

    public function insertar($numero)
    {
        $sql = "INSERT INTO cuadrilla(numero, status) VALUES ('$numero', '1')";
        return ejecutarConsulta($sql); 
        // retorna 0 o 1 
    }

    public function editar($idcuadrilla, $numero)
    {
        $sql = "UPDATE cuadrilla SET numero ='$numero' WHERE idcuadrilla='$idcuadrilla' ";
        return ejecutarConsulta($sql);
    }

    public function emergencia($idcuadrilla)
    {
        $sql = "UPDATE cuadrilla SET status ='2' WHERE idcuadrilla ='$idcuadrilla'";
        return ejecutarConsulta($sql);
    }

    public function noEmergencias ($idcuadrilla)
    {
        $sql = "UPDATE cuadrilla SET status ='1' WHERE idcuadrilla ='$idcuadrilla'";
        return ejecutarConsulta($sql);
    }

    public function mostrar ($idcuadrilla)
    {
        $sql = "SELECT * FROM cuadrilla WHERE idcuadrilla='$idcuadrilla'"
        return ejecutarConsultaSimpleFila($sql); // solo se muestra la fila del id que se esta pidiendo
    }

    public function listar()
    {
        $sql = "SELECT * FROM cuadrilla'"
        return ejecutarConsulta($sql); // devuelve todo lo de cuadrilla
    }
}
?>