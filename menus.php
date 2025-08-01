<?php 
ob_start();
if (session_status() == PHP_SESSION_ACTIVE)
{}else{
session_start();}
 include 'funciones.php';
 $funciones = new funciones();
  ?>
<nav class="navbar navbar-dark bg-primary bg-gradient navbar-expand-lg navbar-expand-md my-3">
<div class="container-fluid">
 
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
        
          <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Pedidos </a> 
             
          
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
          <?php  $permission='Incluir_Pedidos';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>   
             <li><a class="dropdown-item" href="crudpedidos.php">Incluir</a></li><?php } ?>
             <?php  $permission='Pedidos_Producto';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>  
            <li><a class="dropdown-item" href="listapp.php">PedidosxProducto</li><?php } ?></a></li>
            <?php  $permission='Lista_Pedidos';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?> 
            <li><a class="dropdown-item" href="listapedidos2.php">Lista Pedidos</a></li><?php } ?>
            <?php  $permission='Pedidos_Cliente';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?> 
            <li><a class="dropdown-item" href="listapedidos.php">PedidosxCliente</a></li><?php } ?>
			      <?php  $permission='Cliente_Pedido';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?> 
            <li><a class="dropdown-item" href="listapedidosc.php">Cliente/Pedido</a></li><?php } ?>
            <?php  $permission='Aprobar_Pedidos';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>
            <li><a class="dropdown-item" href="estadoped.php">Aprobar Pedidos</a></li><?php } ?>
            <?php  $permission='Despachar_Pedidos';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>
            <li><a class="dropdown-item" href="pedidos_despa.php">Despachar Pedido</a></li><?php } ?>
			      <?php  $permission='Generar_Factura';
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>
            <li><a class="dropdown-item" href="#">Generar Factura</a></li><?php } ?>
          </ul>
        </li>
        
      </ul>
   
    <a class="navbar-brand" href="index.php">Inicio</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
	<a class="navbar-brand" href="#">Compras</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
	<a class="navbar-brand" href="#">Inventario</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    
    <a class="navbar-brand" href="#">Exportacion</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="#">Importacion</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ArchivosMaestros
          </a>
          <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
          <?php  $permission='Clientes'; 
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?>  
            <li><a class="dropdown-item" href="crudclientes.php">Clientes</a></li><?php } ?>
            <?php  $permission='Productos'; 
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?> 
            <li><a class="dropdown-item" href="crudproductos.php">Productos</li></a></li><?php } ?>
            <?php  $permission='Marcas'; 
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?> 
            <li><a class="dropdown-item" href="crudmarca.php">Marcas</a></li><?php } ?>
			      <?php  $permission='Categorias'; 
              if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?> 
            <li><a class="dropdown-item" href="crudcategoria.php">Categoria</a></li><?php } ?>
            <?php  $permission='Usuarios';
            if ($funciones->tienePermiso($permission,$_SESSION['permissions'])){ ?> 
			      <li><a class="dropdown-item" href="crudusuarios.php">Usuarios</a></li><?php } ?>
          </ul>
        </li>
        <li class="dropdown position-relative">
				  <button type="button" class="badge bg-light border px-3 text-dark rounded-pill dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
					<span class="badge badge-pill bg-danger count"></span> 
					<?php echo $_SESSION['name']; ?>
				</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
					<li><a class="dropdown-item" href="accion.php?action=logout">Salir</a></li>
				</ul>
			</li>
      </ul>
    </div>

  </div>
</nav>


<script src="js/bootstrap.bundle.min.js"></script>



