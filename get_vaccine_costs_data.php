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
    // Array of vaccine tables and their corresponding column names
    $vaccines = [
        'Aftosa' => ['table' => 'bh_aftosa', 'dosis' => 'bh_aftosa_dosis', 'costo' => 'bh_aftosa_costo'],
        'Brucelosis' => ['table' => 'bh_brucelosis', 'dosis' => 'bh_brucelosis_dosis', 'costo' => 'bh_brucelosis_costo'],
        'IBR' => ['table' => 'bh_ibr', 'dosis' => 'bh_ibr_dosis', 'costo' => 'bh_ibr_costo'],
        'CBR' => ['table' => 'bh_cbr', 'dosis' => 'bh_cbr_dosis', 'costo' => 'bh_cbr_costo'],
        'Carbunco' => ['table' => 'bh_carbunco', 'dosis' => 'bh_carbunco_dosis', 'costo' => 'bh_carbunco_costo'],
        'Garrapatas' => ['table' => 'bh_garrapatas', 'dosis' => 'bh_garrapatas_dosis', 'costo' => 'bh_garrapatas_costo'],
        'Lombrices' => ['table' => 'bh_lombrices', 'dosis' => 'bh_lombrices_dosis', 'costo' => 'bh_lombrices_costo']
    ];

    foreach ($vaccines as $vaccineName => $vaccineInfo) {
        $table = $vaccineInfo['table'];
        $dosisColumn = $vaccineInfo['dosis'];
        $costoColumn = $vaccineInfo['costo'];

        // Query to get total cost for this vaccine type
        $sql = "
            SELECT 
                SUM({$dosisColumn} * {$costoColumn}) AS total_cost
            FROM {$table} 
            WHERE {$dosisColumn} > 0 AND {$costoColumn} > 0
        ";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $totalCost = $row['total_cost'] ? (float)$row['total_cost'] : 0;
            
            $data[] = [
                'vaccine_name' => $vaccineName,
                'total_cost' => $totalCost
            ];
            
            mysqli_free_result($result);
        } else {
            error_log("Error querying {$table}: " . mysqli_error($conn));
            // Continue with other vaccines even if one fails
            $data[] = [
                'vaccine_name' => $vaccineName,
                'total_cost' => 0
            ];
        }
    }

    echo json_encode($data);

} catch (Exception $e) {
    // Log error if needed
    error_log("Error fetching vaccine costs data: " . $e->getMessage());
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} finally {
    // Close connection
    if (isset($conn)) {
        mysqli_close($conn);
    }
}