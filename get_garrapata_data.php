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
    
    // Query to get garrapatas data ordered by date
    $query = "SELECT         
                bh_garrapatas_fecha as fecha, 
                bh_garrapatas_dosis as dosis,
                bh_garrapatas_costo as costo,
                bh_garrapatas_producto as vacuna,
                v.nombre as animal_nombre,
                bh_garrapatas_tagid as tagid
              FROM bh_garrapatas
              LEFT JOIN bufalino v ON bh_garrapatas_tagid = v.tagid 
              ORDER BY bh_garrapatas_fecha ASC";
    
    // Fetch all records as associative array
    $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}