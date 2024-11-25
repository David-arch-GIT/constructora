<?php
session_start();
if (!isset($_SESSION['rol']) || ($_SESSION['rol'] != 'Administrador del Sistema' && $_SESSION['rol'] != 'Gerente de Proyectos')) {
    header("Location: index.php");
    exit();
}

include 'conexion.php';

// Función para obtener recomendación de IA
function getAIRecommendation($nombre, $costo, $gerente_asignado, $estado) {
    // Generar una recomendación más dinámica
    if ($costo > 10000) {
        return 'Recomendación: Revisar presupuesto y asignación de recursos, debido al costo elevado.';
    } elseif ($estado == 'en progreso') {
        return 'Recomendación: Priorizar la supervisión del trabajo en curso para asegurar el cumplimiento de los plazos.';
    } elseif ($gerente_asignado == 'Gerente A') {
        return 'Recomendación: Revisar desempeño del Gerente A en la asignación de recursos.';
    } else {
        return 'Recomendación: Evaluar si el trabajo está bien balanceado entre recursos y tiempo.';
    }
}

// Manejo de formulario para agregar trabajo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'agregar') {
        $nombre = $_POST['nombre'];
        $costo = $_POST['costo'];
        $gerente_asignado = $_POST['gerente_asignado'];
        $estado = $_POST['estado'];

        $sql = "INSERT INTO trabajos (nombre, costo, gerente_asignado, estado) VALUES ('$nombre', '$costo', '$gerente_asignado', '$estado')";
        if ($conn->query($sql)) {
            echo "Trabajo agregado con éxito.";
        } else {
            echo "Error al agregar el trabajo: " . $conn->error;
        }
    }
}

// Llamada a la función de recomendación
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $costo = $_POST['costo'];
    $gerente_asignado = $_POST['gerente_asignado'];
    $estado = $_POST['estado'];

    $recomendacion = getAIRecommendation($nombre, $costo, $gerente_asignado, $estado);
}

// Consultar trabajos de la base de datos
$sql_trabajos = "SELECT * FROM trabajos";
$result = $conn->query($sql_trabajos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Trabajos - Constructora Serrano</title>
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

        .recommendation {
            margin-top: 20px;
            padding: 15px;
            background-color: #333;
            color: white;
            border: 1px solid #fff;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Gestión de Trabajos</h1>
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
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Costo</th>
            <th>Gerente Asignado</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        <?php while ($trabajo = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $trabajo['id']; ?></td>
            <td><?= $trabajo['nombre']; ?></td>
            <td><?= $trabajo['costo']; ?></td>
            <td><?= $trabajo['gerente_asignado']; ?></td>
            <td><?= $trabajo['estado']; ?></td>
            <td>
                <a href="editar_trabajo.php?id=<?= $trabajo['id']; ?>">Editar</a>
                <a href="eliminar_trabajo.php?id=<?= $trabajo['id']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <form method="post" action="trabajos.php">
        <input type="text" name="nombre" placeholder="Nombre del trabajo" required>
        <input type="number" name="costo" placeholder="Costo" required>
        <input type="text" name="gerente_asignado" placeholder="Gerente Asignado" required>
        <select name="estado">
            <option value="en progreso">En Progreso</option>
            <option value="completado">Completado</option>
        </select>
        <button type="submit" name="action" value="agregar">Agregar Trabajo</button>
    </form>

    <!-- Mostrar la recomendación de IA -->
    <?php if (isset($recomendacion)): ?>
    <div class="recommendation">
        <h3>Recomendación de IA:</h3>
        <p><?= $recomendacion; ?></p>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
