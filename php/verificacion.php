<?php
session_start(); // Ahora se inicia la sesión al principio del script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DNI = $_POST["campo1"];
    $Contrasenya = trim($_POST["campo12"]);

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    $conn = new mysqli($servername, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "SELECT DNI, Contrasenya, Nombre FROM Usuario WHERE DNI = '$DNI'";
    $result = $conn->query($sql);

    if ($result !== FALSE && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row["Contrasenya"];
        $nombre_de_usuario = $row["Nombre"];

        if ($Contrasenya === $stored_password) {
            $_SESSION['DNI'] = $row["DNI"];
            $_SESSION['Nombre'] = $nombre_de_usuario;
            $_SESSION['bienvenida_message'] = "Bienvenido, " . $nombre_de_usuario . ". Hoy es " . date('d \d\e F \d\e Y') . ". ¿Qué realizarás hoy?";
            header("Location: registro_cuenta.php");
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró un usuario con el DNI proporcionado.";
    }

    $conn->close();
} else {
    header("Location: registro.php");
    exit();
}
?>
