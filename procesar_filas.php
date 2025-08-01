<?php
// procesar_filas.php
include 'config.php'; // Asegúrate de que tu archivo de conexión a la BD esté incluido

header('Content-Type: application/json'); // ¡Muy importante! Indica que la respuesta es JSON

$response = ['success' => false, 'message' => ''];

if (isset($_POST['numPeds']) && is_array($_POST['numPeds'])) {
    $selectedNumPeds = $_POST['numPeds'];

    if (empty($selectedNumPeds)) {
        $response['message'] = 'No se recibieron números de pedido para procesar.';
        echo json_encode($response);
        exit();
    }

    // Convertir todos los numPeds a enteros para seguridad y para usarlos en la consulta IN
    // Asegúrate de que tus numPeds sean realmente numéricos si los usarás como INT en la DB.
    // Si son cadenas (ej. 'PED001'), no uses intval.
    // Para este ejemplo, asumo que son numéricos o se pueden tratar como tal.
    $validNumPeds = array_map('intval', $selectedNumPeds); // O 'mysqli_real_escape_string' si son cadenas

    // Crear placeholders para la consulta IN (ej. ?, ?, ?)
    $placeholders = implode(',', array_fill(0, count($validNumPeds), '?'));

    // Crear la cadena de tipos para bind_param (ej. 'iii' para 3 enteros)
    $types = str_repeat('i', count($validNumPeds)); // 'i' si son enteros, 's' si son cadenas

    // Preparar la consulta SQL
    // **¡IMPORTANTE!** Ajusta tu tabla y las columnas a actualizar aquí.
    // Ejemplo: Actualizar el 'status' del pedido a 'Procesado'
    $sql = "UPDATE pedido SET status = 'A' WHERE numped IN ($placeholders)";

    if ($stmt = $conn->prepare($sql)) {
        // Enlazar los parámetros dinámicamente
        // Esta es la forma correcta de pasar un array a bind_param en PHP 5.6+ / 7+
        $stmt->bind_param($types, ...$validNumPeds);

        if ($stmt->execute()) {
            $affected_rows = $stmt->affected_rows;
            $response['success'] = true;
            $response['message'] = "Se actualizaron $affected_rows pedidos correctamente.";
        } else {
            $response['message'] = "Error al ejecutar la actualización: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $response['message'] = "Error al preparar la consulta: " . $conn->error;
    }
} else {
    $response['message'] = "Solicitud inválida. No se recibieron números de pedido.";
}

// Cerrar la conexión a la base de datos
$conn->close();

echo json_encode($response);

?>