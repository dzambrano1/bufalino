<?php
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'update' && isset($_POST['tagid'], $_POST['peso'], $_POST['precio'], $_POST['fecha'])) {
        try {
            // Update bufalino table with descarte information and set status to Descartado
            $stmt = $conn->prepare("UPDATE bufalino SET 
                descarte_fecha = ?, 
                descarte_peso = ?,
                descarte_precio = ?,
                estatus = 'Descartado'
                WHERE tagid = ?");
            
            $stmt->execute([
                $_POST['fecha'],
                $_POST['peso'],
                $_POST['precio'],
                $_POST['tagid']
            ]);
            
            // Check if update affected any rows
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Descarte registrado correctamente',
                    'redirect' => 'bufalino_register_descarte.php'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el animal con el Tag ID especificado'
                );
            }
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        try {
            // Clear descarte information from bufalino table and set status back to Activo
            $stmt = $conn->prepare("UPDATE bufalino SET 
                descarte_fecha = NULL, 
                descarte_peso = NULL,
                descarte_precio = NULL,
                estatus = 'Activo'
                WHERE id = ?");
                
            $stmt->execute([$_POST['id']]);
            
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro de descarte eliminado correctamente',
                    'redirect' => 'bufalino_register_descarte.php'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el registro a eliminar'
                );
            }
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['peso'], $_POST['fecha'])) {
        try {
            // Insert new descarte record
            $stmt = $conn->prepare("UPDATE bufalino SET 
                descarte_fecha = ?, 
                descarte_peso = ?,
                descarte_precio = ?,
                estatus = 'Descartado'
                WHERE tagid = ?");
            
            $stmt->execute([
                $_POST['fecha'],
                $_POST['peso'],
                $_POST['precio'] ?? NULL,
                $_POST['tagid']
            ]);
            
            // Check if update affected any rows
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Descarte registrado correctamente',
                    'redirect' => 'bufalino_register_descarte.php'
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el animal con el Tag ID especificado'
                );
            }
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } else {
        $response = array(
            'success' => false,
            'message' => 'Acción no válida o datos no proporcionados'
        );
    }
    
    echo json_encode($response);
    exit;
}

// If we get here, something went wrong
echo json_encode(array(
    'success' => false,
    'message' => 'Solicitud no válida'
));
?>
