<?php
session_start(); // Inicia la sesión

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['iduser'])) {
    // El usuario no ha iniciado sesión, redirigir al formulario de inicio de sesión
    header('Location: ../../index.php');
    exit();
}

// Incluir el archivo de conexión a la base de datos
include("../../conexion.php");

// Obtener el ID de usuario de la sesión
$iduser = $_SESSION['iduser'];

// Obtener la información del usuario de la base de datos (incluyendo telefono y pais)
$stmt = $conn->prepare("SELECT u.iduser, u.foto_perfil, p.biografia, u.telefono, u.pais
                        FROM usuarios u
                        LEFT JOIN perfil p ON u.iduser = p.iduser
                        WHERE u.iduser = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verificar si se recibió un formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $bio = $_POST['biografia'];
    $telefono = $_POST['telefono'];
    $pais = $_POST['pais'];

    // Actualizar la información en la tabla de usuarios
    $updateUserStmt = $conn->prepare("UPDATE usuarios SET telefono = ?, pais = ? WHERE iduser = ?");
    $updateUserStmt->bind_param("ssi", $telefono, $pais, $iduser);
    $updateUserStmt->execute();

    // Actualizar la información en la tabla de perfil
    $updateProfileStmt = $conn->prepare("UPDATE perfil SET biografia = ? WHERE iduser = ?");
    $updateProfileStmt->bind_param("si", $bio, $iduser);
    $updateProfileStmt->execute();

    // Redireccionar a la misma página para evitar reenvío del formulario al recargar la página
    header('Location: ../perfil');
    exit();
}
?>
