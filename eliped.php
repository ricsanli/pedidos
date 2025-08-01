<!DOCTYPE html>
<html>

<head>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <!-- Custom styles for this template -->

</head>
<body>
  <?php
  //session_start();
  ob_start();
  include ('inc/consec.php');
  //include('funciones.php');
  include('menus.php');
  include('config.php');
  include 'tablas.php';
  $datoscliente = array();
 // $funciones = new funciones();
  //include('config.php');
  //include('inc/consec.php');
  // conectar a la base de datos para consulta
  $iva=0;
  $pedido = $_GET['np'];
  $sql = $conn->query("select * from pedido where numped = $pedido");
  $datos2 = $sql->fetch_object();
  if ($datos2)
  {
  $ccliente = $datos2->codcli;
  $estado = $datos2->status;
  $sql2 = $conn->query("select * from ims_customer where codcli = $ccliente");
  $datos3 = $sql2->fetch_object();
  $ncliente = $datos3->name;
  $sql = $conn->query("select * from pedido where numped = $pedido");

  ?>
 


  <div class="container mt-2 p-5">
    <div class="row text-center" style="background-color: #cecece">
      <div class="col-md-6">
        <strong>Datos del Pedido a Eliminar</strong>
      </div>
      <div class="col-md-6">
        <strong>Productos del Pedido</strong>
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
                    <label for="name" class="form-label">Pedido No. <?= $pedido ?></label>

                    <div id="respuesta"> </div>
                  </div>

                  <?php $datos = $sql->fetch_object();
                    $fechap = $datos->fecha_ped; ?>
                    <div class="col-md-12">
                      <label for="name" class="form-label">Fecha <?= $datos->fecha_ped ?></label>
                      <!-- <input type="date" class="form-control" name="fechap" id="fechap" required='true' default= "date()" value="<?= $datos->fecha_ped ?>"> -->
                    </div>

                    <div class="col-md-12 mt-2">
                      <label for="name" class="form-label">Cédula (Codigo) Cliente <?= $ccliente ?><em></em></label>
                      <!--<input type="number"   class="form-control" name ="cedula" id="cedula" required='true' value="<?= $datos->codcli ?>" autofocus> -->
                      <div id="respuesta"> </div>
                    </div>


                    <div class="col-md-12">
                      <label for="name" class="form-label">Nombre del Cliente <?= $ncliente ?></label>
                      <!--   <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus> -->
                    </div>
                    


                </div>
                <div class="col-12">
                 <?php if ($estado=="I")
                 {?>
                  <button type="buttom" class="btn btn-info btn-md turned-button"   name="btnmped"  id="btnmped"> Eliminar pedido </button>
                  
                  
                  <a href="index.php" >  <button type="button"  class="btn btn-md btn btn-danger" name="btncancelar" id="btncancelar">Salir </button>  </a>


                </div>


              </form>
              <div class="row justify-content-start text-center mt-5">
             
                  
               
              </div>

            <?php }
                  $mensaje = "";
                 if ($estado=="I")
                 {
                  if (isset($_POST["btnmped"]))
                   {  // borrar datos de movped
                    
                      
                      $busqueda = "delete from mov_ped where  numped = '" . $pedido . "'";
                      $busquedar = mysqli_query($conn, $busqueda);
                      
                      if  (!$busquedar) {die('Error in query: ' . mysqli_error($conn));}
                        
                       else { $busqueda2 = "delete from pedido where  numped = '" . $pedido . "'";
                              $busquedar = mysqli_query($conn, $busqueda2);
                              if (!$busquedar) {
                                  die('Error in query: ' . mysqli_error($con));}
                                  header("Location: index.php");
                                  exit();                                }
           
                  } 
                   } else {$mensaje = "El Pedido NO se puede ELIMINAR, el STATUS no lo permite, Contacte a Administracion";
                    ?><div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
                    <?php } ?>

                  
            </div>
            <div class="col-sm-7">
              <div class="row" id="listClientes" action='clienteList'>
                <?php // aqui va el listado de movimiento de pedido 

                lmovped($pedido); ?>


              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <?php } else {          $mensaje = "El Pedido NO EXISTE O fue ELIMINADO Contacte a Administracion";
                    ?><div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
      <?php  } ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!--<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->

    <!--<script src="js/form.js"></script> -->
                </body>