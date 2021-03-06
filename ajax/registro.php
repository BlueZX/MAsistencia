<?php
require_once '../modelos/Registro.php';

$registro = new Registro();

//isset()Determina si una variable está definida y no es NULL // el $_post envia la variable idcategoria (leida de la pag web) para que luego isset verifique si existe.
$idregistro = isset($_POST["idregistro"])? limpiarCadena($_POST["idregistro"]): "";
$fecha = isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]): "";
$status = isset($_POST["status"])? limpiarCadena($_POST["status"]): "";
$idusuario = isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]): "";
//cuando hagan un llamado a este archivo ajax y le envien mediante el metodo $_GET (mediante la URL-- ajax ve por URL) una operacion, yo voy a evaluar que instruccion realizar y retorno un valor.
switch($_GET["op"])
{
    case 'guardaryeditar':
        if(empty ($idregistro)) //empty es para ver si la variable esta vacia
        {
            $rpst = $registro->insertar($fecha, $idusuario);// retornara un 1 o un 0;
            echo $rpst? "Registro registrado" : "No se pudo registrar";
        }
        else
        {
            $rpst = $registro->editar($idregistro, $fecha, $idusuario);
            echo $rpst? "Registro editado" : "No se pudo editar";
        }
    break;

    case 'noAsistir':
        $rpst = $registro->noAsistir($idregistro);
        echo $rpst? "Registro no asistio" : "No se pudo cambiar el estado";
    break;

    case 'asistir':
        $rpst = $registro->asistir($idregistro);
        echo $rpst? "Registro asistio" : "No se pudo cambiar el estado";
    break;

    case 'mostrar':
        $rpst = $registro->mostrar($idregistro);
        echo json_encode($rpst); // el metodo mostrar devuelve un array asi que lo codifico con json_encode para poder mostrar le respuesta en la pag.
    break;

    case 'listar':
        $rpst = $registro->listar();
        
        $data = Array();

        while ($reg=$rpst->fetch_object()) //fetch_object() Devuelve la fila actual de un conjunto de resultados como un objeto // recorrera el while hasta que ya no hayan mas filas.
        {
            $data[]=array(
                "0"=>$reg->nombre,
                "1"=>$reg->rut,
                "2"=>$reg->fecha,
                "3"=>estadoAsistencia($reg->status),
                "4"=>estadoBotones($reg->status,$reg->idregistro)
            );
        }
        $results = array(
            "sEcho"=>1, // Informacion para el datables
            "iTotalRecord"=>count($data), // enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data
        );
        echo json_encode($results);
    break;

    case 'selectUsuario':
        require_once "../modelos/Usuario.php";
        $usuario = new Usuario();

        $rspta = $usuario->listar();

        while($reg = $rspta->fetch_object()){
            echo '<option value=' . $reg->idusuario . '>' . $reg->nombre . '</option>'; //el option va a mostrar las opciones relacionadas al idusuario y se mostrara el nombre del usuario.
        }
    break;

    case 'marcar':
        $rpst = $registro->asistenciaExistente(date("Y-m-d"), $idusuario);

        $fetch = $rpst->fetch_object();

        if(!isset($fetch)){
            $rpst = $registro->marcarAsistencia(date("Y-m-d"), $idusuario);// retornara un 1 o un 0;
            echo $rpst? "se ha registrado la asistencia" : "No se pudo registrar la asistencia";
        }
        else{
            echo 'hoy ya se registro asistencia';
        }
    break;
    case 'cancelarMarcar':
        $rpst = $registro->asistenciaExistente(date("Y-m-d"), $idusuario);

        $fetch = $rpst->fetch_object();

        if(isset($fetch)){
            $rpst = $registro->cancelarAsistencia(date("Y-m-d"), $idusuario);// retornara un 1 o un 0;
            echo $rpst? "se ha cancelado la asistencia" : "No se pudo cancelar la asistencia";
        }
        else{
            echo 'no posee asistencia para cancelar';
        }
    break;

    case 'confirmar': 
        
        $aux = $_GET['idcuadrilla'];
        $tipo = $_GET['tipo'];
        require_once '../modelos/Cuadrilla.php';
        
         $cuadrilla= new Cuadrilla();

         if($tipo == 3){
            $rpst = $cuadrilla->listarporConfirmarJefeCuadrilla($_GET['id']);
         }else if($tipo == 2){
            $rpst = $cuadrilla->listarporConfirmar($aux);
         }

         $data2 = Array();

          while($reg=$rpst->fetch_object())
          {
            $data2[]=array(
            "0"=>"<img src='../files/usuarios/".$reg->image."' height='50px' width='50px'>",
            "1"=>$reg->nombre,
            "2"=>$reg->rut,
            "3"=>$reg->fecha,
            "4"=>estadoAsistencia($reg->status),
            "5"=>estadoBotoness($reg->status,$reg->idregistro)
             );
          }
        $results = array(
            "sEcho"=>1, // Informacion para el datables
            "iTotalRecord"=>count($data2), // enviamos el total de registros al datatable
            "iTotalDisplayRecords"=>count($data2), //enviamos el total registros a visualizar
            "aaData"=>$data2
        );
        echo json_encode($results);
    break; 
}

function estadoAsistencia($status){
    switch($status){
        case 1:
            return '<span class="label bg-green">ASISTIO</span>';
        break;
        case 0:
            return '<span class="label bg-red">NO ASISTIO</span>';
        break;
        case 2:
            return '<span class="label bg-yellow">POR CONFIRMAR</span>';
        break;
    }
}

function estadoBotones($status,$idregistro){
    switch($status){
        case 1:
            return '<button class="btn btn-warning" onclick="mostrar('.$idregistro.')"><i class="fa fa-pencil"></i></button> ' . '<button class="btn btn-danger" onclick="noAsistir('.$idregistro.')"><i class="fa fa-close"></i></button>';
        break;
        case 0:
            return '<button class="btn btn-warning" onclick="mostrar('.$idregistro.')"><i class="fa fa-pencil"></i></button> ' . '<button class="btn btn-success" onclick="asistir('.$idregistro.')"><i class="fa fa-check"></i></button>';
        break;
        case 2:
        return '<button class="btn btn-warning" onclick="mostrar('.$idregistro.')"><i class="fa fa-pencil"></i></button> ' . '<button class="btn btn-success" onclick="asistir('.$idregistro.')"><i class="fa fa-check"></i></button>';
        break;
    }
}

function estadoBotoness($status,$idregistro){
    switch($status){
        case 1:
            return  '<button class="btn btn-danger" onclick="noAsistir('.$idregistro.')"><i class="fa fa-close"></i></button>';
        break;
        case 0:
            return  '<button class="btn btn-success" onclick="asistir('.$idregistro.')"><i class="fa fa-check"></i></button>';
        break;
        case 2:
        return '<button class="btn btn-success" onclick="asistir('.$idregistro.')"><i class="fa fa-check"></i></button>';
        break;
    }
}


?>