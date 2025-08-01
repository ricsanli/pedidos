<?php
//define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'root');
//define('DB_PASSWORD', '');
//define('DB_NAME', 'inventario_db'); // Asegúrate que sea el nombre correcto de tu DB

// Intentar conectar a la base de datos
//$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
include 'config.php';
// Verificar la conexión
if ($conn->connect_error) {
    die("ERROR: No se pudo conectar a la base de datos. " . $conn->connect_error);
}else{

echo 'entro';
include 'funciones.php';
include 'tablas.php';
session_start();
$funciones=new funciones();
$usu=1;
$permiso='Incluir_Pedidos';
$_SESSION['permissions'] = [];
$funciones->carga_permisos($conn,$usu);
if (!empty($_SESSION['permissions'] ))
{echo 'lo lleno';}else{echo 'NADA';}
//$query = "SELECT * FROM permisos_roles as pr JOIN ims_user as us ON pr.id_rol = us.id_rol WHERE us.userid =$usuario ";
//$result =mysqli_query($conn, $query);
//if ($result){ 

   // while ($row = $result->fetch_assoc()) {
   //   $_SESSION['permissions'][] = $row['permiso'];
        
  //}}
 
    $var =  in_array($permiso, $_SESSION['permissions']);
    echo $var;
   }