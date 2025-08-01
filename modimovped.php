<?php
ob_start();
$np = $_GET['np'];
$iva = 0;
$idprod = $_GET['idprod'];
include 'inc/consec.php';
include 'config.php';
include_once 'menus.php';
include_once 'funciones.php';
$funciones = new funciones();
//include_once 'menus.php';
// conectar a la base de datos para consulta
$sql4 = $conn->query("select * from pedido where numped='" . $np . "' ");
$datos4 = $sql4->fetch_object();
$fechap = $datos4->fecha_ped;
$estado = $datos4->status;
$sql3 = $conn->query("select * from ims_product where pid='" . $idprod . "' ");
$datos3 = $sql3->fetch_object();
$nomprod = $datos3->pname;
$sqlmp = $conn->query("select * from mov_ped where  pid = '" . $idprod . "' AND numped = '" . $np . "' ");
$datos = $sqlmp->fetch_object();
if ($datos)
{
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
        <strong>Modificar Datos Pedido Numero <?= $np ?></strong>
      </div>

    </div>

    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="body">
          <div class="row clearfix">
            <div class="col-sm-5">


              <form role="form" method="post" id="modmovp" action="">

                <div class="form-group">
                  <label for="Fecha">Fecha pedido: <?= $fechap ?></label>
                </div>

                <div class="form-group">
                  <label for="Codigo Prodicto"> Codigo Producto : <?= $idprod ?> | <?= $nomprod ?> </label>
                </div>
                <div class="form-group">
                  <label for="cantidad"> Cantidad: </label>
                  <input type="numeric" class="form-control" id="canti" name="canti" value="<?= $datos->cantidad ?>" required maxlength="50">
                </div>
                <div class="form-group">
                  <label for="Precio"> Precio: </label>
                  <input type="numeric" class="form-control" id="precio" name="precio" value="<?= $datos->precio ?>" readonly maxlength="50">
                </div>
                <div class="form-group">
                  <label for="Total">Sub Total: </label>
                  <input type="text" id="subtotal" name="subtotal" value="<?= $datos->total ?>" readonly>
                </div>
                <div class="form-group">
                  <!--  <label for="name"> Mensaje:</label>
                            <textarea class="form-control" type="textarea" name="message" id="message" placeholder="Escribe tu mensaje aqui" maxlength="6000" rows="7"></textarea> -->
                </div>

                <button type="submit" class="btn btn-md btn-success" name="btnmodmp" id="btnmodmp">Actualizar</button>
                <button type="submit" class="btn btn-md btn btn-danger" name="btncancelar" id="btncancelar">Cancelar </button>
              </form>
              <?php
              $mensaje = "";
              if (isset($_POST['btncancelar'])) {
                header("Location: mostrarpedido.php?pedido=$np");
                exit();
              }
              
            if ($estado == "I")
             {
              if (isset($_POST['btnmodmp'])) {
                $cantid = $_POST['canti'];
                $stotal = $cantid * $datos->precio;
                $iva = obteneriva($iva);
                $calciva = ($stotal * $iva) / 100;
                if ($cantid > 0) {

                  $updatemov = "
			            update mov_ped set iva_tax='$calciva',cantidad='$cantid', total='$stotal' where pid=$idprod AND numped=$np";
                  $resultadomovped = mysqli_query($conn, $updatemov);
                  if (!$resultadomovped) {
                    die('Error in query: ' . mysqli_error($conn));
                  } else { //grabar encabezado de pedido
                    $sumastotal = "select SUM(total) AS Sub_total, SUM(iva_tax) AS Tot_iva from mov_ped where numped=$np";
                    $resultadosuma = $conn->query($sumastotal);
                    $row = $resultadosuma->fetch_assoc();
                    $stotal = $row["Sub_total"];
                    $siva = $row["Tot_iva"];
                    $query = "UPDATE pedido SET subtotal= '$stotal', iva_t = '$siva' WHERE numped = $np ";
                    $result = mysqli_query($conn, $query);
                  }
                  header("Location: mostrarpedido.php?pedido=$np");
                  exit();
                } else {
                  $mensaje = "La cantidad debe ser mayor a cero, vuelva a intentarlo";
                  if ($mensaje) {
              ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
                  <?php } ?>
            </div>
        <?php


                }
              } 
              
            }else { $mensaje = "El Pedido NO se puede modificar, el STATUS no lo permite, Contacte a Administracion";
              ?><div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
              <?php } ?>
                </div><?php            ?>




          </div>
        </div>
      </div>
    </div>
  </div>
<?php } else{$mensaje = "NO se puede encontrar la info requerida, consulte a Sistemas";
                  if ($mensaje) {
              ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
    <?php } }?>


  <script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script>
    const formulario = document.getElementById('modmovp');
    const cantidadInput = document.getElementById('canti');
    const precioInput = document.getElementById('precio');
    const subtotalInput = document.getElementById('subtotal');

    function calcularSubtotal() {
      const cantidad = parseFloat(cantidadInput.value);
      const precio = parseFloat(precioInput.value);
      if (cantidad > 0) {
        if (!isNaN(cantidad) && !isNaN(precio)) {
          const subtotal = cantidad * precio;
          subtotalInput.value = subtotal.toFixed(2); // Formato con dos decimales
        } else {
          subtotalInput.value = ''; // Limpiar el campo en caso de valores inválidos
        }
      } else {
        alert('El número debe ser mayor que cero.');
      }
    }

    // Escuchar cambios en los campos de cantidad y precio
    cantidadInput.addEventListener('input', calcularSubtotal);
    precioInput.addEventListener('input', calcularSubtotal);

    // Llamar a la función al cargar la página para mostrar el valor inicial
    //calcularSubtotal();
  </script>






</body>

</html>