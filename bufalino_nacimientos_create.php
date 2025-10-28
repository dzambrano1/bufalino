<?php
// Ensure no output before headers
header('Content-Type: application/json');

// Include database connection
require_once './pdo_conexion.php';

// Function to handle file uploads
function handleFileUpload($file, $directory = 'uploads/') {
    // Check if directory exists, create if it doesn't
    if (!file_exists($directory)) {
        mkdir($directory, 0777, true);
    }
    
    // Generate unique filename
    $filename = $directory . uniqid() . '_' . basename($file['name']);
    
    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $filename)) {
        return $filename;
    }
    
    return false;
}

// Initialize response array
$response = [
    'success' => false,
    'message' => 'Error desconocido al procesar la solicitud.'
];

try {
    // Validate required fields
    $requiredFields = ['tagid', 'nombre', 'fecha_nacimiento', 'genero', 'raza', 'etapa', 'grupo', 'estatus', 'peso'];
    $missingFields = [];
    
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }
    
    if (!empty($missingFields)) {
        throw new Exception('Campos requeridos faltantes: ' . implode(', ', $missingFields));
    }
    
    // Process uploaded files
    $imageField = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK ? 
        handleFileUpload($_FILES['image']) : null;
    
    $image2Field = isset($_FILES['image2']) && $_FILES['image2']['error'] === UPLOAD_ERR_OK ? 
        handleFileUpload($_FILES['image2']) : null;
    
    $image3Field = isset($_FILES['image3']) && $_FILES['image3']['error'] === UPLOAD_ERR_OK ? 
        handleFileUpload($_FILES['image3']) : null;
    
    $videoField = isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK ? 
        handleFileUpload($_FILES['video']) : null;
    
    // Prepare SQL statement
    $sql = "INSERT INTO bufalino (
                tagid, nombre, fecha_nacimiento, genero,
                raza, etapa, grupo, estatus, peso_nacimiento,
                image, image2, image3, video
            ) VALUES (
                :tagid, :nombre, :fecha_nacimiento, :genero,
                :raza, :etapa, :grupo, :estatus, :peso_nacimiento,
                :image, :image2, :image3, :video
            )";
    
    $stmt = $conn->prepare($sql);
    
    // Set etapa to 'Inicio' for newborn animals
    $etapa = 'Inicio';
    
    // Bind parameters
    $stmt->bindParam(':tagid', $_POST['tagid']);
    $stmt->bindParam(':nombre', $_POST['nombre']);
    $stmt->bindParam(':fecha_nacimiento', $_POST['fecha_nacimiento']);
    $stmt->bindParam(':genero', $_POST['genero']);
    $stmt->bindParam(':raza', $_POST['raza']);
    $stmt->bindParam(':etapa', $_POST['etapa']);
    $stmt->bindParam(':grupo', $_POST['grupo']);
    $stmt->bindParam(':estatus', $_POST['estatus']);
    $stmt->bindParam(':peso_nacimiento', $_POST['peso']);
    $stmt->bindParam(':image', $imageField);
    $stmt->bindParam(':image2', $image2Field);
    $stmt->bindParam(':image3', $image3Field);
    $stmt->bindParam(':video', $videoField);
    
    // Execute the statement
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Animal registrado exitosamente.';
        $response['id'] = $conn->lastInsertId();
    } else {
        throw new Exception('Error al insertar en la base de datos.');
    }
    
} catch (PDOException $e) {
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
    error_log('PDOException in bufalino_create.php: ' . $e->getMessage());
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    error_log('Exception in bufalino_create.php: ' . $e->getMessage());
}

// Output JSON response
echo json_encode($response);
