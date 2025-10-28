<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test PDF Generation - Working Solution</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background-color: #f5f5f5;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .test-section { 
            margin: 20px 0; 
            padding: 15px; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            background: #f9f9f9;
        }
        .success { 
            background-color: #d4edda; 
            border-color: #c3e6cb; 
        }
        .error { 
            background-color: #f8d7da; 
            border-color: #f5c6cb; 
        }
        .test-button { 
            background-color: #28a745; 
            color: white; 
            padding: 12px 24px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin: 10px 5px;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
        }
        .test-button:hover { 
            background-color: #218838; 
        }
        .test-button.secondary {
            background-color: #007bff;
        }
        .test-button.secondary:hover {
            background-color: #0056b3;
        }
        .status {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .status.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .status.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .status.info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Test PDF Generation - Bufalino</h1>
        
        <div class="test-section success">
            <h2>✅ Estado del Sistema</h2>
            <?php
            try {
                require_once './pdo_conexion.php';
                echo "<p>✓ Base de datos conectada exitosamente</p>";
                
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if ($conn) {
                    $result = mysqli_query($conn, "SELECT COUNT(*) as count FROM bufalino LIMIT 1");
                    if ($result) {
                        $row = mysqli_fetch_assoc($result);
                        echo "<p>✓ Tabla bufalino accesible - {$row['count']} animales encontrados</p>";
                        
                        // Get sample animals
                        $result = mysqli_query($conn, "SELECT tagid, nombre FROM bufalino LIMIT 3");
                        if ($result && mysqli_num_rows($result) > 0) {
                            echo "<p>✓ Animales de prueba disponibles:</p><ul>";
                            while ($animal = mysqli_fetch_assoc($result)) {
                                echo "<li><strong>{$animal['tagid']}</strong> - {$animal['nombre']}</li>";
                            }
                            echo "</ul>";
                        }
                    }
                    mysqli_close($conn);
                }
            } catch (Exception $e) {
                echo "<p class='error'>✗ Error de base de datos: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
        
        <div class="test-section success">
            <h2>✅ Componentes del Sistema</h2>
            <?php
            if (file_exists('./fpdf/fpdf.php')) {
                echo "<p>✓ Biblioteca FPDF disponible</p>";
            } else {
                echo "<p class='error'>✗ Biblioteca FPDF no encontrada</p>";
            }
            
            $reportsDir = './reports';
            if (file_exists($reportsDir)) {
                echo "<p>✓ Directorio de reportes existe</p>";
                if (is_writable($reportsDir)) {
                    echo "<p>✓ Directorio de reportes es escribible</p>";
                } else {
                    echo "<p class='error'>✗ Directorio de reportes no es escribible</p>";
                }
            } else {
                echo "<p class='error'>✗ Directorio de reportes no existe</p>";
            }
            
            if (file_exists('./bufalino_share.php')) {
                echo "<p>✓ Archivo de compartir disponible</p>";
            } else {
                echo "<p class='error'>✗ Archivo de compartir no encontrado</p>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <h2>🧪 Generar PDF - Opción 1: Enlace Directo</h2>
            <p>Haz clic en uno de estos enlaces para generar un PDF directamente:</p>
            <?php
            try {
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if ($conn) {
                    $result = mysqli_query($conn, "SELECT tagid, nombre FROM bufalino LIMIT 3");
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($animal = mysqli_fetch_assoc($result)) {
                            $url = "bufalino_report.php?tagid=" . urlencode($animal['tagid']);
                            echo "<a href='$url' class='test-button' target='_blank'>";
                            echo "📄 Generar PDF para {$animal['nombre']} (ID: {$animal['tagid']})";
                            echo "</a><br><br>";
                        }
                    }
                    mysqli_close($conn);
                }
            } catch (Exception $e) {
                echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
        
        <div class="test-section">
            <h2>🧪 Generar PDF - Opción 2: Prueba AJAX</h2>
            <p>Prueba la generación de PDF usando AJAX (para aplicaciones web):</p>
            <button class="test-button secondary" onclick="testAjaxPDF()">🔄 Probar Generación AJAX</button>
            <div id="ajaxResult"></div>
        </div>
        
        <div class="test-section">
            <h2>📊 Archivos PDF Recientes</h2>
            <?php
            $reportsDir = './reports';
            if (file_exists($reportsDir)) {
                $pdfFiles = glob($reportsDir . '/*.pdf');
                if ($pdfFiles) {
                    echo "<p>Se encontraron " . count($pdfFiles) . " archivos PDF:</p>";
                    echo "<ul>";
                    foreach (array_slice($pdfFiles, 0, 5) as $file) {
                        $filename = basename($file);
                        $size = filesize($file);
                        $date = date('Y-m-d H:i:s', filemtime($file));
                        echo "<li><strong>$filename</strong> - Tamaño: " . number_format($size) . " bytes - Fecha: $date</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No se encontraron archivos PDF en el directorio de reportes</p>";
                }
            }
            ?>
        </div>
        
        <div class="test-section">
            <h2>🔧 Solución de Problemas</h2>
            <p><strong>Si sigues teniendo problemas:</strong></p>
            <ol>
                <li>Asegúrate de que XAMPP esté ejecutándose (Apache y MySQL)</li>
                <li>Verifica que puedas acceder a <code>http://localhost</code></li>
                <li>Revisa la consola del navegador para errores JavaScript</li>
                <li>Revisa el archivo de log: <code>php_errors.log</code></li>
                <li>Intenta generar un PDF usando los enlaces directos arriba</li>
            </ol>
        </div>
    </div>

    <script>
        function testAjaxPDF() {
            const resultDiv = document.getElementById('ajaxResult');
            resultDiv.innerHTML = '<div class="status info">🔄 Probando generación de PDF...</div>';
            
            // Get first available animal
            fetch('simple_pdf_test.php')
            .then(response => response.text())
            .then(html => {
                // Extract animal ID from the HTML
                const match = html.match(/Test animal: (\d+) -/);
                if (match) {
                    const animalId = match[1];
                    return testPDFGeneration(animalId);
                } else {
                    throw new Error('No se pudo obtener ID de animal');
                }
            })
            .catch(error => {
                resultDiv.innerHTML = '<div class="status error">✗ Error: ' + error.message + '</div>';
            });
        }
        
        function testPDFGeneration(animalId) {
            const resultDiv = document.getElementById('ajaxResult');
            
            fetch('bufalino_report.php?tagid=' + animalId, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = `
                        <div class="status success">
                            ✅ PDF generado exitosamente!<br>
                            Archivo: ${data.filename}<br>
                            Mensaje: ${data.message}
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="status error">
                            ✗ Error al generar PDF<br>
                            Error: ${data.message}
                        </div>
                    `;
                }
            })
            .catch(error => {
                resultDiv.innerHTML = `
                    <div class="status error">
                        ✗ Error en la solicitud<br>
                        Error: ${error.message}
                    </div>
                `;
            });
        }
    </script>
</body>
</html>
