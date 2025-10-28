<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Use mysqli for connection as in the previous examples
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

mysqli_set_charset($conn, "utf8");

$data = [];

try {
    // Query to get monthly sales data with financial calculations
    $sql = "
        SELECT 
            DATE_FORMAT(fecha_venta, '%Y-%m') AS month,
            COUNT(*) AS sales_count,
            SUM(precio_venta * peso_venta) AS total_revenue,
            AVG(precio_venta) AS avg_price,
            SUM(peso_venta) AS total_weight,
            GROUP_CONCAT(tagid ORDER BY tagid SEPARATOR ', ') AS tagids,
            UNIX_TIMESTAMP(MIN(fecha_venta)) as month_timestamp
        FROM bufalino 
        WHERE fecha_venta IS NOT NULL 
        AND precio_venta IS NOT NULL 
        AND peso_venta IS NOT NULL
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'sales_count' => (int)$row['sales_count'],
                'total_revenue' => (float)$row['total_revenue'],
                'avg_price' => (float)$row['avg_price'],
                'total_weight' => (float)$row['total_weight'],
                'tagids' => $row['tagids'] ? $row['tagids'] : '',
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing sales query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching sales data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}