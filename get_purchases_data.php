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
    // Query to get monthly purchase data with financial calculations
    $sql = "
        SELECT 
            DATE_FORMAT(fecha_compra, '%Y-%m') AS month,
            COUNT(*) AS purchase_count,
            SUM(precio_compra * peso_compra) AS total_price,
            AVG(precio_compra) AS avg_price,
            SUM(peso_compra) AS total_weight,
            GROUP_CONCAT(tagid ORDER BY tagid SEPARATOR ', ') AS tagids,
            UNIX_TIMESTAMP(MIN(fecha_compra)) as month_timestamp
        FROM bufalino 
        WHERE fecha_compra IS NOT NULL 
        AND precio_compra IS NOT NULL 
        AND peso_compra IS NOT NULL
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'purchase_count' => (int)$row['purchase_count'],
                'total_price' => (float)$row['total_price'],
                'avg_price' => (float)$row['avg_price'],
                'total_weight' => (float)$row['total_weight'],
                'tagids' => $row['tagids'] ? $row['tagids'] : '',
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing purchase query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching purchase data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}