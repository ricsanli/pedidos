<?php
include ('inc/consec.php');
// Configuración de la base de datos
//define ('DB_HOST', 'localhost');
//define('DB_NAME', 'inventario_db');
//define('DB_USER', 'root');
//define('DB_PASS', '');

/**
 * Función para generar un número de pedido único.
 * En un entorno real, este número debería ser más robusto (ej. GUID, secuencial con prefijo, etc.)
 * Para este ejemplo, usaremos un timestamp y un ID de usuario simulado.
 */
function generarNumeroPedidoUnico($clienteId) {

    
    return 'PED-' . date('YmdHis') . '-' . str_pad($clienteId, 4, '0', STR_PAD_LEFT) . '-' . uniqid();
}

try {
    // Conexión a la base de datos usando PDO
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Deshabilitar emulación para prepared statements reales

    // Simulación de datos del cliente (esto vendría de tu formulario o sesión de usuario)
    //$clienteId = rand(1, 100); // Suponemos un ID de cliente aleatorio para la prueba
    //$clienteId='3024';
    // Iniciar transacción
    // Esto asegura que todas las operaciones dentro del bloque BEGIN/COMMIT se traten como una sola unidad.
    $pdo->beginTransaction();

    // 1. Generar número de pedido
    //$numeroPedido = generarNumeroPedidoUnico($clienteId);
    $numeroPedido=0;
    
    $numeroPedido  = npedido($numeroPedido);
    // 2. Insertar el pedido en la base de datos
    // Se recomienda añadir un índice UNIQUE al campo 'numero_pedido' en la base de datos
    // para evitar duplicados a nivel de DB en caso de errores lógicos.
    $stmt = $pdo->prepare("INSERT INTO pedido (numped, codcli, fecha_ped) VALUES (:numero_pedido, :cliente_id, NOW())");
    $stmt->bindParam(':numero_pedido', $numeroPedido);
    $stmt->bindParam(':cliente_id', $clienteId);
    $stmt->execute();

    // Obtener el ID del pedido recién insertado
    $pedidoId = $pdo->lastInsertId();

    // 3. Confirmar la transacción
    // Si todo ha ido bien, se guardan los cambios.
    $pdo->commit();

    echo "¡Pedido realizado con éxito!<br>";
    echo "ID de Pedido: " . $pedidoId . "<br>";
    echo "Número de Pedido: " . $numeroPedido . "<br>";
    echo "Cliente ID: " . $clienteId . "<br>";

} catch (PDOException $e) {
    // Si algo falla, se revierte la transacción.
    // Esto asegura que no queden datos inconsistentes en la base de datos.
    $pdo->rollBack();
    echo "Error al procesar el pedido: " . $e->getMessage() . "<br>";
    // En un entorno de producción, loguear el error en lugar de mostrarlo directamente al usuario.
} catch (Exception $e) {
    echo "Error inesperado: " . $e->getMessage() . "<br>";
}

?>