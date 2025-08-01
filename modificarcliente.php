<?php

if (!empty($_POST["btnmodificar"])) {
    if ((!empty($_POST['nombre'])) && (!empty($_POST['correo']) ) && (!empty($_POST['celular'])))
    {   $id= $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $celular = $_POST['celular'];
        //$sql1="select * from ims_customer where id = $id";
        $updateCliente = "
			update ims_customer set name='$nombre', address='$correo', mobile = $celular where id=$id";
            $resultadoCliente = mysqli_query($conn, $updateCliente);	
         if ($resultadoCliente ==1) {
             header("location:crudclientes.php");
         }else{

            }
    }

}

?>