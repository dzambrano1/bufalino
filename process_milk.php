<?php
// Include database connection
require_once './pdo_conexion.php';

// Set response header to JSON
header('Content-Type: application/json');

// Handle different actions
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    try {
        // INSERT operation
        if ($action === 'insert') {
            // Validate required fields
            $requiredFields = ['tagid', 'peso', 'precio', 'fecha'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    throw new Exception("Campo requerido: $field");
                }
            }
            
            // Prepare data
            $tagid = $_POST['tagid'];
            $peso = floatval($_POST['peso']);
            $precio = floatval($_POST['precio']);
            $fecha = $_POST['fecha'];
            
            // Execute query
            $stmt = $conn->prepare("INSERT INTO bh_leche (bh_leche_tagid, bh_leche_peso, bh_leche_precio, bh_leche_fecha_inicio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$tagid, $peso, $precio, $fecha]);
            
            echo json_encode(['success' => true, 'message' => 'Registro agregado correctamente']);
        }
        
        // UPDATE operation
        else if ($action === 'update') {
            // Validate required fields
            $requiredFields = ['id', 'tagid', 'peso', 'precio', 'fecha'];
            foreach ($requiredFields as $field) {
                if (!isset($_POST[$field]) || empty($_POST[$field])) {
                    throw new Exception("Campo requerido: $field");
                }
            }
            
            // Prepare data
            $id = intval($_POST['id']);
            $tagid = $_POST['tagid'];
            $peso = floatval($_POST['peso']);
            $precio = floatval($_POST['precio']);
            $fecha = $_POST['fecha'];
            
            // Execute query
            $stmt = $conn->prepare("UPDATE bh_leche SET bh_leche_tagid = ?, bh_leche_peso = ?, bh_leche_precio = ?, bh_leche_fecha_inicio = ? WHERE id = ?");
            $stmt->execute([$tagid, $peso, $precio, $fecha, $id]);
            
            echo json_encode(['success' => true, 'message' => 'Registro actualizado correctamente']);
        }
        
        // DELETE operation
        else if ($action === 'delete') {
            // Validate required fields
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                throw new Exception("ID requerido para eliminar");
            }
            
            // Prepare data
            $id = intval($_POST['id']);
            
            // Execute query
            $stmt = $conn->prepare("DELETE FROM bh_leche WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true, 'message' => 'Registro eliminado correctamente']);
        }
        
        // Invalid action
        else {
            throw new Exception("Acción inválida: $action");
        }
    } 
    catch (Exception $e) {
        // Return error message
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} 
else {
    // No action specified
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No se especificó ninguna acción']);
}
?>