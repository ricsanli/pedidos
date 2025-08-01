<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="css/themes/alertify.css">
<link rel="stylesheet" href="css/themes/bootstrap.css">
<script src="js/jquery-3.7.1.js"> </script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/dataTables.buttons.js"></script>
<script src= "js/buttons.bootstrap5.js"></script>
<script src= "js/jszip.min.js"></script>
<script src= "js/pdfmake.min.js"></script>
<script src= "js/vfs_fonts.js"></script>
<script src= "js/buttons.html5.min.js"></script>
<script src= "js/buttons.print.min.js"></script>
<script src= "js/buttons.colVis.min.js"></script>



<script src="js/popper.min.js"> </script>
<script src="js/bootstrap.min.js"> </script>

<script src="js/dataTables.bootstrap.min.js"> </script>
<script src="js/dataTables.bootstrap5.js"> </script>
<script> src="js/alertify.js" </script>
<script src="js/dataTables.js"> </script>


<?php 
include 'config.php';
//$numped=123;
$codigo='3003';
$sql = "select * from pedido where  codcli = $codigo";
$query         = mysqli_query($conn, $sql);



?>
<body>
<div>

<table class="table table-hover table-condensed" id="tablita">
    <thead>
        <tr>
            <td>Pedido</td>
            <td>Fecha</td>
            <td>Status</td>
            <td>Subtotal</td>
            <td>Total</td>
            <td>Accion</td>
        </tr>
    </thead>

    <tfoot>
    <tr>
            <td>Pedido</td>
            <td>Fecha</td>
            <td>Status</td>
            <td>Subtotal</td>
            <td>Total</td>
            <td>Accion</td>
    </tr>
    </tfoot>
    <tbody>
        <?php 
         while ($datapedido = mysqli_fetch_array($query)){

        
        ?>
        <tr>
        <td>  <?php echo $datapedido['numped']; ?></td>
              <td><?php echo $datapedido['fecha_ped']; ?></td>
              <td><?php echo $datapedido['status']; ?></td>
              <td><?php echo $datapedido['subtotal']; ?></td>
              <td><?php echo $datapedido['subtotal']+$datapedido['iva_t']; ?></td>
              <td>
                <a href="modimovped.php?np=<?= $datapedido['numped'] ?>&idprod=<?=$datapedido['pid'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= 'return modimovped()'><i class="fa fa-edit"></i></button></a>
                <a href="elimovped.php?np=<?= $datapedido['numped'] ?>&idprod=<?=$datapedido['pid'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
              </td>
        </tr>
        <?php 
         }?>
    </tbody>
</table>
</div>
        </body>

<script type= "text/javascript">
 //  $(document).ready(function(){
//    $('#tablita').DataTable();
    
  // });

  new DataTable('#tablita', {
    
        
        language: {
            url: 'js/es-ES.json',
        },
       
    });
   
</script>



