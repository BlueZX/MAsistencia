function asisti(idusuario){
    $.post("../ajax/registro.php?op=marcar",{idusuario:idusuario}, function(e){
        bootbox.alert(e);
    });
}