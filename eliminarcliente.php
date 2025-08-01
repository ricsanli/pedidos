<?php
ob_start();
$mensaje = "";
if (!empty($_POST["btneliminar"])) {
       
        // preguntar si esta seguro e eliminar Busacar en BS si no tiene movimientos de pedido 
        //$sql1="select * from ims_customer where id = $id";
        // buscamos info  acerca de pedidos
                $buscarcliente ="
                select * from ims_customer where id =$id";
                $result = mysqli_query($conn, $buscarcliente);
                if(!$result){
                    die('Error in query: '. mysqli_error($conn));
                }
                $data= array();
		        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			    $data[]=$row;}
                $codigocliente = $data[0]['codcli'];
                $buscarpedido ="
                   select * from pedido where codcli = $codigocliente";
                $resultado = mysqli_query($conn, $buscarpedido); 
                $tienepedido = mysqli_num_rows($resultado);
                if ($tienepedido>=1){
                  
                   $mensaje = " El cliente posee pedidos activos, no se puede eliminar ";
                                     
                }   else {
                        $eliminarCliente = "
		             	delete from ims_customer  where id=$id";
                        $resultadoCliente = mysqli_query($conn, $eliminarCliente);	
        }
        if ($mensaje ) { ?>
            <div class="alert alert-danger rounded-0 py-1"><?php print($mensaje); ?>
            <a href="crudclientes.php" >  <button type="button"  class="btn btn-md btn btn-danger" name="btncancelar" id="btncancelar">Salir </button>  </a></div>
            <?php }
               
        //header("location:crudclientes.php");

            
         
}?>
           
