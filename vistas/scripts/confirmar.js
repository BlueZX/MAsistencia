let tabla;
function confirmar(idcuadrilla)
{
    $("#UsuariosPorConfirmar").show();
    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true, //activamos el procesamiento de datatable
        "aServerSide": true, // paginacion y filtrado a manos del servidor
        dom: 'Bfrtip', //definimos los elemetos de control de la tabla

        buttons: [], // parametro requerido del datatables

        "ajax":
        {
            url: "../ajax/registro.php?op=confirmar&idcuadrilla="+idcuadrilla,
            type: "get",
            dataType: "json",

        // funcion de error si es que falla el llamdo ajax
            /*error: function(e)
            {
                 console.log(e.responseText);
            }   */
        },

    "bDestroy": true,
    "iDisplayLength": 5, //Paginacion de 5 en 5
    "order": [[0,"desc"]]// Ordenar (columna, order)
    }).DataTable();
}

function asistir(idregistro)
{   
    bootbox.confirm("Estás seguro de cambiar el estado a ASISTIO?", function(result)
    {
        if(result) // Si se presiono el boton SI entonces el result sera verdadero
        {
            $.post("../ajax/registro.php?op=asistir", {idregistro : idregistro} ,function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }) // al activar el evento emengencias devuelve un string de si se logro o no cmabiar el estatus y se guarda en el parametro e
        }
    })
}

confirmar($("#idcuadrilla").val());