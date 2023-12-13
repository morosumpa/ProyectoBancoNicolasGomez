<?php
session_start();

if (!isset($_SESSION['DNI'])) {
    echo "Error: DNI de usuario no encontrado en la sesión.";
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DisBank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$dni_usuario = $_SESSION['DNI'];

// Asegúrate de validar y sanitizar los datos del formulario para evitar posibles problemas de seguridad
$tasa_interes = $_POST['tasa_interes'];
$plazo_meses = $_POST['plazo_meses'];
$fecha_final = $_POST['fecha_final'];

// Consulta SQL preparada para evitar inyección de SQL
$sql_insert = "INSERT INTO Prestamos (DNI_usuario, Tasa_interes, Plazo_meses, Fecha_final, Estado) VALUES (?, ?, ?, ?, 1)";
$stmt_insert = $conn->prepare($sql_insert);

// Verifica si la preparación de la consulta fue exitosa
if (!$stmt_insert) {
    echo "Error en la preparación de la consulta: " . $conn->error;
    exit;
}

// Vincula los parámetros
$stmt_insert->bind_param("sids", $dni_usuario, $tasa_interes, $plazo_meses, $fecha_final);

// Ejecuta la consulta
if ($stmt_insert->execute()) {
    echo "Préstamo aceptado y registrado con éxito.";
} else {
    echo "Error al registrar el préstamo: " . $stmt_insert->error;
}

// Cierra la consulta preparada
$stmt_insert->close();

// Cierra la conexión
$conn->close();
?>
