<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador del Sistema') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Gestión de Trabajos</title>
</head>
<body>
    <h1>Bienvenido Administrador: <?php echo $_SESSION['nombre']; ?></h1>
    <h2>Gestionar Trabajos</h2>
    <p>Aquí puedes agregar, modificar o eliminar trabajos</p>

    <!-- Formulario para agregar trabajos -->
    <form action="agregar_trabajo.php" method="post">
        <input type="text" name="nombre_trabajo" placeholder="Nombre del trabajo" required>
        <input type="number" name="costo_trabajo" placeholder="Costo del trabajo" required>
        <button type="submit">Agregar Trabajo</button>
    </form>

    <!-- Tabla de trabajos -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Costo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí puedes listar los trabajos desde la base de datos -->
            <?php
            include 'conexion.php';
            $sql = "SELECT * FROM trabajos";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombre']}</td>
                        <td>{$row['costo']}</td>
                        <td>
                            <a href='editar_trabajo.php?id={$row['id']}'>Editar</a>
                            <a href='eliminar_trabajo.php?id={$row['id']}'>Eliminar</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
