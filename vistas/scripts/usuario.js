let tabla;


function init(){
    mostrarform(false);
    listar();

    $("#formulario").on("submit", function(e){
        guardaryeditar(e);
    });

    //SE CARGAN LOS ITEM DE LA CUADRILLA AL SELECT
    $.post("../ajax/usuario.php?op=selectCuadrilla", function(r){
        $("#idcuadrilla").html(r);
        $("#idcuadrilla").selectpicker('refresh');
    });

    $.post("../ajax/usuario.php?op=selectJB", function(r){
        $("#idjefebase").html(r);
        $("#idjefebase").selectpicker('refresh');
    });
    $("#imagenmuestra").hide();

    //SE MUESTRAN LOS PERMISOS
    $.post("../ajax/usuario.php?op=permisos&id=", function(r){
        $("#permisos").html(r);
    });

}


function limpiar(){
    $("#idusuario").val("");
    $("#idcuadrilla").val("");
    $("#nombre").val("");
    $("#password").val("");
    $("#direccion").val("");
    $("#rut").val(""); 
    $("#numero").val(""); 
    $("#fechaN").val(""); 
    $("#direccion").val(""); 
    $("#kind").val(""); 
    $("#email").val(""); 
    $("#imagenmuestra").attr("src","../files/usuarios/no-image.png");
    $("#imagenactual").val("");
}

function mostrarform(flag){
    limpiar();
    if(flag){
        $("#listadoregistro").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
    }
    else{
        $("#listadoregistro").show();
        $("#formularioregistros").hide();
    }
}

function cancelarform(){
    limpiar();
    mostrarform(false);
}

function listar(){
    tabla=$('#tbllistado').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax":{
            url: '../ajax/usuario.php?op=listar',
            type: "get",
            dataType:"json",
            error: function(e){
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5,
        "order": [[0, "desc"]]
    }).DataTable();
}

function guardaryeditar(e){
    //CON ESTO NO SE ACTIVARA LA ACCION PREDERTMINADA DEL EVENTO
    e.preventDefault();
    $("#btnGuardar").prop("disabled",true);
    let formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: '../ajax/usuario.php?op=guardaryeditar',
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos){
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }
    });
    limpiar();
}

function mostrar(idusuario){
    $.post("../ajax/usuario.php?op=mostrar",{idusuario: idusuario}, function(data,status){
        data = JSON.parse(data);
        mostrarform(true);

        $("#idusuario").val(data.idusuario);
        $("#nombre").val(data.nombre);
        $("#password").val(data.password);
        $("#direccion").val(data.direccion);
        $("#rut").val(data.rut); 
        $("#numero").val(data.numero); 
        $("#idcuadrilla").val(data.idcuadrilla); 
        $("#idcuadrilla").selectpicker('refresh'); 
        $("#fechaN").val(data.fechaN);
        $("#kind").val(data.kind); 
        $("#kind").selectpicker('refresh'); 
        $("#email").val(data.email); 
        $("#imagenmuestra").show();
        $("#imagenmuestra").attr("src","../files/usuarios/"+data.image);
        $("#imagenactual").val(data.image);

    });

    $.post("../ajax/usuario.php?op=permisos&id="+idusuario, function(r){
        $("#permisos").html(r);
    });
}

function desactivar(idusuario){
    bootbox.confirm("¿Estás seguro de desactivar el usuario?",function(result){
        if(result){
            $.post("../ajax/usuario.php?op=desactivar",{idusuario:idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

function activar(idusuario){
    bootbox.confirm("¿Estás seguro de activar el usuario?",function(result){
        if(result){
            $.post("../ajax/usuario.php?op=activar",{idusuario:idusuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            });
        }
    });
}

init();