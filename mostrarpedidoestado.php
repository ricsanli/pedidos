<!DOCTYPE html>
<html>


<body>
  <?php
  //session_start();
  include ('inc/consec.php');
 // include('funciones.php');
  include('menus.php');
  include('config.php');
  $datoscliente = array();
  //$funciones = new funciones();
  include 'tablas.php';
?>
  <head>
  
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap5.css">
  

 
 
 
 
</head>
  <?php
  $iva=0;
  //$codcli = $_GET['codcli'];

  $fechaini = $_GET['fechaini'];
  $fechafin = $_GET['fechafin'];
 // $sql = $conn->query("select * from ims_customer where codcli = $codcli");
 // $datos2 = $sql->fetch_object();
 // $nomcli = $datos2->name;

 
 cambiaestado($fechaini,$fechafin);
  ?>