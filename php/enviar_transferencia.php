<?php
session_start();

include('generarIban.php');

var_dump($_SESSION);

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
        $stmt_get_iban->bind_param("i", $DNI_usuario);
        $stmt_get_iban->execute();
        $result_get_iban = $stmt_get_iban->get_result();
        
        if ($row = $result_get_iban->fetch_assoc()) {
            $iban = $row['IBAN'];


        } else {
            echo "Error al obtener el IBAN del usuario.<br>";
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
