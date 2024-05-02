<?php
$status = isset($_GET['status']) ? $_GET['status'] : '';

if ($status === 'success') {
    $correo = isset($_GET['email']) ? $_GET['email'] : '';
    echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Se ha enviado un correo electrónico con el enlace de restablecimiento de contraseña a $correo.'
            });
         </script>";
} elseif ($status === 'error') {
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Error al enviar el correo electrónico. Por favor, inténtalo de nuevo más tarde.'
            });
         </script>";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MarketMinds Insights</title>

  <!--
    - favicon
  -->
  <link rel="shortcut icon" href="./assets/images/favicon.ico" type="image/x-icon">

  <!--
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!--
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
</head>

<body class="light-theme">

  <!--
    - #HEADER
  -->

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
              <a href="#" class="nav-link">Home</a>
            </li>

            <li>
              <a href="#" class="nav-link">Acerca de Nosotros</a>
            </li>

            <li>
              <a href="sesion/login/" class="nav-link">Login</a>
            </li>

          </ul>

          <button class="theme-btn theme-btn-desktop light">
            <ion-icon name="moon" class="moon"></ion-icon>
            <ion-icon name="sunny" class="sun"></ion-icon>
          </button>

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
                <a href="#" class="nav-link">Economia Mundial</a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">Contenido  Primordial</a>
              </li>

              <li class="nav-item">
                <a href="#" class="nav-link">Analisis del Mercados</a>
              </li>
            </ul>

          </div>

        </div>

      </nav>

    </div>

  </header>





  <main>

    <!--
      - #HERO SECTION
    -->

    <div class="hero">

      <div class="container">

        <div class="left">

          <h1 class="h1">
            <b>MarketMinds&nbsp;</b>.
            <br>Insights
          </h1>

          <p class="h3">
            Dedicado a <abbr title="Accessibility"></abbr>
            Servicios de Economia 
          </p>

          <div class="btn-group">
            <a href="sesion/login/" class="btn btn-primary">Iniciar  sesion</a>
            <a href="#" class="btn btn-secondary">About Me</a>
          </div>

        </div>

        <div class="right">

          <div class="pattern-bg"></div>
          <div class="img-box">
            <img src="./assets/images/blog-10.png" alt="Nose" class="hero-img">
          </div>

        </div>

      </div>

    </div>


    <div class="main">

      <div class="container">

        <!--
          - BLOG SECTION
        -->

        <div class="blog">

          <h2 class="h2">Latest Blog Post</h2>

          <div class="blog-card-group">
          <?php
// Incluir el archivo de conexión
include 'conexion.php';

// Consultar la base de datos para obtener las publicaciones con información del autor
$query = "SELECT p.titulo, p.tema, p.contenido, a.nombre AS autor, p.fecha_publicacion, p.tiempo_lectura, a.foto_admin AS foto_perfil
          FROM post p
          INNER JOIN admins a ON p.id_admin = a.id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    // Obtener los datos de la publicación
    $titulo = $row['titulo'];
    $tema = $row['tema'];
    $contenido = $row['contenido'];
    $autor = $row['autor'];
    $fecha_publicacion = date('M d, Y', strtotime($row['fecha_publicacion']));
    $tiempo_lectura = $row['tiempo_lectura'];
    $imagen_url = $row['foto_perfil']; // Cambiamos el nombre de la variable para reflejar la foto de perfil

    // Generar el HTML para la publicación
    echo '<div class="blog-card">';
    echo '<div class="blog-card-banner">';
    echo '<img src="' . $imagen_url . '" alt="' . $autor . '" width="250" class="blog-banner-img">'; // Utilizamos la foto de perfil como imagen de la publicación
    echo '</div>';
    echo '<div class="blog-content-wrapper">';
    echo '<button class="blog-topic text-tiny">' . $tema . '</button>';
    echo '<h3><a href="#" class="h3">' . $titulo . '</a></h3>';
    echo '<p class="blog-text">' . $contenido . '</p>';
    echo '<div class="wrapper-flex">';
    echo '<div class="profile-wrapper">';
    echo '<img src="admin/dashboard/' . $imagen_url . '" alt="' . $autor . '" width="50">'; // Mostramos la foto de perfil del autor
    echo '</div>';
    echo '<div class="wrapper">';
    echo '<a href="#" class="h4">' . $autor . '</a>';
    echo '<p class="text-sm"><time datetime="' . $fecha_publicacion . '">' . $fecha_publicacion . '</time>';
    echo '<span class="separator"></span>';
    echo '<ion-icon name="time-outline"></ion-icon>';
    echo '<time datetime="PT' . $tiempo_lectura . 'M">' . $tiempo_lectura . ' min</time></p>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }
} else {
  echo 'No hay publicaciones disponibles.';
}

