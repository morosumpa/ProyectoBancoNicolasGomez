<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
    $cantidad = isset($_POST["cantidad"]) ? floatval(trim($_POST["cantidad"])) : 0;

    // Validar y limpiar los datos
    $descripcion = htmlspecialchars($descripcion);
    
    // Verificar si la cantidad es un número positivo
    if ($cantidad <= 0) {
        die("La cantidad debe ser un número positivo.");
    }

    // Configuración de la base de datos
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    // Crear una conexión a la base de datos
    $conn = new mysqli($servername, $username, $password_db, $database);
    
    // Cerrar la conexión
    $conn->close();
}
?>
