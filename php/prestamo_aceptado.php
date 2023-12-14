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
    <!-- place navbar here -->
  </header>
  <main>
  <form class="colorHeader" action="datos_admin_prestamo.php" method="post">
            <!-- Otros campos del formulario -->
            <label for="tasa_interes">Tasa de Interés:</label>
            <input class="colorcampostxt" type="text" id="tasa_interes" name="tasa_interes" required>

            <label for="plazo_meses">Plazo en Meses:</label>
            <input class="colorcampostxt" type="text" id="plazo_meses" name="plazo_meses" required>

            <label for="fecha_final">Última Fecha de Pago:</label>
            <input class="colorcampostxt" type="date" id="fecha_final" name="fecha_final" required>

            <input class="colorcampostxt" type="hidden" name="dni_usuario" value="<?php echo $dni_usuario; ?>">

            <button class="botonadm" type="submit">Aceptar Préstamo</button>
        </form>

  </main>
  
 <!-- Footer -->
 <footer class="text-center text-lg-start bg-body-tertiary text-muted">
  <!-- Copyright -->
  <div class="text-center p-4 colorfooter">
    <p>DisBank@Copyright</p>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->

</body>

</html>