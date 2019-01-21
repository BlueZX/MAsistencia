<?php
require '../config/Conexion.php'; // Conexion a la base de datos

class Cuadrilla
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

    public function emergencias($idcuadrilla)
    {
        $sql = "UPDATE cuadrilla SET status ='0' WHERE idcuadrilla ='$idcuadrilla'";
        return ejecutarConsulta($sql);
    }

    public function noEmergencias($idcuadrilla)
    {
        $sql = "UPDATE cuadrilla SET status ='1' WHERE idcuadrilla ='$idcuadrilla'";
        return ejecutarConsulta($sql);
    }

    public function mostrar ($idcuadrilla)
    {
        $sql = "SELECT * FROM cuadrilla WHERE idcuadrilla='$idcuadrilla'";
        return ejecutarConsultaSimpleFila($sql); // solo se muestra la fila del id que se esta pidiendo
    }

    public function listar()
    {
        $sql = "SELECT *  FROM cuadrilla ";
        return ejecutarConsulta($sql); // devuelve todo lo de cuadrilla
    }

    public function listarCuadrilla($idcuadrilla)
    {
        $fecha_hoy = date('Y') . "-" . date('m') . "-" . date('d');
        $sql = "SELECT u.image, u.nombre, u.rut, u.kind, r.status  FROM cuadrilla c INNER JOIN usuario u ON c.idcuadrilla=u.idcuadrilla INNER JOIN registro r ON r.idusuario=u.idusuario WHERE c.idcuadrilla='$idcuadrilla' AND r.fecha='$fecha_hoy' ORDER BY u.kind DESC";
        return ejecutarConsulta($sql); // devuelve todo lo de cuadrilla
    }

    public function listarporConfirmar($idcuadrilla)
    {
        $sql = "SELECT u.image, u.nombre, u.rut, u.kind, r.status, r.idregistro  FROM cuadrilla c INNER JOIN usuario u ON c.idcuadrilla=u.idcuadrilla LEFT JOIN registro r ON r.idusuario=u.idusuario WHERE c.idcuadrilla='$idcuadrilla' AND r.status='2' AND u.kind='1'";
        return ejecutarConsulta($sql); // devuelve todo lo de cuadrilla
    }

    public function listarJefeCuadrilla($id){
        $sql = "SELECT u.image, u.nombre, u.rut, u.kind FROM usuario u WHERE u.idjefebase='$id' AND u.kind = 2 ";
        return ejecutarConsulta($sql); // devuelve todo lo de cuadrilla
    }

    public function listarporConfirmarJefeCuadrilla($id){
        $sql = "SELECT u.image, u.nombre, u.rut, u.kind, r.status, r.idregistro  FROM usuario u LEFT JOIN registro r ON r.idusuario=u.idusuario WHERE u.idjefebase='$id' AND r.status='2' AND u.kind='2'";
        return ejecutarConsulta($sql); // devuelve todo lo de cuadrilla
    }



}
?>
