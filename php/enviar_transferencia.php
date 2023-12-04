<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cantidad = trim($_POST["cantidad"]);
    $movimientos = isset($_POST["movimiento"]) ? $_POST["movimiento"] : "";

    $servername = "localhost";
    $username = "root";
    $password_db = "";
    $database = "DisBank";

    $conn = new mysqli($servername, $username, $password_db, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Verificar que $movimientos no está vacío antes de intentar procesarlo
    if (!empty($movimientos)) {
        //Esta función divide una cadena en un array de cadenas
        $movimientos = explode(",", $movimientos);

        foreach ($movimientos as $movimiento) {
            $movimiento = trim($movimiento);
            $cantidadFloat = floatval($cantidad);

            $sql = "INSERT INTO Movimientos (Cantidad, Tipo_movimiento) VALUES (?, ?)";
            //Esta funcion prepara una sentencia SQL para su ejecución y devuelve un objeto de declaración asociado con esa sentencia.
            $stmt = $conn->prepare($sql);
            //Esta función es utilizada en PHP para vincular parámetros a una sentencia SQL preparada. 
            $stmt->bind_param("ds", $cantidadFloat, $movimiento);

            //Esta función se utiliza para ejecutar la sentencia preparada con los parámetros vinculados.
            if ($stmt->execute()) {
                echo "Datos insertados correctamente para $movimiento<br>";
            } else {
                echo "Error al insertar datos para $movimiento: " . $stmt->error . "<br>";
            }

            $stmt->close();
        }
    } else {
        echo "No se proporcionaron movimientos.";
    }

    $conn->close();
}
