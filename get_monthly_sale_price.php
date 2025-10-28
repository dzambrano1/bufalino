<?php
header('Content-Type: application/json');

// Include database connection details
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Use mysqli for connection to keep consistency with similar endpoints
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . mysqli_connect_error()]);
    exit();
}

mysqli_set_charset($conn, "utf8");

$data = [];

try {
    // Monthly total sales revenue (sum of precio_venta) for animals with valid sale date and positive weight/price
    $sql = "
        SELECT 
            DATE_FORMAT(fecha_venta, '%Y-%m') AS month,
            SUM(precio_venta) AS total_revenue,
            COUNT(*) AS sales_count,
            GROUP_CONCAT(CONCAT(tagid, ' ($', precio_venta, ')') ORDER BY tagid SEPARATOR ', ') AS sold_animals,
            UNIX_TIMESTAMP(MIN(fecha_venta)) AS month_timestamp
        FROM bufalino
        WHERE 
            fecha_venta IS NOT NULL
            AND fecha_venta <> '0000-00-00'
            AND peso_venta > 0
            AND precio_venta > 0
        GROUP BY month
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'total_revenue' => isset($row['total_revenue']) ? (float)$row['total_revenue'] : 0,
                'sales_count' => (int)$row['sales_count'],
                'sold_animals' => $row['sold_animals'] ? $row['sold_animals'] : '',
                'month_timestamp' => isset($row['month_timestamp']) ? (int)$row['month_timestamp'] : null
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing monthly sale price query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching monthly sale price data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}


