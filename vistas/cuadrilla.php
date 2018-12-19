<?php 
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
                          <h1 class="box-title">Cuadrillas <button class="btn btn-success" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadocuadrilla">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Numero</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </thead>
                          <tbody></tbody>
                          <tfoot>
                            <th>Numero</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                          </tfoot>
                        </table>
                    </div>
                    <div class="panel-body table-responsive" id="listadoCuadrillas">
                        <table id="tbllistadouno" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Tipo de trabajador</th>
                            <th>Estado</th>
                          </thead>
                          <tbody></tbody>
                          <tfoot>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Tipo de trabajador</th>
                            <th>Estado</th>
                          </tfoot>
                        </table>
                        <div class="form-group col-lg-12 col-med-12 col-sm-12 col-xs-12">
            

                          <button class="btn btn-danger" onclick="inicio()" type="button" ><i class="fa fa-arrow-left"></i></button>
                        </div>
                    </div> 
                    <div class="panel-body" style="height: 400px;" id="formulariocuadrilla">
                    <form  name= "formulario" id="formulario" method="POST" >
                        <div class="form-group col-lg-6 col-med-6 col-sm-6 col-xs-12"> <!-- lg, med, sm, xs son medidad de pantallas (max=12 (total pantalla)) // Ocurre un div response -->
                          
                          <label>Numero</label>
                          <input type="hidden" name="idcuadrilla" id="idcuadrilla"> <!-- Cuando quiera editar una cuadrilla aqui envio el id y luego mando los datos al metodo correspondiente -->
                          <input type="number" name="numero" id="numero" class="form-control"  placeholder="Numero" required>

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

<script type="text/javascript" src="scripts/cuadrilla.js"></script>