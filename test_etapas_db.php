<?php
require_once './pdo_conexion.php';

echo "<h2>Testing Database Connection and bc_etapas Table</h2>";

try {
    // Test PDO connection
    if (!($conn instanceof PDO)) {
        die("Error: Connection is not a PDO instance. Please check your connection setup.");
    }
    
    echo "<p style='color: green;'>✓ PDO connection successful</p>";
    
    // Enable PDO error mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if bc_etapas table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'bc_etapas'");
    $tableExists = $stmt->rowCount() > 0;
    
    if ($tableExists) {
        echo "<p style='color: green;'>✓ Table 'bc_etapas' exists</p>";
        
        // Show table structure
        echo "<h3>Table Structure:</h3>";
        $stmt = $conn->query("DESCRIBE bc_etapas");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>{$column['Field']}</td>";
            echo "<td>{$column['Type']}</td>";
            echo "<td>{$column['Null']}</td>";
            echo "<td>{$column['Key']}</td>";
            echo "<td>{$column['Default']}</td>";
            echo "<td>{$column['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Count records
        $stmt = $conn->query("SELECT COUNT(*) as count FROM bc_etapas");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        echo "<p>Total records: <strong>$count</strong></p>";
        
        // Show sample records
        if ($count > 0) {
            echo "<h3>Sample Records:</h3>";
            $stmt = $conn->query("SELECT * FROM bc_etapas LIMIT 5");
            $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
            echo "<tr><th>ID</th><th>Nombre</th></tr>";
            foreach ($records as $record) {
                echo "<tr>";
                echo "<td>{$record['id']}</td>";
                echo "<td>{$record['bc_etapas_nombre']}</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "<p style='color: red;'>✗ Table 'bc_etapas' does not exist</p>";
        
        // Try to create the table
        echo "<h3>Attempting to create table...</h3>";
        $createSQL = "CREATE TABLE bc_etapas (
            bc_etapas_id INT AUTO_INCREMENT PRIMARY KEY,
            bc_etapas_nombre VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        try {
            $conn->exec($createSQL);
            echo "<p style='color: green;'>✓ Table 'bc_etapas' created successfully</p>";
        } catch (PDOException $e) {
            echo "<p style='color: red;'>✗ Error creating table: " . $e->getMessage() . "</p>";
        }
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ General error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<h3>Test Form for Direct Insert</h3>";
echo "<form action='test_etapas_insert.php' method='POST'>";
echo "<label>Etapa Name: <input type='text' name='etapas' required></label><br><br>";
echo "<input type='submit' value='Test Insert'>";
echo "</form>";
?>
