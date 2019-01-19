/* validacion de rut ---------------------------------------------------------------------------------------------------------------------------*/
function checkRutFieldGeneral(id_rut) {
    var rut = $("#" + id_rut).val();
    var rut_campo = $("#" + id_rut);
    var tmpstr = "";

    for (i = 0; i < rut.length; i++)
        if (rut.charAt(i) != ' ' && rut.charAt(i) != '.' && rut.charAt(i) != '-')
            tmpstr = tmpstr + rut.charAt(i);
    rut = tmpstr;
    largo = rut.length;
    tmpstr = "";
    for (i = 0; rut.charAt(i) == '0'; i++)
        ;
    for (; i < rut.length; i++)
        tmpstr = tmpstr + rut.charAt(i);
    rut = tmpstr;
    largo = rut.length;

    if (largo < 2) {
        // alert("Debe ingresar el rut completo.");
//        mensajes_alert("Alerta", "Debe ingresar el rut completo.", '3');
        //mensajes_alert_id('Debe ingresar el rut completo.', false, rut_campo);
        rut_campo.val('');
        rut_campo.focus();
        rut_campo.select();
        return false;
    }
    for (i = 0; i < largo; i++) {
        if (rut.charAt(i) != "0" && rut.charAt(i) != "1" && rut.charAt(i) != "2" && rut.charAt(i) != "3" && rut.charAt(i) != "4" && rut.charAt(i) != "5" && rut.charAt(i) != "6" && rut.charAt(i) != "7" && rut.charAt(i) != "8" && rut.charAt(i) != "9" && rut.charAt(i) != "k" && rut.charAt(i) != "K") {
            // alert("El valor ingresado no corresponde a un R.U.T valido.");
//            mensajes_alert("Alerta", "El valor ingresado no corresponde a un R.U.T valido.", '3');
            //mensajes_alert_id('El valor ingresado no corresponde a un R.U.T valido.', id_rut);
            rut_campo.val('');
            rut_campo.focus();
            rut_campo.select();
            return false;
        }
    }
    var invertido = "";
    for (i = (largo - 1), j = 0; i >= 0; i--, j++)
        invertido = invertido + rut.charAt(i);
    var drut = "";
    drut = drut + invertido.charAt(0);
    drut = drut + '-';
    cnt = 0;
    for (i = 1, j = 2; i < largo; i++, j++) {
        if (cnt == 3) {
            drut = drut + '.';
            j++;
            drut = drut + invertido.charAt(i);
            cnt = 1;
        } else {
            drut = drut + invertido.charAt(i);
            cnt++;
        }
    }
    invertido = "";
    for (i = (drut.length - 1), j = 0; i >= 0; i--, j++)
        invertido = invertido + drut.charAt(i);
    // document.autorizar_permiso.rut.value = invertido;
    rut_campo.val(invertido);
    if (checkDVGeneral(rut, id_rut))
        return true;
    return false;
}
function checkDVGeneral(crut, id_rut) {
    var rut_campo = $("#" + id_rut);
    largo = crut.length;
    var crut_campo = $("#" + id_rut);
    if (largo < 2) {
        // alert("Debe ingresar el rut completo.");
//        mensajes_alert("Alerta", "Debe ingresar el rut completo.", '3');
        //mensajes_alert_id('Debe ingresar el rut completo.', id_rut);
        rut_campo.val('');
        rut_campo.focus();
        rut_campo.select();
        return false;
    }
    if (largo > 2)
        rut = crut.substring(0, largo - 1);
    else
        rut = crut.charAt(0);
    dv = crut.charAt(largo - 1);
    checkCDVGeneral(dv, id_rut);
    if (rut == null || dv == null)
        return 0;
    var dvr = '0';
    suma = 0;
    mul = 2;
    for (i = rut.length - 1; i >= 0; i--) {
        suma = suma + rut.charAt(i) * mul;
        if (mul == 7)
            mul = 2;
        else
            mul++;
    }
    res = suma % 11;
    if (res == 1)
        dvr = 'k';
    else if (res == 0)
        dvr = '0';
    else {
        dvi = 11 - res;
        dvr = dvi + "";
    }
    if (dvr != dv.toLowerCase()) {
        // alert("EL rut es incorrecto.");
        //mensajes_alert("Advertencia", "EL rut es incorrecto.", '3');
        crut_campo.val('');
        crut_campo.focus();
        crut_campo.select();
        crut_campo.parent().parent().find('input[type="text"]').val('');
        return false;
    }
    return true;
}
function checkCDVGeneral(dvr, id_rut) {
    var rut_campo = $("#" + id_rut);
    dv = dvr + "";
    if (dv != '0' && dv != '1' && dv != '2' && dv != '3' && dv != '4' && dv != '5' && dv != '6' && dv != '7' && dv != '8' && dv != '9' && dv != 'k' && dv != 'K') {
        // alert("Debe ingresar un digito verificador valido.");
//        mensajes_alert("Debe ingresar un digito verificador valido.", '3');
        //mensajes_alert_id('Debe ingresar s\xF3lo numeros', id_rut);
        rut_campo.val('');
        rut_campo.focus();
        rut_campo.select();
        return false;
    }
    return true;
}