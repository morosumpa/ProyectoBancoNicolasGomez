<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function generarIBAN($DNI)
{
    $primeras_letras_binario = substr(decbin(crc32($DNI)), 0, 4);
    $iban = "ES" . $primeras_letras_binario . "1234";
    return $iban;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['DNI'])) {
    $DNI_usuario = $_SESSION['DNI'];
    $saldo = trim($_POST["saldo"]);
    $tipo_cuenta = $_POST["tipo_cuenta"];

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    $conn = new mysqli($servername, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar la existencia del usuario
    $sql_check_user = "SELECT ID FROM Usuario WHERE DNI = ?";
    $stmt_check_user = $conn->prepare($sql_check_user);
    $stmt_check_user->bind_param("s", $DNI_usuario);
    $stmt_check_user->execute();
    $stmt_check_user->store_result();

    if ($stmt_check_user->num_rows > 0) {
        // Usuario existe, puedes proceder con la consulta para obtener el IBAN
        echo "El usuario con DNI $DNI_usuario existe. ";

        // Obtener el IBAN del usuario
        $sql_get_iban = "SELECT IBAN FROM Cuenta WHERE ID_usuario = (SELECT ID FROM Usuario WHERE DNI = ?)";
        $stmt_get_iban = $conn->prepare($sql_get_iban);
        $stmt_get_iban->bind_param("s", $DNI_usuario);
        $stmt_get_iban->execute();
        $stmt_get_iban->bind_result($iban);

        if ($stmt_get_iban->fetch()) {
            echo "IBAN generado para el usuario con DNI $DNI_usuario: $iban";
        } else {
            echo "No se encontró el IBAN para el usuario con DNI $DNI_usuario. Mensaje de error: " . $stmt_get_iban->error;
        }

        $stmt_get_iban->close();
    } else {
        echo "El usuario con DNI $DNI_usuario no existe.";
    }

    // Verificar si ya tiene una cuenta
    $sql_check_cuenta = "SELECT ID FROM Cuenta WHERE ID_usuario = ?";
    $stmt_check_cuenta = $conn->prepare($sql_check_cuenta);
    $stmt_check_cuenta->bind_param("i", $user_id);
    $stmt_check_cuenta->execute();
    $stmt_check_cuenta->store_result();

    if ($stmt_check_cuenta->num_rows > 0) {
        echo "El usuario ya tiene una cuenta.";
    } else {
        // Generar el IBAN
        $iban = generarIBAN($DNI_usuario);

        // Insertar datos en la tabla Cuenta
        $sql_insert_cuenta = "INSERT INTO Cuenta (IBAN, Saldo, Tipo_cuenta, Estado_cuenta, ID_usuario) VALUES (?, ?, ?, 'Activa', (SELECT ID FROM Usuario WHERE DNI = ?))";
        $stmt_insert_cuenta = $conn->prepare($sql_insert_cuenta);
        $stmt_insert_cuenta->bind_param("ssds", $iban, $saldo, $tipo_cuenta, $DNI_usuario);
        $stmt_insert_cuenta->execute();

        echo "Cuenta creada para el usuario con DNI $DNI_usuario. IBAN: $iban";

        $stmt_insert_cuenta->close();

        // Redireccionar después de insertar la cuenta
        header("Location: landingpage.php");

        exit();
    }

    $stmt_check_user->close();
    $conn->close();
} else {
    echo "No se puede generar el IBAN, el usuario no ha iniciado sesión.";
}
?>
