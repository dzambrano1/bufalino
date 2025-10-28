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
<title>Bufalino - Registro Aftosa</title>
<!-- Link to the Favicon -->
<link rel="icon" href="images/default_image.png" type="image/x-icon">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Bootstrap 5.3.2 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- DataTables 1.13.7 / Responsive 2.5.0 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
<!-- DataTables Buttons 2.4.1 -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="./bufalino.css">

<!-- JS -->
<!-- jQuery 3.7.0 -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<!-- Bootstrap 5.3.2 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables 1.13.7 / Responsive 2.5.0 -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<!-- DataTables Buttons 2.4.1 -->
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

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
                        <span class="badge-active">🎯 Registrando Aftosa</span>
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

  
  <!-- New Aftosa Entry Modal -->
  
  <div class="modal fade" id="newEntryModal" tabindex="-1" aria-labelledby="newEntryModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newEntryModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nueva Vacunacion Aftosa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newAftosaForm">
                <div class="mb-4">
                    <input type="hidden" id="new_id" name="id" value="">                        
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
                                <i class="fa-solid fa-syringe"></i>
                                <label for="new_vacuna" class="form-label">Vacunas Aftosa</label>
                                <select class="form-select" id="new_vacuna" name="vacuna" required>
                                    <option value="">Vacunas</option>
                                    <?php
                                    try {
                                        $sql_vacunas = "SELECT DISTINCT bc_aftosa_vacuna FROM bc_aftosa ORDER BY bc_aftosa_vacuna ASC";
                                        $stmt_vacunas = $conn->prepare($sql_vacunas);
                                        $stmt_vacunas->execute();
                                        $vacunas = $stmt_vacunas->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($vacunas as $vacuna_row) {
                                            echo '<option value="' . htmlspecialchars($vacuna_row['bc_aftosa_vacuna']) . '">' . htmlspecialchars($vacuna_row['bc_aftosa_vacuna']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Error fetching vacunas: " . $e->getMessage());
                                        echo '<option value="">Error al cargar vacunas</option>';
                                    }
                                    ?>
                                </select>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-eye-dropper"></i>
                                <label for="new_dosis" class="form-label">Dosis (ml)</label>
                                <input type="number" step="0.01" class="form-control" id="new_dosis" name="dosis" required>
                            </span>
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-money-bill-1-wave"></i>
                                <label for="new_costo" class="form-label">Costo ($)</label>
                                <input type="number" step="0.01" class="form-control" id="new_costo" name="costo" required>
                            </span>                            
                        </div>
                    </div>                                          
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewAftosa">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for bh_aftosa records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="aftosaTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                    <th class="text-center">Acciones</th>
                    <th class="text-center">F. Vacunacion</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Numero</th>
                    <th class="text-center">Vacuna</th>
                    <th class="text-center">Dosis (ml)</th>
                    <th class="text-center">Costo ($)</th>
                    <th class="text-center">Estatus</th>                      
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      $aftosaQuery = "SELECT 
                                          v.id AS bufalino_id, -- Alias bufalino ID
                                          v.tagid,
                                          v.nombre,
                                          va.bh_aftosa_fecha,
                                          va.id AS aftosa_record_id, -- Alias aftosa record ID
                                          va.bh_aftosa_producto,
                                          va.bh_aftosa_dosis,
                                          va.bh_aftosa_costo,
                                          -- Flag to easily check if there's a history record
                                          CASE WHEN va.bh_aftosa_tagid IS NOT NULL THEN 1 ELSE 0 END AS in_aftosa_history
                                      FROM 
                                          bufalino v
                                      LEFT JOIN 
                                          -- Join with all aftosa records per tagid
                                          bh_aftosa va ON v.tagid = va.bh_aftosa_tagid 
                                      ORDER BY 
                                          va.bh_aftosa_fecha DESC, v.tagid ASC;";

                      $stmt = $conn->prepare($aftosaQuery);
                      $stmt->execute();
                      $aftosasData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      if (empty($aftosasData)) {
                          echo "<tr><td colspan='9' class='text-center'>No hay registros disponibles</td></tr>";
                      } else {
                          // Get vigencia setting for aftosa records
                          $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT b_vencimiento_aftosa FROM b_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              $row_config = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row_config && isset($row_config['b_vencimiento_aftosa'])) {
                                  $vigencia = intval($row_config['b_vencimiento_aftosa']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                          }

                          $currentDate = new DateTime();

                          foreach ($aftosasData as $row) {
                              echo "<tr>";
                              
                              // Actions column - Modified to always show Add button
                              echo '<td class="text-center">';
                              echo '    <div class="btn-group" role="group">';
                              
                              // Always show Add (+) button
                              echo '        <button class="btn btn-success btn-sm register-new-aftosa-btn" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newEntryModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['tagid'] ?? '').'" 
                                              title="Registrar Nueva Vacuna">
                                              <i class="fas fa-plus"></i>
                                          </button>';
                              
                              // Conditionally show Edit/Delete buttons if a record exists
                              if ($row['in_aftosa_history'] == 1) {
                                  echo '        <button class="btn btn-warning btn-sm edit-aftosa" 
                                                  data-id="' . htmlspecialchars($row['aftosa_record_id'] ?? '') . '" 
                                                  data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '" 
                                                  data-vacuna="' . htmlspecialchars($row['bh_aftosa_producto'] ?? '') . '" 
                                                  data-dosis="' . htmlspecialchars($row['bh_aftosa_dosis'] ?? '') . '" 
                                                  data-costo="' . htmlspecialchars($row['bh_aftosa_costo'] ?? '') . '" 
                                                  data-fecha="' . htmlspecialchars($row['bh_aftosa_fecha'] ?? '') . '"
                                                  title="Editar Vacuna">
                                                  <i class="fas fa-edit"></i>
                                              </button>';
                                  echo '        <button class="btn btn-danger btn-sm delete-aftosa" 
                                                  data-id="' . htmlspecialchars($row['aftosa_record_id'] ?? '') . '"
                                                  data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '" -- Pass tagid for context
                                                  title="Eliminar Vacuna">
                                                  <i class="fas fa-trash"></i>
                                              </button>';
                              }
                              
                              echo '    </div>';
                              echo '</td>';
                              
                              echo "<td>" . htmlspecialchars($row['bh_aftosa_fecha'] ?? '') . "</td>";
                              echo "<td>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                              echo "<td>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";

                              if ($row['in_aftosa_history'] == 1) {
                                  // Animal has vaccination history
                                  echo "<td>" . htmlspecialchars($row['bh_aftosa_producto'] ?? 'N/A') . "</td>";
                                  echo "<td>" . htmlspecialchars($row['bh_aftosa_dosis'] ?? 'N/A') . "</td>";
                                  echo "<td>" . htmlspecialchars($row['bh_aftosa_costo'] ?? 'N/A') . "</td>";

                                  // Calculate due date and determine status
                                  try {
                                      if (!empty($row['bh_aftosa_fecha'])) {
                                          $aftosaDate = new DateTime($row['bh_aftosa_fecha']);
                                          $dueDate = clone $aftosaDate;
                                          $dueDate->modify("+{$vigencia} days");

                                          if ($currentDate > $dueDate) {
                                              echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                          } else {
                                              echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                          }
                                      } else {
                                           echo '<td class="text-center"><span class="badge bg-secondary">Sin Fecha</span></td>'; // Case where history exists but date is null
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $row['bh_aftosa_fecha']);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>';
                                  }
                              } else {
                                  // Animal has no vaccination history
                                  echo "<td>No Registrado</td>";
                                  echo "<td>N/A</td>";
                                  echo "<td>N/A</td>";
                                  echo '<td class="text-center"><span class="badge bg-secondary">NO VACUNADO</span></td>';
                              }

                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in aftosa table: " . $e->getMessage());
                      echo "<tr><td colspan='9' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH aftosa -->
<script>
$(document).ready(function() {
    $('#aftosaTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by Estatus column descending (now index 7)
        order: [[7, 'desc']],
        
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
        
        // Column specific settings - Updated indices
        columnDefs: [
             {
                 targets: [0], // NEW: Actions column (was 7)
                 orderable: false,
                 searchable: false
             },
            {
                targets: [5, 6], // NEW: Dosis, Costo columns (was 4, 5)
                render: function(data, type, row) {
                    if (type === 'display' && data !== 'N/A' && data !== 'No Registrado') {
                        // Attempt to parse only if data looks like a number
                         const num = parseFloat(data);
                         if (!isNaN(num)) {
                             return num.toLocaleString('es-ES', {
                                 minimumFractionDigits: 2,
                                 maximumFractionDigits: 2
                             });
                         }
                    }
                    return data; // Return original data if not display or not a valid number
                }
            },
            {
                targets: [1], // NEW: Fecha Nac. column (was 0)
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
                targets: [7], // NEW: Estatus column (was 6)
                orderable: true,
                searchable: true
            }
             // Removed the old definition for target 7 (Actions) as it's now handled by target 0
        ]
    });
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    // --- Initialize Modals Once --- 
    var newEntryModalElement = document.getElementById('newEntryModal');
    var newEntryModalInstance = new bootstrap.Modal(newEntryModalElement); 
    // Note: editAftosaModal is created dynamically later, so no need to initialize here.

    // Handle new entry form submission
    $('#saveNewAftosa').click(function() {
        // Validate the form
        var form = document.getElementById('newAftosaForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            vacuna: $('#new_vacuna').val(),
            dosis: $('#new_dosis').val(),
            costo: $('#new_costo').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar la dosis de aftosa ${formData.dosis} ml para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_aftosa.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        vacuna: formData.vacuna,
                        dosis: formData.dosis,
                        costo: formData.costo,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        newEntryModalInstance.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de aftosa ha sido guardado correctamente',
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
    $('.edit-aftosa').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var dosis = $(this).data('dosis');
        var vacuna = $(this).data('vacuna');
        var costo = $(this).data('costo');
        var fecha = $(this).data('fecha');

        console.log('Edit button clicked. Record ID captured:', id); // Debug log 1
        
        // Simple check if ID is missing before creating modal
        if (!id) {
             console.error('Attempting to edit a record with a missing ID.');
             Swal.fire({
                 title: 'Error',
                 text: 'No se puede editar este registro porque falta el ID.',
                 icon: 'error',
                 confirmButtonColor: '#dc3545'
             });
             return; // Stop execution if ID is missing
        }

        // Edit Aftosa Modal dialog for editing
        var modalHtml = `
        <div class="modal fade" id="editAftosaModal" tabindex="-1" aria-labelledby="editAftosaModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAftosaModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Vacunacion Aftosa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editAftosaForm">
                            <input type="hidden" id="edit_id" name="id" value="${id}">
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
                            <div class="mb-4">                        
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-syringe"></i>
                                        <label for="edit_vacuna" class="form-label">Vacunas Aftosa</label>
                                        <input type="text" class="form-control" id="edit_vacuna" name="vacuna" value="${vacuna}" readonly required>
                                        <button type="button" class="btn btn-outline-secondary" id="selectVacunaBtn" title="Seleccionar de configuración">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </span>                            
                                </div>
                            </div>
                            <div class="mb-2">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-eye-dropper"></i>
                                        <label for="edit_dosis" class="form-label">Dosis (ml)</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_dosis" value="${dosis}" required>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                        <label for="edit_costo" class="form-label">Costo ($)</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_costo" value="${costo}" required>
                                    </span>
                                </div>
                            </div>                            
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditAftosa">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Vacuna selection modal
        var vacunaSelectionModal = `
        <div class="modal fade" id="vacunaSelectionModal" tabindex="-1" aria-labelledby="vacunaSelectionModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vacunaSelectionModalLabel">
                            <i class="fas fa-list me-2"></i>Seleccionar Vacuna de Aftosa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="vacunaSearch" class="form-label">Buscar vacuna:</label>
                            <input type="text" class="form-control" id="vacunaSearch" placeholder="Escriba para buscar...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Vacunas disponibles:</label>
                            <div class="list-group" id="vacunaList" style="max-height: 300px; overflow-y: auto;">
                                <?php
                                try {
                                    $sql_vacunas = "SELECT DISTINCT bc_aftosa_vacuna FROM bc_aftosa ORDER BY bc_aftosa_vacuna ASC";
                                    $stmt_vacunas = $conn->prepare($sql_vacunas);
                                    $stmt_vacunas->execute();
                                    $vacunas = $stmt_vacunas->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($vacunas as $vacuna_row) {
                                        echo '<button type="button" class="list-group-item list-group-item-action vacuna-option" data-value="' . htmlspecialchars($vacuna_row['bc_aftosa_vacuna']) . '">' . htmlspecialchars($vacuna_row['bc_aftosa_vacuna']) . '</button>';
                                    }
                                } catch (PDOException $e) {
                                    error_log("Error fetching vacunas: " . $e->getMessage());
                                    echo '<div class="list-group-item text-danger">Error al cargar vacunas</div>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modals
        $('#editAftosaModal').remove();
        $('#vacunaSelectionModal').remove();
        
        // Add the modals to the page
        $('body').append(modalHtml);
        $('body').append(vacunaSelectionModal);
        
        // Show the edit modal
        var editModal = new bootstrap.Modal(document.getElementById('editAftosaModal'));
        
        // Set up vacuna selection functionality
        $('#selectVacunaBtn').click(function() {
            var vacunaSelectionModal = new bootstrap.Modal(document.getElementById('vacunaSelectionModal'));
            vacunaSelectionModal.show();
        });
        
        // Vacuna search functionality
        $('#vacunaSearch').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('.vacuna-option').each(function() {
                var vacunaName = $(this).text().toLowerCase();
                if (vacunaName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
        
        // Vacuna selection
        $(document).on('click', '.vacuna-option', function() {
            var selectedVacuna = $(this).data('value');
            $('#edit_vacuna').val(selectedVacuna);
            $('#vacunaSelectionModal').modal('hide');
        });
        
        editModal.show();
        
        // Set value after modal is fully rendered
        $('#edit_vacuna').val(vacuna);
        
        // Handle save button click
        $('#saveEditAftosa').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                vacuna: $('#edit_vacuna').val(),
                dosis: $('#edit_dosis').val(),
                costo: $('#edit_costo').val(),
                fecha: $('#edit_fecha').val()
            };
            
            console.log('Save changes clicked. Form Data being sent:', formData); // Debug log 2
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el registro de aftosa para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_aftosa.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            vacuna: formData.vacuna,
                            dosis: formData.dosis,
                            costo: formData.costo,
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
    $('.delete-aftosa').click(function() {
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
                    url: 'process_aftosa.php',
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

    // Handle new register button click for animals without history
    $(document).on('click', '.register-new-aftosa-btn', function() { 
        // Get tagid from the button's data-tagid-prefill attribute
        var tagid = $(this).data('tagid-prefill'); 
        
        // Clear previous data in the modal
        $('#newAftosaForm')[0].reset();
        $('#new_id').val(''); // Ensure ID is cleared
        
        // Pre-fill the tagid field
        $('#new_tagid').val(tagid);
        
        // Show the new entry modal using the existing instance
        newEntryModalInstance.show(); 
    });
});
</script>

<!-- Aftosa Line Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-success text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2"></i>
                Evolución Dosis Aftosa
            </h5>
        </div>
        <div class="card-body p-4">
            <!-- Enhanced filters with professional styling -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <label for="animalFilter" class="form-label fw-bold text-muted mb-2">
                        <i class="fas fa-cow me-2"></i>Filtrar por Animal:
                    </label>
                    <select id="animalFilter" class="form-select form-select-lg bg-white border-0 shadow-sm">
                        <option value="all">Todos los animales</option>
                        <!-- Animal options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="dataRangeFilter" class="form-label fw-bold text-muted mb-2">
                        <i class="fas fa-calendar-alt me-2"></i>Rango de Datos:
                    </label>
                    <select id="dataRangeFilter" class="form-select form-select-lg bg-white border-0 shadow-sm">
                        <option value="20">Últimos 20 dosis</option>
                        <option value="50">Últimos 50 dosis</option>
                        <option value="100">Últimos 100 dosis</option>
                        <option value="all">Todas las dosis</option>
                    </select>
                </div>
            </div>
            <div class="chart-container">
                <canvas id="aftosaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Professional CSS Styling for Aftosa Charts -->
<style>
/* Gradient backgrounds */
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
}

.bg-gradient-purple {
    background: linear-gradient(135deg, #6f42c1 0%, #e83e8c 100%) !important;
}

.bg-gradient-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
}

/* Chart container styling */
.chart-container {
    position: relative;
    height: 70bh;
    width: 100%;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.chart-container.loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 50px;
    height: 50px;
    margin: -25px 0 0 -25px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #28a745;
    border-radius: 50%;
    animation: spin 1.2s linear infinite;
    z-index: 1000;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Card styling */
.card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
}

.card-header {
    border-bottom: none;
    padding: 1.75rem;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.card-body {
    padding: 2.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

/* Enhanced form controls */
.form-select {
    border-radius: 12px;
    font-weight: 600;
    min-width: 180px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.form-select:focus {
    box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    border-color: #28a745;
    transform: translateY(-2px);
}

.form-select:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.form-label {
    font-size: 1.1rem;
    color: #495057;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Canvas styling */
canvas {
    border-radius: 12px;
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
}

canvas:hover {
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .chart-container {
        height: 60bh;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-header {
        padding: 1.25rem;
    }
    
    .form-select {
        min-width: 140px;
        font-size: 0.9rem;
    }
    
    .form-label {
        font-size: 1rem;
    }
}

/* Enhanced shadows and effects */
.shadow-lg {
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
}

/* Typography enhancements */
h5 {
    font-weight: 700;
    letter-spacing: 0.4px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Loading state */
.chart-container.loading canvas {
    opacity: 0.4;
    transition: opacity 0.3s ease;
}

/* Animation for chart elements */
.chart-container {
    animation: fadeInUp 0.8s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced hover effects */
.card:hover .card-header {
    background: linear-gradient(135deg, #20c997 0%, #28a745 100%) !important;
}

/* Smooth transitions */
* {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Professional color scheme */
.text-muted {
    color: #6c757d !important;
}

.fw-bold {
    font-weight: 700 !important;
}

/* Enhanced form styling */
.form-select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* Pie chart specific styling */
.pie-chart-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.pie-chart-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

.pie-chart-card .card-header {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
}

.pie-chart-card:hover .card-header {
    background: linear-gradient(135deg, #495057 0%, #6c757d 100%) !important;
}

/* Toggle button styling */
.toggle-non-vaccinated-table {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid #6c757d;
}

.toggle-non-vaccinated-table:hover {
    background-color: #6c757d;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
}

/* Table styling */
.table-sm {
    font-size: 0.875rem;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.table-sm thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    font-weight: 600;
    color: #495057;
}

/* Animation delays for staggered loading */
.chart-container:nth-child(1) { animation-delay: 0.1s; }
.chart-container:nth-child(2) { animation-delay: 0.2s; }
.chart-container:nth-child(3) { animation-delay: 0.3s; }
.chart-container:nth-child(4) { animation-delay: 0.4s; }
.chart-container:nth-child(5) { animation-delay: 0.5s; }
.chart-container:nth-child(6) { animation-delay: 0.6s; }
</style>

<!-- Chart.js Script for Aftosa Line Chart -->
<script>
$(document).ready(function() {
    let allAftosaData = [];
    let aftosaChart = null;
    
    // Add loading state to chart container
    $('.chart-container').addClass('loading');
    
    // Fetch aftosa data and create the chart
    $.ajax({
        url: 'get_aftosa_data.php',
        type: 'GET',
        dataType: 'json',
        beforeSend: function() {
            $('.chart-container').addClass('loading');
        },
        success: function(data) {
            $('.chart-container').removeClass('loading');
            
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allAftosaData = data;
            populateAnimalFilter(data);
            createAftosaChart(data);
            
            // Add event listeners for filters
            $('#animalFilter, #dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            $('.chart-container').removeClass('loading');
            console.error('Error fetching aftosa data:', error);
        }
    });
    
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
        
        let filteredData = [...allAftosaData];
        
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
        if (aftosaChart) {
            aftosaChart.destroy();
        }
        createAftosaChart(data);
    }
    
    function createAftosaChart(data) {
        var ctx = document.getElementById('aftosaChart').getContext('2d');
        
        // Create professional gradients
        const lineGradient = ctx.createLinearGradient(0, 0, 0, 400);
        lineGradient.addColorStop(0, 'rgba(40, 167, 69, 1)');
        lineGradient.addColorStop(1, 'rgba(32, 201, 151, 1)');

        const fillGradient = ctx.createLinearGradient(0, 0, 0, 400);
        fillGradient.addColorStop(0, 'rgba(40, 167, 69, 0.3)');
        fillGradient.addColorStop(0.5, 'rgba(40, 167, 69, 0.1)');
        fillGradient.addColorStop(1, 'rgba(40, 167, 69, 0.05)');
        
        // Format the data for the chart
        var labels = data.map(function(item) {
            // Format the date for display
            var parts = item.fecha.split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return item.fecha;
        });
        
        var dosis = data.map(function(item) {
            return item.dosis;
        });
        
        aftosaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: '💉 Dosis (ml)',
                    data: dosis,
                    backgroundColor: fillGradient,
                    borderColor: lineGradient,
                    borderWidth: 4,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 8,
                    pointHoverRadius: 12,
                    pointHoverBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 4,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2500,
                    easing: 'easeInOutQuart',
                    onProgress: function(animation) {
                        const chart = animation.chart;
                        const ctx = chart.ctx;
                        const dataset = chart.data.datasets[0];
                        const meta = chart.getDatasetMeta(0);
                        
                        if (meta.data.length > 0) {
                            const lastPoint = meta.data[meta.data.length - 1];
                            if (lastPoint) {
                                ctx.save();
                                ctx.shadowColor = 'rgba(40, 167, 69, 0.6)';
                                ctx.shadowBlur = 25;
                                ctx.shadowOffsetX = 0;
                                ctx.shadowOffsetY = 0;
                                ctx.restore();
                            }
                        }
                    },
                    onComplete: function(animation) {
                        const chart = animation.chart;
                        const ctx = chart.ctx;
                        ctx.shadowBlur = 0;
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Dosis (ml)',
                            color: '#495057',
                            font: {
                                size: 14,
                                weight: '700',
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                            },
                            padding: {
                                bottom: 15
                            }
                        },
                        ticks: {
                            color: '#6c757d',
                            font: {
                                size: 12,
                                weight: '600',
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                            },
                            padding: 10,
                            callback: function(value) {
                                return value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + ' ml';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.08)',
                            lineWidth: 1,
                            drawBorder: false
                        },
                        border: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            width: 1
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha',
                            color: '#495057',
                            font: {
                                size: 14,
                                weight: '700',
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                            },
                            padding: {
                                top: 15
                            }
                        },
                        ticks: {
                            color: '#6c757d',
                            font: {
                                size: 12,
                                weight: '600',
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                            },
                            padding: 10
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.08)',
                            lineWidth: 1,
                            drawBorder: false
                        },
                        border: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            width: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'center',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 25,
                            font: {
                                size: 14,
                                weight: '700',
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                            },
                            color: '#495057'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 16,
                            weight: '700',
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        bodyFont: {
                            size: 14,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: 18,
                        cornerRadius: 16,
                        displayColors: false,
                        borderColor: 'rgba(40, 167, 69, 0.8)',
                        borderWidth: 3,
                        callbacks: {
                            label: function(context) {
                                var index = context.dataIndex;
                                var datasetIndex = context.datasetIndex;
                                var dataPoint = data[index];
                                
                                var tooltipText = [
                                    '💉 Dosis: ' + context.parsed.y.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    }) + ' ml'
                                ];
                                
                                if (dataPoint && dataPoint.animal_nombre) {
                                    tooltipText.unshift('🐄 Animal: ' + dataPoint.animal_nombre);
                                }
                                
                                return tooltipText;
                            }
                        }
                    },
                    title: {
                        display: false
                    }
                },
                elements: {
                    point: {
                        hoverBorderWidth: 4,
                        hoverBorderColor: '#fff'
                    },
                    line: {
                        borderWidth: 3
                    }
                }
            }
        });
    }
});
</script>

<!-- Pie Chart Section -->
<div class="container mt-5 mb-5">
    <h4 class="text-center text-black mb-4 fw-bold">
        <i class="fas fa-chart-pie me-2"></i>
        Estado de Vacunación Aftosa por Grupos
    </h4>
    <div class="row justify-content-center" id="groupChartsContainer">
        <!-- Group charts will be populated dynamically here -->
    </div>
</div>

<!-- Chart.js Script for Aftosa Status Pie Charts -->
<script>
$(document).ready(function() {
    const aftosaStatusUrl = 'get_aftosa_status_by_grupo.php';
    let pieCharts = {}; // Store chart instances

    // --- Helper function to create group chart HTML ---
    function createGroupChartHtml(grupo) {
        const safeGrupo = grupo.replace(/[^a-zA-Z0-9]/g, ''); // Remove special characters for IDs
        return `
            <div class="col-md-4 mb-4">
                <div class="card shadow-lg border-0 pie-chart-card">
                    <div class="card-header bg-gradient-secondary text-white">
                        <h5 class="mb-0 text-center">
                            <i class="fas fa-chart-pie me-2"></i>Grupo ${grupo}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="chart-container" style="position: relative; height:40bh; width:100%">
                            <canvas id="aftosaPie${safeGrupo}"></canvas>
                            <div id="aftosaPie${safeGrupo}Message" class="text-center small text-muted mt-2"></div>
                        </div>
                        <!-- Toggle Button and Table for Non-Vaccinated -->
                        <div class="text-center mt-3">
                            <button class="btn btn-outline-secondary btn-sm toggle-non-vaccinated-table" data-grupo="${grupo}" style="display: none;">
                                <i class="fas fa-eye me-1"></i>Mostrar/Ocultar No Vacunados
                            </button>
                        </div>
                        <div id="nonVaccinatedTableContainer${safeGrupo}" class="mt-3" style="display: none; max-height: 200px; overflow-y: auto;">
                            <!-- Table will be populated here -->
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // --- Helper function to create or update a pie chart ---
    function createOrUpdatePieChart(canvasId, messageId, title, data) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        const messageDiv = $('#' + messageId);
        messageDiv.text(''); // Clear previous messages

        const vaccinated = data.vaccinated || 0;
        const nonVaccinated = data.non_vaccinated || 0;
        const total = vaccinated + nonVaccinated;

        if (pieCharts[canvasId]) {
            pieCharts[canvasId].destroy(); // Destroy previous instance if exists
        }

        if (total === 0) {
            messageDiv.text('No hay animales en este grupo.');
            $(ctx.canvas).hide();
            return; // Don't create chart if no data
        }
        
        $(ctx.canvas).show(); // Ensure canvas is visible

        // Create professional gradients for pie chart
        const vaccinatedGradient = ctx.createRadialGradient(0, 0, 0, 0, 0, 100);
        vaccinatedGradient.addColorStop(0, 'rgba(40, 167, 69, 0.9)');
        vaccinatedGradient.addColorStop(1, 'rgba(40, 167, 69, 0.7)');

        const nonVaccinatedGradient = ctx.createRadialGradient(0, 0, 0, 0, 0, 100);
        nonVaccinatedGradient.addColorStop(0, 'rgba(220, 53, 69, 0.9)');
        nonVaccinatedGradient.addColorStop(1, 'rgba(220, 53, 69, 0.7)');

        pieCharts[canvasId] = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    `✅ Vacunados (${vaccinated})`,
                    `❌ No Vacunados (${nonVaccinated})`
                ],
                datasets: [{
                    label: 'Estado Aftosa',
                    data: [vaccinated, nonVaccinated],
                    backgroundColor: [
                        vaccinatedGradient,
                        nonVaccinatedGradient
                    ],
                    borderColor: [
                        'rgba(40, 167, 69, 1)',
                        'rgba(220, 53, 69, 1)'
                    ],
                    borderWidth: 3,
                    hoverBorderWidth: 5,
                    hoverBorderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart',
                    animateRotate: true,
                    animateScale: true
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600',
                                family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                            },
                            color: '#495057'
                        }
                    },
                    title: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: {
                            size: 14,
                            weight: '700',
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        bodyFont: {
                            size: 12,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false,
                        borderColor: 'rgba(108, 117, 125, 0.8)',
                        borderWidth: 2,
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let percentage = 0;
                                if (total > 0) {
                                    percentage = ((value / total) * 100).toFixed(1);
                                }
                                return `${label}: ${percentage}%`;
                            }
                        }
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            dataArr.map(data => {
                                sum += data;
                            });
                            let percentage = (value*100 / sum).toFixed(1)+"%";
                            return (value*100 / sum) < 5 ? '' : percentage;
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 11
                        },
                        textShadow: '1px 1px 2px rgba(0,0,0,0.8)'
                    }
                }
            },
            plugins: [ChartDataLabels]
        });
    }

    // --- Helper function to update the non-vaccinated table ---
    function updateNonVaccinatedTable(grupo, nonVaccinatedList) {
        const safeGrupo = grupo.replace(/[^a-zA-Z0-9]/g, '');
        const containerId = `#nonVaccinatedTableContainer${safeGrupo}`;
        const buttonSelector = `.toggle-non-vaccinated-table[data-grupo='${grupo}']`;
        const container = $(containerId);
        const button = $(buttonSelector);

        container.empty().hide();
        button.hide();

        if (nonVaccinatedList && nonVaccinatedList.length > 0) {
            button.show();

            let tableHtml = '<table class="table table-sm table-striped table-bordered small">';
            tableHtml += '<thead><tr><th>Nombre</th><th>Tag ID</th></tr></thead><tbody>';

            nonVaccinatedList.forEach(animal => {
                const nombre = animal.nombre ? animal.nombre : 'N/A';
                tableHtml += `<tr><td>${nombre}</td><td>${animal.tagid}</td></tr>`;
            });

            tableHtml += '</tbody></table>';
            container.html(tableHtml);
        }
    }

    // Fetch data and create charts/tables
    $.ajax({
        url: aftosaStatusUrl,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Error fetching aftosa status data:', data.error);
                $('#groupChartsContainer').html('<div class="col-12 text-center text-danger">Error al cargar datos.</div>');
                return;
            }

            $('#groupChartsContainer').empty();

            const grupos = Object.keys(data);
            if (grupos.length === 0) {
                $('#groupChartsContainer').html('<div class="col-12 text-center text-muted">No hay grupos disponibles.</div>');
                return;
            }

            grupos.forEach((grupo, index) => {
                $('#groupChartsContainer').append(createGroupChartHtml(grupo));
                
                const safeGrupo = grupo.replace(/[^a-zA-Z0-9]/g, '');
                const grupoData = data[grupo] || {vaccinated: 0, non_vaccinated: 0, non_vaccinated_list: []};
                const canvasId = `aftosaPie${safeGrupo}`;
                const messageId = `aftosaPie${safeGrupo}Message`;
                
                // Add staggered animation delay
                setTimeout(() => {
                    createOrUpdatePieChart(canvasId, messageId, grupo, grupoData);
                    updateNonVaccinatedTable(grupo, grupoData.non_vaccinated_list);
                }, index * 200);
            });
        },
        error: function(xhr, status, error) {
            console.error('AJAX error fetching aftosa status data:', error);
            $('#groupChartsContainer').html('<div class="col-12 text-center text-danger">Error de conexión al cargar datos.</div>');
        }
    });

    // Add event listener for toggle buttons
    $(document).on('click', '.toggle-non-vaccinated-table', function() {
        const grupo = $(this).data('grupo');
        const safeGrupo = grupo.replace(/[^a-zA-Z0-9]/g, '');
        const containerId = `#nonVaccinatedTableContainer${safeGrupo}`;
        $(containerId).slideToggle('fast');
    });
});
</script>