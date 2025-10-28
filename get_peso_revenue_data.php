<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Include database connection
require_once './pdo_conexion.php';

try {
    // Create connection using mysqli
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Set charset to UTF-8
    mysqli_set_charset($conn, "utf8");

    // SQL query to get weight revenue data grouped by month
    $sql = "SELECT 
                DATE_FORMAT(bh_peso_fecha, '%Y-%m') as month,
                SUM(bh_peso_animal * bh_peso_precio) as total_revenue,
                SUM(bh_peso_animal) as total_quantity,
                AVG(bh_peso_precio) as avg_price,
                COUNT(*) as record_count
            FROM bh_peso 
            WHERE bh_peso_fecha IS NOT NULL 
            AND bh_peso_animal > 0 
            AND bh_peso_precio > 0
            GROUP BY DATE_FORMAT(bh_peso_fecha, '%Y-%m')
            ORDER BY DATE_FORMAT(bh_peso_fecha, '%Y-%m') ASC";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Query failed: " . mysqli_error($conn));
    }

    $data = array();
    
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = array(
                'month' => $row['month'],
                'total_revenue' => number_format((float)$row['total_revenue'], 2, '.', ''),
                'total_quantity' => (int)$row['total_quantity'],
                'avg_price' => number_format((float)$row['avg_price'], 2, '.', ''),
                'record_count' => (int)$row['record_count']
            );
        }
    }

    // Close connection
    mysqli_close($conn);

    // Return JSON response
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

} catch (Exception $e) {
    // Log error for debugging
    error_log("Error in get_peso_revenue_data.php: " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode(array(
        'error' => 'Error al obtener datos de ingresos por peso',
        'message' => $e->getMessage()
    ), JSON_UNESCAPED_UNICODE);
}
?> 