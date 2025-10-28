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
    // Query to get monthly pregnancy data with animal tag IDs
    $sql = "
        SELECT 
            DATE_FORMAT(bh_gestacion_fecha, '%Y-%m') AS month,
            COUNT(*) AS pregnancy_count,
            GROUP_CONCAT(bh_gestacion_tagid ORDER BY bh_gestacion_tagid SEPARATOR ', ') AS pregnant_animals,
            UNIX_TIMESTAMP(MIN(bh_gestacion_fecha)) as month_timestamp
        FROM bh_gestacion 
        WHERE bh_gestacion_fecha IS NOT NULL 
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'pregnancy_count' => (int)$row['pregnancy_count'],
                'pregnant_animals' => $row['pregnant_animals'] ? $row['pregnant_animals'] : '',
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing pregnancy query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching pregnancy data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}