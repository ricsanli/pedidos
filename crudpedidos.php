<?php
//session_start();
ob_start();
include 'inc/consec.php';
include_once 'config.php';

//include_once 'funciones.php';
//$funciones = new funciones();
include_once 'menus.php';
include 'tablas.php';
$pedido = 0;
$iva = 0;
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
            <form name="encpedido" id="encpedido" action="" method="post">
              <div class="row">
                <div class="col-md-12 mt-2">
                  <label class="form-label">Pedido No. </label>
                  <div id="respuesta"> </div>
                </div>
                <div class="col-md-12">
                  <label for="name" class="form-label">Fecha </label>
                  <input type="date" class="form-control" name="fechap" id="fechap" required='true' default="date()" value="date()">
                </div>
                <div class="col-md-12 mt-2">
                  <label class="form-label">Cédula (Codigo) Cliente <em></em></label>
                 <!-- <input type="number" class="form-control" name="cedula" id="cedula" required="true" autofocus> -->
                 <select name="customer" id="customer" class="form-select rounded-0" required>
                         <option value="">Seleccione Cliente  Nombre</option>
                         <?php echo $funciones->customerDropdownList();?>
                  </select>
                  <div id="respuesta"> </div>
                </div>

               
              </div>
              <div class="row justify-content-start text-center mt-5">
                <div class="col-12">
                <?php  $permission='Registrar_Nuevo_Pedido'; 
                    if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>
                      <button class="btn btn-primary btn-block" name="btnEnviar" value="Pedido" id="btnEnviar">
                         <i class=""></i>
                          Registrar Nuevo pedido
                     </button>
                     <?php }else {?><button disabled class="btn btn-primary btn-block" name="btnEnviar" value="Pedido" id="btnEnviar">
                         <i class=""></i>
                          Registrar Nuevo pedido
                     </button><?php }?>

                </div>
              </div>

          </div>
          </form>

          <div class="col-sm-7">
            <div class="row" id="lismovped" action='listmovped'>
              <?php // aqui va el listado de movimiento de pedido 
              // $funciones->listmovped($pedido); 
              ?>
            </div>
          </div>
        </div>



        <?php
        $mensaje = "";

        if (isset($_POST['btnEnviar'])) {
          $cedula = $_POST['customer'];
          
          $selectQuery   = ("SELECT * FROM ims_customer WHERE codcli='" . $cedula . "' ");
          $query         = mysqli_query($conn, $selectQuery);
          $totalCliente  = mysqli_num_rows($query);
          if ($totalCliente <= 0) {
            $jsonData['success'] = 1;
            $jsonData['message'] = '<p style="color:red;">El codigo ingresado NO Existe, intente de nuevo<strong>(' . $cedula . ')<strong></p>';

            echo '<p style="color:red;">El codigo ingresado NO Existe,' . $cedula . '</p>';
          } else {
            
            if (!empty($_POST['customer'])) 
            {   echo '<p style="color:red;">Grabando,' . $cedula . '</p>';
              // Grabar pedido
              $estado = "I";
              $fech_p = $_POST['fechap'];
              //probando pdo
              try {
                // Conexión a la base de datos usando PDO
                $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
                $pdo->beginTransaction();
                $pedido = npedido($pedido);
                $iva = obteneriva($iva);
                $stmt = $pdo->prepare("INSERT INTO pedido (numped, codcli, fecha_ped, status) VALUES (:numero_pedido, :cliente_id, NOW(),:estado_id)");
                $stmt->bindParam(':numero_pedido', $pedido);
                $stmt->bindParam(':cliente_id', $cedula);
                $stmt->bindParam(':estado_id', $estado);
                $stmt->execute();
                $pedidoId = $pdo->lastInsertId();
                $pdo->commit();

              } catch (PDOException $e) {
                // Si algo falla, se revierte la transacción.
                // Esto asegura que no queden datos inconsistentes en la base de datos.
                $pdo->rollBack();
                echo "Error al procesar el pedido: " . $e->getMessage() . "<br>";
                // En un entorno de producción, loguear el error en lugar de mostrarlo directamente al usuario.
            } catch (Exception $e) {
                echo "Error inesperado: " . $e->getMessage() . "<br>";
            }
              //pdo
              
            //  $Insertpedido = "
             //        INSERT INTO pedido(codcli,fecha_ped, numped, status) 
             //        VALUES ('" . $cedula . "','" . $fech_p . "', '" . $pedido . "', '" . $estado . "')";
              //echo '<p style="color:red;">Insertando ...,'.$cedula. ''.$pedido.'</p>';
              $query="select * from pedido where numped=$pedido";
              $resultadoped = mysqli_query($conn, $query);
              
              
              if (!$resultadoped) {
                die('Error in query: ' . mysqli_error($conn));
              }
              else {header("Location: mostrarpedido.php?pedido=$pedido");
              exit();}
              //include_once 'mostrarpedido.php?pedido=$pedido';
            }
          }
        } ?>


      </div>

    </div>

    <div>

</html>
      </body>