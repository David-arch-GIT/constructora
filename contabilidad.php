<?php
session_start();
if ($_SESSION['rol'] != 'Administrador del Sistema' && $_SESSION['rol'] != 'Contador / Responsable Financiero') {
    header("Location: index.php");
    exit();
}

include 'conexion.php';

$sql_costos = "SELECT trabajos.nombre AS trabajo, trabajos.costo, usuarios.nombre AS responsable FROM trabajos LEFT JOIN usuarios ON trabajos.gerente_asignado = usuarios.nombre";
$result = $conn->query($sql_costos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contabilidad - Constructora Serrano</title>
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
    <h1>Contabilidad - Costos y Pagos</h1>
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
    <h2>Lista de Costos</h2>
    <table>
        <tr>
            <th>Trabajo</th>
            <th>Costo</th>
            <th>Responsable</th>
        </tr>
        <?php while ($fila = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $fila['trabajo']; ?></td>
            <td><?= $fila['costo']; ?></td>
            <td><?= $fila['responsable']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
