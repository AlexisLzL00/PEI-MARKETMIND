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



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="css/setting.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">

<!--
  - custom css link
-->
<link rel="stylesheet" href="../assets/css/style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700;800;900&display=swap"
  rel="stylesheet">
</head>

<body class="light-theme">

  <!--
    - #HEADER
  -->


    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-change-password">Change password</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-info">Info</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-connections">Connections</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list"
                            href="#account-notifications">Notifications</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">

                    <div class="tab-pane fade active show" id="account-general">
    <div class="card-body media align-items-center">
        <!-- Formulario para actualizar otros datos del perfil -->
        <form method="POST" action="../solicitudes/update_general.php" enctype="multipart/form-data">

        <!-- Mostrar la imagen actual del perfil con animación -->
        <div class="image-container">
            <img src="../<?php echo $user['foto_perfil']; ?>" id="currentImage" alt="Profile Image" class="d-block rounded-circle" style="width: 150px; height: 150px; object-fit: cover;" onclick="triggerImageUpload()">
            <input type="file" id="uploadImage" class="account-settings-fileinput" name="profile_picture" accept="image/*" style="display: none;" onchange="previewImage(event)">
        </div>
    </div>
    <hr class="border-light m-0">
    <div class="card-body">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" class="form-control mb-1" value="<?php echo $user['username']; ?>" name="username">
            </div>
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" value="<?php echo $user['nombre']; ?>" name="nombre">
            </div>
            <div class="form-group">
                <label class="form-label">E-mail</label>
                <input type="text" class="form-control mb-1" value="<?php echo $user['correo']; ?>" name="correo">
                <div class="alert alert-warning mt-3">
                    Your email is not confirmed. Please check your inbox.<br>
                    <a href="javascript:void(0)">Resend confirmation</a>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="../perfil" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- Estilo CSS para imagen -->
<style>
    .image-container {
        cursor: pointer;
    }

    #currentImage {
        max-width: 150px;
        max-height: 150px;
        border-radius: 50%;
        margin-top: 10px;
        border: 2px solid #ddd; /* Borde delgado */
    }
</style>

<!-- Script para activar la carga de imagen al hacer clic en la imagen -->
<script>
    function triggerImageUpload() {
        document.getElementById('uploadImage').click();
    }

    function previewImage(event) {
        var input = event.target;
        var currentImage = document.getElementById('currentImage');

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                currentImage.src = e.target.result; // Actualiza la imagen actual
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>


<div class="tab-pane fade" id="account-change-password">
    <div class="card-body pb-2">
        <form action="../solicitudes/update_contra.php" method="POST"> <!-- Reemplaza 'update_password.php' con el archivo donde manejarás la actualización de contraseña -->
            <div class="form-group">
                <label class="form-label">Current password</label>
                <input type="password" class="form-control" name="current_password" required>
            </div>
            <div class="form-group">
                <label class="form-label">New password</label>
                <input type="password" class="form-control" name="new_password" required>
            </div>
            <div class="form-group">
                <label class="form-label">Repeat new password</label>
                <input type="password" class="form-control" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Password</button>
            <a href="../perfil" class="btn btn-default">Cancel</a>

        </form>
    </div>
</div>



                        <!-- Formulario  de Info -->
                        <div class="tab-pane fade" id="account-info">
    <div class="card-body pb-2">
    <form action="../solicitudes/update_info.php" method="POST"> <!-- Reemplaza 'update_password.php' con el archivo donde manejarás la actualización de contraseña -->

        <div class="form-group">
            <label class="form-label">Bio</label>
            <textarea class="form-control" rows="5" name="biografia"><?php echo isset($user['biografia']) ? $user['biografia'] : ''; ?></textarea>
        </div>
        <!-- Agrega el código correspondiente si estos datos están en otra tabla -->
        <div class="form-group">
            <label class="form-label">Country</label>
            <select class="custom-select" name="pais">
                <option value="USA" <?php if(isset($user['pais']) && $user['pais'] == 'USA') echo 'selected'; ?>>USA</option>
                <option value="MEXICO" <?php if(isset($user['pais']) && $user['pais'] == 'Mexico') echo 'selected'; ?>>Mexico</option>
                <option value="Canada" <?php if(isset($user['pais']) && $user['pais'] == 'Canada') echo 'selected'; ?>>Canada</option>
                <option value="UK" <?php if(isset($user['pais']) && $user['pais'] == 'UK') echo 'selected'; ?>>UK</option>
                <option value="Germany" <?php if(isset($user['pais']) && $user['pais'] == 'Germany') echo 'selected'; ?>>Germany</option>
                <option value="France" <?php if(isset($user['pais']) && $user['pais'] == 'France') echo 'selected'; ?>>France</option>
            </select>
        </div>
    </div>
    <hr class="border-light m-0">
    <div class="card-body pb-2">
        <h6 class="mb-4">Contacts</h6>
        <div class="form-group">
            <label class="form-label">Phone</label>
            <input type="text" class="form-control" value="<?php echo isset($user['telefono']) ? $user['telefono'] : ''; ?>" name="telefono">
        </div>
        <button type="submit" class="btn btn-primary">Update Info</button>
        <a href="../perfil" class="btn btn-default">Cancel</a>

</form>
    </div>
</div>

                        <div class="tab-pane fade" id="account-connections">
                            <div class="card-body">
                                <button type="button" class="btn btn-twitter">Connect to
                                    <strong>Twitter</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <h5 class="mb-2">
                                    <a href="javascript:void(0)" class="float-right text-muted text-tiny"><i
                                            class="ion ion-md-close"></i> Remove</a>
                                    <i class="ion ion-logo-google text-google"></i>
                                    You are connected to Google:
                                </h5>
                                <a href="/cdn-cgi/l/email-protection" class="__cf_email__"
                                    data-cfemail="f9979498818e9c9595b994989095d79a9694">[email&#160;protected]</a>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-facebook">Connect to
                                    <strong>Facebook</strong></button>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body">
                                <button type="button" class="btn btn-instagram">Connect to
                                    <strong>Instagram</strong></button>
                                    <a href="perfil.php" class="btn btn-default">Salir</a>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="account-notifications">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Activity</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone comments on my article</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone answers on my forum
                                            thread</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Email me when someone follows me</span>
                                    </label>
                                </div>
                            </div>
                            <hr class="border-light m-0">
                            <div class="card-body pb-2">
                                <h6 class="mb-4">Application</h6>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">News and announcements</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input">
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly product updates</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="switcher">
                                        <input type="checkbox" class="switcher-input" checked>
                                        <span class="switcher-indicator">
                                            <span class="switcher-yes"></span>
                                            <span class="switcher-no"></span>
                                        </span>
                                        <span class="switcher-label">Weekly blog digest</span>
                                    </label>
                                </div>
                                <a href="perfil.php" class="btn btn-default">Salir</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">

    </script>

</body>

</html>