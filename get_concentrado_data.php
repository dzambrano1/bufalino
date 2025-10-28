<?php
require_once './pdo_conexion.php';

try {
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to get monthly averages of (costo × racion)
    $query = "
        SELECT 
            DATE_FORMAT(bh_concentrado_fecha, '%Y-%m') as month,
            v.tagid,
            v.nombre as animal_nombre,
            ROUND(AVG(bh_concentrado_costo * bh_concentrado_racion), 2) as average_cost
        FROM 
            bh_concentrado c
            LEFT JOIN bufalino v ON c.bh_concentrado_tagid = v.tagid 
        GROUP BY 
            DATE_FORMAT(bh_concentrado_fecha, '%Y-%m'),
            v.tagid,
            v.nombre
        ORDER BY 
            month ASC, 
            v.tagid ASC
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the data for the chart
    $formattedData = array_map(function($row) {
        return [
            'fecha' => $row['month'] . '-01', // Add day to make it a valid date
            'tagid' => $row['tagid'],
            'animal_nombre' => $row['animal_nombre'],
            'bh_concentrado_cantidad' => $row['average_cost']
        ];
    }, $data);

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($formattedData);

} catch (PDOException $e) {
    // Return error response
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}