<script>
$(document).ready(function() {
    $('#miTabla').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdf',
                customize: function ( doc ) {
                    // Añadir el título al inicio de cada página
                    doc.content.forEach(function(item, index) {
                        if (item.table) {
                            // Inserta el título antes de la tabla
                            doc.content.splice(index, 0, {
                                text: 'Mi Título de la Tabla',
                                style: 'header'
                            });
                        }
                    });
                }
            },
            {
                extend: 'print',
                customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )
                        .prepend(
                            '<h1 style="text-align:center;">Mi Título de la Tabla</h1>'
                        );

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
            }
        ]
    } );
} );
</script>