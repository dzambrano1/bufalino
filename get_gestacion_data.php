<?php
// Include database connection
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Verify connection is PDO
    if (!($conn instanceof PDO)) {
        throw new Exception("Error: La conexión no es una instancia de PDO");
    }
    
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to get gestacion data ordered by date
    $query = "SELECT         
                bh_gestacion_fecha as fecha, 
                bh_gestacion_numero as numero,
                v.nombre as animal_nombre,
                bh_gestacion_tagid as tagid
              FROM bh_gestacion
              LEFT JOIN bufalino v ON bh_gestacion_tagid = v.tagid 
              ORDER BY bh_gestacion_fecha ASC";
    
    // Fetch all records as associative array
    $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}
