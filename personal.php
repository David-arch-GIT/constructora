<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];

// Obtener la lista de usuarios
$sql = "SELECT id, nombre, correo, rol FROM usuarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Personal - Constructora Serrano</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: white;
            background-image: url('fondolegal.jpg');
            background-size: cover;
            background-position: center;
        }

        .header {
            background-color: black;
            color: white;
            text-align: left;
            padding: 10px 20px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
        }

        .main-content {
            padding: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            border: 1px solid #fff;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #444;
        }

        tr:nth-child(even) {
            background-color: #555;
        }

        .actions {
            display: flex;
            justify-content: space-around;
        }

        .actions a {
            padding: 5px 10px;
            background-color: #888;
            color: white;
            text-decoration: none;
            border-radius: 3px;
        }

        .actions a:hover {
            background-color: #aaa;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 15px;
        }

        input, select {
            padding: 10px;
            margin: 5px 0;
            width: 250px;
        }

        button {
            padding: 10px 20px;
            background-color: #000;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Gestión de Personal</h1>
</div>

<div class="navbar">
    <div>
        <a href="index.php">Home</a>
        <a href="empresa.html">Empresa</a>
        <a href="contacto.html">Contacto</a>
        <a href="trabajos.php">Administrar Trabajos</a>
        <a href="personal.php">Administrar Personal</a>
        <a href="contabilidad.php">Contabilidad</a>
        <a href="logout.php">Salir</a>
    </div>
</div>

<div class="main-content">
    <h2>Bienvenido, <?php echo $nombre; ?>, aquí puedes gestionar el personal</h2>
    <p>En esta sección puedes ver, agregar, editar y eliminar usuarios registrados en el sistema.</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['correo']; ?></td>
                        <td><?php echo $row['rol']; ?></td>
                        <td class="actions">
                            <a href="editar_usuario.php?id=<?php echo $row['id']; ?>">Editar</a>
                            <a href="eliminar_usuario.php?id=<?php echo $row['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No hay usuarios registrados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h3>Agregar Nuevo Usuario</h3>
    <form action="agregar_usuario.php" method="post">
        <div class="form-group">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <select name="rol" required>
                <option value="Administrador del Sistema">Administrador del Sistema</option>
                <option value="Gerente de Proyectos">Gerente de Proyectos</option>
                <option value="Contador / Responsable Financiero">Contador / Responsable Financiero</option>
            </select>
            <button type="submit">Agregar Usuario</button>
        </div>
    </form>
</div>
</body>
</html>
