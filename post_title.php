<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener el ID de la publicación desde la solicitud GET
$postId = $_GET['id'];

// Consultar la base de datos para obtener el título de la publicación
$query = "SELECT titulo FROM post WHERE id = $postId";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  echo $row['titulo']; // Devolver el título de la publicación
} else {
  echo 'Título no encontrado';
}

// Cerrar la conexión
$conn->close();
?>
