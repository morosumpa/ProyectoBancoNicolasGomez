<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['DNI'])) {
    $DNI_usuario = $_SESSION['DNI'];
    $cantidad = trim($_POST["cantidad"]);
    $movimiento = isset($_POST["movimiento"]) ? strtolower($_POST["movimiento"]) : "";

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    $conn = new mysqli($servername, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta para obtener el IBAN asociado al usuario
    $sql_get_iban = "SELECT IBAN FROM Cuenta WHERE ID_usuario = (SELECT ID FROM Usuario WHERE DNI = ?)";
    $stmt_get_iban = $conn->prepare($sql_get_iban);
    $stmt_get_iban->bind_param("s", $DNI_usuario);
    
    if (!$stmt_get_iban->execute()) {
        echo "Error al ejecutar la consulta para obtener el IBAN: " . $stmt_get_iban->error;
        $stmt_get_iban->close();
        $conn->close();
        exit();
    }

    $result_get_iban = $stmt_get_iban->get_result();

    // Verificar si se obtuvo el IBAN
    if ($row = $result_get_iban->fetch_assoc()) {
        $iban = $row['IBAN'];

        echo "IBAN obtenido con éxito: $iban<br>"; // Salida de depuración
        echo "Movimiento recibido: $movimiento<br>"; // Salida de depuración

        $cantidadFloat = floatval($cantidad);

        // Operaciones según el tipo de movimiento (ingreso o gasto).
        // Actualizar el saldo en la tabla Cuenta según el tipo de movimiento.
        if ($movimiento === "ingreso") {
            $sql_update_saldo = "UPDATE Cuenta SET Saldo = Saldo + ? WHERE IBAN = ?";
        } elseif ($movimiento === "gasto") {
            $sql_update_saldo = "UPDATE Cuenta SET Saldo = Saldo - ? WHERE IBAN = ?";
        } else {
            echo "Tipo de movimiento no válido: $movimiento";
            $stmt_get_iban->close();
            $conn->close();
            exit(); // Detener la ejecución si el tipo de movimiento no es válido
        }

        $stmt_update_saldo = $conn->prepare($sql_update_saldo);
        $stmt_update_saldo->bind_param("ds", $cantidadFloat, $iban);
        if (!$stmt_update_saldo->execute()) {
            echo "Error al actualizar el saldo: " . $stmt_update_saldo->error;
            $stmt_update_saldo->close();
            $stmt_get_iban->close();
            $conn->close();
            exit();
        }
        $stmt_update_saldo->close();

        // Obtener el ID de usuario para la inserción en Movimientos
        $sql_get_user_id = "SELECT ID FROM Usuario WHERE DNI = ?";
        $stmt_get_user_id = $conn->prepare($sql_get_user_id);
        $stmt_get_user_id->bind_param("s", $DNI_usuario);
        if (!$stmt_get_user_id->execute()) {
            echo "Error al obtener el ID de usuario: " . $stmt_get_user_id->error;
            $stmt_get_iban->close();
            $conn->close();
            exit();
        }
        $result_get_user_id = $stmt_get_user_id->get_result();

        if ($row_user_id = $result_get_user_id->fetch_assoc()) {
            $user_id = $row_user_id['ID'];

            echo "ID de usuario obtenido con éxito: $user_id<br>"; // Salida de depuración

            // Registrar la transacción en la tabla Movimientos.
            $sql_insert_movimiento = "INSERT INTO Movimientos (Tipo_movimiento, Cantidad, IBAN, ID_usuario) VALUES (?, ?, ?, ?)";
            $stmt_insert_movimiento = $conn->prepare($sql_insert_movimiento);
            $stmt_insert_movimiento->bind_param("sdss", $movimiento, $cantidadFloat, $iban, $user_id);
            if (!$stmt_insert_movimiento->execute()) {
                echo "Error al insertar movimiento: " . $stmt_insert_movimiento->error;
                $stmt_insert_movimiento->close();
                $stmt_get_user_id->close();
                $stmt_get_iban->close();
                $conn->close();
                exit();
            }
            $stmt_insert_movimiento->close();

            echo "Operación realizada con éxito.";
        } else {
            echo "No se encontró un ID de usuario para el DNI: $DNI_usuario.";
        }

        $stmt_get_user_id->close();
    } else {
        echo "No se encontró un IBAN para el usuario. DNI del usuario: $DNI_usuario";
    }

    $stmt_get_iban->close();
    $conn->close();
} else {
    ob_clean();
    header("Location: inicio_sesion.php");
    exit();
}
?>
