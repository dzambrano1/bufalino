<?php
// Disable error display to prevent JSON corruption
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once './pdo_conexion.php';

// Check if FPDF class already exists to avoid conflicts
if (!class_exists('FPDF')) {
    require('./fpdf/fpdf.php'); // You might need to install FPDF library
}

// Check if reports directory exists, if not create it
$reportsDir = './reports';
if (!file_exists($reportsDir)) {
    mkdir($reportsDir, 0777, true);
}

// Handle download requests
if (isset($_GET['download'])) {
    $filename = $_GET['download'];
    $filepath = __DIR__ . '/reports/' . $filename;
    
    // Security check - only allow PDF files
    if (!preg_match('/\.pdf$/i', $filename) || !file_exists($filepath)) {
        http_response_code(404);
        die('File not found');
    }
    
    // Set headers for PDF download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
    header('Content-Length: ' . filesize($filepath));
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
    
    // Output the file
    readfile($filepath);
    exit;
}

// Ensure no output has been sent before
while (ob_get_level()) {
    ob_end_clean();
}
ob_start();

// Check if animal ID is provided
if (!isset($_GET['tagid']) || empty($_GET['tagid'])) {
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error: No animal ID provided']);
        exit;
    } else {
        die('Error: No animal ID provided');
    }
}

$tagid = $_GET['tagid'];


// Connect to database
try {
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    // Check connection
    if (!$conn) {
        error_log('Database connection failed: ' . mysqli_connect_error());
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                   strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Connection failed: ' . mysqli_connect_error()]);
            exit;
        } else {
            die('Connection failed: ' . mysqli_connect_error());
        }
    }
} catch (Exception $e) {
    error_log('Database connection exception: ' . $e->getMessage());
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
        exit;
    } else {
        die('Database connection error: ' . $e->getMessage());
    }
}

// Set charset to UTF-8 for proper character encoding in PDF
mysqli_set_charset($conn, "utf8");

// Log successful connection
error_log("Database connection established successfully");

// Fetch animal basic info
$sql_animal = "SELECT * FROM bufalino WHERE tagid = ?";
$stmt_animal = $conn->prepare($sql_animal);
if (!$stmt_animal) {
    error_log('Failed to prepare animal query: ' . mysqli_error($conn));
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to prepare animal query: ' . mysqli_error($conn)]);
        exit;
    } else {
        die('Failed to prepare animal query: ' . mysqli_error($conn));
    }
}

$stmt_animal->bind_param('s', $tagid);
$stmt_animal->execute();
$result_animal = $stmt_animal->get_result();

if ($result_animal->num_rows === 0) {
    error_log('Animal not found with tagid: ' . $tagid);
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error: Animal not found']);
        exit;
    } else {
        die('Error: Animal not found');
    }
}

$animal = $result_animal->fetch_assoc();
error_log("Animal data retrieved successfully: " . $animal['nombre'] . " (" . $animal['tagid'] . ")");

// Create PDF
if (!class_exists('PDF')) {
    class PDF extends FPDF
    {
        // Animal data to access in header
        protected $animalData;
        
        // Set animal data
        function setAnimalData($data) {
            $this->animalData = $data;
        }
        
        // Helper function to ensure proper UTF-8 encoding for searchable text
        function EncodeText($text) {
            // Handle null or empty values
            if ($text === null || $text === '') {
                return '';
            }
            
            // Convert to string if needed
            $text = (string)$text;
            
            // Remove control characters and normalize text
            $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);
            
            // Convert text to proper encoding for FPDF
            if (mb_detect_encoding($text, 'UTF-8', true)) {
                // Text is UTF-8, convert to ISO-8859-1 for FPDF compatibility
                return iconv('UTF-8', 'ISO-8859-1//TRANSLIT', $text);
            }
            return $text;
        }
        
        // Override Cell method to ensure proper text encoding
        function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='') {
            // Ensure text is properly formatted for searchability
            $txt = trim($txt); // Remove extra whitespace
            $txt = preg_replace('/\s+/', ' ', $txt); // Normalize whitespace
            parent::Cell($w, $h, $this->EncodeText($txt), $border, $ln, $align, $fill, $link);
        }
        
        // Add method to set optimal font for searchability
        function SetSearchableFont($family='Arial', $style='', $size=10) {
            $this->SetFont($family, $style, $size);
            // Ensure text rendering mode is optimal for searchability
            $this->_out('2 Tr'); // Set text rendering mode to fill (most searchable)
        }
        
        // Page header
        function Header()
        {
            // Only show header on first page
            if ($this->PageNo() == 1) {
                // Set margins and padding
                $this->SetMargins(10, 10, 10);
                
                // Draw a subtle header background
                $this->SetFillColor(240, 240, 240);
                $this->Rect(0, 0, 210, 35, 'F');
                
                // Logo with adjusted position - add error handling
                try {
                    if (file_exists('./images/default_image.png')) {
                        $this->Image('./images/default_image.png', 10, 6, 30);
                    }
                } catch (Exception $e) {
                    // If image fails, just continue without it
                    error_log('Image loading failed: ' . $e->getMessage());
                }
                
                // Add current date on upper right
                $this->SetSearchableFont('Arial', '', 10);
                $this->SetTextColor(80, 80, 80); // Gray color for date
                $current_date = date('d/m/Y H:i:s');
                $this->SetXY(150, 8); // Position on upper right
                $this->Cell(50, 8, 'Fecha: ' . $current_date, 0, 0, 'R');
                
                // Add a decorative line
                $this->SetDrawColor(0, 128, 0); // Green line
                $this->Line(10, 35, 200, 35);
                
                // Main report title
                $this->SetFont('Arial', 'B', 18);
                $this->SetTextColor(0, 80, 0); // Darker green for main title
                
                $this->Ln(5);
                
                // Title section with animal name - add error handling
                if (isset($this->animalData) && isset($this->animalData['nombre'])) {
                    $this->SetSearchableFont('Arial', 'B', 16);
                    $this->SetTextColor(0, 100, 0); // Dark green color for title
                    // Center alignment for animal name - use strtoupper instead of mb_strtoupper
                    $animalName = strtoupper($this->animalData['nombre']);
                    $this->Cell(0, 10, $animalName, 0, 1, 'C');
                    
                    // Tag ID in a slightly smaller font, still professional
                    $this->SetSearchableFont('Arial', 'B', 12);
                    $this->SetTextColor(80, 80, 80); // Gray color for tag ID
                    // Center alignment for Tag ID
                    $this->Cell(0, 10, 'Tag ID: ' . $this->animalData['tagid'], 0, 1, 'C');
                } else {
                    // Fallback if animal data is not available
                    $this->SetSearchableFont('Arial', 'B', 16);
                    $this->SetTextColor(0, 100, 0);
                    $this->Cell(0, 10, 'REPORTE VETERINARIO', 0, 1, 'C');
                }
                $this->Ln(5);
                
                // Add animal images - add error handling
                if (!empty($this->animalData) && isset($this->animalData['image'])) {
                    // Photo section title
                    $this->SetFont('Arial', 'B', 12);
                    $this->SetTextColor(0, 0, 0);
                    $this->Cell(0, 5, 'CONDICION CORPORAL', 0, 1, 'C');
                    $this->Ln(1);
                    
                    // Start position for images
                    $y = 70; // Adjusted for the new title
                    $imageWidth = 60;
                    $spacing = 5;
                    
                    // Left position for first image
                    $x1 = 10;
                    // Left position for second image
                    $x2 = $x1 + $imageWidth + $spacing;
                    // Left position for third image
                    $x3 = $x2 + $imageWidth + $spacing;
                    
                    // Add first image if exists
                    if (!empty($this->animalData['image'])) {
                        $imagePath = $this->animalData['image'];
                        $imagePath = str_replace('\\', '/', $imagePath); // Normalize path
                        
                        // Validate image file before including
                        if ($this->isValidImageFile($imagePath)) {
                            // Paths to try
                            $pathsToTry = [
                                $imagePath,
                                './' . ltrim($imagePath, './'),
                                '../' . $imagePath,
                                $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imagePath, '/')
                            ];
                            
                            $imageAdded = false;
                            foreach ($pathsToTry as $path) {
                                if (file_exists($path) && $this->isValidImageFile($path)) {
                                    try {
                                        $this->Image($path, $x1, $y, $imageWidth);
                                        $imageAdded = true;
                                        break;
                                    } catch (Exception $e) {
                                        error_log("Failed to include image: $path - " . $e->getMessage());
                                        continue;
                                    }
                                }
                            }
                            
                            if (!$imageAdded) {
                                // Add placeholder text if image couldn't be loaded
                                $this->SetFont('Arial', 'I', 8);
                                $this->SetTextColor(128, 128, 128);
                                $this->SetXY($x1, $y + $imageWidth/2);
                                $this->Cell($imageWidth, 10, 'Imagen no disponible', 0, 0, 'C');
                                $this->SetTextColor(0, 0, 0);
                            }
                        } else {
                            error_log("Invalid image file: $imagePath");
                            // Add placeholder text
                            $this->SetFont('Arial', 'I', 8);
                            $this->SetTextColor(128, 128, 128);
                            $this->SetXY($x1, $y + $imageWidth/2);
                            $this->Cell($imageWidth, 10, 'Imagen no disponible', 0, 0, 'C');
                            $this->SetTextColor(0, 0, 0);
                        }
                    }
                    
                    // Add second image if exists
                    if (!empty($this->animalData['image2'])) {
                        $imagePath = $this->animalData['image2'];
                        $imagePath = str_replace('\\', '/', $imagePath); // Normalize path
                        
                        // Validate image file before including
                        if ($this->isValidImageFile($imagePath)) {
                            // Paths to try
                            $pathsToTry = [
                                $imagePath,
                                './' . ltrim($imagePath, './'),
                                '../' . $imagePath,
                                $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imagePath, '/')
                            ];
                            
                            $imageAdded = false;
                            foreach ($pathsToTry as $path) {
                                if (file_exists($path) && $this->isValidImageFile($path)) {
                                    try {
                                        $this->Image($path, $x2, $y, $imageWidth);
                                        $imageAdded = true;
                                        break;
                                    } catch (Exception $e) {
                                        error_log("Failed to include image: $path - " . $e->getMessage());
                                        continue;
                                    }
                                }
                            }
                            
                            if (!$imageAdded) {
                                // Add placeholder text if image couldn't be loaded
                                $this->SetFont('Arial', 'I', 8);
                                $this->SetTextColor(128, 128, 128);
                                $this->SetXY($x2, $y + $imageWidth/2);
                                $this->Cell($imageWidth, 10, 'Imagen no disponible', 0, 0, 'C');
                                $this->SetTextColor(0, 0, 0);
                            }
                        } else {
                            error_log("Invalid image file: $imagePath");
                            // Add placeholder text
                            $this->SetFont('Arial', 'I', 8);
                            $this->SetTextColor(128, 128, 128);
                            $this->SetXY($x2, $y + $imageWidth/2);
                            $this->Cell($imageWidth, 10, 'Imagen no disponible', 0, 0, 'C');
                            $this->SetTextColor(0, 0, 0);
                        }
                    }
                    
                    // Add third image if exists
                    if (!empty($this->animalData['image3'])) {
                        $imagePath = $this->animalData['image3'];
                        $imagePath = str_replace('\\', '/', $imagePath); // Normalize path
                        
                        // Validate image file before including
                        if ($this->isValidImageFile($imagePath)) {
                            // Paths to try
                            $pathsToTry = [
                                $imagePath,
                                './' . ltrim($imagePath, './'),
                                '../' . $imagePath,
                                $_SERVER['DOCUMENT_ROOT'] . '/' . ltrim($imagePath, '/')
                            ];
                            
                            $imageAdded = false;
                            foreach ($pathsToTry as $path) {
                                if (file_exists($path) && $this->isValidImageFile($path)) {
                                    try {
                                        $this->Image($path, $x3, $y, $imageWidth);
                                        $imageAdded = true;
                                        break;
                                    } catch (Exception $e) {
                                        error_log("Failed to include image: $path - " . $e->getMessage());
                                        continue;
                                    }
                                }
                            }
                            
                            if (!$imageAdded) {
                                // Add placeholder text if image couldn't be loaded
                                $this->SetFont('Arial', 'I', 8);
                                $this->SetTextColor(128, 128, 128);
                                $this->SetXY($x3, $y + $imageWidth/2);
                                $this->Cell($imageWidth, 10, 'Imagen no disponible', 0, 0, 'C');
                                $this->SetTextColor(0, 0, 0);
                            }
                        } else {
                            error_log("Invalid image file: $imagePath");
                            // Add placeholder text
                            $this->SetFont('Arial', 'I', 8);
                            $this->SetTextColor(128, 128, 128);
                            $this->SetXY($x3, $y + $imageWidth/2);
                            $this->Cell($imageWidth, 10, 'Imagen no disponible', 0, 0, 'C');
                            $this->SetTextColor(0, 0, 0);
                        }
                    }
                    
                    // Add image captions
                    $this->SetFont('Arial', 'I', 8);
                    $this->SetY($y + $imageWidth + 2);
                    $this->SetX($x1);
                    $this->Cell($imageWidth, 10, 'Foto Principal', 0, 0, 'C');
                    $this->SetX($x2);
                    $this->Cell($imageWidth, 10, 'Foto Secundaria', 0, 0, 'C');
                    $this->SetX($x3);
                    $this->Cell($imageWidth, 10, 'Foto Adicional', 0, 0, 'C');
                    
                    // Add extra space after images
                    $this->Ln(10);
                }
            }
        }

        // Page footer
        function Footer()
        {
            // Position at 1.5 cm from bottom
            $this->SetY(-15);
            // Arial italic 8
            $this->SetSearchableFont('Arial', 'I', 8);
            // Page number
            $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }

        // Draw a circle
        function Circle($x, $y, $r, $style='D')
        {
            $this->Ellipse($x, $y, $r, $r, $style);
        }
        
        // Draw an ellipse
        function Ellipse($x, $y, $rx, $ry, $style='D')
        {
            if($style=='F')
                $op='f';
            elseif($style=='FD' || $style=='DF')
                $op='B';
            else
                $op='S';
                
            $lx=4/3*(M_SQRT2-1)*$rx;
            $ly=4/3*(M_SQRT2-1)*$ry;
            $k=$this->k;
            $h=$this->h;
            
            $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
                ($x)*$k, ($h-$y)*$k,
                ($x+$lx)*$k, ($h-$y)*$k,
                ($x+$rx)*$k, ($h-$y+$ly)*$k,
                ($x+$rx)*$k, ($h-$y+$ry)*$k));
            $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
                ($x+$rx)*$k, ($h-$y+$ry+$ly)*$k,
                ($x+$lx)*$k, ($h-$y+$ry+$ry)*$k,
                ($x)*$k, ($h-$y+$ry+$ry)*$k));
            $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c',
                ($x-$lx)*$k, ($h-$y+$ry+$ry)*$k,
                ($x-$rx)*$k, ($h-$y+$ry+$ly)*$k,
                ($x-$rx)*$k, ($h-$y+$ry)*$k));
            $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s',
                ($x-$rx)*$k, ($h-$y+$ly)*$k,
                ($x-$lx)*$k, ($h-$y)*$k,
                ($x)*$k, ($h-$y)*$k,
                $op));
        }

        // Function to validate image files before including them
        function isValidImageFile($filePath)
        {
            // Check if file exists
            if (!file_exists($filePath)) {
                return false;
            }
            
            // Check file size (must be > 0)
            if (filesize($filePath) === 0) {
                return false;
            }
            
            // Check file extension
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
            
            if (!in_array($extension, $validExtensions)) {
                return false;
            }
            
            // Check MIME type
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $filePath);
            finfo_close($finfo);
            
            $validMimeTypes = [
                'image/jpeg',
                'image/jpg', 
                'image/png',
                'image/gif',
                'image/bmp'
            ];
            
            if (!in_array($mimeType, $validMimeTypes)) {
                return false;
            }
            
            // Try to get image info
            try {
                $imageInfo = getimagesize($filePath);
                if ($imageInfo === false) {
                    return false;
                }
                
                // Check if it's a valid image
                if ($imageInfo[0] <= 0 || $imageInfo[1] <= 0) {
                    return false;
                }
                
                return true;
            } catch (Exception $e) {
                error_log("Error validating image: $filePath - " . $e->getMessage());
                return false;
            }
        }

        // Function to styled chapter titles
        function ChapterTitle($title)
        {
            // Add animal tagid and nombre to the title (except for farm-wide statistics)
            $animalInfo = '';
            if ($this->animalData && isset($this->animalData['tagid']) && isset($this->animalData['nombre'])) {
                // Don't add animal info for farm-wide statistics (any title containing "(Finca)" or distribution reports)
                if (strpos($title, '(Finca)') === false && $title !== 'Distribucion por Raza' && $title !== 'Distribucion de Animales por Grupo' && $title !== 'Indice de Conversion Alimenticia (ICA)' && $title !== 'Resumen de Vacunaciones y Tratamientos' && $title !== 'Duracion de Gestaciones' && $title !== 'Hembras Sin Registro de Gestacion' && $title !== 'Animales con mas de 365 Dias Desde Ultimo Parto' && $title !== 'ESTADISTICAS DE LA FINCA') {
                    $animalInfo = ' ' . $this->animalData['tagid'] . ' (' . $this->animalData['nombre'] . ')';
                }
            }
            $fullTitle = $title . $animalInfo;
            
            $this->SetSearchableFont('Arial', 'B', 12);
            $this->SetFillColor(0, 100, 0); // Darker green
            $this->SetTextColor(255, 255, 255); // White text
            
            // Check if this is a main section title (all caps)
            if ($title == 'PRODUCCION' || $title == 'ALIMENTACION' || $title == 'SALUD' || 
                $title == 'REPRODUCCION' || $title == 'ESTADISTICAS DE LA FINCA') {
                // Main section titles - centered, larger font, more space before/after
                $this->SetSearchableFont('Arial', 'B', 14);
                $this->Ln(5); // Extra space before main sections
                $this->Cell(0, 10, $fullTitle, 0, 1, 'C', true);
                $this->Ln(5); // Extra space after main sections
            } else {
                // Regular subsection titles - left aligned
                $this->Cell(0, 8, $fullTitle, 0, 1, 'L', true);
                $this->Ln(3);
            }
            
            $this->SetTextColor(0, 0, 0); // Reset to black text
        }

        // Data table
        function DataTable($header, $data)
        {
            // Column widths
            $w = array(40, 50, 40, 50);
            
            // Header
            $this->SetSearchableFont('Arial', 'B', 10);
            $this->SetFillColor(50, 120, 50); // Darker green for header
            $this->SetTextColor(255, 255, 255); // White text for better contrast
            for ($i = 0; $i < count($header); $i++) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            }
            $this->Ln();
            $this->SetTextColor(0, 0, 0); // Reset to black text for data
            
            // Data
            $this->SetSearchableFont('Arial', '', 9); // Match SimpleTable font size
            $this->SetFillColor(245, 250, 245); // Match SimpleTable fill color
            $fill = false;
            foreach ($data as $row) {
                for ($i = 0; $i < count($row); $i++) {
                    $this->Cell($w[$i], 6, $row[$i], 1, 0, 'C', $fill); // Center align all cells
                }
                $this->Ln();
                $fill = !$fill;
            }
            $this->Ln(5);
        }
        
        // Simple table for two columns
        function SimpleTable($header, $data)
        {
            // Determine column count and adjust widths accordingly
            $columnCount = count($header);
            
            // Default column widths
            if ($columnCount == 2) {
                $w = array(60, 120); // Original 2-column layout
            } elseif ($columnCount == 3) {
                $w = array(50, 50, 80); // 3-column layout (date, value, price)
            } elseif ($columnCount == 4) {
                $w = array(40, 60, 40, 40); // 4-column layout
            } else {
                // Create automatic column widths
                $pageWidth = $this->GetPageWidth() - 20; // Adjust for margins
                $w = array_fill(0, $columnCount, $pageWidth / $columnCount);
            }
            
            // Check if this is a table that needs special formatting
            if (in_array('Precio ($/Kg)', $header) || in_array('Dosis', $header)) {
                // Special column widths for tables with price or dose fields
                if ($columnCount == 3) {
                    $w = array(45, 60, 75); // Date, Weight/Product, Price/Dose
                }
            }
            
            // Header with background
            $this->SetSearchableFont('Arial', 'B', 10);
            $this->SetFillColor(50, 120, 50); // Darker green for header
            $this->SetTextColor(255, 255, 255); // White text for better contrast
            for ($i = 0; $i < $columnCount; $i++) {
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            }
            $this->Ln();
            $this->SetTextColor(0, 0, 0); // Reset to black text for data
            
            // Data
            $this->SetSearchableFont('Arial', '', 9); // Slightly smaller font to fit more text
            $this->SetFillColor(245, 250, 245); // Lighter green tint
            $fill = false;
            
            foreach ($data as $row) {
                // Make sure we have the right number of cells
                $rowCount = count($row);
                for ($i = 0; $i < $columnCount; $i++) {
                    // If the cell exists in data, display it, otherwise display empty cell
                    $cellContent = ($i < $rowCount) ? $row[$i] : '';
                    
                    // Center align all data cells for consistency
                    $align = 'C';
                    
                    $this->Cell($w[$i], 6, $cellContent, 1, 0, $align, $fill);
                }
                $this->Ln();
                $fill = !$fill;
            }
            
            // Add space after table
            $this->Ln(5);
        }
    }
}

