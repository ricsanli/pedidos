<?php
// fetch.php (ejemplo de tu script PHP que alimenta DataTables)

// ... tu código para conectarte a la base de datos y obtener los datos ...

$data = array();
$total_columna_1 = 0;
$total_columna_2 = 0;

foreach ($result as $row) {
    $sub_array = array();
    $sub_array[] = $row["campo1"];
    $sub_array[] = $row["campo2"]; // Asume que este es el campo a sumar
    $sub_array[] = $row["campo3"];
    // ... otros campos

    $data[] = $sub_array;

    // Sumar el valor de la columna relevante
    $total_columna_1 += (float)$row["campo2"]; 
    $total_columna_2 += (float)$row["otro_campo_a_sumar"]; // Si tienes más columnas
}

// Preparar el array final para DataTables
$output = array(
    "draw"            => intval($_POST["draw"]),
    "recordsTotal"    => $total_records, // Total de registros sin filtrar
    "recordsFiltered" => $total_records_filtered, // Total de registros después del filtro
    "data"            => $data,
    "total_columna_1" => $total_columna_1, // Envía el total junto con los datos
    "total_columna_2" => $total_columna_2
);

echo json_encode($output);

?>





<script>
$(document).ready(function() {
    var table = $('#miTabla').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "fetch.php", // Tu script PHP
            "type": "POST"
        },
        "columns": [
            { "data": 0 }, // Columna 1
            { "data": 1 }, // Columna 2 (la que se suma)
            { "data": 2 }  // Columna 3
            // ... otras columnas
        ],
        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();

            // Acceder a los totales enviados desde PHP
            var totalColumna1 = api.ajax.json().total_columna_1;
            var totalColumna2 = api.ajax.json().total_columna_2;

            // Actualizar el pie de la tabla (ejemplo: en la columna 2)
            $( api.column( 1 ).footer() ).html(
                'Total: ' + totalColumna1.toFixed(2) // Formatear a 2 decimales
            );
            // Si tienes más totales, actualiza los otros footers
            // $( api.column( 2 ).footer() ).html(
            //     'Total: ' + totalColumna2.toFixed(2)
            // );
        },
        dom: 'Bfrtip', // Habilita los botones de exportación
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>