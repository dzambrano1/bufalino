<?php
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

try {
    // Enable error reporting in PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to get monthly sales data from bufalino table
    // Group by year and month, calculate total revenue
    $query = "SELECT 
                YEAR(fecha_venta) AS year,
                MONTH(fecha_venta) AS month,
                SUM(precio_venta) AS total_revenue,
                COUNT(*) AS total_sales
              FROM bufalino
              WHERE 
                fecha_venta IS NOT NULL AND 
                precio_venta IS NOT NULL AND 
                peso_venta IS NOT NULL AND
                estatus = 'Vendido'
              GROUP BY YEAR(fecha_venta), MONTH(fecha_venta)
              ORDER BY year ASC, month ASC";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $monthlySalesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Output the data as JSON
    echo json_encode($monthlySalesData);
    
} catch (PDOException $e) {
    // Return error message
    echo json_encode([
        'error' => true,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
    
    // Log the error
    error_log('Error in get_monthly_sales.php: ' . $e->getMessage());
}