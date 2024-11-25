<?php 
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: login.php");
    exit();
}

$nombre = $_SESSION['nombre'];
include 'conexion.php';

// Función de monitoreo con IA (simulada)
function monitorear_materiales($material_id, $cantidad_disponible) {
    $umbral = 10;  
    return $cantidad_disponible <= $umbral ? "Reponer material urgentemente." : "Stock suficiente.";
}

// Registrar el uso de un material
if (isset($_POST['registrar_uso'])) {
    $material_id = $_POST['material_id'];
    $cantidad_usada = $_POST['cantidad_usada'];
    $usuario = $_SESSION['nombre'];

    // Actualizar la cantidad disponible del material
    $sql_actualizar = "UPDATE materiales SET cantidad_disponible = cantidad_disponible - ? WHERE id = ?";
    $stmt = $conn->prepare($sql_actualizar);
    $stmt->bind_param('ii', $cantidad_usada, $material_id);
    $stmt->execute();

    // Registrar el uso del material en la tabla de uso_materiales
    $sql_uso = "INSERT INTO uso_materiales (material_id, cantidad_usada, usuario) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_uso);
    $stmt->bind_param('iis', $material_id, $cantidad_usada, $usuario);
    $stmt->execute();

    echo "<script>alert('Uso de material registrado correctamente.');</script>";
}

// Procesar la búsqueda de materiales
$search = '';
if (isset($_POST['search'])) {
    $search = $_POST['search'];
}
$sql_materiales = "SELECT * FROM materiales WHERE nombre LIKE ?";
$stmt = $conn->prepare($sql_materiales);
$search_param = "%$search%";
$stmt->bind_param('s', $search_param);
$stmt->execute();
$result_materiales = $stmt->get_result();

// Agregar un nuevo material
if (isset($_POST['agregar_material'])) {
    $nombre_material = $_POST['nombre'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $unidad = $_POST['unidad'];

    $sql_agregar = "INSERT INTO materiales (nombre, cantidad_disponible, unidad) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_agregar);
    $stmt->bind_param('sis', $nombre_material, $cantidad_disponible, $unidad);
    $stmt->execute();

    echo "<script>alert('Material agregado correctamente.');</script>";
}

// Editar un material
if (isset($_POST['editar_material'])) {
    $material_id = $_POST['material_id'];
    $nombre_material = $_POST['nombre'];
    $cantidad_disponible = $_POST['cantidad_disponible'];
    $unidad = $_POST['unidad'];

    $sql_editar = "UPDATE materiales SET nombre = ?, cantidad_disponible = ?, unidad = ? WHERE id = ?";
    $stmt = $conn->prepare($sql_editar);
    $stmt->bind_param('sisi', $nombre_material, $cantidad_disponible, $unidad, $material_id);
    $stmt->execute();

    echo "<script>alert('Material editado correctamente.');</script>";
}

// Eliminar un material
if (isset($_POST['eliminar_material'])) {
    $material_id = $_POST['material_id'];
    $sql_eliminar = "DELETE FROM materiales WHERE id = ?";
    $stmt = $conn->prepare($sql_eliminar);
    $stmt->bind_param('i', $material_id);
    $stmt->execute();

    echo "<script>alert('Material eliminado correctamente.');</script>";
}

// Obtener el historial de uso de materiales
$sql_historial = "SELECT um.*, m.nombre AS material_nombre FROM uso_materiales um JOIN materiales m ON um.material_id = m.id";
$result_historial = $conn->query($sql_historial);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisar Materiales - Constructora Serrano</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: white;
            background-image: url('fondolegal.jpg'); /* Imagen de fondo */
            background-size: cover;
            background-position: center;
        }
        .header {
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: left;
            padding: 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: bold;
        }
        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 15px;
            position: fixed;
            top: 60px;
            width: 100%;
            z-index: 999;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 20px;
            font-size: 18px;
            padding: 8px 15px;
            background-color: rgba(51, 51, 51, 0.7);
            border-radius: 5px;
        }
        .navbar a:hover {
            background-color: rgba(51, 51, 51, 1);
        }
        .main-content {
            margin-top: 120px;
            padding: 20px;
            text-align: center;
            background-color: rgba(51, 51, 51, 0.7);
            border-radius: 10px;
            margin-bottom: 30px;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #333;
        }
        table tr:nth-child(even) {
            background-color: #444;
        }
        .social-icons {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.8);
            color: #fff;
            padding: 10px;
            position: fixed;
            bottom: 20px;
            width: 100%;
        }
        .social-icons a {
            color: #fff;
            text-decoration: none;
            font-size: 24px;
            margin: 0 15px;
        }
    </style>
