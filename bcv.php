<?php
// Include the session check file
require_once 'check_session.php';

// Require admin login for direct access
if (!isLoggedIn() || $_SESSION["role"] !== "admin") {
    // For AJAX requests, return error message
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo json_encode(['success' => false, 'message' => 'Acceso no autorizado']);
        exit;
    }
    // For direct access, redirect to login
    header("Location: login.php");
    exit;
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "durafrenos";

// Create database connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $e->getMessage()]);
        exit;
    }
    die("Connection failed: " . $e->getMessage());
}

// Process AJAX form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // If it's an AJAX request to update the BCV rate
        if (isset($_POST['bcv_rate'])) {
            $bcv_rate = floatval($_POST['bcv_rate']);
            $bcv_date = isset($_POST['bcv_date']) ? $_POST['bcv_date'] : date('Y-m-d', strtotime('now America/New_York'));
            
            if ($bcv_rate <= 0) {
                echo json_encode(['success' => false, 'message' => 'La tasa BCV debe ser un número positivo.']);
                exit;
            }
            
            // First, check if the bcv table exists
            $check_table = $conn->query("SHOW TABLES LIKE 'bcv'");
            if ($check_table->rowCount() == 0) {
                // Create the bcv table if it doesn't exist
                $conn->exec("CREATE TABLE bcv (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    rate DECIMAL(15,4) NOT NULL,
                    rate_date DATE NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )");
            }
            
            // Insert new BCV rate record
            $stmt = $conn->prepare("INSERT INTO bcv (rate, rate_date) VALUES (:rate, :rate_date)");
            $stmt->bindParam(':rate', $bcv_rate, PDO::PARAM_STR);
            $stmt->bindParam(':rate_date', $bcv_date);
            $stmt->execute();
            
            // Also update the settings table for backwards compatibility
            $check_settings_table = $conn->query("SHOW TABLES LIKE 'settings'");
            if ($check_settings_table->rowCount() > 0) {
                // Check if setting_date column exists
                try {
                    $check_column = $conn->query("SHOW COLUMNS FROM settings LIKE 'setting_date'");
                    if ($check_column->rowCount() == 0) {
                        // Add the setting_date column if it doesn't exist
                        $conn->exec("ALTER TABLE settings ADD COLUMN setting_date DATE AFTER setting_value");
                    }
                    
                    // Update or insert the BCV rate and date in settings table
                    $stmt = $conn->prepare("INSERT INTO settings (setting_key, setting_value, setting_date) 
                                         VALUES ('bcv_rate', :bcv_rate, :bcv_date) 
                                         ON DUPLICATE KEY UPDATE setting_value = :bcv_rate, setting_date = :bcv_date");
                    $stmt->bindParam(':bcv_rate', $bcv_rate);
                    $stmt->bindParam(':bcv_date', $bcv_date);
                    $stmt->execute();
                } catch (PDOException $e) {
                    // Proceed even if there's an error with the settings table
                }
            }
            
            echo json_encode(['success' => true, 'message' => 'Tasa BCV actualizada correctamente.', 'rate' => $bcv_rate, 'date' => $bcv_date]);
            
            // Also update the Bscash column in products table
            try {
                // Check if the products table exists and has the Bscash column
                $check_products = $conn->query("SHOW TABLES LIKE 'products'");
                if ($check_products->rowCount() > 0) {
                    // Check if Bscash column exists
                    $check_bscash = $conn->query("SHOW COLUMNS FROM products LIKE 'Bscash'");
                    
                    // If Bscash column doesn't exist, create it
                    if ($check_bscash->rowCount() == 0) {
                        $conn->exec("ALTER TABLE products ADD COLUMN Bscash DECIMAL(15,2) AFTER price");
                    }
                    
                    // Update the Bscash column with price * bcv_rate
                    $update_sql = "UPDATE products SET Bscash = price * :bcv_rate WHERE price IS NOT NULL";
                    $update_stmt = $conn->prepare($update_sql);
                    $update_stmt->bindParam(':bcv_rate', $bcv_rate, PDO::PARAM_STR);
                    $update_stmt->execute();
                }
            } catch (PDOException $e) {
                // Log error but don't stop execution
                error_log("Error updating products Bscash: " . $e->getMessage());
            }
            
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Parámetros incompletos']);
            exit;
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
        exit;
    }
}

// Redirect to catalog page with modal parameter for direct access
// First, check if we can get the latest BCV rate to update products
try {
    $rate_query = $conn->query("SELECT rate FROM bcv ORDER BY created_at DESC LIMIT 1");
    if ($rate_query->rowCount() > 0) {
        $latest_rate = $rate_query->fetchColumn();
        
        // Check if the products table exists and has the Bscash column
        $check_products = $conn->query("SHOW TABLES LIKE 'products'");
        if ($check_products->rowCount() > 0) {
            // Check if Bscash column exists
            $check_bscash = $conn->query("SHOW COLUMNS FROM products LIKE 'Bscash'");
            
            // If Bscash column doesn't exist, create it
            if ($check_bscash->rowCount() == 0) {
                $conn->exec("ALTER TABLE products ADD COLUMN Bscash DECIMAL(15,2) AFTER price");
            }
            
            // Update the Bscash column with price * bcv_rate
            $update_sql = "UPDATE products SET Bscash = price * :bcv_rate WHERE price IS NOT NULL";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindParam(':bcv_rate', $latest_rate, PDO::PARAM_STR);
            $update_stmt->execute();
        }
    }
} catch (PDOException $e) {
    // Log error but continue to redirect
    error_log("Error updating products Bscash on direct access: " . $e->getMessage());
}

header("Location: catalog.php?show_bcv_modal=1");
exit;
?>
