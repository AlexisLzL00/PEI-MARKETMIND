<?php
require_once 'config.php';

// Verificar si se proporcionó un token en la URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consultar la base de datos para validar el token
    $query = "SELECT id_usuario FROM resetcontra WHERE token = :token AND creado_en >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':token', $token, PDO::PARAM_STR);
    $statement->execute();
    $resetRequest = $statement->fetch(PDO::FETCH_ASSOC);

    if ($resetRequest) {
        // Mostrar formulario para restablecer la contraseña
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Restablecer contraseña</title>
        </head>
        <body>
            <h1>Restablecer contraseña</h1>
            <form action="newcontra.php" method="post">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <label for="password">Nueva contraseña:</label><br>
                <input type="password" id="password" name="password" required><br><br>
                <button type="submit">Restablecer contraseña</button>
            </form>
        </body>
        </html>
        <?php
    } else {
        // Token no válido o caducado
        echo "El enlace de restablecimiento de contraseña no es válido o ha caducado.";
    }
} else {
    // No se proporcionó ningún token en la URL
    echo "No se ha proporcionado un token de restablecimiento de contraseña.";
}
?>
