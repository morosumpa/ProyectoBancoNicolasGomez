<!DOCTYPE html>
<html lang="es">
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
<header>
    <div class="colorHeader">
  <img src="../img/DisBankBanner.png">
</div>
  </header>
<body>
  <div class="container">
    <h2>Registro de Cuenta</h2>

    <form class="colorforms" action="generarIban.php" method="post">
  <div class="mb-3">
    <label for="saldo" class="form-label">Saldo Inicial:</label>
    <input class="form-control colorcampostxt" type="number" name="saldo" required>
  </div>

  <div class="mb-3">
    <label for="tipo_cuenta" class="form-label">Tipo de Cuenta:</label>
    <select class="form-control colorcampostxt" name="tipo_cuenta" required>
      <option class="colorcampostxt" value="CuentaCorriente">Cuenta Corriente</option>
      <option class="colorcampostxt" value="CuentaAhorro">Cuenta ahorro</option>
    </select>
  </div>

  <input class="btn btn-primary botonforms" type="submit" value="Registrar Cuenta">
</form>

    </div>
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
