<?php
class funclogi{
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
    private function getData1($sqlQuery) {
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

public function checkLogin(){
		if(empty($_SESSION['userid'])) {
			header("Location:login.php");
		}
	}
    public function carga_permiso($mysqli,$usuario){	
    
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

    public function login($email, $password){
		$password = md5($password);
		$sqlQuery = "
			SELECT userid, email, password, name, type, status
			FROM ".$this->userTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData1($sqlQuery);
	}	
    public function checkemail($email){
		
		$sqlQuery = "
			SELECT userid, email, password, name, type, status
			FROM ".$this->userTable." 
			WHERE email='".$email."' ";
        return  $this->getData1($sqlQuery);
	}	
}//clase
    ?>