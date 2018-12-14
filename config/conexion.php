<?php
requiere_once "global.php";

$conexion = new Mysqli(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);

mysqli_query($conexion, 'SET NAME "'.DB_ENCODE.'"');

if(mysqli_connect_errno())
{
    printgf("Conexión fallida: %s\n",mysqli_connect_error());
    exit();
}

if(!function_exits("ejecutarConsulta"))
{
    function ejecutarConsulta($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }

    function ejecutarConsultaSimple($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        $fila = $query->fetch_assoc();
        return $fila;
    }

    function ejecutarConsulta_retornaID($sql)
    {
        global $conexion;
        $query = $conexion->query($sql);
        return $query->insert_id; // retorna la id de lo que recien se ingresa
    }

    function limpiarCadena($str)
    {
        global $conexion;
        $str = mysqli_real_escape_string($conexion,trim($str)); // trim elimina los espacios de la cadena
        return htmlspecialchars($str);
    }
}

?>

