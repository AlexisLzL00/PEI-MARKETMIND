<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de restablecimiento de contraseña</title>
    <!-- Agrega SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #333; /* Negro */
            color: #fff; /* Blanco */
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #fff; /* Blanco */
        }

        form {
            background-color: rgba(255, 255, 255, 0.1); /* Blanco con transparencia */
            padding: 20px;
            border-radius: 10px;
        }

        label {
            color: #ccc; /* Gris oscuro */
        }

        input[type="email"] {
            background-color: rgba(255, 255, 255, 0.5); /* Blanco con transparencia */
            color: #333; /* Negro */
            border: 1px solid #ccc; /* Gris oscuro */
            border-radius: 5px;
            padding: 8px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            background-color: #333; /* Negro */
            color: #fff; /* Blanco */
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #444; /* Negro ligeramente más oscuro */
        }

        button:active {
            background-color: #222; /* Negro más oscuro */
        }
    </style>
</head>

<body>
    <h1>Solicitud de restablecimiento de contraseña</h1>
    <form id="resetForm" action="../admin/bot_/bot_codigo.php" method="post">
        <label for="email">Correo electrónico:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <button type="submit">Enviar correo de restablecimiento</button>
    </form>

    <!-- Script de alerta en JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const status = "<?php echo $_GET['status'] ?? ''; ?>"; // Obtiene el estado de la URL
            if (status === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'Se ha enviado un correo electrónico con el enlace de restablecimiento de contraseña.',
                    showConfirmButton: false,
                    timer: 3000 // Cierra automáticamente después de 3 segundos
                });
            } else if (status === "error") {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ha ocurrido un error al procesar la solicitud.',
                    showConfirmButton: false,
                    timer: 3000 // Cierra automáticamente después de 3 segundos
                });
            }
        });
    </script>
</body>
</html>
