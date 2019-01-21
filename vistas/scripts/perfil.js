function init(){

    $('#hh1').hide();
    $('#hh2').hide();
    $('#hh3').hide();
    $('#hh4').hide();
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
    $("#idjefebase").val("");
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

function cancelarform(){
    limpiar();
    location.href='/masistencia/vistas/escritorio.php';
}

function guardaryeditar(e){

    $("#idjefebase").prop('disabled', false);
    $("#idcuadrilla").prop('disabled', false);
    $("#rut").prop('disabled', false);
    $("#idjefebase").selectpicker('refresh');
    $("#idcuadrilla").selectpicker('refresh');
    
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
    location.href='/masistencia/vistas/escritorio.php';
}

function mostrar(idusuario){
    $.post("../ajax/usuario.php?op=mostrar",{idusuario: idusuario}, function(data,status){
        data = JSON.parse(data);

        $("#idusuario").val(data.idusuario);
        $("#nombre").val(data.nombre);
        $("#password").val(data.password);
        $("#direccion").val(data.direccion);
        $("#rut").val(data.rut); 
        $("#numero").val(data.numero); 
        $("#idjefebase").val(data.idjefebase);
        $("#idjefebase").selectpicker('refresh'); 
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

init();

$("#kind").change(function() {
    if($("#kind").val() == 3){
        $("#idcuadrilla").val(0);
        //$("#idjefebase option[value='']").attr('selected', true)
        $("#idjefebase").val(null);
        $("#idcuadrilla").prop('disabled', 'disabled');
        $("#idjefebase").prop('disabled', 'disabled');
        $("#idjefebase").selectpicker('refresh');
        $("#idcuadrilla").selectpicker('refresh');
    }else{
        $("#idjefebase").prop('disabled', false);
        $("#idcuadrilla").prop('disabled', false);
        $("#idjefebase").selectpicker('refresh');
        $("#idcuadrilla").selectpicker('refresh');
    }
});