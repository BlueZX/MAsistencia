$("#frmAcceso").on('submit',function(e){
    e.preventDefault();

    rut_a = $("#rut_a").val();
    pass_a = $("#pass_a").val();

    console.log("rut "+ rut_a + " pass: "+pass_a);

    $.post("../ajax/usuario.php?op=verificar",
    {"rut_a":rut_a,"pass_a":pass_a},
    function(data){
        if(data!="null"){
            $(location).attr("href","escritorio.php");
        }
        else{
            bootbox.alert("Usuario y/o contraseña incorrectos");
        }
    });
});