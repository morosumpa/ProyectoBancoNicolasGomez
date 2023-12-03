<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DNI = $_POST["campo1"];
    $Contrasenya = $_POST["campo12"];

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

    // Consulta SQL para obtener la contraseña almacenada
    $sql = "SELECT * FROM Usuario WHERE DNI = '$DNI'";
    $result = $conn->query($sql);

    if ($result !== FALSE && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row["Contrasenya"]; // Ajusta el nombre de la columna según tu esquema

        // Verificar si la contraseña coincide
        if (password_verify($Contrasenya, $stored_password)) {
            // La contraseña es correcta, puedes redirigir al usuario a su área personal o hacer otras acciones
            echo "Inicio de sesión exitoso.";
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró un usuario con el DNI proporcionado.";
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si alguien intenta acceder directamente a autenticar.php, puedes redirigirlo a la página de inicio de sesión
    header("Location: iniciar_sesion.php");
    exit();
}
?>