</head>
<body>

<!-- Encabezado -->
<div class="header">
    <h1>Constructora Serrano</h1>
</div>

<!-- Barra de navegación -->
<div class="navbar">
    <a href="index.php">Home</a>
    <a href="trabajos.php">Administrar Trabajos</a>
    <a href="personal.php">Administrar Personal</a>
    <a href="contabilidad.php">Contabilidad</a>
    <a href="supervisar_materiales.php">Supervisar Materiales</a>
    <a href="logout.php">Salir</a>
</div>

<!-- Contenido principal -->
<div class="main-content">
    <h2>Bienvenido, <?php echo $nombre; ?>, a la sección de Supervisión de Materiales</h2>
    <p>A continuación, se muestra la lista de materiales disponibles para su supervisión.</p>
    
    <form method="post">
        <input type="text" name="search" placeholder="Buscar material..." value="<?= htmlspecialchars($search) ?>">
        <input type="submit" value="Buscar">
    </form>

    <!-- Formulario para agregar un nuevo material -->
    <h3>Agregar Nuevo Material</h3>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre del material" required>
        <input type="number" name="cantidad_disponible" placeholder="Cantidad disponible" required>
        <input type="text" name="unidad" placeholder="Unidad" required>
        <input type="submit" name="agregar_material" value="Agregar Material">
    </form>

    <!-- Tabla de materiales -->
    <h3>Lista de Materiales</h3>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Cantidad Disponible</th>
            <th>Unidad</th>
            <th>Monitoreo IA</th>
            <th>Registrar Uso</th>
            <th>Acciones</th>
        </tr>
        <?php while ($material = $result_materiales->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($material['nombre']); ?></td>
            <td><?= htmlspecialchars($material['cantidad_disponible']); ?></td>
            <td><?= htmlspecialchars($material['unidad']); ?></td>
            <td><?= monitorear_materiales($material['id'], $material['cantidad_disponible']); ?></td>
            <td>
                <form action="" method="post">
                    <input type="hidden" name="material_id" value="<?= $material['id']; ?>">
                    <input type="number" name="cantidad_usada" min="1" max="<?= $material['cantidad_disponible']; ?>" required>
                    <input type="submit" name="registrar_uso" value="Registrar Uso">
                </form>
            </td>
            <td>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="material_id" value="<?= $material['id']; ?>">
                    <input type="text" name="nombre" value="<?= htmlspecialchars($material['nombre']); ?>" required>
                    <input type="number" name="cantidad_disponible" value="<?= htmlspecialchars($material['cantidad_disponible']); ?>" required>
                    <input type="text" name="unidad" value="<?= htmlspecialchars($material['unidad']); ?>" required>
                    <input type="submit" name="editar_material" value="Editar">
                </form>
                <form action="" method="post" style="display:inline;">
                    <input type="hidden" name="material_id" value="<?= $material['id']; ?>">
                    <input type="submit" name="eliminar_material" value="Eliminar" onclick="return confirm('¿Estás seguro de que deseas eliminar este material?');">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Historial de uso -->
    <h3>Historial de Uso de Materiales</h3>
    <table>
        <tr>
            <th>Material</th>
            <th>Cantidad Usada</th>
            <th>Usuario</th>
            <th>Fecha</th>
        </tr>
        <?php while ($historial = $result_historial->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($historial['material_nombre']); ?></td>
            <td><?= htmlspecialchars($historial['cantidad_usada']); ?></td>
            <td><?= htmlspecialchars($historial['usuario']); ?></td>
            <td><?= htmlspecialchars($historial['fecha']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Iconos sociales -->
<div class="social-icons">
    <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
    <a href="https://wa.me/" target="_blank"><i class="fab fa-whatsapp"></i></a>
</div>

</body>
</html>