<?php 
require "../config/Conexion.php";

Class Usuario{
    public function __construct(){

    }

    public function insertar($nombre,$rut,$password,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla){
        $sql="INSERT INTO `usuario`(`nombre`, `rut`, `password`, `image`, `email`, `fechaN`, `direccion`, `numero`, `status`, `kind`, `idcuadrilla`)
        VALUES ('$nombre','$rut','$password','$image','$email','$fechaN','$direccion','$numero','$status','$kind','$idcuadrilla')";

        return ejecutarConsulta($sql);
    }

    public function editar($idusuario,$nombre,$rut,$password,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla){
        $sql = "UPDATE usuario SET nombre='$nombre', rut='$rut',password='$password',image='$image',email='$email',fechaN='$fechaN',direccion='$direccion',numero='$numero',status='$status',kind='$kind',idcuadrilla='$idcuadrilla'
        WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);
    }

    public function desactivar($idusuario){
        $sql = "UPDATE usuario SET status='0' WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);
    }

    public function activar($idusuario){
        $sql = "UPDATE usuario SET status='1' WHERE idusuario='$idusuario'";

        return ejecutarConsulta($sql);
    }

    public function mostrar($idusuario){
        $sql = "SELECT * FROM usuario WHERE idusuario='$idusuario'";

        return ejecutarConsultaSimpleFila($sql);
    }

    public function listar(){
        $sql="SELECT u.idusuario, u.nombre, u.rut, u.password, u.image, u.email, u.fechaN, u.direccion, u.numero, u.status, u.kind, c.numero as cuadrilla FROM usuario u INNER JOIN cuadrilla c ON u.idcuadrilla=c.idcuadrilla";
        return ejecutarConsulta($sql);
    }
}
?>