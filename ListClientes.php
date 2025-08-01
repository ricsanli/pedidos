   <!DOCTYPE html>
   <html>
   <head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Listado Clientes</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
   </head>
   <body>
    
   </body>
   </html>
   <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="css/themes/alertify.css">
    <link rel="stylesheet" href="css/themes/bootstrap.css">
    <script src="js/jquery-3.7.1.js"> </script>
    <script src="js/dataTables.js"> </script>
    <script src="js/bootstrap.min.js"> </script>
    <script> src="js/alertify.js" </script>
    <
    
    <?php 
    include 'config.php';
    
    $sql = "select * from ims_customer";
    $query         = mysqli_query($conn, $sql);
       
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
                <td>Codcli</td>
                <td>Nombre</td>
                <td>Direccion</td>
                <td>mobile</td>
                <td>balance</td>
                <td>Accion</td>
            </tr>
        </thead>
    
        <tfoot>
        <tr>
                <td>Codcli</td>
                <td>Nombre</td>
                <td>Direccion</td>
                <td>mobile</td>
                <td>balance</td>
                <td>Accion</td>
        </tr>
        </tfoot>
        <tbody>
            <?php 
             while ($datapedido = mysqli_fetch_array($query)){
    
            
            ?>
            <tr>
            <td>  <?php echo $datapedido['codcli']; ?></td>
                  <td><?php echo $datapedido['name']; ?></td>
                  <td><?php echo $datapedido['address']; ?></td>
                  <td><?php echo $datapedido['mobile']; ?></td>
                  <td><?php echo $datapedido['balance']; ?></td>
                  <td>
                    <a href="modicliente.php?id=<?= $datapedido['id'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['id']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= ''><i class="fa fa-edit"></i></button></a>
                    <a href="elicliente.php?id=<?= $datapedido['id'] ?>"> <button type="button" name="delete" id="$datampedido['id']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
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
    
     