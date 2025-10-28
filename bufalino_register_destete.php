<?php
require_once './pdo_conexion.php';

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}
// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// --- Fetch data for statistics and tables ---
try {
    // Get destete buffalos count and data
    $desteteQuery = "
        SELECT 
            b.tagid,
            b.nombre,
            b.etapa,
            b.grupo,
            b.estatus,
            b.destete_fecha,
            b.destete_peso,
            COALESCE(p.bh_peso_animal, 'No Disponible') as ultimo_peso
        FROM bufalino b
        LEFT JOIN (
            SELECT 
                bh_peso_tagid,
                bh_peso_animal,
                bh_peso_fecha,
                ROW_NUMBER() OVER (PARTITION BY bh_peso_tagid ORDER BY bh_peso_fecha DESC) as rn
            FROM bh_peso
        ) p ON b.tagid = p.bh_peso_tagid AND p.rn = 1
        WHERE b.etapa = 'Destete'
        ORDER BY b.nombre ASC";
    
    $desteteStmt = $conn->prepare($desteteQuery);
    $desteteStmt->execute();
    $desteteData = $desteteStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get lactantes buffalos count and data
    $lactantesQuery = "
        SELECT 
            b.tagid,
            b.nombre,
            b.etapa,
            b.grupo,
            b.estatus,
            b.fecha_nacimiento,
            COALESCE(p.bh_peso_animal, 'No Disponible') as ultimo_peso
        FROM bufalino b
        LEFT JOIN (
            SELECT 
                bh_peso_tagid,
                bh_peso_animal,
                bh_peso_fecha,
                ROW_NUMBER() OVER (PARTITION BY bh_peso_tagid ORDER BY bh_peso_fecha DESC) as rn
            FROM bh_peso
        ) p ON b.tagid = p.bh_peso_tagid AND p.rn = 1
        WHERE b.grupo = 'Lactantes'
        ORDER BY b.nombre ASC";
    
    $lactantesStmt = $conn->prepare($lactantesQuery);
    $lactantesStmt->execute();
    $lactantesData = $lactantesStmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate statistics
    $totalDestete = count($desteteData);
    $totalLactantes = count($lactantesData);
    $totalPoblacion = $totalDestete + $totalLactantes;
    $tasaDestete = $totalPoblacion > 0 ? round(($totalDestete / $totalPoblacion) * 100, 1) : 0;
    
         // Calculate total value for destete buffalos
     $valorTotalDestete = 0;
     foreach ($desteteData as $bufalo) {
         if (is_numeric($bufalo['destete_peso'])) {
             // Use a default price if destete_precio doesn't exist
             $precio = isset($bufalo['destete_precio']) ? $bufalo['destete_precio'] : 0;
             $valorTotalDestete += $precio * $bufalo['destete_peso'];
         }
     }
    
} catch (PDOException $e) {
    error_log("Error fetching data: " . $e->getMessage());
    $desteteData = [];
    $lactantesData = [];
    $totalDestete = 0;
    $totalLactantes = 0;
    $totalPoblacion = 0;
    $tasaDestete = 0;
    $valorTotalDestete = 0;
}

// --- Fetch data for the line chart ---
$chartLabels = [];
$chartData = [];
try {
    $chartQuery = "SELECT DATE_FORMAT(bh_destete_fecha, '%Y-%m') as month_year, COUNT(*) as count 
                     FROM bh_destete 
                     GROUP BY month_year 
                     ORDER BY month_year ASC";
    $chartStmt = $conn->prepare($chartQuery);
    $chartStmt->execute();
    $chartResults = $chartStmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($chartResults as $row) {
        $chartLabels[] = $row['month_year'];
        $chartData[] = (int)$row['count'];
    }
} catch (PDOException $e) {
    error_log("Error fetching chart data: " . $e->getMessage());
    // Handle error appropriately, maybe set default values or show an error message
}

// Encode data for JavaScript
$chartLabelsJson = json_encode($chartLabels);
$chartDataJson = json_encode($chartData);
// --- End chart data fetching ---

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bufalino Register Destete</title>
<!-- Link to the Favicon -->
<link rel="icon" href="images/default_image.png" type="image/x-icon">
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

/* Statistics Cards Styling */
.stats-card {
    background: linear-gradient(50deg,rgb(168, 234, 102) 0%,rgb(86, 158, 129) 100%);
    color: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(0, 0, 0, 0.2);
}

