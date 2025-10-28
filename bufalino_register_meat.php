<?php
require_once './pdo_conexion.php';  

// Debug connection type
if (!($conn instanceof PDO)) {
    die("Error: Connection is not a PDO instance. Please check your connection setup.");
}
// Enable PDO error mode to get better error messages
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bufalino Register Carne</title>
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
.chart-container {
    position: relative;
    height: 500px;
    margin: 20px 0;
}

.chart-controls {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 20px;
}

.stats-cards {
    margin-bottom: 20px;
}

.stat-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    margin-bottom: 15px;
}

.stat-card h4 {
    margin: 0;
    font-size: 1.8rem;
    font-weight: bold;
}

.stat-card p {
    margin: 5px 0 0 0;
    opacity: 0.9;
}

.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 300px;
}

.professional-chart-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px 10px 0 0;
    padding: 20px;
    margin-bottom: 0;
}

.professional-chart-body {
    background: white;
    border-radius: 0 0 10px 10px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
</style>
</head>
<body>
<!-- Icon Navigation Buttons -->
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
                        <span class="badge-active">🎯 Registrando Peso</span>
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


  <!-- New Entry Modal -->
  <div class="modal fade" id="newPesoModal" tabindex="-1" aria-labelledby="newPesoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newPesoModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Peso
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newPesoForm">
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
                                <label for="new_peso" class="form-label">Peso (kg)</label>
                                <input type="text" class="form-control" id="new_peso" name="peso" required>
                            </span>
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                                <label for="new_precio" class="form-label">Precio ($/kg)</label>
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
                <button type="button" class="btn btn-success" id="saveNewPeso">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- DataTable for bh_peso records -->
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="carneTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Acciones</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Peso (kg)</th>
                      <th class="text-center">Precio ($/kg)</th>
                      <th class="text-center">Valor Total ($)</th>
                      <th class="text-center">Estatus</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      // Query to get all Animals and ALL their peso records (if any)
                        $pesoQuery = "
                            SELECT
                                b.tagid AS bufalino_tagid,
                                b.nombre AS animal_nombre,
                                p.id AS peso_id,         -- Will be NULL for animals with no peso records
                                p.bh_peso_fecha,
                                p.bh_peso_tagid,         -- Matches bufalino_tagid if peso exists
                                p.bh_peso_animal,
                                p.bh_peso_precio,
                                -- Calculate total_value only if p.id is not null
                                CASE WHEN p.id IS NOT NULL THEN CAST((p.bh_peso_animal * p.bh_peso_precio) AS DECIMAL(10,2)) ELSE NULL END as total_value
                            FROM
                                bufalino b
                            LEFT JOIN
                                bh_peso p ON b.tagid = p.bh_peso_tagid -- Join ALL matching peso records
                            ORDER BY
                                -- Prioritize animals with records (IS NOT NULL -> 0, IS NULL -> 1)
                                CASE WHEN p.id IS NOT NULL THEN 0 ELSE 1 END ASC,
                                -- Then order by animal tag ID to group them
                                b.tagid ASC,
                                -- Within each animal, order their peso records by date descending
                                p.bh_peso_fecha DESC";

                        $stmt = $conn->prepare($pesoQuery);
                        $stmt->execute();
                        $pesosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // If no data, display a message
                      if (empty($pesosData)) {
                          echo "<tr><td colspan='9' class='text-center'>No hay animales registrados</td></tr>"; // Updated message
                      } else {
                          // Get vigencia setting for peso records
                          $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT b_vencimiento_pesaje_animal FROM b_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              
                              // Explicitly use PDO fetch method
                              $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row && isset($row['b_vencimiento_pesaje_animal'])) {
                                  $vigencia = intval($row['b_vencimiento_pesaje_animal']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                              // Continue with default value
                          }
                          
                          $currentDate = new DateTime();
                          
                          foreach ($pesosData as $row) {
                              $hasPeso = !empty($row['peso_id']); // Check if this row represents a peso record
                              $pesoFecha = $row['bh_peso_fecha'] ?? null;
                              
                              echo "<tr>";
                              
                              // Column 1: Actions
                              echo '<td class="text-center">';
                              echo '    <div class="btn-group" role="group">';
                              // Always show Add Button
                              echo '        <button class="btn btn-success btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newPesoModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['bufalino_tagid'] ?? '').'" 
                                              title="Registrar Nuevo Peso">
                                              <i class="fas fa-plus"></i>
                                          </button>';
                              
                              if ($hasPeso) {
                                  // Edit Button (only if peso record exists for this row)
                                  echo '        <button class="btn btn-warning btn-sm edit-peso" 
                                                  data-id="'.htmlspecialchars($row['peso_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['bh_peso_tagid'] ?? '').'" 
                                                  data-peso="'.htmlspecialchars($row['bh_peso_animal'] ?? '').'" 
                                                  data-precio="'.htmlspecialchars($row['bh_peso_precio'] ?? '').'" 
                                                  data-fecha="'.htmlspecialchars($pesoFecha ?? '').'" 
                                                  title="Editar Peso">
                                                  <i class="fas fa-edit"></i>
                                              </button>';
                                  // Delete Button (only if peso record exists for this row)
                                  echo '        <button class="btn btn-danger btn-sm delete-peso" 
                                                  data-id="'.htmlspecialchars($row['peso_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['bh_peso_tagid'] ?? '').'" -- Pass tagid for context
                                                  title="Eliminar Peso">
                                                  <i class="fas fa-trash"></i>
                                              </button>';
                              }
                              echo '    </div>';
                              echo '</td>';
                              
                              // Column 2: Fecha
                              echo "<td>" . ($pesoFecha ? htmlspecialchars(date('d/m/Y', strtotime($pesoFecha))) : 'N/A') . "</td>";
                              // Column 3: Nombre Animal
                              echo "<td>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              // Column 4: Tag ID Animal
                              echo "<td>" . htmlspecialchars($row['bufalino_tagid'] ?? 'N/A') . "</td>"; // Use bufalino_tagid for consistency
                              // Column 5: Peso (kg)
                              echo "<td>" . ($hasPeso ? htmlspecialchars($row['bh_peso_animal'] ?? '') : 'N/A') . "</td>";
                              // Column 6: Precio ($/kg)
                              echo "<td>" . ($hasPeso ? htmlspecialchars($row['bh_peso_precio'] ?? '') : 'N/A') . "</td>";
                              // Column 7: Valor Total ($)
                              echo "<td>" . ($hasPeso && isset($row['total_value']) ? htmlspecialchars($row['total_value']) : 'N/A') . "</td>";
                              
                              // Column 8: Estatus
                              if ($hasPeso && $pesoFecha) {
                                  try {
                                      $pesoDate = new DateTime($pesoFecha);
                                      $dueDate = clone $pesoDate;
                                      $dueDate->modify("+{$vigencia} days");
                                      
                                      if ($currentDate > $dueDate) {
                                          echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>'; // Changed from VENCIDO
                                      } else {
                                          echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $pesoFecha);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>'; // Changed from ERROR
                                  }
                              } else {
                                  echo '<td class="text-center"><span class="badge bg-secondary">No Registro</span></td>'; // Status if no peso record
                              }
                              
                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in peso table: " . $e->getMessage());
                      echo "<tr><td colspan='8' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>"; // Colspan is 8 now
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH Peso -->
<script>
$(document).ready(function() {
    $('#carneTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[7, 'desc']],
        
        // Spanish language
        language: {
            url: 'es-ES.json',
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
                targets: [0], // Actions column (new position)
                orderable: false,
                searchable: false
            },
            {
                targets: [4, 5, 6], // Peso, Precio, Valor Total columns (indices shifted)
                render: function(data, type, row) {
                    if (type === 'display') {
                        if (data === 'N/A') return data;
                        const number = parseFloat(data);
                        if (!isNaN(number)) {
                            return number.toLocaleString('es-ES', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        } else {
                            return data;
                        }
                    }
                    return data;
                }
            },
            {
                targets: [1], // Fecha column (index shifted)
                type: 'date-eu',
                render: function(data, type, row) {
                     if (type === 'display') {
                        if (data === 'N/A') return data; // Pass through 'N/A'
                        // Date is already formatted DD/MM/YYYY in PHP
                        return data; 
                    }
                    // For sorting/filtering, convert DD/MM/YYYY back to YYYY-MM-DD
                    if (type === 'sort' || type === 'filter') {
                         if (data === 'N/A') return null; 
                         const parts = data.split('/');
                         if (parts.length === 3) {
                            return parts[2] + '-' + parts[1] + '-' + parts[0];
                         }
                         return null; // Fallback
                    }
                    return data;
                }
            },
            {
                targets: [7], // Status column (index shifted)
                orderable: true,
                searchable: true
            }
            // Removed old Actions column def (index 8)
        ]
    });
});
</script>

<!-- JavaScript for Modal Pre-fill -->
<script>
$(document).ready(function() {
    var newPesoModalEl = document.getElementById('newPesoModal');
    if (newPesoModalEl) {
        var tagIdInput = newPesoModalEl.querySelector('#new_tagid');
        newPesoModalEl.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var tagIdToPrefill = button ? button.getAttribute('data-tagid-prefill') : null;
            
            if (tagIdInput && tagIdToPrefill) {
                tagIdInput.value = tagIdToPrefill;
            } else if (tagIdInput) {
                tagIdInput.value = ''; // Clear if no prefill info (e.g., modal opened via different button)
            }
            // Optionally reset other fields
            // newPesoModalEl.querySelector('#new_peso').value = '';
            // newPesoModalEl.querySelector('#new_precio').value = '';
            // newPesoModalEl.querySelector('#new_fecha').value = '<?php echo date('Y-m-d'); ?>';
        });
    }
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    // Handle new entry form submission
    $('#saveNewPeso').click(function() {
        // Validate the form
        var form = document.getElementById('newPesoForm');
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
            text: `¿Desea registrar el peso de ${formData.peso} kg para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_weight.php',
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
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newPesoModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de peso ha sido guardado correctamente',
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
    $('.edit-peso').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var peso = $(this).data('peso');
        var precio = $(this).data('precio');
        var fecha = $(this).data('fecha');
        
        var modalHtml = `
        <div class="modal fade" id="editPesoModal" tabindex="-1" aria-labelledby="editPesoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPesoModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Pesaje
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPesoForm">
                            <input type="hidden" id="edit_id" value="${id}">                            
                            <div class="mb-4">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                        <label for="edit_fecha" class="form-label">Fecha</label>
                                        <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="mb-4">                                
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i>
                                    <label for="edit_tagid" class="form-label">Tag ID</label>
                                    <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="mb-4">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-weight"></i>
                                        <label for="edit_peso" class="form-label">Peso (kg)</label>
                                        <input type="text" class="form-control" id="edit_peso" value="${peso}" required>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mb-4">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                        <label for="edit_precio" class="form-label">Precio ($/kg)</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_precio" value="${precio}" required>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditPeso">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editPesoModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editPesoModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditPeso').click(function() {
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
                text: `¿Desea actualizar el registro de peso para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_weight.php',
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
                                text: 'El registro ha sido actualizado correctamente',
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
    $('.delete-peso').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar registro?',
            text: `¿Está seguro de que desea eliminar el registro para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
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
                    url: 'process_weight.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'El registro ha sido eliminado correctamente',
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

<!-- Professional Weight Evolution Chart Section -->
<div class="container mt-5">
    <div class="professional-chart-header">
        <h4 class="text-white mb-0">
            <i class="fas fa-chart-line me-2"></i>EVOLUCIÓN DE PESO - ANÁLISIS PROFESIONAL
        </h4>
    </div>
    
    <div class="professional-chart-body">
        <!-- Statistics Cards -->
        <div class="row stats-cards mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="pesoCurrentWeight">0.00 kg</h4>
                    <p>Peso Actual Promedio</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="pesoWeightGain">+0.00 kg</h4>
                    <p>Ganancia Total</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="pesoMonthlyGain">+0.00 kg</h4>
                    <p>Ganancia Mensual Prom.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="pesoTotalAnimals">0</h4>
                    <p>Total Animales</p>
                </div>
            </div>
        </div>

        <!-- Chart Controls -->
        <div class="chart-controls mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="animalFilter" class="form-label">
                        <i class="fas fa-filter me-2"></i>Filtrar por Animal
                    </label>
                    <select id="animalFilter" class="form-select">
                        <option value="all">Todos los animales</option>
                        <!-- Animal options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dataRangeFilter" class="form-label">
                        <i class="fas fa-calendar me-2"></i>Período de Datos
                    </label>
                    <select id="dataRangeFilter" class="form-select">
                        <option value="20">Últimos 20 registros</option>
                        <option value="50">Últimos 50 registros</option>
                        <option value="100">Últimos 100 registros</option>
                        <option value="all">Todos los registros</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary" onclick="refreshWeightChart()">
                        <i class="fas fa-sync-alt me-2"></i>Actualizar
                    </button>
                    <button class="btn btn-success ms-2" onclick="exportWeightChart()">
                        <i class="fas fa-download me-2"></i>Exportar
                    </button>
                </div>
            </div>
        </div>

        <!-- Chart Container -->
        <div class="chart-container">
            <div id="weightLoadingSpinner" class="loading-spinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
            <canvas id="weightChart"></canvas>
        </div>

        <!-- Data Summary Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-table me-2"></i>Resumen de Evolución de Peso</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="weightDataTable">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Peso Promedio (kg)</th>
                                <th>Variación Mensual (kg)</th>
                                <th>Registros</th>
                            </tr>
                        </thead>
                        <tbody id="weightDataTableBody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Weight Line Chart -->
<script>
$(document).ready(function() {
    let allWeightData = [];
    let weightChart = null;
    
    // Fetch weight data and create the chart
    $.ajax({
        url: 'get_weight_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allWeightData = data;
            populateAnimalFilter(data);
            createWeightChart(data);
            
            // Add event listeners for filters
            $('#animalFilter, #dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching weight data:', error);
        }
    });
    
    // --- Linear Regression Function ---
    function linearRegression(x, y) {
        const n = x.length;
        if (n < 2) {
            // Not enough data points for regression
            return { slope: 0, intercept: 0, r2: 0 };
        }

        let sumX = 0;
        let sumY = 0;
        let sumXY = 0;
        let sumXX = 0;
        // Removed sumYY calculation as it's only needed for R-squared

        for (let i = 0; i < n; i++) {
            sumX += x[i];
            sumY += y[i];
            sumXY += x[i] * y[i];
            sumXX += x[i] * x[i];
        }

        const denominator = (n * sumXX - sumX * sumX);
        if (denominator === 0) {
            // Avoid division by zero (vertical line or single x-value)
            return { slope: 0, intercept: sumY / n, r2: 0 }; // Return average Y as intercept
        }

        const slope = (n * sumXY - sumX * sumY) / denominator;
        const intercept = (sumY - slope * sumX) / n;

        // R-squared calculation (optional, can add later if needed)
        // let ssr = 0;
        // let sst = 0;
        // const meanY = sumY / n;
        // for (let i = 0; i < n; i++) {
        //     const predictedY = slope * x[i] + intercept;
        //     ssr += (predictedY - meanY) ** 2;
        //     sst += (y[i] - meanY) ** 2;
        // }
        // const r2 = (sst === 0) ? 1 : ssr / sst; // Handle case where all Y are the same

        return { slope: slope, intercept: intercept }; // Simplified return
    }
    // ---------------------------------
    
    function populateAnimalFilter(data) {
        // Get unique animals from the data
        const animals = [];
        const uniqueTagIds = new Set();
        
        data.forEach(item => {
            if (item.tagid && !uniqueTagIds.has(item.tagid)) {
                uniqueTagIds.add(item.tagid);
                animals.push({
                    tagid: item.tagid,
                    nombre: item.animal_nombre || 'Sin nombre'
                });
            }
        });
        
        // Sort animals by name
        animals.sort((a, b) => a.nombre.localeCompare(b.nombre));
        
        // Add options to the dropdown
        const animalFilter = $('#animalFilter');
        animals.forEach(animal => {
            animalFilter.append(`<option value="${animal.tagid}">${animal.nombre} (${animal.tagid})</option>`);
        });
    }
    
    function updateChart() {
        const selectedAnimal = $('#animalFilter').val();
        const selectedRange = $('#dataRangeFilter').val();
        
        let filteredData = [...allWeightData];
        
        // Filter by animal if not "all"
        if (selectedAnimal !== 'all') {
            filteredData = filteredData.filter(item => item.tagid === selectedAnimal);
        }
        
        // Sort data by date
        filteredData.sort((a, b) => new Date(a.fecha) - new Date(b.fecha));
        
        // Apply range filter
        if (selectedRange !== 'all' && filteredData.length > parseInt(selectedRange)) {
            filteredData = filteredData.slice(filteredData.length - parseInt(selectedRange));
        }
        
        // Update chart with filtered data
        updateChartData(filteredData);
    }
    
    function updateChartData(data) {
        if (weightChart) {
            weightChart.destroy();
        }
        createWeightChart(data);
    }
    
    function createWeightChart(data) {
        var ctx = document.getElementById('weightChart').getContext('2d');
        
        // Group data by month and calculate average weight per month
        const monthlyData = {};
        
        data.forEach(function(item) {
            const date = new Date(item.timestamp_fecha * 1000);
            const monthKey = date.getFullYear() + '-' + String(date.getMonth() + 1).padStart(2, '0');
            
            if (!monthlyData[monthKey]) {
                monthlyData[monthKey] = {
                    weights: [],
                    animalName: item.animal_nombre,
                    tagid: item.tagid
                };
            }
            
            const peso = parseFloat(item.peso) || 0;
            if (peso > 0) {
                monthlyData[monthKey].weights.push(peso);
            }
        });
        
        // Convert to arrays and calculate averages
        const monthlyEntries = Object.entries(monthlyData)
            .map(([monthKey, data]) => ({
                month: monthKey,
                averageWeight: data.weights.length > 0 
                    ? data.weights.reduce((sum, weight) => sum + weight, 0) / data.weights.length 
                    : 0,
                animalName: data.animalName,
                tagid: data.tagid,
                recordCount: data.weights.length
            }))
            .sort((a, b) => a.month.localeCompare(b.month));
        
        // Update statistics
        updateWeightStatistics(monthlyEntries, data);
        updateWeightDataTable(monthlyEntries);
        
        // Format the data for the main chart labels and values
        var labels = monthlyEntries.map(function(item) {
            // Format month as "MMM YYYY" (e.g., "Ene 2024")
            const [year, month] = item.month.split('-');
            const date = new Date(year, month - 1, 1);
            return date.toLocaleDateString('es-ES', { month: 'short', year: 'numeric' });
        });
        
        var weights = monthlyEntries.map(function(item) {
            return item.averageWeight;
        });

        // --- Trendline Calculation ---
        var xValues = monthlyEntries.map((item, index) => index); // Use sequential numbers for months
        var yValues = weights; // Numeric weights for y
        
        const regression = linearRegression(xValues, yValues);
        const trendlineYValues = xValues.map(x => regression.slope * x + regression.intercept);
        
        // --- Calculate Average Monthly Slope ---
        // Since xValues are now month indices (0, 1, 2, ...), slope is already in kg per month
        const monthlySlopeKg = regression.slope;
        // ------------------------------------
        
        // Destroy existing chart instance if it exists
        if (weightChart) {
            weightChart.destroy();
        }
        
        weightChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                { // Original Weight Data
                    label: 'Peso (kg)',
                    data: weights,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3
                },
                { // Trendline Data
                    label: 'Tendencia Lineal',
                    data: trendlineYValues, // Y values calculated from regression
                    borderColor: 'rgba(255, 99, 132, 0.8)', // Reddish color for trend
                    borderWidth: 2,
                    borderDash: [5, 5], // Dashed line style
                    type: 'line', // Explicitly line type
                    pointRadius: 4, // Changed from 0 to show points
                    pointBackgroundColor: 'rgba(255, 99, 132, 0.8)', // Match line color
                    pointBorderColor: '#fff', // White border for points
                    pointHoverRadius: 6, // Slightly larger on hover
                    fill: false,
                    tension: 0 // Straight line
                }
            ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Peso (kg)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + ' kg';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var index = context.dataIndex;
                                var datasetIndex = context.datasetIndex;
                                var monthlyPoint = monthlyEntries[index]; // Monthly data point info
                                var value = context.parsed.y;

                                let tooltipText = [];

                                // Check which dataset is being hovered
                                if (datasetIndex === 0) { // Monthly average weight data
                                    tooltipText.push('Peso Promedio: ' + value.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + ' kg');
                                    if (monthlyPoint) {
                                        tooltipText.push('Registros: ' + monthlyPoint.recordCount);
                                        if (monthlyPoint.animalName && $('#animalFilter').val() !== 'all') {
                                            tooltipText.unshift('Animal: ' + monthlyPoint.animalName);
                                        }
                                    }
                                } else if (datasetIndex === 1) { // Trendline data
                                    tooltipText.push('Tendencia: ' + value.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + ' kg');
                                } else {
                                    // Fallback for any other datasets
                                    tooltipText.push(context.dataset.label + ': ' + value.toLocaleString('es-ES'));
                                }

                                return tooltipText;
                            },
                            // Optional: Customize title if needed, e.g., show month
                            title: function(tooltipItems) {
                                // Show month instead of date
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: function() {
                            const selectedAnimal = $('#animalFilter').val();
                            let baseTitle = 'Evolución de Peso Mensual (Promedio)';
                            if (selectedAnimal !== 'all') {
                                const animalName = $('#animalFilter option:selected').text();
                                baseTitle = 'Evolución de Peso Mensual - ' + animalName;
                            }
                            
                            // Append monthly slope if calculated and meaningful
                            if (regression.slope !== 0 && monthlyEntries.length > 1) { 
                                const formattedSlope = monthlySlopeKg.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2,
                                    signDisplay: 'always' // Show + or -
                                });
                                return baseTitle + ` | Variación Mensual Prom.: ${formattedSlope} kg`;
                            }
                            
                            return baseTitle; // Return base title if no slope
                        },
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
    
    // Add professional statistics and data table functions
    function updateWeightStatistics(monthlyEntries, rawData) {
        if (monthlyEntries.length === 0) return;
        
        const currentWeight = monthlyEntries[monthlyEntries.length - 1].averageWeight;
        const firstWeight = monthlyEntries[0].averageWeight;
        const totalWeightGain = currentWeight - firstWeight;
        const monthlyGain = monthlyEntries.length > 1 ? totalWeightGain / (monthlyEntries.length - 1) : 0;
        
        // Count unique animals
        const uniqueAnimals = new Set(rawData.map(item => item.tagid));
        
        $('#pesoCurrentWeight').text(currentWeight.toLocaleString('es-ES', {minimumFractionDigits: 2}) + ' kg');
        $('#pesoWeightGain').text((totalWeightGain >= 0 ? '+' : '') + totalWeightGain.toLocaleString('es-ES', {minimumFractionDigits: 2}) + ' kg');
        $('#pesoMonthlyGain').text((monthlyGain >= 0 ? '+' : '') + monthlyGain.toLocaleString('es-ES', {minimumFractionDigits: 2}) + ' kg');
        $('#pesoTotalAnimals').text(uniqueAnimals.size);
    }
    
    function updateWeightDataTable(monthlyEntries) {
        const tbody = $('#weightDataTableBody');
        tbody.empty();
        
        monthlyEntries.forEach(function(item, index) {
            const date = new Date(item.month + '-01');
            const monthName = date.toLocaleDateString('es-ES', { year: 'numeric', month: 'long' });
            const variation = index > 0 ? (item.averageWeight - monthlyEntries[index - 1].averageWeight) : 0;
            
            const row = `
                <tr>
                    <td>${monthName}</td>
                    <td>${item.averageWeight.toLocaleString('es-ES', {minimumFractionDigits: 2})} kg</td>
                    <td>${(variation >= 0 ? '+' : '')+ variation.toLocaleString('es-ES', {minimumFractionDigits: 2})} kg</td>
                    <td>${item.recordCount}</td>
                </tr>
            `;
            tbody.append(row);
        });
    }
    
    // Export functions
    window.refreshWeightChart = function() {
        updateChart();
    };
    
    window.exportWeightChart = function() {
        if (!weightChart) {
            alert('No hay gráfico para exportar');
            return;
        }
        const link = document.createElement('a');
        link.download = 'evolucion_peso_' + new Date().toISOString().split('T')[0] + '.png';
        link.href = weightChart.toBase64Image();
        link.click();
    };
});
</script>

<!-- Professional Price Evolution Chart Section -->
<div class="container mt-5">
    <div class="professional-chart-header">
        <h4 class="text-white mb-0">
            <i class="fas fa-dollar-sign me-2"></i>EVOLUCIÓN PRECIO ANIMALES EN PIE - ANÁLISIS PROFESIONAL
        </h4>
    </div>
    
    <div class="professional-chart-body">
        <!-- Statistics Cards -->
        <div class="row stats-cards mb-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="precioCurrentValue">$0.00</h4>
                    <p>Valor Actual Promedio</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="precioTotalValue">$0.00</h4>
                    <p>Valor Total Acumulado</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="precioMonthlyChange">$0.00</h4>
                    <p>Variación Mensual Prom.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h4 id="precioHighestMonth">$0.00</h4>
                    <p>Mes Más Alto</p>
                </div>
            </div>
        </div>

        <!-- Chart Controls -->
        <div class="chart-controls mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="precioPeriodSelect" class="form-label">
                        <i class="fas fa-calendar me-2"></i>Período de Tiempo
                    </label>
                    <select class="form-select" id="precioPeriodSelect">
                        <option value="all">Todos los Datos</option>
                        <option value="12">Últimos 12 Meses</option>
                        <option value="6">Últimos 6 Meses</option>
                        <option value="3">Últimos 3 Meses</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">
                        <i class="fas fa-eye me-2"></i>Mostrar
                    </label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="precioShowValues" checked>
                        <label class="form-check-label" for="precioShowValues">
                            Valores Mensuales
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="precioShowTrend" checked>
                        <label class="form-check-label" for="precioShowTrend">
                            Línea de Tendencia
                        </label>
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary" onclick="refreshPrecioChart()">
                        <i class="fas fa-sync-alt me-2"></i>Actualizar
                    </button>
                    <button class="btn btn-success ms-2" onclick="exportPrecioChart()">
                        <i class="fas fa-download me-2"></i>Exportar
                    </button>
                </div>
            </div>
        </div>

        <!-- Chart Container -->
        <div class="chart-container">
            <div id="precioLoadingSpinner" class="loading-spinner" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
            <div id="weightValueChartMessage" class="text-center text-muted small mb-2"></div>
            <canvas id="weightValueChart"></canvas>
        </div>

        <!-- Data Summary Table -->
        <div class="card mt-4">
            <div class="card-header">
                <h5><i class="fas fa-table me-2"></i>Resumen de Evolución de Precios</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="precioDataTable">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Valor Total ($)</th>
                                <th>Variación Mensual ($)</th>
                                <th>% del Total</th>
                            </tr>
                        </thead>
                        <tbody id="precioDataTableBody">
                            <!-- Data will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Weight Value Chart -->
<script>
$(document).ready(function() {
    let weightValueChart = null;
    const weightValueUrl = 'get_monthly_weight_value_data.php'; // Our updated endpoint

    // Re-use the linear regression function from the previous chart
    function linearRegression(x, y) {
        const n = x.length;
        if (n < 2) return { slope: 0, intercept: 0 };
        let sumX = 0, sumY = 0, sumXY = 0, sumXX = 0;
        for (let i = 0; i < n; i++) {
            sumX += x[i]; sumY += y[i]; sumXY += x[i] * y[i]; sumXX += x[i] * x[i];
        }
        const denominator = (n * sumXX - sumX * sumX);
        if (denominator === 0) return { slope: 0, intercept: sumY / n };
        const slope = (n * sumXY - sumX * sumY) / denominator;
        const intercept = (sumY - slope * sumX) / n;
        return { slope: slope, intercept: intercept };
    }

    // Fetch monthly weight value data
    $.ajax({
        url: weightValueUrl,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (!Array.isArray(data) || data.error) {
                console.error('Server error fetching monthly weight value:', data);
                 $('#weightValueChartMessage').text('Error al cargar datos de valor de peso.');
                return;
            }
            if (data.length === 0) {
                 console.warn('No monthly weight value data received.');
                 $('#weightValueChartMessage').text('No hay datos disponibles para mostrar el valor de peso mensual.');
                 return;
            }
            createWeightValueChart(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly weight value data:', error);
            $('#weightValueChartMessage').text('Error al cargar datos para el gráfico de valor de peso.');
        }
    });

    function createWeightValueChart(data) {
        var ctx = document.getElementById('weightValueChart').getContext('2d');

        // Format data for chart
        var labels = data.map(item => item.month); // YYYY-MM labels
        var values = data.map(item => parseFloat(item.total_weight_value) || 0);
        
        // Update statistics and data table
        updatePrecioStatistics(data, values);
        updatePrecioDataTable(data, values);

        // --- Trendline Calculation ---
        var xValues = data.map(item => item.month_timestamp); // Use month timestamp
        var yValues = values;
        
        const regression = linearRegression(xValues, yValues);
        const trendlineYValues = xValues.map(x => regression.slope * x + regression.intercept);
        
        // Calculate Average Monthly Slope in $
        const secondsPerDay = 24 * 60 * 60;
        const approxDaysPerMonth = 365.25 / 12;
        const secondsPerMonth = secondsPerDay * approxDaysPerMonth;
        const monthlySlopeValue = regression.slope * secondsPerMonth; // Slope in $/month
        // ---------------------------

        // Destroy existing chart instance if it exists
        if (weightValueChart) {
            weightValueChart.destroy();
        }

        weightValueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                { // Original Monthly Value Data
                    label: 'Precio Animales en Pie ($)',
                    data: values,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)', // Primary blue
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3
                },
                { // Trendline Data
                    label: 'Tendencia Lineal ($)',
                    data: trendlineYValues,
                    borderColor: 'rgba(220, 53, 69, 0.8)', // Danger red for trend
                    borderWidth: 2,
                    borderDash: [5, 5],
                    type: 'line',
                    pointRadius: 4, // Show points
                    pointBackgroundColor: 'rgba(220, 53, 69, 0.8)',
                    pointBorderColor: '#fff',
                    pointHoverRadius: 6,
                    fill: false,
                    tension: 0 
                }
            ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true, // Value should start at 0
                        title: {
                            display: true,
                            text: 'Precio en Pie ($)',
                            font: { size: 14, weight: 'bold' }
                        },
                        ticks: {
                            callback: function(value) {
                                return '$ ' + value.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes',
                            font: { size: 14, weight: 'bold' }
                        }
                    }
                },
                plugins: {
                    legend: { display: true, position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var datasetIndex = context.datasetIndex;
                                var value = context.parsed.y;
                                if (datasetIndex === 0) { // Original data
                                    return 'Valor: $ ' + value.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                } else if (datasetIndex === 1) { // Trendline data
                                     return 'Tendencia: $ ' + value.toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                                }
                                return ''; // Default
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: function() {
                            let baseTitle = 'Evolución Precio Animales en Pie';
                            // Append monthly slope if calculated
                            if (regression.slope !== 0 && data.length > 1) {
                                const formattedSlope = monthlySlopeValue.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2,
                                    signDisplay: 'always' 
                                });
                                return baseTitle + ` | Variación Mensual Prom.: $ ${formattedSlope}`;
                            }
                            return baseTitle; 
                        },
                        font: { size: 16 }
                    }
                }
            }
        });
    }
    
    // Add professional statistics and data table functions for price chart
    function updatePrecioStatistics(data, values) {
        if (data.length === 0) return;
        
        const currentValue = values[values.length - 1];
        const totalValue = values.reduce((sum, val) => sum + val, 0);
        const monthlyChange = values.length > 1 ? (currentValue - values[0]) / (values.length - 1) : 0;
        const highestMonth = Math.max(...values);
        
        $('#precioCurrentValue').text('$' + currentValue.toLocaleString('es-ES', {minimumFractionDigits: 2}));
        $('#precioTotalValue').text('$' + totalValue.toLocaleString('es-ES', {minimumFractionDigits: 2}));
        $('#precioMonthlyChange').text('$' + (monthlyChange >= 0 ? '+' : '') + monthlyChange.toLocaleString('es-ES', {minimumFractionDigits: 2}));
        $('#precioHighestMonth').text('$' + highestMonth.toLocaleString('es-ES', {minimumFractionDigits: 2}));
    }
    
    function updatePrecioDataTable(data, values) {
        const tbody = $('#precioDataTableBody');
        tbody.empty();
        
        const totalValue = values.reduce((sum, val) => sum + val, 0);
        
        data.forEach(function(item, index) {
            const date = new Date(item.month + '-01');
            const monthName = date.toLocaleDateString('es-ES', { year: 'numeric', month: 'long' });
            const value = values[index];
            const variation = index > 0 ? (value - values[index - 1]) : 0;
            const percentage = totalValue > 0 ? (value / totalValue * 100).toFixed(1) : '0.0';
            
            const row = `
                <tr>
                    <td>${monthName}</td>
                    <td>$${value.toLocaleString('es-ES', {minimumFractionDigits: 2})}</td>
                    <td>$${(variation >= 0 ? '+' : '') + variation.toLocaleString('es-ES', {minimumFractionDigits: 2})}</td>
                    <td>${percentage}%</td>
                </tr>
            `;
            tbody.append(row);
        });
    }
    
    // Add event listeners for the new controls
    $('#precioPeriodSelect').change(function() {
        updatePrecioChart();
    });
    
    $('#precioShowValues, #precioShowTrend').change(function() {
        updatePrecioChartVisibility();
    });
    
    function updatePrecioChart() {
        // Re-fetch data with current filters (simplified for now)
        location.reload(); // Simple refresh - could be enhanced with AJAX filtering
    }
    
    function updatePrecioChartVisibility() {
        if (!weightValueChart) return;
        
        const showValues = $('#precioShowValues').is(':checked');
        const showTrend = $('#precioShowTrend').is(':checked');
        
        weightValueChart.data.datasets[0].hidden = !showValues;
        weightValueChart.data.datasets[1].hidden = !showTrend;
        
        weightValueChart.update();
    }
    
    // Export functions
    window.refreshPrecioChart = function() {
        updatePrecioChart();
    };
    
    window.exportPrecioChart = function() {
        if (!weightValueChart) {
            alert('No hay gráfico para exportar');
            return;
        }
        const link = document.createElement('a');
        link.download = 'evolucion_precio_' + new Date().toISOString().split('T')[0] + '.png';
        link.href = weightValueChart.toBase64Image();
        link.click();
    };
});
</script>

</body>
</html>