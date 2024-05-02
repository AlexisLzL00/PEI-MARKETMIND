<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['iduser'])) {
    // Redirige al formulario de inicio de sesión si no ha iniciado sesión
    header('Location: ../index.php');
    exit();
}

// Incluye el archivo de conexión a la base de datos
include("../conexion.php");

// Obtén el ID de usuario de la sesión
$iduser = $_SESSION['iduser'];

// Obtén la información del usuario de la base de datos (incluyendo datos del perfil)
$stmt = $conn->prepare("SELECT u.iduser, u.username, u.nombre, u.correo, u.foto_perfil, p.biografia, p.banner, u.telefono, u.pais
                        FROM usuarios u
                        LEFT JOIN perfil p ON u.iduser = p.iduser
                        WHERE u.iduser = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Cierra la conexión a la base de datos
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Perfil de Usuario</title>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <!-- CSS personalizado -->
  <link rel="stylesheet" href="css/user.css" />
</head>
<body>
  <div class="header__wrapper">
    <!-- Contenedor del banner -->
    <div class="banner__container">
      <!-- Aquí puedes cargar el banner del usuario -->
      <img src="IMG/A.png" alt="Banner del usuario" />
    </div>
    <div class="cols__container">
      <!-- Columna izquierda: Información del usuario -->
      <div class="left__col">
        <div class="img__container">
          <!-- Carga la foto de perfil del usuario -->
          <img src="<?php echo $user['foto_perfil']; ?>" alt="<?php echo $user['nombre']; ?>" />
          <span></span>
          <!-- Ícono de editar perfil -->
          <a href="setting.php" class="edit-icon"><i class="fas fa-edit"></i></a>
        </div>
        <h2><?php echo $user['nombre']; ?></h2>
        <p><?php echo $user['username']; ?></p>
        <p><?php echo $user['correo']; ?></p>
        <!-- Datos adicionales del perfil -->
        <div class="content">
          <p><?php echo $user['biografia']; ?></p>
          <ul>
            <!-- Puedes incluir íconos según las redes sociales del usuario -->
            <li><i class="fab fa-twitter"></i></li>
            <li><i class="fab fa-pinterest"></i></li>
            <li><i class="fab fa-facebook"></i></li>
            <li><i class="fab fa-dribbble"></i></li>
          </ul>
        </div>
      </div>
      <!-- Columna derecha: Navegación y contenido -->
      <div class="right__col">
        <!-- Barra de navegación -->
        <nav>
          <ul>
            <li><a href="#">Publicaciones</a></li>
            <li><a href="#">Videos</a></li>
            <li><a href="#">Grupos</a></li>
            <li><a href="#">Acerca de</a></li>
          </ul>
          <!-- Botón de seguir -->
          <button>Seguir</button>
        </nav>
        <!-- Contenido de la sección seleccionada -->
        <div class="publicaciones">
          <!-- Aquí se mostrarán las publicaciones, videos, etc. -->
        </div>
      </div>
    </div>
  </div>
</body>
</html>


