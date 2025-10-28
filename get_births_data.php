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
    // Query to get monthly birth data with animal tag IDs
    $sql = "
        SELECT 
            DATE_FORMAT(bh_parto_fecha, '%Y-%m') AS month,
            COUNT(*) AS birth_count,
            GROUP_CONCAT(bh_parto_tagid ORDER BY bh_parto_tagid SEPARATOR ', ') AS birth_animals,
            UNIX_TIMESTAMP(MIN(bh_parto_fecha)) as month_timestamp
        FROM bh_parto 
        WHERE bh_parto_fecha IS NOT NULL 
        GROUP BY month 
        ORDER BY month ASC
    ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'month' => $row['month'],
                'birth_count' => (int)$row['birth_count'],
                'birth_animals' => $row['birth_animals'] ? $row['birth_animals'] : '',
                'month_timestamp' => (int)$row['month_timestamp']
            ];
        }
        mysqli_free_result($result);
    } else {
        throw new Exception("Error executing birth query: " . mysqli_error($conn));
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching birth data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}