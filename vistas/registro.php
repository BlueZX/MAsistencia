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
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Registros <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistro">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody></tbody>
                          <tfoot>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistro">
                    <form  name= "formulario" id="formulario" method="POST" >

                        <div class="form-group col-lg-6 col-med-6 col-sm-6 col-xs-12"> <!-- lg, med, sm, xs son medidad de pantallas (max=12 (total pantalla)) // Ocurre un div response -->
                          
                          <label>fecha</label>
                          <input type="hidden" name="idregistro" id="idregistro"> <!-- Cuando quiera editar una categoria aqui envio el id y luego mando los datos al metodo correspondiente -->
                          <input type="date" name="fecha" id="fecha"  placeholder="fecha" required>
                        </div>
                        <div class="form-group col-lg-6 col-med-6 col-sm-6 col-xs-12"> <!-- lg, med, sm, xs son medidad de pantallas (max=12 (total pantalla)) // Ocurre un div response -->
                          
                          <label>Usuario</label>
                          <select name="idusuario" id="idusuario"  class="form-control selectpicker" data-live-search="true" required></select>
                        </div>
                       
                         <!-- idcategoria esta oculto asi que solo hay que ponerlo una vez al inicio. -->
                        <div class="form-group col-lg-12 col-med-12 col-sm-12 col-xs-12">
                          <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i>Guardar</button> <!--submit ya que con este boton enviare el formulario mediante un metdo ajax // etiqueta "i" para el icono del boton  -->

                          <button class="btn btn-danger" onclick="cancelarform()" type="button" ><i class="fa fa-arrow-circle-left"></i>Cancelar</button>
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

<script type="text/javascript" src="scripts/registro.js"></script>

<?php 
}

ob_end_flush();
?>