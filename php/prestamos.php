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
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="landingpage.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="perfil.php">Perfil</a>
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
      <div class="row row-cols-1 ">
        <div class="col-12">
          <p>Prestamos</p>
          <img src="../img/iconprestamo.png" class="img-fluid rounded-top imgajustada" alt="">
          <p>Introduzca el motivo por el que esta pidiendo un préstamo y la cantidad de este.</p>

          <form class="colorforms" action="enviar_prestamo.php" method="post">
            <div class="mb-3">
              <label for="descripcion" class="form-label">Descripción:</label>
              <input class="form-control colorcampostxt" type="text" id="descripcion" name="descripcion" required>
            </div>

            <div class="mb-3">
              <label for="cantidad" class="form-label">Cantidad:</label>
              <input class="form-control colorcampostxt" type="text" id="cantidad" name="cantidad" required>
            </div>

            <input class="btn btn-primary botonforms" type="submit" value="Enviar">
          </form>

        </div>
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