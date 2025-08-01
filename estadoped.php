<?php
//session_start();
ob_start();
include 'inc/consec.php';
include_once 'config.php';

//include_once 'funciones.php';
//$funciones = new funciones();
include_once 'menus.php';
$cedula = "";
$fechafin = 'D-m-y';
$fechaini = 'D-m-y';
$nomcli = "";
$datoscliente = array();
?>
<!DOCTYPE html>
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
  

</head>

<body>

  <div class="container mt-2 p-5">
 

    <div class="row text-center" style="background-color: #cecece">
      <div class="col-md-6">
        <strong>Cambiar Estado de  Pedidos por Rango de Fechas</strong>
      </div>
      <div class="col-md-6">
        <strong>Lista de Pedidos</strong>

      </div>
    </div>

    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="body">
          <div class="row clearfix">

            <!----- formulario --->
            <div class="col-sm-5">

              <form name="lispedido" id="lispedido" action="" method="post">
                <class="row">
                  
                  
                  <div class="col-md-12">
                    <label for="name" class="form-label">Fecha Inicio </label>
                    <input type="date" class="form-control" name="fechaini" id="fechaini" required='true' default="date()" autofocus value="<?= isset($_POST['fechaini']) ? $_POST['fechaini'] : '' ?>"value="date()">
                  </div>
                  <div class="col-md-12">
                    <label for="name" class="form-label">Fecha Final</label>
                    <input type="date" class="form-control" name="fechafin" id="fechafin" required='true' default="date()" autofocus value="<?= isset($_POST['fechafin']) ? $_POST['fechafin'] : '' ?>" value="date()">
                  </div>


                  <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                      <button class="btn btn-primary btn-block" name="btnEnviar" value="Pedido" id="btnEnviar">
                        <i class=""></i>
                        Consultar Pedidos
                      </button>
                    </div>
                  </div>
                  

                  </div>
                  </form> 
                

                  <div class="col-sm-7">
                    <div class="row" id="lismovped" action='listmovped'>
                      <?php
                      if (!empty($_POST['fechaini'])) {
                       
                        $fechaini = $_POST['fechaini'];
                        $fechafin = $_POST['fechafin']; 
                        if ($fechaini >$fechafin )
                           { $mensaje="La fecha de inicio es Mayor a la fecha Final, Corrija las fechas";
                              ?>  <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; 
                           ?> </div> <?php
                          }else{
                        // aqui va el listado de pedido
                        // $seleccion=$con->query(" SELECT * FROM pedido AS ped INNER JOIN ims_customer as cli ON ped.codcli=cli.codcli WHERE ped.codcli='$cedula' AND ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin'"); 
                        //$datos4 = $seleccion->fetch_object();
                        //$nomcli = $datos4->name;
                       // $funciones->listped($cedula, $fechaini, $fechafin);
                         header("Location: mostrarpedidoestado.php?fechaini=$fechaini&fechafin=$fechafin");
                         exit();
                      }
                    }
                      ?>
                    </div>
                  </div>

                  
               </div>

            <?php
                     ?>


          </div>

        </div>

        <div>

</html>
</body>