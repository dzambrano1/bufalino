<?php
// Simple test to check server configuration
echo "PHP Server Test - " . date('Y-m-d H:i:s');
echo "<br>";
echo "PHP Version: " . phpversion();
echo "<br>";

// Test database connection
try {
    require_once './pdo_conexion.php';
    echo "Database connection: SUCCESS";
    echo "<br>";
    echo "PDO available: " . (isset($pdo) ? "YES" : "NO");
} catch (Exception $e) {
    echo "Database connection: FAILED - " . $e->getMessage();
}
echo "<br>";

// Test if image exists
$logo_path = "./images/default_image.png";
echo "Logo file exists: " . (file_exists($logo_path) ? "YES" : "NO");
echo "<br>";

echo "Server working properly!";