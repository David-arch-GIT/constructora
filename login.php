<?php
// Iniciar la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos
include 'conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Consulta para buscar el usuario por correo electrónico
    $sql = "SELECT * FROM usuarios WHERE correo = '$correo'";
    $result = $conn->query($sql);

    // Verifica si la consulta se ejecutó correctamente
    if (!$result) {
        die("Error en la consulta: " . $conn->error);
    }

    // Verifica si se encontró un usuario
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Verifica que la contraseña se recupere correctamente y verifica la contraseña
        if (isset($row['Contrasena']) && password_verify($contrasena, $row['Contrasena'])) {
            $_SESSION['nombre'] = $row['Nombre'];
            $_SESSION['rol'] = $row['Rol'];
            
            // Redirigir a index.php
            header("Location: index.php");
            exit();
        } else {
            $mensaje = "Contraseña incorrecta";
        }
    } else {
        $mensaje = "Usuario no encontrado";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Constructora Serrano</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #CCCCCC;
        }

        .login-container {
            max-width: 400px;
            width: 90%;
            padding: 20px;
            border: 1px solid #333333;
            border-radius: 5px;
            background-color: #FFFFFF;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333333;
        }
        .login-container input {
            width: calc(100% - 20px);
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #333333;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            border-radius: 3px;
            border: none;
            background-color: #000000;
            color: #FFFFFF;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #333333;
        }
        .login-container form {
            margin-top: 10px;
        }
        .login-container p.error {
            text-align: center;
            margin-top: 10px;
            color: red;
        }
        .login-container a {
            color: #000000;
            text-decoration: none;
        }

        @media (max-width: 600px) {
            .login-container {
                width: 95%;
                padding: 15px;
            }
            .login-container h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Iniciar sesión</h2>
    <?php if (!empty($mensaje)) : ?>
        <p class="error"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <input type="email" name="correo" placeholder="Correo electrónico" required><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br>
        <button type="submit">Iniciar sesión</button>
    </form>
    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
</div>
</body>
</html>
