<?php
require_once "../modelos/Usuario.php";

$usuario = new Usuario();

$idusuario=isset($_POST["idusuario"]) ? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"]) ? limpiarCadena($_POST["nombre"]):"";
$rut=isset($_POST["rut"]) ? limpiarCadena($_POST["rut"]):"";
$password=isset($_POST["password"]) ? limpiarCadena($_POST["password"]):"";
$image=isset($_POST["image"]) ? limpiarCadena($_POST["image"]):"no-image.png";
$email=isset($_POST["email"]) ? limpiarCadena($_POST["email"]):"";
$fechaN=isset($_POST["fechaN"]) ? limpiarCadena($_POST["fechaN"]):date("Y-m-d");
$direccion=isset($_POST["direccion"]) ? limpiarCadena($_POST["direccion"]):"";
$numero=isset($_POST["numero"]) ? limpiarCadena($_POST["numero"]):"";
$status=isset($_POST["status"]) ? limpiarCadena($_POST["status"]):1;
$kind=isset($_POST["kind"]) ? limpiarCadena($_POST["kind"]):1;
$idcuadrilla=isset($_POST["idcuadrilla"]) ? limpiarCadena($_POST["idcuadrilla"]):1;

switch($_GET["op"]){
    case 'guardaryeditar':

        if(!file_exists($_FILES['image']['tmp_name']) || !is_uploaded_file($_FILES['image']['tmp_name'])){
            $image = $_POST["imagenactual"];
        }
        else{
            $ext = explode(".", $_FILES["image"]["name"]);
            if($_FILES['image']['type'] == "image/jpg" || $_FILES['image']['type'] == "image/jpeg" || $_FILES['image']['type'] == "image/png" || $_FILES['image']['type'] == "image/gif"){
                $image = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES['image']["tmp_name"], "../files/usuarios/" . $image);
            }
        }

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
                "0"=>"<img src='../files/usuarios/".$reg->image."' height='50px' width='50px'>",
                "1"=>$reg->nombre,
                "2"=>$reg->rut,
                "3"=>$reg->direccion,
                "4"=>$reg->fechaN,
                "5"=>$reg->email,
                "6"=>$reg->numero,
                "7"=>$reg->cuadrilla,
                "8"=>tipoUser($reg->kind),
                "9"=>($reg->status)?'<span class="label bg-green">Activo</span>':'<span class="label bg-red">Inactivo</span>',
                /*"10"=>$reg->kind,
                "11"=>$reg->idcuadrilla,*/
                "10"=>($reg->status)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>' .
                ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
                '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>' .
                ' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',
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
    
    case 'selectCuadrilla':
        require_once "../modelos/Cuadrilla.php";
        $cuadrilla = new Cuadrilla();

        $rspta = $cuadrilla->listar();

        while($reg = $rspta->fetch_object()){
            echo '<option value=' . $reg->idcuadrilla . '>' . $reg->numero . '</option>';
        }
    break;
    default:
    break;
}

function tipoUser($kind){
    switch($kind){
        case 1:
            return "brigadista";
        break;
        case 2:
            return "Jefe de cuadrilla";
        break;
        case 3:
            return "Jefe de base";
        break;
    }
}
?>