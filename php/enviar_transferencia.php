<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['DNI'])) {
    $DNI_usuario = $_SESSION['DNI'];
    $cantidad = trim($_POST["cantidad"]);
    $movimiento = isset($_POST["movimiento"]) ? $_POST["movimiento"] : "";

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    $conn = new mysqli($servername, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $cantidadFloat = floatval($cantidad);

    if ($movimiento === "ingreso" || $movimiento === "gasto") {
        $sql_get_iban = "SELECT IBAN FROM Cuenta WHERE ID_usuario = ?";
        $stmt_get_iban = $conn->prepare($sql_get_iban);
        echo "ID del usuario antes de la consulta: " . $DNI_usuario . "<br>";
        $stmt_get_iban->bind_param("i", $DNI_usuario);
        $stmt_get_iban->execute();
        $result_get_iban = $stmt_get_iban->get_result();
        
        if ($stmt_get_iban->execute()) {
            $result_get_iban = $stmt_get_iban->get_result();
        
            if ($row = $result_get_iban->fetch_assoc()) {
                $iban = $row['IBAN'];
                echo "IBAN obtenido con éxito: $iban";
            } else {
                echo "No se encontró un IBAN para el usuario.";
            }
        } else {
            echo "Error en la ejecución de la consulta: " . $stmt_get_iban->error;
        }

        
        if ($row = $result_get_iban->fetch_assoc()) {
            $iban = $row['IBAN'];

            // Operaciones según el tipo de movimiento (ingreso o gasto).
            // Actualizar el saldo en la tabla Cuenta según el tipo de movimiento.
            if ($movimiento === "ingreso") {
                $sql_update_saldo = "UPDATE Cuenta SET Saldo = Saldo + ? WHERE ID_usuario = ?";
            } elseif ($movimiento === "gasto") {
                $sql_update_saldo = "UPDATE Cuenta SET Saldo = Saldo - ? WHERE ID_usuario = ?";
            }

            $stmt_update_saldo = $conn->prepare($sql_update_saldo);
            $stmt_update_saldo->bind_param("ds", $cantidadFloat, $DNI_usuario);
            $stmt_update_saldo->execute();
            $stmt_update_saldo->close();

            // Registrar la transacción en la tabla Movimientos.
            $sql_insert_movimiento = "INSERT INTO Movimientos (Tipo_movimiento, Cantidad, IBAN) VALUES (?, ?, ?)";
            $stmt_insert_movimiento = $conn->prepare($sql_insert_movimiento);
            $stmt_insert_movimiento->bind_param("sds", $movimiento, $cantidadFloat, $iban);
            $stmt_insert_movimiento->execute();
            $stmt_insert_movimiento->close();

            echo "Operación realizada con éxito.";

        } else {
            echo "Error al obtener el IBAN del usuario.<br>";
            $sql_get_iban = "SELECT IBAN FROM Cuenta WHERE ID_usuario = ?";
            echo $sql_get_iban . "<br>";
            echo "ID del usuario: " . $DNI_usuario;

        }

        $stmt_get_iban->close();
    } else {
        echo "Tipo de movimiento no válido.";
    }

    $conn->close();
} else {
    header("Location: inicio_sesion.php");
    exit();
}
?>
