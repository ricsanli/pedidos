
<?php
include('config.php');
$email   = $_POST['email'];
echo $email;
//Verificando si existe algun cliente en bd ya con dicha cedula asignada
//Preparamos un arreglo que es el que contendrá toda la información
$jsonData = array();
$selectQuery   = ("SELECT * FROM ims_user WHERE email='".$email."' ");
//$query         = mysqli_query($conn, $selectQuery);
//$totalCliente  = mysqli_num_rows($query);

  //Validamos que la consulta haya retornado información
  $jsonData['message'] = '';

  $result = $conn->query($selectQuery);
  $response = array();

if ($result->num_rows > 0) {
    $response['existe'] = true;
    $jsonData['message'] = 'El email ya existe';
} else {
    $response['existe'] = false;
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);

//Mostrando mi respuesta en formato Json
//header('Content-type: application/json; charset=utf-8');
//echo json_encode( $jsonData );
?>