<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="css/dataTables.bootstrap5.css">
<link rel="stylesheet" href="css/themes/alertify.css">
<link rel="stylesheet" href="css/themes/bootstrap.css">


<script src="js/jquery-3.7.1.js"> </script>
<script src="js/popper.min.js"> </script>
<script src="js/bootstrap.min.js"> </script>
<script src="js/jquery.dataTables.min.js"> </script>
<script src="js/dataTables.bootstrap.min.js"> </script>
<script src="js/dataTables.js"> </script>
<script src="js/dataTables.bootstrap5.js"> </script>
<script> src="js/alertify.js" </script>
</head>
</html>

<div class= "container mt-5">
    <div class="row">
      <div class="col-md-6">
       
       <h2 class="mb-4">Listado de Pedidos por Cliente</h2>

      <div id="tablaData">

      </div>





      </div>
   </div>
</div>

<script type="text/javascript" >
    $(document).ready(function(){
        $('#tablaData').load('tabla.php')
    })
</script>