// Cerrar la conexión
$conn->close();
?>



          </div>

          <button class="btn load-more">Load More</button>

        </div>





        <!--
          - ASIDE
        -->

        <div class="aside">

          <div class="topics">

            <h2 class="h2">Temas</h2>

            <a href="#" class="topic-btn">
              <div class="icon-box">
                <ion-icon name="server-outline"></ion-icon>
              </div>

              <p>Economia Mundial</p>
            </a>

            <a href="#" class="topic-btn">
              <div class="icon-box">
                <ion-icon name="accessibility-outline"></ion-icon>
              </div>

              <p>Contenido Primordial</p>
            </a>

            <a href="#" class="topic-btn">
              <div class="icon-box">
                <ion-icon name="rocket-outline"></ion-icon>
              </div>

              <p>Analisis  del Mercado</p>
            </a>

          </div>

          <div class="tags">

            <h2 class="h2">Tags</h2>

            <div class="wrapper">

              <button class="hashtag">#mongodb</button>
              <button class="hashtag">#nodejs</button>
              <button class="hashtag">#a11y</button>
              <button class="hashtag">#mobility</button>
              <button class="hashtag">#inclusion</button>
              <button class="hashtag">#webperf</button>
              <button class="hashtag">#optimize</button>
              <button class="hashtag">#performance</button>

            </div>

          </div>

          <div class="contact">

            <h2 class="h2">Let's Talk</h2>

            <div class="wrapper">

              <p>
                Do you want to learn more about how I can help your company overcome problems? Let us have a
                conversation.
              </p>

              <ul class="social-link">

                <li>
                  <a href="#" class="icon-box discord">
                    <ion-icon name="logo-discord"></ion-icon>
                  </a>
                </li>

                <li>
                  <a href="#" class="icon-box twitter">
                    <ion-icon name="logo-twitter"></ion-icon>
                  </a>
                </li>

                <li>
                  <a href="#" class="icon-box facebook">
                    <ion-icon name="logo-facebook"></ion-icon>
                  </a>
                </li>

              </ul>

            </div>

          </div>

          <div class="newsletter">

            <h2 class="h2">Newsletter</h2>

            <div class="wrapper">

              <p>
                Subscribe to our newsletter to be among the first to keep up with the latest updates.
              </p>

              <form action="#">
                <input type="email" name="email" placeholder="Email Address" required>

                <button type="submit" class="btn btn-primary">Subscribe</button>
              </form>

            </div>

          </div>

        </div>

      </div>

    </div>

  </main>





  <!--
    - #FOOTER
  -->

  <footer>

    <div class="container">

      <div class="wrapper">

        <a href="#" class="footer-logo">
          <img src="./assets/images/logo-light.svg" alt="Insights's Logo" width="150" class="logo-light">
          <img src="./assets/images/logo-dark.svg" alt="Insights's Logo" width="150" class="logo-dark">
        </a>

        <p class="footer-text">
          Learn about Web accessibility, Web performance, and Database management.
        </p>

      </div>

      <div class="wrapper">

        <p class="footer-title">Quick Links</p>

        <ul>

          <li>
            <a href="#" class="footer-link">Advertise with us</a>
          </li>

          <li>
            <a href="#" class="footer-link">About Us</a>
          </li>

          <li>
            <a href="#" class="footer-link">Contact Us</a>
          </li>

        </ul>

      </div>

      <div class="wrapper">

        <p class="footer-title">Legal Stuff</p>

        <ul>

          <li>
            <a href="#" class="footer-link">Privacy Notice</a>
          </li>

          <li>
            <a href="#" class="footer-link">Cookie Policy</a>
          </li>

          <li>
            <a href="#" class="footer-link">Terms Of Use</a>
          </li>

        </ul>

      </div>

    </div>

    <p class="copyright">
      &copy; Copyright 2022 <a href="#">MarketMinds Insights</a>
    </p>

  </footer>





  <!--
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!--
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>