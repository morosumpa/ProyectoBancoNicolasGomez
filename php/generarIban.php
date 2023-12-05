<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generarIBAN($DNI, $conn)
{
    $iban = "ES" . substr(decbin(crc32($DNI)), 0, 4) . "1234";

    // Verificar si el IBAN ya existe en la base de datos
    $sql_check_iban = "SELECT ID FROM Cuenta WHERE IBAN = ?";
    $stmt_check_iban = $conn->prepare($sql_check_iban);
    $stmt_check_iban->bind_param("s", $iban);
    $stmt_check_iban->execute();
    $stmt_check_iban->store_result();

    // Si el IBAN ya existe, genera uno nuevo hasta que sea único
    $counter = 0;
    while ($stmt_check_iban->num_rows > 0 && $counter < 10) {
        $counter++;
        $iban = "ES" . substr(decbin(crc32($DNI . $counter)), 0, 4) . "1234";
        $stmt_check_iban->bind_param("s", $iban);
        $stmt_check_iban->execute();
        $stmt_check_iban->store_result();
    }

    $stmt_check_iban->close();

    if ($counter >= 10) {
        // Evitar un bucle infinito si algo sale mal
        die("Error: No se pudo generar un IBAN único después de 10 intentos.");
    }

    return $iban;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['DNI'])) {
    $DNI_usuario = $_SESSION['DNI'];

    // Verificar si los índices están definidos antes de usarlos
    $saldo = isset($_POST["saldo"]) ? trim($_POST["saldo"]) : "";
    $tipo_cuenta = isset($_POST["tipo_cuenta"]) ? $_POST["tipo_cuenta"] : "";

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    $conn = new mysqli($servername, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Resto del código...

    // Verificar si ya tiene una cuenta
    $sql_check_cuenta = "SELECT ID FROM Cuenta WHERE ID_usuario = ?";
    $stmt_check_cuenta = $conn->prepare($sql_check_cuenta);
    $stmt_check_cuenta->bind_param("s", $DNI_usuario);
    $stmt_check_cuenta->execute();
    $stmt_check_cuenta->store_result();

    if ($stmt_check_cuenta->num_rows > 0) {
        echo "El usuario ya tiene una cuenta.";
    } else {
        // Generar el IBAN
        $iban = generarIBAN($DNI_usuario, $conn);

        // Insertar datos en la tabla Cuenta
        $sql_insert_cuenta = "INSERT INTO Cuenta (IBAN, Saldo, Tipo_cuenta, Estado_cuenta, ID_usuario) VALUES (?, ?, ?, 'Activa', (SELECT ID FROM Usuario WHERE DNI = ?))";
        $stmt_insert_cuenta = $conn->prepare($sql_insert_cuenta);
        $stmt_insert_cuenta->bind_param("ssds", $iban, $saldo, $tipo_cuenta, $DNI_usuario);
        $stmt_insert_cuenta->execute();

        echo "El usuario con DNI $DNI_usuario. IBAN: $iban. Saldo: $saldo.";

        $stmt_insert_cuenta->close();

       

        exit();
    }

    $stmt_check_user->close();
    $conn->close();
} else {
    echo "No se puede generar el IBAN, el usuario no ha iniciado sesión.";
}
?>
