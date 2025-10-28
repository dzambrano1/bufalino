<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PDF Generation - Bufalino</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background-color: #d4edda; border-color: #c3e6cb; }
        .error { background-color: #f8d7da; border-color: #f5c6cb; }
        .test-button { 
            background-color: #007bff; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin: 5px;
        }
        .test-button:hover { background-color: #0056b3; }
        .log { background-color: #f8f9fa; padding: 10px; border-radius: 3px; font-family: monospace; }
    </style>
</head>
<body>
    <h1>Test PDF Generation - Bufalino</h1>
    
    <div class="test-section success">
        <h2>✅ Database Connection Test</h2>
        <?php
        try {
            require_once './pdo_conexion.php';
            echo "<p>✓ Database connection successful</p>";
            
            // Test if we can query the bufalino table
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            if ($conn) {
                $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM bufalino LIMIT 1");
                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    echo "<p>✓ Bufalino table accessible - {$row['count']} animals found</p>";
                    
                    // Get a sample animal
                    $result = mysqli_query($conn, "SELECT tagid, nombre FROM bufalino LIMIT 1");
                    if ($result && mysqli_num_rows($result) > 0) {
                        $animal = mysqli_fetch_assoc($result);
                        echo "<p>✓ Sample animal: {$animal['tagid']} - {$animal['nombre']}</p>";
                    }
                }
                mysqli_close($conn);
            }
        } catch (Exception $e) {
            echo "<p class='error'>✗ Database error: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
    
    <div class="test-section success">
        <h2>✅ FPDF Library Test</h2>
        <?php
        if (file_exists('./fpdf/fpdf.php')) {
            echo "<p>✓ FPDF library found</p>";
            try {
                require_once './fpdf/fpdf.php';
                echo "<p>✓ FPDF library loaded successfully</p>";
            } catch (Exception $e) {
                echo "<p class='error'>✗ FPDF error: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p class='error'>✗ FPDF library not found</p>";
        }
        ?>
    </div>
    
    <div class="test-section success">
        <h2>✅ File System Test</h2>
        <?php
        $reportsDir = './reports';
        if (file_exists($reportsDir)) {
            echo "<p>✓ Reports directory exists</p>";
            if (is_writable($reportsDir)) {
                echo "<p>✓ Reports directory is writable</p>";
            } else {
                echo "<p class='error'>✗ Reports directory is not writable</p>";
            }
        } else {
            echo "<p class='error'>✗ Reports directory does not exist</p>";
        }
        
        if (file_exists('./bufalino_share.php')) {
            echo "<p>✓ Share file exists</p>";
        } else {
            echo "<p class='error'>✗ Share file not found</p>";
        }
        ?>
    </div>
    
    <div class="test-section">
        <h2>🧪 PDF Generation Test</h2>
        <p>Click the button below to test PDF generation for animal 3000 (Lola):</p>
        <button class="test-button" onclick="testPDFGeneration()">Generate PDF for Animal 3000</button>
        <button class="test-button" onclick="testPDFGenerationAjax()">Test PDF Generation (AJAX)</button>
        
        <div id="result" style="margin-top: 15px;"></div>
    </div>
    
    <div class="test-section">
        <h2>📊 Recent PDF Files</h2>
        <?php
        $reportsDir = './reports';
        if (file_exists($reportsDir)) {
            $pdfFiles = glob($reportsDir . '/*.pdf');
            if ($pdfFiles) {
                echo "<p>Found " . count($pdfFiles) . " PDF files:</p>";
                echo "<ul>";
                foreach (array_slice($pdfFiles, 0, 5) as $file) {
                    $filename = basename($file);
                    $size = filesize($file);
                    $date = date('Y-m-d H:i:s', filemtime($file));
                    echo "<li><strong>$filename</strong> - Size: " . number_format($size) . " bytes - Date: $date</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No PDF files found in reports directory</p>";
            }
        }
        ?>
    </div>

    <script>
        function testPDFGeneration() {
            // Direct link test
            window.open('bufalino_report.php?tagid=3000', '_blank');
        }
        
        function testPDFGenerationAjax() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p>Testing PDF generation...</p>';
            
            fetch('bufalino_report.php?tagid=3000', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="success">
                            <p>✓ PDF generated successfully!</p>
                            <p>Filename: ${data.filename}</p>
                            <p>Message: ${data.message}</p>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="error">
                            <p>✗ PDF generation failed</p>
                            <p>Error: ${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `
                    <div class="error">
                        <p>✗ Request failed</p>
                        <p>Error: ${error.message}</p>
                    </div>
                `;
            });
        }
    </script>
</body>
</html>
