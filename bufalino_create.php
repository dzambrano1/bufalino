<?php
require_once './pdo_conexion.php';
// Disable error reporting in output
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

try {
    
    
    $conn = new mysqli($hostname, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $tagid = $_POST['tagid'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
    $fecha_compra = $_POST['fecha_compra'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $raza = $_POST['raza'] ?? '';
    $grupo = $_POST['grupo'] ?? '';
    $estatus = $_POST['estatus'] ?? '';

    // Validate required fields
    if (empty($tagid) || empty($nombre) || empty($fecha_nacimiento)) {
        throw new Exception("Campos requeridos faltantes");
    }

    // Check if animal with same tagid already exists
    $check_sql = "SELECT COUNT(*) as count FROM bufalino WHERE tagid = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $tagid);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $row = $check_result->fetch_assoc();
    
    if ($row['count'] > 0) {
        throw new Exception("Ya existe un animal con este Tag ID");
    }

    // Handle image upload if provided
    $image_path = null;
    $image2_path = null;
    $image3_path = null;
    $video_path = null;

    // Process main image
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $upload_dir = "uploads/";
        
        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $image_filename = uniqid() . '_' . basename($_FILES['imagen']['name']);
        $image_path = $upload_dir . $image_filename;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $image_path)) {
            throw new Exception("Error uploading image");
        }
    }
    
    // Process image2 upload
    if (isset($_FILES['imagen2']) && $_FILES['imagen2']['error'] == 0) {
        $upload_dir = "uploads/";
        
        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $image2_filename = uniqid() . '_' . basename($_FILES['imagen2']['name']);
        $image2_path = $upload_dir . $image2_filename;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['imagen2']['tmp_name'], $image2_path)) {
            throw new Exception("Error uploading second image");
        }
    }
    
    // Process image3 upload
    if (isset($_FILES['imagen3']) && $_FILES['imagen3']['error'] == 0) {
        $upload_dir = "uploads/";
        
        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $image3_filename = uniqid() . '_' . basename($_FILES['imagen3']['name']);
        $image3_path = $upload_dir . $image3_filename;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['imagen3']['tmp_name'], $image3_path)) {
            throw new Exception("Error uploading third image");
        }
    }
    
    // Process video upload
    if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
        $upload_dir = "uploads/videos/";
        
        // Create upload directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $video_filename = uniqid() . '_' . basename($_FILES['video']['name']);
        $video_path = $upload_dir . $video_filename;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['video']['tmp_name'], $video_path)) {
            throw new Exception("Error uploading video");
        }
    }

    // Insert new animal record with the image path
    $sql = "INSERT INTO bufalino (tagid, nombre, fecha_nacimiento, fecha_compra, genero, raza, grupo, estatus, image, image2, image3, video) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssss", $tagid, $nombre, $fecha_nacimiento, $fecha_compra, $genero, $raza, $grupo, $estatus, $image_path, $image2_path, $image3_path, $video_path);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Animal agregado exitosamente']);
    } else {
        throw new Exception("Error insertando el animal: " . $stmt->error);
    }
    
    $stmt->close();
    $conn->close();
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}