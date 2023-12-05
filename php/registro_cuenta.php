<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Cuenta</title>
</head>
<body>
    <h2>Registro de Cuenta</h2>

    <form action="generarIban.php" method="post">
        <label for="saldo">Saldo Inicial:</label>
        <input type="number" name="saldo" required>

        <br>

        <label for="tipo_cuenta">Tipo de Cuenta:</label>
        <select name="tipo_cuenta" required>
            <option value="CuentaCorriente">Cuenta Corriente</option>
            <!-- Puedes agregar más opciones según tus necesidades -->
        </select>

        <br>

        <input type="submit" value="Registrar Cuenta">
    </form>
</body>
</html>
