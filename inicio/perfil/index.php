<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['iduser'])) {
    // Redirige al formulario de inicio de sesión si no ha iniciado sesión
    header('Location: ../../index.php');
    exit();
}

// Incluye el archivo de conexión a la base de datos
include("../../conexion.php");

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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
  <link rel="shortcut icon" href="../../assets/images/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="../../assets/css/style.css">
  <!-- CSS personalizado -->
  <link rel="stylesheet" href="../css/user.css" />

  <style>
  /* Estilo para el icono de actualización del banner */
  .update-banner-icon {
    position: absolute;
    top: 10px; /* Posición desde arriba */
    right: 10px; /* Posición desde la derecha */
    z-index: 1; /* Asegura que esté por encima de otros elementos */
    color: #fff; /* Color del icono */
    background-color: rgba(0, 0, 0, 0.7); /* Fondo semitransparente */
    padding: 8px; /* Espaciado interno */
    border-radius: 50%; /* Borde redondeado */
    cursor: pointer; /* Cambia el cursor al pasar sobre el icono */
  }

  /* Estilo para el icono en dispositivos móviles */
  @media screen and (max-width: 768px) {
    .update-banner-icon {
      top: 25px; /* Ajusta la posición en dispositivos móviles */
      right: 5px; /* Ajusta la posición en dispositivos móviles */
    }
  }

  </style>
</head>
<body class="light-theme">
<header>

<div class="container">

  <nav class="navbar">

    <a href="#">
      <!-- <img src="./assets/images/logo-light.svg" alt="Devblog's logo" width="150" class="logo-light">
      <img src="./assets/images/logo-dark.svg" alt="Devblog's logo" width="150" class="logo-dark"> -->
    </a>

    <div class="btn-group">

      <button class="theme-btn theme-btn-mobile light">
        <ion-icon name="moon" class="moon"></ion-icon>
        <ion-icon name="sunny" class="sun"></ion-icon>
      </button>

      <button class="nav-menu-btn">
        <ion-icon name="menu-outline"></ion-icon>
      </button>

    </div>

    <div class="flex-wrapper">

      <ul class="desktop-nav">

        <li>
          <a href="../" class="nav-link">Home</a>
        </li>

        <li>
<a href="#" class="nav-link">Acerca de Nosotros</a>
</li>

<li class="nav-item dropdown">
<a class="nav-link" href="#" id="navbarDropdown" onclick="toggleDropdown(event)">
    <div class="d-flex align-items-center">
        <?php
        // Verifica si existe una sesión y si hay datos de perfil
        if (isset($_SESSION['username']) && isset($_SESSION['foto_perfil'])) {
            ?>
            <div class="profile-info">
                <img src="../<?php echo $_SESSION['foto_perfil']; ?>" alt="Foto de perfil" class="profile-img" height="50px" width="50px" style="border-radius:50px;">

            </div>
            <?php
        } else {
            echo '<span class="d-inline-block">Usuario</span>'; // Si no hay sesión iniciada, muestra un texto genérico
        }
        ?>
    </div>
</a>
<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" id="dropdownMenu">
    <li><a class="dropdown-item" href="#">Notificaciones</a></li>
    <li><hr class="dropdown-divider"></li>
    <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
</ul>
</li>




<script>
function toggleDropdown(event) {
event.preventDefault();
var dropdownMenu = document.getElementById("dropdownMenu");
dropdownMenu.classList.toggle("show");
}
</script>



      <button class="theme-btn theme-btn-desktop light">
        <ion-icon name="moon" class="moon"></ion-icon>
        <ion-icon name="sunny" class="sun"></ion-icon>
      </button>
      </ul>
    </div>

    <div class="mobile-nav">

      <button class="nav-close-btn">
        <ion-icon name="close-outline"></ion-icon>
      </button>

      <div class="wrapper">

        <p class="h3 nav-title">Main Menu</p>

        <ul>
          <li class="nav-item">
            <a href="#" class="nav-link">Home</a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">Acerca de Nosotros</a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">Login</a>
          </li>
        </ul>

      </div>

      <div>

        <p class="h3 nav-title">Temas</p>

        <ul>
          <li class="nav-item">
            <a href="#" class="nav-link">La vida en el trabajo</a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">Datos</a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">Lujo de Trabajo</a>
          </li>
        </ul>

      </div>

    </div>

  </nav>

</div>

</header>

  <div class="header__wrapper">
    <!-- Contenedor del banner -->
    <div class="banner__container">
  <!-- Aquí puedes cargar el banner del usuario -->
  <img src="../bannerview/<?php echo $user['banner']; ?>" alt="Banner del usuario">

  <!-- Icono para redirigir a actualizar_fondo.php -->
  <div class="update-banner-icon">
    <a href="../bannerview/">
      <i class="fas fa-edit"></i> <!-- Icono de edición, puedes cambiarlo por otro de FontAwesome -->
    </a>
  </div>
</div>


    <div class="cols__container">
      <!-- Columna izquierda: Información del usuario -->
      <div class="left__col">
        <div class="img__container">
          <!-- Carga la foto de perfil del usuario -->
          <img src="../<?php echo $user['foto_perfil']; ?>" alt="<?php echo $user['nombre']; ?>" />
          <span></span>
          <!-- Ícono de editar perfil -->
          <a href="../configuracion/" class="edit-icon"><i class="fas fa-edit"></i></a>
        </div>
        <h2><?php echo $user['nombre']; ?></h2>
        <p><?php echo $user['username']; ?></p>
        <p><?php echo $user['correo']; ?></p>
        <!-- Datos adicionales del perfil -->
        <div class="content">
          <p><?php echo $user['biografia']; ?></p>
          <ul class="redes">
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
          <ul class="secciones">
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

  <script src="../../assets/js/script.js"></script>

  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>


