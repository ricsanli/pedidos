<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedidos</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <style>
        /* Estilos para el encabezado de impresión */
        .print-header {
            width: 100%;
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box; /* Asegura que el padding no aumente el tamaño */
            display: grid;
            grid-template-columns: 1fr 1fr; /* Dos columnas para un diseño cuadrado */
            gap: 10px;
        }
        .print-header div {
            padding: 5px;
            /* border: 1px solid #ccc; /* Opcional: para visualizar los divs */
        }
        .print-header .left-info {
            grid-column: 1 / 2;
        }
        .print-header .right-info {
            grid-column: 2 / 3;
            text-align: right;
        }
        .print-header .center-title {
            grid-column: 1 / 3;
            text-align: center;
            font-weight: bold;
            font-size: 1.2em;
        }

        /* Ocultar el encabezado personalizado en la vista normal del navegador */
        .print-header-container {
            display: none;
        }

        @media print {
            .print-header-container {
                display: block; /* Mostrar solo al imprimir */
            }
        }
    </style>
</head>
<body>

    <div class="print-header-container">
        <div class="print-header" id="pedidoHeader">
            <div class="center-title">ENCABEZADO DE PEDIDO</div>
            <div class="left-info">
                <p><strong>Empresa:</strong> Tu Empresa S.A.</p>
                <p><strong>Dirección:</strong> Calle Falsa 123, Ciudad</p>
                <p><strong>Teléfono:</strong> (123) 456-7890</p>
            </div>
            <div class="right-info">
                <p><strong>Nro. Pedido:</strong> <span id="numeroPedido">XXXXX</span></p>
                <p><strong>Fecha:</strong> <span id="fechaPedido">DD/MM/AAAA</span></p>
                <p><strong>Cliente:</strong> <span id="nombreCliente">Nombre del Cliente</span></p>
            </div>
        </div>
    </div>

    <table id="miTablaPedidos" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                </tr>
        </thead>
        <tbody>
            <?php
            // Conexión a la base de datos (ejemplo)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "inventario_db";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $sql = "SELECT p.numped, d.pid, d.cantidad, 
                    d.precio, (d.cantidad * d.precio) as totalp,
                    p.fecha_ped, c.name
                    FROM pedido p
                    JOIN mov_ped d ON p.numped = d.numped
                    JOIN ims_customer c ON p.codcli = c.codcli
                    ORDER BY p.numped";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["numped"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["pid"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["cantidad"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["precio"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["totalp"]) . "</td>";
                    // Puedes agregar data-attributes para los campos del encabezado
                    echo "<td data-fecha-pedido='" . htmlspecialchars($row["fecha_ped"]) . "' data-nombre-cliente='" . htmlspecialchars($row["name"]) . "'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay pedidos para mostrar.</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>

    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            
            var table = new $('#miTablaPedidos').DataTable({
                layout: { // Mostrar botones de exportación
                topStart: {    
                buttons: [
                    {
                        extend: 'print',
                        text: 'Imprimir',
                        customize: function ( win ) {
                            // Obtener el HTML del encabezado del pedido
                            var headerHtml = $('#pedidoHeader').prop('outerHTML');

                            // Clonar el encabezado para evitar modificar el original
                            var $headerClone = $(headerHtml);

                            // Obtener los datos de la primera fila para el encabezado (si es un solo pedido)
                            // Si tienes múltiples pedidos en la tabla y quieres un encabezado por pedido,
                            // necesitarías una lógica más compleja o generar PDFs individuales.
                            // Para un solo pedido o si el encabezado es general para la tabla:
                            if (table.rows().count() > 0) {
                                var rowData = table.row(0).data(); // Obtener datos de la primera fila
                                var idPedido = rowData[0]; // Suponiendo que el ID de pedido está en la primera columna
                                var fechaPedido = $('#miTablaPedidos tbody tr:eq(0) td:last-child').data('fecha-pedido');
                                var nombreCliente = $('#miTablaPedidos tbody tr:eq(0) td:last-child').data('nombre-cliente');

                                $headerClone.find('#numeroPedido').text(idPedido);
                                $headerClone.find('#fechaPedido').text(fechaPedido);
                                $headerClone.find('#nombreCliente').text(nombreCliente);
                            } else {
                                $headerClone.find('#numeroPedido').text('N/A');
                                $headerClone.find('#fechaPedido').text('N/A');
                                $headerClone.find('#nombreCliente').text('N/A');
                            }


                            $(win.document.body)
                                .css( 'font-size', '10pt' )
                                .prepend( $headerClone ); // Inserta el encabezado al principio del cuerpo del documento de impresión

                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Exportar a PDF',
                        orientation: 'portrait', // 'landscape'
                        pageSize: 'A4',
                        title: 'Informe de Pedido',
                        customize: function (doc) {
                            // Obtener los datos de la primera fila para el encabezado
                            var idPedido = 'N/A';
                            var fechaPedido = 'N/A';
                            var nombreCliente = 'N/A';

                            if (table.rows().count() > 0) {
                                var rowData = table.row(0).data();
                                idPedido = rowData[0]; // Suponiendo que el ID de pedido está en la primera columna
                                fechaPedido = $('#miTablaPedidos tbody tr:eq(0) td:last-child').data('fecha-pedido');
                                nombreCliente = $('#miTablaPedidos tbody tr:eq(0) td:last-child').data('nombre-cliente');
                            }

                            // Contenido del encabezado para PDFMake
                            doc.content.splice(0, 0, {
                                margin: [0, 0, 0, 12], // Margen inferior
                                style: 'headerStyle',
                                table: {
                                    widths: ['*', '*'], // Dos columnas de ancho igual
                                    body: [
                                        [{ text: 'ENCABEZADO DE PEDIDO', colSpan: 2, alignment: 'center', style: 'headerTitle' }, {}],
                                        [{ text: 'Empresa: Tu Empresa S.A.\nDirección: Calle Falsa 123, Ciudad\nTeléfono: (123) 456-7890', alignment: 'left' },
                                         { text: 'Nro. Pedido: ' + idPedido + '\nFecha: ' + fechaPedido + '\nCliente: ' + nombreCliente, alignment: 'right' }]
                                    ]
                                },
                                layout: {
                                    hLineWidth: function(i, node) {
                                        return (i === 0 || i === node.table.body.length) ? 1 : 0; // Línea horizontal arriba y abajo
                                    },
                                    vLineWidth: function(i, node) {
                                        return (i === 0 || i === node.table.widths.length) ? 1 : 0; // Línea vertical izquierda y derecha
                                    },
                                    hLineColor: function(i, node) {
                                        return 'black';
                                    },
                                    vLineColor: function(i, node) {
                                        return 'black';
                                    },
                                    paddingLeft: function(i, node) { return 10; },
                                    paddingRight: function(i, node) { return 10; },
                                    paddingTop: function(i, node) { return 5; },
                                    paddingBottom: function(i, node) { return 5; }
                                }
                            });

                            // Estilos adicionales para el PDF
                            doc.styles.headerStyle = {
                                fontSize: 10
                            };
                            doc.styles.headerTitle = {
                                fontSize: 12,
                                bold: true,
                                margin: [0, 5, 0, 5] // Margen arriba y abajo
                            };
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Exportar a Excel',
                        title: 'Informe de Pedido',
                        exportOptions: {
                            // Puedes personalizar las columnas a exportar si es necesario
                            columns: ':visible'
                        }
                    }
                ]}
        }});
        });
    </script>

</body>
</html>