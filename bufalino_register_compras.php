<?php
require_once './pdo_conexion.php';

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}
// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --- Fetch data for Monthly Purchase Value Chart ---
$monthlyValueLabels = [];
$monthlyValueData = [];
try {
    $monthlyQuery = "SELECT DATE_FORMAT(fecha_compra, '%Y-%m') as month_year, 
                           SUM(peso_compra * precio_compra) as total_value 
                     FROM bufalino 
                     WHERE fecha_compra IS NOT NULL AND peso_compra IS NOT NULL AND precio_compra IS NOT NULL
                     GROUP BY month_year 
                     ORDER BY month_year ASC";
    $monthlyStmt = $conn->prepare($monthlyQuery);
    $monthlyStmt->execute();
    $monthlyResults = $monthlyStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($monthlyResults as $row) {
        $monthlyValueLabels[] = $row['month_year'];
        $monthlyValueData[] = (float)$row['total_value'];
    }
} catch (PDOException $e) {
    error_log("Error fetching monthly purchase value data: " . $e->getMessage());
}
$monthlyValueLabelsJson = json_encode($monthlyValueLabels);
$monthlyValueDataJson = json_encode($monthlyValueData);

// --- Fetch data for Cumulative Investment Chart ---
$cumulativeLabels = [];
$cumulativeData = [];
$monthlyTotals = []; // Temporary array to store monthly totals

try {
    // Fetch all purchases ordered by date from bufalino table
    $cumulativeQuery = "SELECT fecha_compra, (peso_compra * precio_compra) as purchase_value
                        FROM bufalino 
                        WHERE fecha_compra IS NOT NULL AND peso_compra IS NOT NULL AND precio_compra IS NOT NULL
                        ORDER BY fecha_compra ASC";
    $cumulativeStmt = $conn->prepare($cumulativeQuery);
    $cumulativeStmt->execute();
    $allPurchases = $cumulativeStmt->fetchAll(PDO::FETCH_ASSOC);

    $currentCumulativeTotal = 0;
    
    // Aggregate totals per month
    foreach ($allPurchases as $purchase) {
        $monthYear = date('Y-m', strtotime($purchase['fecha_compra']));
        $value = (float)$purchase['purchase_value'];
        if (!isset($monthlyTotals[$monthYear])) {
            $monthlyTotals[$monthYear] = 0;
        }
        $monthlyTotals[$monthYear] += $value;
    }

    // Calculate cumulative sum month by month
    ksort($monthlyTotals); // Ensure months are in chronological order

    foreach ($monthlyTotals as $monthYear => $monthlyTotal) {
        $currentCumulativeTotal += $monthlyTotal;
        $cumulativeLabels[] = $monthYear;
        $cumulativeData[] = round($currentCumulativeTotal, 2); // Store cumulative total
    }

} catch (PDOException $e) {
    error_log("Error fetching cumulative investment data: " . $e->getMessage());
}
$cumulativeLabelsJson = json_encode($cumulativeLabels);
$cumulativeDataJson = json_encode($cumulativeData);


// --- End chart data fetching ---
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bufalino Register Compras</title>
<!-- Link to the Favicon -->
<link rel="icon" href="images/Ganagram_icono.ico" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<!--Bootstrap 5 Css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


<!-- Include Chart.js and Chart.js DataLabels Plugin -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<!-- SweetAlert2 CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

<!-- Place these in the <head> section in this exact order -->

<!-- jQuery Core (main library) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">

<!-- DataTables JavaScript -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Add these in the <head> section, after your existing DataTables CSS/JS -->
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- DataTables Buttons JS -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<link rel="stylesheet" href="./bufalino.css">

<style>
/* Professional Chart Styling */
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.bg-gradient-purple {
    background: linear-gradient(135deg, #6f42c1 0%, #5a2d91 100%);
}

.chart-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    padding: 2rem;
    margin: 2rem 0;
}

.chart-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.card {
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: none;
}

.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.card-header {
    border-bottom: none;
    border-radius: 16px 16px 0 0 !important;
    padding: 1.5rem;
}

.card-header h5 {
    font-weight: 600;
    font-size: 1.1rem;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 2rem;
    border-radius: 0 0 16px 16px;
}

/* Enhanced chart styling */
canvas {
    border-radius: 8px;
    transition: all 0.3s ease;
}

/* Loading animation */
.chart-container.loading::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.chart-container.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    margin: -20px 0 0 -20px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 11;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .chart-container {
        margin: 1rem 0;
        padding: 1rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }
}

/* Smooth transitions */
* {
    transition: all 0.2s ease;
}

/* Enhanced shadows */
.shadow {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.06);
}

.shadow-lg {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05);
}
</style>

</head>
<body>
<!-- Navigation Title -->
<nav class="navbar text-center" style="border: none !important; box-shadow: none !important;">
    <!-- Title Row -->
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-between align-items-center position-relative">
                <!-- Botón de Configuración -->
                <button type="button" onclick="window.location.href='./bufalino_configuracion.php'" class="btn" style="color:white; border: none; border-radius: 8px; padding: 8px 15px; z-index: 1050; position: relative;" title="Configuración">
                    <i class="fas fa-cog"></i> 
                </button>
                
                <!-- Título centrado -->
                <h1 class="navbar-title text-center position-absolute" style="left: 50%; transform: translateX(-50%); z-index: 1;">
                    <i class="fas fa-clipboard-list me-2"></i>LA GRANJA DE TITO<span class="ms-2"><i class="fas fa-file-medical"></i></span>
                </h1>
                
                <!-- Botón de Salir -->
                <button type="button" onclick="window.location.href='../inicio.php'" class="btn" style="color: white; border: none; border-radius: 8px; padding: 8px 15px; z-index: 1050; position: relative;" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i> 
                </button>
            </div>
        </div>
    </div>
</nav>

