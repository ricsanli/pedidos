<?php 
function lmovped($numped){
    ?>
    <!DOCTYPE html>
    
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
    <body>
    <div>   
    
    
    
    <?php 
  include 'config.php'; 
  $sql2 = $conn->query("select * from pedido where numped = $numped");
  $datos2 = $sql2->fetch_object();
  $fechap=$datos2->fecha_ped;
  $ccliente = $datos2->codcli;
  $sql3 = $conn->query("select * from ims_customer where codcli = $ccliente");
  $datos3 = $sql3->fetch_object();
  $nomcli=$datos3->name;
  $titulo="Pedido :$numped";
  $fecha_objeto = new DateTime($fechap);
  $fecha_formateada = $fecha_objeto->format('d-m-Y');
  $mensaje="Sistema de pedidos";
  $empresa="Diginet c.a";
       
    
    $sql = "select * from mov_ped where  numped = '".$numped."' ";
    $sqlmovped="select * from mov_ped as mp INNER JOIN ims_product as prod ON mp.pid=prod.pid
          where mp.numped='.$numped.'";
    $query         = mysqli_query($conn, $sqlmovped);
    //Buscar permisologia del usuario
    $permission='Modificar_Pedidos'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
    ?>
    
     
    <table id="tablita" class="table table-hover table-condensed">
    <thead>
       
            <tr>
               
                <td>Producto</td>
                <td>Cantidad</td>
                <td>Precio</td>
                <td>Iva</td>
                <td>Sub Total</td>
                <td>Total</td>
                <td>Accion</td>
                
            </tr>
        </thead>
    
        <tfoot>
        <tr>
                 <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
                
        </tr>
        </tfoot>
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;
             while ($datapedido = mysqli_fetch_array($query)){
                      $totalp=$totalp+$datapedido['total'];  
                      $iiva=$iiva+$datapedido['iva_tax'];  
    
            
            ?>
            <tr>
                  <td><?php echo $datapedido['pname']; ?></td>
                  <td><?php echo $datapedido['cantidad']; ?></td>
                  <td><?php echo $datapedido['precio']; ?></td>
                  <td><?php echo $datapedido['iva_tax']; ?></td>
                  <td><?php echo $datapedido['total']; ?></td>
                  <td><?php echo $datapedido['total']+$datapedido['iva_tax']; ?></td>
                  <td>
                  <?php if ($modify)
                    { ?>
                    <a href="modimovped.php?np=<?= $datapedido['numped'] ?>&idprod=<?=$datapedido['pid'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= 'return modimovped()'><i class="fa fa-edit"></i></button></a>
                    <a href="elimovped.php?np=<?= $datapedido['numped'] ?>&idprod=<?=$datapedido['pid'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
                    <?php } ?> 
                </td>
            </tr>
            <?php 
             }?>
        </tbody>    
     <!--   <?php  echo "<tr><td colspan='3'>Sub-Total Pedido =>></td><td>" .number_format($totalp, 2, ',', '.')."</td></tr>"; 
             echo "<tr><td colspan='3'>Total IVA (Inc) =>></td><td>" .number_format($totalp+$iiva, 2, ',', '.')."</td></tr>"; 
           ?> -->
    
    
    </table>
    </div>
    </body>
            
    <script type= "text/javascript">
     var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
     var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";  
     var empresaJS = "<?php echo htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8'); ?>";
     var numpedJS = "<?php echo htmlspecialchars($numped, ENT_QUOTES, 'UTF-8'); ?>";
     var nomcliJS = "<?php echo htmlspecialchars($nomcli, ENT_QUOTES, 'UTF-8'); ?>";
     var fechapedJS = "<?php echo htmlspecialchars($fecha_formateada, ENT_QUOTES, 'UTF-8'); ?>";
     new DataTable('#tablita',{
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
                text: 'Imprimir Pedidos',
                                customize: function ( win ) {
                                    // Crear el encabezado dinámicamente
                                    var companyName = empresaJS; // Puedes obtener esto de una variable PHP o JS
                                    var orderNumber = numpedJS; // Si quieres un número de pedido general, puedes poner "Lista de Pedidos"
                                    var clientName =nomcliJS  ; // Puedes poner "General"
                                    //var currentDate = new Date().toLocaleDateString();
                                    var currentDate = fechapedJS;


                                    var header = '<div style="text-align: left; margin-bottom: 20px;">' +
                                                 '<h2 style="margin: 0;">' + companyName + '</h2>' +
                                                 '<p style="margin: 5px 0;"><strong>Numero de Pedido:</strong> ' + orderNumber + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Cliente:</strong> ' + clientName + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Fecha:</strong> ' + currentDate + '</p>' +
                                                 '</div>';

                                    $(win.document.body).prepend( header );

                                    // Puedes añadir estilos al documento de impresión si lo deseas
                                    $(win.document.body).find('h1').css('text-align', 'center');
                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [6], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
        //total iva_
        totiva = api
            .column(3)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0); 
        totneto = api
            .column(4)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0); 

        // Total over all pages
        total = api
            .column(5)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(5, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        const numeroFormateadoUS = totiva.toLocaleString('en-US');
        api.column(3).footer().innerHTML =
         'IVA ' + numeroFormateadoUS;  
         const numeroFormat = totneto.toLocaleString('en-US');
        api.column(4).footer().innerHTML =
            'Neto ' + numeroFormat;
            var summa = totiva+totneto;
            const numeroForma = summa.toLocaleString('en-US');
        api.column(5).footer().innerHTML =
            'Total ' + numeroForma;    
                
      }

    });
    </script>

<?php

}
//fin lmovped
function listClientes(){ 
    
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
    include 'config.php';
    $titulo='Listado de clientes ';
    $mensaje='Sistemas Diginet c.a';
    
    $sql = "select * from ims_customer";
    $query         = mysqli_query($conn, $sql);
    //Buscar permisologia del usuario
    $permission='Modificar_Cliente'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
     
    
    ?>   
    
    
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
                <td>Codigo</td>
                <td>Nombre</td>
                <td>Direccion</td>
                <td>mobile</td>
                <td>balance</td>
                <td>Accion</td>
            </tr>
        </thead>
    
        <tfoot>
        <tr>
                <td>Codigo</td>
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
                    <?php if ($modify)
                    { ?>
                    <a href="modicliente.php?id=<?= $datapedido['id'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['id']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= ''><i class="fa fa-edit"></i></button></a>
                    <a href="elicliente.php?id=<?= $datapedido['id'] ?>"> <button type="button" name="delete" id="$datampedido['id']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
                    <?php } ?> 
                    </td>
            </tr>
            <?php 
             }?>
        </tbody>
    </table>
    </div>
            </body>
    
    <script type= "text/javascript">
     var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";  
    
      new DataTable('#tablita', {
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [5], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
        });
       
    </script>
    
     
