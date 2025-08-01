<!DOCTYPE html>
<html>

<head>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
  $pedido = $_GET['pedido'];
  $sql = $conn->query("select * from pedido where numped = $pedido");
  $datos2 = $sql->fetch_object();
  $ccliente = $datos2->codcli;
  $estado = $datos2->status;
  $sql2 = $conn->query("select * from ims_customer where codcli = $ccliente");
  $datos3 = $sql2->fetch_object();
  $ncliente = $datos3->name;
  $sql = $conn->query("select * from pedido where numped = $pedido");

  ?>
  <script type="text/javascript">
    function confirmacion3() {
      var respuesta = confirm("¿deseas incluir productos en el pedido a este cliente ?");
      if (respuesta == true) {
        return true;
      } else {
        return false;
      }
    }
  </script>


  <div class="container mt-2 p-5">
    <div class="row text-center" style="background-color: #cecece">
      <div class="col-md-6">
        <strong>Registrar Pedido</strong>
      </div>
      <div class="col-md-6">
        <strong>Pedido</strong>
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
                    <label  class="form-label">Pedido No. <?= $pedido ?></label>

                    <div id="respuesta"> </div>
                  </div>

                  <?php while ($datos = $sql->fetch_object()) {
                    $fechap = $datos->fecha_ped; 
                    $fecha_objeto = new DateTime($fechap);
                    $fecha_formateada = $fecha_objeto->format('d-m-Y'); ?>
                    <div class="col-md-12">
                      <label  class="form-label">Fecha <?= $fecha_formateada ?></label>
                      <!-- <input type="date" class="form-control" name="fechap" id="fechap" required='true' default= "date()" value="<?= $datos->fecha_ped ?>"> -->
                    </div>

                    <div class="col-md-12 mt-2">
                      <label  class="form-label">Cédula (Codigo) Cliente <?= $ccliente ?><em></em></label>
                      <!--<input type="number"   class="form-control" name ="cedula" id="cedula" required='true' value="<?= $datos->codcli ?>" autofocus> -->
                      <div id="respuesta"> </div>
                    </div>


                    <div class="col-md-12">
                      <label  class="form-label">Nombre del Cliente <?= $ncliente ?></label>
                      <!--   <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus> -->
                    </div>
                    


                </div>


              </form>
              <div class="row justify-content-start text-center mt-5">
                <div class="col-12">
                <?php  $permission='Registrar_Nuevo_Pedido'; 
                  if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>
                     <?php if ($estado=="I"){ ?>
                      <button class="btn btn-info btn-lg turned-button" data-toggle="modal" data-target="#myModal" name="btnmped"  id="btnmped">
                       <i class=""></i>
                         Incluir productos pedido
                      </button>
                      <?php }}else{?><button disabled class="btn btn-info btn-lg turned-button" data-toggle="modal" data-target="#myModal" name="btnmped"  id="btnmped">
                       <i class=""></i>
                         Incluir productos pedido
                      </button><?php } ?>
                       <a href="index.php" >  <button type="button"  class="btn btn-md btn btn-danger" name="btncancelar" id="btncancelar">Salir </button>  </a>


                </div>
              </div>


              <!-- Modal -->
              <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Incluir Productos Pedido No <?= $pedido ?></h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                     
                      <form role="form" method="post" id="reused_form" action="">
                        <div class="form-group">
                          <select name="product" id="product" class="form-select rounded-0" required>
                            <option value="">Seleccionar Producto  Precio</option>
                            <?php echo $funciones->productDropdownList(); ?>
                          </select>
                        </div>
                                        
                        
                        <div class="form-group">
                          <label for="canti"> Cantidad: </label>
                          <input type="numeric" class="form-control" id="canti" name="canti" value="1" required maxlength="50">
                        </div>
                        <div class="form-group">
                          <!--  <label for="name"> Mensaje:</label>
                                    <textarea class="form-control" type="textarea" name="message" id="message" placeholder="Escribe tu mensaje aqui" maxlength="6000" rows="7"></textarea> -->
                        </div>
                        <button type="submit" class="btn btn-lg btn-success btn-block" name="btnmovped" id="btnmovped">Enviar </button>
                      </form>


                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal -->

            <?php }
                  $mensaje = "";
                if ($estado=="I") 
                  {
                  if (isset($_POST["btnmovped"])) {
                    if (!empty($_POST['product']))
                    { if ($_POST['canti']>0)
                      {
                      $codpro = $_POST['product'];
                      $sql4 = $conn->query("select * from ims_product where pid = $codpro");
                      $datos4 = $sql4->fetch_object();

                      $precio_P = $datos4->base_price;
                      $subtotal =  $precio_P * $_POST['canti'];
                      $iva = obteneriva($iva);
                      $calciva= ($subtotal*$iva)/100;
                      // incluir en movped
                      //echo '<p style="color:red;">Insertando ...,'.$fechap. ''.$pedido. ' '.$ccliente.  ' '.$codpro. '  '.$precio_P. ' '.$subtotal. '</p>';
                      $busqueda = "select * from mov_ped where  pid = '" . $codpro . "' AND numped = '" . $pedido . "' ";
                      $busquedar = mysqli_query($conn, $busqueda);
                      //
                      $resul = mysqli_num_rows($busquedar);
                      if ($resul >= 1) {
                        echo '<p style="color:red;">Producto ya incluido !! ...,' . $pedido . ' ' . $codpro . '   </p>';
                      } else {

                        $Insertmovped = "
                        INSERT INTO mov_ped(numped,pid, cantidad, precio, total,iva_tax) 
                        VALUES ('" . $pedido . "','" . $codpro . "', '" . $_POST['canti'] . "', '" . $precio_P . "', '" . $subtotal . "','" . $calciva . "' )";
                        $resultadomped = mysqli_query($conn, $Insertmovped);
                        ////Buscar el encabezado de pedido e incrementar el iva y el subtotal
                        $sql = $conn->query("select * from pedido where numped = '" . $pedido . "'");
                        $datos2 = $sql->fetch_object();
                        $sstotal = $datos2->subtotal;
                        $ssivatax = $datos2->iva_t;
                        $sstotal =$sstotal + $subtotal;
                        $ssivatax = $ssivatax + $calciva;
                         $query = "UPDATE pedido SET subtotal= '$sstotal', iva_t = '$ssivatax' WHERE numped = $pedido ";
                         $result = mysqli_query($conn,$query);
          
                        if (!$resultadomped) {
                                  die('Error in query: ' . mysqli_error($con));}
                                
                      }

                      //

                      }
                    } else {echo '<p style="color:red;">La cantidad debe ser mayor a cero !! ...,   </p>';

                      }
                  }  
                }else {
                  $mensaje = "El Pedido NO se puede modificar, el STATUS no lo permite, Contacte a Administracion";
                  ?><div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
                  <?php } 
                  ?>
                




            </div>
            <div class="col-sm-7">
              <div class="row" id="listClientes" action='clienteList'>
                <?php // aqui va el listado de movimiento de pedido 

               // $funciones->listmovped($pedido); 
               lmovped($pedido);
               ?>


              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <!--<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script> -->

    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->

    <!--<script src="js/form.js"></script> -->
                </body>