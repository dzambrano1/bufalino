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
    
    // Get the type parameter to determine what data to return
    $type = $_GET['type'] ?? 'basic';
    
    switch ($type) {
        case 'basic':
            // Basic melaza data for line charts
            $query = "SELECT                 
                        bh_melaza_fecha as fecha, 
                        bh_melaza_racion as melaza,
                        bh_melaza_costo as bh_melaza_costo,
                        b.nombre as animal_nombre,
                        bh_melaza_tagid as tagid
                      FROM bh_melaza
                      LEFT JOIN bufalino b ON bh_melaza_tagid = b.tagid 
                      ORDER BY bh_melaza_fecha ASC";
            break;
            
        case 'monthly_expense':
            // Monthly total expense data
            $query = "SELECT 
                        DATE_FORMAT(bh_melaza_fecha, '%Y-%m') as month,
                        SUM(bh_melaza_racion * bh_melaza_costo) as total_expense
                      FROM bh_melaza 
                      GROUP BY DATE_FORMAT(bh_melaza_fecha, '%Y-%m')
                      ORDER BY month ASC";
            break;
            
        case 'monthly_weight':
            // Monthly total weight data
            $query = "SELECT 
                        DATE_FORMAT(bh_melaza_fecha, '%Y-%m') as month,
                        SUM(bh_melaza_racion) as total_weight
                      FROM bh_melaza 
                      GROUP BY DATE_FORMAT(bh_melaza_fecha, '%Y-%m')
                      ORDER BY month ASC";
            break;
            
        case 'monthly_feed_weight':
            // Monthly total feed weight data for conversion calculations
            $query = "SELECT 
                        DATE_FORMAT(bh_melaza_fecha, '%Y-%m') as month,
                        SUM(bh_melaza_racion) as total_feed_kg
                      FROM bh_melaza 
                      GROUP BY DATE_FORMAT(bh_melaza_fecha, '%Y-%m')
                      ORDER BY month ASC";
            break;
            
        case 'animal_weight':
            // Monthly animal weight data for conversion calculations (from bh_peso table)
            $query = "SELECT 
                        DATE_FORMAT(bh_peso_fecha, '%Y-%m') as month,
                        SUM(bh_peso_animal) as total_weight
                      FROM bh_peso 
                      WHERE bh_peso_animal IS NOT NULL AND bh_peso_animal > 0
                      GROUP BY DATE_FORMAT(bh_peso_fecha, '%Y-%m')
                      ORDER BY month ASC";
            break;
            
        default:
            throw new Exception("Tipo de datos no válido");
    }
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    
    // Fetch all records as associative array
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the result as JSON
    echo json_encode($result);
    
} catch (Exception $e) {
    // Return error as JSON
    echo json_encode(['error' => $e->getMessage()]);
}