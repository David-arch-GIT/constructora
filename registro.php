<?php
session_start();
include 'conexion.php';
include 'roles.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    // Verifica si el correo ya está registrado
    $sql_check_email = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result_check_email = $stmt->get_result();

    if ($result_check_email->num_rows > 0) {
        $mensaje = "El correo electrónico ya está registrado. Por favor, utiliza otro correo.";
    } else {
        // Hashea la contraseña antes de guardarla
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql_insert_user = "INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert_user);
        $stmt->bind_param("ssss", $nombre, $correo, $contrasena_hash, $rol);
        
        if ($stmt->execute()) {
            $mensaje = "Usuario registrado con éxito. Ahora puedes iniciar sesión.";
        } else {
            $mensaje = "Error al registrar el usuario: " . $stmt->error;
        }
    }

    // Cerrar declaración
    $stmt->close();
    // Cerrar conexión
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro - Constructora Serrano</title>
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

    .registro-container {
        max-width: 400px;
        width: 90%;
        padding: 20px;
        border: 1px solid #333333;
        border-radius: 5px;
        background-color: #FFFFFF;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .registro-container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333333;
    }
    .registro-container input, .registro-container select {
        width: calc(100% - 20px);
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 3px;
        border: 1px solid #333333;
    }
    .registro-container button {
        width: 100%;
        padding: 10px;
        border-radius: 3px;
        border: none;
        background-color: #000000;
        color: #FFFFFF;
        cursor: pointer;
    }
    .registro-container button:hover {
        background-color: #333333;
    }
    .registro-container p.error {
        text-align: center;
        margin-top: 10px;
        color: red;
    }
    .registro-container a {
        color: #000000;
        text-decoration: none;
    }

    @media (max-width: 600px) {
        .registro-container {
            width: 95%;
            padding: 15px;
        }
    }
</style>
</head>
<body>
<div class="registro-container">
    <h2>Registro de usuario</h2>
    <?php if (!empty($mensaje)) : ?>
        <p class="error"><?php echo $mensaje; ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required><br>
        <input type="email" name="correo" placeholder="Correo electrónico" required><br>
        <input type="password" name="contrasena" placeholder="Contraseña" required><br>
        <select name="rol">
            <?php foreach ($roles as $rol) : ?>
                <option value="<?php echo $rol; ?>"><?php echo $rol; ?></option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Registrarse</button>
    </form>
    <p>¿Ya tienes una cuenta? <a href="login.php">Iniciar sesión</a></p>
</div>
</body>
</html>
