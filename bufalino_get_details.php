<?php
header('Content-Type: application/json');
require_once './pdo_conexion.php'; // Ensure this path is correct

$response = ['success' => false, 'message' => 'Solicitud inválida.'];

if (isset($_GET['tagid']) && !empty($_GET['tagid'])) {
    $tagid = $_GET['tagid'];

    try {
        $sql = "SELECT 
                    tagid, nombre, DATE_FORMAT(fecha_nacimiento, '%Y-%m-%d') as fecha_nacimiento, 
                    DATE_FORMAT(fecha_compra, '%Y-%m-%d') as fecha_compra, genero, raza, 
                    etapa, grupo, estatus, image, image2, image3, video,
                    peso_compra, precio_compra
                FROM bufalino 
                WHERE tagid = :tagid";
        
        $stmt = $conn->prepare($sql);
        
        // Check if statement preparation was successful
        if ($stmt instanceof PDOStatement) {
            $stmt->bindParam(':tagid', $tagid, PDO::PARAM_STR);
            $stmt->execute(); // Execute should throw PDOException on failure
            
            // Fetch the data. fetch() should be called on a PDOStatement.
            $animalData = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            if ($animalData === false) { // Check if fetch returned false (no rows found)
                $response = ['success' => false, 'message' => 'Animal con Tag ID ' . htmlspecialchars($tagid) . ' no encontrado.'];
            } else {
                $response = ['success' => true, 'data' => $animalData];
            }
        } else {
             // This path indicates prepare() failed, which should have thrown an exception
             // with ERRMODE_EXCEPTION set, but we add it for robustness.
            throw new Exception("Falló la preparación de la consulta SQL.");
        }

    } catch (PDOException $e) {
        error_log("Database Error in bufalino_get_details.php: " . $e->getMessage());
        $response = ['success' => false, 'message' => 'Error al consultar la base de datos: ' . $e->getMessage()];
    } catch (Exception $e) {
        error_log("General Error in bufalino_get_details.php: " . $e->getMessage());
        $response = ['success' => false, 'message' => 'Ocurrió un error inesperado: ' . $e->getMessage()];
    }

} else {
    $response = ['success' => false, 'message' => 'Tag ID no proporcionado.'];
}

$conn = null;
echo json_encode($response);
exit;
