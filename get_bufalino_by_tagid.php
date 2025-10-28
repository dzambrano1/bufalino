<?php
require_once './pdo_conexion.php';

// Set response content type to JSON
header('Content-Type: application/json');

// Check if tagid is provided
if (!isset($_POST['tagid']) || empty($_POST['tagid'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Tag ID es requerido'
    ]);
    exit;
}

$tagid = trim($_POST['tagid']);

try {
    // Prepare and execute the query
    $query = "SELECT * FROM bufalino WHERE tagid = :tagid LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':tagid', $tagid, PDO::PARAM_STR);
    $stmt->execute();
    
    // Fetch the result without parameters
    $animal = $stmt->fetch();
    
    if ($animal) {
        // Return success with animal data
        echo json_encode([
            'success' => true,
            'animal' => $animal
        ]);
    } else {
        // Return error if animal not found
        echo json_encode([
            'success' => false,
            'message' => 'No se encontró ningún animal con el Tag ID: ' . $tagid
        ]);
    }
} catch (PDOException $e) {
    // Log the error
    error_log("Database error in get_bufalino_by_tagid.php: " . $e->getMessage());
    
    // Return error message
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
}