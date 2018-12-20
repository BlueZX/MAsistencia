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
                          <h1 class="box-title">Bienvenido <?php echo $_SESSION["nombre"]; ?></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistro">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <p>Este sera el escritorio, donde saldra la informacion mas importante para cada brigadistas</p>
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