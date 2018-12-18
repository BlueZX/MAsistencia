let tabla // Es una version mas moderna de var;

function inicio ()
{
    mostrarform(false);
    listar();

    $("#formulario").on("submit",function(e)
    {
        // mediante jquery si el formulario activa el evento submit al hacer click en el boton btnGuardar entonces llamare a la funcion guardaryeditar
        guardaryeditar(e);
    })
}

function limpiar()
{
    $("#idcuadrilla").val("");
    $("#numero").val(""); // se crea el objeto numero y le paso un valor vacio
    $("#status").val("");
}

function mostrarform(flag) // si recibe un true muestra, si recibe un false esconde el formulario // boton agregar en las caudrillas
{
    limpiar();

    if(flag)
    {
        $("#listadocuadrilla").hide();
        $("#formulariocuadrilla").show();
        $("#btnGuardar").prop("disable",false); // cuando se muestra el formnulario cuadrilla se activa el boton guardar
    }
    else
    {
        $("#listadocuadrilla").show();
        $("#formulariocuadrilla").hide();
    }
}

function cancelarform()
{
    limpiar();
    mostrarform(false);
}

function listar()
{
    tabla=$('#tbllistado').dataTable(
        {
            "aProcessing": true, //activamos el procesamiento de datatable
            "aServerSide": true, // paginacion y filtrado a manos del servidor
            dom: 'Bfrtip', //definimos los elemetos de control de la tabla

            buttons: [], // parametro requerido del datatables

            "ajax": 
            {
                url: "../ajax/cuadrilla.php?op=listar",
                type: "get",
                datatype: "json",

                // funcion de error si es que falla el llamdo ajax
                error: function(e)
                {
                    console.log(e.responseText);
                }
            },

            "bDestroy": true,
            "iDisplayLength": 5, //Paginacion de 5 en 5
            "order": [[0,"desc"]]// Ordenar (columna, order)
        }
    ).DataTable();
}

function mostrar(idcuadrilla)
{   
    // se le pasa a la funcion mostrar por el metodo posto idcuadrilla, y la function recibe la informacion que retorna en data
    $.post("../ajax/cuadrilla.php?op=mostrar", {idcuadrilla : idcuadrilla}, function(data,status)
    {
        data = JSON.parse(data);
        mostrarform(true);

        $("#numero").val(data.numero);
        $("#idcuadrilla").val(data.idcuadrilla);
    });
}

function guardaryeditar(e)
{
    e.preventDefault(); //intruccion jquery para indicar que no se va activar la acción predeterminada del evento
    $("#btnGuardar").prop("disable",true);
    let formData= new FormData($("#formulario")[0]);

    $.ajax({
        url:"../ajax/cuadrilla.php?op=guardaryeditar",
        type: "POST",
        datatype: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload(); //se actualiza la tabla
        }

    }); //generar una peticion ajax
    limpiar();
}

function emergencias(idcuadrilla)
{   
    bootbox.confirm("Estás seguro de cambiar el estadoa a EMERGENCIAS?", function(result)
    {
        if(result) // Si se presiono el boton SI entonces el result sera verdadero
        {
            $.post("../ajax/cuadrilla.php?op=emergencias",{idcuadrilla : idcuadrilla} , function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }) // al activar el evento emengencias devuelve un string de si se logro o no cmabiar el estatus y se guarda en el parametro e
        }
    })
}


function noEmergencias(idcuadrilla)
{   
    bootbox.confirm("Estás seguro de cambiar el estado a NO EN EMERGENCIAS?", function(result)
    {
        if(result) // Si se presiono el boton SI entonces el result sera verdadero
        {
            $.post("../ajax/cuadrilla.php?op=noEmergencias", {idcuadrilla : idcuadrilla} ,function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }) // al activar el evento emengencias devuelve un string de si se logro o no cmabiar el estatus y se guarda en el parametro e
        }
    })
}



inicio();

