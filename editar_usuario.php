<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT nombre, correo, rol FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET nombre = ?, correo = ?, rol = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $correo, $rol, $id);

    if ($stmt->execute()) {
        header("Location: personal.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <form action="" method="post">
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
        <input type="email" name="correo" value="<?php echo $usuario['correo']; ?>" required>
        <select name="rol" required>
            <option value="<?php echo $usuario['rol']; ?>"><?php echo $usuario['rol']; ?></option>
            <option value="Administrador del Sistema">Administrador del Sistema</option>
            <option value="Gerente de Proyectos">Gerente de Proyectos</option>
            <option value="Contador / Responsable Financiero">Contador / Responsable Financiero</option>
        </select>
        <button type="submit">Actualizar Usuario
