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

    // Consulta SQL para obtener la contraseña y el nombre de usuario
    $sql = "SELECT Contrasenya, Nombre FROM Usuario WHERE DNI = '$DNI'";
    $result = $conn->query($sql);

    if ($result !== FALSE && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row["Contrasenya"];
        $nombre_de_usuario = $row["Nombre"];

        // Verificar si la contraseña coincide
        if ($Contrasenya === $stored_password) {
            // Inicio de sesión exitoso
            session_start();
            $_SESSION['Nombre'] = $nombre_de_usuario;
            $_SESSION['bienvenida_message'] = "Bienvenido, " . $nombre_de_usuario . ". Hoy es " . date('d \d\e F \d\e Y') . ". ¿Qué realizarás hoy?";
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