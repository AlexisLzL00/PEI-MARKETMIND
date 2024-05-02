<?php
session_start(); // Inicia la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['iduser'])) {
    // El usuario no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header('Location: ../../index.php.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../conexion.php");

// Obtener el ID de usuario de la sesión
$iduser = $_SESSION['iduser'];

// Obtener la contraseña actual del formulario
$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

// Verificar si la nueva contraseña y la confirmación coinciden
if ($newPassword !== $confirmPassword) {
    echo "Las contraseñas no coinciden. Inténtalo de nuevo.";
    exit();
}

// Obtener la información del usuario de la base de datos
$stmt = $conn->prepare("SELECT contrasena FROM usuarios WHERE iduser = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if ($userData) {
    // Verificar si la contraseña actual coincide con la almacenada en la base de datos
    if (password_verify($currentPassword, $userData['contrasena'])) {
        // La contraseña actual coincide, proceder a actualizar la contraseña

        // Hashear la nueva contraseña antes de actualizarla
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $updateStmt = $conn->prepare("UPDATE usuarios SET contrasena = ? WHERE iduser = ?");
        $updateStmt->bind_param("si", $hashedPassword, $iduser);
        $updateStmt->execute();

        echo "Contraseña actualizada correctamente.";
    } else {
        echo "La contraseña actual es incorrecta. Inténtalo de nuevo.";
    }
} else {
    echo "Usuario no encontrado.";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
