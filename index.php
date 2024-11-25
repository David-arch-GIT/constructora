<?php 
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
include 'conexion.php';

// Obtener materiales
$sql_materiales = "SELECT * FROM materiales";
$result_materiales = $conn->query($sql_materiales);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Constructora Serrano</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: white;
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
        .social-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        .social-icons a {
            color: #fff;
            text-decoration: none;
            font-size: 20px;
            margin: 0 10px;
        }
        .main-content {
            text-align: center;
            padding: 20px;
            background-image: url('fondolegal.jpg');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .extra-text {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1 style="font-size: 32px;">Constructora Serrano</h1>
</div>

<div class="navbar">
    <div>
        <a href="index.php">Home</a>
        <a href="empresa.html">Empresa</a>
        <a href="contacto.html">Contacto</a>

        <!-- Menú dinámico por roles -->
        <?php if ($_SESSION['rol'] == 'Administrador del Sistema'): ?>
            <a href="trabajos.php">Administrar Trabajos</a>
            <a href="personal.php">Administrar Personal</a>
            <a href="contabilidad.php">Contabilidad</a>
            <a href="supervisar_materiales.php">Supervisar Materiales</a>
        <?php elseif ($_SESSION['rol'] == 'Gerente de Proyectos'): ?>
            <a href="trabajos.php">Ver Trabajos</a>
        <?php elseif ($_SESSION['rol'] == 'Contador / Responsable Financiero'): ?>
            <a href="contabilidad.php">Contabilidad</a>
        <?php endif; ?>

        <a href="logout.php">Salir</a>
    </div>
</div>

<div class="social-icons">
    <a href="https://facebook.com"><i class="fab fa-facebook"></i></a>
    <a href="https://wa.me/"><i class="fab fa-whatsapp"></i></a>
</div>

<div id="home" class="main-content">
    <h1 style="padding: 20px;">Bienvenido, <?php echo $nombre; ?>, a Constructora Serrano</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed et ligula et turpis varius congue ac ut libero.</p>
</div>

<div id="empresa" class="extra-text">
    <p>Información sobre la Empresa.</p>
</div>

<div id="contacto" class="extra-text">
    <p>Información de Contacto.</p>
</div>

<div class="extra-text" style="background-color: black;">
    <p>Descubre nuestras últimas construcciones y proyectos innovadores para un futuro mejor.</p>
</div>

<!-- Mostrar materiales disponibles -->
<div class="extra-text">
    <h2>Materiales Disponibles</h2>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Cantidad Disponible</th>
            <th>Unidad</th>
        </tr>
        <?php while ($material = $result_materiales->fetch_assoc()): ?>
        <tr>
            <td><?= $material['nombre']; ?></td>
            <td><?= $material['cantidad_disponible']; ?></td>
            <td><?= $material['unidad']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
