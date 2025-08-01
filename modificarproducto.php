<?php

if (isset($_POST["btnmodificar"])) {
    
    if ((!empty($_POST['nombre'])) && ($_POST['precio'])>0)
    {   
        $categoria=$_POST['categoria'];
        $nombre=$_POST['nombre'];
        $marca=$_POST['marca'];
        $modelo=$_POST['modelo'];
        $precio=$_POST['precio'];
        $unidad=$_POST['unidad'];
        $cantidad=$_POST['cantidad'];
        
        //$sql1="select * from ims_customer where id = $id";
        $updateproducto = "UPDATE ims_product SET pname='$nombre',categoryid='$categoria',brandid='$marca',model='$modelo',base_price='$precio',unit='$unidad',quantity='$cantidad' WHERE pid=$pid";
       
            $resultadoproducto = mysqli_query($conn, $updateproducto);	
         if ($resultadoproducto ==1) {
             header("location:crudproductos.php");
         }else{ header("location:modiproduc.php?pid=$pid");

            }
    }else{ $mensaje = "El Precio debe ser mayor a cero, vuelva a intentarlo";
        if ($mensaje) {
    ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
      <?php   }

         }
   }

?>