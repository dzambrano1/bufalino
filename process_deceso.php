<?php
require_once './pdo_conexion.php';

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'update' && isset($_POST['tagid'], $_POST['causa'], $_POST['fecha'])) {
        try {
            // First check if the animal exists
            $checkStmt = $conn->prepare("SELECT id FROM bufalino WHERE tagid = ?");
            $checkStmt->execute([$_POST['tagid']]);
            
            if ($checkStmt->rowCount() === 0) {
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el animal con el Tag ID especificado'
                );
            } else {
                // Update bufalino table with death information and set status to Muerto
                $stmt = $conn->prepare("UPDATE bufalino SET 
                    deceso_causa = ?, 
                    deceso_fecha = ?,
                    estatus = 'Muerto'
                    WHERE tagid = ?");
                
                $stmt->execute([
                    $_POST['causa'],
                    $_POST['fecha'],
                    $_POST['tagid']
                ]);
                
                $response = array(
                    'success' => true,
                    'message' => 'Deceso registrado correctamente',
                    'redirect' => 'bufalino_register_decesos.php'
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
            // First check if the record exists
            $checkStmt = $conn->prepare("SELECT id FROM bufalino WHERE id = ?");
            $checkStmt->execute([$_POST['id']]);
            
            if ($checkStmt->rowCount() === 0) {
                $response = array(
                    'success' => false,
                    'message' => 'No se encontró el registro a eliminar'
                );
            } else {
                // Clear death information from bufalino table and set status back to Activo
                $stmt = $conn->prepare("UPDATE bufalino SET 
                    deceso_causa = NULL, 
                    deceso_fecha = NULL,
                    estatus = 'Activo'
                    WHERE id = ?");
                    
                $stmt->execute([$_POST['id']]);
                
                $response = array(
                    'success' => true,
                    'message' => 'Registro de deceso eliminado correctamente',
                    'redirect' => 'bufalino_register_decesos.php'
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

