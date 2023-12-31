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
    <title>Tu Título</title>
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
        <nav class="navbar navbar-expand-lg navbar-light colorHeader">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
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
            <?php
            // Mostrar el mensaje de bienvenida y la fecha actual
            echo $_SESSION['bienvenida_message'];
            ?>
            <div class="row row-cols-2">
                <div class="col" id="transferenciaSection">
                    ingresos o gastos
                 
                    <a href="transferencia.php">
                        <img src="../img/icontransferencia.png" class="img-fluid rounded-top imgajustada" alt="">
                    </a>
                </div>   <button onclick="toggleVisibility('transferenciaSection')">Mostrar/Ocultar transferencias</button>
                <div class="col" id="prestamoSection">
                    Prestamos
                    
                    <a href="prestamos.php">
                        <img src="../img/iconprestamo.png" class="img-fluid rounded-top imgajustada" alt="">
                    </a>
                </div><button onclick="toggleVisibility('prestamoSection')">Mostrar/Ocultar prestamos</button>
                <div class="col" id="cambioMonedaSection">
                    Cambio moneda
                   
                    <a href="cambio_moneda.php">
                        <img src="../img/iconmoneda.png" class="img-fluid rounded-top imgajustada" alt="">
                    </a>
                </div> <button onclick="toggleVisibility('cambioMonedaSection')">Mostrar/Ocultar cambiar moneda</button>
                <div class="col" id="chatSection">
                    Chat
                   
                    <a href="chat.php">
                        <img src="../img/iconchat.png" class="img-fluid rounded-top imgajustada" alt="">
                    </a>
                </div> <button onclick="toggleVisibility('chatSection')">Mostrar/Ocultar chat</button>
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
    <script>
        function toggleVisibility(sectionId) {
            var section = document.getElementById(sectionId);
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }
    </script>
</body>

</html>
