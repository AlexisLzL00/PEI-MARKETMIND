<?php
include("../conexion.php");


// Verifica si se enviaron datos de usuario y contraseña
if (isset($_POST['usuario']) && isset($_POST['contrasena'])) {
    // Obtiene los valores enviados
    $username = $_POST['usuario'];
    $password = $_POST['contrasena'];
    $ip = $_SERVER['REMOTE_ADDR']; // Obtiene la IP del usuario

    // Prepara la consulta para obtener la contraseña almacenada
    $sql = "SELECT id, usuario, nombre, correo_electronico, contrasena, permisos FROM admins WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($admin_id, $username, $nombre, $correo, $hashed_password, $permisos);
    $stmt->fetch();
    $stmt->close();

    // Verifica si el usuario existe y la contraseña es correcta
    if ($hashed_password && password_verify($password, $hashed_password)) {
        // Inicio de sesión exitoso, puedes almacenar información de sesión si es necesario
        session_start();
        $_SESSION['admin_id'] = $admin_id;
        $_SESSION['username'] = $username;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['correo'] = $correo;
        $_SESSION['ip'] = $ip; // Almacena la IP en la sesión
        $_SESSION['permisos'] = $permisos; // Almacena los permisos en la sesión

        // Actualiza la última conexión y la IP en la base de datos
        $updateSql = "UPDATE admins SET ultima_conexion = CURRENT_TIMESTAMP(), ip = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("si", $ip, $admin_id);
        $updateStmt->execute();
        $updateStmt->close();

        // Redirige a la página de bienvenida o realiza las acciones necesarias
        header('Location: ../admin/Dashboard');
        exit();
    } else {
        // Usuario o contraseña incorrectos, redirige a admin.php con el parámetro de error
        header('Location: login/index.php?error=utx');
        exit();
    }
} else {
    // Si no se enviaron datos, redirige a la página de login
    header('Location: login/');
    exit();
}

// Cierra la conexión a la base de datos
$con->close();
?>
