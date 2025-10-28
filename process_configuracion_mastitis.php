<?php
// Include database connection
require_once './pdo_conexion.php';

// Enable error reporting for debugging (can be disabled in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set response header to JSON
header('Content-Type: application/json');

// Function to validate and sanitize input data
function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get action from POST
$action = isset($_POST['action']) ? validateInput($_POST['action']) : '';

// Process based on action
try {
    // Ensure connection is a PDO instance
    if (!($conn instanceof PDO)) {
        throw new Exception("Database connection error");
    }

    switch ($action) {
        case 'insert':
            // Validate required fields
            if (!isset($_POST['vacuna']) || !isset($_POST['dosis']) || !isset($_POST['costo']) || !isset($_POST['vigencia'])) {
                throw new Exception("Todos los campos son requeridos");
            }

            // Sanitize and validate inputs
            $vacuna = validateInput($_POST['vacuna']);
            $dosis = filter_var($_POST['dosis'], FILTER_VALIDATE_FLOAT);
            $costo = filter_var($_POST['costo'], FILTER_VALIDATE_FLOAT);
            $vigencia = filter_var($_POST['vigencia'], FILTER_VALIDATE_INT);

            if ($dosis === false || $costo === false || $vigencia === false) {
                throw new Exception("Los valores ingresados no son válidos");
            }

            // Insert new record
            $sql = "INSERT INTO bc_mastitis (bc_mastitis_vacuna, bc_mastitis_dosis, bc_mastitis_costo, bc_mastitis_vigencia) 
                    VALUES (:vacuna, :dosis, :costo, :vigencia)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':vacuna', $vacuna, PDO::PARAM_STR);
            $stmt->bindParam(':dosis', $dosis, PDO::PARAM_STR);
            $stmt->bindParam(':costo', $costo, PDO::PARAM_STR);
            $stmt->bindParam(':vigencia', $vigencia, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registro agregado exitosamente']);
            } else {
                throw new Exception("Error al insertar el registro");
            }
            break;

        case 'update':
            // Validate required fields including ID
            if (!isset($_POST['id']) || !isset($_POST['vacuna']) || !isset($_POST['dosis']) || !isset($_POST['costo']) || !isset($_POST['vigencia'])) {
                throw new Exception("Todos los campos son requeridos");
            }

            // Sanitize and validate inputs
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            $vacuna = validateInput($_POST['vacuna']);
            $dosis = filter_var($_POST['dosis'], FILTER_VALIDATE_FLOAT);
            $costo = filter_var($_POST['costo'], FILTER_VALIDATE_FLOAT);
            $vigencia = filter_var($_POST['vigencia'], FILTER_VALIDATE_INT);

            if ($id === false || $dosis === false || $costo === false || $vigencia === false) {
                throw new Exception("Los valores ingresados no son válidos");
            }

            // Update existing record
            $sql = "UPDATE bc_mastitis 
                    SET bc_mastitis_vacuna = :vacuna, 
                        bc_mastitis_dosis = :dosis, 
                        bc_mastitis_costo = :costo, 
                        bc_mastitis_vigencia = :vigencia 
                    WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':vacuna', $vacuna, PDO::PARAM_STR);
            $stmt->bindParam(':dosis', $dosis, PDO::PARAM_STR);
            $stmt->bindParam(':costo', $costo, PDO::PARAM_STR);
            $stmt->bindParam(':vigencia', $vigencia, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registro actualizado exitosamente']);
            } else {
                throw new Exception("Error al actualizar el registro");
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
            $sql = "DELETE FROM bc_mastitis WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Registro eliminado exitosamente']);
            } else {
                throw new Exception("Error al eliminar el registro");
            }
            break;

        default:
            throw new Exception("Acción no válida");
    }
} catch (PDOException $e) {
    // Log the error for debugging
    error_log("Database error: " . $e->getMessage());
    
    // Return error message
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Return error message
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 