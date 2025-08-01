<?php 
ob_start();
$pid = $_GET['pid'];
include('config.php');
//include_once 'funciones.php';
//$funciones = new funciones();
include_once 'menus.php';
// conectar a la base de datos para consulta
$sql = $conn->query("select * from ims_product where pid = $pid");
if ($sql){
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
    <strong>Editar Datos Productos</strong>
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
                 include('modificarproducto.php');
                 while ($datos=$sql->fetch_object()){
               ?>
                
                <div class="col-md-12">
                    <label for="name" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $datos->pname ?>">
                </div>
                <div class="col-md-12">
                      <select name="marca" id="marca" class="form-select rounded-0" required autofocus value="<?=$datos->brandid  ?>">
                            <option value="">Seleccionar Marca</option>
                            <?php echo $funciones->marcaDropdownList(); ?>
                      </select>
                </div>
                <div class="col-md-12">
                
                  <select name="categoria" id="categoria" class="form-select rounded-0" required autofocus value="<?=$datos->categoryid  ?>">
                      <option value="">Seleccionar Categoria</option>
                      <?php echo $funciones->catDropdownList(); ?>
                  </select>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="precio" class="form-label">Precio Base</label>
                    <input type="number" class="form-control" name="precio" id="precio" required='true' autofocus value="<?= $datos->base_price ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" class="form-control" name="modelo" id="modelo" required='true' autofocus value="<?= $datos->model ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="unidad" class="form-label">Unidad de Medida</label>
                    <input type="text" class="form-control" name="unidad" id="unidad" autofocus value="<?= $datos->unit ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="cantidad" class="form-label">Cantidad/Unidad</label>
                    <input type="number" class="form-control" name="cantidad" id="cantidad" autofocus value="<?= $datos->quantity  ?>">
                </div>

              </div>
                <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block" value="Editar Datos Productos " name ="btnmodificar" id="btnmodificar">
                           
                            Grabar Cambios
                        </button>
                    </div>
                </div>

             <?php  
                 }
            ?>
              
          </form>
        </div>  
      <!--fin form -->

         

          



        </div>
      </div>
  </div>
</div>
</div>
<?php } else{ header("location:crudproductos.php");}
?>


<script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>




<script>
    const formulario = document.getElementById('formproduc');
    //const cantidadInput = document.getElementById('cantidad');
    const precioInput = document.getElementById('precio');
   // const subtotalInput = document.getElementById('subtotal');

    function calcularSubtotal() {
     // const cantidad = parseFloat(cantidadInput.value);
      const precio = parseFloat(precioInput.value);
      if (precio > 0) {
        
        }
       else {
        alert('El número debe ser mayor que cero.');
      }
    }

    // Escuchar cambios en los campos de cantidad y precio
    //cantidadInput.addEventListener('input', calcularSubtotal);
    precioInput.addEventListener('input', calcularSubtotal);

    // Llamar a la función al cargar la página para mostrar el valor inicial
    //calcularSubtotal();
  </script>
  </body>
</html>