<?php 
include 'config.php';
ob_start();
require_once ('funclogi.php');
$funclogi = new funclogi();
//include('inc/header.php');
$loginError = '';
$_SESSION['permissions']=[];
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
	
	$login = $funclogi->login($_POST['email'], $_POST['pwd']); 
	if(!empty($login)) {
		session_start();
		
       // $_SESSION['id_rol'] = $login[0]['id_rol'];
        $_SESSION['loggedin'] = true;
      //cargar los permisos function carga_permisos($_SESSION['id_rol'])
	  $funclogi->carga_permiso($conn,$login[0]['userid']);
	  $_SESSION['userid'] = $login[0]['userid'];
	  $_SESSION['name'] = $login[0]['name'];
	  header("Location:index.php");
	} else {
		$loginError = "Error en email o password!";
	}
}
?>
<style>
html,
body,
body>.container {
    height: 95%;
    width: 100%;
}
body>.container {
	display:flex;
	flex-direction:column;
	align-items:center;
	justify-content:center;
}
#title{
	text-shadow:2px 2px 5px #000;
} 
</style>
<?php //include('inc/container.php');?>

	<h1 class="text-center my-4 py-3 text-light" id="title">Acceso a Clientes</h1>	
	<div class="col-lg-4 col-md-5 col-sm-10 col-xs-12">
		<div class="card rounded-0 shadow">
			<div class="card-header">
				<div class="card-title h3 text-center mb-0 fw-bold">Login</div>
			</div>
			<div class="card-body">
				<div class="container-fluid">
					<form method="post" action="">
						<div class="form-group">
						<?php if ($loginError ) { ?>
							<div class="alert alert-danger rounded-0 py-1"><?php echo $loginError; ?></div>
						<?php } ?>
						</div>
						<div class="mb-3">
							<label for="email" class="control-label">Email</label>
							<input name="email" id="email" type="email" class="form-control rounded-0" placeholder="Email address" autofocus value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" required>
						</div>
						<div class="mb-3">
							<label for="password" class="control-label">Password</label>
							<input type="password" class="form-control rounded-0" id="password" name="pwd" placeholder="Password" required>
						</div>  
						<div class="d-grid">
							<button type="submit" name="login" class="btn btn-primary rounded-0">Login</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>		
<?//php include('inc/footer.php');?>