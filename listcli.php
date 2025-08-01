<!DOCTYPE html>
<html>


<body>
  <?php
  session_start();
  include ('inc/consec.php');
  include('funciones.php');
  include('config.php');
  $datoscliente = array();
  $funciones = new funciones();
  include 'tablas.php';
?>
  <head>
        
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
  <?php
  


  listClientes();

  ?>
 