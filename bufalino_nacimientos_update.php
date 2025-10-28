<?php
require_once './pdo_conexion.php';

// Set header to JSON
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to log debug data
function debugData($label, $data) {
    error_log("DEBUG [$label]: " . print_r($data, true));
}

// Log the POST data for debugging
debugData("POST DATA", $_POST);
debugData("FILES", $_FILES);

try {
    // Check if tagid is provided
    if (!isset($_POST['tagid']) || empty($_POST['tagid'])) {
        throw new Exception("Tag ID es requerido");
    }

    // Extract and sanitize form data
    $tagid = trim($_POST['tagid']);
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : null;
    $fecha_nacimiento = isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : null;
    $genero = isset($_POST['genero']) ? trim($_POST['genero']) : null;
    $raza = isset($_POST['raza']) ? trim($_POST['raza']) : null;
    $grupo = isset($_POST['grupo']) ? trim($_POST['grupo']) : null;
    $estatus = isset($_POST['estatus']) ? trim($_POST['estatus']) : null;
    $peso_nacimiento = isset($_POST['peso_nacimiento']) ? (float)$_POST['peso_nacimiento'] : null;

    // Log the extracted data
    debugData("EXTRACTED DATA", [
        'tagid' => $tagid,
        'nombre' => $nombre,
        'fecha_nacimiento' => $fecha_nacimiento,
        'genero' => $genero,
        'raza' => $raza,
        'grupo' => $grupo,
        'estatus' => $estatus,
        'peso_nacimiento' => $peso_nacimiento
    ]);

    // Start building the query and parameters
    $sql = "UPDATE bufalino SET ";
    $params = [];
    $paramTypes = [];

    // Add fields to update only if they are provided
    if ($nombre !== null) {
        $sql .= "nombre = :nombre, ";
        $params[':nombre'] = $nombre;
        $paramTypes[':nombre'] = PDO::PARAM_STR;
    }

    if ($fecha_nacimiento !== null) {
        $sql .= "fecha_nacimiento = :fecha_nacimiento, ";
        $params[':fecha_nacimiento'] = $fecha_nacimiento;
        $paramTypes[':fecha_nacimiento'] = PDO::PARAM_STR;
    }

    if ($genero !== null) {
        $sql .= "genero = :genero, ";
        $params[':genero'] = $genero;
        $paramTypes[':genero'] = PDO::PARAM_STR;
    }

    if ($raza !== null) {
        $sql .= "raza = :raza, ";
        $params[':raza'] = $raza;
        $paramTypes[':raza'] = PDO::PARAM_STR;
    }

    if ($grupo !== null) {
        $sql .= "grupo = :grupo, ";
        $params[':grupo'] = $grupo;
        $paramTypes[':grupo'] = PDO::PARAM_STR;
    }

    if ($estatus !== null) {
        $sql .= "estatus = :estatus, ";
        $params[':estatus'] = $estatus;
        $paramTypes[':estatus'] = PDO::PARAM_STR;
    }

    if ($peso_nacimiento !== null) {
        $sql .= "peso_nacimiento = :peso_nacimiento, ";
        $params[':peso_nacimiento'] = $peso_nacimiento;
        $paramTypes[':peso_nacimiento'] = PDO::PARAM_STR;
    }

    // Handle file uploads if present
    $uploadDir = 'uploads/';
    
    // Ensure upload directory exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Process image uploads
    $imageFields = ['image', 'image2', 'image3', 'video'];
    
    foreach ($imageFields as $field) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
            $fileName = $uploadDir . time() . '_' . basename($_FILES[$field]['name']);
            
            // Move uploaded file
            if (move_uploaded_file($_FILES[$field]['tmp_name'], $fileName)) {
                $sql .= "$field = :$field, ";
                $params[":$field"] = $fileName;
                $paramTypes[":$field"] = PDO::PARAM_STR;
            } else {
                throw new Exception("Error al subir $field");
            }
        }
    }

    // Remove trailing comma and space if any fields were added
    if (substr($sql, -2) === ', ') {
        $sql = substr($sql, 0, -2);
    }

    // Add WHERE clause
    $sql .= " WHERE tagid = :tagid";
    $params[':tagid'] = $tagid;
    $paramTypes[':tagid'] = PDO::PARAM_STR;

    // Log the generated SQL and parameters
    debugData("SQL", $sql);
    debugData("PARAMS", $params);

    // Prepare and execute the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters with their respective types
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, $paramTypes[$key] ?? PDO::PARAM_STR);
    }

    // Execute the statement
    if ($stmt->execute()) {
        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Datos actualizados correctamente'
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'message' => 'No se realizaron cambios. Los datos son iguales a los existentes.'
            ]);
        }
    } else {
        throw new Exception("Error al actualizar los datos: " . implode(", ", $stmt->errorInfo()));
    }
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("Application error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
