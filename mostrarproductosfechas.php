<!DOCTYPE html>
<html>

<head>
  <!--<link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
   Custom styles for this template -->
  
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap5.css">


    <script src="js/jquery-3.7.1.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/dataTables.js"></script>
    <script src="js/dataTables.bootstrap5.js"></script>
    <script src="js/dataTables.buttons.js"></script>
    <script src="js/buttons.bootstrap5.js"></script>
    <script src="js/jszip.min.js"></script>
    <script src="js/pdfmake.min.js"></script>
    <script src="js/vfs_fonts.js"></script>
    <script src="js/buttons.html5.min.js"></script>
    <script src="js/buttons.print.min.js"></script>
    <script src="js/buttons.colVis.min.js"></script>
</head>



</head>
<body>
  <?php
  //session_start();
  include ('inc/consec.php');
  //include('funciones.php');
  include('menus.php');
  include('config.php');
  include('tablas.php');
  $datoscliente = array();
  //$funciones = new funciones();
  //include('config.php');
  //include('inc/consec.php');
  // conectar a la base de datos para consulta
  $iva=0;
  $fechaini = $_GET['fechaini'];
  $fechafin = $_GET['fechafin'];



  ?>
  

  <div class="container mt-2 p-5">
    <div class="row text-center" style="background-color: #cecece">
      <div class="col-md-6">
        <strong>Datos de la Consulta de Productos Pedidos</strong>
      </div>
      <div class="col-md-6">
        <strong>Productos Pedidos</strong>
      </div>
    </div>

    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="body">
          <div class="row clearfix">

            <!----- formulario --->
            <div class="col-sm-5">
              <form name="formCliente" id="formCliente" action="" method="POST">
                <div class="row">
                  <div class="col-md-12 mt-2">
                    <!--<label for="name" class="form-label">Pedido No. </label> -->

                    <div id="respuesta"> </div>
                  </div>
                
                    <div class="col-md-12">
                      <label for="name" class="form-label">Fecha Inicio:<?= $fechaini ?></label>
                      <!-- <input type="date" class="form-control" name="fechap" id="fechap" required='true' default= "date()" value="<?= $datos->fecha_ped ?>"> -->
                    </div>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Fecha fin:<?= $fechafin ?></label>
                      <!-- <input type="date" class="form-control" name="fechap" id="fechap" required='true' default= "date()" value="<?= $datos->fecha_ped ?>"> -->
                    </div>
                    
                </div>


              </form>
              <div class="row justify-content-start text-center mt-5">
                <div class="col-12">
                  
                  <a href="index.php" >  <button type="button"  class="btn btn-md btn btn-danger" name="btncancelar" id="btncancelar">Salir </button>  </a>


                </div>
              </div>

            <?php $mensaje = ""; ?>
            

            </div>
            <div class="col-sm-7">
              <div class="row" id="listClientes" action='clienteList'>
                <?php // aqui va el listado de movimiento de pedido 

                 listpp($fechaini, $fechafin); ?>


              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->

    <!--<script src="js/form.js"></script> -->
                </body>