// Create PDF instance
try {
    $pdf = new PDF();
    $pdf->setAnimalData($animal);
    error_log("PDF instance created successfully");
} catch (Exception $e) {
    error_log('Failed to create PDF instance: ' . $e->getMessage());
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to create PDF instance: ' . $e->getMessage()]);
        exit;
    } else {
        die('Failed to create PDF instance: ' . $e->getMessage());
    }
}

// Set UTF-8 metadata for better searchability
try {
    $pdf->SetTitle('Reporte Veterinario - ' . $animal['nombre'] . ' (' . $animal['tagid'] . ')', true);
    $pdf->SetAuthor('Sistema Ganagram', true);
    $pdf->SetSubject('Historial Veterinario Completo', true);
    $pdf->SetKeywords('veterinario, ganado, bovino, historial, ' . $animal['tagid'] . ', ' . $animal['nombre'], true);
    $pdf->SetCreator('Ganagram - Sistema de Gestión Ganadera', true);
    error_log("PDF metadata set successfully");
} catch (Exception $e) {
    error_log('Failed to set PDF metadata: ' . $e->getMessage());
    // Continue anyway as this is not critical
}

$pdf->AliasNbPages();
try {
    $pdf->AddPage();
    error_log("First PDF page added successfully");
} catch (Exception $e) {
    error_log('Failed to add first page: ' . $e->getMessage());
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to add first page: ' . $e->getMessage()]);
        exit;
    } else {
        die('Failed to add first page: ' . $e->getMessage());
    }
}

// Basic animal information
$pdf->ChapterTitle('Datos');
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

// Peso history
try {
    $pdf->AddPage();
    $pdf->ChapterTitle('Tabla Pesos del animal');
    $sql_weight = "SELECT bh_peso_tagid, bh_peso_fecha, bh_peso_animal, bh_peso_precio FROM bh_peso WHERE bh_peso_tagid = ? ORDER BY bh_peso_fecha DESC";
    $stmt_weight = $conn->prepare($sql_weight);
    if (!$stmt_weight) {
        throw new Exception('Failed to prepare weight query: ' . mysqli_error($conn));
    }
    $stmt_weight->bind_param('s', $tagid);
    $stmt_weight->execute();
    $result_weight = $stmt_weight->get_result();

    if ($result_weight->num_rows > 0) {
        $header = array('Tag ID', 'Fecha', 'Peso (kg)', 'Precio ($/Kg)');
        $data = array();
        while ($row = $result_weight->fetch_assoc()) {
            $data[] = array($row['bh_peso_tagid'], $row['bh_peso_fecha'], $row['bh_peso_animal'], $row['bh_peso_precio']);
        }
        $pdf->SimpleTable($header, $data);

    } else {
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 5, 'No hay regisros de pesajes', 0, 1);
        $pdf->Ln(2);
    }
} catch (Exception $e) {
    error_log('Error in peso history section: ' . $e->getMessage());
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'Error cargando datos de peso: ' . $e->getMessage(), 0, 1);
    $pdf->Ln(2);
}   

