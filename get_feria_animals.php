<?php
// Remove session check for public access
// require_once 'check_session.php';

// Include database connection
require_once './pdo_conexion.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Initialize response array
$animals = [];

try {
    // Use the existing PDO connection from pdo_conexion.php
    if (!isset($pdo) || !($pdo instanceof PDO)) {
        throw new Exception('PDO connection not available');
    }
    
    // Debug: Check for any animals with price > 0
    $debug_query = "SELECT COUNT(*) as count FROM bufalino WHERE precio_venta > 0";
    $debug_stmt = $pdo->query($debug_query);
    if ($debug_stmt) {
        $debug_row = $debug_stmt->fetch(PDO::FETCH_ASSOC);
        error_log("Total animals with price > 0: " . $debug_row['count']);
    }
    
    // Debug: Check for all unique estatus values
    $status_query = "SELECT DISTINCT estatus FROM bufalino";
    $status_stmt = $pdo->query($status_query);
    if ($status_stmt) {
        $status_values = [];
        while($status_row = $status_stmt->fetch(PDO::FETCH_ASSOC)) {
            $status_values[] = $status_row['estatus'];
        }
        error_log("Unique estatus values: " . implode(", ", $status_values));
    }
    
    // Build the query with filters
    $query = "SELECT tagid, nombre, genero, raza, etapa, grupo, image, precio_venta, fecha_publicacion, estatus
              FROM bufalino 
              WHERE precio_venta > 0 AND UPPER(estatus) = UPPER('Feria')";
    
    $params = [];
    
    // Add filters if provided
    if (isset($_GET['genero']) && !empty($_GET['genero'])) {
        $query .= " AND genero = ?";
        $params[] = $_GET['genero'];
    }
    
    if (isset($_GET['raza']) && !empty($_GET['raza'])) {
        $query .= " AND raza = ?";
        $params[] = $_GET['raza'];
    }
    
    if (isset($_GET['etapa']) && !empty($_GET['etapa'])) {
        $query .= " AND etapa = ?";
        $params[] = $_GET['etapa'];
    }
    
    if (isset($_GET['grupo']) && !empty($_GET['grupo'])) {
        $query .= " AND grupo = ?";
        $params[] = $_GET['grupo'];
    }
    
    // Order by most recent publication date
    $query .= " ORDER BY fecha_publicacion DESC";
    
    // Debug: Log the query
    error_log("Query: " . $query);
    
    // Execute the query using PDO
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Debug: Log the number of rows returned
    error_log("Number of rows: " . count($results));
    
    // Fetch BCV rate for calculating BS price
    $bcv_rate = 0;
    $bcv_query = "SELECT rate FROM bcv ORDER BY rate_date DESC LIMIT 1";
    $bcv_stmt = $pdo->query($bcv_query);
    
    if ($bcv_stmt) {
        $bcv_row = $bcv_stmt->fetch(PDO::FETCH_ASSOC);
        if ($bcv_row) {
            $bcv_rate = floatval($bcv_row['rate']);
        }
    }
    
    // Process each animal
    foreach ($results as $row) {
        // Calculate BS price if BCV rate is available
        $bs_price = null;
        if ($bcv_rate > 0) {
            $bs_price = $row['precio_venta'] * $bcv_rate;
        }
        
        // Format image path
        $image_path = !empty($row['image']) ? $row['image'] : './images/default_image.png';
        
        // Add animal to results
        $animals[] = [
            'tagid' => $row['tagid'],
            'nombre' => $row['nombre'],
            'genero' => $row['genero'],
            'raza' => $row['raza'],
            'etapa' => $row['etapa'],
            'grupo' => $row['grupo'],
            'image' => $image_path,
            'precio_venta' => $row['precio_venta'],
            'Bscash' => $bs_price,
            'stock' => 1, // Each animal is a unique item
            'fecha_publicacion' => $row['fecha_publicacion'],
            'estatus' => $row['estatus']
        ];
    }
    
} catch (Exception $e) {
    // In case of error, return empty array with error message
    error_log('Error in get_feria_animals.php: ' . $e->getMessage());
    // Add the error to the response for debugging
    $animals = ['error' => $e->getMessage()];
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($animals);