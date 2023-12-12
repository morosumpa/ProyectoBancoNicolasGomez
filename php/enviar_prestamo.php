<?php
session_start();

if (!isset($_SESSION['DNI'])) {
    echo "Error: DNI de usuario no encontrado en la sesión.";
    exit;
}
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DisBank";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recupera los datos del formulario
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];

// Inserta los datos en la tabla Prestamos
$dni_usuario = $_SESSION['DNI'];
$sql = "INSERT INTO Prestamos (DNI_usuario, Monto_pedido, Descripcion)
        VALUES ('$dni_usuario', '$cantidad', '$descripcion')";

if ($conn->query($sql) === TRUE) {
    echo "Préstamo enviado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cierra la conexión
$conn->close();
?>
