<!DOCTYPE html>
<html>

<head>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
  <script src="js/jquery.min.js"></script>
 <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> -->
  <!-- Custom styles for this template -->
   <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
   <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap5.css">

     <script> src="js/alertify.js" </script>
    <script src="js/dataTables.js"> </script>
   
        
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
  //recibiendo los parametros por $_SeSSION
  
  if (isset($_SESSION['cedula']) && isset($_SESSION['fechaini']) && isset($_SESSION['fechafin'])) 
  { 
    $cedula = $_SESSION['cedula'];
    $fechaini = $_SESSION['fechaini'];
    $fechafin = $_SESSION['fechafin'];
  
  $iva=0;
 // $cedula = $_GET['cedula'];
 // $fechaini = $_GET['fechaini'];
 // $fechafin = $_GET['fechafin'];
  $fecha_objeto = new DateTime($fechaini);
  $fechaini_format = $fecha_objeto->format('d-m-Y');
  $fecha_objeto2 = new DateTime($fechafin);
  $fechafin_format = $fecha_objeto2->format('d-m-Y');

  //$sql = $con->query("select * from pedido where numped = $pedido");
  //$datos2 = $sql->fetch_object();
  $ccliente = $cedula;
  $sql2 = $conn->query("select * from ims_customer where codcli = $ccliente");
  $datos3 = $sql2->fetch_object();
  $ncliente = $datos3->name;
 // $sql = $con->query("select * from pedido where numped = $pedido");
if ($datos3){
  ?>
  

  <div class="container mt-2 p-5">
    <div class="row text-center" style="background-color: #cecece">
      <div class="col-md-6">
        <strong>Datos de la Consulta de Pedidos a Despachar</strong>
      </div>
      <div class="col-md-6">
        <strong>Pedidos a Despachar</strong>
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
                                

                    <div class="col-md-12 mt-2">
                      <label class="form-label">Cédula (Codigo) Cliente <?= $ccliente ?><em></em></label>
                      <!--<input type="number"   class="form-control" name ="cedula" id="cedula" required='true' value="<?= $datos->codcli ?>" autofocus> -->
                      
                    </div>

                    <div class="col-md-12">
                      <label  class="form-label">Nombre del Cliente <?= $ncliente ?></label>
                      <!--   <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus> -->
                    </div>
                    <div class="col-md-12">
                      <label  class="form-label">Fecha Inicio:<?= $fechaini_format ?></label>
                      <!-- <input type="date" class="form-control" name="fechap" id="fechap" required='true' default= "date()" value="<?= $datos->fecha_ped ?>"> -->
                    </div>
                    <div class="col-md-12">
                      <label  class="form-label">Fecha fin:<?= $fechafin_format ?></label>
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
                <?php // aqui va el listado de pedidos a despachar 

                 peddespa($cedula, $fechaini, $fechafin,$ncliente); ?>


              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <?php } else{$mensaje = "NO se puede encontrar la info requerida, consulte a Sistemas";
        
        ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
      <?php } ?>
      <?php }else{ $mensaje = "NO se puede encontrar la info requerida, consulte a Sistemas";
        
        ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
      <?php } ?>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!--<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->

    <!--<script src="js/form.js"></script> -->
                </body>