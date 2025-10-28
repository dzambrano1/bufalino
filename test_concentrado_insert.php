<?php
require_once './pdo_conexion.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set response header to JSON
header('Content-Type: application/json');

echo "<h1>Test Insert for bc_concentrado</h1>";

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get POST data
        $concentrado = isset($_POST['concentrado']) ? trim($_POST['concentrado']) : '';
        $etapa = isset($_POST['etapa']) ? trim($_POST['etapa']) : '';
        $costo = isset($_POST['costo']) ? filter_var(trim($_POST['costo']), FILTER_VALIDATE_FLOAT) : false;
        $vigencia = isset($_POST['vigencia']) ? filter_var(trim($_POST['vigencia']), FILTER_VALIDATE_INT) : false;
        
        echo "<p><strong>Received data:</strong></p>";
        echo "<ul>";
        echo "<li>Concentrado: " . htmlspecialchars($concentrado) . "</li>";
        echo "<li>Etapa: " . htmlspecialchars($etapa) . "</li>";
        echo "<li>Costo: " . htmlspecialchars($_POST['costo']) . " (validated: " . ($costo !== false ? $costo : 'INVALID') . ")</li>";
        echo "<li>Vigencia: " . htmlspecialchars($_POST['vigencia']) . " (validated: " . ($vigencia !== false ? $vigencia : 'INVALID') . ")</li>";
        echo "</ul>";
        
        // Validate data
        if (empty($concentrado) || empty($etapa) || $costo === false || $vigencia === false) {
            throw new Exception('Invalid data received');
        }
        
        if ($costo < 0 || $vigencia < 0) {
            throw new Exception('Negative values not allowed');
        }
        
        // Ensure connection is a PDO instance
        if (!($conn instanceof PDO)) {
            throw new Exception("Database connection error");
        }
        
        echo "<p>✅ Data validation passed</p>";
        echo "<p>✅ Database connection verified</p>";
        
        // Insert new record
        $sql = "INSERT INTO bc_concentrado (bc_concentrado_nombre, bc_concentrado_etapa, bc_concentrado_costo, bc_concentrado_vigencia) 
               VALUES (:concentrado, :etapa, :costo, :vigencia)";
        
        echo "<p><strong>SQL Query:</strong> " . htmlspecialchars($sql) . "</p>";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':concentrado', $concentrado, PDO::PARAM_STR);
        $stmt->bindValue(':etapa', $etapa, PDO::PARAM_STR);
        $stmt->bindValue(':costo', $costo, PDO::PARAM_STR);
        $stmt->bindValue(':vigencia', $vigencia, PDO::PARAM_INT);
        
        echo "<p>✅ Statement prepared and bound</p>";
        
        if ($stmt->execute()) {
            $newId = $conn->lastInsertId();
            echo "<p>✅ <strong>INSERT SUCCESSFUL!</strong></p>";
            echo "<p>New record ID: " . $newId . "</p>";
            
            // Verify the insert by selecting the new record
            $sql = "SELECT * FROM bc_concentrado WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $newId, PDO::PARAM_INT);
            $stmt->execute();
            $newRecord = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($newRecord) {
                echo "<p>✅ Record verified in database:</p>";
                echo "<ul>";
                foreach ($newRecord as $key => $value) {
                    echo "<li><strong>" . htmlspecialchars($key) . ":</strong> " . htmlspecialchars($value ?? 'NULL') . "</li>";
                }
                echo "</ul>";
            }
            
        } else {
            $errorInfo = $stmt->errorInfo();
            throw new Exception("Error executing statement: " . implode(", ", $errorInfo));
        }
        
    } catch (PDOException $e) {
        echo "<p>❌ <strong>Database Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<p>Error Code: " . $e->getCode() . "</p>";
    } catch (Exception $e) {
        echo "<p>❌ <strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>This script expects a POST request with concentrado, etapa, costo, and vigencia parameters.</p>";
}

echo "<hr>";
echo "<p><a href='test_concentrado_db.php'>← Back to Database Test</a></p>";
echo "<p><a href='bufalino_configuracion_concentrado.php'>← Back to Main Page</a></p>";
?>
