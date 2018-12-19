<?php 
require "../config/Conexion.php";

Class Usuario{
    public function __construct(){

    }

    public function insertar($nombre,$rut,$password,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla,$permisos){
        $sql="INSERT INTO `usuario`(`nombre`, `rut`, `password`, `image`, `email`, `fechaN`, `direccion`, `numero`, `status`, `kind`, `idcuadrilla`)
        VALUES ('$nombre','$rut','$password','$image','$email','$fechaN','$direccion','$numero','$status','$kind','$idcuadrilla')";

        //return ejecutarConsulta($sql);
        $idusuarionew = ejecutarConsulta_retornarID($sql);

        $num_elementos = 0;

        $sw = true;

        while($num_elementos < count($permisos)){
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos++;
        }

        return $sw;
    }

    public function editar($idusuario,$nombre,$rut,$password,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla,$permisos){
        $sql = "UPDATE usuario SET nombre='$nombre', rut='$rut',password='$password',image='$image',email='$email',fechaN='$fechaN',direccion='$direccion',numero='$numero',status='$status',kind='$kind',idcuadrilla='$idcuadrilla'
        WHERE idusuario='$idusuario'";

        ejecutarConsulta($sql);

        //ELIMINAR TODOS LOS PERMISOS ASIGNADOS PARA VOLVERLOS A REGISTAR
        $sqldel = "DELETE FROM usuario_permiso WHERE idusuario='$idusuario'";

        ejecutarConsulta($sqldel);

        $num_elementos = 0;

        $sw = true;

        while($num_elementos < count($permisos)){
            $sql_detalle = "INSERT INTO usuario_permiso(idusuario,idpermiso) VALUES('$idusuario', '$permisos[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos++;
        }

        return $sw;
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
        $sql="SELECT u.idusuario, u.nombre, u.rut, u.password, u.image, u.email, u.fechaN, u.direccion, u.numero, u.status, u.kind, c.numero as cuadrilla 
        FROM usuario u INNER JOIN cuadrilla c ON u.idcuadrilla=c.idcuadrilla";
        return ejecutarConsulta($sql);
    }

    public function listarBrigadistas(){
        $sql="SELECT u.idusuario, u.nombre, u.rut, u.password, u.image, u.email, u.fechaN, u.direccion, u.numero, u.status, u.kind, c.numero as cuadrilla 
        FROM usuario u INNER JOIN cuadrilla c ON u.idcuadrilla=c.idcuadrilla 
        WHERE kind=1";
        return ejecutarConsulta($sql);
    }

    public function listarJefesDeCuadrillas(){
        $sql="SELECT u.idusuario, u.nombre, u.rut, u.password, u.image, u.email, u.fechaN, u.direccion, u.numero, u.status, u.kind, c.numero as cuadrilla 
        FROM usuario u INNER JOIN cuadrilla c ON u.idcuadrilla=c.idcuadrilla 
        WHERE kind=2";
        return ejecutarConsulta($sql);
    }

    public function listarJefesDeBases(){
        $sql="SELECT u.idusuario, u.nombre, u.rut, u.password, u.image, u.email, u.fechaN, u.direccion, u.numero, u.status, u.kind, c.numero as cuadrilla 
        FROM usuario u INNER JOIN cuadrilla c ON u.idcuadrilla=c.idcuadrilla 
        WHERE kind=3";
        return ejecutarConsulta($sql);
    }

    public function listarMarcados($idusuario){
        $sql = "SELECT * FROM usuario_permiso WHERE idusuario = '$idusuario'";

        return ejecutarConsulta($sql);
    }

    //VERIFICAR ACCESSO AL SISTEMA
    public function verificar($rut,$password){
        $sql = "SELECT *
        FROM usuario 
        WHERE rut='$rut' AND password='$password' AND status='1'";

        return ejecutarConsulta($sql);
    }
}
?>