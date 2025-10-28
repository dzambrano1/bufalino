<?php
require_once './pdo_conexion.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Database Connection Test</h1>";

try {
    // Test database connection
    if (!($conn instanceof PDO)) {
        die("Error: Connection is not a PDO instance.");
    }
    echo "<p>✅ Database connection successful</p>";
    
    // Test if bc_concentrado table exists
    $sql = "SHOW TABLES LIKE 'bc_concentrado'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tableExists = $stmt->fetch();
    
    if ($tableExists) {
        echo "<p>✅ Table 'bc_concentrado' exists</p>";
        
        // Show table structure
        $sql = "DESCRIBE bc_concentrado";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<h2>Table Structure:</h2>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($column['Extra']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Count existing records
        $sql = "SELECT COUNT(*) as total FROM bc_concentrado";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>📊 Total records in table: " . $count['total'] . "</p>";
        
        // Show sample records
        $sql = "SELECT * FROM bc_concentrado LIMIT 5";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!empty($records)) {
            echo "<h2>Sample Records:</h2>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr>";
            foreach (array_keys($records[0]) as $header) {
                echo "<th>" . htmlspecialchars($header) . "</th>";
            }
            echo "</tr>";
            
            foreach ($records as $record) {
                echo "<tr>";
                foreach ($record as $value) {
                    echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<p>❌ Table 'bc_concentrado' does not exist</p>";
        
        // Try to create the table
        echo "<h2>Attempting to create table...</h2>";
        $createSQL = "CREATE TABLE IF NOT EXISTS bc_concentrado (
            id INT AUTO_INCREMENT PRIMARY KEY,
            bc_concentrado_nombre VARCHAR(255) NOT NULL,
            bc_concentrado_etapa VARCHAR(255) NOT NULL,
            bc_concentrado_costo DECIMAL(10,2) NOT NULL,
            bc_concentrado_vigencia INT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        try {
            $stmt = $conn->prepare($createSQL);
            $stmt->execute();
            echo "<p>✅ Table 'bc_concentrado' created successfully</p>";
        } catch (PDOException $e) {
            echo "<p>❌ Error creating table: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
    
} catch (PDOException $e) {
    echo "<p>❌ Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
} catch (Exception $e) {
    echo "<p>❌ Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<hr>";
echo "<h2>Test Form Submission</h2>";
echo "<form method='POST' action='test_concentrado_insert.php'>";
echo "<p><label>Concentrado: <input type='text' name='concentrado' value='Test Concentrado' required></label></p>";
echo "<p><label>Etapa: <input type='text' name='etapa' value='Test Etapa' required></label></p>";
echo "<p><label>Costo: <input type='number' step='0.01' name='costo' value='10.50' required></label></p>";
echo "<p><label>Vigencia: <input type='number' name='vigencia' value='30' required></label></p>";
echo "<p><input type='submit' value='Test Insert'></p>";
echo "</form>";
?>
