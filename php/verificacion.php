<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DNI = $_POST["campo1"];
    // Trim de contraseña para evitar espacios indeseados
    $Contrasenya = trim($_POST["campo12"]);

    // Configuración de la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password_db, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    echo "Conexión a la base de datos exitosa.<br>";

    // Consulta SQL para obtener la contraseña
    $sql = "SELECT Contrasenya FROM Usuario WHERE DNI = '$DNI'";
    $result = $conn->query($sql);

    if ($result !== FALSE && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row["Contrasenya"];
        echo "Contraseña almacenada: " . $stored_password . "<br>";

        // Verificar si la contraseña coincide
        if ($Contrasenya === $stored_password) {
            // La contraseña es correcta, puedes redirigir al usuario a su área personal o hacer otras acciones
            echo "Inicio de sesión exitoso."; 
            header("Location: landingpage.php");
    exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró un usuario con el DNI proporcionado.";
    }

    // Cerrar la conexión
    $conn->close();
} 
?>
