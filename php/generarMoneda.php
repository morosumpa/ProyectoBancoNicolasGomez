<?php
session_start();
$DNI_usuario = $_SESSION['DNI'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "DisBank");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir los datos del formulario
$monedaOrigen = strtoupper($_POST['monedaOrigen']);
$monedaDestino = strtoupper($_POST['monedaDestino']);

// Obtener el IBAN del usuario desde la tabla Cuenta
$queryIbanUsuario = "SELECT IBAN FROM Cuenta WHERE ID_usuario = (SELECT ID FROM Usuario WHERE DNI = ?)";
$stmtIbanUsuario = $conexion->prepare($queryIbanUsuario);

if (!$stmtIbanUsuario) {
    die("Error al preparar la consulta para obtener el IBAN del usuario: " . $conexion->error);
}

$stmtIbanUsuario->bind_param("s", $DNI_usuario);

if (!$stmtIbanUsuario->execute()) {
    die("Error al ejecutar la consulta para obtener el IBAN del usuario: " . $stmtIbanUsuario->error);
}

$stmtIbanUsuario->bind_result($ibanUsuario);

// Verificar si se obtuvo el IBAN
if (!$stmtIbanUsuario->fetch()) {
    die("No se encontró un IBAN para el usuario. DNI del usuario: $DNI_usuario");
}

$stmtIbanUsuario->close();

// Definir las tasas de cambio fijas
$tasasDeCambio = [
    "EURO" => ["DOLAR" => 1.1, "LIBRA" => 0.9, "YEN" => 160, "RUBLO" => 95],
    "DOLAR" => ["EURO" => 1 / 1.1, "LIBRA" => 0.9 / 1.1, "YEN" => 160 / 1.1, "RUBLO" => 95 / 1.1],
    "LIBRA" => ["EURO" => 1 / 0.9, "DOLAR" => 1.1 / 0.9, "YEN" => 160 / 0.9, "RUBLO" => 95 / 0.9],
    "YEN" => ["EURO" => 1 / 160, "DOLAR" => 1.1 / 160, "LIBRA" => 0.9 / 160, "RUBLO" => 95 / 160],
    "RUBLO" => ["EURO" => 1 / 95, "DOLAR" => 1.1 / 95, "LIBRA" => 0.9 / 95, "YEN" => 160 / 95],
];

// Obtener la tasa de cambio
$tasaCambio = $tasasDeCambio[$monedaOrigen][$monedaDestino];

// Obtener el saldo actual en la moneda de origen
$querySaldo = "SELECT Saldo FROM Cuenta WHERE IBAN = ?";
$stmtSaldo = $conexion->prepare($querySaldo);

if (!$stmtSaldo) {
    die("Error al preparar la consulta de saldo: " . $conexion->error);
}

$stmtSaldo->bind_param("s", $ibanUsuario);

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
$queryActualizarSaldo = "UPDATE Cuenta SET Saldo = ? WHERE IBAN = ?";
$stmtActualizarSaldo = $conexion->prepare($queryActualizarSaldo);

if (!$stmtActualizarSaldo) {
    die("Error al preparar la consulta de actualización de saldo: " . $conexion->error);
}

$stmtActualizarSaldo->bind_param("ds", $saldoConvertido, $ibanUsuario);

if (!$stmtActualizarSaldo->execute()) {
    die("Error al actualizar el saldo: " . $stmtActualizarSaldo->error);
}

$stmtActualizarSaldo->close();

// Cierra la conexión a la base de datos
$conexion->close();

// Aquí puedes redirigir o mostrar un mensaje de éxito
echo "El saldo ha sido convertido correctamente. Tasa de cambio: $tasaCambio. Cantidad inicial: $saldo. Cantidad convertida: $saldoConvertido. IBAN: $ibanUsuario";
?>
