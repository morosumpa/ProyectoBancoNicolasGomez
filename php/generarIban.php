<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generarIBAN($DNI, $conn)
{
    $iban = "ES" . substr(decbin(crc32($DNI)), 0, 4) . "1234";
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
  
    // Verificar si ya tiene una cuenta
    $sql_check_cuenta = "SELECT IBAN, Saldo FROM Cuenta WHERE ID_usuario = ?";
    $stmt_check_cuenta = $conn->prepare($sql_check_cuenta);
    $stmt_check_cuenta->bind_param("s", $DNI_usuario);
    $stmt_check_cuenta->execute();
    $result_check_cuenta = $stmt_check_cuenta->get_result();

    if ($row = $result_check_cuenta->fetch_assoc()) {
        $iban = $row['IBAN'];
        echo "El usuario ya tiene una cuenta. IBAN existente: $iban.";

        // Operaciones de sumar o restar saldo
        $saldo_actual = $row['Saldo'];
        $nuevo_saldo = $saldo_actual + $saldo;
        echo " Saldo actual: $saldo_actual. Nuevo saldo después de la suma: $nuevo_saldo.";

    } else {
        // Generar el IBAN
        $iban = generarIBAN($DNI_usuario, $conn);

        // Insertar datos en la tabla Cuenta
        $sql_insert_cuenta = "INSERT INTO Cuenta (IBAN, Saldo, Tipo_cuenta, Estado_cuenta, ID_usuario) VALUES (?, ?, ?, 'Activa', (SELECT ID FROM Usuario WHERE DNI = ?))";
        $stmt_insert_cuenta = $conn->prepare($sql_insert_cuenta);
        $stmt_insert_cuenta->bind_param("ssds", $iban, $saldo, $tipo_cuenta, $DNI_usuario);
        $stmt_insert_cuenta->execute();

        echo "Cuenta creada para el usuario con DNI $DNI_usuario. IBAN generado: $iban. Saldo inicial: $saldo.";
    }
    header("Location: landingpage.php");
    $stmt_check_cuenta->close();
    $stmt_insert_cuenta->close();
    $conn->close();
} else {
    echo "No se puede generar la cuenta, el usuario no ha iniciado sesión.";
}
?>
