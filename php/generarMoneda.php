<?php
// Conexión a la base de datos (ajusta según tus credenciales)
$conexion = new mysqli("localhost", "root", "", "DisBank");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$monedaOrigen = $_POST['monedaOrigen'];
$monedaDestino = $_POST['monedaDestino'];

// Obtener el IBAN del usuario (ajusta según tu lógica de usuario)
$ibanUsuario = "IBAN_DEL_USUARIO_ACTUAL";

// Obtener el valor de cambio de la base de datos
$query = "SELECT Tasa_cambio FROM CambioMoneda WHERE UPPER(Moneda_origen) = UPPER(?) AND UPPER(Moneda_destino) = UPPER(?)";
$stmt = $conexion->prepare($query);

// Verificar si la preparación de la consulta fue exitosa
if (!$stmt) {
    die("Error al preparar la consulta: " . $conexion->error);
}

$stmt->bind_param("ss", $monedaOrigen, $monedaDestino);

// Verificar si la ejecución de la consulta fue exitosa
if (!$stmt->execute()) {
    die("Error al ejecutar la consulta: " . $stmt->error);
}

$stmt->bind_result($tasaCambio);

// Intentar obtener los resultados
if (!$stmt->fetch()) {
    die("Error al obtener los resultados Tasa_cambio: No se encontraron resultados para la moneda de origen '$monedaOrigen' y destino '$monedaDestino'");
}

$stmt->close();

// Obtener el saldo actual en la moneda de origen
$querySaldo = "SELECT Saldo FROM Cuenta WHERE IBAN = ? AND Moneda = ?";
$stmtSaldo = $conexion->prepare($querySaldo);

// Verificar si la preparación de la consulta fue exitosa
if (!$stmtSaldo) {
    die("Error al preparar la consulta de saldo: " . $conexion->error);
}

$stmtSaldo->bind_param("ss", $ibanUsuario, $monedaOrigen);

// Verificar si la ejecución de la consulta fue exitosa
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
$queryActualizarSaldo = "UPDATE Cuenta SET Saldo = ? WHERE IBAN = ? AND Moneda = ?";
$stmtActualizarSaldo = $conexion->prepare($queryActualizarSaldo);

// Verificar si la preparación de la consulta fue exitosa
if (!$stmtActualizarSaldo) {
    die("Error al preparar la consulta de actualización de saldo: " . $conexion->error);
}

$stmtActualizarSaldo->bind_param("dss", $saldoConvertido, $ibanUsuario, $monedaDestino);

// Verificar si la ejecución de la consulta fue exitosa
if (!$stmtActualizarSaldo->execute()) {
    die("Error al actualizar el saldo: " . $stmtActualizarSaldo->error);
}

$stmtActualizarSaldo->close();

// Cierra la conexión a la base de datos
$conexion->close();

// Aquí puedes redirigir o mostrar un mensaje de éxito
echo "El saldo ha sido convertido correctamente.";
?>
