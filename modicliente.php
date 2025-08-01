<?php 
ob_start();
$id = $_GET['id'];
include('config.php');
//include_once 'funciones.php';
//$funciones = new funciones();
include_once 'menus.php';
// conectar a la base de datos para consulta
$sql = $conn->query("select * from ims_customer where id = $id");

if ($sql)
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
  
<div class="cargando">
    <div class="loader-outter"></div>
    <div class="loader-inner"></div>
</div>


<div class="container mt-5 p-5">


<div class="row text-center" style="background-color: #cecece">
  <div class="col-md-6"> 
    <strong>Editar Datos Cliente</strong>
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
                <input type="hidden" name="id" value="<?=$_GET["id"] ?>" >
                <?php
                 include('modificarcliente.php');
                 while ($datos=$sql->fetch_object()){
               ?>
                <div class="col-md-12 mt-2">
                    <label for="name" class="form-label" >Cédula (Codigo) Cliente <em></em><?= $datos->codcli ?></label>
                    <!-- <input type="number" class="form-control" name="cedula" id="cedula" required='true' autofocus value="<?= $datos->codcli ?>"> -->
                   <div id="respuesta"> </div>
                </div>

                <div class="col-md-12">
                    <label for="name" class="form-label">Nombre del Cliente</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $datos->name ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="correo" id="correo" required='true' value="<?= $datos->address ?>">
                </div>
                <div class="col-md-12 mt-2">
                    <label for="celular" class="form-label">Celular</label>
                    <input type="number" class="form-control" name="celular" id="celular" required='true' value="<?= $datos->mobile ?>">
                </div>

              </div>
                <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block" value="Editar Datos Cliente " name ="btnmodificar" id="btnmodificar">
                           <i class="zmdi zmdi-spinner zmdi-hc-lg zmdi-hc-spin"></i>
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
<?php } else{$mensaje = "NO se puede encontrar la info requerida, consulte a Sistemas";
                  if ($mensaje) {
              ?> <div class="alert alert-danger rounded-0 py-1"><?php echo $mensaje; ?></div>
    <?php } }?>

<script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/popper.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
      //Apenas cargue  La pagina cargara la lista de Clientes.
      $("#listClientes").load("listClientes.php"); //load es una funcion de Jquery
      $(".zmdi-hc-spin").hide(); //Oculto la animacion del boton enviar

      //Efecto Pre-Carga
      $(window).load(function() {
          $(".cargando").fadeOut(500);
      });


    //Codigo para limitar la cantidad maxima que tendra dicho Input
    $('input#cedula').keypress(function (event) {
      if (event.which < 48 || event.which > 57 || this.value.length === 5) {
        return false;
      }
    });
    

    //Validar la cantidad maxima en el campo celular
    $('input#celular').keypress(function (event) {
      if (event.which < 48 || event.which > 57 || this.value.length === 11) {
        return false;
      }
    });


//Validando si existe la Cedula en BD antes de enviar el Form
$("#cedula").on("keyup", function() {
  var cedula = $("#cedula").val(); //CAPTURANDO EL VALOR DE INPUT CON ID CEDULA
  var longitudCedula = $("#cedula").val().length; //CUENTO LONGITUD

//Valido la longitud 
  if(longitudCedula >= 3){
    var dataString = 'cedula=' + cedula;

      $.ajax({
          url: 'verificarCedula.php',
          type: "GET",
          data: dataString,
          dataType: "JSON",

          success: function(datos){

                if( datos.success == 1){

                $("#respuesta").html(datos.message);

                $("input").attr('disabled',true); //Desabilito el input nombre
                $("input#cedula").attr('disabled',false); //Habilitando el input cedula
                $("#btnEnviar").attr('disabled',true); //Desabilito el Botton

                }else{

                $("#respuesta").html(datos.message);

                $("input").attr('disabled',false); //Habilito el input nombre
                $("#btnEnviar").attr('disabled',false); //Habilito el Botton

                    }
                  }
                });
              }
          });


       


 });
      
</script>

</body>
</html>