// Leche
try {
    $pdf->AddPage();
    $pdf->ChapterTitle('Tabla Leche del animal');
    $sql_leche = "SELECT bh_leche_tagid, bh_leche_fecha_inicio, bh_leche_fecha_fin, bh_leche_peso, bh_leche_precio FROM bh_leche WHERE bh_leche_tagid = ? ORDER BY bh_leche_fecha_inicio DESC";
    $stmt_leche = $conn->prepare($sql_leche);
    if (!$stmt_leche) {
        throw new Exception('Failed to prepare leche query: ' . mysqli_error($conn));
    }
    $stmt_leche->bind_param('s', $tagid);
    $stmt_leche->execute();
    $result_leche = $stmt_leche->get_result();

    if ($result_leche->num_rows > 0) {
        $header = array('Tag ID', 'Fecha Inicio', 'Fecha Fin', 'Peso (kg)', 'Precio ($/Kg)');
        $data = array();
        while ($row = $result_leche->fetch_assoc()) {
            $data[] = array($row['bh_leche_tagid'], $row['bh_leche_fecha_inicio'], $row['bh_leche_fecha_fin'], $row['bh_leche_peso'], $row['bh_leche_precio']);
        }
        $pdf->SimpleTable($header, $data);
    } else {
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 5, 'No hay registros de produccion de leche', 0, 1);
        $pdf->Ln(2);
    }
} catch (Exception $e) {
    error_log('Error in leche section: ' . $e->getMessage());
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'Error cargando datos de leche: ' . $e->getMessage(), 0, 1);
    $pdf->Ln(2);
}

// Concentrado
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Concentrado del animal');
$sql_concentrado = "SELECT bh_concentrado_tagid, bh_concentrado_fecha_inicio, bh_concentrado_fecha_fin, bh_concentrado_racion, bh_concentrado_costo FROM bh_concentrado WHERE bh_concentrado_tagid = ? ORDER BY bh_concentrado_fecha_inicio DESC";
$stmt_concentrado = $conn->prepare($sql_concentrado);
$stmt_concentrado->bind_param('s', $tagid);
$stmt_concentrado->execute();
$result_concentrado = $stmt_concentrado->get_result();

