<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>

  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
    crossorigin="anonymous"></script>

  <link rel="stylesheet" href="../sass/css/style.css">
  <script defer src="../assets/js/web.js"></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="landingpage.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="perfil.php">Perfil usuarios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="transferencia.php">Transferencias</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="prestamo.php">Prestamos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="cambio_moneda.php">Cambio moneda</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="registro_cuenta.php">Registro de cuenta</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="chat.php">Chat</a>
            </li>
          </ul>
         
        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="container">
      <h1>Bienvenido, Administrador</h1>

      <!-- Código para mostrar la información del perfil del administrador -->

      <h2>Préstamos de Usuarios No Administradores</h2>
            <?php
            $servername = "localhost";
            $username = "root";
            $password_db = "";
            $database = "DisBank";

            $conn = new mysqli($servername, $username, $password_db, $database);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            $adminDNI = "12345678A"; // DNI del administrador

            // Verificar si se ha enviado un formulario para actualizar el estado
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST["aceptar"])) {
                    $estadoNuevo = 1; // 1 para "Aprobado"
                } elseif (isset($_POST["rechazar"])) {
                    $estadoNuevo = 0; // 0 para "Rechazado"
                }

                $dni_usuario = $_POST["dni_usuario"];

                // Actualizar el estado en la base de datos
                $updateSql = "UPDATE Prestamos SET Estado = ? WHERE DNI_usuario = ?";
                $stmt = $conn->prepare($updateSql);
                $stmt->bind_param("is", $estadoNuevo, $dni_usuario);
                $stmt->execute();
                $stmt->close();
            }

            // Consulta SQL preparada
            $sql = "SELECT * FROM Prestamos WHERE DNI_usuario != ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $adminDNI);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica errores en la consulta SQL
            if (!$result) {
                echo "Error en la consulta: " . $conn->error;
            } else {
                // Mostrar los resultados
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>";
                        echo "<p>DNI Usuario: " . $row["DNI_usuario"] . "<br>" .
                            "Monto Pedido: " . $row["Monto_pedido"] . "<br>" .
                            "Descripción: " . $row["Descripcion"] . "<br>" .
                            "Fecha Inicio: " . $row["Fecha_inicio"] . "<br>" .
                            "<br></p>";

                        // Agregar botones para aceptar y rechazar
                        echo "<input type='hidden' name='dni_usuario' value='" . $row["DNI_usuario"] . "'>";
                        echo "<button type='submit' name='aceptar' class='btn btn-success'>Aceptar</button>";
                        echo "<button type='submit' name='rechazar' class='btn btn-danger'>Rechazar</button>";
                        echo "</form><br>";
                    }
                } else {
                    echo "No hay préstamos para usuarios no administradores.";
                }
            }

            $stmt->close();
            $conn->close();
            ?>
    </div>
  </main>
  <footer>
    <!-- place footer here -->
  </footer>

</body>

</html>