<?php

}

// lista pedidos
function listped($codcli,$fechaini,$fechafin,$nomcli){
    ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="css/themes/alertify.css">
    <link rel="stylesheet" href="css/themes/bootstrap.css">
    
    
    
    <script> src="js/alertify.js" </script>
    <script src="js/dataTables.js"> </script>
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
     
    include 'config.php';
    $sqlped= "SELECT * FROM pedido AS ped INNER JOIN ims_customer AS cli ON ped.codcli=cli.codcli WHERE (ped.codcli=?) AND ped.fecha_ped BETWEEN '$fechaini' AND '$fechafin' ";
   // $queryped = mysqli_query($conn,$sqlped);
    $stmt = $conn->prepare($sqlped);
    $stmt->bind_param("s", $codcli);
    $stmt->execute();
    $queryped = $stmt->get_result();
    if(!$queryped){
      die('Error in query: '. mysqli_error($conn));
}else {  
     //Buscar permisologia del usuario
    $permission='Modificar_Pedidos'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
    $fecha_objeto = new DateTime($fechaini);
    $fechaini_format = $fecha_objeto->format('d-m-Y');
    $fecha_objeto2 = new DateTime($fechafin);
    $fechafin_format = $fecha_objeto2->format('d-m-Y');
    
    $titulo='Listado de Pedidos por cliente desde '.$fechaini_format.' hasta '.$fechafin_format.' '.$codcli.' '.$nomcli;
    $mensaje='Gerencia de Sistemas';
    $empresa='Diginet c.a';
    
  
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              <th scope="col">Pedido</th>
              <th scope="col">Fecha</th>
              <th scope="col">Status</th>
              <th scope="col">SubTotal</th>
              <th scope="col">TOTAL</th>
              <th scope="col">Accion </th>
            </tr>
        </thead>
    
       
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($queryped)){
                $totalp=$totalp+$datapedido['subtotal'];  
                $iiva=$iiva+$datapedido['iva_t'];  
            
            ?>
            <tr>
            
              <td><?php echo $datapedido['numped']; ?></td>
              <td><?php echo $datapedido['fecha_ped']; ?></td>
              <td><?php echo $datapedido['status']; ?></td>
              <td><?php echo $datapedido['subtotal']; ?></td>
              <td><?php echo $datapedido['subtotal']+$datapedido['iva_t']; ?></td>
              <td>
              <?php if ($modify)
                    { ?>
                <a href="consultarpedido.php?np=<?= $datapedido['numped'] ?>"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
                <a href="eliped.php?np=<?= $datapedido['numped'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion6()'><i class="fa fa-trash"></i></button></a>
                <?php } ?>   
            </td>
            </tr>
            <?php 
             }?>
        </tbody>
        <tfoot>
        <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        </tr>
        </tfoot>
       <!-- <?php  echo "<tr><td colspan='3'>Sub-Total Pedido =>></td><td>" .number_format($totalp, 2, ',', '.')."</td></tr>"; 
             echo "<tr><td colspan='3'>Total IVA (Inc) =>></td><td>" .number_format($totalp+$iiva, 2, ',', '.')."</td></tr>"; 
           ?> -->
    </table>
    </div>
    </body>
    
    
    <script>
      
    var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";   
    var empresaJS = "<?php echo htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8'); ?>"; 
    var nomcliJS = "<?php echo htmlspecialchars($nomcli, ENT_QUOTES, 'UTF-8'); ?>";
    new DataTable('#tablita',{
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
                text: 'Imprimir',
                                customize: function ( win ) {
                                    // Crear el encabezado dinámicamente
                                    var companyName = empresaJS; // Puedes obtener esto de una variable PHP o JS
                                    var orderNumber = ''; // Si quieres un número de pedido general, puedes poner "Lista de Pedidos"
                                    var clientName = nomcliJS; // Puedes poner "General"
                                    var currentDate = new Date().toLocaleDateString();

                                    var header = '<div style="text-align: left; margin-bottom: 20px;">' +
                                                 '<h2 style="margin: 0;">' + companyName + '</h2>' +
                                                 '<p style="margin: 5px 0;"><strong>Gerencia de Sistemas:</strong> ' + orderNumber + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Cliente:</strong> ' + clientName + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Fecha:</strong> ' + currentDate + '</p>' +
                                                 '</div>';

                                    $(win.document.body).prepend( header );

                                    // Puedes añadir estilos al documento de impresión si lo deseas
                                    $(win.document.body).find('h1').css('text-align', 'center');
                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [5], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    
         
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
        // Total over all pages
        total = api
            .column(4)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(3, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        const numeroFormateadoUS = pageTotal.toLocaleString('en-US');
        api.column(3).footer().innerHTML =
         'SubTotal pg.$ ' + numeroFormateadoUS;  
         const numeroFormat = total.toLocaleString('en-US');
        api.column(4).footer().innerHTML =
            'Total $' + numeroFormat;
                
      }});    
     
    
       
    </script>
    
     
<?php
   }
}
// fin lista pedidos

