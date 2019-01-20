<?php 
//SE ACTIVA EL ALMACENAMIENTO EN EL BUFFER
ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.html");
}
else{

$id= $_SESSION["idcuadrilla"];
$tipo = $_SESSION["kind"];

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
                    <h1 class="box-title">Cuadrilla</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="UsuariosPorConfirmar">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                        <input type="hidden" name="idcuadrilla" id="idcuadrilla" value="<?php echo $id; ?>"> <!-- mando el idcuadrilla al metodo confirmar.js y el valor es el recibido en la varibale $id por el metodo SESSION.-->
                        <input type="hidden" name="tipo" id="tipo" value="<?php echo $tipo; ?>">
                        <input type="hidden" name="idj" id="idj" value="<?php echo $_SESSION['idusuario']; ?>">
                          <thead>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </thead>
                          <tbody></tbody>
                          <tfoot>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Rut</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tfoot>
                        </table>
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

<script type="text/javascript" src="scripts/confirmar.js"></script>


<?php 
}

ob_end_flush();
?>