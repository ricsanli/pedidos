<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="js/jquery-3.7.1.js"> </script>
    <script src="js/popper.min.js"> </script>
    <script src="js/dataTables.js"> </script>
    <script src="js/bootstrap.bundle.min.js"> </script>
    <script src="js/bootstrap.min.js"> </script>
<link rel="stylesheet" href="css/dataTables.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">
   
</head>
<body>
    
</body>
</html>

<?php 
require_once 'config.php';
$numped=220;

$sql = "select * from mov_ped where  numped = '".$numped."' ";
$sqlmovped="select * from mov_ped as mp INNER JOIN ims_product as prod ON mp.pid=prod.pid
      where mp.numped='.$numped.'";
$query         = mysqli_query($conn, $sqlmovped);
?>





<table id="example" class="display">
<thead>
        <tr>
           <td>Pedido</td>
            <td>Producto</td>
            <td>Precio</td>
            <td>Cantidad</td>
            <td>Total</td>
            <td>Accion</td>
            
        </tr>
    </thead>

    <tfoot>
    <tr>
    <td>Pedido</td>
            <td>Producto</td>
            <td>Precio</td>
            <td>Cantidad</td>
            <td>Total</td>
            
    </tr>
    </tfoot>
    <tbody>
        <?php 
         while ($datapedido = mysqli_fetch_array($query)){

        
        ?>
        <tr>
        <td>  <?php echo $datapedido['numped']; ?></td>
              <td><?php echo $datapedido['pname']; ?></td>
              <td><?php echo $datapedido['cantidad']; ?></td>
              <td><?php echo $datapedido['precio']; ?></td>
              <td><?php echo $datapedido['total']; ?></td>
              <td>
                <a href="modimovped.php?np=<?= $datapedido['numped'] ?>&idprod=<?=$datapedido['pid'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= 'return modimovped()'><i class="fa fa-edit"></i></button></a>
                <a href="elimovped.php?np=<?= $datapedido['numped'] ?>&idprod=<?=$datapedido['pid'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
              </td>
        </tr>
        <?php 
         }?>
    </tbody>    


</table>
    <script type=text/Javascript>
    new DataTable('#example', {
        
    language: {
        url: 'js/es-ES.json',
    },
    paging: false,
    scrollCollapse: true,
    scrollY: '200px'
});
</script>