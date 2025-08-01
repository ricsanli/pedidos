
<?php
include 'tablas.php';

$jsonData = array();
require("config.php");
$nombre = ucwords($_REQUEST['nombre']); //ucwords para convertir la 1 letra mayuscula
$cedula        = $_REQUEST['cedula'];
$correo        = $_REQUEST['correo']; 
$celular       = $_REQUEST['celu'];


//$InsertCliente = "INSERT INTO ims_customer(
 //     name,
 //     codcli,
 //     address,
 //     mobile
 //     )
 //   VALUES (
 //     '" .$cedula. "',
 //     '". $nombre."',
 //     '" .$correo. "',
 //     '" .$celular. "'
 // )";

  $InsertCliente = "
			INSERT INTO ims_customer(codcli,name, address, mobile) 
			VALUES ('".$cedula."','".$nombre."', '".$correo."', '".$celular."')";	
    
  if ((!empty($cedula))  && (!empty($nombre)) && (!empty($correo) ) && ((!empty($celular))))
       {  $resultadoCliente = mysqli_query($conn, $InsertCliente);
            }
       else { $jsonData['message'] = '<p style="color:red;">Rellene los Datos  </p>';
             echo json_encode( $jsonData );}
   
?>