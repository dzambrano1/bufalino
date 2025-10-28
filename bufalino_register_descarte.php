<?php
require_once './pdo_conexion.php';

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}
// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// PHP Data Queries for Statistics - MOVED TO TOP
try {
    // Query to get discarded buffalos (estatus = Descartado) for statistics
    $discardedQuery = "SELECT *
                  FROM bufalino
                  WHERE estatus = 'Descartado'
                  ORDER BY descarte_fecha DESC";                              
    $stmt = $conn->prepare($discardedQuery);  
    $stmt->execute();
    $discardedData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Query to get active buffalos (estatus = Activo) for statistics
    $activeQuery = "SELECT b.*, p.bh_peso_animal, p.bh_peso_fecha
                  FROM bufalino b
                  LEFT JOIN (
                      SELECT bp1.bh_peso_tagid, bp1.bh_peso_animal, bp1.bh_peso_fecha
                      FROM bh_peso bp1
                      INNER JOIN (
                          SELECT bh_peso_tagid, MAX(bh_peso_fecha) as max_fecha
                          FROM bh_peso
                          GROUP BY bh_peso_tagid
                      ) bp2 ON bp1.bh_peso_tagid = bp2.bh_peso_tagid 
                              AND bp1.bh_peso_fecha = bp2.max_fecha
                  ) p ON b.tagid = p.bh_peso_tagid
                  WHERE b.estatus = 'Activo'
                  ORDER BY b.nombre ASC";                              
    $stmt = $conn->prepare($activeQuery);  
    $stmt->execute();
    $activeData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate additional statistics
    $totalDiscarded = count($discardedData);
    $totalActive = count($activeData);
    $totalBuffalos = $totalDiscarded + $totalActive;
    $discardedPercentage = $totalBuffalos > 0 ? ($totalDiscarded / $totalBuffalos) * 100 : 0;
    
    // Calculate total value of discarded buffalos
    $totalDiscardedValue = 0;
    foreach ($discardedData as $row) {
        if (isset($row['descarte_precio']) && isset($row['descarte_peso'])) {
            $totalDiscardedValue += ($row['descarte_precio'] * $row['descarte_peso']);
        }
    }
    
    // Calculate average values
    $averageDiscardedValue = $totalDiscarded > 0 ? $totalDiscardedValue / $totalDiscarded : 0;
    $averageDiscardedWeight = 0;
    $totalWeight = 0;
    foreach ($discardedData as $row) {
        if (isset($row['descarte_peso'])) {
            $totalWeight += $row['descarte_peso'];
        }
    }
    $averageDiscardedWeight = $totalDiscarded > 0 ? $totalWeight / $totalDiscarded : 0;
    
} catch (PDOException $e) {
    error_log("Error in statistics queries: " . $e->getMessage());
    $discardedData = [];
    $activeData = [];
    $totalDiscarded = 0;
    $totalActive = 0;
    $totalBuffalos = 0;
    $discardedPercentage = 0;
    $totalDiscardedValue = 0;
    $averageDiscardedValue = 0;
    $averageDiscardedWeight = 0;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bufalino Register Descarte</title>
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



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">




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
                        <span class="badge-active">🎯 Registrando Descartes</span>
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
  <div class="container mb-4">
      <div class="row">
          <div class="col-md-2">
              <div class="card bg-warning text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-times-circle me-2"></i>Bufalos Descartados   
                      </h5>
                      <h3 class="mb-0" id="discardedCount"><?php echo $totalDiscarded; ?></h3>
                      <small>Total de descartes</small>
                  </div>
              </div>
          </div>
          <div class="col-md-2">
              <div class="card bg-success text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-heart me-2"></i>Bufalos Activos
                      </h5>
                      <h3 class="mb-0" id="activeCount"><?php echo $totalActive; ?></h3>
                      <small>En producción</small>
                  </div>
              </div>
          </div>
          <div class="col-md-2">
              <div class="card bg-info text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-calculator me-2"></i>Total Población
                      </h5>
                      <h3 class="mb-0" id="totalCount"><?php echo $totalBuffalos; ?></h3>
                      <small>Población total</small>
                  </div>
              </div>
          </div>
          <div class="col-md-2">
              <div class="card bg-danger text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-percentage me-2"></i>Tasa Descarte
                      </h5>
                      <h3 class="mb-0" id="discardRate"><?php echo number_format($discardedPercentage, 1); ?>%</h3>
                      <small>Porcentaje de descartes</small>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="card bg-secondary text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-dollar-sign me-2"></i>Valor Total Descartado
                      </h5>
                      <h3 class="mb-0" id="totalValue">$<?php echo number_format($totalDiscardedValue, 0); ?></h3>
                      <small>Valor acumulado de descartes</small>
                  </div>
              </div>
          </div>
      </div>
  </div>
  
  <!-- New Descarte Entry Modal -->
  
  <div class="modal fade" id="newDescarteModal" tabindex="-1" aria-labelledby="newDescarteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDescarteModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Registrar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newDescarteForm">
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
                                <input type="text" class="form-control" id="new_peso" name="peso" required>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                                <label for="new_precio" class="form-label">Precio</label>
                                <input type="text" class="form-control" id="new_precio" name="precio" required>
                            </span>                            
                        </div>
                    </div>                                                                                 
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewDescarte">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
   
   <!-- DataTable for Discarded Buffalos (estatus = Descartado) -->
   
   <div class="container table-section mb-5" style="display: block;">
       <div class="card shadow">
           <div class="card-header bg-warning text-dark">
               <h5 class="mb-0"><i class="fas fa-times-circle me-2"></i>Bufalos Descartados</h5>
           </div>
           <div class="card-body">
               <div class="table-responsive">
                   <table id="discardedTable" class="table table-striped table-bordered">
                       <thead>
                           <tr>
                               <th class="text-center">Imagen</th>
                               <th class="text-center">Acciones</th>
                               <th class="text-center">Fecha</th>
                               <th class="text-center">Nombre</th>                    
                               <th class="text-center">Tag ID</th>
                               <th class="text-center">Peso (Kg)</th>                      
                               <th class="text-center">Precio ($)</th>                      
                           </tr>
                       </thead>
                       <tbody>
                           <?php                    
                           // Use the data already queried for statistics
                           // If no data, display a message
                           if (empty($discardedData)) {
                               echo "<tr><td colspan='7' class='text-center text-muted'>No hay buffalos descartados registrados</td></tr>";
                           } else {
                               foreach ($discardedData as $row) {
                                   echo "<tr>";
                                   
                                   // Add image column as the first column
                                   echo '<td class="text-center">';
                                   // Check if animal has an image
                                   if (!empty($row['image'])) {
                                       echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Imagen del animal" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                   } else {
                                       echo '<img src="images/vaca.png" alt="Imagen por defecto" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                   }
                                   echo '</td>';
                                   
                                   // Add action buttons (edit and delete)
                                   echo '<td class="text-center">
                                       <div class="btn-group" role="group">
                                           <button class="btn btn-warning btn-sm edit-descarte" 
                                               data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                               data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '"
                                               data-fecha="' . htmlspecialchars($row['descarte_fecha'] ?? '') . '"
                                               data-peso="' . htmlspecialchars($row['descarte_peso'] ?? '') . '"
                                               data-precio="' . htmlspecialchars($row['descarte_precio'] ?? '') . '">
                                               <i class="fas fa-edit"></i>
                                           </button>
                                           <button class="btn btn-danger btn-sm delete-descarte" 
                                               data-id="' . htmlspecialchars($row['id'] ?? '') . '">
                                               <i class="fas fa-trash"></i>
                                           </button>
                                       </div>
                                   </td>';
                                   
                                   echo "<td class='text-center'>" . htmlspecialchars($row['descarte_fecha'] ?? '') . "</td>";                        
                                   echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                   echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";
                                   echo "<td class='text-center'>" . htmlspecialchars($row['descarte_peso'] ?? '') . "</td>";
                                   echo "<td class='text-center'>" . htmlspecialchars($row['descarte_precio'] ?? '') . "</td>";
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
 
   <!-- DataTable for Active Buffalos (estatus = Activo) -->
   
   <div class="container table-section mb-5" style="display: block;">
       <div class="card shadow">
           <div class="card-header bg-success text-white">
               <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Bufalos Activos</h5>
           </div>
           <div class="card-body">
               <div class="table-responsive">
                   <table id="activeTable" class="table table-striped table-bordered">
                       <thead>
                           <tr>
                               <th class="text-center">Imagen</th>
                               <th class="text-center">Acciones</th>
                               <th class="text-center">Estatus</th>
                               <th class="text-center">Nombre</th>                    
                               <th class="text-center">Tag ID</th>
                               <th class="text-center">Último Peso</th>
                           </tr>
                       </thead>
                       <tbody>
                           <?php                    
                           // Use the data already queried for statistics
                           // If no data, display a message
                           if (empty($activeData)) {
                               echo "<tr><td colspan='6' class='text-center text-muted'>No hay buffalos activos registrados</td></tr>";
                           } else {
                               foreach ($activeData as $row) {
                                   echo "<tr>";
                                   
                                   // Add image column as the first column
                                   echo '<td class="text-center">';
                                   // Check if animal has an image
                                   if (!empty($row['image'])) {
                                       echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Imagen del animal" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                   } else {
                                       echo '<img src="images/vaca.png" alt="Imagen por defecto" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                   }
                                   echo '</td>';
                                   
                                   // Add action buttons (register discard button only for active buffalos)
                                   echo '<td class="text-center">
                                       <div class="btn-group" role="group">
                                           <button class="btn btn-warning btn-sm register-descarte" 
                                               data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '">
                                               <i class="fas fa-times-circle"></i>
                                           </button>
                                       </div>
                                   </td>';
                                   
                                   echo "<td class='text-center'>" . htmlspecialchars($row['estatus'] ?? '') . "</td>";
                                   echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                   echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";
                                   echo "<td class='text-center'>" . (isset($row['bh_peso_animal']) ? htmlspecialchars($row['bh_peso_animal']) . ' kg' : 'No Disponible') . "</td>";
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

<!-- Initialize DataTable for Discarded and Active Buffalos -->
<script>
$(document).ready(function() {

    
    // Initialize discarded table only if it has data
    if ($('#discardedTable tbody tr').length > 0 && !$('#discardedTable tbody tr').first().find('td').text().includes('No hay')) {

        $('#discardedTable').DataTable({
            // Set initial page length
            pageLength: 10,
            
            // Configure length menu options
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todos"]
            ],
            
            // Order by fecha (date) column descending
            order: [[2, 'desc']],
            
            // Spanish language
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
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
                    targets: [2], // Fecha column
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
                    targets: [1], // Actions column
                    orderable: false,
                    searchable: false
                }
            ]
        });
    } else {
        // If no data, just add basic styling

        $('#discardedTable').addClass('table-striped table-bordered');
    }

    // Initialize active table only if it has data
    if ($('#activeTable tbody tr').length > 0 && !$('#activeTable tbody tr').first().find('td').text().includes('No hay')) {

        $('#activeTable').DataTable({
            // Set initial page length
            pageLength: 10,
            
            // Configure length menu options
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todos"]
            ],
            
            // Order by nombre (name) column ascending
            order: [[3, 'asc']],
            
            // Spanish language
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
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
                    targets: [1], // Actions column
                orderable: false,
                searchable: false
            }
        ]
    });
    } else {
        // If no data, just add basic styling

        $('#activeTable').addClass('table-striped table-bordered');
    }
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    // Add handler for register-descarte button
    $('.register-descarte').click(function() {
        var tagid = $(this).data('tagid');
        
        // Populate the tagid field in the newDescarteModal
        $('#new_tagid').val(tagid);
        
        // Show the modal
        var newDescarteModal = new bootstrap.Modal(document.getElementById('newDescarteModal'));
        newDescarteModal.show();
    });

    // Handle new entry form submission
    $('#saveNewDescarte').click(function() {
        // Validate the form
        var form = document.getElementById('newDescarteForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            peso: $('#new_peso').val(),
            precio: $('#new_precio').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el descarte para el animal con Tag ID ${formData.tagid}? Esto marcará el animal como "Descartado".`,
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
                    url: 'process_descarte.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        peso: formData.peso,
                        precio: formData.precio,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newDescarteModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de descarte ha sido guardado correctamente',
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

    // Handle edit button click
    $('.edit-descarte').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var peso = $(this).data('peso');
        var precio = $(this).data('precio');
        var fecha = $(this).data('fecha');
        
        // Edit Descarte Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editDescarteModal" tabindex="-1" aria-labelledby="editDescarteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDescarteModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Descarte
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editDescarteForm">
                            <input type="hidden" id="edit_id" value="${id}">
                            <div class="mb-2">                                
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                            <label for="edit_fecha" class="form-label">Fecha</label>
                                            <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                                        </span>
                                    </div>
                                </div>                            
                            <div class="mb-2">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                        <label for="edit_tagid" class="form-label"> Tag ID </label>
                                        <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="mb-2">                            
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-weight"></i>
                                        <label for="edit_peso" class="form-label">Peso (kg)</label>                                    
                                        <input type="text" class="form-control" id="edit_peso" value="${peso}" required>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="mb-2">                            
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-dollar-sign"></i>
                                        <label for="edit_precio" class="form-label">Precio ($/Kg)</label>                                    
                                        <input type="text" class="form-control" id="edit_precio" value="${precio}" required>
                                    </span>                                    
                                </div>
                            </div>                                                 
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditDescarte">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editDescarteModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editDescarteModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditDescarte').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                peso: $('#edit_peso').val(),
                precio: $('#edit_precio').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el descarte para el animal con Tag ID ${formData.tagid}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Actualizando...',
                        text: 'Por favor espere mientras se procesa la información',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Send AJAX request to update the record
                    $.ajax({
                        url: 'process_descarte.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            peso: formData.peso,
                            precio: formData.precio,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: `El descarte para el animal con Tag ID ${formData.tagid} ha sido actualizado correctamente`,
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
    
    // Handle delete button click
    $('.delete-descarte').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar descarte?',
            text: `¿Está seguro de que desea eliminar el descarte para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
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

                // Send AJAX request to delete the record
                $.ajax({
                    url: 'process_descarte.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: `El descarte para el animal con Tag ID ${tagid} ha sido eliminado correctamente`,
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
  
  <!-- New Descarte Entry Modal -->
  
  <div class="modal fade" id="newDescarteModal" tabindex="-1" aria-labelledby="newDescarteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDescarteModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Descarte
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newDescarteForm">
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
                                <input type="text" class="form-control" id="new_peso" name="peso" required>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                                <label for="new_precio" class="form-label">Precio</label>
                                <input type="text" class="form-control" id="new_precio" name="precio" required>
                            </span>                            
                        </div>
                    </div>                                                                                 
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewDescarte">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
   </div>
   
       <!-- Monthly Descarte Chart Section -->
    <div class="container-fluid mb-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Evolución Mensual de Descartes</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="chartYear" class="form-label">Año:</label>
                        <select id="chartYear" class="form-select">
                            <option value="">Todos los años</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="chartMonth" class="form-label">Mes:</label>
                        <select id="chartMonth" class="form-select">
                            <option value="">Todos los meses</option>
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                </div>
                
                <div class="chart-container" style="position: relative; height:500px; width:100%;">
                    <canvas id="descarteChart"></canvas>
                </div>
               
               <div class="row mt-3">
                   <div class="col-md-6">
                       <div class="card bg-info text-white">
                           <div class="card-body text-center">
                               <h6 class="card-title">Total Valor Descartado</h6>
                               <h4 id="totalChartValue">$0</h4>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-6">
                       <div class="card bg-success text-white">
                           <div class="card-body text-center">
                               <h6 class="card-title">Total Buffalos Descartados</h6>
                               <h4 id="totalChartCount">0</h4>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   
   <!-- Chart.js Script for Monthly Descarte Chart -->
   <script>
   $(document).ready(function() {
       let descarteChart = null;
       
       // Initialize the chart
       function initChart() {
           const ctx = document.getElementById('descarteChart').getContext('2d');
           
           descarteChart = new Chart(ctx, {
               type: 'bar',
               data: {
                   labels: [],
                   datasets: [
                       {
                           label: 'Valor Total ($)',
                           data: [],
                           backgroundColor: 'rgba(54, 162, 235, 0.8)',
                           borderColor: 'rgba(54, 162, 235, 1)',
                           borderWidth: 2,
                           yAxisID: 'y'
                       },
                       {
                           label: 'Cantidad de Buffalos',
                           data: [],
                           type: 'line',
                           borderColor: 'rgba(255, 99, 132, 1)',
                           backgroundColor: 'rgba(255, 99, 132, 0.1)',
                           borderWidth: 3,
                           fill: false,
                           yAxisID: 'y1'
                       }
                   ]
               },
               options: {
                   responsive: true,
                   maintainAspectRatio: false,
                   interaction: {
                       mode: 'index',
                       intersect: false,
                   },
                   scales: {
                       x: {
                           display: true,
                           title: {
                               display: true,
                               text: 'Mes'
                           }
                       },
                       y: {
                           type: 'linear',
                           display: true,
                           position: 'left',
                           title: {
                               display: true,
                               text: 'Valor Total ($)'
                           },
                           grid: {
                               drawOnChartArea: false,
                           },
                       },
                       y1: {
                           type: 'linear',
                           display: true,
                           position: 'right',
                           title: {
                               display: true,
                               text: 'Cantidad de Buffalos'
                           },
                           grid: {
                               drawOnChartArea: false,
                           },
                       }
                   },
                   plugins: {
                       title: {
                           display: true,
                           text: 'Evolución Mensual de Descartes - Valor y Cantidad'
                       },
                       tooltip: {
                           callbacks: {
                               label: function(context) {
                                   if (context.datasetIndex === 0) {
                                       return 'Valor: $' + context.parsed.y.toLocaleString();
                                   } else {
                                       return 'Cantidad: ' + context.parsed.y + ' buffalos';
                                   }
                               }
                           }
                       }
                   }
               }
           });
       }
       
       // Load chart data
       function loadChartData() {
           const year = $('#chartYear').val();
           const month = $('#chartMonth').val();
           
           $.ajax({
               url: 'get_descarte_monthly_data.php',
               type: 'GET',
               data: { year: year, month: month },
               success: function(response) {
                   if (response.success) {
                       updateChart(response.data);
                       updateSummaryCards(response.total_value, response.total_count);
                       populateYearFilter(response.years);
                   } else {
                       console.error('Error loading chart data:', response.message);
                   }
               },
               error: function(xhr, status, error) {
                   console.error('AJAX error:', error);
               }
           });
       }
       
       // Update chart with new data
       function updateChart(data) {
           if (!descarteChart) return;
           
           const labels = data.map(item => {
               const date = new Date(item.month + '-01');
               return date.toLocaleDateString('es-ES', { month: 'short', year: '2-digit' });
           });
           
           const values = data.map(item => item.total_value);
           const counts = data.map(item => item.buffalo_count);
           
           descarteChart.data.labels = labels;
           descarteChart.data.datasets[0].data = values;
           descarteChart.data.datasets[1].data = counts;
           
           descarteChart.update();
       }
       
       // Update summary cards
       function updateSummaryCards(totalValue, totalCount) {
           $('#totalChartValue').text('$' + totalValue.toLocaleString());
           $('#totalChartCount').text(totalCount);
       }
       
       // Populate year filter
       function populateYearFilter(years) {
           const yearSelect = $('#chartYear');
           yearSelect.find('option:not(:first)').remove();
           
           years.forEach(year => {
               yearSelect.append(`<option value="${year}">${year}</option>`);
           });
       }
       
       // Event handlers for filters
       $('#chartYear, #chartMonth').change(function() {
           loadChartData();
       });
       
       // Initialize chart and load data
       initChart();
       loadChartData();
   });
   </script>
   
 </body>
</html>