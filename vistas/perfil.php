<?php 
//SE ACTIVA EL ALMACENAMIENTO EN EL BUFFER
ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.html");
}
else{

require 'header.php';
?>

<input type="hidden" name="id" id="id" value="<?php echo $_SESSION['idusuario'];?>">

<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" method="POST">
                        <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="foto">Foto:</label>
                            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <img src="" width="150px" height="150px" id="imagenmuestra">
                              <input type="file" name="image" id="image" class="form-control">
                              <input type="hidden" name="imagenactual" id="imagenactual">
                            </div>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="nombre">Nombre:</label>
                            <input type="hidden" name="idusuario" id="idusuario">
                            <input type="text" name="nombre" id="nombre" class="form-control" maxLength="50" placeholder="Nombre" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="rut">Rut:</label>
                            <input type="text" name="rut" id="rut" oninput="checkRut(this)" class="form-control" maxLength="12" placeholder="ejem: 12.123.123-2" required disabled>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="password">Contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control" maxLength="64" placeholder="contraseña" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccion" id="direccion" class="form-control" maxLength="45" placeholder="calle, ciudad, pais" required>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="fechaN">Fecha de nacimiento:</label>
                            <input type="date" name="fechaN" id="fechaN" class="form-control">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="email">E-mail:</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="example@email.com">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label for="numero">Numero telefonico:</label>
                            <input type="text" name="numero" id="numero" class="form-control" placeholder="ejem: +56981823280">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="hh1">
                            <label for="cuadrilla">Cuadrilla:</label>
                            <select name="idcuadrilla" id="idcuadrilla" class="form-control selectpicker" data-live-search="true"></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="hh2">
                            <label for="jefebase">Jefe de base:</label>
                            <select name="idjefebase" id="idjefebase" class="form-control selectpicker" data-live-search="true"></select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="hh3">
                            <label for="kind">Tipo de usuario:</label>
                            <select name="kind" id="kind" class="form-control selectpicker" data-live-search="true">
                              <option value=1 selected>Brigadista</option>
                              <option value=2>Jefe de cuadrilla</option>
                              <option value=3>Jefe de base</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12" id="hh4">
                            <label for="permisos">Permisos:</label>
                            <ul style="list-style: none;" id="permisos">
                              
                            </ul>
                          </div>
                          <div class="from-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" id="btnGuardar" type="submit"><i class="fa fa-save"></i> Guardar</button>
                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
  <!--Fin-Contenido-->
<?php 
require 'footer.php';
?>

<script type="text/javascript" src="scripts/perfil.js"></script>
<script type="text/javascript">mostrar($('#id').val()) </script>

<?php 
}

ob_end_flush();
?>