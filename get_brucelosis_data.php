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
    
    // Query to get brucelosis data ordered by date
    $query = "SELECT         
                bh_brucelosis_fecha as fecha, 
                bh_brucelosis_dosis as dosis,
                bh_brucelosis_costo as costo,
                bh_brucelosis_producto as vacuna,
                v.nombre as animal_nombre,
                bh_brucelosis_tagid as tagid
              FROM bh_brucelosis
              LEFT JOIN bufalino v ON bh_brucelosis_tagid = v.tagid 
              ORDER BY bh_brucelosis_fecha ASC";
    
    // Fetch all records as associative array
    $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}