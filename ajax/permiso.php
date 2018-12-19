<?php
require_once "../modelos/Permiso.php";

$permiso = new Permiso();

switch($_GET["op"]){

    case 'listar':
        $rspta = $permiso->listar();

        //Vamos a declarar un array
        $data = Array();

        while($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->nombre
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