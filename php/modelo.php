<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DNI = $_POST["campo1"];
    $Nombre = $_POST["campo2"];
    $Apellidos = $_POST["campo3"];
    $Email = $_POST["campo4"];
    $Fecha_nac = $_POST["campo5"];
    $Foto = $_POST["campo6"];
    $Direccion = $_POST["campo7"];
    $Codigo_postal = $_POST["campo8"];
    $Ciudad = $_POST["campo9"];
    $Provincia = $_POST["campo10"];
    $Pais = $_POST["campo11"];
    $Contrasenya = $_POST["campo12"];

    // Validar el formato del correo electrónico
    if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        echo "El formato del correo electrónico no es válido.";
        exit();
    }

    // Validar el formato de la fecha de nacimiento
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $Fecha_nac)) {
        echo "El formato de fecha de nacimiento no es válido.";
        exit();
    }

    // Configuración de la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "DisBank";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Sentencia preparada para evitar la inyección de SQL
    $stmt = $conn->prepare("INSERT INTO Usuario (DNI, Nombre, Apellidos, Email, Fecha_nac, Foto, Direccion, Codigo_postal, Ciudad, Provincia, Pais, Contrasenya) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssss", $DNI, $Nombre, $Apellidos, $Email, $Fecha_nac, $Foto, $Direccion, $Codigo_postal, $Ciudad, $Provincia, $Pais, $Contrasenya);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Datos almacenados correctamente en la base de datos.";

        // Guardar el DNI en la sesión
        $_SESSION['DNI'] = $DNI;

        // Redirigir a la página de inicio de sesión
        header("Location: inicio_sesion.php");
        exit();
    } else {
        echo "Error al almacenar datos: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
} else {
    // Si alguien intenta acceder directamente a iniciar_sesion.php, puedes redirigirlo a la página del formulario
    header("Location: registro.php");
    exit();
}
?>
