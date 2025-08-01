<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imprimir variable PHP en JavaScript</title>
</head>
<body>

    <?php
    $nombre_producto = "Teclado Mecánico RGB";
    $precio_producto = 99.99;
    $usuario_activo = "admin";
    $es_admin = true;
    ?>

    <script>
        // Variables de cadena (string)
        var nombreProductoJS = "<?php echo htmlspecialchars($nombre_producto, ENT_QUOTES, 'UTF-8'); ?>";
        console.log("Nombre del producto (string):", nombreProductoJS); // Salida: Teclado Mecánico RGB

        // Variables numéricas
        var precioProductoJS = <?php echo $precio_producto; ?>;
        console.log("Precio del producto (número):", precioProductoJS); // Salida: 99.99

        // Variables booleanas
        var esAdminJS = <?php echo $es_admin ? 'true' : 'false'; ?>;
        console.log("¿Es administrador? (booleano):", esAdminJS); // Salida: true

        // Podemos usar las variables PHP directamente en un alert o manipulación del DOM
        alert("¡Bienvenido, " + "<?php echo htmlspecialchars($usuario_activo, ENT_QUOTES, 'UTF-8'); ?>" + "!");

        // Modificar un elemento del DOM
        document.body.innerHTML += '<p>El producto ' + nombreProductoJS + ' cuesta $' + precioProductoJS + '.</p>';
    </script>

</body>
</html>