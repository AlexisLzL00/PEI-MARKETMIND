<?php
session_start(); // Inicia la sesión

if (!isset($_SESSION['csrf_token'])) {
    // Generar un nuevo token CSRF si no está definido
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Genera un token CSRF aleatorio
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="style.css" />
    <title>Admon</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="../solicitud_admin.php" method="POST"  class="sign-in-form">
          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="usuario" placeholder="username" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="contrasena"placeholder="password" required/>
            </div>
            <input type="submit" value="Login" class="btn solid" />
        <p class="social-text">Leer  <a href="../terminos.html">Terminos & Conditions</a></p>
        <!-- Agregar enlace para restablecer la contraseña -->
        <p class="social-text"><a href="../../reset_contra/">Forgot Password?</a></p>
            <div class="social-media">
              <a href="#" class="social-icon">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-google"></i>
              </a>
              <a href="#" class="social-icon">
                <i class="fab fa-linkedin-in"></i>
              </a>
            </div>
          </form>

        </div>
      </div>



    <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        const type = password.type === 'password' ? 'text' : 'password';
        password.type = type;
        togglePassword.classList.toggle('fa-eye-slash');
    });

    // Script para mostrar un alert al hacer clic en "Forgot Password?"
    document.getElementById('resetPassword').addEventListener('click', function(event) {
        event.preventDefault(); // Evita que el enlace redireccione
        alert('Contact the administrator (achavez63@ucol.mx) to reset your password.'); // Muestra un alert
    });
</script>

    <script src="app.js"></script>
  </body>
</html>
