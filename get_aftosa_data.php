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
    
    // Query to get aftosa data ordered by date
    $query = "SELECT         
                bh_aftosa_fecha as fecha, 
                bh_aftosa_dosis as dosis,
                bh_aftosa_costo as costo,
                bh_aftosa_producto as vacuna,
                b.nombre as animal_nombre,
                bh_aftosa_tagid as tagid
              FROM bh_aftosa
              LEFT JOIN bufalino b ON bh_aftosa_tagid = b.tagid 
              ORDER BY bh_aftosa_fecha ASC";
    
    // Fetch all records as associative array
    $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}