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

if($_SESSION['escritorio']==1){

  function tipoUser($kind){
    switch($kind){
        case 1:
            return "brigadista";
        break;
        case 2:
            return "Jefe de cuadrilla";
        break;
    }
  }

  require_once "../modelos/Registro.php";
  $registro = new Registro();
  $asistidos = $registro->asistenciaultimos_15dias($id);
  $fechaa = '';
  $siono = '';

  while($regfechaa = $asistidos->fetch_object()){
    $fechaa = $fechaa.'"'.$regfechaa->fecha . '",';
    if($regfechaa->status == 2){
      $siono = $siono.'"'. 1 . '",';
    }
    else{
      $siono = $siono.'"'.$regfechaa->status . '",';
    }
  }
  $fechaa = substr($fechaa, 0, -1);
  $siono = substr($siono,0, -1);

  require_once "../modelos/Cuadrilla.php";
  $cuadrilla = new Cuadrilla();
  $l_cuadrilla = $cuadrilla->listarCuadrilla($_SESSION['idcuadrilla']);
  $miembros = '';

  while($lista_c = $l_cuadrilla->fetch_object()){
    $miembros = $miembros . '<li><img id="circulo-foto" src="../files/usuarios/'. $lista_c->image .'" alt="User Image" height="128px" width="128px">
                            <a class="users-list-name" href="#">' . $lista_c->nombre . '</a>
                            <span class="users-list-date">' . tipoUser($lista_c->kind) . '</span></li>';
  }



  ?>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
              <?php if($_SESSION['kind'] != 3) { ?>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Mi cuadrilla</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="box-body no-padding">
                      <ul class="users-list clearfix">
                        <?php echo $miembros; ?>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
              <?php }?>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1 class="box-title">Grafico de asistencia</h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistro">
                            <div class="box-body">
                              <canvas id="fechas" width="400" height="300"></canvas>
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
}
else{
  require 'noacceso.php';
}
require 'footer.php';
?>

<script type="text/javascript" src="scripts/marcar.js"></script>
<script type="text/javascript" src="../public/js/Chart.min.js"></script>
<script type="text/javascript" src="../public/js/Chart.bundle.min.js"></script>

<script type="text/javascript">
var ctx = document.getElementById("fechas").getContext('2d');
var fechas = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php echo $fechaa; ?>],
        datasets: [{
            label: '# dias asistidos',
            data: [<?php echo $siono; ?>],
            fill: false,
            borderColor: 'rgba(255, 99, 132, 1)'

        }]
    },
    options: {                                        
            scales: {
                yAxes: [
                    {
                        ticks: {                                    
                            stepSize: 1  
                        }
                    }
                ]
            }
    }
});
</script>
<?php 
}

ob_end_flush();
?>