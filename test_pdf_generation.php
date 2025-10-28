<?php
// Test script for PDF generation using the actual PDF class
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

echo "<h1>Testing PDF Generation with Actual Class</h1>";

// Test 1: Check if FPDF is available
echo "<h2>Test 1: FPDF Library</h2>";
if (file_exists('./fpdf/fpdf.php')) {
    echo "✓ FPDF library found<br>";
    require_once './fpdf/fpdf.php';
    echo "✓ FPDF library loaded successfully<br>";
} else {
    echo "✗ FPDF library not found<br>";
    exit;
}

// Test 2: Check database connection
echo "<h2>Test 2: Database Connection</h2>";
require_once './pdo_conexion.php';
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✓ Database connection successful<br>";
} catch(PDOException $e) {
    echo "✗ Database connection failed: " . $e->getMessage() . "<br>";
    exit;
}

// Test 3: Check if animal exists
echo "<h2>Test 3: Animal Data</h2>";
$tagid = '9500'; // Use a known tagid
$stmt = $conn->prepare("SELECT * FROM bufalino WHERE tagid = ?");
$stmt->execute([$tagid]);
$animal = $stmt->fetch(PDO::FETCH_ASSOC);

if ($animal) {
    echo "✓ Animal found: " . $animal['nombre'] . " (Tag ID: " . $animal['tagid'] . ")<br>";
    echo "Image paths:<br>";
    echo "- Main image: " . ($animal['image'] ?: 'None') . "<br>";
    echo "- Image 2: " . ($animal['image2'] ?: 'None') . "<br>";
    echo "- Image 3: " . ($animal['image3'] ?: 'None') . "<br>";
    echo "- Video: " . ($animal['video'] ?: 'None') . "<br>";
} else {
    echo "✗ Animal not found with Tag ID: $tagid<br>";
    exit;
}

// Test 4: Check reports directory
echo "<h2>Test 4: Reports Directory</h2>";
$reportsDir = './reports';
if (file_exists($reportsDir)) {
    echo "✓ Reports directory exists<br>";
    if (is_writable($reportsDir)) {
        echo "✓ Reports directory is writable<br>";
    } else {
        echo "✗ Reports directory is not writable<br>";
    }
} else {
    echo "✗ Reports directory does not exist<br>";
    if (mkdir($reportsDir, 0777, true)) {
        echo "✓ Reports directory created successfully<br>";
    } else {
        echo "✗ Failed to create reports directory<br>";
    }
}

// Test 5: Check if images exist
echo "<h2>Test 5: Image Files</h2>";
if (!empty($animal['image'])) {
    $imagePath = $animal['image'];
    if (file_exists($imagePath)) {
        echo "✓ Main image exists: $imagePath<br>";
    } else {
        echo "✗ Main image not found: $imagePath<br>";
    }
}

if (!empty($animal['image2'])) {
    $imagePath = $animal['image2'];
    if (file_exists($imagePath)) {
        echo "✓ Image 2 exists: $imagePath<br>";
    } else {
        echo "✗ Image 2 not found: $imagePath<br>";
    }
}

if (!empty($animal['image3'])) {
    $imagePath = $animal['image3'];
    if (file_exists($imagePath)) {
        echo "✓ Image 3 exists: $imagePath<br>";
    } else {
        echo "✗ Image 3 not found: $imagePath<br>";
    }
}

// Test 6: Try to create PDF using the actual class
echo "<h2>Test 6: PDF Creation with Actual Class</h2>";

// First, let's include the PDF class definition
ob_start();
include './bufalino_report.php';
ob_end_clean();

try {
    // Create PDF instance
    $pdf = new PDF();
    $pdf->setAnimalData($animal);
    echo "✓ PDF instance created successfully<br>";
    
    // Set metadata
    $pdf->SetTitle('Test Reporte - ' . $animal['nombre'] . ' (' . $animal['tagid'] . ')', true);
    $pdf->SetAuthor('Sistema Ganagram', true);
    $pdf->SetSubject('Test Historial Veterinario', true);
    $pdf->SetKeywords('test, veterinario, ganado, bovino, historial, ' . $animal['tagid'] . ', ' . $animal['nombre'], true);
    $pdf->SetCreator('Ganagram - Sistema de Gestión Ganadera', true);
    echo "✓ PDF metadata set successfully<br>";
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    echo "✓ First PDF page added successfully<br>";
    
    // Add basic content
    $pdf->ChapterTitle('Datos');
    echo "✓ Chapter title added<br>";
    
    $header = array('Concepto', 'Descripcion');
    $data = array(
        array('Tag ID', $animal['tagid']),
        array('Nombre', $animal['nombre']),
        array('Fecha Nacimiento', $animal['fecha_nacimiento']),
        array('Genero', $animal['genero']),
        array('Raza', $animal['raza']),
        array('Etapa', $animal['etapa']),
        array('Grupo', $animal['grupo']),
        array('Estatus', $animal['estatus'])
    );
    $pdf->SimpleTable($header, $data);
    echo "✓ Basic table added<br>";
    
    // Try to save the PDF
    $filename = 'test_' . $tagid . '_' . date('Y-m-d_His') . '.pdf';
    $filepath = $reportsDir . '/' . $filename;
    
    echo "Attempting to save PDF to: $filepath<br>";
    
    $pdf->Output('F', $filepath);
    
    if (file_exists($filepath)) {
        $size = filesize($filepath);
        echo "✓ PDF saved successfully!<br>";
        echo "File: $filename<br>";
        echo "Size: " . number_format($size) . " bytes<br>";
        echo "Path: $filepath<br>";
        
        // Test if file is readable
        if (is_readable($filepath)) {
            echo "✓ File is readable<br>";
        } else {
            echo "✗ File is not readable<br>";
        }
        
        // Provide download link
        echo "<br><a href='reports/$filename' target='_blank' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Download Test PDF</a>";
        
        // Clean up
        unlink($filepath);
        echo "<br>✓ Test file cleaned up<br>";
        
    } else {
        echo "✗ PDF file was not created<br>";
    }
    
} catch (Exception $e) {
    echo "✗ PDF creation error: " . $e->getMessage() . "<br>";
    echo "Error details: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    echo "Stack trace: " . $e->getTraceAsString() . "<br>";
}

echo "<h2>Test Complete</h2>";
echo "If all tests pass, the PDF generation should be working correctly.<br>";
echo "Check the browser console for JavaScript errors when using the actual interface.<br>";
?>
