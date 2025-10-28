<?php
require_once './pdo_conexion.php';

header('Content-Type: application/json');

// Check if tagid is provided
if (!isset($_GET['tagid']) || empty($_GET['tagid'])) {
    http_response_code(400);
    echo json_encode(['error' => 'No se proporcionó TagID']);
    exit;
}

$tagid = $_GET['tagid'];

// Connect to database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión: ' . mysqli_connect_error()]);
    exit;
}

// Prepare and execute query
$stmt = $conn->prepare("SELECT tagid, nombre FROM bufalino WHERE tagid = ?");
$stmt->bind_param('s', $tagid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Animal no encontrado']);
    exit;
}

// Get animal data
$animal = $result->fetch_assoc();

// Close connection
$stmt->close();
$conn->close();

// Return animal data
echo json_encode($animal); 