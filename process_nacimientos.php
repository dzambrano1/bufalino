<?php
require_once './pdo_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['peso'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("INSERT INTO bh_nacimiento (bh_nacimiento_tagid, bh_nacimiento_peso, bh_nacimiento_fecha) VALUES (?, ?, ?)");
            $stmt->execute([
                $_POST['tagid'],
                $_POST['peso'],
                $_POST['fecha']
            ]);
            
            $response = array(
                'success' => true,
                'message' => 'Registro agregado correctamente',
                'redirect' => 'bufalino_register_nacimiento.php'
            );
            
        } catch (PDOException $e) {
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        try {
            $stmt = $conn->prepare("DELETE FROM bh_nacimiento WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro eliminado correctamente',
                    'redirect' => 'bufalino_register_nacimiento.php'
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
    } elseif ($_POST['action'] === 'update' && isset($_POST['id'], $_POST['peso'], $_POST['fecha'])) {
        try {
            $stmt = $conn->prepare("UPDATE bh_nacimiento SET bh_nacimiento_peso = ?, bh_nacimiento_fecha = ? WHERE id = ?");
            $stmt->execute([
                $_POST['peso'],
                $_POST['fecha'],
                $_POST['id']
            ]);
            
            $response = array(
                'success' => true,
                'message' => 'Registro actualizado correctamente',
                'redirect' => 'bufalino_register_nacimiento.php'
            );
            
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
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// If we get here, something went wrong
header('Content-Type: application/json');
echo json_encode(array(
    'success' => false,
    'message' => 'Solicitud no válida'
));
