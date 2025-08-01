
    
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
    $fechaini='2025-05-01';
    $fechafin='2025-06-30';
    include 'config.php';
    
    //$sql = "select * from ims_customer";
    //$query         = mysqli_query($conn, $sql);
    $sqlped =" SELECT * FROM pedido AS ped INNER JOIN ims_customer as cli ON ped.codcli=cli.codcli WHERE ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin' ORDER BY numped";
    $queryped = mysqli_query($conn,$sqlped);

    
    if(!$queryped){
      die('Error in query: '. mysqli_error($conn));
}else {    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              <th scope="col">Pedido</th>
              <th scope="col">Fecha</th>
              <th scope="col">Cliente</th>
              <th scope="col">SubTotal</th>
              <th scope="col">TOTAL</th>
              <th scope="col">Accion </th>
            </tr>
        </thead>
    
       
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($queryped )){
                $totalp=$totalp+$datapedido['subtotal'];  
                $iiva=$iiva+$datapedido['iva_t'];  
            
            ?>
            <tr>
            
              <td><?php echo $datapedido['numped']; ?></td>
              <td><?php echo $datapedido['fecha_ped']; ?></td>
              <td><?php echo $datapedido['name']; ?></td>
              <td><?php echo $datapedido['subtotal']; ?></td>
              <td><?php echo $datapedido['subtotal']+$datapedido['iva_t']; ?></td>
              <td>
                <a href="consultarpedido.php?np=<?= $datapedido['numped'] ?>"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
                <a href="eliped.php?np=<?= $datapedido['numped'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion6()'><i class="fa fa-trash"></i></button></a>
              </td>
              </tr>
            <?php 
             }?>
             
          <!--
            <td><?php  echo "<tr><td colspan='3'>Sub-Total Pedidos =>></td><td>" .number_format($totalp, 2, ',', '.')."</td></tr>"; ?></td>   
           <td><?php echo "<tr><td colspan='3'>Total IVA (Inc) =>></td><td>" .number_format($totalp+$iiva, 2, ',', '.')."</td></tr>";?> </td> 
            -->
             
        </tbody>
        <tfoot>
        <tr>
               <th> </th>
              <th > </th>
              <th > </th>
              <th ></th>
             <th> </th> 
             <th> </th> 
             
        </tr>
        </tfoot>
        
       </table>
    </div>
            </body>
    
            <script>
new DataTable('#tablita', {
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',footer:true},
            {extend:'excel',footer:true}, 
            {extend:'pdf', footer:true}, 
            {extend:'colvis'},
            {extend:'print',footer:true}]
        }
    },
    language: {
                url: 'js/es-ES.json',
            },
            columnDefs: [
      {
        targets: [5], // Aplica a las columnas 5
        orderable: true // Desactiva el ordenamiento para estas columnas en false
      }
    ],



});



    </script>
    
     
<?php
   }   
