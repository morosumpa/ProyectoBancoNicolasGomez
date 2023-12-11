<?php
// Conexión a la base de datos (ajusta según tus credenciales)
$conexion = new mysqli("localhost", "root", "", "DisBank");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$monedaOrigen = strtoupper($_POST['monedaOrigen']);
$monedaDestino = strtoupper($_POST['monedaDestino']);

// Obtener el IBAN del usuario (ajusta según tu lógica de usuario)
$ibanUsuario = "IBAN_DEL_USUARIO_ACTUAL";

// Obtener el valor de cambio de la base de datos o insertar si no existe
$query = "SELECT Tasa_cambio FROM CambioMoneda WHERE UPPER(Moneda_origen) = UPPER(?) AND UPPER(Moneda_destino) = UPPER(?)";
$stmt = $conexion->prepare($query);

if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("ss", $monedaOrigen, $monedaDestino);

if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}

$stmt->bind_result($tasaCambio);

// Si no hay resultados, insertar un nuevo registro
if (!$stmt->fetch()) {
    $stmt->close();

    // Valor de cambio por defecto
    $valorCambioPorDefecto = 1;

    // Insertar nuevo registro
    $insertQuery = "INSERT INTO CambioMoneda (Moneda_origen, Moneda_destino, Tasa_cambio) VALUES (?, ?, ?)";
    $insertStmt = $conexion->prepare($insertQuery);

    if (!$insertStmt) {
        die("Error al preparar la consulta de inserción: " . $conexion->error);
    }

    $insertStmt->bind_param("ssd", $monedaOrigen, $monedaDestino, $valorCambioPorDefecto);

    if (!$insertStmt->execute()) {
        die("Error al insertar el nuevo registro: " . $insertStmt->error);
    }

    $insertStmt->close();

    // Actualizar tasa de cambio
    $tasaCambio = $valorCambioPorDefecto;
}

$stmt->close();

// Obtener el saldo actual en la moneda de origen
$querySaldo = "SELECT Saldo FROM Cuenta WHERE IBAN = ? AND Tipo_cuenta = ?";
$stmtSaldo = $conexion->prepare($querySaldo);

if (!$stmtSaldo) {
    die("Error al preparar la consulta de saldo: " . $conexion->error);
}

$stmtSaldo->bind_param("ss", $ibanUsuario, $monedaOrigen);

if (!$stmtSaldo->execute()) {
    die("Error al ejecutar la consulta de saldo: " . $stmtSaldo->error);
}

$stmtSaldo->bind_result($saldo);

// Intentar obtener el saldo
if (!$stmtSaldo->fetch()) {
    die("Error al obtener el saldo: " . $stmtSaldo->error);
}

$stmtSaldo->close();

// Calcular el nuevo saldo en la moneda de destino
$saldoConvertido = $saldo * $tasaCambio;

// Actualizar el saldo en la moneda de destino
$queryActualizarSaldo = "UPDATE Cuenta SET Saldo = ? WHERE IBAN = ? AND Tipo_cuenta = ?";
$stmtActualizarSaldo = $conexion->prepare($queryActualizarSaldo);

if (!$stmtActualizarSaldo) {
    die("Error al preparar la consulta de actualización de saldo: " . $conexion->error);
}

$stmtActualizarSaldo->bind_param("dss", $saldoConvertido, $ibanUsuario, $monedaDestino);

if (!$stmtActualizarSaldo->execute()) {
    die("Error al actualizar el saldo: " . $stmtActualizarSaldo->error);
}

$stmtActualizarSaldo->close();

// Cierra la conexión a la base de datos
$conexion->close();

// Aquí puedes redirigir o mostrar un mensaje de éxito
echo "El saldo ha sido convertido correctamente. Tasa de cambio: $tasaCambio";
?>