function listped2($fechaini,$fechafin){
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
    include 'config.php';
    $fecha_objeto = new DateTime($fechaini);
    $fechaini_format = $fecha_objeto->format('d-m-Y');
    $fecha_objeto2 = new DateTime($fechafin);
    $fechafin_format = $fecha_objeto2->format('d-m-Y');

    $titulo='Listado de Pedidos desde '.$fechaini_format.' hasta '.$fechafin_format;
    $mensaje='Gerencia de Sistemas ';
    $empresa="Diginet c.a";
    
    //$sql = "select * from ims_customer";
    //$query         = mysqli_query($conn, $sql);
    $sqlped =" SELECT * FROM pedido AS ped INNER JOIN ims_customer as cli ON ped.codcli=cli.codcli WHERE ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin' ORDER BY numped";
    $queryped = mysqli_query($conn,$sqlped);
    //Buscar permisologia del usuario
    $permission='Modificar_Pedidos'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);

    
    if(!$queryped){
      die('Error in query: '. mysqli_error($conn));
}else {    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              
              <td scope="col">Pedido</td>
              <td scope="col">Fecha</td>
              <td scope="col">Cliente</td>
              <td scope="col">SubTotal</td>
              <td scope="col">TOTAL</td>
              <td scope="col">Accion </td>
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
              <?php if ($modify)
                    { ?>
                <a href="consultarpedido.php?np=<?= $datapedido['numped'] ?>"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
                <a href="eliped.php?np=<?= $datapedido['numped'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion6()'><i class="fa fa-trash"></i></button></a>
                <?php } ?>  
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
    var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";   
    var empresaJS = "<?php echo htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8'); ?>";
    new DataTable('#tablita', {
        
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
                text: 'Imprimir',
                                customize: function ( win ) {
                                    // Crear el encabezado dinámicamente
                                    var companyName = empresaJS; // Puedes obtener esto de una variable PHP o JS
                                    var orderNumber = ''; // Si quieres un número de pedido general, puedes poner "Lista de Pedidos"
                                    var clientName = ''; // Puedes poner "General"
                                    var currentDate = new Date().toLocaleDateString();

                                    var header = '<div style="text-align: left; margin-bottom: 20px;">' +
                                                 '<h2 style="margin: 0;">' + companyName + '</h2>' +
                                                 '<p style="margin: 5px 0;"><strong>Gerencia de Sistemas:</strong> ' + orderNumber + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Barquisimeto:</strong> ' + clientName + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Fecha:</strong> ' + currentDate + '</p>' +
                                                 '</div>';

                                    $(win.document.body).prepend( header );

                                    // Puedes añadir estilos al documento de impresión si lo deseas
                                    $(win.document.body).find('h1').css('text-align', 'center');
                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [5], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    
         
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
        // Total over all pages
        total = api
            .column(4)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(3, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        const numeroFormateadoUS = pageTotal.toLocaleString('en-US');
        api.column(3).footer().innerHTML =
         'SubTotal pg.$ ' + numeroFormateadoUS;  
         const numeroFormat = total.toLocaleString('en-US');
        api.column(4).footer().innerHTML =
            'Total $' + numeroFormat;
                
      }});    
      
    </script>
    
     
<?php
   }   
}

//lista productos pedidos
function listpp($fechaini,$fechafin){
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
    include 'config.php';
    $fecha_objeto = new DateTime($fechaini);
    $fechaini_format = $fecha_objeto->format('d-m-Y');
    $fecha_objeto2 = new DateTime($fechafin);
    $fechafin_format = $fecha_objeto2->format('d-m-Y');

    $titulo='Listado de Productos Pedidos desde '.$fechaini_format.' hasta '.$fechafin_format;
    $mensaje='Gerencia de Sistemas';
    $empresa='Diginet c.a';
     
    
    $sqlmped =" SELECT *, SUM(cantidad) AS TOTCan,SUM(total) AS TOTtot,
    SUM(total+mped.iva_tax) AS TOTciva
    FROM mov_ped AS mped 
    INNER JOIN pedido as ped ON ped.numped=mped.numped 
    inner join ims_product as prod ON prod.pid=mped.pid 
     WHERE ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin' 
     group by mped.pid
    ORDER BY mped.pid";
                
    $querymped = mysqli_query($conn,$sqlmped );            
    
    if(!$querymped){
      die('Error in query: '. mysqli_error($conn));
}else {    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              
              <td scope="col">C.Prod</td>
              <td scope="col">Nombre</td>
              <td scope="col">Cantidad</td>
              <td scope="col">Precio Ini</td>
              <td scope="col">SubTotal</td>
              <td scope="col">Total </td>
              <td scope="col">Detalles </td>
            </tr>
        </thead>
           
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($querymped )){
                       
                        
            ?>

            <tr>
            
              <td><?php echo $datapedido['pid']; ?></td>
              <td><?php echo $datapedido['pname']; ?></td>
              <td><?php echo $datapedido['TOTCan']; ?></td>
              <td><?php echo $datapedido['precio']; ?></td>
              <td><?php echo $datapedido['TOTtot'];?></td>
              <td><?php echo $datapedido['TOTciva']; ?></td>
             
              <td>  <a href="consultar_pro_pedido.php?pid=<?= $datapedido['pid'] ?>&fechaini=<?=$fechaini ?>&fechafin=<?=$fechafin ?>"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
               
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
              <th> </th> 
             
        </tr>
        </tfoot>
        
       </table>
    </div>
            </body>
    
    <script>
    var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";   
    var empresaJS = "<?php echo htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8'); ?>";
    new DataTable('#tablita', {
        
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 6
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
                text: 'Imprimir',
                                customize: function ( win ) {
                                    // Crear el encabezado dinámicamente
                                    var companyName = empresaJS; // Puedes obtener esto de una variable PHP o JS
                                    var orderNumber = ''; // Si quieres un número de pedido general, puedes poner "Lista de Pedidos"
                                    var clientName = ''; // Puedes poner "General"
                                    var currentDate = new Date().toLocaleDateString();

                                    var header = '<div style="text-align: left; margin-bottom: 20px;">' +
                                                 '<h2 style="margin: 0;">' + companyName + '</h2>' +
                                                 '<p style="margin: 5px 0;"><strong>Gerencia de Sistemas:</strong> ' + orderNumber + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Barquisimeto:</strong> ' + clientName + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Fecha:</strong> ' + currentDate + '</p>' +
                                                 '</div>';

                                    $(win.document.body).prepend( header );

                                    // Puedes añadir estilos al documento de impresión si lo deseas
                                    $(win.document.body).find('h1').css('text-align', 'center');
                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 6
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [6], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    
         
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
        // Cantidad pedida over all pages
        cantiped = api
            .column(2)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        // Total over all pages
        total = api
            .column(5)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(4, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        const numeropedido = cantiped.toLocaleString('en-US');
        api.column(2).footer().innerHTML =
            'Pedido ' + numeropedido;
        const numeroFormateadoUS = pageTotal.toLocaleString('en-US');
        api.column(4).footer().innerHTML =
         'SubTotal pg.$ ' + numeroFormateadoUS;  
         const numeroFormat = total.toLocaleString('en-US');
        api.column(5).footer().innerHTML =
            'Total $' + numeroFormat;
                
      }});    
      
    </script>
    
     
<?php
   }   
}
//listado de productos por pedido
function lisproped($codpro,$nompro,$fechaini,$fechafin){
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
    include 'config.php';
   

    $titulo='Listado de Pedidos por producto ID: '.$codpro.' '. ' '.$nompro. ' desde '.$fechaini.' hasta '.$fechafin;
    $mensaje='Sistemas Diginet c.a';
    
    $sqlmped =" SELECT * 
    FROM mov_ped AS mped 
    INNER JOIN pedido as ped ON ped.numped=mped.numped 
    inner join ims_customer AS cli ON ped.codcli=cli.codcli
    inner join ims_product as prod ON prod.pid=mped.pid 
     WHERE mped.pid=$codpro AND ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin' 
     ORDER BY mped.numped"; 
    $queryped = mysqli_query($conn,$sqlmped);
    ?>
    <div class="col-md-12">
       <strong>Consulta de Pedidos del Producto  Codigo: <?php echo $codpro .' '.$nompro.' Desde '.$fechaini.' Hasta '.$fechafin?> </strong>
     </div>
    <?php
    if(!$queryped){
      die('Error in query: '. mysqli_error($conn));
}else {    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              
              <td scope="col">Pedido</td>
              <td scope="col">Fecha</td>
              <td scope="col">Cliente</td>
              <td scope="col">Cantidad</td>
              <td scope="col">Precio</td>
              <td scope="col">SubTotal</td>
              <td scope="col">TOTAL</td>
            </tr>
        </thead>
    
       
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($queryped )){
                $totalp=$totalp+$datapedido['subtotal'];  
                $iiva=$iiva+$datapedido['iva_tax'];  
            
            ?>
            <tr>
            
              <td><?php echo $datapedido['numped']; ?></td>
              <td><?php echo $datapedido['fecha_ped']; ?></td>
              <td><?php echo $datapedido['name']; ?></td>
              <td><?php echo $datapedido['cantidad']; ?></td>
              <td><?php echo $datapedido['precio']; ?></td>
              <td><?php echo $datapedido['total']?></td> 
              <td><?php echo $datapedido['total']+$datapedido['iva_tax']; ?></td>
             <!-- <td>
                <a href="consultarpedido.php?np=<?= $datapedido['numped'] ?>"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
                <a href="eliped.php?np=<?= $datapedido['numped'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion6()'><i class="fa fa-trash"></i></button></a>
              </td> -->
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
              <th> </th> 
             
        </tr>
        </tfoot>
        
       </table>
    </div>
            </body>
    
    <script>
    var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";   
    new DataTable('#tablita', {
        
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [6], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    
         
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
        // cantidad
        // Total over all pages
            cantit = api
            .column(3)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);

        // Total over all pages
        total = api
            .column(6)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(5, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        const numeroForma = cantit.toLocaleString('en-US');
        api.column(3).footer().innerHTML =
         'pedido ' + numeroForma; 
        const numeroFormateadoUS = pageTotal.toLocaleString('en-US');
        api.column(5).footer().innerHTML =
         'SubTotal pg.$ ' + numeroFormateadoUS;  
         const numeroFormat = total.toLocaleString('en-US');
        api.column(6).footer().innerHTML =
            'Total $' + numeroFormat;
                
      }});    
      
    </script>
    
     
<?php
   }   
}

