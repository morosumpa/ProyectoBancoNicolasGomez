<?php

session_start();

// Verificar si el usuario está autenticado (si hay una sesión activa)
if (!isset($_SESSION['Nombre'])) {
  // Redirigir a la página de inicio de sesión si no hay sesión activa
  header("Location: iniciar_sesion.php");
  exit();
}
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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Perfil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Transferencias</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Prestamos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Cambio moneda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Chat</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
  </header>
  <main>
  <div class="container">
  <?php
  // Mostrar el mensaje de bienvenida y la fecha actual
  echo $_SESSION['bienvenida_message'];
  ?>
  <div class="row row-cols-2">
    <div class="col">
        <a href="transferencia.php"> 
        ingresos o gastos
            <img src="../img/icontransferencia.png" class="img-fluid rounded-top" alt="">
        </a>
    </div>
    <div class="col">
        <a href="prestamos.php"> 
            Prestamos
            <img src="../img/iconprestamo.png" class="img-fluid rounded-top" alt="">
        </a>
    </div>
    <div class="col">
        <a href="cambio_moneeda.php"> 
            Cambio moneda
            <img src="../img/iconmoneda.png" class="img-fluid rounded-top" alt="">
        </a>
    </div>
    <div class="col">
        <a href="chat.php">
            Chat
            <img src="../img/iconchat.png" class="img-fluid rounded-top" alt="">
        </a>
    </div>
</div>


  </main>
  <footer>
    <!-- place footer here -->
  </footer>


</body>

</html>