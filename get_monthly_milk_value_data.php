<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Use the correct PDO connection variable from pdo_conexion.php
// $conn is already defined in pdo_conexion.php

try {
    // Verify connection is PDO
    if (!($conn instanceof PDO)) {
        throw new Exception("Error: La conexión no es una instancia de PDO. Verifique la configuración.");
    }
    
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get total monthly milk value from bh_leche table
    // Assumes weight column is bh_leche_peso and price/kg column is bh_leche_precio
    $sql = "
        SELECT 
            DATE_FORMAT(bh_leche_fecha, '%Y-%m') AS month, 
            SUM(bh_leche_peso * bh_leche_precio) AS total_milk_value,
            UNIX_TIMESTAMP(MIN(bh_leche_fecha)) as month_timestamp -- Timestamp for the start of the month
        FROM bh_leche 
        WHERE bh_leche_peso > 0 AND bh_leche_precio > 0 -- Ensure valid weight and price
        GROUP BY month 
        ORDER BY month ASC;
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $data = [];
    foreach ($results as $row) {
        $data[] = [
            'month' => $row['month'],
            'total_milk_value' => (float)$row['total_milk_value'], // Ensure value is a float
            'month_timestamp' => (int)$row['month_timestamp'] // Add timestamp to output
        ];
    }

    echo json_encode($data);

} catch (Exception $e) {
    error_log("Error fetching monthly milk value data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
}