//lista productos pedidos
// lista de pedido por cliente
function listpc($fechaini,$fechafin){
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
    include 'config.php';
    $fecha_objeto = new DateTime($fechaini);
    $fechaini_format = $fecha_objeto->format('d-m-Y');
    $fecha_objeto2 = new DateTime($fechafin);
    $fechafin_format = $fecha_objeto2->format('d-m-Y');

    $titulo='Listado de Pedidos por Cliente desde '.$fechaini_format.' hasta '.$fechafin_format;
    $mensaje='Gerencia de Sistemas';
    $empresa='Diginet c.a'; 
    
    $sqlmped =" SELECT *, SUM(subtotal) AS TOTsub,SUM(iva_t) AS TOTtot,
    SUM(subtotal+iva_t) AS TOTciva
    FROM pedido AS ped 
    INNER JOIN ims_customer as cli ON ped.codcli=cli.codcli 
    WHERE ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin' 
    group by ped.codcli
    ORDER BY ped.numped";
                
    $querymped = mysqli_query($conn,$sqlmped );            
    
    if(!$querymped){
      die('Error in query: '. mysqli_error($conn));
}else {    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              
              <td scope="col">Cliente</td>
              <td scope="col">Nombre</td>
              <td scope="col">Mobile</td>
              <td scope="col">SubTotal</td>
              <td scope="col">IVA</td>
              <td scope="col">Total </td>
              <td scope="col">Detalles </td>
            </tr>
        </thead>
           
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($querymped )){
                       
                        
            ?>

            <tr>
            
              <td><?php echo $datapedido['codcli']; ?></td>
              <td><?php echo $datapedido['name']; ?></td>
              <td><?php echo $datapedido['mobile']; ?></td>
              <td><?php echo $datapedido['TOTsub']; ?></td>
              <td><?php echo $datapedido['TOTtot']; ?></td>
              <td><?php echo $datapedido['TOTciva'];?></td>
             
              <td>  <a href="consultar_cli_pedido.php?codcli=<?= $datapedido['codcli'] ?>&fechaini=<?=$fechaini ?>&fechafin=<?=$fechafin ?>"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
               
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
              <th> </th> 
              
             
        </tr>
        </tfoot>
        
       </table>
    </div>
            </body>
    
    <script>
    var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";   
    var empresaJS = "<?php echo htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8'); ?>";   
    new DataTable('#tablita', {
        
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 6
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
                text: 'Imprimir',
                                customize: function ( win ) {
                                    // Crear el encabezado dinámicamente
                                    var companyName = empresaJS; // Puedes obtener esto de una variable PHP o JS
                                    var orderNumber = ''; // Si quieres un número de pedido general, puedes poner "Lista de Pedidos"
                                    var clientName = ''; // Puedes poner "General"
                                    var currentDate = new Date().toLocaleDateString();

                                    var header = '<div style="text-align: left; margin-bottom: 20px;">' +
                                                 '<h2 style="margin: 0;">' + companyName + '</h2>' +
                                                 '<p style="margin: 5px 0;"><strong>Gerencia de Sistemas:</strong> ' + orderNumber + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Barquisimeto:</strong> ' + clientName + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Fecha:</strong> ' + currentDate + '</p>' +
                                                 '</div>';

                                    $(win.document.body).prepend( header );

                                    // Puedes añadir estilos al documento de impresión si lo deseas
                                    $(win.document.body).find('h1').css('text-align', 'center');
                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 6
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [6], // Aplica a las columnas 6
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    
         
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
              // Total over all pages
        total = api
            .column(5)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(3, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        
        const numeroFormateadoUS = pageTotal.toLocaleString('en-US');
        api.column(3).footer().innerHTML =
         'SubTotal pg.$ ' + numeroFormateadoUS;  
         const numeroFormat = total.toLocaleString('en-US');
        api.column(5).footer().innerHTML =
            'Total $' + numeroFormat;
                
      }});    
      
    </script>
    
     
<?php
   }   
}
//listado de productos cliente

function liscliped($codcli,$nomcli,$fechaini,$fechafin){
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
    include 'config.php';
    $fecha_objeto = new DateTime($fechaini);
    $fechaini_format = $fecha_objeto->format('d-m-Y');
    $fecha_objeto2 = new DateTime($fechafin);
    $fechafin_format = $fecha_objeto2->format('d-m-Y');

    $titulo='Listado de Pedidos por Cliente desde '.$fechaini_format.' hasta '.$fechafin_format;
    $mensaje='Gerencia de Sistemas';
    $empresa='Diginet c.a';
    
    $sqlmped =" SELECT * 
    FROM mov_ped AS mped 
    INNER JOIN pedido as ped ON ped.numped=mped.numped 
    inner join ims_customer AS cli ON ped.codcli=cli.codcli
    inner join ims_product as prod ON prod.pid=mped.pid 
     WHERE ped.codcli=$codcli AND ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin' 
     ORDER BY mped.pid"; 
    $queryped = mysqli_query($conn,$sqlmped);
    ?>
    <div class="col-md-12">
       <strong>Consulta de Pedidos del Cliente  Codigo: <?php echo $codcli .' '.$nomcli.' Desde '.$fechaini_format.' Hasta '.$fechafin_format?> </strong>
     </div>
    <?php
    if(!$queryped){
      die('Error in query: '. mysqli_error($conn));
}else {    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              
              <td scope="col">Pedido</td>
              <td scope="col">Fecha</td>
              <td scope="col">Producto</td>
              <td scope="col">Cantidad</td>
              <td scope="col">Precio</td>
              <td scope="col">SubTotal</td>
              <td scope="col">TOTAL</td>
            </tr>
        </thead>
    
       
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($queryped )){
                
            
            ?>
            <tr>
            
              <td><?php echo $datapedido['numped']; ?></td>
              <td><?php echo $datapedido['fecha_ped']; ?></td>
              <td><?php echo $datapedido['pname']; ?></td>
              <td><?php echo $datapedido['cantidad']; ?></td>
              <td><?php echo $datapedido['precio']; ?></td>
              <td><?php echo $datapedido['total']?></td> 
              <td><?php echo $datapedido['total']+$datapedido['iva_tax']; ?></td>
             <!-- <td>
                <a href="consultarpedido.php?np=<?= $datapedido['numped'] ?>"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
                <a href="eliped.php?np=<?= $datapedido['numped'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion6()'><i class="fa fa-trash"></i></button></a>
              </td> -->
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
              <th> </th> 
             
        </tr>
        </tfoot>
        
       </table>
    </div>
            </body>
    
    <script>
    var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";   
    var empresaJS = "<?php echo htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8'); ?>";
    var nomcliJS = "<?php echo htmlspecialchars($nomcli, ENT_QUOTES, 'UTF-8'); ?>"; 
    var codcliJS = "<?php echo htmlspecialchars($codcli, ENT_QUOTES, 'UTF-8'); ?>"; 
    
    new DataTable('#tablita', {
        
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
                text: 'Imprimir',
                                customize: function ( win ) {
                                    // Crear el encabezado dinámicamente
                                    var companyName = empresaJS; // Puedes obtener esto de una variable PHP o JS
                                    var orderNumber = ''; // Si quieres un número de pedido general, puedes poner "Lista de Pedidos"
                                    var clientName = nomcliJS; // Puedes poner "General"
                                    var currentDate = new Date().toLocaleDateString();

                                    var header = '<div style="text-align: left; margin-bottom: 20px;">' +
                                                 '<h2 style="margin: 0;">' + companyName + '</h2>' +
                                                 '<p style="margin: 5px 0;"><strong>Gerencia de Sistemas:</strong> ' + orderNumber + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Cliente:</strong> '+codcliJS+' ' + clientName + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Fecha:</strong> ' + currentDate + '</p>' +
                                                 '</div>';

                                    $(win.document.body).prepend( header );

                                    // Puedes añadir estilos al documento de impresión si lo deseas
                                    $(win.document.body).find('h1').css('text-align', 'center');
                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
               
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    
         
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
        // cantidad
        // Total over all pages
            cantit = api
            .column(3)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);

        // Total over all pages
        total = api
            .column(6)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(5, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        const numeroForma = cantit.toLocaleString('en-US');
        api.column(3).footer().innerHTML =
         'pedido ' + numeroForma; 
        const numeroFormateadoUS = pageTotal.toLocaleString('en-US');
        api.column(5).footer().innerHTML =
         'SubTotal pg.$ ' + numeroFormateadoUS;  
         const numeroFormat = total.toLocaleString('en-US');
        api.column(6).footer().innerHTML =
            'Total $' + numeroFormat;
                
      }});    
      
    </script>
    
     
<?php
   }   
}
function listUsuarios(){ 
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
    include 'config.php';
    $titulo='Listado de Usuarios ';
    $mensaje='Sistemas Diginet c.a';
    
    $sql = "select * from ims_user";
    $query         = mysqli_query($conn, $sql);
    //Buscar permisologia del usuario
    $permission='Registrar_Nuevo_Usuario'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
    
    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
                <td>Codigo</td>
                <td>Nombre</td>
                <td>email</td>
                <td>Id Rol</td>
                <td>Accion</td>
            </tr>
        </thead>
    
        <tfoot>
        <tr>
        <td>Codigo</td>
        <td>Nombre</td>
        <td>email</td>
        <td>Id Rol</td>
        <td>Accion</td>
        </tr>
        </tfoot>
        <tbody>
            <?php 
             while ($datapedido = mysqli_fetch_array($query)){
    
            
            ?>
            <tr>
            <td>  <?php echo $datapedido['userid']; ?></td>
                  <td><?php echo $datapedido['name']; ?></td>
                  <td><?php echo $datapedido['email']; ?></td>
                  <td><?php echo $datapedido['id_rol']; ?></td>
                  
                  <td>
                  <?php if ($modify)
                    { ?>
                    <a href="#?id=<?= $datapedido['userid'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['id']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= ''><i class="fa fa-edit"></i></button></a>
                    <a href="#?id=<?= $datapedido['userid'] ?>"> <button type="button" name="delete" id="$datampedido['id']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
                    <?php } ?>  
                </td>
            </tr>
            <?php 
             }?>
        </tbody>
    </table>
    </div>
            </body>
    
    <script type= "text/javascript">
     var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";  
    
      new DataTable('#tablita', {
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
            exportOptions: {columns: [ 0, 1, 2, 3 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [4], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
        });
       
    </script>
    
     
<?php

}

//lista categorias
function listCategorias(){ 
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
    include 'config.php';
    $titulo='Listado de Categorias ';
    $mensaje='Sistemas Diginet c.a';
    
    $sql = "select * from ims_category";
    $query         = mysqli_query($conn, $sql);
    //Buscar permisologia del usuario
    $permission='Registrar_Nueva_Categoria'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
    
    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
                <td>Codigo</td>
                <td>Nombre</td>
                <td>Accion</td>
            </tr>
        </thead>
    
        <tfoot>
        <tr>
        <td>Codigo</td>
        <td>Nombre</td>
        <td>Accion</td>
        </tr>
        </tfoot>
        <tbody>
            <?php 
             while ($datapedido = mysqli_fetch_array($query)){
    
            
            ?>
            <tr>
            <td>  <?php echo $datapedido['categoryid']; ?></td>
                  <td><?php echo $datapedido['name']; ?></td>
                  
                  
                  <td>
                  <?php if ($modify)
                    { ?>
                    <a href="#?id=<?= $datapedido['categoryid'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['categoryid']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= ''><i class="fa fa-edit"></i></button></a>
                    <a href="#?id=<?= $datapedido['categoryid'] ?>"> <button type="button" name="delete" id="$datampedido['categoryid']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
                    <?php } ?>  
                </td>
            </tr>
            <?php 
             }?>
        </tbody>
    </table>
    </div>
            </body>
    
    <script type= "text/javascript">
     var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";  
    
      new DataTable('#tablita', {
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
            exportOptions: {columns: [ 0, 1, 2 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [2], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
        });
       
    </script>
    
     
<?php

}
//lista
function listMarcas(){ 
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
    include 'config.php';
    $titulo='Listado de Marcas ';
    $mensaje='Sistemas Diginet c.a';
    
    $sql = "select * from ims_brand";
    $query         = mysqli_query($conn, $sql);
    //Buscar permisologia del usuario
    $permission='Registrar_Nueva_Marca'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
    
    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
                <td>Codigo</td>
                <td>Nombre</td>
                <td>Categoria</td>
                <td>Accion</td>
            </tr>
        </thead>
    
        <tfoot>
        <tr>
        <td>Codigo</td>
        <td>Nombre</td>
        <td>Categoria</td>
        <td>Accion</td>
        </tr>
        </tfoot>
        <tbody>
            <?php 
             while ($datapedido = mysqli_fetch_array($query)){
    
            
            ?>
            <tr>
            <td>  <?php echo $datapedido['id']; ?></td>
                  <td><?php echo $datapedido['bname']; ?></td>
                  <td><?php echo $datapedido['categoryid']; ?></td>
                  
                  
                  <td>
                  <?php if ($modify)
                    { ?>
                    <a href="#?id=<?= $datapedido['id'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['id']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= ''><i class="fa fa-edit"></i></button></a>
                    <a href="#?id=<?= $datapedido['id'] ?>"> <button type="button" name="delete" id="$datampedido['id']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
                    <?php } ?>  
                </td>
            </tr>
            <?php 
             }?>
        </tbody>
    </table>
    </div>
            </body>
    
    <script type= "text/javascript">
     var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";  
    
      new DataTable('#tablita', {
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
            exportOptions: {columns: [ 0, 1, 2 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [2], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
        });
       
    </script>
    
     
<?php

}

function Permiso($permission,$arreglo) {
    //isset($_SESSION['permissions']) &&
   
   if (in_array($permission, $arreglo))
   { return true;}else{return false;}
   
  }

function cambiaestado($fechaini,$fechafin) {
 
 ?>
    <head>
<link rel="stylesheet" type="text/css" href="ccs\dataTables.dataTables.css">
<link rel="stylesheet" type="text/css" href="ccs\select.dataTables.css">
<script src="js/jquery-3.7.1.js" type="text/javascript"></script>
<script src="js/select.dataTables.js" type="text/javascript"></script>
<script src="js/dataTables.js" type="text/javascript"></script>
<script src="js/dataTables.select.js" type="text/javascript"></script>

</head>
<?php 
include 'config.php';

$fecha_objeto = new DateTime($fechaini);
$fechaini_format = $fecha_objeto->format('d-m-Y');
$fecha_objeto2 = new DateTime($fechafin);
$fechafin_format = $fecha_objeto2->format('d-m-Y');

$titulo='Listado de Pedidos desde '.$fechaini_format.' hasta '.$fechafin_format;
$mensaje='Gerencia de Sistemas ';
$empresa="Diginet c.a";

//$sql = "select * from ims_customer";
//$query         = mysqli_query($conn, $sql);
$sqlped =" SELECT * FROM pedido AS ped INNER JOIN ims_customer as cli ON ped.codcli=cli.codcli WHERE ped.status='I' AND ped.fecha_ped>='$fechaini' AND ped.fecha_ped<='$fechafin' ORDER BY numped";
$queryped = mysqli_query($conn,$sqlped);
if(!$queryped){
    die('Error in query: '. mysqli_error($conn));
}else {    


?>

<button id="btnActualizarSeleccionados">Actualizar seleccionados</button>
<div class="col-md-6">
        <strong>Cambiar Estado de  Pedidos desde <?=$fechaini_format ?> hasta <?=$fechafin_format ?></strong>
      </div>

<table id="example" class="display">
        <thead>
            <tr>
            <th>Check</th>
             <th>Pedido</th>
             <th>Status</th>
             <th>Fecha</th>
             <th>Cliente</th>
             <th>SubTotal</t>
             <th>TOTAL</th>
            
            </tr>
        </thead>
        <tbody>
        <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($queryped ))
             {
                $totalp=$totalp+$datapedido['subtotal'];  
                $iiva=$iiva+$datapedido['iva_t'];  
            
            ?>
            
            <tr data-numped="<?php echo htmlspecialchars($datapedido['numped']); ?>">
           
           <td></td>
            <td><?php echo $datapedido['numped']; ?></td>
            <td><?php echo $datapedido['status']; ?></td>
            <?php $fecha_objeto = new DateTime($datapedido['fecha_ped']);
              $fechaini_format = $fecha_objeto->format('d-m-Y'); ?>
            <td><?php echo htmlspecialchars($fechaini_format); ?></td>
            <td><?php echo htmlspecialchars($datapedido['name']); ?></td>
            <td><?php echo htmlspecialchars($datapedido['subtotal']); ?></td>
            <td><?php echo htmlspecialchars($datapedido['subtotal'])+htmlspecialchars($datapedido['iva_t']); ?></td>
                 
          
            </tr>    
            <?php 
             }?>      
                            
        </tbody>
        <tfoot>
            <tr>
              <td>Check</td>  
              <td>Pedido</td>
              <td>status</td>
              <td>Fecha</td>
              <td>Cliente</td>
              <td>SubTotal</td>
              <td>TOTAL</td>
            </tr>
        </tfoot>
    </table>


<?php } ?>    
<script>
$(document).ready(function() {
    var tabla = new DataTable('#example', {
        select: true, // Ya lo tienes, pero es importante para la extensión Select
        language: {
            url: 'js/es-ES.json',
        },
        columnDefs: [
            {   
                render: DataTable.render.select(),
                targets: 0
            },
            {
                "className": "text-center",
                "targets": [1, 2, 3, 4] // Aplica el centrado a la primera y tercera columna (índices 0 y 2)
            }
        ],
        select: {
            style: 'os', // 'os' para selección tipo sistema operativo (Ctrl/Cmd para múltiples)
            selector: 'td:first-child' // Hace que el click en la primera celda (checkbox) seleccione la fila
        },
        order: [[1, 'asc']] // Ordena por la segunda columna (Pedido)
    });

    // Event listener para el botón 'Actualizar seleccionados'
    $('#btnActualizarSeleccionados').on('click', function() {
        var selectedNumPeds = [];

        // Obtiene todas las filas seleccionadas usando la API de DataTables
        // y luego itera sobre ellas para obtener el atributo data-numped
        tabla.rows({ selected: true }).nodes().to$().each(function() {
            var numPed = $(this).data('numped'); // Obtiene el valor del atributo data-numped de la fila (<tr>)
            if (numPed) {
                selectedNumPeds.push(numPed);
            }
        });

        if (selectedNumPeds.length > 0) {
            // Envía los IDs de los pedidos seleccionados a PHP usando AJAX
            $.ajax({
                url: 'procesar_filas.php', // *** ¡IMPORTANTE! Cambia esto a la ruta de tu script PHP ***
                type: 'POST',
                data: { numPeds: selectedNumPeds }, // 'numPeds' será un array en PHP ($_POST['numPeds'])
                dataType: 'json', // Espera una respuesta JSON del servidor
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        // Opcional: Deseleccionar filas después de una operación exitosa
                        tabla.rows().deselect();
                        // Opcional: Si necesitas recargar o redibujar la tabla después de la acción
                        // tabla.ajax.reload(); // Si tu DataTable se carga via AJAX
                         location.reload(); // Si la tabla se carga de forma estática y necesitas recargar la página
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la comunicación con el servidor: ' + error);
                    console.error("AJAX error:", status, error, xhr.responseText);
                }
            });
        } else {
            alert('Por favor, selecciona al menos una fila para procesar.');
        }
    });
});
</script>
<?php
}  

//listado de productos
function listProductos(){ 
    ?>
    <head>
        
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.2.3/css/buttons.bootstrap5.css">
   
   
       <script src="js/jquery-3.7.1.js"></script>
      <!-- <script src="js/bootstrap.bundle.min.js"></script> -->
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
    include 'config.php';
    $titulo='Listado de Productos ';
    $mensaje='Sistemas Diginet c.a';
    
    $sql = "select * from ims_product as pro inner join ims_brand as mar inner join ims_category as cat on pro.brandid=mar.id and pro.categoryid=cat.categoryid ";
    $query         = mysqli_query($conn, $sql);
    //Buscar permisologia del usuario
    $permission='Registrar_Nuevo_Producto'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
    
    
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
                <td>Id</td>
                <td>Nombre_Pro</td>
                <td>Marca</td>
                <td>Categoria</td>
                <td>PrecioBase</td>
                <td>Modelo</td>
                <td>Accion</td>
            </tr>
        </thead>
    
        <tfoot>
        <tr>
                <td>Id</td>
                <td>Nombre_Pro</td>
                <td>Marca</td>
                <td>Categoria</td>
                <td>PrecioBase</td>
                <td>Modelo</td>
                <td>Accion</td>
        </tr>
        </tfoot>
        <tbody>
            <?php 
             while ($datapedido = mysqli_fetch_array($query)){
    
            
            ?>
            <tr>
            <td>  <?php echo $datapedido['pid']; ?></td>
                  <td><?php echo $datapedido['pname']; ?></td>
                  <td><?php echo $datapedido['bname']; ?></td>
                  <td><?php echo $datapedido['name']; ?></td>
                  <td><?php echo $datapedido['base_price']; ?></td>
                  <td><?php echo $datapedido['model']; ?></td>
                  
                  
                  <td>
                  <?php if ($modify)
                    { ?>
                    <a href="modiproduc.php?pid=<?= $datapedido['pid'] ?>"><button type="button" name="update" value ="uproduct" id="$datampedido['pid']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= ''><i class="fa fa-edit"></i></button></a>
                    <a href="eliproduc.php?pid=<?= $datapedido['pid'] ?>"> <button type="button" name="delete" id="$datampedido['pid']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
                    <?php } ?>  
                </td>
            </tr>
            <?php 
             }?>
        </tbody>
    </table>
    </div>
            </body>
    
    <script type= "text/javascript">
     var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";  
    
      new DataTable('#tablita', {
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
            exportOptions: {columns: [ 0, 1, 2, 3, 4, 5 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [6], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
        });
 function confirmacion3() {
  var respuesta = confirm("¿deseas eliminar este producto ?");
  if (respuesta == true) {
      return true;
  } else {
      return false;
  }
};
       
    </script>
    
     
<?php

}
function peddespa($codcli,$fechaini,$fechafin,$nomcli){
    ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="css/themes/alertify.css">
    <link rel="stylesheet" href="css/themes/bootstrap.css">
    
    
    
    <script> src="js/alertify.js" </script>
    <script src="js/dataTables.js"> </script>
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
     
    include 'config.php';
    $sqlped= "SELECT * FROM pedido AS ped INNER JOIN ims_customer AS cli ON ped.codcli=cli.codcli WHERE (ped.codcli=?) AND ped.status='A' AND ped.fecha_ped BETWEEN '$fechaini' AND '$fechafin' ";
   // $queryped = mysqli_query($conn,$sqlped);
    $stmt = $conn->prepare($sqlped);
    $stmt->bind_param("s", $codcli);
    $stmt->execute();
    $queryped = $stmt->get_result();
    if(!$queryped){
      die('Error in query: '. mysqli_error($conn));
}else {  
     //Buscar permisologia del usuario
    $permission='Modificar_Pedidos'; 
    $modify= false;
    $modify=Permiso($permission,$_SESSION['permissions']);
    $fecha_objeto = new DateTime($fechaini);
    $fechaini_format = $fecha_objeto->format('d-m-Y');
    $fecha_objeto2 = new DateTime($fechafin);
    $fechafin_format = $fecha_objeto2->format('d-m-Y');
    
    $titulo='Listado de Pedidos por cliente desde '.$fechaini_format.' hasta '.$fechafin_format.' '.$codcli.' '.$nomcli;
    $mensaje='Gerencia de Sistemas';
    $empresa='Diginet c.a';
    
  
    ?>
    <body>
    <div>
    
    <table class="table table-hover table-condensed" id="tablita">
        <thead>
            <tr>
              <th scope="col">Pedido</th>
              <th scope="col">Fecha</th>
              <th scope="col">Status</th>
              <th scope="col">SubTotal</th>
              <th scope="col">TOTAL</th>
              <th scope="col">Accion </th>
            </tr>
        </thead>
    
       
        <tbody>
            <?php 
            $totalp=0;
            $iiva=0;

             while ($datapedido = mysqli_fetch_array($queryped)){
                $totalp=$totalp+$datapedido['subtotal'];  
                $iiva=$iiva+$datapedido['iva_t'];  
            
            ?>
            <tr>
            
              <td><?php echo $datapedido['numped']; ?></td>
              <td><?php echo $datapedido['fecha_ped']; ?></td>
              <td><?php echo $datapedido['status']; ?></td>
              <td><?php echo $datapedido['subtotal']; ?></td>
              <td><?php echo $datapedido['subtotal']+$datapedido['iva_t']; ?></td>
              <td>
              <?php if ($modify)
                    { $_SESSION['numped']=$datapedido['numped']?>
                <a href="consultarpedido.php"><button type="button" name="update" value ="ucliente" id="$datapedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Consultar detalle" ><i class="fa fa-edit"></i></button></a>
                <a href="eliped.php?np=<?= $datapedido['numped'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion6()'><i class="fa fa-trash"></i></button></a>
                <?php } ?>   
            </td>
            </tr>
            <?php 
             }?>
        </tbody>
        <tfoot>
        <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
        </tr>
        </tfoot>
       <!-- <?php  echo "<tr><td colspan='3'>Sub-Total Pedido =>></td><td>" .number_format($totalp, 2, ',', '.')."</td></tr>"; 
             echo "<tr><td colspan='3'>Total IVA (Inc) =>></td><td>" .number_format($totalp+$iiva, 2, ',', '.')."</td></tr>"; 
           ?> -->
    </table>
    </div>
    </body>
    
    
    <script>
      
    var tituloJS = "<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>";
    var mensajeJS = "<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>";   
    var empresaJS = "<?php echo htmlspecialchars($empresa, ENT_QUOTES, 'UTF-8'); ?>"; 
    var nomcliJS = "<?php echo htmlspecialchars($nomcli, ENT_QUOTES, 'UTF-8'); ?>";
    new DataTable('#tablita',{
        responsive:true,
        layout: {
        topStart: {
            buttons: [
            {extend:'copy',title:tituloJS},
            {extend:'excel',title:tituloJS,
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},}, 
            {extend:'pdf', 
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS,messageTop:mensajeJS},'colvis',
            {extend:'print',
                text: 'Imprimir',
                                customize: function ( win ) {
                                    // Crear el encabezado dinámicamente
                                    var companyName = empresaJS; // Puedes obtener esto de una variable PHP o JS
                                    var orderNumber = ''; // Si quieres un número de pedido general, puedes poner "Lista de Pedidos"
                                    var clientName = nomcliJS; // Puedes poner "General"
                                    var currentDate = new Date().toLocaleDateString();

                                    var header = '<div style="text-align: left; margin-bottom: 20px;">' +
                                                 '<h2 style="margin: 0;">' + companyName + '</h2>' +
                                                 '<p style="margin: 5px 0;"><strong>Gerencia de Sistemas:</strong> ' + orderNumber + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Cliente:</strong> ' + clientName + '</p>' +
                                                 '<p style="margin: 5px 0;"><strong>Fecha:</strong> ' + currentDate + '</p>' +
                                                 '</div>';

                                    $(win.document.body).prepend( header );

                                    // Puedes añadir estilos al documento de impresión si lo deseas
                                    $(win.document.body).find('h1').css('text-align', 'center');
                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                },
            exportOptions: {columns: [ 0, 1, 2, 3, 4 ]},// Excluye la columna 5
            footer:true,title:tituloJS}],
        }
    },
    language: {
                url: 'js/es-ES.json',
            },

            columnDefs: [
      {
        targets: [5], // Aplica a las columnas 5
        orderable: false // Desactiva el ordenamiento para estas columnas
      }
    ],
    
         
    footerCallback: function (row, data, start, end, display) {
        let api = this.api();
 
        // Remove the formatting to get integer data for summation
        let intVal = function (i) {
            return typeof i === 'string'
                ? i.replace(/[\$,]/g, '') * 1
                : typeof i === 'number'
                ? i
                : 0;
        };
 
        // Total over all pages
        total = api
            .column(4)
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
        // Total over this page
        pageTotal = api
            .column(3, { page: 'current' })
            .data()
            .reduce((a, b) => intVal(a) + intVal(b), 0);
        
 
        // Update footer
        const numeroFormateadoUS = pageTotal.toLocaleString('en-US');
        api.column(3).footer().innerHTML =
         'SubTotal pg.$ ' + numeroFormateadoUS;  
         const numeroFormat = total.toLocaleString('en-US');
        api.column(4).footer().innerHTML =
            'Total $' + numeroFormat;
                
      }});    
     
    
       
    </script>
    
     
<?php
   }
}
  