<?php
session_start();

if (!isset($_SESSION['DNI'])) {
  echo "Error: DNI de usuario no encontrado en la sesión.";
  exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "DisBank";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

$dni_usuario = $_SESSION['DNI'];

// Obtener información del Usuario
$sql_usuario = "SELECT * FROM Usuario WHERE DNI = ?";
$stmt_usuario = $conn->prepare($sql_usuario);

if (!$stmt_usuario) {
  die("Error al preparar la consulta del Usuario: " . $conn->error);
}

$stmt_usuario->bind_param("s", $dni_usuario);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$usuario = $result_usuario->fetch_assoc();
$stmt_usuario->close();

// Obtener información de la Cuenta
$sql_cuenta = "SELECT * FROM Cuenta WHERE ID_usuario = (SELECT ID FROM Usuario WHERE DNI = ?)";
$stmt_cuenta = $conn->prepare($sql_cuenta);

if (!$stmt_cuenta) {
  die("Error al preparar la consulta de la Cuenta: " . $conn->error);
}

$stmt_cuenta->bind_param("s", $dni_usuario);
$stmt_cuenta->execute();
$result_cuenta = $stmt_cuenta->get_result();
$cuenta = $result_cuenta->fetch_assoc();
$stmt_cuenta->close();

// Obtener información de los Movimientos
$sql_movimientos = "SELECT * FROM Movimientos WHERE ID_usuario = (SELECT ID FROM Usuario WHERE DNI = ?)";
$stmt_movimientos = $conn->prepare($sql_movimientos);

if (!$stmt_movimientos) {
  die("Error al preparar la consulta de Movimientos: " . $conn->error);
}

$stmt_movimientos->bind_param("s", $dni_usuario);
$stmt_movimientos->execute();
$result_movimientos = $stmt_movimientos->get_result();
$movimientos = $result_movimientos->fetch_all(MYSQLI_ASSOC);
$stmt_movimientos->close();

// Obtener información del CambioMoneda
$sql_cambio_moneda = "SELECT * FROM CambioMoneda WHERE IBAN_origen IN (SELECT IBAN FROM Cuenta WHERE ID_usuario = (SELECT ID FROM Usuario WHERE DNI = ?))";
$stmt_cambio_moneda = $conn->prepare($sql_cambio_moneda);

if (!$stmt_cambio_moneda) {
  die("Error al preparar la consulta de CambioMoneda: " . $conn->error);
}

$stmt_cambio_moneda->bind_param("s", $dni_usuario);
$stmt_cambio_moneda->execute();
$result_cambio_moneda = $stmt_cambio_moneda->get_result();
$cambio_moneda = $result_cambio_moneda->fetch_assoc();
$stmt_cambio_moneda->close();

// Obtener información de los Prestamos
$sql_prestamos = "SELECT * FROM Prestamos WHERE DNI_usuario = ?";
$stmt_prestamos = $conn->prepare($sql_prestamos);

if (!$stmt_prestamos) {
  die("Error al preparar la consulta de Prestamos: " . $conn->error);
}

$stmt_prestamos->bind_param("s", $dni_usuario);
$stmt_prestamos->execute();
$result_prestamos = $stmt_prestamos->get_result();
$prestamos = $result_prestamos->fetch_all(MYSQLI_ASSOC);
$stmt_prestamos->close();

// Cierra la conexión
$conn->close();
?>

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
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

  <link rel="stylesheet" href="../sass/css/style.css">
  <script defer src="../assets/js/web.js"></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light colorHeader">
      <div class="container-fluid">
      
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item colorcampostxt">
              <a class="nav-link active" aria-current="page" href="landingpage.php">Home</a>
            </li>
            <li class="nav-item colorcampostxt">
              <a class="nav-link active" aria-current="page" href="perfil.php">Perfil</a>
            </li>
            <li class="nav-item colorcampostxt">
              <a class="nav-link active" aria-current="page" href="transferencia.php">Transferencias</a>
            </li>
            <li class="nav-item colorcampostxt">
              <a class="nav-link active" aria-current="page" href="prestamo.php">Prestamos</a>
            </li>
            <li class="nav-item colorcampostxt">
              <a class="nav-link active" aria-current="page" href="cambio_moneda.php">Cambio moneda</a>
            </li>
            <li class="nav-item colorcampostxt">
              <a class="nav-link active" aria-current="page" href="registro_cuenta.php">Registro de cuenta</a>
            </li>
            <li class="nav-item colorcampostxt">
              <a class="nav-link active" aria-current="page" href="chat.php">Chat</a>
            </li>
          </ul>

        </div>
      </div>
    </nav>
  </header>
  <main>
    <div class="container">
      <h1>Perfil del Usuario</h1>
      <div class="alert " role="alert">
        <?php echo $_SESSION['bienvenida_message']; ?>
      </div>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/X11KScXu9pg?si=Q16vdnyc9cQlDWrr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
      <!-- Mostrar información del Usuario -->
      <div class="tablapar">
        <h2>Información del Usuario</h2>
        <pre><?php print_r($usuario); ?></pre>
      </div>

      <!-- Mostrar información de la Cuenta -->
      <div class="tablaimpar">
        <h2>Información de la Cuenta</h2>
        <pre><?php print_r($cuenta); ?></pre>
      </div>

      <!-- Mostrar información de los Movimientos -->
      <div class="tablapar">
        <h2>Movimientos</h2>
        <pre><?php print_r($movimientos); ?></pre>
      </div>

      <!-- Mostrar información del CambioMoneda -->
      <div class="tablaimpar">
        <h2>Cambio de Moneda</h2>
        <pre><?php print_r($cambio_moneda); ?></pre>
      </div>

      <!-- Mostrar información de los Prestamos -->
      <div class="tablapar">
        <h2>Préstamos</h2>
        <pre><?php print_r($prestamos); ?></pre>
      </div>
    </div>
  </main>
  <!-- Footer -->
  <footer class="text-center text-lg-start bg-body-tertiary text-muted">
    <!-- Copyright -->
    <div class="text-center p-4 footerestandar">
      <p>DisBank@Copyright</p>
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
</body>

</html>