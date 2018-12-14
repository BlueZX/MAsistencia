<?php
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$idusuario=isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]):"";
$rut=isset($_POST["rut"]) ? limpiarCadena($_POST["rut"]):"";
$password=isset($_POST["password"]) ? limpiarCadena($_POST["password"]):"";
$image=isset($_POST["image"]) ? limpiarCadena($_POST["image"]):"";
$email=isset($_POST["email"]) ? limpiarCadena($_POST["email"]):"";
$fechaN=isset($_POST["fechaN"]) ? limpiarCadena($_POST["fechaN"]):"";
$direccion=isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]):"";
$numero=isset($_POST["numero"]) ? limpiarCadena($_POST["numero"]):"";
$status=isset($_POST["status"]) ? limpiarCadena($_POST["status"]):"";
$kind=isset($_POST["kind"]) ? limpiarCadena($_POST["kind"]):"";
$idcuadrilla=isset($_POST["idcuadrilla"]) ? limpiarCadena($_POST["idcuadrilla"]):"";

switch($_GET["op"]){
    case 'guardaryeditar':
        if (empty($idusuario)){
            $rspta=$usuario->insertar($nombre,$rut,$password,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla);
            echo $rspta ? "Usuario registrado": "Usuario no se pudo registrar";

        }
        else{
            $rspta=$usuario->editar($idusuario,$nombre,$rut,$password,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla);
            echo $rspta ? "Usuario actualizado": "Usuario no se pudo actualizar";
        }
    break;
    case 'desactivar':        
        $rspta=$usuario->desactivar($idusuario);
        echo $rspta ? "Usuario desactivado": "Usuario no se pudo desactivar";
    break;
    case 'activar':
        $rspta=$usuario->activar($idusuario);
        echo $rspta ? "Usuario activado": "Usuario no se pudo activar";
    break;
    case 'listar':
        $rspta = $usuario->listar();

        //Vamos a declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->idusuario,
                "1"=>$reg->nombre,
                "2"=>$reg->rut,
                "3"=>$reg->password,
                "4"=>$reg->image,
                "5"=>$reg->email,
                "6"=>$reg->fechaN,
                "7"=>$reg->direccion,
                "8"=>$reg->numero,
                "9"=>$reg->status,
                "10"=>$reg->kind,
                "11"=>$reg->idcuadrilla
            );
        }
        $results = array(
            //Información para el datatables
            "sEcho"=>1,
            //enviamos el total registros al datatable
            "iTotalRecords"=>count($data),
            //enviamos el total registros a visualizar
            "iTotalDisplayRecords"=>count($data),
            "aaData"=>$data
        );

        echo json_encode($results);
    break;
    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);

        //codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    default:
    break;
}
?>