if ($result_concentrado->num_rows > 0) {
    $header = array('Tag ID', 'Fecha Inicio', 'Fecha Fin', 'Días', 'Consumo Diario (kg)', 'Precio ($/Kg)', 'Gasto Total ($)');
    $data = array();
    while ($row = $result_concentrado->fetch_assoc()) {
        // Calculate days difference
        $fecha_inicio = new DateTime($row['bh_concentrado_fecha_inicio']);
        $fecha_fin = new DateTime($row['bh_concentrado_fecha_fin']);
        $dias = $fecha_fin->diff($fecha_inicio)->days + 1; // +1 to include both start and end days
        
        // Calculate total expense: days * daily_ration * cost_per_kg
        $gasto_total = $dias * $row['bh_concentrado_racion'] * $row['bh_concentrado_costo'];
        
        $data[] = array(
            $row['bh_concentrado_tagid'], 
            $row['bh_concentrado_fecha_inicio'], 
            $row['bh_concentrado_fecha_fin'], 
            $dias,
            $row['bh_concentrado_racion'], 
            $row['bh_concentrado_costo'],
            number_format($gasto_total, 2)
        );
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de concentrado', 0, 1);
    $pdf->Ln(2);
}

// Salt
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Sal del animal');
$sql_salt = "SELECT bh_sal_tagid, bh_sal_fecha_inicio, bh_sal_fecha_fin, bh_sal_racion, bh_sal_costo FROM bh_sal WHERE bh_sal_tagid = ? ORDER BY bh_sal_fecha_inicio DESC";
$stmt_salt = $conn->prepare($sql_salt);
$stmt_salt->bind_param('s', $tagid);
$stmt_salt->execute();
$result_salt = $stmt_salt->get_result();

if ($result_salt->num_rows > 0) {
    $header = array('Tag ID', 'Fecha Inicio', 'Fecha Fin', 'Días', 'Consumo Diario (kg)', 'Costo ($/Kg)', 'Gasto Total ($)');
    $data = array();
    while ($row = $result_salt->fetch_assoc()) {
        // Calculate days difference
        $fecha_inicio = new DateTime($row['bh_sal_fecha_inicio']);
        $fecha_fin = new DateTime($row['bh_sal_fecha_fin']);
        $dias = $fecha_fin->diff($fecha_inicio)->days + 1; // +1 to include both start and end days
        
        // Calculate total expense: days * daily_ration * cost_per_kg
        $gasto_total = $dias * $row['bh_sal_racion'] * $row['bh_sal_costo'];
        
        $data[] = array(
            $row['bh_sal_tagid'], 
            $row['bh_sal_fecha_inicio'], 
            $row['bh_sal_fecha_fin'], 
            $dias,
            $row['bh_sal_racion'], 
            $row['bh_sal_costo'],
            number_format($gasto_total, 2)
        );
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de sal', 0, 1);
    $pdf->Ln(2);
}

// Molasses
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Melaza del animal');
$sql_molasses = "SELECT bh_melaza_tagid, bh_melaza_fecha_inicio, bh_melaza_fecha_fin, bh_melaza_racion, bh_melaza_costo FROM bh_melaza WHERE bh_melaza_tagid = ? ORDER BY bh_melaza_fecha_inicio DESC";
$stmt_molasses = $conn->prepare($sql_molasses);
$stmt_molasses->bind_param('s', $tagid);
$stmt_molasses->execute();
$result_molasses = $stmt_molasses->get_result();

if ($result_molasses->num_rows > 0) {
    $header = array('Tag ID', 'Fecha Inicio', 'Fecha Fin', 'Días', 'Consumo Diario (kg)', 'Costo ($/Kg)', 'Gasto Total ($)');
    $data = array();
    while ($row = $result_molasses->fetch_assoc()) {
        // Calculate days difference
        $fecha_inicio = new DateTime($row['bh_melaza_fecha_inicio']);
        $fecha_fin = new DateTime($row['bh_melaza_fecha_fin']);
        $dias = $fecha_fin->diff($fecha_inicio)->days + 1; // +1 to include both start and end days
        
        // Calculate total expense: days * daily_ration * cost_per_kg
        $gasto_total = $dias * $row['bh_melaza_racion'] * $row['bh_melaza_costo'];
        
        $data[] = array(
            $row['bh_melaza_tagid'], 
            $row['bh_melaza_fecha_inicio'], 
            $row['bh_melaza_fecha_fin'], 
            $dias,
            $row['bh_melaza_racion'], 
            $row['bh_melaza_costo'],
            number_format($gasto_total, 2)
        );
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de melaza', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Aftosa
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Aftosa del animal');
$pdf->ChapterTitle('Aftosa');
$sql_aftosa = "SELECT bh_aftosa_tagid, bh_aftosa_fecha, bh_aftosa_producto, bh_aftosa_dosis, bh_aftosa_costo FROM bh_aftosa WHERE bh_aftosa_tagid = ? ORDER BY bh_aftosa_fecha DESC";
$stmt_aftosa = $conn->prepare($sql_aftosa);
$stmt_aftosa->bind_param('s', $tagid);
$stmt_aftosa->execute();
$result_aftosa = $stmt_aftosa->get_result();

if ($result_aftosa->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
    $data = array();
    while ($row = $result_aftosa->fetch_assoc()) {
        $data[] = array($row['bh_aftosa_tagid'], $row['bh_aftosa_fecha'], $row['bh_aftosa_producto'], $row['bh_aftosa_dosis'], $row['bh_aftosa_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion aftosa', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Brucelosis
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Brucelosis');
$sql_bruc = "SELECT bh_brucelosis_tagid, bh_brucelosis_fecha, bh_brucelosis_producto, bh_brucelosis_dosis, bh_brucelosis_costo FROM bh_brucelosis WHERE bh_brucelosis_tagid = ? ORDER BY bh_brucelosis_fecha DESC";
$stmt_bruc = $conn->prepare($sql_bruc);
$stmt_bruc->bind_param('s', $tagid);
$stmt_bruc->execute();
$result_bruc = $stmt_bruc->get_result();

if ($result_bruc->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
    $data = array();
    while ($row = $result_bruc->fetch_assoc()) {
        $data[] = array($row['bh_brucelosis_tagid'], $row['bh_brucelosis_fecha'], $row['bh_brucelosis_producto'], $row['bh_brucelosis_dosis'], $row['bh_brucelosis_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion brucelosis', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - Carbunco
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Carbunco');
$sql_carbunco = "SELECT bh_carbunco_tagid, bh_carbunco_fecha, bh_carbunco_producto, bh_carbunco_dosis, bh_carbunco_costo FROM bh_carbunco WHERE bh_carbunco_tagid = ? ORDER BY bh_carbunco_fecha DESC";
$stmt_carbunco = $conn->prepare($sql_carbunco);
$stmt_carbunco->bind_param('s', $tagid);
$stmt_carbunco->execute();
$result_carbunco = $stmt_carbunco->get_result();

if ($result_carbunco->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
    $data = array();
    while ($row = $result_carbunco->fetch_assoc()) {
        $data[] = array($row['bh_carbunco_tagid'], $row['bh_carbunco_fecha'], $row['bh_carbunco_producto'], $row['bh_carbunco_dosis'], $row['bh_carbunco_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion carbunco', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - IBR
$pdf->AddPage();
$pdf->ChapterTitle('Tabla IBR');
$sql_ibr = "SELECT bh_ibr_tagid, bh_ibr_fecha, bh_ibr_producto, bh_ibr_dosis, bh_ibr_costo FROM bh_ibr WHERE bh_ibr_tagid = ? ORDER BY bh_ibr_fecha DESC";
$stmt_ibr = $conn->prepare($sql_ibr);
$stmt_ibr->bind_param('s', $tagid);
$stmt_ibr->execute();
$result_ibr = $stmt_ibr->get_result();

if ($result_ibr->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
    $data = array();
    while ($row = $result_ibr->fetch_assoc()) {
        $data[] = array($row['bh_ibr_tagid'], $row['bh_ibr_fecha'], $row['bh_ibr_producto'], $row['bh_ibr_dosis'], $row['bh_ibr_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion IBR', 0, 1);
    $pdf->Ln(2);
}

// Vaccination - CBR
$pdf->AddPage();
$pdf->ChapterTitle('Tabla CBR');
$sql_cbr = "SELECT bh_cbr_tagid, bh_cbr_fecha, bh_cbr_producto, bh_cbr_dosis, bh_cbr_costo FROM bh_cbr WHERE bh_cbr_tagid = ? ORDER BY bh_cbr_fecha DESC";
$stmt_cbr = $conn->prepare($sql_cbr);
$stmt_cbr->bind_param('s', $tagid);
$stmt_cbr->execute();
$result_cbr = $stmt_cbr->get_result();

if ($result_cbr->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
    $data = array();
    while ($row = $result_cbr->fetch_assoc()) {
        $data[] = array($row['bh_cbr_tagid'], $row['bh_cbr_fecha'], $row['bh_cbr_producto'], $row['bh_cbr_dosis'], $row['bh_cbr_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de vacunacion CBR', 0, 1);
    $pdf->Ln(2);
}

// Parasites Treatment
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Parasitos');
$sql_para = "SELECT bh_parasitos_tagid, bh_parasitos_fecha, bh_parasitos_producto, bh_parasitos_dosis, bh_parasitos_costo FROM bh_parasitos WHERE bh_parasitos_tagid = ? ORDER BY bh_parasitos_fecha DESC";
$stmt_para = $conn->prepare($sql_para);
$stmt_para->bind_param('s', $tagid);
$stmt_para->execute();
$result_para = $stmt_para->get_result();

if ($result_para->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
    $data = array();
    while ($row = $result_para->fetch_assoc()) {
        $data[] = array($row['bh_parasitos_tagid'], $row['bh_parasitos_fecha'], $row['bh_parasitos_producto'], $row['bh_parasitos_dosis'], $row['bh_parasitos_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de tratamiento parasitos', 0, 1);
    $pdf->Ln(2);
}

// Garrapatas Treatment
try {
    $pdf->AddPage();
    $pdf->ChapterTitle('Tabla Garrapatas');
    $sql_tick = "SELECT bh_garrapatas_tagid, bh_garrapatas_fecha, bh_garrapatas_producto, bh_garrapatas_dosis, bh_garrapatas_costo FROM bh_garrapatas WHERE bh_garrapatas_tagid = ? ORDER BY bh_garrapatas_fecha DESC";
    $stmt_tick = $conn->prepare($sql_tick);
    if (!$stmt_tick) {
        throw new Exception('Failed to prepare garrapatas query: ' . mysqli_error($conn));
    }
    $stmt_tick->bind_param('s', $tagid);
    $stmt_tick->execute();
    $result_tick = $stmt_tick->get_result();

    if ($result_tick->num_rows > 0) {
        $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
        $data = array();
        while ($row = $result_tick->fetch_assoc()) {
            $data[] = array($row['bh_garrapatas_tagid'], $row['bh_garrapatas_fecha'], $row['bh_garrapatas_producto'], $row['bh_garrapatas_dosis'], $row['bh_garrapatas_costo']);
        }
        $pdf->SimpleTable($header, $data);
    } else {
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 5, 'No hay registros de tratamiento garrapatas', 0, 1);
        $pdf->Ln(2);
    }
} catch (Exception $e) {
    error_log('Error in garrapatas section: ' . $e->getMessage());
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'Error cargando datos de garrapatas: ' . $e->getMessage(), 0, 1);
    $pdf->Ln(2);
}

// Mastitis Treatment
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Mastitis');
$sql_mastitis = "SELECT bh_mastitis_tagid, bh_mastitis_fecha, bh_mastitis_producto, bh_mastitis_dosis, bh_mastitis_costo FROM bh_mastitis WHERE bh_mastitis_tagid = ? ORDER BY bh_mastitis_fecha DESC";
$stmt_mastitis = $conn->prepare($sql_mastitis);
$stmt_mastitis->bind_param('s', $tagid);
$stmt_mastitis->execute();
$result_mastitis = $stmt_mastitis->get_result();

if ($result_mastitis->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Producto', 'Dosis (ml)', 'Costo ($)');
    $data = array();
    while ($row = $result_mastitis->fetch_assoc()) {
        $data[] = array($row['bh_mastitis_tagid'], $row['bh_mastitis_fecha'], $row['bh_mastitis_producto'], $row['bh_mastitis_dosis'], $row['bh_mastitis_costo']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de tratamiento mastitis', 0, 1);
    $pdf->Ln(2);
}

// Inseminacion
$pdf->AddPage();
$pdf->ChapterTitle('REPRODUCCION');
$pdf->ChapterTitle('Tabla Inseminaciones del animal');
$sql_ins = "SELECT bh_inseminacion_tagid, bh_inseminacion_fecha, bh_inseminacion_numero FROM bh_inseminacion WHERE bh_inseminacion_tagid = ? ORDER BY bh_inseminacion_fecha DESC";
$stmt_ins = $conn->prepare($sql_ins);
$stmt_ins->bind_param('s', $tagid);
$stmt_ins->execute();
$result_ins = $stmt_ins->get_result();

if ($result_ins->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Inseminacion Nro.');
    $data = array();
    while ($row = $result_ins->fetch_assoc()) {
        $data[] = array($row['bh_inseminacion_tagid'], $row['bh_inseminacion_fecha'], $row['bh_inseminacion_numero']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de inseminaciones', 0, 1);
    $pdf->Ln(2);
}

// Gestacion
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Gestaciones del animal');
$sql_preg = "SELECT bh_gestacion_tagid, bh_gestacion_fecha, bh_gestacion_numero FROM bh_gestacion WHERE bh_gestacion_tagid = ? ORDER BY bh_gestacion_fecha DESC";
$stmt_preg = $conn->prepare($sql_preg);
$stmt_preg->bind_param('s', $tagid);
$stmt_preg->execute();
$result_preg = $stmt_preg->get_result();

if ($result_preg->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Gestacion Nro.');
    $data = array();
    while ($row = $result_preg->fetch_assoc()) {
        $data[] = array($row['bh_gestacion_tagid'], $row['bh_gestacion_fecha'], $row['bh_gestacion_numero']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No registros de gestacion encontrados', 0, 1);
    $pdf->Ln(2);
}

// Parto
$pdf->AddPage();
$pdf->ChapterTitle('Tabla Partos del animal');
$sql_birth = "SELECT bh_parto_tagid, bh_parto_fecha, bh_parto_numero FROM bh_parto WHERE bh_parto_tagid = ? ORDER BY bh_parto_fecha DESC";
$stmt_birth = $conn->prepare($sql_birth);
$stmt_birth->bind_param('s', $tagid);
$stmt_birth->execute();
$result_birth = $stmt_birth->get_result();

if ($result_birth->num_rows > 0) {
    $header = array('Tag ID', 'Fecha', 'Parto Nro.');
    $data = array();
    while ($row = $result_birth->fetch_assoc()) {
        $data[] = array($row['bh_parto_tagid'], $row['bh_parto_fecha'], $row['bh_parto_numero']);
    }
    $pdf->SimpleTable($header, $data);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de partos', 0, 1);
    $pdf->Ln(2);
}

// Add Monthly Farm Weight Statistics
$pdf->AddPage();
$pdf->ChapterTitle('ESTADISTICAS DE LA FINCA');

// Add Breed Distribution Statistics
$pdf->ChapterTitle('Razas');

// SQL to get breed distribution
$sql_breeds = "SELECT 
    raza,
    COUNT(*) as total_animales,
    ROUND((COUNT(*) * 100.0) / (SELECT COUNT(*) FROM bufalino WHERE estatus = 'Activo'), 1) as porcentaje
FROM bufalino 
WHERE estatus = 'Activo'
GROUP BY raza
ORDER BY total_animales DESC";

$result_breeds = $conn->query($sql_breeds);

if ($result_breeds->num_rows > 0) {
    $header = array('Raza', 'Total Animales', 'Porcentaje (%)');
    $data = array();
    $total_animals = 0;
    
    while ($row = $result_breeds->fetch_assoc()) {
        $data[] = array(
            $row['raza'] ?: 'No Especificada',  // Handle NULL or empty breed
            $row['total_animales'],
            number_format($row['porcentaje'], 1)
        );
        $total_animals += $row['total_animales'];
    }
    
    // Add total row
    $data[] = array(
        'TOTAL',
        $total_animals,
        '100.0'
    );
    
    $pdf->SimpleTable($header, $data);
    
    // Add explanatory note
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->Cell(0, 5, 'Nota: Porcentajes calculados sobre el total de animales activos en el sistema.', 0, 1);
    $pdf->Ln(2);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de animales para generar la distribucion por razas', 0, 1);
    $pdf->Ln(2);
}

// Add Animal Distribution by Group
$pdf->ChapterTitle('Grupos');

// SQL to get animal distribution by group
$sql_groups = "SELECT 
    grupo,
    COUNT(*) as total_animales,
    ROUND((COUNT(*) * 100.0) / (SELECT COUNT(*) FROM bufalino WHERE estatus = 'Activo'), 1) as porcentaje
FROM bufalino 
WHERE estatus = 'Activo'
GROUP BY grupo
ORDER BY total_animales DESC";

$result_groups = $conn->query($sql_groups);

if ($result_groups->num_rows > 0) {
    $header = array('Grupo', 'Total Animales', 'Porcentaje (%)');
    $data = array();
    $total_animals = 0;
    
    while ($row = $result_groups->fetch_assoc()) {
        $data[] = array(
            $row['grupo'],
            $row['total_animales'],
            number_format($row['porcentaje'], 1)
        );
        $total_animals += $row['total_animals'];
    }
    
    // Add total row
    $data[] = array(
        'TOTAL',
        $total_animals,
        '100.0'
    );
    
    $pdf->SimpleTable($header, $data);
    
    // Add explanatory note
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->Cell(0, 5, 'Nota: Porcentajes calculados sobre el total de animales activos en el sistema.', 0, 1);
    $pdf->Ln(2);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de animales para generar la distribucion por grupos', 0, 1);
    $pdf->Ln(2);
}


//Estadisticas------------------

// Add Monthly Weight Statistics
$pdf->AddPage();
$pdf->ChapterTitle('Produccion Carnica');

// SQL to get monthly total weight with averages for multiple weights in same month
$sql_monthly = "WITH MonthlyWeights AS (
    SELECT 
        DATE_FORMAT(bh_peso_fecha, '%Y-%m-01') as primer_dia_mes,
        bh_peso_tagid,
        AVG(bh_peso_animal) as peso_promedio_animal
    FROM bh_peso 
    GROUP BY DATE_FORMAT(bh_peso_fecha, '%Y-%m-01'), bh_peso_tagid
)
SELECT 
    primer_dia_mes as mes,
    COUNT(DISTINCT bh_peso_tagid) as total_animales,
    ROUND(SUM(peso_promedio_animal), 2) as peso_total,
    ROUND(AVG(peso_promedio_animal), 2) as peso_promedio
FROM MonthlyWeights
GROUP BY primer_dia_mes
ORDER BY primer_dia_mes DESC
LIMIT 12";  // Last 12 months

$result_monthly = $conn->query($sql_monthly);

if ($result_monthly->num_rows > 0) {
    $header = array('Mes', 'Total Animales', 'Peso Total (kg)', 'Promedio (kg)');
    $data = array();
    $total_weight = 0;
    $total_months = 0;
    $min_weight = PHP_FLOAT_MAX;
    $max_weight = 0;
    
    while ($row = $result_monthly->fetch_assoc()) {
        // Format the month to Spanish format
        $date = DateTime::createFromFormat('Y-m-d', $row['mes']);
        $mes_espanol = strftime('%B %Y', $date->getTimestamp());
        $mes_espanol = ucfirst(mb_strtolower($mes_espanol, 'UTF-8'));
        
        $data[] = array(
            $mes_espanol,
            $row['total_animales'],
            number_format($row['peso_total'], 2),
            number_format($row['peso_promedio'], 2)
        );
        
        // Track statistics
        $total_weight += $row['peso_promedio'];
        $total_months++;
        $min_weight = min($min_weight, $row['peso_promedio']);
        $max_weight = max($max_weight, $row['peso_promedio']);
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add statistics
    if ($total_months > 0) {
        $overall_average = $total_weight / $total_months;
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(5);
        $pdf->Cell(0, 6, 'ESTADISTICAS DE PESO:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, sprintf('Promedio General: %.2f kg', $overall_average), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Peso Minimo Mensual: %.2f kg', $min_weight), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Peso Maximo Mensual: %.2f kg', $max_weight), 0, 1, 'L');
    }
    
    // Add explanatory note
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, 'Notas:
- Los pesos se calculan como un promedio mensual por animal.
- Si hay varios pesos para un animal en el mismo mes, se usa el promedio.
- El peso total es la suma de los pesos promedio de todos los animales del mes.
- El promedio mensual es el peso total dividido por el numero de animales.
- Las estadisticas muestran la tendencia de peso en los ultimos 12 meses.', 0, 'L');
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de peso para generar estadisticas mensuales', 0, 1);
    $pdf->Ln(2);
}

// Add Monthly Milk Production Statistics
$pdf->AddPage();    
$pdf->ChapterTitle('Produccion lechera');

// SQL to get monthly milk production with daily calculations and costs
$sql_milk_monthly = "WITH MonthlyMilk AS (
    SELECT 
        DATE_FORMAT(bh_leche_fecha_inicio, '%Y-%m-01') as primer_dia_mes,
        bh_leche_tagid,
        AVG(bh_leche_peso) as produccion_diaria_promedio,
        AVG(bh_leche_precio) as precio_promedio
    FROM bh_leche
    GROUP BY DATE_FORMAT(bh_leche_fecha_inicio, '%Y-%m-01'), bh_leche_tagid
),
MonthlyStats AS (
    SELECT 
        primer_dia_mes as mes,
        COUNT(DISTINCT bh_leche_tagid) as total_vacas,
        ROUND(SUM(produccion_diaria_promedio), 2) as produccion_diaria_total,
        ROUND(AVG(produccion_diaria_promedio), 2) as promedio_diario_por_vaca,
        ROUND(AVG(precio_promedio), 2) as precio_promedio_mes
    FROM MonthlyMilk
    GROUP BY primer_dia_mes
)
SELECT 
    mes,
    total_vacas,
    produccion_diaria_total,
    produccion_diaria_total * DAY(LAST_DAY(mes)) as produccion_total_mes,
    promedio_diario_por_vaca,
    promedio_diario_por_vaca * DAY(LAST_DAY(mes)) as promedio_mensual_por_vaca,
    precio_promedio_mes
FROM MonthlyStats
ORDER BY mes DESC
LIMIT 12";

$result_milk_monthly = $conn->query($sql_milk_monthly);

if ($result_milk_monthly->num_rows > 0) {
    $header = array('Mes', '# Vacas', 'Prod. Diaria', 'Prod. Mensual', 'Diario x Vaca', 'Mensual x Vaca', 'Precio Prom.');
    $data = array();
    
    // Statistics tracking
    $total_production = 0;
    $total_months = 0;
    $min_daily_per_cow = PHP_FLOAT_MAX;
    $max_daily_per_cow = 0;
    $total_daily_per_cow = 0;
    
    while ($row = $result_milk_monthly->fetch_assoc()) {
        // Format the month to Spanish format
        $date = DateTime::createFromFormat('Y-m-d', $row['mes']);
        $mes_espanol = strftime('%B %Y', $date->getTimestamp());
        $mes_espanol = ucfirst(mb_strtolower($mes_espanol, 'UTF-8'));
        
        $data[] = array(
            $mes_espanol,
            $row['total_vacas'],
            number_format($row['produccion_diaria_total'], 2),
            number_format($row['produccion_total_mes'], 2),
            number_format($row['promedio_diario_por_vaca'], 2),
            number_format($row['promedio_mensual_por_vaca'], 2),
            number_format($row['precio_promedio_mes'], 2)
        );
        
        // Track statistics
        $total_production += $row['produccion_total_mes'];
        $total_daily_per_cow += $row['promedio_diario_por_vaca'];
        $min_daily_per_cow = min($min_daily_per_cow, $row['promedio_diario_por_vaca']);
        $max_daily_per_cow = max($max_daily_per_cow, $row['promedio_diario_por_vaca']);
        $total_months++;
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add statistics summary
    if ($total_months > 0) {
        $avg_daily_per_cow = $total_daily_per_cow / $total_months;
        $avg_monthly_production = $total_production / $total_months;
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(5);
        $pdf->Cell(0, 6, 'ESTADISTICAS GENERALES:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, sprintf('Produccion Mensual Promedio: %.2f litros', $avg_monthly_production), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Promedio Diario por Vaca: %.2f litros', $avg_daily_per_cow), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Minimo Diario por Vaca: %.2f litros', $min_daily_per_cow), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Maximo Diario por Vaca: %.2f litros', $max_daily_per_cow), 0, 1, 'L');
    }
    
    // Add explanatory notes
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, 'Notas:
- La produccion se calcula como un promedio diario por animal por mes.
- Si hay varios registros para un animal en el mismo mes, se usa el promedio.
- La produccion diaria total es la suma de los promedios diarios de todas las vacas.
- La produccion mensual se calcula multiplicando la produccion diaria por los dias del mes.
- El promedio por vaca representa la produccion individual promedio.
- Los precios mostrados son promedios mensuales por litro.
- Las estadisticas muestran la tendencia de produccion en los ultimos 12 meses.', 0, 'L');
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de produccion de leche para generar estadisticas mensuales', 0, 1);
    $pdf->Ln(2);
}

// Add Monthly Feed Consumption Statistics
$pdf->AddPage();    
$pdf->ChapterTitle('Consumo Concentrado');

// SQL to get monthly feed consumption with daily calculations and costs
$sql_feed_monthly = "WITH MonthlyFeed AS (
    SELECT 
        DATE_FORMAT(bh_concentrado_fecha_inicio, '%Y-%m-01') as primer_dia_mes,
        bh_concentrado_tagid,
        AVG(bh_concentrado_racion) as consumo_diario_promedio,
        AVG(bh_concentrado_costo) as costo_promedio
    FROM bh_concentrado
    GROUP BY DATE_FORMAT(bh_concentrado_fecha_inicio, '%Y-%m-01'), bh_concentrado_tagid
),
MonthlyStats AS (
    SELECT 
        primer_dia_mes as mes,
        COUNT(DISTINCT bh_concentrado_tagid) as total_animales,
        ROUND(SUM(consumo_diario_promedio), 2) as consumo_diario_total,
        ROUND(AVG(consumo_diario_promedio), 2) as promedio_diario_por_animal,
        ROUND(AVG(costo_promedio), 2) as costo_promedio_mes
    FROM MonthlyFeed
    GROUP BY primer_dia_mes
)
SELECT 
    mes,
    total_animales,
    consumo_diario_total,
    consumo_diario_total * DAY(LAST_DAY(mes)) as consumo_total_mes,
    promedio_diario_por_animal,
    promedio_diario_por_animal * DAY(LAST_DAY(mes)) as promedio_mensual_por_animal,
    costo_promedio_mes,
    ROUND(consumo_diario_total * DAY(LAST_DAY(mes)) * costo_promedio_mes, 2) as costo_total_mes
FROM MonthlyStats
ORDER BY mes DESC";

$result_feed_monthly = $conn->query($sql_feed_monthly);

if ($result_feed_monthly->num_rows > 0) {
    $header = array('Mes', '# Animales', 'C. Diario', 'C. Mensual', 'Diario x Animal', 'Mensual x Animal', 'Precio Prom.', 'Total');
    $data = array();
    
    // Statistics tracking
    $total_consumption = 0;
    $total_cost = 0;
    $total_months = 0;
    $min_daily_per_animal = PHP_FLOAT_MAX;
    $max_daily_per_animal = 0;
    $total_daily_per_animal = 0;
    
    while ($row = $result_feed_monthly->fetch_assoc()) {
        // Format the month to Spanish format
        $date = DateTime::createFromFormat('Y-m-d', $row['mes']);
        $mes_espanol = strftime('%B %Y', $date->getTimestamp());
        $mes_espanol = ucfirst(mb_strtolower($mes_espanol, 'UTF-8'));
        
        $data[] = array(
            $mes_espanol,
            $row['total_animales'],
            number_format($row['consumo_diario_total'], 2),
            number_format($row['consumo_total_mes'], 2),
            number_format($row['promedio_diario_por_animal'], 2),
            number_format($row['promedio_mensual_por_animal'], 2),
            number_format($row['costo_promedio_mes'], 2),
            number_format($row['costo_total_mes'], 2)
        );
        
        // Track statistics
        $total_consumption += $row['consumo_total_mes'];
        $total_cost += $row['costo_total_mes'];
        $total_daily_per_animal += $row['promedio_diario_por_animal'];
        $min_daily_per_animal = min($min_daily_per_animal, $row['promedio_diario_por_animal']);
        $max_daily_per_animal = max($max_daily_per_animal, $row['promedio_diario_por_animal']);
        $total_months++;
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add statistics summary
    if ($total_months > 0) {
        $avg_daily_per_animal = $total_daily_per_animal / $total_months;
        $avg_monthly_consumption = $total_consumption / $total_months;
        $avg_monthly_cost = $total_cost / $total_months;
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(5);
        $pdf->Cell(0, 6, 'ESTADISTICAS GENERALES:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, sprintf('Consumo Mensual Promedio: %.2f kg', $avg_monthly_consumption), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Promedio Diario por Animal: %.2f kg', $avg_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Minimo Diario por Animal: %.2f kg', $min_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Maximo Diario por Animal: %.2f kg', $max_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Costo Mensual Promedio: $%.2f', $avg_monthly_cost), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, sprintf('Costo Total (12 meses): $%.2f', $total_cost), 0, 1, 'L');
    }
    
    // Add explanatory notes
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, 'Notas:
- El consumo se calcula como un promedio diario por animal por mes.
- Si hay varios registros para un animal en el mismo mes, se usa el promedio.
- El consumo diario total es la suma de los promedios diarios de todos los animales.
- El consumo mensual se calcula multiplicando el consumo diario por los dias del mes.
- El promedio por animal representa el consumo individual promedio.
- Los precios mostrados son promedios mensuales por kilogramo.
- El costo total incluye el consumo mensual multiplicado por el precio promedio.
- Las estadisticas muestran la tendencia de consumo en los ultimos 12 meses.', 0, 'L');
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de alimento concentrado para generar estadisticas mensuales', 0, 1);
    $pdf->Ln(2);
}

// Add Feed Conversion Ratio Analysis
$pdf->AddPage();
$pdf->ChapterTitle('Conversion');

// SQL to calculate FCR using total feed and weight gain
$sql_fcr = "WITH AllAnimals AS (
    SELECT tagid, nombre, fecha_nacimiento, genero, etapa 
    FROM bufalino 
    WHERE estatus = 'Activo'
),
MonthlyWeights AS (
    SELECT 
        bh_peso_tagid,
        DATE_FORMAT(bh_peso_fecha, '%Y-%m-01') as mes,
        AVG(bh_peso_animal) as peso_promedio
    FROM bh_peso
    GROUP BY bh_peso_tagid, DATE_FORMAT(bh_peso_fecha, '%Y-%m-01')
),
WeightChanges AS (
    SELECT 
        w1.bh_peso_tagid,
        w1.mes as mes_inicial,
        w2.mes as mes_final,
        w1.peso_promedio as peso_inicial,
        w2.peso_promedio as peso_final,
        w2.peso_promedio - w1.peso_promedio as ganancia_peso
    FROM MonthlyWeights w1
    JOIN MonthlyWeights w2 ON w1.bh_peso_tagid = w2.bh_peso_tagid
        AND w1.mes < w2.mes
        AND NOT EXISTS (
            SELECT 1 FROM MonthlyWeights w3
            WHERE w3.bh_peso_tagid = w1.bh_peso_tagid
            AND w3.mes > w1.mes AND w3.mes < w2.mes
        )
),
TotalFeed AS (
    SELECT 
        bh_concentrado_tagid,
        DATE_FORMAT(bh_concentrado_fecha_inicio, '%Y-%m-01') as mes,
        SUM(bh_concentrado_racion) as consumo_total
    FROM bh_concentrado
    GROUP BY bh_concentrado_tagid, DATE_FORMAT(bh_concentrado_fecha_inicio, '%Y-%m-01')
),
FCRCalculation AS (
    SELECT 
        wc.bh_peso_tagid,
        a.nombre,
        a.genero,
        a.etapa,
        wc.mes_inicial,
        wc.mes_final,
        wc.peso_inicial,
        wc.peso_final,
        wc.ganancia_peso,
        SUM(tf.consumo_total) as consumo_periodo,
        CASE 
            WHEN wc.ganancia_peso > 0 THEN SUM(tf.consumo_total) / wc.ganancia_peso
            ELSE NULL
        END as fcr
    FROM WeightChanges wc
    JOIN AllAnimals a ON wc.bh_peso_tagid = a.tagid
    LEFT JOIN TotalFeed tf ON wc.bh_peso_tagid = tf.bh_concentrado_tagid
        AND tf.mes >= wc.mes_inicial AND tf.mes <= wc.mes_final
    GROUP BY wc.bh_peso_tagid, a.nombre, a.genero, a.etapa, wc.mes_inicial, wc.mes_final, 
             wc.peso_inicial, wc.peso_final, wc.ganancia_peso
    HAVING consumo_periodo IS NOT NULL AND ganancia_peso > 0
)
SELECT 
    (SELECT COUNT(*) FROM AllAnimals) as total_animales_hato,
    COUNT(DISTINCT bh_peso_tagid) as animales_con_ica,
    ROUND(AVG(fcr), 2) as fcr_promedio,
    ROUND(MIN(fcr), 2) as fcr_minimo,
    ROUND(MAX(fcr), 2) as fcr_maximo,
    ROUND(SUM(consumo_periodo), 2) as consumo_total,
    ROUND(SUM(ganancia_peso), 2) as ganancia_total,
    ROUND(SUM(consumo_periodo) / SUM(ganancia_peso), 2) as fcr_global
FROM FCRCalculation";

$result_fcr = $conn->query($sql_fcr);

if ($result_fcr->num_rows > 0) {
    $fcr_data = $result_fcr->fetch_assoc();
    
    // Display FCR Statistics
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'ESTADISTICAS DE CONVERSION:', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, sprintf('Total de Animales en el Hato: %d', $fcr_data['total_animales_hato']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('Animales con Datos Suficientes para ICA: %d (%.1f%%)', 
        $fcr_data['animales_con_ica'],
        ($fcr_data['animales_con_ica'] / $fcr_data['total_animales_hato']) * 100
    ), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('Consumo Total de Alimento: %.2f kg', $fcr_data['consumo_total']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('Ganancia Total de Peso: %.2f kg', $fcr_data['ganancia_total']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('ICA Global del Hato: %.2f', $fcr_data['fcr_global']), 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->Cell(0, 6, 'RANGOS DE ICA:', 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('ICA Promedio: %.2f', $fcr_data['fcr_promedio']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('ICA Minimo: %.2f', $fcr_data['fcr_minimo']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('ICA Maximo: %.2f', $fcr_data['fcr_maximo']), 0, 1, 'L');
    
    // Add explanatory notes
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, sprintf('Notas:
- El Indice de Conversion Alimenticia (ICA) se calcula como: Alimento Consumido / Ganancia de Peso
- Un ICA mas bajo indica mejor eficiencia en la conversion de alimento a peso
- El ICA Global representa la eficiencia general del hato
- De los %d animales en el hato, solo %d tienen datos suficientes para calcular el ICA
- Se consideran solo periodos con registros completos de peso y consumo
- Los calculos se basan en promedios mensuales de peso y consumo total de alimento
- Solo se incluyen animales con ganancia de peso positiva
- El analisis requiere al menos dos pesajes y registros de consumo en el periodo', 
        $fcr_data['total_animales_hato'],
        $fcr_data['animales_con_ica']
    ), 0, 'L');
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay suficientes datos para calcular el Indice de Conversion Alimenticia', 0, 1);
    $pdf->Ln(2);
}

// Add Monthly Molasses Consumption Statistics
$pdf->AddPage();
$pdf->ChapterTitle('Consumo Melaza');

// SQL to get monthly molasses consumption with daily calculations and costs
$sql_molasses_monthly = "WITH MonthlyMolasses AS (
    SELECT 
        DATE_FORMAT(bh_melaza_fecha_inicio, '%Y-%m-01') as primer_dia_mes,
        bh_melaza_tagid,
        AVG(bh_melaza_racion) as consumo_diario_promedio,
        AVG(bh_melaza_costo) as costo_promedio
    FROM bh_melaza
    GROUP BY DATE_FORMAT(bh_melaza_fecha_inicio, '%Y-%m-01'), bh_melaza_tagid
),
MonthlyStats AS (
    SELECT 
        primer_dia_mes as mes,
        COUNT(DISTINCT bh_melaza_tagid) as total_animales,
        ROUND(SUM(consumo_diario_promedio), 2) as consumo_diario_total,
        ROUND(AVG(consumo_diario_promedio), 2) as promedio_diario_por_animal,
        ROUND(AVG(costo_promedio), 2) as costo_promedio_mes
    FROM MonthlyMolasses
    GROUP BY primer_dia_mes
)
SELECT 
    mes,
    total_animales,
    consumo_diario_total,
    consumo_diario_total * DAY(LAST_DAY(mes)) as consumo_total_mes,
    promedio_diario_por_animal,
    promedio_diario_por_animal * DAY(LAST_DAY(mes)) as promedio_mensual_por_animal,
    costo_promedio_mes,
    ROUND(consumo_diario_total * DAY(LAST_DAY(mes)) * costo_promedio_mes, 2) as costo_total_mes
FROM MonthlyStats
ORDER BY mes DESC
LIMIT 12";

$result_molasses_monthly = $conn->query($sql_molasses_monthly);

if ($result_molasses_monthly->num_rows > 0) {
    $header = array('Mes', '# Animales', 'C. Diario', 'C. Mensual', 'Diario x Animal', 'Mensual x Animal', 'Precio Prom.', 'Total');
    $data = array();
    
    // Statistics tracking
    $total_consumption = 0;
    $total_cost = 0;
    $total_months = 0;
    $min_daily_per_animal = PHP_FLOAT_MAX;
    $max_daily_per_animal = 0;
    $total_daily_per_animal = 0;
    
    while ($row = $result_molasses_monthly->fetch_assoc()) {
        // Format the month to Spanish format
        $date = DateTime::createFromFormat('Y-m-d', $row['mes']);
        $mes_espanol = strftime('%B %Y', $date->getTimestamp());
        $mes_espanol = ucfirst(mb_strtolower($mes_espanol, 'UTF-8'));
        
        $data[] = array(
            $mes_espanol,
            $row['total_animales'],
            number_format($row['consumo_diario_total'], 2),
            number_format($row['consumo_total_mes'], 2),
            number_format($row['promedio_diario_por_animal'], 2),
            number_format($row['promedio_mensual_por_animal'], 2),
            number_format($row['costo_promedio_mes'], 2),
            number_format($row['costo_total_mes'], 2)
        );
        
        // Track statistics
        $total_consumption += $row['consumo_total_mes'];
        $total_cost += $row['costo_total_mes'];
        $total_daily_per_animal += $row['promedio_diario_por_animal'];
        $min_daily_per_animal = min($min_daily_per_animal, $row['promedio_diario_por_animal']);
        $max_daily_per_animal = max($max_daily_per_animal, $row['promedio_diario_por_animal']);
        $total_months++;
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add statistics summary
    if ($total_months > 0) {
        $avg_daily_per_animal = $total_daily_per_animal / $total_months;
        $avg_monthly_consumption = $total_consumption / $total_months;
        $avg_monthly_cost = $total_cost / $total_months;
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(5);
        $pdf->Cell(0, 6, 'ESTADISTICAS GENERALES:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, sprintf('Consumo Mensual Promedio: %.2f kg', $avg_monthly_consumption), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Promedio Diario por Animal: %.2f kg', $avg_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Minimo Diario por Animal: %.2f kg', $min_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Maximo Diario por Animal: %.2f kg', $max_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Costo Mensual Promedio: $%.2f', $avg_monthly_cost), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, sprintf('Costo Total (12 meses): $%.2f', $total_cost), 0, 1, 'L');
    }
    
    // Add explanatory notes
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, 'Notas:
- El consumo se calcula como un promedio diario por animal por mes.
- Si hay varios registros para un animal en el mismo mes, se usa el promedio.
- El consumo diario total es la suma de los promedios diarios de todos los animales.
- El consumo mensual se calcula multiplicando el consumo diario por los dias del mes.
- El promedio por animal representa el consumo individual promedio.
- Los precios mostrados son promedios mensuales por kilogramo.
- El costo total incluye el consumo mensual multiplicado por el precio promedio.
- Las estadisticas muestran la tendencia de consumo en los ultimos 12 meses.', 0, 'L');
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de melaza para generar estadisticas mensuales', 0, 1);
    $pdf->Ln(2);
}

// Add Monthly Salt Consumption Statistics
$pdf->AddPage();
$pdf->ChapterTitle('Consumo Sal');

// SQL to get monthly salt consumption with daily calculations and costs
$sql_salt_monthly = "WITH MonthlySalt AS (
    SELECT 
        DATE_FORMAT(bh_sal_fecha_inicio, '%Y-%m-01') as primer_dia_mes,
        bh_sal_tagid,
        AVG(bh_sal_racion) as consumo_diario_promedio,
        AVG(bh_sal_costo) as costo_promedio
    FROM bh_sal
    GROUP BY DATE_FORMAT(bh_sal_fecha_inicio, '%Y-%m-01'), bh_sal_tagid
),
MonthlyStats AS (
    SELECT 
        primer_dia_mes as mes,
        COUNT(DISTINCT bh_sal_tagid) as total_animales,
        ROUND(SUM(consumo_diario_promedio), 2) as consumo_diario_total,
        ROUND(AVG(consumo_diario_promedio), 2) as promedio_diario_por_animal,
        ROUND(AVG(costo_promedio), 2) as costo_promedio_mes
    FROM MonthlySalt
    GROUP BY primer_dia_mes
)
SELECT 
    mes,
    total_animales,
    consumo_diario_total,
    consumo_diario_total * DAY(LAST_DAY(mes)) as consumo_total_mes,
    promedio_diario_por_animal,
    promedio_diario_por_animal * DAY(LAST_DAY(mes)) as promedio_mensual_por_animal,
    costo_promedio_mes,
    ROUND(consumo_diario_total * DAY(LAST_DAY(mes)) * costo_promedio_mes, 2) as costo_total_mes
FROM MonthlyStats
ORDER BY mes DESC
LIMIT 12";

$result_salt_monthly = $conn->query($sql_salt_monthly);

if ($result_salt_monthly->num_rows > 0) {
    $header = array('Mes', '# Animales', 'C. Diario', 'C. Mensual', 'Diario x Animal', 'Mensual x Animal', 'Precio Prom.', 'Total');
    $data = array();
    
    // Statistics tracking
    $total_consumption = 0;
    $total_cost = 0;
    $total_months = 0;
    $min_daily_per_animal = PHP_FLOAT_MAX;
    $max_daily_per_animal = 0;
    $total_daily_per_animal = 0;
    
    while ($row = $result_salt_monthly->fetch_assoc()) {
        // Format the month to Spanish format
        $date = DateTime::createFromFormat('Y-m-d', $row['mes']);
        $mes_espanol = strftime('%B %Y', $date->getTimestamp());
        $mes_espanol = ucfirst(mb_strtolower($mes_espanol, 'UTF-8'));
        
        $data[] = array(
            $mes_espanol,
            $row['total_animales'],
            number_format($row['consumo_diario_total'], 2),
            number_format($row['consumo_total_mes'], 2),
            number_format($row['promedio_diario_por_animal'], 2),
            number_format($row['promedio_mensual_por_animal'], 2),
            number_format($row['costo_promedio_mes'], 2),
            number_format($row['costo_total_mes'], 2)
        );
        
        // Track statistics
        $total_consumption += $row['consumo_total_mes'];
        $total_cost += $row['costo_total_mes'];
        $total_daily_per_animal += $row['promedio_diario_por_animal'];
        $min_daily_per_animal = min($min_daily_per_animal, $row['promedio_diario_por_animal']);
        $max_daily_per_animal = max($max_daily_per_animal, $row['promedio_diario_por_animal']);
        $total_months++;
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add statistics summary
    if ($total_months > 0) {
        $avg_daily_per_animal = $total_daily_per_animal / $total_months;
        $avg_monthly_consumption = $total_consumption / $total_months;
        $avg_monthly_cost = $total_cost / $total_months;
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Ln(5);
        $pdf->Cell(0, 6, 'ESTADISTICAS GENERALES:', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, sprintf('Consumo Mensual Promedio: %.2f kg', $avg_monthly_consumption), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Promedio Diario por Animal: %.2f kg', $avg_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Minimo Diario por Animal: %.2f kg', $min_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Maximo Diario por Animal: %.2f kg', $max_daily_per_animal), 0, 1, 'L');
        $pdf->Cell(0, 6, sprintf('Costo Mensual Promedio: $%.2f', $avg_monthly_cost), 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, sprintf('Costo Total (12 meses): $%.2f', $total_cost), 0, 1, 'L');
    }
    
    // Add explanatory notes
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, 'Notas:
- El consumo se calcula como un promedio diario por animal por mes.
- Si hay varios registros para un animal en el mismo mes, se usa el promedio.
- El consumo diario total es la suma de los promedios diarios de todos los animales.
- El consumo mensual se calcula multiplicando el consumo diario por los dias del mes.
- El promedio por animal representa el consumo individual promedio.
- Los precios mostrados son promedios mensuales por kilogramo.
- El costo total incluye el consumo mensual multiplicado por el precio promedio.
- Las estadisticas muestran la tendencia de consumo en los ultimos 12 meses.', 0, 'L');
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de consumo de sal para generar estadisticas mensuales', 0, 1);
    $pdf->Ln(2);
}

// Add Vaccination Summary
$pdf->AddPage();
$pdf->ChapterTitle('Vacunas');

// SQL to get vaccination counts
$sql_vacc_summary = "
WITH AllAnimals AS (
    SELECT DISTINCT tagid FROM bufalino WHERE estatus = 'Activo'
),
VaccinationCounts AS (
    SELECT 
        (SELECT COUNT(*) FROM AllAnimals) as total_animals,
        (SELECT COUNT(DISTINCT bh_aftosa_tagid) FROM bh_aftosa) as aftosa_count,
        (SELECT COUNT(DISTINCT bh_brucelosis_tagid) FROM bh_brucelosis) as brucelosis_count,
        (SELECT COUNT(DISTINCT bh_cbr_tagid) FROM bh_cbr) as cbr_count,
        (SELECT COUNT(DISTINCT bh_ibr_tagid) FROM bh_ibr) as ibr_count,
        (SELECT COUNT(DISTINCT bh_carbunco_tagid) FROM bh_carbunco) as carbunco_count,
        (SELECT COUNT(DISTINCT bh_garrapatas_tagid) FROM bh_garrapatas) as garrapatas_count,
        (SELECT COUNT(DISTINCT bh_parasitos_tagid) FROM bh_parasitos) as parasitos_count,
        (SELECT COALESCE(SUM(bh_aftosa_costo * bh_aftosa_dosis), 0) FROM bh_aftosa) as aftosa_cost,
        (SELECT COALESCE(SUM(bh_brucelosis_costo * bh_brucelosis_dosis), 0) FROM bh_brucelosis) as brucelosis_cost,
        (SELECT COALESCE(SUM(bh_cbr_costo * bh_cbr_dosis), 0) FROM bh_cbr) as cbr_cost,
        (SELECT COALESCE(SUM(bh_ibr_costo * bh_ibr_dosis), 0) FROM bh_ibr) as ibr_cost,
        (SELECT COALESCE(SUM(bh_carbunco_costo * bh_carbunco_dosis), 0) FROM bh_carbunco) as carbunco_cost,
        (SELECT COALESCE(SUM(bh_garrapatas_costo * bh_garrapatas_dosis), 0) FROM bh_garrapatas) as garrapatas_cost,
        (SELECT COALESCE(SUM(bh_parasitos_costo * bh_parasitos_dosis), 0) FROM bh_parasitos) as parasitos_cost
)
SELECT 
    total_animals,
    aftosa_count,
    total_animals - aftosa_count as aftosa_pending,
    aftosa_cost,
    brucelosis_count,
    total_animals - brucelosis_count as brucelosis_pending,
    brucelosis_cost,
    cbr_count,
    total_animals - cbr_count as cbr_pending,
    cbr_cost,
    ibr_count,
    total_animals - ibr_count as ibr_pending,
    ibr_cost,
    carbunco_count,
    total_animals - carbunco_count as carbunco_pending,
    carbunco_cost,
    garrapatas_count,
    total_animals - garrapatas_count as garrapatas_pending,
    garrapatas_cost,
    parasitos_count,
    total_animals - parasitos_count as parasitos_pending,
    parasitos_cost
FROM VaccinationCounts";

$result_vacc = $conn->query($sql_vacc_summary);
$vacc_data = $result_vacc->fetch_assoc();

// Create summary table
$header = array('Tratamiento', 'Animales Tratados', 'Animales Pendientes', 'Costo Total');
$data = array(
    array('Aftosa', $vacc_data['aftosa_count'], $vacc_data['aftosa_pending'], '$' . number_format($vacc_data['aftosa_cost'], 2)),
    array('Brucelosis', $vacc_data['brucelosis_count'], $vacc_data['brucelosis_pending'], '$' . number_format($vacc_data['brucelosis_cost'], 2)),
    array('CBR', $vacc_data['cbr_count'], $vacc_data['cbr_pending'], '$' . number_format($vacc_data['cbr_cost'], 2)),
    array('IBR', $vacc_data['ibr_count'], $vacc_data['ibr_pending'], '$' . number_format($vacc_data['ibr_cost'], 2)),
    array('Carbunco', $vacc_data['carbunco_count'], $vacc_data['carbunco_pending'], '$' . number_format($vacc_data['carbunco_cost'], 2)),
    array('Garrapatas', $vacc_data['garrapatas_count'], $vacc_data['garrapatas_pending'], '$' . number_format($vacc_data['garrapatas_cost'], 2)),
    array('Parasitos', $vacc_data['parasitos_count'], $vacc_data['parasitos_pending'], '$' . number_format($vacc_data['parasitos_cost'], 2))
);

$pdf->SimpleTable($header, $data);

// Calculate total vaccination cost
$total_vacc_cost = $vacc_data['aftosa_cost'] + 
                   $vacc_data['brucelosis_cost'] + 
                   $vacc_data['cbr_cost'] + 
                   $vacc_data['ibr_cost'] + 
                   $vacc_data['carbunco_cost'] + 
                   $vacc_data['garrapatas_cost'] + 
                   $vacc_data['parasitos_cost'];

// Add total cost line
$pdf->SetFont('Arial', 'B', 10);
$pdf->Ln(3);
$pdf->Cell(0, 6, sprintf('Costo Total en Tratamientos: $%.2f', $total_vacc_cost), 0, 1, 'R');

// Add explanatory note
$pdf->SetFont('Arial', 'I', 9);
$pdf->Ln(2);
$pdf->MultiCell(0, 5, sprintf('Nota: Basado en un total de %d animales activos en el sistema. Los animales pendientes son aquellos que no tienen ningun registro historico del tratamiento correspondiente. Los costos totales incluyen todos los tratamientos historicos realizados.', $vacc_data['total_animals']), 0, 'L');

// Add Pregnancy Duration Statistics
$pdf->AddPage();
$pdf->ChapterTitle('Preñez');

// SQL to calculate pregnancy duration including current pregnancies
$sql_preg_duration = "SELECT 
    g.bh_gestacion_tagid,
    v.nombre,
    g.bh_gestacion_numero,
    g.bh_gestacion_fecha,
    p.bh_parto_fecha,
    CASE 
        WHEN p.bh_parto_fecha IS NOT NULL THEN 'Completada'
        ELSE 'En Curso'
    END as estado,
    DATEDIFF(COALESCE(p.bh_parto_fecha, CURDATE()), g.bh_gestacion_fecha) as dias_gestacion
FROM bh_gestacion g
LEFT JOIN bh_parto p ON g.bh_gestacion_tagid = p.bh_parto_tagid 
    AND g.bh_gestacion_numero = p.bh_parto_numero
LEFT JOIN bufalino v ON g.bh_gestacion_tagid = v.tagid
ORDER BY g.bh_gestacion_tagid, g.bh_gestacion_fecha DESC";

$stmt_preg_duration = $conn->prepare($sql_preg_duration);
$stmt_preg_duration->execute();
$result_preg_duration = $stmt_preg_duration->get_result();

if ($result_preg_duration->num_rows > 0) {
    $header = array('Tag ID', 'Nombre', 'Gest. Nro.', 'F. Gestacion', 'F. Parto', 'Estado', 'Dias');
    $data = array();
    $total_days_completed = 0;
    $count_completed = 0;
    $current_tag = '';
    $tag_stats = array();
    
    while ($row = $result_preg_duration->fetch_assoc()) {
        $parto_fecha = $row['bh_parto_fecha'] ? $row['bh_parto_fecha'] : 'En Curso';
        $data[] = array(
            $row['bh_gestacion_tagid'],
            $row['nombre'],
            $row['bh_gestacion_numero'],
            $row['bh_gestacion_fecha'],
            $parto_fecha,
            $row['estado'],
            $row['dias_gestacion']
        );
        
        // Collect statistics per animal
        $current_tagid = $row['bh_gestacion_tagid'];
        if (!isset($tag_stats[$current_tagid])) {
            $tag_stats[$current_tagid] = array(
                'total_days' => 0,
                'count' => 0,
                'nombre' => $row['nombre']
            );
        }
        
        // Only include completed pregnancies in the statistics
        if ($row['estado'] === 'Completada') {
            $total_days_completed += $row['dias_gestacion'];
            $count_completed++;
        $tag_stats[$current_tagid]['total_days'] += $row['dias_gestacion'];
        $tag_stats[$current_tagid]['count']++;
        }
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add overall statistics
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln(5);
    $pdf->Cell(0, 6, 'ESTADISTICAS GENERALES:', 0, 1, 'L');
    
    if ($count_completed > 0) {
        $average_days = round($total_days_completed / $count_completed, 1);
        $pdf->Cell(0, 6, sprintf('Promedio General de Duracion (Gestaciones Completadas): %s dias', $average_days), 0, 1, 'L');
    }
    
    // Add per-animal statistics
    $pdf->Ln(2);
    $pdf->Cell(0, 6, 'PROMEDIOS POR ANIMAL (Solo Gestaciones Completadas):', 0, 1, 'L');
    foreach ($tag_stats as $current_tagid => $stats) {
        if ($stats['count'] > 0) {
            $avg = round($stats['total_days'] / $stats['count'], 1);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 6, sprintf('Tag ID: %s - %s: %s dias (de %d gestaciones)', 
                $current_tagid, 
                $stats['nombre'],
                $avg,
                $stats['count']
            ), 0, 1, 'L');
        }
    }
    
    // Add explanatory note
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(2);
    $pdf->MultiCell(0, 5, 'Nota: La duracion se calcula como la diferencia en dias entre la fecha de confirmacion de gestacion y la fecha del parto. Para gestaciones en curso, se utiliza la fecha actual para calcular los dias transcurridos. Los promedios solo consideran las gestaciones completadas.', 0, 'L');
    $pdf->Ln(2);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de gestaciones', 0, 1);
    $pdf->Ln(2);
}

// Add Open Days Statistics
$pdf->AddPage();
$pdf->ChapterTitle('Dias Abiertos');

// SQL to calculate open days between birth and next pregnancy for all animals
$sql_open_days = "WITH OrderedEvents AS (
    SELECT 
        bh_parto_tagid as tagid,
        bh_parto_fecha as fecha,
        bh_parto_numero as numero,
        'Parto' as tipo
    FROM bh_parto
    
    UNION ALL
    
    SELECT 
        bh_gestacion_tagid as tagid,
        bh_gestacion_fecha as fecha,
        bh_gestacion_numero as numero,
        'Gestacion' as tipo
    FROM bh_gestacion
),
NextPregnancy AS (
    SELECT 
        e1.tagid,
        e1.fecha as fecha_parto,
        e1.numero as parto_numero,
        MIN(e2.fecha) as fecha_siguiente_gestacion,
        DATEDIFF(MIN(e2.fecha), e1.fecha) as dias_abiertos
    FROM OrderedEvents e1
    LEFT JOIN OrderedEvents e2 ON e1.tagid = e2.tagid 
        AND e2.tipo = 'Gestacion'
        AND e2.fecha > e1.fecha
    WHERE e1.tipo = 'Parto'
    GROUP BY e1.tagid, e1.fecha, e1.numero
)
SELECT 
    np.tagid,
    v.nombre,
    v.etapa,
    np.parto_numero,
    np.fecha_parto,
    np.fecha_siguiente_gestacion,
    CASE 
        WHEN np.fecha_siguiente_gestacion IS NOT NULL THEN np.dias_abiertos
        WHEN np.fecha_parto IS NOT NULL THEN DATEDIFF(CURDATE(), np.fecha_parto)
    END as dias_abiertos,
    CASE 
        WHEN np.fecha_siguiente_gestacion IS NOT NULL THEN 'Cerrado'
        WHEN np.fecha_parto IS NOT NULL THEN 'Abierto'
    END as estado
FROM NextPregnancy np
LEFT JOIN bufalino v ON np.tagid = v.tagid
WHERE v.genero = 'Hembra'
ORDER BY np.tagid, np.fecha_parto DESC";

$stmt_open_days = $conn->prepare($sql_open_days);
$stmt_open_days->execute();
$result_open_days = $stmt_open_days->get_result();

if ($result_open_days->num_rows > 0) {
    $header = array('Tag ID', 'Nombre', 'Etapa', 'Parto Nro.', 'F. Parto', 'F. Nueva Gestacion', 'Dias Abiertos', 'Estado');
    $data = array();
    $total_days_closed = 0;
    $count_closed = 0;
    $tag_stats = array();
    
    while ($row = $result_open_days->fetch_assoc()) {
        $siguiente_gestacion = $row['fecha_siguiente_gestacion'] ? $row['fecha_siguiente_gestacion'] : 'Pendiente';
        $data[] = array(
            $row['tagid'],
            $row['nombre'],
            $row['etapa'],
            $row['parto_numero'],
            $row['fecha_parto'],
            $siguiente_gestacion,
            $row['dias_abiertos'],
            $row['estado']
        );
        
        // Collect statistics per animal
        $current_tagid = $row['tagid'];
        if (!isset($tag_stats[$current_tagid])) {
            $tag_stats[$current_tagid] = array(
                'nombre' => $row['nombre'],
                'etapa' => $row['etapa'],
                'total_days' => 0,
                'count' => 0,
                'open_periods' => 0,
                'current_open_days' => null
            );
        }
        
        // Track statistics
        if ($row['estado'] === 'Cerrado') {
            $tag_stats[$current_tagid]['total_days'] += $row['dias_abiertos'];
            $tag_stats[$current_tagid]['count']++;
            $total_days_closed += $row['dias_abiertos'];
            $count_closed++;
        } else {
            $tag_stats[$current_tagid]['open_periods']++;
            if ($tag_stats[$current_tagid]['current_open_days'] === null || 
                $row['dias_abiertos'] > $tag_stats[$current_tagid]['current_open_days']) {
                $tag_stats[$current_tagid]['current_open_days'] = $row['dias_abiertos'];
            }
        }
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add overall statistics
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln(5);
    $pdf->Cell(0, 6, 'ESTADISTICAS GENERALES:', 0, 1, 'L');
    
    if ($count_closed > 0) {
        $average_days = round($total_days_closed / $count_closed, 1);
        $pdf->Cell(0, 6, sprintf('Promedio General de Dias Abiertos (Periodos Cerrados): %s dias', $average_days), 0, 1, 'L');
    }
    
    // Add per-animal statistics
    $pdf->Ln(2);
    $pdf->Cell(0, 6, 'PROMEDIOS POR ANIMAL:', 0, 1, 'L');
    foreach ($tag_stats as $current_tagid => $stats) {
        $pdf->SetFont('Arial', '', 10);
        
        // Show average for closed periods if any
        if ($stats['count'] > 0) {
            $avg = round($stats['total_days'] / $stats['count'], 1);
            $pdf->Cell(0, 6, sprintf('Tag ID: %s - %s (%s)', $current_tagid, $stats['nombre'], $stats['etapa']), 0, 1, 'L');
            $pdf->Cell(0, 6, sprintf('   Promedio Periodos Cerrados: %s dias (de %d periodos)', 
                $avg, $stats['count']), 0, 1, 'L');
        }
        
        // Show current open period if any
        if ($stats['current_open_days'] !== null) {
            $pdf->Cell(0, 6, sprintf('   Periodo Abierto Actual: %d dias', 
                $stats['current_open_days']), 0, 1, 'L');
        }
        
        $pdf->Ln(1);
    }
    
    // Add explanatory notes
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(2);
    $pdf->MultiCell(0, 5, 'Notas:
- Dias abiertos: Periodo entre un parto y la siguiente confirmacion de gestacion.
- Estado "Cerrado": El animal ya tiene confirmada la siguiente gestacion.
- Estado "Abierto": El animal aun no tiene confirmada la siguiente gestacion.
- Para periodos abiertos, se calcula usando la fecha actual.
- Los promedios de periodos cerrados solo consideran gestaciones confirmadas.
- Se muestran unicamente animales hembra con historial de partos.', 0, 'L');
    $pdf->Ln(2);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay registros de partos para calcular dias abiertos', 0, 1);
    $pdf->Ln(2);
}

// Add section for females with no pregnancy records
$pdf->AddPage();
$pdf->ChapterTitle('Descartes');

// SQL to find females with no pregnancy records
$sql_no_preg = "SELECT 
    v.tagid,
    v.nombre,
    v.fecha_nacimiento,
    TIMESTAMPDIFF(MONTH, v.fecha_nacimiento, CURDATE()) as edad_meses
FROM bufalino v
LEFT JOIN bh_gestacion g ON v.tagid = g.bh_gestacion_tagid
WHERE v.genero = 'Hembra' 
    AND g.bh_gestacion_tagid IS NULL
    AND v.estatus = 'Activo'
ORDER BY v.fecha_nacimiento ASC";

$stmt_no_preg = $conn->prepare($sql_no_preg);
$stmt_no_preg->execute();
$result_no_preg = $stmt_no_preg->get_result();

if ($result_no_preg->num_rows > 0) {
    $header = array('Tag ID', 'Nombre', 'F. Nacimiento', 'Edad (Meses)');
    $data = array();
    $count_by_age = array(
        'menos_12' => 0,
        '12_24' => 0,
        'mas_24' => 0
    );
    
    while ($row = $result_no_preg->fetch_assoc()) {
        $data[] = array(
            $row['tagid'],
            $row['nombre'],
            $row['fecha_nacimiento'],
            $row['edad_meses']
        );
        
        // Count animals by age range
        if ($row['edad_meses'] < 12) {
            $count_by_age['menos_12']++;
        } elseif ($row['edad_meses'] <= 24) {
            $count_by_age['12_24']++;
        } else {
            $count_by_age['mas_24']++;
        }
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add summary statistics
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln(5);
    $pdf->Cell(0, 6, 'RESUMEN POR EDAD:', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, sprintf('Menores de 12 meses: %d animales', $count_by_age['menos_12']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('Entre 12 y 24 meses: %d animales', $count_by_age['12_24']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('Mayores de 24 meses: %d animales', $count_by_age['mas_24']), 0, 1, 'L');
    
    // Add explanatory note
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(2);
    $pdf->MultiCell(0, 5, 'Nota: Esta lista muestra las hembras activas que no tienen ningun registro de gestacion en el sistema. Las edades se calculan en meses desde la fecha de nacimiento hasta la fecha actual. Animales mayores de 24 meses sin registro de gestacion podrian requerir atencion especial.', 0, 'L');
    $pdf->Ln(2);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'Todas las hembras activas tienen al menos un registro de gestacion', 0, 1);
    $pdf->Ln(2);
}

// Add section for animals with extended time since last birth
$pdf->AddPage();
$pdf->ChapterTitle('sin parir');

// SQL to find animals with more than 365 days since last birth
$sql_extended_period = "WITH LastBirth AS (
    SELECT 
        bh_parto_tagid,
        MAX(bh_parto_fecha) as bh_parto_fecha,
        COUNT(*) as total_partos
    FROM bh_parto
    GROUP BY bh_parto_tagid
)
SELECT 
    v.tagid,
    v.nombre,
    v.etapa,
    lb.bh_parto_fecha,
    DATEDIFF(CURDATE(), lb.bh_parto_fecha) as dias_desde_parto,
    lb.total_partos
FROM bufalino v
JOIN LastBirth lb ON v.tagid = lb.bh_parto_tagid
LEFT JOIN bh_parto p ON v.tagid = p.bh_parto_tagid 
    AND p.bh_parto_fecha > lb.bh_parto_fecha
WHERE v.genero = 'Hembra' 
    AND v.estatus = 'Activo'
    AND DATEDIFF(CURDATE(), lb.bh_parto_fecha) > 365
    AND p.bh_parto_tagid IS NULL
ORDER BY dias_desde_parto DESC";

$stmt_extended = $conn->prepare($sql_extended_period);
$stmt_extended->execute();
$result_extended = $stmt_extended->get_result();

if ($result_extended->num_rows > 0) {
    $header = array('Tag ID', 'Nombre', 'Etapa', 'Ultimo Parto', 'Dias Sin Parir', 'Total Partos');
    $data = array();
    
    // Statistics counters
    $count_by_days = array(
        '365_540' => 0,  // 1-1.5 years
        '541_730' => 0,  // 1.5-2 years
        'over_730' => 0  // over 2 years
    );
    
    while ($row = $result_extended->fetch_assoc()) {
        $data[] = array(
            $row['tagid'],
            $row['nombre'],
            $row['etapa'],
            $row['bh_parto_fecha'],
            $row['dias_desde_parto'],
            $row['total_partos']
        );
        
        // Count by days range
        if ($row['dias_desde_parto'] <= 540) {
            $count_by_days['365_540']++;
        } elseif ($row['dias_desde_parto'] <= 730) {
            $count_by_days['541_730']++;
        } else {
            $count_by_days['over_730']++;
        }
    }
    
    $pdf->SimpleTable($header, $data);
    
    // Add statistics
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Ln(5);
    $pdf->Cell(0, 6, 'RESUMEN POR PERIODO:', 0, 1, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, sprintf('Entre 365 y 517 dias sin parir: %d animales', $count_by_days['365_540']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('Entre 518 y 720 dias sin parir: %d animales', $count_by_days['541_730']), 0, 1, 'L');
    $pdf->Cell(0, 6, sprintf('Mas de 720 dias sin parir: %d animales', $count_by_days['over_730']), 0, 1, 'L');
    
    // Add explanatory notes
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Ln(2);
    $pdf->MultiCell(0, 5, 'Notas:
- Esta tabla muestra hembras activas con mas de 365 dias desde su ultimo parto.
- Solo se incluyen animales que no tienen una gestacion registrada despues de su ultimo parto.
- Los dias sin parir se calculan desde el ultimo parto hasta la fecha actual.
- Animales con mas de 540 dias sin parir requieren atencion especial.
- Considerar revision veterinaria para animales con periodos extendidos sin parir.', 0, 'L');
    $pdf->Ln(2);
} else {
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->Cell(0, 5, 'No hay animales con mas de 365 dias desde su ultimo parto sin nueva gestacion', 0, 1);
    $pdf->Ln(2);
}


// At the end of the file:
// Clean any output buffers
while (ob_get_level()) {
    ob_end_clean();
}

// Sanitize animal name for filename (remove special characters and spaces)
$sanitized_name = preg_replace('/[^a-zA-Z0-9]/', '_', $animal['nombre']);
$sanitized_name = trim($sanitized_name, '_'); // Remove leading/trailing underscores

// Generate filename with timestamp to avoid conflicts
$filename = $sanitized_name . '_' . $tagid . '_' . date('Y-m-d_His') . '.pdf';
$filepath = __DIR__ . '/reports/' . $filename;

try {
    // Make sure reports directory exists
    $reportsDir = __DIR__ . '/reports';
    if (!file_exists($reportsDir)) {
        mkdir($reportsDir, 0777, true);
    }

    // Log the file path for debugging
    error_log("Attempting to generate PDF at: " . $filepath);
    error_log("Reports directory: " . $reportsDir);
    error_log("Directory exists: " . (file_exists($reportsDir) ? 'Yes' : 'No'));
    error_log("Directory writable: " . (is_writable($reportsDir) ? 'Yes' : 'No'));

    // First save the PDF to file
    $pdf->Output('F', $filepath);
    
    // Verify the file was created and is a PDF
    if (!file_exists($filepath)) {
        error_log("PDF file was not created at: " . $filepath);
        throw new Exception('Failed to create PDF file');
    }
    
    if (filesize($filepath) === 0) {
        error_log("PDF file is empty at: " . $filepath);
        unlink($filepath); // Delete empty file
        throw new Exception('Generated PDF file is empty');
    }
    
    // Log success
    error_log("PDF generated successfully: " . $filepath);
    error_log("File size: " . filesize($filepath) . " bytes");
    
    // Verify the file is readable
    if (!is_readable($filepath)) {
        error_log("Generated PDF file is not readable: " . $filepath);
        throw new Exception('Generated PDF file is not readable');
    }
    
    // Check if the share file exists
    $share_file = __DIR__ . '/bufalino_share.php';
    if (!file_exists($share_file)) {
        error_log("Share file not found: " . $share_file);
        throw new Exception('Share file not found');
    }
    
    // Check if this is an AJAX request (from JavaScript)
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        // Return JSON response for AJAX requests
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'filename' => $filename,
            'filepath' => $filepath,
            'message' => 'PDF generated successfully'
        ]);
        exit;
    } else {
        // Redirect for direct browser requests
        $redirect_url = 'bufalino_share.php?file=' . urlencode($filename) . '&tagid=' . urlencode($tagid) . '&t=' . time();
        
        // Ensure no output has been sent
        if (headers_sent()) {
            error_log("Headers already sent, cannot redirect");
            throw new Exception('Headers already sent, cannot redirect');
        }
        
        header('Location: ' . $redirect_url);
        exit;
    }
} catch (Exception $e) {
    // Log error
    error_log('PDF Generation Error: ' . $e->getMessage());
    error_log('Error occurred at: ' . $e->getFile() . ':' . $e->getLine());
    error_log('Stack trace: ' . $e->getTraceAsString());
    
    if (file_exists($filepath)) {
        error_log("Cleaning up failed file: " . $filepath);
        unlink($filepath); // Clean up any failed file
    }
    
    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Error generating PDF: ' . $e->getMessage() . '. Please try again.']);
        exit;
    } else {
        die('Error generating PDF: ' . $e->getMessage() . '. Please try again.');
    }
}