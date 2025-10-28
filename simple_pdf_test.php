<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Simple PDF Generation Test</h1>";

// Test 1: Check if we can access the main script
echo "<h2>Test 1: Script Access</h2>";
if (file_exists('./bufalino_report.php')) {
    echo "✓ bufalino_report.php exists<br>";
} else {
    echo "✗ bufalino_report.php not found<br>";
    exit;
}

// Test 2: Check database connection
echo "<h2>Test 2: Database Connection</h2>";
try {
    require_once './pdo_conexion.php';
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if ($conn) {
        echo "✓ Database connection successful<br>";
        
        // Get a test animal
        $result = mysqli_query($conn, "SELECT tagid, nombre FROM bufalino LIMIT 1");
        if ($result && mysqli_num_rows($result) > 0) {
            $animal = mysqli_fetch_assoc($result);
            echo "✓ Test animal: {$animal['tagid']} - {$animal['nombre']}<br>";
            $test_tagid = $animal['tagid'];
        } else {
            echo "✗ No animals found<br>";
            exit;
        }
        mysqli_close($conn);
    } else {
        echo "✗ Database connection failed<br>";
        exit;
    }
} catch (Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "<br>";
    exit;
}

// Test 3: Test PDF generation via HTTP request simulation
echo "<h2>Test 3: PDF Generation Test</h2>";
echo "<p>Testing PDF generation for animal: $test_tagid</p>";

// Create a simple test by calling the script directly
$test_url = "http://localhost/bufalino/bufalino_report.php?tagid=" . urlencode($test_tagid);
echo "<p>Test URL: <a href='$test_url' target='_blank'>$test_url</a></p>";

// Also provide a direct link for testing
echo "<p><strong>Click the link above to test PDF generation</strong></p>";

// Test 4: Check if reports directory is accessible
echo "<h2>Test 4: Reports Directory</h2>";
$reportsDir = './reports';
if (file_exists($reportsDir)) {
    echo "✓ Reports directory exists<br>";
    if (is_writable($reportsDir)) {
        echo "✓ Reports directory is writable<br>";
        
        // List recent PDFs
        $pdfFiles = glob($reportsDir . '/*.pdf');
        if ($pdfFiles) {
            echo "<p>Recent PDF files:</p><ul>";
            foreach (array_slice($pdfFiles, 0, 3) as $file) {
                $filename = basename($file);
                $size = filesize($file);
                $date = date('Y-m-d H:i:s', filemtime($file));
                echo "<li><strong>$filename</strong> - Size: " . number_format($size) . " bytes - Date: $date</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No PDF files found</p>";
        }
    } else {
        echo "✗ Reports directory is not writable<br>";
    }
} else {
    echo "✗ Reports directory does not exist<br>";
}

echo "<h2>Test Complete</h2>";
echo "<p>Click the test link above to generate a PDF. If it works, you should see a PDF download or be redirected to the share page.</p>";
echo "<p>If you get an error, check the browser's developer console and the PHP error logs for more details.</p>";
?>
