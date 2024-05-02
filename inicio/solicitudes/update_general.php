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
$stmt = $conn->prepare("SELECT u.iduser, u.username, u.nombre, u.correo, u.foto_perfil, p.biografia, p.banner, u.telefono, u.pais
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
    $username = $_POST['username'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    // Procesar la imagen de perfil si se cargó
    if ($_FILES['profile_picture']['name']) {
        // Ruta donde se almacenarán las imágenes de perfil
        $uploadDir = "fotosperf/";
        $fileName = basename($_FILES["profile_picture"]["name"]);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Permitir solo ciertos formatos de imagen
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Subir la imagen al servidor
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFilePath)) {
                // Actualizar la ruta de la imagen en la base de datos
                $updateImgStmt = $conn->prepare("UPDATE usuarios SET foto_perfil = ? WHERE iduser = ?");
                $updateImgStmt->bind_param("si", $targetFilePath, $iduser);
                $updateImgStmt->execute();

                // Actualizar la ruta de la imagen en la variable de sesión para reflejar el cambio en la página actual
                $_SESSION['foto_perfil'] = $targetFilePath;

                // Redireccionar a la misma página para evitar reenvío del formulario al recargar la página
                header('Location: setting.php');
                exit();
            } else {
                echo "Error al subir la imagen.";
            }
        } else {
            echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
        }
    }

    // Actualizar la información en la tabla de usuarios (sin la imagen)
    $updateUserStmt = $conn->prepare("UPDATE usuarios SET username = ?, nombre = ?, correo = ? WHERE iduser = ?");
    $updateUserStmt->bind_param("sssi", $username, $nombre, $correo, $iduser);
    $updateUserStmt->execute();

    // Redireccionar a la misma página para evitar reenvío del formulario al recargar la página
    header('Location: ../perfil');
    exit();
}
?>
