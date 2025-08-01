<?php
ob_start();
$np = $_GET['np'];
$idprod = $_GET['idprod'];
include 'config.php';
include_once 'menus.php';
include_once 'funciones.php';
$funciones = new funciones();
//include_once 'menus.php';


// conectar a la base de datos para consulta
// Luego ño voy a hacer con inner join
$sql4 = $conn->query("select * from pedido where numped='" . $np . "' ");
$datos4 = $sql4->fetch_object();
$fechap = $datos4->fecha_ped;
$estado=$datos4->status;
$sql3 = $conn->query("select * from ims_product where pid='" . $idprod . "' ");
$datos3 = $sql3->fetch_object();
$nomprod = $datos3->pname;
$sqlmp = $conn->query("select * from mov_ped where  pid = '" . $idprod . "' AND numped = '" . $np . "' ");
$datos = $sqlmp->fetch_object();
if ($datos){
?>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link type="text/css" rel="shortcut icon" href="img/logo-mywebsite-urian-viera.svg" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/cargando.css">
  <link rel="stylesheet" type="text/css" href="css/maquinawrite.css">
  <style>
    table tr th {
      background: rgba(0, 0, 0, .6);
      color: #fff;
    }

    tbody tr {
      font-size: 12px !important;

    }

    h3 {
      color: crimson;
      margin-top: 100px;
    }

    a:hover {
      cursor: pointer;
      color: #333 !important;
    }

    em {
      font-size: 15px;
    }
  </style>
</head>

<body>


          <div class="container mt-2 p-5">
               <div class="row text-center" style="background-color: #cecece">
                  <div class="col-md-6">
                  <strong>Eliminar Datos Pedido Numero <?= $np ?></strong>
                </div>

          </div>

    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-5">

              <form role="form" method="post" id="elimovp" action="">
                <div class="form-group">
                  <label for="Fecha">Fecha pedido: <?= $fechap ?></label>
                </div>

                <div class="form-group">
                  <label for="Codigo Prodicto"> Codigo Producto : <?= $idprod ?> | <?= $nomprod ?> </label>
                </div>
                <div class="form-group">
                  <label for="cantidad"> Cantidad: <?= $datos->cantidad ?></label>
                </div>
                <div class="form-group">
                  <label for="Precio"> Precio: <?= $datos->precio ?></label>
                </div>
                <div class="form-group">
                  <label for="Total">Sub Total: <?= $datos->total ?></label>
                </div>
                <div class="form-group">
                  <!--  <label for="name"> Mensaje:</label>
                            <textarea class="form-control" type="textarea" name="message" id="message" placeholder="Escribe tu mensaje aqui" maxlength="6000" rows="7"></textarea> -->
                </div>
                <button type="submit" class="btn btn-md btn-success" name="btnelimp" id="btnelimp">Eliminar </button>
                <button type="submit" class="btn btn-md btn btn-danger" name="btncancelar" id="btncancelar">Cancelar </button>
              </form>
              <?php
              $mensaje = "";
              if (isset($_POST['btncancelar']))
              { header("Location: mostrarpedido.php?pedido=$np");
                exit();

              }

              if (isset($_POST['btnelimp']))
                { if ($estado=="I")
                  {
                //  $elimimovped = "
                //delete from mov_ped  pid = '.$idprod.'  AND numped =  '.$np.'";
                $eli = "delete  from mov_ped where  pid = '" . $idprod . "' AND numped = '" . $np . "' ";
                $resultadomovped = mysqli_query($conn, $eli);
                // Restar al encabezado de pedido iva y subtotal
                $vtotal=$datos->total;
                $ivatax=$datos->iva_tax;
                $sql4 = $conn->query("select * from pedido where numped='" . $np . "' ");
                $datos4 = $sql4->fetch_object();
                $eiva=$datos4->iva_t;
                $esubtotal=$datos4->subtotal;
                $eiva=$eiva-$ivatax;
                $esubtotal=$esubtotal-$vtotal;
                $query = "UPDATE pedido SET subtotal= '$esubtotal', iva_t = '$eiva' WHERE numped = $np ";
                $result = mysqli_query($conn,$query);
                //
                if (!$resultadomovped) {
                  die('Error in query: ' . mysqli_error($conn));
                }
                header("Location: mostrarpedido.php?pedido=$np");
                exit();
              } else {$mensaje = "El Pedido NO se puede ELIMINAR, el STATUS no lo permite, Contacte a Administracion";
                ?><div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
                <?php }
              
             }?>




            </div>
          </div>
        </div>
      </div>
    </div>
  
<?php } else{$mensaje = "NO se puede encontrar la info requerida, consulte a Sistemas";
        
        ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
      <?php } ?>

    <script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <script src="js/bootstrap.min.js"></script>
     <script src="js/popper.min.js"></script>




    </body>

</html>