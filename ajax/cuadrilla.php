<?php
require_once '../modelos/Cuadrilla.php';

$cuadrilla= new Cuadrilla();

//isset()Determina si una variable está definida y no es NULL // el $_post envia la variable idcategoria (leida de la pag web) para que luego isset verifique si existe.
$idcuadrilla= isset($_POST["idcuadrilla"])? limpiarCadena($_POST["idcuadrilla"]): "";
$numero = isset($_POST["numero"])? limpiarCadena($_POST["numero"]): "";
$status = isset($_POST["status"])? limpiarCadena($_POST["status"]): "";

//cuando hagan un llamado a este archivo ajax y le envien mediante el metodo $_GET (mediante la URL-- ajax ve por URL) una operacion, yo voy a evaluar que instruccion realizar y retorno un valor.
switch ($_GET["op"]) 
{
    case 'guardaryeditar':
        if(empty ($idcuadrilla)) //empty es para ver si la variable esta vacia
        {
            $rpst = $cuadrilla->insertar($numero);// retornara un 1 o un 0;
            echo $rpst? "cuadrilla registrado" : "No se pudo registrar";
        }
        else
        {
            $rpst = $cuadrilla->editar($idcuadrilla, $numero);
            echo $rpst? "cuadrilla editado" : "No se pudo editar";
        }
    break;

    case 'emergencias':
        $rpst = $cuadrilla->emergencias($idcuadrilla);
        echo $rpst? "cuadrillano en emergencia" : "No se pudo cambiar el estado";
    break;

    case 'noEmergencias':
        $rpst = $cuadrilla->noEmergencias($idcuadrilla);
        echo $rpst? "cuadrilla en estado normal" : "No se pudo cambiar el estado";
    break;

    case 'mostrar':
        $rpst = $cuadrilla->mostrar($idcuadrilla);
        echo json_encode($rpst); // el metodo mostrar devuelve un array asi que lo codifico con json_encode para poder mostrar le respuesta en la pag.
    break;

    case 'listar':
        $rpst = $cuadrilla->listar();
        
        $data = Array();

        while ($reg=$rpst->fetch_object()) //fetch_object() Devuelve la fila actual de un conjunto de resultados como un objeto // recorrera el while hasta que ya no hayan mas filas.
        {
            $data[]=array(
                "0"=>$reg->numero,
                "1"=>($reg->status)?'<span class="label bg-green">NO EN EMERGENCIAS</span>':'<span class="label bg-red">EN EMERGENCIA</span>',
                "2"=>($reg->status)? '<button class="btn btn-warning" onclick="mostrar('.$reg->idcuadrilla.')"><i class="fa fa-pencil"></i></button> ' . ' <button class="btn btn-danger" onclick="emergencias('.$reg->idcuadrilla.')"><i class="fa fa-close"></i></button>' : ' <button class="btn btn-warning" onclick="mostrar('.$reg->idcuadrilla.')"><i class="fa fa-pencil"></i></button> ' . ' <button class="btn btn-success" onclick="noEmergencias('.$reg->idcuadrilla.')"><i class="fa fa-check"></i></button>'
                                    
            );
        }
        $results = array(
            "sEcho"=>1, // Informacion para el datables
            "iTotalRecord"=>count($data), // enviamos el total de cuadrillas al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total cuadrillas a visualizar
            "aaData"=>$data
        );
        echo json_encode($results);
    break;
}

?>