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
  <form action="modelo.php" method="post">
        <label for="campo1">DNI:</label>
        <input type="text" id="campo1" name="campo1" required>

        <label for="campo2">Nombre:</label>
        <input type="text" id="campo2" name="campo2" required>

        <label for="campo3">Apellidos:</label>
        <input type="text" id="campo3" name="campo3" required>

        <label for="campo4">Email:</label>
        <input type="text" id="campo4" name="campo4" required>

        <label for="campo5">Fecha de nacimiento:</label>
        <input type="text" id="campo5" name="campo5" required>

        <label for="campo6">Foto:</label>
        <input type="text" id="campo6" name="campo6" required>

        <label for="campo7">Dirección:</label>
        <input type="text" id="campo7" name="campo7" required>

        <label for="campo8">Codigo postal:</label>
        <input type="text" id="campo8" name="campo8" required>

        <label for="campo9">Ciudad:</label>
        <input type="text" id="campo9" name="campo9" required>

        <label for="campo10">Provincia:</label>
        <input type="text" id="campo10" name="campo10" required>

        <label for="campo11">País:</label>
        <input type="text" id="campo11" name="campo11" required>

        <label for="campo12">Contraseña:</label>
        <input type="text" id="campo12" name="campo12">

        <input type="submit" value="Enviar">
    </form>

  </main>
  <footer>
    <!-- place footer here -->
  </footer>


</body>

</html>