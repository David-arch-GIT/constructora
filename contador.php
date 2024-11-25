<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Contador / Responsable Financiero') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contador - Gestión de Costos</title>
</head>
<body>
    <h1>Bienvenido Contador: <?php echo $_SESSION['nombre']; ?></h1>
    <h2>Costos de Proyectos</h2>

    <!-- Tabla de costos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Trabajo</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            <!-- Consultar costos de los trabajos -->
            <?php
            include 'conexion.php';
            $sql = "SELECT * FROM trabajos";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['costo']}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
