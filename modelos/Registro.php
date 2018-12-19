<?php
require '../config/Conexion.php'; // Conexion a la base de datos

class Registro
{
    public function _construct()
    {
        // vacio porque al crear un objeto de la clase no se le pasa nada
    }

    public function insertar($fecha, $idusuario)
    {
        $sql = "INSERT INTO registro(fecha, status, idusuario) VALUES ('$fecha', '0', '$idusuario')";
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

    public function porConfirmar($idregistro)
    {
        $sql = "UPDATE registro SET status ='2' WHERE idregistro ='$idregistro'";
        return ejecutarConsulta($sql);
    }

    public function asistir ($idregistro)
    {
        $sql = "UPDATE registro SET status ='1' WHERE idregistro ='$idregistro'";
        return ejecutarConsulta($sql);
    }

    public function mostrar ($idregistro)
    {
        $sql = "SELECT * FROM registro  WHERE idregistro='$idregistro'";
        return ejecutarConsultaSimpleFila($sql); // solo se muestra la fila del id que se esta pidiendo
    }

    public function listar()
    {
        $sql = "SELECT u.nombre, u.rut, r.fecha, r.status, r.idregistro FROM registro r INNER JOIN usuario u ON r.idusuario=u.idusuario";
        return ejecutarConsulta($sql); // devuelve todo lo de registro
    }

    public function marcarAsistencia($fecha, $idusuario){
        $sql = "UPDATE registro SET status ='2' WHERE fecha='$fecha' AND idusuario='$idusuario'";
        //"INSERT INTO registro(fecha, status, idusuario) VALUES ('$fecha', '1', '$idusuario')";
        return ejecutarConsulta($sql);
    }

    public function asistenciaExistente($fecha, $idusuario){
        $sql = "SELECT * FROM registro WHERE fecha='$fecha' AND idusuario='$idusuario' AND (status='1' OR status='2') ";
        return ejecutarConsulta($sql);
    }

    public function registroHoyUser($fecha, $idusuario){
        $sql = "SELECT * FROM registro WHERE fecha='$fecha' AND idusuario='$idusuario'";
        return ejecutarConsulta($sql);
    }

    public function registrosDeHoy($fecha){
        $sql = "SELECT * FROM registro WHERE fecha='$fecha'";
        return ejecutarConsulta($sql);
    }


}
?>
