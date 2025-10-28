<?php
header('Content-Type: application/json');
require_once './pdo_conexion.php';

$response = ['success' => false, 'message' => 'Solicitud inválida.'];

if (isset($_GET['query']) && !empty($_GET['query'])) {
    $query = trim($_GET['query']);

    try {
        // Search by both tagid and nombre (name)
        $sql = "SELECT 
                    tagid, nombre, DATE_FORMAT(fecha_nacimiento, '%Y-%m-%d') as fecha_nacimiento,
                    genero, raza, 
                    etapa, grupo, estatus, image, image2, image3, video,
                    peso_nacimiento
                FROM bufalino 
                WHERE tagid = :query OR nombre LIKE :queryLike
                LIMIT 1";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt instanceof PDOStatement) {
            $queryLike = '%' . $query . '%';
            $stmt->bindParam(':query', $query, PDO::PARAM_STR);
            $stmt->bindParam(':queryLike', $queryLike, PDO::PARAM_STR);
            $stmt->execute();
            
            $animalData = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($animalData === false) {
                $response = [
                    'success' => false, 
                    'message' => 'Animal con Tag ID o nombre "' . htmlspecialchars($query) . '" no encontrado.'
                ];
            } else {
                $response = [
                    'success' => true, 
                    'animal' => $animalData
                ];
            }
        } else {
            throw new Exception("Falló la preparación de la consulta SQL.");
        }
        
    } catch (PDOException $e) {
        error_log("Database error in search_animal.php: " . $e->getMessage());
        $response = [
            'success' => false, 
            'message' => 'Error de base de datos: ' . $e->getMessage()
        ];
    } catch (Exception $e) {
        error_log("Error in search_animal.php: " . $e->getMessage());
        $response = [
            'success' => false, 
            'message' => 'Error interno del servidor'
        ];
    }
} else {
    $response = [
        'success' => false, 
        'message' => 'Parámetro de búsqueda requerido'
    ];
}

echo json_encode($response);
?> 