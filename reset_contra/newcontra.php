<?php
require_once 'config.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Consultar la base de datos para obtener el usuario asociado al token
    $query = "SELECT id_usuario FROM resetcontra WHERE token = :token AND creado_en >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':token', $token, PDO::PARAM_STR);
    $statement->execute();
    $resetRequest = $statement->fetch(PDO::FETCH_ASSOC);

    if ($resetRequest) {
        // Actualizar la contraseña del usuario en la base de datos
        $idUsuario = $resetRequest['id_usuario'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "UPDATE usuarios SET contrasena = :contrasena WHERE iduser = :id_usuario";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':contrasena', $hashedPassword, PDO::PARAM_STR);
        $statement->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
        $statement->execute();

        // Eliminar el token de restablecimiento de contraseña de la base de datos
        $query = "DELETE FROM resetcontra WHERE token = :token";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':token', $token, PDO::PARAM_STR);
        $statement->execute();

        echo "¡Tu contraseña ha sido restablecida con éxito!";
    } else {
        echo "El enlace de restablecimiento de contraseña no es válido o ha caducado.";
    }
} else {
    echo "Acceso no válido.";
}
?>
