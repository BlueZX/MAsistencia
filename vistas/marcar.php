<?php 
//SE ACTIVA EL ALMACENAMIENTO EN EL BUFFER
ob_start();
session_start();

if(!isset($_SESSION["nombre"])){
  header("Location: login.html");
}
else{

$id= $_SESSION["idusuario"];

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
                          <h1 class="box-title"><?php setlocale(LC_ALL,"es_ES"); echo strftime("%A %d de %B del %Y"); ?></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistro">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-success center-block" onclick="asisti(<?php echo $id; ?>)" style="padding:50px 150px; margin: 10px;" >Marcar</button>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <button class="btn btn-danger center-block" onclick="cancelarAsistencia(<?php echo $id; ?>)" style="padding:50px 150px; margin: 10px;">Cancelar</button>
                        </div>
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

<script type="text/javascript" src="scripts/marcar.js"></script>


<?php 
}

ob_end_flush();
?>