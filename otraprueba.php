<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Clientes y Pedidos</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- jQuery (Requerido por DataTables) -->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6; /* light gray background */
        }
        /* Estilos personalizados para las filas de total */
        .cliente-total {
            background-color: #e0f2fe !important; /* light blue for total rows */
            font-weight: bold;
            color: #1e40af; /* darker blue text */
        }
        /* Ajuste de DataTables para un mejor aspecto con Tailwind */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply px-3 py-1 rounded-md border border-gray-300 mx-1 bg-white hover:bg-gray-100;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-blue-500 text-white border-blue-500;
        }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            @apply rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50;
        }
        table.dataTable thead th,
        table.dataTable tbody td {
            @apply py-2 px-4 text-left;
        }
        table.dataTable thead th {
            @apply bg-gray-200 text-gray-700;
        }
        table.dataTable tbody tr:nth-child(odd) {
            @apply bg-white;
        }
        table.dataTable tbody tr:nth-child(even) {
            @apply bg-gray-50;
        }
    </style>
</head>
<body class="p-6">
    <div class="container mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Reporte de Clientes y Pedidos</h1>

        <div class="overflow-x-auto">
            <table id="reporteClientes" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">Cliente ID</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pedido ID</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                        <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">Subtotal</th>
                    </tr>
                </thead>
                <tbody id="reporteBody" class="bg-white divide-y divide-gray-200">
                    <!-- Aquí se insertarán los datos y totales dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- SIMULACIÓN DE DATOS DE PHP/MYSQL ---
            // En un entorno real, estos datos vendrían de tu script PHP después de una consulta MySQL.
            const clientes = [
                { id_cliente: 1, nombre_cliente: 'Alice Smith' },
                { id_cliente: 2, nombre_cliente: 'Bob Johnson' },
                { id_cliente: 3, nombre_cliente: 'Charlie Brown' },
                { id_cliente: 4, nombre_cliente: 'Diana Prince' }
            ];

            const pedidos = [
                { id_pedido: 101, id_cliente: 1, nombre_producto: 'Laptop XYZ', cantidad: 1, precio_unitario: 1200.00 },
                { id_pedido: 102, id_cliente: 1, nombre_producto: 'Mouse Inalámbrico', cantidad: 2, precio_unitario: 25.50 },
                { id_pedido: 103, id_cliente: 2, nombre_producto: 'Teclado Mecánico', cantidad: 1, precio_unitario: 75.00 },
                { id_pedido: 104, id_cliente: 1, nombre_producto: 'Monitor Curvo 27"', cantidad: 1, precio_unitario: 300.00 },
                { id_pedido: 105, id_cliente: 3, nombre_producto: 'Cámara Web HD', cantidad: 1, precio_unitario: 50.00 },
                { id_pedido: 106, id_cliente: 2, nombre_producto: 'Auriculares Gaming', cantidad: 1, precio_unitario: 150.00 },
                { id_pedido: 107, id_cliente: 3, nombre_producto: 'Micrófono Condensador', cantidad: 1, precio_unitario: 80.00 },
                { id_pedido: 108, id_cliente: 4, nombre_producto: 'Disco Duro SSD 1TB', cantidad: 1, precio_unitario: 90.00 },
                { id_pedido: 109, id_cliente: 4, nombre_producto: 'Memoria RAM 16GB', cantidad: 2, precio_unitario: 60.00 }
            ];

            // Simulación de la unión y ordenación que harías en SQL
            // En PHP, esto sería el resultado de tu consulta SQL `LEFT JOIN clientes ON pedidos`
            const rawData = [];
            clientes.forEach(cliente => {
                const clientePedidos = pedidos.filter(p => p.id_cliente === cliente.id_cliente)
                                             .map(p => ({
                                                 ...p,
                                                 nombre_cliente: cliente.nombre_cliente,
                                                 subtotal_producto: p.cantidad * p.precio_unitario
                                             }))
                                             .sort((a, b) => a.id_pedido - b.id_pedido); // Ordenar pedidos dentro del cliente

                if (clientePedidos.length > 0) {
                    rawData.push(...clientePedidos);
                } else {
                    // Si un cliente no tiene pedidos, aún lo incluimos para mostrarlo en el reporte
                    rawData.push({
                        id_cliente: cliente.id_cliente,
                        nombre_cliente: cliente.nombre_cliente,
                        id_pedido: null, // No hay pedido
                        nombre_producto: 'No hay pedidos',
                        cantidad: null,
                        precio_unitario: null,
                        subtotal_producto: 0
                    });
                }
            });

            // Ordenar los datos combinados por ID de cliente para la ruptura
            rawData.sort((a, b) => a.id_cliente - b.id_cliente);

            // --- LÓGICA DE RUPTURA DE DATOS Y TOTALES (Simulación PHP) ---
            const reporteBody = document.getElementById('reporteBody');
            let currentClienteId = null;
            let currentClienteTotal = 0;
            let clienteNombreActual = '';
            let rowsToInsert = []; // Usaremos un array para acumular HTML y luego insertarlo de una vez

            rawData.forEach((row, index) => {
                if (row.id_cliente !== currentClienteId) {
                    // Si hay un cambio de cliente y no es el primer cliente procesado
                    if (currentClienteId !== null) {
                        // Insertar la fila de total para el cliente anterior
                        rowsToInsert.push(`
                            <tr class="cliente-total">
                                <td colspan="6" class="py-2 px-4 text-right"><strong>Total para ${clienteNombreActual}:</strong></td>
                                <td class="py-2 px-4 text-left"><strong>$${currentClienteTotal.toFixed(2)}</strong></td>
                            </tr>
                        `);
                    }

                    // Reiniciar para el nuevo cliente
                    currentClienteId = row.id_cliente;
                    currentClienteTotal = 0;
                    clienteNombreActual = row.nombre_cliente; // Actualizar el nombre del cliente
                }

                // Insertar la fila del pedido actual
                rowsToInsert.push(`
                    <tr>
                        <td class="py-2 px-4">${row.id_cliente || '-'}</td>
                        <td class="py-2 px-4">${row.nombre_cliente || '-'}</td>
                        <td class="py-2 px-4">${row.id_pedido || '-'}</td>
                        <td class="py-2 px-4">${row.nombre_producto || '-'}</td>
                        <td class="py-2 px-4">${row.cantidad !== null ? row.cantidad : '-'}</td>
                        <td class="py-2 px-4">${row.precio_unitario !== null ? '$' + row.precio_unitario.toFixed(2) : '-'}</td>
                        <td class="py-2 px-4">${row.subtotal_producto !== null ? '$' + row.subtotal_producto.toFixed(2) : '-'}</td>
                    </tr>
                `);

                // Acumular el subtotal del producto al total del cliente actual
                currentClienteTotal += (row.subtotal_producto || 0);

                // Manejar el caso del último cliente después del bucle
                if (index === rawData.length - 1) {
                     rowsToInsert.push(`
                        <tr class="cliente-total">
                            <td colspan="6" class="py-2 px-4 text-right"><strong>Total para ${clienteNombreActual}:</strong></td>
                            <td class="py-2 px-4 text-left"><strong>$${currentClienteTotal.toFixed(2)}</strong></td>
                        </tr>
                    `);
                }
            });

            reporteBody.innerHTML = rowsToInsert.join('');

            // --- INICIALIZACIÓN DE DATATABLES ---
            // DataTables debe inicializarse después de que el tbody esté completamente poblado.
            $('#reporteClientes').DataTable({
                paging: true,          // Habilitar paginación
                searching: true,       // Habilitar búsqueda
                ordering: false,       // Deshabilitar ordenación para evitar problemas con las filas de total
                info: true,            // Mostrar información de paginación
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es_es.json' // Idioma español
                },
                // Desactivar el procesamiento de DataTables para las filas de total
                // DataTables tiene problemas para ordenar/filtrar cuando hay filas de totales insertadas manualmente.
                // Es por eso que se ha deshabilitado 'ordering'.
                // Puedes usar 'rowCallback' si necesitas interactuar con las filas de forma específica.
                // rowCallback: function(row, data, index) {
                //     // Ejemplo: Aplicar clase si es una fila de total (si no se hizo con PHP)
                //     if ($(row).hasClass('cliente-total')) {
                //         // Hacer algo especial
                //     }
                // }
            });
        });
    </script>
</body>
</html>