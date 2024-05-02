<?php

// Configuración de la base de datos
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "Progrsolab";

// Intentar conectarse a la base de datos
try {
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPassword);
    // Habilitar mensajes de error de PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // En caso de error al conectar, mostrar mensaje de error y terminar el script
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

?>
