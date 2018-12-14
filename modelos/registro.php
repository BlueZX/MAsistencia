<?php
require "../config/conexion.php"; // Conexion a la base de datos

class registro
{
    public function _construct()
    {
        // vacio porque al crear un objeto de la clase no se le pasa nada
    }

    public function insertar($fecha, $idusuario)
    {
        $sql = "INSERT INTO registro(fecha, status, idusuario) VALUES ('$fecha', '1', '$idusuario')";
        return ejecutarConsulta($sql); 
        // retorna 0 o 1 
    }

    public function editar($idregistro, $fecha, $idusuario)
    {
        $sql = "UPDATE registro SET fecha ='$fecha', idusuario='$idusuario' WHERE idregistro='$idregistro' ";
        return ejecutarConsulta($sql);
    }

    public function noAsistir($idregistro)
    {
        $sql = "UPDATE registro SET status ='0' WHERE idregistro ='$idregistro'";
        return ejecutarConsulta($sql);
    }

    public function asistir ($idregistro)
    {
        $sql = "UPDATE registro SET status ='1' WHERE idregistro ='$idregistro'";
        return ejecutarConsulta($sql);
    }

    public function mostrar ($idregistro)
    {
        $sql = "SELECT * FROM registro WHERE idregistro='$idregistro'"
        return ejecutarConsultaSimpleFila($sql); // solo se muestra la fila del id que se esta pidiendo
    }

    public function listar()
    {
        $sql = "SELECT * FROM registro'"
        return ejecutarConsulta($sql); // devuelve todo lo de registro
    }
}
?>