<?php
//session_start();
//include 'funciones.php';
//$funciones = new funciones();
include 'tablas.php';
include 'menus.php';
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

  


<div class="row text-center" style="background-color: #cecece">
  <div class="col-md-6"> 
    <strong>Registrar Nuevo Cliente</strong>
  </div>
  <div class="col-md-6"> 
    <strong>Lista de Clientes </strong>
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
                    <label for="name" class="form-label">Cédula (Codigo) Cliente <em>(DIN)</em></label>
                    <input type="number" class="form-control" name ="cedula" id="cedula" required='true' autofocus>
                    <div id="respuesta"> </div>
                </div>

                <div class="col-md-12">
                    <label for="name" class="form-label">Nombre del Cliente</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required='true' autofocus>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="correo" id="correo" required='true'>
                </div>
                <div class="col-md-12 mt-2">
                    <label for="celu" class="form-label">Celular</label>
                    <input type="number" class="form-control" name="celu" id="celu" required='true'>
                </div>

              </div>
                <div class="row justify-content-start text-center mt-5">
                    <div class="col-12">
                    <?php  $permission='Registrar_Nuevo_Cliente'; 
                    if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>  
                        <button  class="btn btn-primary btn-block" name ="btnEnviar" value="Registrar Nuevo Cliente" id="btnEnviar">
                           <i class="zmdi zmdi-spinner zmdi-hc-lg zmdi-hc-spin"></i>
                            Registrar Nuevo Cliente
                        </button>
                        <?php } else {  ?><button  disabled class="btn btn-primary btn-block" name ="btnEnviar" value="Registrar Nuevo Cliente" id="btnEnviar">
                           <i class="zmdi zmdi-spinner zmdi-hc-lg zmdi-hc-spin"></i>
                            Registrar Nuevo Cliente
                        </button><?php }?>
                    </div>
                </div>
          </form>
        </div>  
      <!--fin form -->

         

          <div class="col-sm-7">
              <div class="row" id="listClientes" action='clienteList'>
               <?php 
                 listClientes();?>

              </div>
          </div>



        </div>
      </div>
  </div>
</div>
</div>





<script type="text/javascript">
    $(document).ready(function() {
      //Apenas cargue  La pagina cargara la lista de Clientes.
      //$("#listClientes").load("listClientes.php"); //load es una funcion de Jquery
      
      $(".zmdi-hc-spin").hide(); //Oculto la animacion del boton enviar

      //Efecto Pre-Carga
      $(window).on("load",function() {
          $(".cargando").fadeOut(500);
      });


    //Codigo para limitar la cantidad maxima que tendra dicho Input
    $('input#cedula').keypress(function (event) {
      if (event.which < 48 || event.which > 57 || this.value.length === 5) {
        return false;
      }
    });
    

    //Validar la cantidad maxima en el campo celular
  //  $('input#celular').keypress(function (event) {
  //    if (event.which < 48 || event.which > 57 || this.value.length === 11) {
  //      return false;
 //     }
 //   });


//Validando si existe la Cedula en BD antes de enviar el Form
$("#cedula").on("keyup", function() {
  var cedula = $("#cedula").val(); //CAPTURANDO EL VALOR DE INPUT CON ID CEDULA
  var longitudCedula = $("#cedula").val().length; //CUENTO LONGITUD
$validaced = false;
//Valido la longitud 
  if(longitudCedula >= 3){
    
    var dataString = 'cedula=' + cedula;
    var $validaced=true;
    url = "verificarCedula.php";
      $.ajax({
          url: url,
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


         //Funcion para enviar el formulario de registro.
         $('#btnEnviar').click(function(e){
            e.preventDefault();

          //Muestro el efecto cargando en el boton
          $(".zmdi-hc-spin").show();  

          setTimeout(function() {
            $(".zmdi-hc-spin").hide();
            $("#btnEnviar").attr('disabled',false); //Desabilito el boton enviar
          }, 1000);
          var $incliente=true;
          url = "nuevoCliente.php";
          $.ajax({
              type: "POST",
              url: url,
              data: $("#formCliente").serialize(),
              success: function(datos)
              {
                $("#listClientes").load("Listcli.php"); //Cargo nuevamenta la lista de Clientes, pero ya actualizada.
                $("#formCliente")[0].reset(); //Limpio todos los input de mi formulario
              }
          });
        });


 });
      
</script>

</body>
</html>