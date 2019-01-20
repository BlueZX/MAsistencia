<?php
session_start();
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
$permisos=isset($_POST['permiso']) ? $_POST['permiso']:[];

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

        //Hash SHA256 en el pass
        $clavehash=hash("SHA256",$password);

        if (empty($idusuario)){
            $rspta=$usuario->insertar($nombre,$rut,$clavehash,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla, $permisos);
            echo $rspta ? "Usuario registrado": "No se pudo registrar todos los datos del usuario";

        }
        else{
            $rspta=$usuario->editar($idusuario,$nombre,$rut,$password,$image,$email,$fechaN,$direccion,$numero,$status,$kind,$idcuadrilla, $permisos);
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

    case 'permisos':
        //Se obtienen todos los permisos de la tabla permisos
        require_once '../modelos/Permiso.php';
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        //SE OBTIENEN PERMISOS ASIGNADO AL USUARIO
        $id = $_GET['id'];
        $marcados = $usuario->listarMarcados($id);
        $valores = array();

        while($per = $marcados->fetch_object()){
            array_push($valores, $per->idpermiso);
        }

        //SE MUESTRA LA LISTA DE PERMISOS EN LA VISTA
        while($reg = $rspta->fetch_object()){
            $sw = in_array($reg->idpermiso,$valores)? 'checked':'';
            echo '<li><input type="checkbox" name="permiso[]" value="'. $reg->idpermiso .'"' . $sw . ' > ' . $reg->nombre . '</li>';
        }
    break;

    case 'mostrar':
        $rspta = $usuario->mostrar($idusuario);

        //codificar el resultado utilizando json
        echo json_encode($rspta);
    break;

    case 'selectJB':

        $rspta = $usuario->listarJefesDeBases();

        while($reg = $rspta->fetch_object()){
            echo '<option value=' . $reg->idusuario . '>' . $reg->nombre . '</option>';
        }
    break;
    
    case 'selectCuadrilla':
        require_once "../modelos/Cuadrilla.php";
        $cuadrilla = new Cuadrilla();

        $rspta = $cuadrilla->listar();

        while($reg = $rspta->fetch_object()){
            echo '<option value=' . $reg->idcuadrilla . '>' . $reg->numero . '</option>';
        }
    break;

    case 'verificar':
        $rut_a = $_POST['rut_a'];
        $pass_a = $_POST['pass_a'];

        //HASH SHA256 EN EL PASS
        $pass_hash = hash("SHA256",$pass_a);

        $rspta = $usuario->verificar($rut_a, $pass_hash);

        $fetch = $rspta->fetch_object();

        if(isset($fetch)){
            //SE DECLARAN VARIABLES DE SESSION
            $_SESSION['idusuario'] = $fetch->idusuario;
            $_SESSION['nombre'] = $fetch->nombre;
            $_SESSION['image'] = $fetch->image;
            $_SESSION['rut'] = $fetch->rut;
            $_SESSION['idcuadrilla'] = $fetch->idcuadrilla;
            $_SESSION['kind'] = $fetch->kind;
            
            $marcados = $usuario->listarMarcados($fetch->idusuario);

            $valores = array();

            while($per = $marcados->fetch_object()){
                array_push($valores, $per->idpermiso);
            }

            in_array(1,$valores)? $_SESSION['escritorio']=1:$_SESSION['escritorio']=0;
            in_array(2,$valores)? $_SESSION['mantenedores']=1:$_SESSION['mantenedores']=0;
            in_array(3,$valores)? $_SESSION['masistencia']=1:$_SESSION['masistencia']=0;
            in_array(4,$valores)? $_SESSION['tucuadrilla']=1:$_SESSION['tucuadrilla']=0; 

            require_once '../modelos/Registro.php';
            $registro = new Registro();
            
            $rspta = $usuario->listar();

            while($reg=$rspta->fetch_object()){
                $rspt = $registro->registroHoyUser(date("Y-m-d"),$reg->idusuario);

                $fet = $rspt->fetch_object();

                if(!isset($fet)){
                    $registro->insertar(date("Y-m-d"),$reg->idusuario);
                }
            }
        }
        echo json_encode($fetch);
    break;
    case 'salir':
        session_unset();

        session_destroy();

        header("Location: ../index.php");
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