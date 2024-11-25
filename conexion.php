<?php
$servername = "localhost";
$username = "root"; // Cambia esto si usas un usuario diferente
$password = "1234"; // Cambia esto si tienes una contraseña diferente
$dbname = "constructora_serrano";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conn->set_charset("utf8");
?>
