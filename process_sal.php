<?php
require_once './pdo_conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $response = array();
    
    if ($_POST['action'] === 'insert' && isset($_POST['tagid'], $_POST['racion'], $_POST['producto'], $_POST['etapa'], $_POST['costo'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
        try {
            // Start transaction to ensure both operations succeed or fail together
            $conn->beginTransaction();
            
            // Insert into bh_sal table
            $stmt = $conn->prepare("INSERT INTO bh_sal (bh_sal_tagid, bh_sal_racion, bh_sal_producto, bh_sal_etapa, bh_sal_costo, bh_sal_fecha_inicio, bh_sal_fecha_fin) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['tagid'],
                $_POST['racion'],
                $_POST['producto'],
                $_POST['etapa'],
                $_POST['costo'],
                $_POST['fecha_inicio'],
                $_POST['fecha_fin']
            ]);
            
            // Update the bufalino table with the new etapa for the specific animal
            $stmt_bufalino = $conn->prepare("UPDATE bufalino SET etapa = ? WHERE tagid = ?");
            $stmt_bufalino->execute([
                $_POST['etapa'],
                $_POST['tagid']
            ]);
            
            // Commit the transaction
            $conn->commit();
            
            $response = array(
                'success' => true,
                'message' => 'Registro agregado correctamente en bh_sal y bufalino',
                'redirect' => 'bufalino_registros.php'
            );
            
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
            $response = array(
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            );
        }
    } elseif ($_POST['action'] === 'delete' && isset($_POST['id'])) {
        try {
            $stmt = $conn->prepare("DELETE FROM bh_sal WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            
            if ($stmt->rowCount() > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Registro eliminado correctamente',
                    'redirect' => 'bufalino_registros.php'
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
    } elseif ($_POST['action'] === 'update' && isset($_POST['id'], $_POST['racion'], $_POST['producto'], $_POST['etapa'], $_POST['costo'], $_POST['fecha_inicio'], $_POST['fecha_fin'])) {
        try {
            // Start transaction to ensure both updates succeed or fail together
            $conn->beginTransaction();
            
            // First, update the bh_sal table
            $stmt = $conn->prepare("UPDATE bh_sal SET bh_sal_racion = ?, bh_sal_producto = ?, bh_sal_etapa = ?, bh_sal_costo = ?, bh_sal_fecha_inicio = ?, bh_sal_fecha_fin = ? WHERE id = ?");
            $stmt->execute([
                $_POST['racion'],
                $_POST['producto'],
                $_POST['etapa'],
                $_POST['costo'],
                $_POST['fecha_inicio'],
                $_POST['fecha_fin'],
                $_POST['id']
            ]);
            
            // Then, update the bufalino table with the new etapa for the specific animal
            $stmt_bufalino = $conn->prepare("UPDATE bufalino SET etapa = ? WHERE tagid = ?");
            $stmt_bufalino->execute([
                $_POST['etapa'],
                $_POST['tagid']
            ]);
            
            // Commit the transaction
            $conn->commit();
            
            $response = array(
                'success' => true,
                'message' => 'Registro actualizado correctamente en bh_sal y bufalino',
                'redirect' => 'bufalino_registros.php'
            );
            
        } catch (PDOException $e) {
            // Rollback the transaction on error
            $conn->rollBack();
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