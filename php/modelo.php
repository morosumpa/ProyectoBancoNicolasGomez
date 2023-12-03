<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $campo1 = $_POST["campo1"];
    $campo2 = $_POST["campo2"];
    $campo3 = $_POST["campo3"];
    $campo4 = $_POST["campo4"];
    $campo5 = $_POST["campo5"];
    $campo6 = $_POST["campo6"];
    $campo7 = $_POST["campo7"];
    $campo8 = $_POST["campo8"];
    $campo9 = $_POST["campo9"];
    $campo10 = $_POST["campo10"];
    $campo11 = $_POST["campo11"];
    $campo12 = $_POST["campo12"];

    // Configuración de la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "DisBank";

    // Crear la conexión
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para insertar datos en la tabla Usuario
    $sql = "INSERT INTO Usuario (DNI, Nombre, Apellidos, Email, Fecha_nac, Foto, Direccion, Codigo_postal, Ciudad, Provincia, Pais, Contrasenya) VALUES ('$campo1', '$campo2', '$campo3', '$campo4', '$campo5', '$campo6', '$campo7', '$campo8', '$campo9', '$campo10', '$campo11', '$campo12')";

    // Ejecutar la consulta
    if ($conn->query($sql) === TRUE) {
        echo "Datos almacenados correctamente en la base de datos.";

        // Consultar los datos recién insertados
        $sql_select = "SELECT * FROM Usuario WHERE DNI = '$campo1'";
        $result = $conn->query($sql_select);

        // Verificar si la consulta SELECT fue exitosa
        if ($result !== FALSE) {
            // Verificar si hay filas de resultados
            if ($result->num_rows > 0) {
                // Mostrar los datos consultados
                while ($row = $result->fetch_assoc()) {
                    echo "<br>";
                    echo "DNI: " . $row["DNI"] . "<br>";
                    echo "Nombre: " . $row["Nombre"] . "<br>";
                    echo "Apellidos: " . $row["Apellidos"] . "<br>";
                    echo "Email: " . $row["Email"] . "<br>";
                    echo "Fecha de Nacimiento: " . $row["Fecha_nac"] . "<br>";
                    echo "Foto: " . $row["Foto"] . "<br>";
                    echo "Dirección: " . $row["Direccion"] . "<br>";
                    echo "Código Postal: " . $row["Codigo_postal"] . "<br>";
                    echo "Ciudad: " . $row["Ciudad"] . "<br>";
                    echo "Provincia: " . $row["Provincia"] . "<br>";
                    echo "País: " . $row["Pais"] . "<br>";
                    echo "Contraseña: " . $row["Contrasenya"] . "<br>";
                }
            } else {
                echo "No se encontraron resultados para el DNI: $campo1";
            }
        } else {
            echo "Error en la consulta SELECT: " . $conn->error;
        }
    } else {
        echo "Error al almacenar datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si alguien intenta acceder directamente a procesar.php, puedes redirigirlo a la página del formulario
    header("Location: index.html");
    exit();
}
?>
