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

    $_SESSION['DNI'] = $DNI;
    $_SESSION['Nombre'] = $Nombre; 
    // Hash de la contraseña
    $hashed_password = password_hash($Contrasenya, PASSWORD_DEFAULT);

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

    // Preparar la consulta SQL para insertar datos en la tabla Usuario
    $sql = "INSERT INTO Usuario (DNI, Nombre, Apellidos, Email, Fecha_nac, Foto, Direccion, Codigo_postal, Ciudad, Provincia, Pais, Contrasenya) VALUES ('$DNI', '$Nombre', '$Apellidos', '$Email', '$Fecha_nac', '$Foto', '$Direccion', '$Codigo_postal', '$Ciudad', '$Provincia', '$Pais', '$Contrasenya')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Datos almacenados correctamente en la base de datos.";

        // Guardar el DNI en la sesión
        $_SESSION['DNI'] = $DNI;

        // Redirigir a la página de inicio de sesión
        header("Location: inicio_sesion.php");
        exit();
    } else {
        echo "Error al almacenar datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si alguien intenta acceder directamente a iniciar_sesion.php, puedes redirigirlo a la página del formulario
    header("Location: registro.php");
    exit();
}
?>
