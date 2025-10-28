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
            if (!isset($_POST['etapas']) || empty(trim($_POST['etapas']))) {
                throw new Exception('El campo etapas es requerido');
            }

            // Sanitize and prepare data
            $etapas = trim($_POST['etapas']);

            // Debug values
            error_log("Insert values: etapas=$etapas");

            // Insert new record
            $sql = "INSERT INTO bc_etapas (bc_etapas_nombre) VALUES (:etapas)";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':etapas', $etapas, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $newId = $conn->lastInsertId();
                echo json_encode([
                    'success' => true, 
                    'message' => 'Etapa agregada exitosamente.',
                    'newId' => $newId
                ]);
            } else {
                throw new Exception("Error al insertar el registro: " . implode(", ", $stmt->errorInfo()));
            }
            break;

        case 'update':
            // Validate required fields
            if (!isset($_POST['id']) || !isset($_POST['etapas'])) {
                $missing = [];
                if (!isset($_POST['id'])) $missing[] = 'id';
                if (!isset($_POST['etapas'])) $missing[] = 'etapas';
                
                throw new Exception("Campos requeridos faltantes: " . implode(', ', $missing));
            }

            // Sanitize and validate inputs
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
            $etapas = trim($_POST['etapas']);

            if ($id === false) {
                throw new Exception("El ID ingresado no es válido");
            }
            
            // Debug values
            error_log("Update values: id=$id, etapas=$etapas");

            // Update existing record
            $sql = "UPDATE bc_etapas SET bc_etapas_nombre = :etapas WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':etapas', $etapas, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Etapa actualizada exitosamente.']);
            } else {
                throw new Exception("Error al actualizar el registro: " . implode(", ", $stmt->errorInfo()));
            }
            break;

        case 'delete':
            // Validate required fields
            if (!isset($_POST['id'])) {
                throw new Exception("El ID es requerido para eliminar");
            }

            // Sanitize and validate inputs
            $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

            if ($id === false) {
                throw new Exception("El ID ingresado no es válido");
            }
            
            // Debug values
            error_log("Delete values: id=$id");

            // Delete record
            $sql = "DELETE FROM bc_etapas WHERE id = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Etapa eliminada exitosamente.']);
            } else {
                throw new Exception("Error al eliminar el registro: " . implode(", ", $stmt->errorInfo()));
            }
            break;

        default:
            throw new Exception("Acción no válida: $action");
    }

} catch (Exception $e) {
    error_log("Error in process_configuracion_etapas.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Error: ' . $e->getMessage()
    ]);
} catch (PDOException $e) {
    error_log("PDO Error in process_configuracion_etapas.php: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Error de base de datos: ' . $e->getMessage()
    ]);
}
?>
