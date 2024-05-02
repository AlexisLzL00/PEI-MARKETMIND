<?php
session_start();

if (!isset($_SESSION['iduser'])) {
    header('Location: ../../index.php');
    exit();
}

include("../../conexion.php");

$iduser = $_SESSION['iduser'];

$stmt = $conn->prepare("SELECT iduser, banner FROM perfil WHERE iduser = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["banner"])) {
    $uploadDir = "banner/";
    $fileName = basename($_FILES["banner"]["name"]);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        if (move_uploaded_file($_FILES["banner"]["tmp_name"], $targetFilePath)) {
            $updateStmt = $conn->prepare("UPDATE perfil SET banner = ? WHERE iduser = ?");
            $updateStmt->bind_param("si", $targetFilePath, $iduser);
            $updateStmt->execute();

            $_SESSION['banner'] = $targetFilePath;

            header('Location: ../setting.php');
            exit();
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "Solo se permiten archivos JPG, JPEG, PNG y GIF.";
    }
}
?>