.stats-card h3 {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.stats-card p {
    font-size: 0.9rem;
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.stats-card i {
    font-size: 2.5rem;
    opacity: 0.8;
    margin-bottom: 1rem;
}

/* Table Section Styling */
.table-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    margin: 2rem 0;
    overflow: hidden;
}

.table-section .card-header {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    padding: 1.5rem;
    border-bottom: none;
}

.table-section .card-header h5 {
    margin: 0;
    font-weight: 600;
    font-size: 1.2rem;
}

.table-responsive {
    padding: 1.5rem;
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
                        <span class="badge-active">🎯 Registrando Destetes</span>
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


  <!-- Statistics Cards -->
  <div class="container mt-4">
      <div class="row">
          <div class="col-md-3">
              <div class="stats-card text-center">
              <i class="fas fa-baby"></i>
                  <h3><?php echo number_format($totalDestete, 0); ?></h3>
                  <p>Bucerros Destetados</p>
              </div>
          </div>
          <div class="col-md-3">
              <div class="stats-card text-center">
                  <i class="fas fa-baby"></i>
                  <h3><?php echo number_format($totalLactantes, 0); ?></h3>
                  <p>Bucerros Lactantes</p>
              </div>
          </div>
          <div class="col-md-3">
              <div class="stats-card text-center">
                  <i class="fas fa-users"></i>
                  <h3><?php echo number_format($totalPoblacion, 0); ?></h3>
                  <p>Total Bucerros</p>
              </div>
          </div>
          <div class="col-md-3">
              <div class="stats-card text-center">
                  <i class="fas fa-percentage"></i>
                  <h3><?php echo number_format($tasaDestete, 1); ?>%</h3>
                  <p>% Destetados</p>
              </div>
          </div>
      </div>
  </div>

  <!-- New Destete Entry Modal -->
  
  <div class="modal fade" id="newDesteteModal" tabindex="-1" aria-labelledby="newDesteteModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDesteteModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Destete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newDesteteForm">
                    <input type="hidden" name="id" id="new_id" value="">
                <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                                <label for="new_fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-tag"></i>
                                <label for="new_tagid" class="form-label">Tag ID</label>
                                <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                            </span>                            
                        </div>
                    </div>                    
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-weight"></i>
                                <label for="new_peso" class="form-label">Peso</label>
                                <input type="number" class="form-control" id="new_peso" name="peso" required>
                            </span>                            
                        </div>
                    </div>                                                              
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewDestete">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for destete buffalos -->
  <div class="container table-section">
      <div class="card">
          <div class="card-header">
              <h5><i class="fas fa-cow me-2"></i>Bucerros Destetados</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="desteteTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <th class="text-center">Acciones</th>
                              <th class="text-center">Tag ID</th>
                              <th class="text-center">Nombre</th>                    
                              <th class="text-center">Etapa</th>
                              <th class="text-center">Grupo</th>  
                              <th class="text-center">Estatus</th>
                              <th class="text-center">Último Peso</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                          if (empty($desteteData)) {
                              echo "<tr><td colspan='7' class='text-center'>No hay bufalos en destete</td></tr>";
                          } else {
                              foreach ($desteteData as $row) {
                                  echo "<tr>";
                                  
                                  // Action buttons
                                  echo '<td class="text-center">
                                      <div class="btn-group" role="group">
                                          <button class="btn btn-success btn-sm" 
                                                  data-bs-toggle="modal" 
                                                  data-bs-target="#newDesteteModal" 
                                                  data-tagid-prefill="'.htmlspecialchars($row['tagid'] ?? '').'"
                                                  title="Registrar Nuevo Destete">
                                              <i class="fas fa-plus"></i>
                                          </button>
                                      </div>
                                  </td>';
                                  
                                  echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['etapa'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['group'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['estatus'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['ultimo_peso'] ?? 'N/A') . "</td>";
                                  
                                  echo "</tr>";
                              }
                          }
                          ?>
                  </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>

  <!-- DataTable for lactantes buffalos -->
  <div class="container table-section">
      <div class="card">
          <div class="card-header">
              <h5><i class="fas fa-baby me-2"></i>Bucerros Lactantes</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="lactantesTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                              <th class="text-center">Acciones</th>
                              <th class="text-center">Tag ID</th>
                              <th class="text-center">Nombre</th>                    
                              <th class="text-center">Etapa</th>
                              <th class="text-center">Grupo</th>  
                              <th class="text-center">Estatus</th>
                              <th class="text-center">Último Peso</th>
                          </tr>
                      </thead>
                      <tbody>
                      <?php
                          if (empty($lactantesData)) {
                              echo "<tr><td colspan='7' class='text-center'>No hay bufalos lactantes</td></tr>";
                          } else {
                              foreach ($lactantesData as $row) {
                                  echo "<tr>";
                                  
                                  // Action buttons
                                  echo '<td class="text-center">
                                      <div class="btn-group" role="group">
                                          <button class="btn btn-success btn-sm" 
                                                  data-bs-toggle="modal" 
                                                  data-bs-target="#newDesteteModal" 
                                                  data-tagid-prefill="'.htmlspecialchars($row['tagid'] ?? '').'"
                                                  title="Registrar Nuevo Destete">
                                              <i class="fas fa-plus"></i>
                                          </button>
                                      </div>
                                  </td>';
                                  
                                  echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['etapa'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['group'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['estatus'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['ultimo_peso'] ?? 'N/A') . "</td>";
                                  
                                  echo "</tr>";
                              }
                          }
                          ?>
                  </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- Initialize DataTables -->
<script>
$(document).ready(function() {
    // Initialize desteteTable
    if (!$('#desteteTable tbody tr').first().find('td').text().includes('No hay')) {
        $('#desteteTable').DataTable({
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]],
            order: [[2, 'asc']], // Order by Nombre column
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12 col-md-6"l>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                {
                    extend: 'collection',
                    text: 'Exportar',
                    buttons: ['copy', 'excel', 'csv', 'pdf', 'print']
                }
            ],
            columnDefs: [
                {
                    targets: [0], // Actions column
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }
    
    // Initialize lactantesTable
    if (!$('#lactantesTable tbody tr').first().find('td').text().includes('No hay')) {
        $('#lactantesTable').DataTable({
            pageLength: 10,
            lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "Todos"]],
            order: [[2, 'asc']], // Order by Nombre column
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            responsive: true,
            dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>' +
                 '<"row"<"col-sm-12 col-md-6"l>>' +
                 '<"row"<"col-sm-12"tr>>' +
                 '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
            buttons: [
                {
                    extend: 'collection',
                    text: 'Exportar',
                    buttons: ['copy', 'excel', 'csv', 'pdf', 'print']
                }
            ],
            columnDefs: [
                {
                    targets: [0], // Actions column
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    var newDesteteModalEl = document.getElementById('newDesteteModal');
    var tagIdInput = document.getElementById('new_tagid');

    // --- Pre-fill Tag ID when New Destete Modal opens --- 
    if (newDesteteModalEl && tagIdInput) {
        newDesteteModalEl.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = event.relatedTarget; 
            
            if (button) { // Check if modal was triggered by a button
                // Extract info from data-* attributes
                var tagid = button.getAttribute('data-tagid-prefill');
                
                // Update the modal's input field
                if (tagid) {
                    tagIdInput.value = tagid;
                } else {
                     tagIdInput.value = ''; // Clear if no tagid passed
                }
            } else {
                tagIdInput.value = ''; // Clear if opened programmatically without a relatedTarget
            }
        });

        // Optional: Clear the input when the modal is hidden to avoid stale data
        newDesteteModalEl.addEventListener('hidden.bs.modal', function (event) {
            tagIdInput.value = ''; 
            // Optionally reset form validation state
            $('#newDesteteForm').removeClass('was-validated'); 
            document.getElementById('newDesteteForm').reset(); // Reset other fields too
        });
    }
    // --- End Pre-fill Logic ---

    // Handle new entry form submission
    $('#saveNewDestete').click(function() {
        // Validate the form
        var form = document.getElementById('newDesteteForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            peso: $('#new_peso').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el destete para el animal con Tag ID ${formData.tagid}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading state
                Swal.fire({
                    title: 'Guardando...',
                    text: 'Por favor espere mientras se procesa la información',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Send AJAX request to insert the record
                $.ajax({
                    url: 'process_destete.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        peso: formData.peso,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newDesteteModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de destete ha sido guardado correctamente',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            // Reload the page to show updated data
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        // Show error message
                        let errorMsg = 'Error al procesar la solicitud';
                        
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

<!-- Chart Section -->
<div class="container mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header bg-gradient-success text-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2"></i>
                Historial Mensual de Destetes
            </h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:60vh; width:100%">
                <canvas id="desteteChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxDestete = document.getElementById('desteteChart').getContext('2d');
    const desteteLabels = <?php echo $chartLabelsJson; ?>;
    const desteteData = <?php echo $chartDataJson; ?>;

    // Create beautiful gradient for professional look
    const gradient = ctxDestete.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(40, 167, 69, 0.8)'); // Success green at top
    gradient.addColorStop(1, 'rgba(40, 167, 69, 0.1)'); // Faint green at bottom

    // Create secondary gradient for line
    const lineGradient = ctxDestete.createLinearGradient(0, 0, 0, 400);
    lineGradient.addColorStop(0, 'rgba(40, 167, 69, 1)'); // Solid success green
    lineGradient.addColorStop(1, 'rgba(32, 201, 151, 1)'); // Darker success green

    new Chart(ctxDestete, {
        type: 'line',
        data: {
            labels: desteteLabels,
            datasets: [{
                label: 'Número de Destetes por Mes',
                data: desteteData,
                borderColor: lineGradient,
                backgroundColor: gradient,
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
                                label += context.parsed.y + ' destetes';
                            }
                            return '🐄 ' + label;
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
                        text: 'Cantidad de Destetes',
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
                        stepSize: Math.max(1, Math.ceil(Math.max(...desteteData) / 5)),
                        precision: 0
                    },
                    grid: {
                        color: 'rgba(40, 167, 69, 0.1)',
                        lineWidth: 1,
                        drawBorder: false
                    },
                    border: {
                        color: 'rgba(40, 167, 69, 0.2)',
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
</body>
</html>