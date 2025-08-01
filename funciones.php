<?php
class funciones{
    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = '';
    private $database  = 'inventario_db';   
	private $userTable = 'ims_user';	
    private $customerTable = 'ims_customer';
	private $categoryTable = 'ims_category';
	private $brandTable = 'ims_brand';
	private $productTable = 'ims_product';
	private $supplierTable = 'ims_supplier';
	private $purchaseTable = 'ims_purchase';
	private $orderTable = 'ims_order';
    private $pedidos = 'pedido';
    private $movped = 'mov_ped';
    private $numeros = 'numeros';
    private $roles = 'roles';
    private $permisos_roles = 'permisos_roles';


    private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }

 
    

    public function productDropdownList(){	
      $sqlQuery = "SELECT * FROM ".$this->productTable." ORDER BY pid ASC";
      $result = mysqli_query($this->dbConnect, $sqlQuery);
      $dropdownHTML = '';
      while( $product = mysqli_fetch_assoc($result) ) {	
        $dropdownHTML .= '<option value="'.$product["pid"].'">'.$product["pid"].''."  ".' '.$product["pname"].'   '.$product["base_price"].'</option>';
      }
      return $dropdownHTML;
    }


	
	public function valcli($vcliente){
		
		$sqlQuery = "
			SELECT *
			FROM ".$this->customerTable." 
			WHERE codcli='".$vcliente."'";
											
        return  $this->getData($sqlQuery);

		
		
		//echo json_encode($row);
	}

	public function existecli($vcliente, $existe){
		$existe = false;
    $sqlQuery = "
			SELECT *
			FROM ".$this->customerTable." 
			WHERE codcli='".$vcliente."'";
			$result = mysqli_query($this->dbConnect, $sqlQuery);
		  if(!$result){
			   //die('Error in query: '. mysqli_error());
	      	}
		    $data= array();
	        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
		  	 $data[]=$row;            
		     }
      if (!empty($data))	{
				$existe = true;

			}							
        return  $existe;

		
		
		//echo json_encode($row);
	}
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function login($email, $password){
		$password = md5($password);
		$sqlQuery = "
			SELECT userid, email, password, name, type, status
			FROM ".$this->userTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	
  public function checkemail($email){
		
		$sqlQuery = "
			SELECT userid, email, password, name, type, status
			FROM ".$this->userTable." 
			WHERE email='".$email."' ";
        return  $this->getData($sqlQuery);
	}	
	public function checkLogin(){
		if(empty($_SESSION['userid'])) {
			header("Location:login.php");
		}
	}
	public function getCustomer(){
		$sqlQuery = "
			SELECT * FROM ".$this->customerTable." 
			WHERE id = '".$_POST["userid"]."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($row);
	}
	
	public function getCustomerList(){		
		$sqlQuery = "SELECT * FROM ".$this->customerTable." ";
		if(!empty($_POST["search"]["value"])){
			$sqlQuery .= '(id LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= '(name LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR address LIKE "%'.$_POST["search"]["value"].'%" ';
			$sqlQuery .= 'OR mobile LIKE "%'.$_POST["search"]["value"].'%") ';
			$sqlQuery .= 'OR balance LIKE "%'.$_POST["search"]["value"].'%") ';
		}
		if(!empty($_POST["order"])){
			$sqlQuery .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}
		if($_POST["length"] != -1){
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}	
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$numRows = mysqli_num_rows($result);
		$customerData = array();	
		while( $customer = mysqli_fetch_assoc($result) ) {		
			$customerRows = array();
			$customerRows[] = $customer['id'];
			$customerRows[] = $customer['name'];
			$customerRows[] = $customer['address'];			
			$customerRows[] = $customer['mobile'];	
			$customerRows[] = number_format($customer['balance'],2);	
			$customerRows[] = '<button type="button" name="update" id="'.$customer["id"].'" class="btn btn-primary btn-sm rounded-0 update" title="update"><i class="fa fa-edit"></i></button><button type="button" name="delete" id="'.$customer["id"].'" class="btn btn-danger btn-sm rounded-0 delete" ><i class="fa fa-trash"></button>';
			$customerRows[] = '';
			$customerData[] = $customerRows;
		}
		$output = array(
			"draw"				=>	intval($_POST["draw"]),
			"recordsTotal"  	=>  $numRows,
			"recordsFiltered" 	=> 	$numRows,
			"data"    			=> 	$customerData
		);
		echo json_encode($output);
	}

	public function saveCustomer() {		
		$sqlInsert = "
			INSERT INTO ".$this->customerTable."(codcli,name, address, mobile, balance) 
			VALUES ('".$_POST['vcliente']."','".$_POST['cname']."', '".$_POST['address']."', '".$_POST['mobile']."', '".$_POST['balance']."')";	
			mysqli_query($this->dbConnect, $sqlInsert);	
		echo 'New Customer Added';
	}			
	public function updateCustomer() {
		if($_POST['userid']) {	
			$sqlInsert = "
				UPDATE ".$this->customerTable." 
				SET name = '".$_POST['cname']."', address= '".$_POST['address']."', mobile = '".$_POST['mobile']."', balance = '".$_POST['balance']."' 
				WHERE id = '".$_POST['userid']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
			echo 'Customer Edited';
		}	
	}	
	public function deleteCustomer(){
		$sqlQuery = "
			DELETE FROM ".$this->customerTable." 
			WHERE id = '".$_POST['userid']."'";		
		mysqli_query($this->dbConnect, $sqlQuery);		
	}
	
// Listado de clientes

public function listClientes(){ 
?>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/themes/alertify.css">
<link rel="stylesheet" href="css/themes/bootstrap.css">
<script src="js/jquery-3.7.1.js"> </script>
<script src="js/popper.min.js"> </script>
<script src="js/dataTables.js"> </script>
<!--<script src="js/dataTables.bootstrap.min.js"> </script> -->
<!--<script src="js/dataTables.bootstrap5.js"> </script> -->
<script> src="js/alertify.js" </script>

  
<?php
include('config.php');

$sqlCliente   = ("SELECT * FROM ims_customer ORDER BY id DESC ");
$queryCliente = mysqli_query($conn, $sqlCliente);
$cantidad     = mysqli_num_rows($queryCliente);
?>
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />

<!--<div class="col-md-12 p-2"> -->
<!--<div class="table-responsive"> -->
    <table id = "tablacli" class="table table-hover table-condensed" >
        <thead>
          <tr>
            <th scope="col">Cédula </th>
            <th scope="col">Nombre</th>
            <th scope="col">Direccion</th>
            <th scope="col">Celular</th>
            <th scope="col">Accion</th>
          </tr>
          </tr>
        </thead>
        <tbody>
          <?php
              
              while ($dataCliente = mysqli_fetch_array($queryCliente)) {
                           
              
               
                ?>
          <tr>
            <td><?php echo $dataCliente['codcli']; ?></td>
            <td><?php echo $dataCliente['name']; ?></td>
            <td><?php echo $dataCliente['address']; ?></td>
            <td><?php echo $dataCliente['mobile']; ?></td>
            <td>
              <a href="modicliente.php?id=<?= $dataCliente['id'] ?>"><button type="button" name="update" value ="ucliente" id="$dataCliente['id']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= 'return modicliente()'><i class="fa fa-edit"></i></button></a>
              <a href="elicliente.php?id=<?= $dataCliente['id'] ?>"> <button type="button" name="delete" id="$dataCliente['id']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion()'><i class="fa fa-trash"></i></button></a>
            </td>
            
          </tr>
        </tbody>
        <?php } ?>

    </table>
<!--</div> -->
<!--</div> --> 
<script type="text/Javascript">
new DataTable('#tablacli', {
        
        language: {
            url: 'js/es-ES.json',
        },
    });

/* codigo para mostrar mensaje de confirmacion antes de que se envien los datos */
    //function confirmacion() {
    //    var respuesta = confirm("¿deseas eliminar esta informacion?");
    //    if (respuesta == true) {
    //        return true;
    //    } else {
    //        return false;
    //    }
    //}
</script>
<?php
}
// fin listado de clientes
//Funcion verificar cedula, codigo cliente
public function verificarCedula($cedula) { 
//include('config.php');
//$cedula    = $_REQUEST['cedula'];

//Verificando si existe algun cliente en bd ya con dicha cedula asignada
//Preparamos un arreglo que es el que contendrá toda la información
$jsonData = array();
$selectQuery   = ("SELECT codcli FROM ims_customer WHERE codcli='".$cedula."' ");
$query         = mysqli_query($conn, $selectQuery);
$totalCliente  = mysqli_num_rows($query);

  //Validamos que la consulta haya retornado información
  if( $totalCliente <= 0 ){
    $jsonData['success'] = 0;
   // $jsonData['message'] = 'No existe Cédula ' .$cedula;
    $jsonData['message'] = '';
} else{
    //Si hay datos entonces retornas algo
    $jsonData['success'] = 1;
    $jsonData['message'] = '<p style="color:red;">Ya existe El codigo <strong>(' .$cedula.')<strong></p>';
  }

//Mostrando mi respuesta en formato Json
header('Content-type: application/json; charset=utf-8');
echo json_encode( $jsonData );
}
// fin verificar cedula, codigo cliente

//funcion nuevo cliente
public function nuevoCliente(){
	
$jsonData = array();
require("config.php");
$nombre = ucwords($_REQUEST['nombre']); //ucwords para convertir la 1 letra mayuscula
$cedula        = $_REQUEST['cedula'];
$correo        = $_REQUEST['correo']; 
$celular       = $_REQUEST['celular'];


//$InsertCliente = "INSERT INTO ims_customer(
 //     name,
 //     codcli,
 //     address,
 //     mobile
 //     )
 //   VALUES (
 //     '" .$cedula. "',
 //     '". $nombre."',
 //     '" .$correo. "',
 //     '" .$celular. "'
 // )";

  $InsertCliente = "
			INSERT INTO ims_customer(codcli,name, address, mobile) 
			VALUES ('".$cedula."','".$nombre."', '".$correo."', '".$celular."')";	
    
  if ((!empty($cedula))  && (!empty($nombre)) && (!empty($correo) ) && ((!empty($celular))))
       {  $resultadoCliente = mysqli_query($con, $InsertCliente);}
       else { $jsonData['message'] = '<p style="color:red;">Rellene los Datos  </p>';
             echo json_encode( $jsonData );}

} 

//fin funcion nuevo cliente

// funcion validar cliente
public function validaCliente($cedula){


//Verificando si existe algun cliente en bd ya con dicha cedula asignada
//Preparamos un arreglo que es el que contendrá toda la información
$jsonData = array();
$selectQuery   = ("SELECT codcli FROM ims_customer WHERE codcli='".$cedula."' ");
$query         = mysqli_query($con, $selectQuery);
$totalCliente  = mysqli_num_rows($query);

  //Validamos que la consulta haya retornado información
  if( $totalCliente <= 0 ){
    $jsonData['success'] = 1;
   // $jsonData['message'] = 'No existe Cédula ' .$cedula;
    $jsonData['message'] = '<p style="color:red;">NO existe El codigo <strong>(' .$cedula.')<strong></p>';
} else{
    //Si hay datos entonces retornas algo
    $jsonData['success'] = 0;
    $jsonData['message'] = '';
  }

//Mostrando mi respuesta en formato Json
header('Content-type: application/json; charset=utf-8');
echo json_encode( $jsonData );
}
// fin funcion validar cliente
public function modipedido($numpedido){

include('config.php');
//include('inc/consec.php');
// conectar a la base de datos para consulta
$pedido = $numpedido;
$sql = $con->query("select * from pedido where numped = $pedido");
$datos2=$sql->fetch_object();
$ccliente = $datos2->codcli;
$sql2 = $con->query("select * from ims_customer where codcli = $ccliente");
$datos3=$sql2->fetch_object();
$ncliente = $datos3->name;
$sql = $con->query("select * from pedido where numped = $pedido");

?>
<script type="text/javascript">
  function confirmacion3() {
  var respuesta = confirm("¿deseas incluir pedidos a este cliente ?");
  if (respuesta == true) {
      return true;
  } else {
      return false;
  }
}

</script>
  </body>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="shortcut icon" href="img/logo-mywebsite-urian-viera.svg"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="css/cargando.css">
  <link rel="stylesheet" type="text/css" href="css/maquinawrite.css">
  <style> 
  </style>

<div class="container mt-5 p-5">
    <div class="row text-center" style="background-color: #cecece">
       <div class="col-md-6"> 
          <strong>Registrar Pedido</strong>
      </div>
      <div class="col-md-6"> 
          <strong>Pedido</strong>
       </div>
    </div>

  <div class="row clearfix">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <div class="body">
        <div class="row clearfix">

           <!----- formulario --->
             <div class="col-sm-5">
                    <form name="formCliente" id="formCliente" action="" method="POST">
                            <div class="row">
                              <div class="col-md-12 mt-2">
                                <label for="name" class="form-label">Pedido No. <?=$pedido ?></label>
                              
                                <div id="respuesta"> </div>
                              </div>
                               <?php while ($datos=$sql->fetch_object()){ ?> 
                             <div class="col-md-12 mt-2">
                               <label for="name" class="form-label">Cédula (Codigo) Cliente <em>(DIN)</em></label>
                               <input type="number"   class="form-control" name ="cedula" id="cedula" required='true' value="<?= $datos->codcli ?>" autofocus>                              <div id="respuesta"> </div>
                             </div>
                              <div class="col-md-12">
                               <label for="name" class="form-label">Nombre del Cliente <?= $ncliente ?></label>
                                 <!--   <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus> -->
                              </div>
                             <div class="col-md-12">
                              <label for="name" class="form-label">Fecha </label>
                              <input type="date" class="form-control" name="fechap" id="fechap" required='true' default= "date()" value="<?= $datos->fecha_ped ?>"> 
                             </div>
                         
          
                            </div>
                              <div class="row justify-content-start text-center mt-5">
                                 <div class="col-12">
                                      <button  class="btn btn-primary btn-block" name ="btnEnviar" value="Registrar Nuevo Cliente" id="btnEnviar" onclick= 'return confirmacion3()'>
                                       <i class=""></i>
                                        Registrar Nuevo pedido
                                      </button>
							   </div>
                               </div>
                            </form>  
        
                       <?php }
                       $mensaje = "";
       if (isset($_POST["btnEnviar"])){ 
             $cedula = $_POST['cedula'];
             $selectQuery   = ("SELECT codcli FROM ims_customer WHERE codcli='".$cedula."' ");
             $query         = mysqli_query($con, $selectQuery);
             $totalCliente  = mysqli_num_rows($query);
             if ($totalCliente <= 0){
               $jsonData['success'] = 1;
               $jsonData['message'] = '<p style="color:red;">El codigo ingresado NO Existe, intente de nuevo<strong>(' .$cedula.')<strong></p>';
               //$mensaje = " El cliente'.$cedula.' No esta registrado en la Base de datos";
               echo '<p style="color:red;">El codigo ingresado NO Existe,'.$cedula.'</p>';
             } 
              else{ if (!empty($_POST['cedula'])) {
                echo '<p style="color:red;">Grabando,'.$cedula.'</p>';
                     // Grabar pedido
                     $estado= "I";
                     $fech_p =$_POST['fechap']; 
                     $pedido = npedido($pedido);
                     $Insertpedido = "
                     INSERT INTO pedido(codcli,fecha_ped, numped, status) 
                     VALUES ('".$cedula."','".$fech_p."', '".$pedido."', '".$estado."')";
                     echo '<p style="color:red;">Insertando ...,'.$cedula. ''.$pedido.'</p>';
                     $resultadoped = mysqli_query($con, $Insertpedido);	
                     if(!$resultadoped){
                     
                      die('Error in query: '. mysqli_error());
                       }
                        
                           
                          }}



                   // include('mostrarpedido.php');
                   // header("location:mostrarpedido.php");
                    // grabar el movimiento y mostrarlo en ñla parte derecha
                   
                         }       
        
  

 ?>
        </div>  
        </div>  
        </div>  
        </div>  
 
		</div>  	<!--fin form -->
		</div>  
		</div>  
		</div>  
		</div>  					
<?php
}// fin funcion

// lista de movimientos de pedido
public function listmovped($nped){ 
  ?><body>
<script src="js/jquery-3.7.1.js"> </script>
    <script src="js/popper.min.js"> </script>
    <script src="js/dataTables.js"> </script>
    <script src="js/bootstrap.bundle.min.js"> </script>
    <script src="js/bootstrap.min.js"> </script>
<link rel="stylesheet" href="css/dataTables.dataTables.css">
<link rel="stylesheet" href="css/bootstrap.min.css">

 <script type="text/javascript">
  new DataTable('#tablita', {
        
        language: {
            url: 'js/es-ES.json',
        },
        paging: false,
        scrollCollapse: true,
        scrollY: '200px'
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
    </body>
  <?php
  include('config.php');
  
  //$sqlmovped  = ("SELECT * FROM mov_ped where numped = $nped");
  $sqlmovped="select * from mov_ped as mp INNER JOIN ims_product as prod ON mp.pid=prod.pid
      where mp.numped='.$nped.'";
  $querymovped = mysqli_query($conn, $sqlmovped);
  $cantidad     = mysqli_num_rows($querymovped);
  ?>
  <link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
  
  <div class="col-md-12 p-3">
  <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" id="tablita" >          
    <thead>
            <tr>
              <th scope="col">Pedido <span style="font-size:12px;"></span></th>
              <th scope="col">Producto</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">Total</th>
              <th scope="col">Accion </th>
            </tr>
            </tr>
          </thead>
          <tbody>
            <?php $totalp=0;
            $iiva=0;
                
                while ($datampedido = mysqli_fetch_array($querymovped)) {
                      $totalp=$totalp+$datampedido['total'];  
                      $iiva=$iiva+$datampedido['iva_tax'];  
                
                 
                  ?>
            <tr>
              <td><?php echo $datampedido['numped']; ?></td>
              <td><?php echo $datampedido['pname']; ?></td>
              <td><?php echo $datampedido['cantidad']; ?></td>
              <td><?php echo $datampedido['precio']; ?></td>
              <td><?php echo $datampedido['total']; ?></td>
              <td>
                <a href="modimovped.php?np=<?= $datampedido['numped'] ?>&idprod=<?=$datampedido['pid'] ?>"><button type="button" name="update" value ="ucliente" id="$datampedido['numped']" class="btn btn-primary btn-sm rounded-0 update" title="Editar"  onclick= 'return modimovped()'><i class="fa fa-edit"></i></button></a>
                <a href="elimovped.php?np=<?= $datampedido['numped'] ?>&idprod=<?=$datampedido['pid'] ?>"> <button type="button" name="delete" id="$datampedido['numped']" class="btn btn-danger btn-sm rounded-0 delete" title="Borrar" onclick= 'return confirmacion3()'><i class="fa fa-trash"></i></button></a>
              </td>
              
            </tr>
            
          </tbody>
          <?php } echo "<tr><td colspan='3'>Sub-Total Pedido =>></td><td>" .number_format($totalp, 2, ',', '.')."</td></tr>"; 
             echo "<tr><td colspan='3'>Total IVA (Inc) =>></td><td>" .number_format($totalp+$iiva, 2, ',', '.')."</td></tr>"; 
           ?> 
  
      </table>
  </div>
  </div> <?php
  }

// fin lista de movimientos de pedido

public function customerDropdownList(){	
  $sqlQuery = "SELECT * FROM ".$this->customerTable." ORDER BY name ASC";
  $result = mysqli_query($this->dbConnect, $sqlQuery);
  $dropdownHTML = '';
  while( $customer = mysqli_fetch_assoc($result) ) {	
    $dropdownHTML .= '<option value="'.$customer["codcli"].'">'.$customer["codcli"].''." ".' '.$customer["name"].'</option>';
  }
  return $dropdownHTML;
}

public function carga_permisos($mysqli,$usuario){	
    
    $_SESSION['permissions'] = [];
    
    //$query = "SELECT * FROM permisos_roles as pr JOIN ims_user as us ON pr.id_rol = us.id_rol WHERE us.userid =? ";
    //$result =mysqli_query($mysqli,$query);
    $stmt = $mysqli->prepare("SELECT pr.permiso 
                              FROM permisos_roles pr 
                              JOIN ims_user u ON pr.id_rol = u.id_rol 
                              WHERE u.userid = ?"); 
    $stmt->bind_param("i", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result){ 

    while ($row = $result->fetch_assoc()) {
        $_SESSION['permissions'][] = $row['permiso'];
        
    }}
    $stmt->close();
    //return $_SESSION['permissions'];
}
public function tienePermiso($permission,$arreglo) {
  //isset($_SESSION['permissions']) &&
 
 if (in_array($permission, $arreglo))
 { return true;}else{return false;}
 
}


public function listmp($numped){
?>
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
include 'config.php';


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

<?php
             
//ultima llave
}   
public function rolesDropdownList(){	
  $sqlQuery = "SELECT * FROM ".$this->roles." ORDER BY id ASC";
  $result = mysqli_query($this->dbConnect, $sqlQuery);
  $dropdownHTML = '';
  while( $rol = mysqli_fetch_assoc($result) ) {	
    $dropdownHTML .= '<option value="'.$rol["id"].'">'.$rol["nombre_rol"].''."  ".'   </option>';
  }
  return $dropdownHTML;
}
public function catDropdownList(){	
  $sqlQuery = "SELECT * FROM ".$this->categoryTable." ORDER BY categoryid ASC";
  $result = mysqli_query($this->dbConnect, $sqlQuery);
  $dropdownHTML = '';
  while( $cate = mysqli_fetch_assoc($result) ) {	
    $dropdownHTML .= '<option value="'.$cate["categoryid"].'">'.$cate["name"].''."  ".'   </option>';
  }
  return $dropdownHTML;
}
public function marcaDropdownList(){	
  $sqlQuery = "SELECT * FROM ".$this->brandTable." ORDER BY id ASC";
  $result = mysqli_query($this->dbConnect, $sqlQuery);
  $dropdownHTML = '';
  while( $marc = mysqli_fetch_assoc($result) ) {	
    $dropdownHTML .= '<option value="'.$marc["id"].'">'.$marc["bname"].''." ".'   </option>';
  }
  return $dropdownHTML;
}
}