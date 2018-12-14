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
            $rpst = $registro->insert($fecha, $idusuario);// retornara un 1 o un 0;
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
                "0"=>$reg->idregistro,
                "1"=>$reg->fecha,
                "2"=>$reg->status,
                "3"=>$reg->idusuario
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
}

?>