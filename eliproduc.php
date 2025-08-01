<?php 
ob_start();
$pid = $_GET['pid'];
include('config.php');
//include_once 'funciones.php';
//$funciones = new funciones();
$tienedatos=false;
include_once 'menus.php';
// buscar el producto a ver si tiene movimientos en pedidos
$sql0 =$conn->query("select * from mov_ped WHERE pid=$pid");
$datos1=$sql0->fetch_object();
if ($datos1)
{$tienedatos=true;}
// conectar a la base de datos para consulta
$sql = $conn->query("select * from ims_product as pro INNER JOIN ims_brand as mar ON pro.brandid=mar.id INNER JOIN ims_category as cat ON pro.categoryid=cat.categoryid  where pid = $pid");
$datos=$sql->fetch_object();
if ($datos)
{
?>

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


<div class="container mt-5 p-5">


<div class="row text-center" style="background-color: #cecece">
  <div class="col-md-6"> 
    <strong>Eliminar Datos Productos</strong>
  </div>
  
</div>

<div class="row clearfix">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  <div class="body">
      <div class="row clearfix">

        <!----- formulario --->
        <div class="col-sm-5">
          <form name="formproduc" id="formproduc" action="" method="POST">

            
              <div class="row">
                <input type="hidden" name="pid" value="<?=$_GET["pid"] ?>" >
                <?php
               //  include('eliminarproducto.php');
               
               ?>
                
                <div class="col-md-12">
                    <label for="name" class="form-label">Nombre del Producto <?= $datos->pname ?></label>
                  <!--  <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $datos->pname ?>">-->
                </div>
                <div class="col-md-12">
                <label for="name" class="form-label">Marca: <?= $datos->bname ?></label>   
                </div>
                <div class="col-md-12">
                <label for="name" class="form-label">Categoria: <?= $datos->name ?></label> 
                  
                </div>
                <div class="col-md-12 mt-2">
                    <label for="precio" class="form-label">Precio Base:<?= $datos->base_price ?></label>
                   <!-- <input type="number" class="form-control" name="precio" id="precio" required='true' autofocus value="<?= $datos->base_price ?>"> -->
                </div>
                <div class="col-md-12 mt-2">
                    <label for="modelo" class="form-label">Modelo:<?= $datos->model ?></label>
                   <!-- <input type="text" class="form-control" name="modelo" id="modelo" required='true' autofocus value="<?= $datos->model ?>"> -->
                </div>
                <div class="col-md-12 mt-2">
                    <label for="unidad" class="form-label">Unidad de Medida:<?= $datos->unit ?></label>
                  <!--  <input type="text" class="form-control" name="unidad" id="unidad" autofocus value="<?= $datos->unit ?>"> -->
                </div>
                <div class="col-md-12 mt-2">
                    <label for="cantidad" class="form-label">Cantidad/Unidad:<?= $datos->quantity  ?></label>
                  <!--  <input type="number" class="form-control" name="cantidad" id="cantidad" autofocus value="<?= $datos->quantity  ?>"> -->
                </div>

              </div>
                <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                        <button class="button btn-primary" value="Editar Datos Productos " name ="btnmodificar" id="btnmodificar">Grabar Cambios</button>
                        <a href="crudproductos.php" >  <button type="button"  class="btn btn-md btn btn-danger" name="btncancelar" id="btncancelar">Salir </button>  </a>
                    </div>
                </div>

             
              
          </form>
        </div>  
      <!--fin form -->
   <?php   if (isset($_POST["btnmodificar"])) 
   {
    
      if ($tienedatos)
      { $mensaje = "El PRODUCTO tiene movimientos NO se puede Eliminar,Contacte a Administracion ";
        if ($mensaje) {
    ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
      <?php   }

       }else
      {   
        
        
        //$sql1="select * from ims_customer where id = $id";
        $eliminaproducto = "DELETE from ims_product WHERE pid=$pid";
       
            $resultadoproducto = mysqli_query($conn, $eliminaproducto);	
         if ($resultadoproducto ==1) {
             header("location:crudproductos.php");
         }
    

         }
   } 
}else{header("location:crudproductos.php");}?>
         

          



        </div>
      </div>
  </div>
</div>
</div>


<script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>





  </body>
</html>