<!-- Subtitle - 3 Steps Guide -->
<style>
.arrow-step {
    position: relative;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    padding: 20px 30px;
    margin: 0 10px;
    clip-path: polygon(0% 0%, calc(100% - 30px) 0%, 100% 50%, calc(100% - 30px) 100%, 0% 100%, 30px 50%);
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    min-height: 108px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0.7;
    transition: all 0.3s ease;
    cursor: pointer;
}

.arrow-step:hover:not(.arrow-step-active) {
    opacity: 0.9;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
}

.arrow-step-active {
    background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%) !important;
    opacity: 1 !important;
    box-shadow: 0 8px 25px rgba(32, 201, 151, 0.5) !important;
    transform: scale(1.05);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 8px 25px rgba(32, 201, 151, 0.5);
    }
    50% {
        box-shadow: 0 8px 35px rgba(32, 201, 151, 0.8);
    }
}

.arrow-step-first {
    clip-path: polygon(0% 0%, calc(100% - 30px) 0%, 100% 50%, calc(100% - 30px) 100%, 0% 100%);
    border-radius: 10px 0 0 10px;
}

.arrow-step-last {
    clip-path: polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%, 30px 50%);
    border-radius: 0 10px 10px 0;
}

.badge-active {
    position: absolute;
    top: 10px;
    right: 20px;
    background: #ffc107;
    color: #000;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: bold;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    animation: bounce 1s infinite;
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

@media (max-width: 768px) {
    .arrow-step, .arrow-step-first, .arrow-step-last {
        clip-path: none !important;
        border-radius: 10px !important;
        margin: 10px 0;
    }
    .badge-active {
        right: 10px;
    }
}
</style>

<div class="container-fluid mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-11">
            <div class="row justify-content-center align-items-stretch">
                <div class="col-md-4 d-flex px-1 mb-3 mb-md-0">
                    <div class="arrow-step arrow-step-first w-100" onclick="window.location.href='./inventario_bufalino.php'" title="Ir a Inventario">
                        <div style="background: white; color: #28a745; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            1
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 1:<br>Crear Animales</h5>
                    </div>
                </div>
                <div class="col-md-4 d-flex px-1 mb-3 mb-md-0">
                    <div class="arrow-step arrow-step-active w-100">
                        <span class="badge-active">🎯 Registrando Compras</span>
                        <div style="background: white; color: #17a2b8; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            2
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 2:<br>Registrar Tareas</h5>
                    </div>
                </div>
                <div class="col-md-4 d-flex px-1 mb-3 mb-md-0">
                    <div class="arrow-step arrow-step-last w-100" onclick="window.location.href='./bufalino_indices.php'" title="Ir a Índices">
                        <div style="background: white; color: #28a745; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            3
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 3:<br>Consultar</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Add back button before the header container -->
<a href="./bufalino_registros.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>
<div class="container text-center">

  
  <div class="container mt-3 mb-4 text-center">
    <button type="button" class="btn btn-add-animal" data-bs-toggle="modal" data-bs-target="#newEntryModal">
        <i class="fas fa-plus-circle me-2"></i>Registrar
    </button>
</div>
  
<!-- New Entry Modal -->
<div class="modal fade" id="newEntryModal" tabindex="-1" aria-labelledby="newEntryModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="newEntryModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Comprar Animal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newEntryForm" class="needs-validation" novalidate enctype="multipart/form-data">
                    <div class="row">
                        <!-- Left Column - Images and Video -->
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <!-- Image slider for previews -->
                                <div id="newImagePreviewCarousel" class="carousel slide carousel-fade mb-2" data-bs-ride="carousel" data-bs-interval="5200">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img id="newImagePreview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="newImage2Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="newImage3Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                        </div>
                                        <div class="carousel-item">
                                            <video id="newVideoPreview" class="img-thumbnail" controls 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;">
                                                <source src="" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#newImagePreviewCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#newImagePreviewCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>

                                <!-- Upload buttons -->
                                <div class="d-flex flex-wrap justify-content-center">
                                    <div class="m-1">
                                        <label for="newImageUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 1
                                        </label>
                                        <input type="file" class="d-none" id="newImageUpload" name="image"
                                               accept="image/*" onchange="previewImage(event, 'newImagePreview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="newImage2Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 2
                                        </label>
                                        <input type="file" class="d-none" id="newImage2Upload" name="image2"
                                               accept="image/*" onchange="previewImage(event, 'newImage2Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="newImage3Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 3
                                        </label>
                                        <input type="file" class="d-none" id="newImage3Upload" name="image3"
                                               accept="image/*" onchange="previewImage(event, 'newImage3Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="newVideoUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-video me-1"></i>Video
                                        </label>
                                        <input type="file" class="d-none" id="newVideoUpload" name="video"
                                               accept="video/*" onchange="previewVideo(event, 'newVideoPreview')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Form Fields -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Tag ID -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="tagid" id="newTagid" required>
                                        <label for="newTagid">Tag ID</label>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un Tag ID válido.
                                        </div>
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="nombre" id="newNombre" required>
                                        <label for="newNombre">Nombre</label>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un nombre.
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha Nacimiento -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="newFechaNacimiento" required>
                                        <label for="newFechaNacimiento">Fecha de Nacimiento</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione una fecha de nacimiento.
                                        </div>
                                    </div>
                                </div>

                                <!-- Fecha Compra -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="fecha_compra" id="newFechaCompra">
                                        <label for="newFechaCompra">Fecha de Compra</label>
                                    </div>
                                </div>

                                <!-- Sexo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="genero" id="newGenero" required>
                                            <option value="">Seleccionar</option>
                                            <option value="Macho">Macho</option>
                                            <option value="Hembra">Hembra</option>
                                        </select>
                                        <label for="newGenero">Sexo</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un sexo.
                                        </div>
                                    </div>
                                </div>

                                <!-- Raza -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="raza" id="newRaza" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_razas = $conn->prepare("SELECT DISTINCT bc_razas_nombre FROM bc_razas ORDER BY bc_razas_nombre");
                                                $stmt_razas->execute();
                                                $razas_list = $stmt_razas->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($razas_list as $row_razas) {
                                                    echo '<option value="' . htmlspecialchars($row_razas['bc_razas_nombre']) . '">' 
                                                        . htmlspecialchars($row_razas['bc_razas_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading razas: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="newRaza">Raza</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione una raza.
                                        </div>
                                    </div>
                                </div>                                

                                <!-- Etapa -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="etapa" id="newEtapa" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_etapa = $conn->prepare("SELECT DISTINCT bc_etapas_nombre FROM bc_etapas ORDER BY bc_etapas_nombre");
                                                $stmt_etapa->execute();
                                                $etapas_list = $stmt_etapa->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($etapas_list as $row_etapa) {
                                                    echo '<option value="' . htmlspecialchars($row_etapa['bc_etapas_nombre']) . '">' 
                                                        . htmlspecialchars($row_etapa['bc_etapas_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading etapas: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="newEtapa">Etapa</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione una etapa.
                                        </div>
                                    </div>
                                </div>

                                <!-- Grupo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="grupo" id="newGrupo" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_grupos = $conn->prepare("SELECT DISTINCT bc_grupos_nombre FROM bc_grupos ORDER BY bc_grupos_nombre");
                                                $stmt_grupos->execute();
                                                $grupos_list = $stmt_grupos->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($grupos_list as $row_grupos) {
                                                    echo '<option value="' . htmlspecialchars($row_grupos['bc_grupos_nombre']) . '">' 
                                                        . htmlspecialchars($row_grupos['bc_grupos_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading grupos: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="newGrupo">Grupo</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un grupo.
                                        </div>
                                    </div>
                                </div>

                                <!-- Estatus -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="estatus" id="newEstatus" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_estatus = $conn->prepare("SELECT DISTINCT bc_estatus_nombre FROM bc_estatus ORDER BY bc_estatus_nombre");
                                                $stmt_estatus->execute();
                                                $estatus_list = $stmt_estatus->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($estatus_list as $row_estatus) {
                                                    echo '<option value="' . htmlspecialchars($row_estatus['bc_estatus_nombre']) . '">' 
                                                        . htmlspecialchars($row_estatus['bc_estatus_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading estatus: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="newEstatus">Estatus</label>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un estatus.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Peso -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" step="0.1" class="form-control" name="peso" id="newPeso" required>
                                <label for="newPeso">Peso</label>
                                <div class="invalid-feedback">
                                    Por favor ingrese un peso.
                                </div>
                            </div>
                        </div>
                        <!-- Precio -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" step="0.1" class="form-control" name="precio" id="newPrecio" required>
                                <label for="newPrecio">Precio</label>
                                <div class="invalid-feedback">
                                    Por favor ingrese un precio.
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="submit" class="btn btn-success" form="newEntryForm">
                    <i class="fas fa-save me-2"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Function to preview image
    function previewImage(event, previewId) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById(previewId);
            if (output) {
                output.src = reader.result;
            }            
            // Show the correct carousel item
            const carouselItems = document.querySelectorAll('#newImagePreviewCarousel .carousel-item');
            carouselItems.forEach((item, index) => {
                if (item.querySelector('img') && item.querySelector('img').id === previewId) {
                    const carousel = bootstrap.Carousel.getInstance(document.getElementById('newImagePreviewCarousel'));
                    if (carousel) {
                        carousel.to(index);
                    }
                }
            });
        };
        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Function to preview video
    function previewVideo(event, previewId) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById(previewId);
            if (output) {
                const source = output.querySelector('source');
                if (source) {
                    source.src = reader.result;
                    output.load();
                }
                
                // Show video carousel item (last item)
                const carousel = bootstrap.Carousel.getInstance(document.getElementById('newImagePreviewCarousel'));
                if (carousel) {
                    const carouselItems = document.querySelectorAll('#newImagePreviewCarousel .carousel-item');
                    carousel.to(carouselItems.length - 1);
                }
            }
        };
        if (event.target.files && event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    // Initialize NewEntryModal form submission
    document.addEventListener('DOMContentLoaded', function() {
        // Get form element
        const createEntryForm = document.getElementById('newEntryForm');
        const newEntryModal = document.getElementById('newEntryModal');

        if (createEntryForm) {
            // Handle form submission
            createEntryForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                
                // Check form validation
                if (!createEntryForm.checkValidity()) {
                    event.stopPropagation();
                    createEntryForm.classList.add('was-validated');
                    return;
                }

                // Create a FormData object from the form
                const formData = new FormData(createEntryForm);
                
                // Add the action parameter
                formData.append('action', 'insert');

                // Show loading state
                const submitButton = document.querySelector('#newEntryModal .btn-success');
                const originalText = submitButton.innerHTML;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
                submitButton.disabled = true;

                // Send the form data using fetch
                fetch('bufalino_update.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: 'Nuevo animal agregado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            // Reset form and close modal
                            createEntryForm.reset();
                            createEntryForm.classList.remove('was-validated');
                            
                            // Reset image previews
                            document.getElementById('newImagePreview').src = './images/default_image.png';
                            document.getElementById('newImage2Preview').src = './images/default_image.png';
                            document.getElementById('newImage3Preview').src = './images/default_image.png';
                            const videoPreview = document.getElementById('newVideoPreview');
                            if (videoPreview && videoPreview.querySelector('source')) {
                                videoPreview.querySelector('source').src = '';
                                videoPreview.load();
                            }
                            
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(newEntryModal);
                            if (modal) {
                                modal.hide();
                            }
                            
                            // Reload page to show new entry
                            location.reload();
                        });
                    } else {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.message || 'Ocurrió un error al agregar el nuevo animal.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error al procesar la solicitud.'
                    });
                })
                .finally(() => {
                    // Restore button state
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                });
            });
        }

        // Initialize carousel when modal is shown
        newEntryModal.addEventListener('shown.bs.modal', function() {
            new bootstrap.Carousel(document.getElementById('newImagePreviewCarousel'), {
                interval: 5200
            });
        });
    });
</script>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="updateModalLabel">
                    <i class="fas fa-edit me-2"></i>Actualizar Compra de Animal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" class="needs-validation" enctype="multipart/form-data">
                    <!-- Hidden ID field for update -->
                    <input type="hidden" id="updateId" name="id" value="">
                    <div class="row">
                        <!-- Left Column - Images and Video -->
                        <div class="col-md-4 text-center">
                            <div class="mb-3">
                                <!-- Image slider for previews -->
                                <div id="updateImagePreviewCarousel" class="carousel slide carousel-fade mb-2" data-bs-ride="carousel" data-bs-interval="5200">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img id="updateImagePreview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreen(this.src)">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="updateImage2Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreen(this.src)">
                                        </div>
                                        <div class="carousel-item">
                                            <img id="updateImage3Preview" src="./images/default_image.png" 
                                                class="img-thumbnail" alt="Preview" 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreen(this.src)">
                                        </div>
                                        <div class="carousel-item">
                                            <video id="updateVideoPreview" class="img-thumbnail" controls 
                                                style="width: 200px; height: 200px; object-fit: cover; cursor: pointer;"
                                                onclick="openFullscreenVideo(this)">
                                                <source src="" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#updateImagePreviewCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#updateImagePreviewCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>

                                <!-- Upload buttons -->
                                <div class="d-flex flex-wrap justify-content-center">
                                    <div class="m-1">
                                        <label for="updateImageUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 1
                                        </label>
                                        <input type="file" class="d-none" id="updateImageUpload" 
                                               accept="image/*" onchange="previewImage(event, 'updateImagePreview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="updateImage2Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 2
                                        </label>
                                        <input type="file" class="d-none" id="updateImage2Upload" 
                                               accept="image/*" onchange="previewImage(event, 'updateImage2Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="updateImage3Upload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-image me-1"></i>Imagen 3
                                        </label>
                                        <input type="file" class="d-none" id="updateImage3Upload" 
                                               accept="image/*" onchange="previewImage(event, 'updateImage3Preview')">
                                    </div>
                                    <div class="m-1">
                                        <label for="updateVideoUpload" class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-video me-1"></i>Video
                                        </label>
                                        <input type="file" class="d-none" id="updateVideoUpload" 
                                               accept="video/*" onchange="previewVideo(event, 'updateVideoPreview')">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Form Fields -->
                        <div class="col-md-8">
                            <div class="row g-3">
                                <!-- Tag ID -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="tagid" id="updateTagid" required readonly>
                                        <label for="updateTagid">Tag ID</label>
                                    </div>
                                </div>

                                <!-- Nombre -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="nombre" id="updateNombre" required>
                                        <label for="updateNombre">Nombre</label>
                                    </div>
                                </div>

                                <!-- Fecha Nacimiento -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="fecha_nacimiento" id="updateFechaNacimiento" required>
                                        <label for="updateFechaNacimiento">Fecha de Nacimiento</label>
                                    </div>
                                </div>

                                <!-- Fecha Compra -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="fecha_compra" id="updateFechaCompra">
                                        <label for="updateFechaCompra">Fecha de Compra</label>
                                    </div>
                                </div>

                                <!-- Sexo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="genero" id="updateGenero" required>
                                            <option value="">Seleccionar</option>
                                            <option value="Macho">Macho</option>
                                            <option value="Hembra">Hembra</option>
                                        </select>
                                        <label for="updateGenero">Sexo</label>
                                    </div>
                                </div>

                                <!-- Raza -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="raza" id="updateRaza" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_razas_upd = $conn->prepare("SELECT DISTINCT razas_nombre FROM b_razas ORDER BY razas_nombre");
                                                $stmt_razas_upd->execute();
                                                $razas_list_upd = $stmt_razas_upd->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($razas_list_upd as $row_razas) {
                                                    echo '<option value="' . htmlspecialchars($row_razas['razas_nombre']) . '">' 
                                                        . htmlspecialchars($row_razas['razas_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading razas for update modal: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="updateRaza">Raza</label>
                                    </div>
                                </div>                                

                                <!-- Etapa -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="etapa" id="updateEtapa" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_etapa_upd = $conn->prepare("SELECT DISTINCT etapa FROM bufalino ORDER BY etapa");
                                                $stmt_etapa_upd->execute();
                                                $etapas_list_upd = $stmt_etapa_upd->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($etapas_list_upd as $row_etapa) {
                                                    echo '<option value="' . htmlspecialchars($row_etapa['etapa']) . '">' 
                                                        . htmlspecialchars($row_etapa['etapa']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading etapas for update modal: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="updateEtapa">Etapa</label>
                                    </div>
                                </div>

                                <!-- Grupo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="grupo" id="updateGrupo" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_grupos_upd = $conn->prepare("SELECT DISTINCT grupos_nombre FROM b_grupos ORDER BY grupos_nombre");
                                                $stmt_grupos_upd->execute();
                                                $grupos_list_upd = $stmt_grupos_upd->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($grupos_list_upd as $row_grupos) {
                                                    echo '<option value="' . htmlspecialchars($row_grupos['grupos_nombre']) . '">' 
                                                        . htmlspecialchars($row_grupos['grupos_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading grupos for update modal: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="updateGrupo">Grupo</label>
                                    </div>
                                </div>

                                <!-- Estatus -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" name="estatus" id="updateEstatus" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            try {
                                                $stmt_estatus_upd = $conn->prepare("SELECT DISTINCT estatus_nombre FROM b_estatus ORDER BY estatus_nombre");
                                                $stmt_estatus_upd->execute();
                                                $estatus_list_upd = $stmt_estatus_upd->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($estatus_list_upd as $row_estatus) {
                                                    echo '<option value="' . htmlspecialchars($row_estatus['estatus_nombre']) . '">' 
                                                        . htmlspecialchars($row_estatus['estatus_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error loading estatus for update modal: " . $e->getMessage());
                                            }
                                            ?>
                                        </select>
                                        <label for="updateEstatus">Estatus</label>
                                    </div>
                                </div>

                                <!-- Peso -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.1" class="form-control" name="peso" id="updatePeso" required>
                                        <label for="updatePeso">Peso</label>
                                    </div>
                                </div>

                                <!-- Precio -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" step="0.1" class="form-control" name="precio" id="updatePrecio" required>
                                        <label for="updatePrecio">Precio</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-outline-success" onclick="saveUpdates()">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Save Update Modal -->
<script>
function saveUpdates() {
    console.log('saveUpdates function called'); // Debug log
    
    // Get the form
    const form = document.getElementById('updateForm');
    if (!form) {
        console.error('Update form not found');
            return;
        }

    // Create FormData object from the form
    const formData = new FormData(form);
    
    // Debug: Log all form data
    console.log('Form data contents:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    // Check if updateId is set
    const updateId = formData.get('id');
    if (!updateId) {
        console.error('updateId is missing from form data');
        // Let's also check the DOM element directly
        const updateIdElement = document.getElementById('updateId');
        console.error('updateId DOM element value:', updateIdElement ? updateIdElement.value : 'element not found');
        console.error('updateId DOM element:', updateIdElement);
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'ID del registro no encontrado. Por favor, cierre el modal y vuelva a intentar.'
        });
        return;
    }
    
    // Add the action parameter
    formData.append('action', 'update');
    
    // Add any fields that might not be in the form or need specific handling
    const tagid = document.getElementById('updateTagid');
    if (tagid) {
        formData.append('tagid', tagid.value); // Ensure tagid is explicitly added
    }
    // Add peso and precio from the modal inputs
    const peso = document.getElementById('updatePeso');
    if (peso) {
        formData.append('peso_compra', peso.value); // Use the correct name expected by update script
    }
    const precio = document.getElementById('updatePrecio');
    if (precio) {
        formData.append('precio_compra', precio.value); // Use the correct name expected by update script
    }

    // Add image files if selected
    const imageFile = document.getElementById('updateImageUpload').files[0];
    if (imageFile) {
        formData.append('image', imageFile);
    }
    
    // Add image2 file if selected
    const image2File = document.getElementById('updateImage2Upload').files[0];
    if (image2File) {
        formData.append('image2', image2File);
    }
    
    // Add image3 file if selected
    const image3File = document.getElementById('updateImage3Upload').files[0];
    if (image3File) {
        formData.append('image3', image3File);
    }
    
    // Add video file if selected
    const videoFile = document.getElementById('updateVideoUpload').files[0];
    if (videoFile) {
        formData.append('video', videoFile);
    }

    // Show loading state
    const saveButton = document.querySelector('#updateModal .btn-outline-success');
    if (!saveButton) {
        console.error('Save button not found');
            return;
        }
    const originalText = saveButton.innerHTML;
    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
    saveButton.disabled = true;

    // Debug: Check if updateId is set
    const updateIdField = document.getElementById('updateId');
    console.log('updateId field value before AJAX:', updateIdField ? updateIdField.value : 'field not found');
    console.log('updateId field in FormData:', formData.get('id'));
    
    // Send the update request
        $.ajax({
        url: 'bufalino_update.php',
            type: 'POST',
        data: formData,
        processData: false,  // Important for FormData
        contentType: false,  // Important for FormData
        cache: false,        // Prevent caching
        timeout: 30000,      // Increased timeout for larger files
            success: function(response) {
            try {
                const result = typeof response === 'string' ? JSON.parse(response) : response;
                
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: 'Los datos han sido actualizados exitosamente.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Close modal and refresh page
                        const modal = bootstrap.Modal.getInstance(document.getElementById('updateModal'));
                        if (modal) {
                            modal.hide();
                        }
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Hubo un error al actualizar los datos.'
                    });
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un error al procesar la respuesta del servidor.'
                });
                }
            },
            error: function(xhr, status, error) {
            console.error('Ajax error:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            
            let errorMessage = 'Hubo un error al enviar los datos';
            if (status === 'timeout') {
                errorMessage = 'La solicitud tardó demasiado tiempo. Por favor, intente de nuevo.';
            } else if (xhr.responseText) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.message) {
                        errorMessage = response.message;
                    }
                } catch (e) {
                    console.error('Error parsing error response:', e);
                }
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        },
        complete: function() {
            // Restore button state
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
        }
    });
}

// Add form validation before submission
document.getElementById('updateModal').addEventListener('shown.bs.modal', function () {
    // Remove the form submission event listener that interferes with button click
    // The form will be handled by the saveUpdates function called from button click
});
</script>

</div><!-- Close container text-center opened on line 454 -->

  <!-- DataTable for bh_compra records -->
  
  <div class="container table-section" style="display: block; margin-top: 20px; margin-bottom: 20px;">
      <h3 class="text-center mb-4">Registros de Compras</h3>
      <div class="table-responsive">
          <table id="compraTable" class="table table-striped table-bordered" style="width:100%;">
              <thead>
                  <tr>
                      <th class="text-center">Imagen</th>
                      <th class="text-center">Acciones</th>                      
                      <th class="text-center">Nombre</th> 
                      <th class="text-center">Fecha</th>                   
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Precio</th>
                      <th class="text-center">Peso</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      // Query to get purchase data directly from bufalino table
                      $compraQuery = "SELECT 
                                        id, 
                                        DATE_FORMAT(fecha_compra, '%Y-%m-%d') as fecha_compra_formatted, 
                                        nombre as animal_nombre, 
                                        tagid, 
                                        precio_compra, 
                                        peso_compra, 
                                        image as animal_image 
                                    FROM bufalino 
                                    WHERE fecha_compra IS NOT NULL 
                                    AND fecha_compra != '0000-00-00' 
                                    AND fecha_compra != ''
                                    ORDER BY fecha_compra DESC"; // Order by actual purchase date
                                
                      $stmt = $conn->prepare($compraQuery);  
                      $stmt->execute();
                      $compraData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                      // Debug: Log the count of records found
                      error_log("Compra records found: " . count($compraData));
                      
                      // If no data, display a message
                      if (empty($compraData)) {
                          echo "<tr><td colspan='7' class='text-center'>No hay registros de compra disponibles</td></tr>";
                      } else {
                          // The foreach loop below will handle rendering the rows
                      }
                  } catch (PDOException $e) {
                      error_log("Error in compra table data fetching: " . $e->getMessage());
                      echo "<tr><td colspan='7' class='text-center'>Error al cargar los datos de compra: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                  }

                  // Ensure $compraData is iterable even if the try block failed or returned empty
                  if (!isset($compraData)) {
                      $compraData = []; 
                  }

                  foreach ($compraData as $row) {
                      // Determine image path
                      $imagePath = './images/default_image.png'; // Default image
                      if (!empty($row['animal_image'])) {
                          $imagePath = './' . htmlspecialchars($row['animal_image']); // Use animal's image
                      }

                      // Render row using bufalino table columns
                      echo "<tr>";
                      echo '<td class="text-center"><img src="' . $imagePath . '" alt="Animal Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>';
                      echo '<td class="text-center">
                            <div class="btn-group" role="group">
                                <button class="btn btn-warning btn-sm edit-compra" 
                                    data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                    data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '"
                                    data-fecha="' . htmlspecialchars($row['fecha_compra_formatted'] ?? '') . '"
                                    data-precio="' . htmlspecialchars($row['precio_compra'] ?? '') . '"
                                    data-peso="' . htmlspecialchars($row['peso_compra'] ?? '') . '">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-compra" 
                                    data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                    data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>';
                      
                      echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>"; // bufalino.nombre                      
                      echo "<td class='text-center'>" . htmlspecialchars($row['fecha_compra_formatted'] ?? 'N/A') . "</td>"; // Use formatted fecha_compra
                      echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>"; // bufalino.tagid
                      echo "<td class='text-center'>" . htmlspecialchars($row['precio_compra'] ?? '0.00') . "</td>"; // bufalino.precio_compra
                      echo "<td class='text-center'>" . htmlspecialchars($row['peso_compra'] ?? '0.00') . "</td>"; // bufalino.peso_compra
                      echo "</tr>";
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>

<!-- Monthly Purchase Value Chart -->
<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2"></i>
                Valor Mensual de Compras
            </h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:60vh; width:100%">
                <canvas id="monthlyPurchaseChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Cumulative Investment Chart -->
<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-area me-2"></i>
                Inversión Acumulada en Compras
            </h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:60vh; width:100%">
                <canvas id="cumulativeInvestmentChart"></canvas>
            </div>
        </div>
    </div>
</div>



<!-- Initialize DataTable for VH compra -->
<script>
$(document).ready(function() {
    console.log('Initializing compraTable DataTable...');
    console.log('Table element exists:', $('#compraTable').length > 0);
    
    if ($('#compraTable').length === 0) {
        console.error('Table #compraTable not found in DOM!');
        return;
    }
    
    var table = $('#compraTable').DataTable({
        // Set initial page length
        pageLength: 10,
        
        // Configure length menu options
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[3, 'desc']],
        
        // Spanish language
        language: {
            url: './es-ES.json',
            lengthMenu: "Mostrar _MENU_ registros por página",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            search: "Buscar:",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        
        // Enable responsive features
        responsive: true,
        
        // Configure DOM layout and buttons
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12 col-md-6"l>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        
        buttons: [
            {
                extend: 'collection',
                text: 'Exportar',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],
        
        // Column specific settings
        columnDefs: [
            {
                targets: [0], // New Image column
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    // Assuming the image path is directly in the data or calculated in PHP
                    // The PHP code already renders the <img> tag, so we just return the cell content
                    return data; 
                }
            },
            {
                targets: [5, 6], // Adjusted: Precio (now 5), Peso (now 6) columns
                render: function(data, type, row) {
                    if (type === 'display') {
                        return parseFloat(data).toLocaleString('es-ES', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                    return data;
                }
            },
            {
                targets: [3], // Adjusted: Fecha column (now 3)
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Parse the date parts manually to avoid timezone issues
                        if (data) {
                            // Split the date string (format: YYYY-MM-DD)
                            var parts = data.split('-');
                            // Create date string in local format (DD/MM/YYYY)
                            if (parts.length === 3) {
                                return parts[2] + '/' + parts[1] + '/' + parts[0];
                            }
                        }
                        return data; // Return original if parsing fails
                    }
                    return data;
                }
            },
            {
                targets: [1], // Adjusted: Actions column (now 1)
                orderable: false,
                searchable: false
            }
        ]
    });
    
    console.log('compraTable DataTable initialized successfully!');
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    // Handle edit button click - using event delegation for DataTables compatibility
    $(document).on('click', '.edit-compra', function() {
        var button = $(this); // Store reference to the button
        var id = button.data('id'); // Get the record ID
        var tagid = button.data('tagid');
        var fechaCompra = button.data('fecha'); // Get the purchase date
        var precio = button.data('precio'); // Get the price
        var peso = button.data('peso'); // Get the weight
        
        // Debug: Log the data attributes
        console.log('Edit button clicked with data:', {
            id: id,
            tagid: tagid,
            fecha: fechaCompra,
            precio: precio,
            peso: peso
        });
        
        // Show loading indicator (optional)
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        // Fetch animal details via AJAX
        $.ajax({
            url: 'bufalino_get_details.php', // Assuming this endpoint exists
            type: 'GET',
            data: { tagid: tagid },
            dataType: 'json',
            success: function(animalData) {
                if (animalData && animalData.success) {
                    const data = animalData.data;
                    // Populate the #updateModal fields
                    $('#updateId').val(id); // Set the record ID for update
                    console.log('Setting updateId to:', id); // Debug log
                    $('#updateTagid').val(data.tagid);
                    $('#updateNombre').val(data.nombre);
                    $('#updateFechaNacimiento').val(data.fecha_nacimiento);
                    $('#updateFechaCompra').val(fechaCompra); // Use the specific purchase date from the button
                    $('#updateGenero').val(data.genero);
                    $('#updateRaza').val(data.raza);
                    $('#updateEtapa').val(data.etapa);
                    $('#updateGrupo').val(data.grupo);
                    $('#updateEstatus').val(data.estatus);
                    $('#updatePeso').val(peso); // Use the peso from button data
                    $('#updatePrecio').val(precio); // Use the precio from button data

                    // Reset and Populate image/video previews (adjust paths as needed)
                    const basePath = './'; // Adjust if your image/video paths are different
                    $('#updateImagePreview').attr('src', data.image ? basePath + data.image : './images/default_image.png');
                    $('#updateImage2Preview').attr('src', data.image2 ? basePath + data.image2 : './images/default_image.png');
                    $('#updateImage3Preview').attr('src', data.image3 ? basePath + data.image3 : './images/default_image.png');
                    const videoPreview = $('#updateVideoPreview');
                    const videoSource = videoPreview.find('source');
                    if (data.video) {
                        videoSource.attr('src', basePath + data.video);
                        videoPreview[0].load(); // Reload the video element
                        videoPreview.show();
                    } else {
                        videoSource.attr('src', '');
                        videoPreview[0].load();
                         // Optionally hide video preview if no video
                         // videoPreview.hide(); 
                    }
                     // Ensure carousel starts at the first image
                    $('#updateImagePreviewCarousel').carousel(0); 


                    // Get the modal instance and show it
                    var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
                    updateModal.show();
                    
                    // Ensure the hidden ID field is set after modal is shown
                    setTimeout(function() {
                        $('#updateId').val(id);
                        console.log('updateId field value after setTimeout:', $('#updateId').val());
                        
                        // Show debug info
                        $('#debugIdValue').text(id);
                        $('#debugInfo').show();
                        
                        // Additional debugging
                        const updateIdElement = document.getElementById('updateId');
                        console.log('updateId DOM element after setTimeout:', updateIdElement);
                        console.log('updateId DOM element value after setTimeout:', updateIdElement ? updateIdElement.value : 'element not found');
                        console.log('updateId DOM element type:', updateIdElement ? updateIdElement.type : 'element not found');
                        console.log('updateId DOM element name:', updateIdElement ? updateIdElement.name : 'element not found');
                    }, 100);

                } else {
                    Swal.fire(
                        'Error',
                        animalData.message || 'No se pudieron obtener los detalles del animal.',
                        'error'
                    );
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error fetching animal details: ", status, error);
                Swal.fire(
                    'Error',
                    'Hubo un problema al conectar con el servidor para obtener los detalles.',
                    'error'
                );
            },
            complete: function() {
                 // Restore button state
                button.prop('disabled', false).html('<i class="fas fa-edit"></i>');
            }
        });
    });
    
    // Handle delete button click - using event delegation for DataTables compatibility
    $(document).on('click', '.delete-compra', function() {
        // var id = $(this).data('id'); // Old ID is irrelevant
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar registro de compra?',
            text: `¿Está seguro de que desea eliminar la información de compra del animal con Tag ID ${tagid}? Esta acción no eliminará el animal del inventario.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar registro',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Eliminando...',
                    text: 'Por favor espere mientras se procesa la solicitud',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Send AJAX request to delete only purchase data
                $.ajax({
                    url: 'bufalino_update.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        tagid: tagid
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                             // Show success message
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: response.message || 'La información de compra ha sido eliminada correctamente.',
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // Reload the page to show updated data
                                location.reload();
                            });
                        } else {
                             Swal.fire({
                                title: 'Error',
                                text: response.message || 'No se pudo eliminar la información de compra.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                       
                    },
                    error: function(xhr, status, error) {
                        // Show error message
                        let errorMsg = 'Error al procesar la solicitud de eliminación';
                        
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMsg = response.message;
                            }
                        } catch (e) {
                            // Use default error message
                        }
                        
                        Swal.fire({
                            title: 'Error',
                            text: errorMsg,
                            icon: 'error',
                            confirmButtonColor: '#dc3545'
                        });
                    }
                });
            }
        });
    });
});
</script>

<!-- JavaScript for Monthly Purchase Value Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxMonthly = document.getElementById('monthlyPurchaseChart').getContext('2d');
    const monthlyLabels = <?php echo $monthlyValueLabelsJson; ?>;
    const monthlyData = <?php echo $monthlyValueDataJson; ?>;

    // Create beautiful gradient for professional look
    const monthlyGradient = ctxMonthly.createLinearGradient(0, 0, 0, 400);
    monthlyGradient.addColorStop(0, 'rgba(102, 126, 234, 0.8)'); // Primary blue at top
    monthlyGradient.addColorStop(1, 'rgba(102, 126, 234, 0.1)'); // Faint blue at bottom

    // Create secondary gradient for line
    const monthlyLineGradient = ctxMonthly.createLinearGradient(0, 0, 0, 400);
    monthlyLineGradient.addColorStop(0, 'rgba(102, 126, 234, 1)'); // Solid primary blue
    monthlyLineGradient.addColorStop(1, 'rgba(118, 75, 162, 1)'); // Purple accent

    new Chart(ctxMonthly, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Valor Total Compras por Mes',
                data: monthlyData,
                borderColor: monthlyLineGradient,
                backgroundColor: monthlyGradient,
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgba(102, 126, 234, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointRadius: 8,
                pointHoverRadius: 12,
                pointHoverBackgroundColor: 'rgba(102, 126, 234, 1)',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 4,
                pointStyle: 'circle'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart',
                onProgress: function(animation) {
                    // Add subtle glow effect during animation
                    const chart = animation.chart;
                    const ctx = chart.ctx;
                    ctx.shadowColor = 'rgba(102, 126, 234, 0.3)';
                    ctx.shadowBlur = 20;
                },
                onComplete: function(animation) {
                    // Remove glow effect after animation
                    const chart = animation.chart;
                    const ctx = chart.ctx;
                    ctx.shadowBlur = 0;
                }
            },
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'center',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            size: 14,
                            weight: '600',
                            family: 'Arial, sans-serif'
                        },
                        color: '#333'
                    }
                },
                title: {
                    display: false // Title is now in the card header
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: {
                        size: 16,
                        weight: 'bold',
                        family: 'Arial, sans-serif'
                    },
                    bodyFont: {
                        size: 14,
                        family: 'Arial, sans-serif'
                    },
                    padding: 16,
                    cornerRadius: 8,
                    displayColors: true,
                    borderColor: 'rgba(102, 126, 234, 0.5)',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += '$' + context.parsed.y.toLocaleString('es-ES', { 
                                    minimumFractionDigits: 2, 
                                    maximumFractionDigits: 2 
                                });
                            }
                            return '💰 ' + label;
                        },
                        title: function(tooltipItems) {
                            return '📅 Mes: ' + tooltipItems[0].label;
                        }
                    }
                },
                datalabels: {
                    display: false // Keep datalabels off for a cleaner look
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Período (Año-Mes)',
                        color: '#333',
                        font: {
                            size: 14,
                            weight: 'bold',
                            family: 'Arial, sans-serif'
                        },
                        padding: 20
                    },
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12,
                            weight: '500',
                            family: 'Arial, sans-serif'
                        },
                        padding: 10
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        lineWidth: 1,
                        drawBorder: false
                    },
                    border: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        width: 1
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Valor Total ($)',
                        color: '#333',
                        font: {
                            size: 14,
                            weight: 'bold',
                            family: 'Arial, sans-serif'
                        },
                        padding: 20
                    },
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12,
                            weight: '500',
                            family: 'Arial, sans-serif'
                        },
                        padding: 10,
                        callback: function(value, index, values) {
                            return '$' + value.toLocaleString('es-ES');
                        }
                    },
                    grid: {
                        color: 'rgba(102, 126, 234, 0.1)',
                        lineWidth: 1,
                        drawBorder: false
                    },
                    border: {
                        color: 'rgba(102, 126, 234, 0.2)',
                        width: 2
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 12,
                    hoverBorderWidth: 4
                },
                line: {
                    borderWidth: 4
                }
            }
        }
    });
});
</script>

<!-- JavaScript for Cumulative Investment Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxCumulative = document.getElementById('cumulativeInvestmentChart').getContext('2d');
    const cumulativeLabels = <?php echo $cumulativeLabelsJson; ?>;
    const cumulativeData = <?php echo $cumulativeDataJson; ?>;

    // Create beautiful gradient for professional look
    const cumulativeGradient = ctxCumulative.createLinearGradient(0, 0, 0, 400);
    cumulativeGradient.addColorStop(0, 'rgba(40, 167, 69, 0.8)'); // Success green at top
    cumulativeGradient.addColorStop(1, 'rgba(40, 167, 69, 0.1)'); // Faint green at bottom

    // Create secondary gradient for line
    const cumulativeLineGradient = ctxCumulative.createLinearGradient(0, 0, 0, 400);
    cumulativeLineGradient.addColorStop(0, 'rgba(40, 167, 69, 1)'); // Solid success green
    cumulativeLineGradient.addColorStop(1, 'rgba(32, 201, 151, 1)'); // Darker success green

    new Chart(ctxCumulative, {
        type: 'line',
        data: {
            labels: cumulativeLabels,
            datasets: [{
                label: 'Inversión Acumulada en Compras',
                data: cumulativeData,
                borderColor: cumulativeLineGradient,
                backgroundColor: cumulativeGradient,
                borderWidth: 4,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointRadius: 8,
                pointHoverRadius: 12,
                pointHoverBackgroundColor: 'rgba(40, 167, 69, 1)',
                pointHoverBorderColor: '#fff',
                pointHoverBorderWidth: 4,
                pointStyle: 'circle'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart',
                onProgress: function(animation) {
                    // Add subtle glow effect during animation
                    const chart = animation.chart;
                    const ctx = chart.ctx;
                    ctx.shadowColor = 'rgba(40, 167, 69, 0.3)';
                    ctx.shadowBlur = 20;
                },
                onComplete: function(animation) {
                    // Remove glow effect after animation
                    const chart = animation.chart;
                    const ctx = chart.ctx;
                    ctx.shadowBlur = 0;
                }
            },
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'center',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            size: 14,
                            weight: '600',
                            family: 'Arial, sans-serif'
                        },
                        color: '#333'
                    }
                },
                title: {
                    display: false // Title is now in the card header
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: {
                        size: 16,
                        weight: 'bold',
                        family: 'Arial, sans-serif'
                    },
                    bodyFont: {
                        size: 14,
                        family: 'Arial, sans-serif'
                    },
                    padding: 16,
                    cornerRadius: 8,
                    displayColors: true,
                    borderColor: 'rgba(40, 167, 69, 0.5)',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += '$' + context.parsed.y.toLocaleString('es-ES', { 
                                    minimumFractionDigits: 2, 
                                    maximumFractionDigits: 2 
                                });
                            }
                            return '💹 ' + label;
                        },
                        title: function(tooltipItems) {
                            return '📅 Mes: ' + tooltipItems[0].label;
                        }
                    }
                },
                datalabels: {
                    display: false // Keep datalabels off for a cleaner look
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Período (Año-Mes)',
                        color: '#333',
                        font: {
                            size: 14,
                            weight: 'bold',
                            family: 'Arial, sans-serif'
                        },
                        padding: 20
                    },
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12,
                            weight: '500',
                            family: 'Arial, sans-serif'
                        },
                        padding: 10
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        lineWidth: 1,
                        drawBorder: false
                    },
                    border: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        width: 1
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Inversión Acumulada ($)',
                        color: '#333',
                        font: {
                            size: 14,
                            weight: 'bold',
                            family: 'Arial, sans-serif'
                        },
                        padding: 20
                    },
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12,
                            weight: '500',
                            family: 'Arial, sans-serif'
                        },
                        padding: 10,
                        callback: function(value, index, values) {
                            return '$' + value.toLocaleString('es-ES');
                        }
                    },
                    grid: { color: 'rgba(40, 167, 69, 0.1)', lineWidth: 1, drawBorder: false }
                }
            },
            interaction: { mode: 'index', intersect: false }
        }
    });
});
</script>



