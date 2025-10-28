<?php
require_once './pdo_conexion.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli('localhost', $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $estatus_nombre = $_POST['estatus_nombre'];

    // Insert data into alimentacion table
    $sql = "INSERT INTO v_estatus (estatus_nombre) VALUES ('$estatus_nombre')";

    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Redirect to config_alimento.php
    header("Location: bufalino_configuracion.php");
    exit();
}
?>