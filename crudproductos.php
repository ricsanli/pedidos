<?php
//session_start();
//include 'funciones.php';
//$funciones = new funciones();
include 'tablas.php';
include 'menus.php';
include 'config.php';
$categoria=0;
$nombre='';
$marca=0;
$model='';
$precio=0;
$unidad='';
$cantidad=0;
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
   
   
      <!-- <script src="js/jquery-3.7.1.js"></script>
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
       <script src="js/buttons.colVis.min.js"></script> -->
   

    

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
               $categoria=$_POST['categoria'];
               $nombre=$_POST['nombre'];
               $marca=$_POST['marca'];
               $model=$_POST['modelo'];
               $precio=$_POST['precio'];
               $unidad=$_POST['unidad'];
               $cantidad=$_POST['cantidad'];
        if ((!empty($_POST['nombre'])) && (!empty($_POST['marca']))&&(!empty($_POST['categoria'])))                     
          {
            if ($_POST['precio']>0)
               {
               
               $Insertproduc = "
			         INSERT INTO ims_product(categoryid,brandid,pname,model,base_price,unit,quantity) 
			         VALUES ('".$categoria."','".$marca."','".$nombre."','".$model."','".$precio."','".$unidad."','".$cantidad."')";
               $resultadomar = mysqli_query($conn, $Insertproduc);
              }else{
                $mensaje = "El Precio debe ser mayor a cero, vuelva a intentarlo";
                  if ($mensaje) {
              ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>

                  <?php 
                   } 

              }
          }
          
          
      }
       

      
    
        ?> 

  


<div class="row text-center" style="background-color: #cecece">
  <div class="col-md-6"> 
    <strong>Registrar Nuevo Producto</strong>
  </div>
  <div class="col-md-6"> 
    <strong>Lista de Productos </strong>
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
                
                <div class="col-md-12">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus value="<?= isset($_POST['nombre']) ? $_POST['nombre'] : '' ?>">
                </div>
                <div class="col-md-12">
                
                      <select name="marca" id="marca" class="form-select rounded-0" required autofocus value="<?= isset($_POST['marca']) ? $_POST['marca'] : '' ?>">
                            <option value="">Seleccionar Marca</option>
                            <?php echo $funciones->marcaDropdownList(); ?>
                      </select>
                </div>
                <div class="col-md-12">
                
                <select name="categoria" id="categoria" class="form-select rounded-0" required>
                      <option value="">Seleccionar Categoria</option>
                      <?php echo $funciones->catDropdownList(); ?>
                </select>
          </div>
                <div class="col-md-12 mt-2">
                    <label for="precio" class="form-label">Precio Base</label>
                    <input type="number" class="form-control" name="precio" id="precio" required='true' autofocus value="<?= isset($_POST['precio']) ? $_POST['precio'] : '' ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="modelo" class="form-label">Modelo</label>
                    <input type="text" class="form-control" name="modelo" id="modelo" required='true' autofocus value="<?= isset($_POST['modelo']) ? $_POST['modelo'] : '' ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="unidad" class="form-label">Unidad de Medida</label>
                    <input type="text" class="form-control" name="unidad" id="unidad" autofocus value="<?= isset($_POST['unidad']) ? $_POST['unidad'] : '' ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="cantidad" class="form-label">Cantidad/Unidad</label>
                    <input type="number" class="form-control" name="cantidad" id="cantidad" autofocus value="<?= isset($_POST['cantidad']) ? $_POST['cantidad'] : '' ?>">
                </div>

              </div>
                <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                    <?php  $permission='Registrar_Nuevo_Cliente'; 
                    if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>  
                        <button  class="btn btn-primary btn-block" name ="btnEnviar" value="Registrar Nuevo Producto" id="btnEnviar">
                           <i class="zmdi zmdi-spinner zmdi-hc-lg zmdi-hc-spin"></i>
                            Registrar Nuevo Producto
                        </button>
                        <?php } else {  ?><button  disabled class="btn btn-primary btn-block" name ="btnEnviar" value="Registrar Nuevo Producto" id="btnEnviar">
                           <i class="zmdi zmdi-spinner zmdi-hc-lg zmdi-hc-spin"></i>
                            Registrar Nuevo Producto
                        </button><?php }?>
                    </div>
                </div>
          </form>
          <?php 
        $_POST['categoria']=$categoria;
        $_POST['nombre']=$nombre;
        $_POST['marca']=$marca;
        $_POST['modelo']=$model;
        $_POST['precio']=$precio;
        $_POST['unidad']=$unidad;
        $_POST['cantidad']=$cantidad;?>
        </div>  
      <!--fin form -->

         

          <div class="col-sm-7">
              <div class="row" id="listpro" action='proList'>
               <?php 
                 listProductos();?>

              </div>
          </div>



        </div>
      </div>
  </div>
</div>
</div>







</body>
</html>
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