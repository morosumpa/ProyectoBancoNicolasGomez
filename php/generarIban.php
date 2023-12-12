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

    // Generar el IBAN
    $ibanGenerado = generarIBAN($DNI_usuario, $conn);

    // Establecer las variables de sesión relacionadas con la cuenta
    $_SESSION['iban_cuenta'] = $ibanGenerado;
    $_SESSION['saldo_cuenta'] = $saldo;
  
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

        // Actualizar el saldo en la tabla Cuenta
        $sql_update_saldo = "UPDATE Cuenta SET Saldo = Saldo + ? WHERE ID_usuario = ?";
        $stmt_update_saldo = $conn->prepare($sql_update_saldo);
        $stmt_update_saldo->bind_param("ds", $saldo, $DNI_usuario);
        $stmt_update_saldo->execute();
        $stmt_update_saldo->close();
    } else {
        // Generar el IBAN
        $iban = generarIBAN($DNI_usuario, $conn);

        // Insertar datos en la tabla Cuenta
        $sql_insert_cuenta = "INSERT INTO Cuenta (IBAN, Saldo, Tipo_cuenta, Estado_cuenta, ID_usuario) VALUES (?, ?, ?, 'Activa', (SELECT ID FROM Usuario WHERE DNI = ?))";
        $stmt_insert_cuenta = $conn->prepare($sql_insert_cuenta);
        $stmt_insert_cuenta->bind_param("ssds", $iban, $saldo, $tipo_cuenta, $DNI_usuario);
        $stmt_insert_cuenta->execute();

        echo "Cuenta creada para el usuario con DNI $DNI_usuario. IBAN generado: $iban. Saldo inicial: $saldo.";

        // Redirigir a landingpage.php
        header("Location: landingpage.php");
        exit();
    }

    $stmt_check_cuenta->close();
    $stmt_insert_cuenta->close();
    $conn->close();
} else {
    echo "No se puede generar la cuenta, el usuario no ha iniciado sesión.";
}
?>
