<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Gerente de Proyectos') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerente de Proyectos - Trabajos</title>
</head>
<body>
    <h1>Bienvenido Gerente de Proyectos: <?php echo $_SESSION['nombre']; ?></h1>
    <h2>Trabajos Asignados</h2>
    
    <!-- Lista de trabajos asignados al gerente -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Trabajo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <!-- Consultar trabajos desde la base de datos -->
            <?php
            include 'conexion.php';
            $sql = "SELECT * FROM trabajos WHERE gerente_asignado = '{$_SESSION['nombre']}'";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['estado']}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
