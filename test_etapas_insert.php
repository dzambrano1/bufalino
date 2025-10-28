<?php
require_once './pdo_conexion.php';

echo "<h2>Testing Direct Insert for bc_etapas</h2>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        if (!isset($_POST['etapas']) || empty(trim($_POST['etapas']))) {
            throw new Exception('El campo etapas es requerido');
        }

        $etapas = trim($_POST['etapas']);
        echo "<p>Attempting to insert: <strong>$etapas</strong></p>";

        // Ensure connection is a PDO instance
        if (!($conn instanceof PDO)) {
            throw new Exception("Database connection error");
        }

        // Enable PDO error mode
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert new record
        $sql = "INSERT INTO bc_etapas (bc_etapas_nombre) VALUES (:etapas)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':etapas', $etapas, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            $newId = $conn->lastInsertId();
            echo "<p style='color: green;'>✓ Insert successful! New ID: <strong>$newId</strong></p>";
            
            // Verify the insert
            echo "<h3>Verification:</h3>";
            $stmt = $conn->prepare("SELECT * FROM bc_etapas WHERE id = :id");
            $stmt->bindValue(':id', $newId, PDO::PARAM_INT);
            $stmt->execute();
            $record = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($record) {
                echo "<p>Record found:</p>";
                echo "<ul>";
                echo "<li>ID: {$record['id']}</li>";
                echo "<li>Nombre: {$record['bc_etapas_nombre']}</li>";
                if (isset($record['created_at'])) {
                    echo "<li>Created: {$record['created_at']}</li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color: red;'>✗ Record not found after insert!</p>";
            }
            
        } else {
            throw new Exception("Error al insertar el registro: " . implode(", ", $stmt->errorInfo()));
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    } catch (PDOException $e) {
        echo "<p style='color: red;'>✗ PDO Error: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>No POST data received.</p>";
}

echo "<hr>";
echo "<p><a href='test_etapas_db.php'>← Back to Database Test</a></p>";
echo "<p><a href='bufalino_configuracion_etapas.php'>← Back to Etapas Configuration</a></p>";
?>
