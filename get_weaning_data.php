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
    // Query to get monthly weaning data with animal tag IDs and weaning weights
    $sql = "
        SELECT 
            DATE_FORMAT(destete_fecha, '%Y-%m') AS month,
            COUNT(*) AS weaning_count,
            GROUP_CONCAT(CONCAT(tagid, ' (', destete_peso, ' kg)') ORDER BY tagid SEPARATOR ', ') AS weaned_animals,
            UNIX_TIMESTAMP(MIN(destete_fecha)) as month_timestamp
        FROM bufalino 
        WHERE destete_fecha IS NOT NULL 
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'weaning_count' => (int)$row['weaning_count'],
                'weaned_animals' => $row['weaned_animals'] ? $row['weaned_animals'] : '',
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing weaning query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching weaning data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}