<?php
require_once './pdo_conexion.php'; // Adjust path if necessary

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set response header to JSON
header('Content-Type: application/json');

// Debug received data
function debugData($data) {
    error_log("DEBUG DATA: " . print_r($data, true));
}

// Log all POST data for debugging
error_log("POST data: " . print_r($_POST, true));

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido. Se esperaba POST.']);
    exit;
}

// Get action from POST
$action = isset($_POST['action']) ? trim($_POST['action']) : '';

try {
    // Ensure connection is a PDO instance
    if (!($conn instanceof PDO)) {
        throw new Exception("Database connection error");
    }

    switch ($action) {
        case 'insert':
            // Validate required fields
            if (!isset($_POST['grupos']) || empty(trim($_POST['grupos']))) {
                throw new Exception('El campo grupos es requerido');
            }

            // Sanitize and prepare data
            $grupos = trim($_POST['grupos']);

            // Debug values
            error_log("Insert values: grupos=$grupos");

            // Insert new record
            $sql = "INSERT INTO vc_grupos (vc_grupos_nombre) VALUES (:grupos)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':grupos', $grupos, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Grupo agregado exitosamente.']);
            } else {
                throw new Exception("Error al insertar el registro: " . implode(", ", $stmt->errorInfo()));
            }
            break;

        case 'update':
            // Validate required fields
            if (!isset($_POST['id']) || !isset($_POST['grupos']) || empty(trim($_POST['grupos']))) {
                $missing = [];
                if (!isset($_POST['id'])) $missing[] = 'id';
                if (!isset($_POST['grupos']) || empty(trim($_POST['grupos']))) $missing[] = 'grupos';
                
                throw new Exception("Campos requeridos faltantes: " . implode(', ', $missing));
            }

            // Sanitize and validate inputs
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            $grupos = trim($_POST['grupos']);

            if ($id === false) {
                throw new Exception("ID inválido");
            }
            
            // Debug values
            error_log("Update values: id=$id, grupos=$grupos");

            // Update existing record
            $sql = "UPDATE vc_grupos SET vc_grupos_nombre = :grupos WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':grupos', $grupos, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registro actualizado exitosamente']);
            } else {
                throw new Exception("Error al actualizar el registro: " . implode(", ", $stmt->errorInfo()));
            }
            break;

        case 'delete':
            // Validate required ID field
            if (!isset($_POST['id'])) {
                throw new Exception("ID es requerido para eliminar");
            }

            // Sanitize and validate ID
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            
            if ($id === false) {
                throw new Exception("ID inválido");
            }

            // Delete record
            $sql = "DELETE FROM vc_grupos WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Grupo eliminado exitosamente']);
            } else {
                throw new Exception("Error al eliminar el registro: " . implode(", ", $stmt->errorInfo()));
            }
            break;

        default:
            throw new Exception("Acción no válida o no especificada: '$action'");
    }
} catch (PDOException $e) {
    // Log the error for debugging
    error_log("Database error: " . $e->getMessage());
    
    // Return error message
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Log the error for debugging
    error_log("Application error: " . $e->getMessage());
    
    // Return error message
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
