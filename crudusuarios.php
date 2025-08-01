<?php
//session_start();
//include 'funciones.php';
//$funciones = new funciones();
include 'tablas.php';
include 'menus.php';
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
   

    

  <style> 
        table tr th{
            background:rgba(0, 0, 0, .6);
            color: #fff;
        }
        tbody tr{
          font-size: 12px !important;

        }
        h3{
            color:crimson; 
            margin-top: 100px;
        }
        a:hover{
            cursor: pointer;
            color: #333 !important;
        }
        em{
          font-size: 15px;
        }
      </style>
</head>
<body>
  
<div class="cargando">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>





<div class="container mt-2 p-5">

<?php if (isset($_POST['btnEnviar']))
      {
          
        if ($_POST['Password1'] !=$_POST['Password2'] )
        { $mensaje="Las contraseñas no coinciden";

          ?>  <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; 
        ?> </div> <?php
        }else { // validar e incluir usuario
          $login = $funciones->checkemail($_POST['email']); 
          if(!empty($login)) { 
            $email=$_POST['email'];
            $mensaje="Error en email, el email $email  ya existe";
            ?>  <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; 
            ?> </div> <?php
            $_POST['email']=""; }
            
          else{
           $password=md5($_POST['Password1']);
           $email=$_POST['email']; 
           $rol=$_POST['rol'];
           $nombre=$_POST['nombre'];
           $InsertUsuario = "
			     INSERT INTO ims_user(email,password,name, id_rol) 
			     VALUES ('".$email."','".$password."', '".$nombre."', '".$rol."')";
           $resultadouser = mysqli_query($conn, $InsertUsuario);
           }
        }

      } 
    
        ?> 


<div class="row text-center" style="background-color: #cecece">
  <div class="col-md-6"> 
    <strong>Registrar Nuevo Usuario</strong>
  </div>
  <div class="col-md-6"> 
    <strong>Lista de Usuarios </strong>
  </div>
</div>

<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="body">
      <div class="row clearfix">

        <!----- formulario --->
        <div class="col-sm-5">
          <form name="formCliente" id="formCliente" action="" method="POST" >
              <div class="row">
              <div class="col-md-12 mt-2">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" id="email"  type="email" class="form-control rounded-0"autofocus value="<?= isset($_POST['email']) ? $_POST['email'] : '' ?>" name="email" id="email" required='true'>
                </div>
                <div class="col-md-12">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus value="<?= isset($_POST['nombre']) ? $_POST['nombre'] : '' ?>" >
                </div>
                <div class="col-md-12">
                  <label for="password1">Password</label>
                 <input type="password" class="form-control" id="Password1" name="Password1" placeholder="Password" autofocus value="<?= isset($_POST['Password1']) ? $_POST['Password1'] : '' ?>" >
                  
                </div>     
                <div class="col-md-12">
                  <label for="password1">Repite el Password</label>
                 <input type="password" class="form-control" id="Password2"  name="Password2"placeholder="Re entre el Password" autofocus value="<?= isset($_POST['Password1']) ? $_POST['Password1'] : '' ?>">
                 
                </div>      
                <div class="col-md-12">
                      <select name="rol" id="rol" class="form-select rounded-0" required>
                            <option value="">Seleccionar Rol del usuario</option>
                            <?php echo $funciones->rolesDropdownList(); ?>
                      </select>
                      
                </div>
                <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                    <?php  $permission='Registrar_Nuevo_Usuario'; 
                    if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>
                        <button class="btn btn-primary btn-block" name ="btnEnviar" value="Registrar Nuevo Cliente" id="btnEnviar">
                           <i class="zmdi zmdi-spinner zmdi-hc-lg zmdi-hc-spin"></i>
                            Registrar Nuevo Usuario
                        </button>
                        <?php } else {?><button disabled class="btn btn-primary btn-block" name ="btnEnviar" value="Registrar Nuevo Cliente" id="btnEnviar">
                          <i class="zmdi zmdi-spinner zmdi-hc-lg zmdi-hc-spin"></i>
                            Registrar Nuevo Usuario
                        </button><?php }?>
                    </div>
                </div>
          </form>
        
      <!--fin form -->
      

          



        </div>
      </div>
      <div class="col-sm-7">
              <div class="row" id="listClientes" action='clienteList'>
               <?php 
                 listUsuarios();?>

              </div>
          </div>
        </div>  
  </div>
</div>
</div>







   

