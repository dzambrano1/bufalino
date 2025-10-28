<?php
header('Content-Type: application/json');
require_once "./pdo_conexion.php"; // Adjust path if necessary

// Initialize response with empty array - we'll populate it dynamically based on available groups
$response = [];

try {
    // Verify connection is PDO
    if (!($conn instanceof PDO)) {
        throw new Exception("Error: La conexión no es una instancia de PDO.");
    }
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // First, get all distinct groups from the database
    $sql_groups = "SELECT DISTINCT grupo FROM bufalino WHERE grupo IS NOT NULL AND grupo != '' ORDER BY grupo";
    $stmt_groups = $conn->prepare($sql_groups);
    $stmt_groups->execute();
    $groups = $stmt_groups->fetchAll(PDO::FETCH_COLUMN);
    
    // Initialize response for each group
    foreach ($groups as $group) {
        $response[$group] = ['total' => 0, 'vaccinated' => 0, 'non_vaccinated' => 0, 'non_vaccinated_list' => []];
    }

    // --- Query 1: Get counts --- 
    $sql_counts = "
        SELECT
            v.grupo,
            COUNT(DISTINCT v.tagid) AS total_animals,
            COUNT(DISTINCT a.bh_cbr_tagid) AS vaccinated_animals
        FROM bufalino v
        LEFT JOIN bh_cbr a ON v.tagid = a.bh_cbr_tagid
        WHERE v.grupo IS NOT NULL AND v.grupo != ''
        GROUP BY v.grupo;
    ";

    $stmt_counts = $conn->prepare($sql_counts);
    $stmt_counts->execute();
    $results_counts = $stmt_counts->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results_counts as $row) {
        $grupo = $row['grupo'];
        if (isset($response[$grupo])) {
            $response[$grupo]['total'] = (int)$row['total_animals'];
            $response[$grupo]['vaccinated'] = (int)$row['vaccinated_animals'];
            // Calculate non-vaccinated count
            $response[$grupo]['non_vaccinated'] = $response[$grupo]['total'] - $response[$grupo]['vaccinated'];
             if ($response[$grupo]['non_vaccinated'] < 0) { // Sanity check
                 $response[$grupo]['non_vaccinated'] = 0;
             }
        }
    }
    
    // --- Query 2: Get list of non-vaccinated animals --- 
    $sql_list = "
        SELECT 
            v.grupo, 
            v.nombre, 
            v.tagid
        FROM bufalino v
        LEFT JOIN bh_cbr a ON v.tagid = a.bh_cbr_tagid
        WHERE v.grupo IS NOT NULL AND v.grupo != ''
          AND a.bh_cbr_tagid IS NULL
        ORDER BY v.grupo, v.nombre;
    ";
    
    $stmt_list = $conn->prepare($sql_list);
    $stmt_list->execute();
    $results_list = $stmt_list->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($results_list as $row) {
        $grupo = $row['grupo'];
        if (isset($response[$grupo])) {
             // Ensure nombre is not null, provide default if it is
             $nombre = $row['nombre'] ?? 'N/A'; // Use 'N/A' if nombre is null
             $response[$grupo]['non_vaccinated_list'][] = [
                 'nombre' => $nombre,
                 'tagid' => $row['tagid']
             ];
        }
    }

    // Keep 'total' for potential debugging or future use, js can ignore it

    echo json_encode($response);

} catch (Exception $e) {
    error_log("Error fetching CBR status by grupo: " . $e->getMessage());
    // Ensure error response is structured correctly
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error processing request: ' . $e->getMessage()]);
} 