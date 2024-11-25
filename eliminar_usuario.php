<?php
session_start();
include 'conexion.php';

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se ha pasado un ID de usuario a eliminar
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir a la página de gestión de personal
        header("Location: personal.php");
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Redirigir si no se proporciona un ID
    header("Location: personal.php");
    exit();
}

$conn->close();
?>
