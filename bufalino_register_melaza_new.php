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
<title>Bufalino - Registro de Melaza</title>
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
</style>
</head>
<body>
<body>
<!-- Icon Navigation Buttons -->

<div class="container nav-icons-container">
    <div class="icon-button-container">
        <button onclick="window.location.href='../inicio.php'" class="icon-button">
            <img src="./images/default_image.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">INICIO</span>
    </div>
    
    <div class="icon-button-container">
        <button onclick="window.location.href='./inventario_bufalino.php'" class="icon-button">
            <img src="./images/bufalo-icon.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">POBLACION</span>
    </div>
    
    <div class="icon-button-container">
        <button onclick="window.location.href='./bufalino_indices.php'" class="icon-button">
            <img src="./images/indices.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">INDICES</span>
    </div>

    <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion.php'" class="icon-button">
                <img src="./images/configuracion.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">CONFIG</span>
        </div>

</div>


<!-- Add back button before the header container -->
<a href="./bufalino_registros.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>
<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="melaza">
  REGISTROS DE MELAZA
  </h3>
    
  <!-- New Melaza Entry Modal -->
  
  <div class="modal fade" id="newMelazaModal" tabindex="-1" aria-labelledby="newMelazaModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMelazaModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Nuevo Registro Melaza
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newMelazaForm">
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
                                <i class="fa-solid fa-syringe"></i>
                                <label for="new_etapa" class="form-label">Etapa</label>
                                <select class="form-select" id="new_etapa" name="etapa" required>
                                    <option value="">Seleccionar</option>
                                    <?php
                                    try {
                                        $sql_etapas = "SELECT DISTINCT etapas_nombre FROM b_etapas ORDER BY etapas_nombre ASC";
                                        $stmt_etapas = $conn->prepare($sql_etapas);
                                        $stmt_etapas->execute();
                                        $etapas = $stmt_etapas->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($etapas as $etapa_row) {
                                            echo '<option value="' . htmlspecialchars($etapa_row['etapas_nombre']) . '">' . htmlspecialchars($etapa_row['etapas_nombre']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Error fetching etapas: " . $e->getMessage());
                                        echo '<option value="">Error al cargar etapas</option>';
                                    }
                                    ?>
                                </select>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-syringe"></i>
                                <label for="new_producto" class="form-label">Melaza</label>
                                <select class="form-select" id="new_producto" name="producto" required>
                                    <option value="">Productos</option>
                                    <?php
                                    try {
                                        $sql_alimentos = "SELECT DISTINCT bc_melaza_nombre FROM bc_melaza ORDER BY bc_melaza_nombre ASC";
                                        $stmt_alimentos = $conn->prepare($sql_alimentos);
                                        $stmt_alimentos->execute();
                                        $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($alimentos as $alimento_row) {
                                            echo '<option value="' . htmlspecialchars($alimento_row['bc_melaza_nombre']) . '">' . htmlspecialchars($alimento_row['bc_melaza_nombre']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Error fetching melazas: " . $e->getMessage());
                                        echo '<option value="">Error al cargar melazas</option>';
                                    }
                                    ?>
                                </select>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                            <i class="fa-solid fa-weight"></i>
                                <label for="new_racion" class="form-label">Racion</label>
                                <input type="text" class="form-control" id="new_racion" name="racion" required>
                            </span>                                
                        </div>
                    </div>                    
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                            <i class="fa-solid fa-dollar-sign"></i>
                                <label for="new_costo" class="form-label">Costo</label>
                                <input type="text" class="form-control" id="new_costo" name="costo" required>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewMelaza">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- DataTable for bh_melaza records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">  
          <table id="melazaTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">Acciones</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Etapa</th>
                      <th class="text-center">Producto</th>
                      <th class="text-center">Racion (kg)</th>
                      <th class="text-center">Costo ($/kg)</th>
                      <th class="text-center">Valor Total ($)</th>
                      <th class="text-center">Estatus</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      // Query to get all Animals and ALL their melaza records (if any)
                        $melazaQuery = "
                            SELECT
                                b.tagid AS bufalino_tagid,
                                b.nombre AS animal_nombre,
                                c.id AS melaza_id,         -- Will be NULL for animals with no melaza records
                                c.bh_melaza_fecha,
                                c.bh_melaza_tagid,         -- Matches bufalino_tagid if melaza exists
                                c.bh_melaza_etapa,
                                c.bh_melaza_producto,
                                c.bh_melaza_racion,
                                c.bh_melaza_costo,
                                -- Calculate total_value only if c.id is not null
                                CASE WHEN c.id IS NOT NULL THEN CAST((c.bh_melaza_racion * c.bh_melaza_costo) AS DECIMAL(10,2)) ELSE NULL END as total_value
                            FROM
                                bufalino b
                            LEFT JOIN
                                bh_melaza c ON b.tagid = c.bh_melaza_tagid -- Join ALL matching melaza records
                            ORDER BY
                                -- Prioritize animals with records (IS NOT NULL -> 0, IS NULL -> 1)
                                CASE WHEN c.id IS NOT NULL THEN 0 ELSE 1 END ASC,
                                -- Then order by animal tag ID to group them
                                b.tagid ASC,
                                -- Within each animal, order their melaza records by date descending
                                c.bh_melaza_fecha DESC";

                        $stmt = $conn->prepare($melazaQuery);
                        $stmt->execute();
                        $melazaData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // If no data, display a message
                      if (empty($melazaData)) {
                          echo "<tr><td colspan='10' class='text-center'>No hay animales registrados</td></tr>"; // Message adjusted
                      } else {
                          // Get vigencia setting for melaza records
                          $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT b_vencimiento_melaza FROM b_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              
                              // Explicitly use PDO fetch method
                              $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row && isset($row['b_vencimiento_melaza'])) {
                                  $vigencia = intval($row['b_vencimiento_melaza']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                              // Continue with default value
                          }
                          
                          $currentDate = new DateTime();
                          
                          foreach ($melazaData as $row) {
                              $hasMelaza = !empty($row['melaza_id']);
                              $melazaFecha = $row['bh_melaza_fecha'] ?? null;

                              echo "<tr>";

                              // Column 1: Actions
                              echo '<td class="text-center">';
                              echo '    <div class="btn-group" role="group">';
                              // Always show Add Button
                              echo '        <button class="btn btn-success btn-sm" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#newMelazaModal" 
                                              data-tagid-prefill="'.htmlspecialchars($row['bufalino_tagid'] ?? '').'" 
                                              title="Registrar Nuevo Melaza">
                                              <i class="fas fa-plus"></i>
                                          </button>';
                              
                              if ($hasMelaza) {
                                  // Edit Button (only if melaza exists)
                                  echo '        <button class="btn btn-warning btn-sm edit-melaza" 
                                                  data-id="'.htmlspecialchars($row['melaza_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['bufalino_tagid'] ?? '').'" 
                                                  data-etapa="'.htmlspecialchars($row['bh_melaza_etapa'] ?? '').'" 
                                                  data-producto="'.htmlspecialchars($row['bh_melaza_producto'] ?? '').'" 
                                                  data-racion="'.htmlspecialchars($row['bh_melaza_racion'] ?? '').'" 
                                                  data-costo="'.htmlspecialchars($row['bh_melaza_costo'] ?? '').'" 
                                                  data-fecha="'.htmlspecialchars($melazaFecha ?? '').'" 
                                                  title="Editar Registro">
                                                  <i class="fas fa-edit"></i>
                                              </button>';
                                  // Delete Button (only if melaza exists)
                                  echo '        <button class="btn btn-danger btn-sm delete-melaza" 
                                                  data-id="'.htmlspecialchars($row['melaza_id'] ?? '').'" 
                                                  data-tagid="'.htmlspecialchars($row['bufalino_tagid'] ?? '').'" 
                                                  title="Eliminar Registro">
                                                  <i class="fas fa-trash"></i>
                                              </button>';
                              }
                              echo '    </div>';
                              echo '</td>';

                              // Column 2: Fecha Melaza (or N/A)
                              echo "<td>" . ($melazaFecha ? htmlspecialchars(date('d/m/Y', strtotime($melazaFecha))) : 'N/A') . "</td>";
                              // Column 3: Nombre Animal
                              echo "<td>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              // Column 4: Tag ID Animal
                              echo "<td>" . htmlspecialchars($row['bufalino_tagid'] ?? 'N/A') . "</td>";
                              // Column 5: Etapa (or N/A)
                              echo "<td>" . ($hasMelaza ? htmlspecialchars($row['bh_melaza_etapa'] ?? '') : 'N/A') . "</td>";
                              // Column 6: Producto (or N/A)
                              echo "<td>" . ($hasMelaza ? htmlspecialchars($row['bh_melaza_producto'] ?? '') : 'N/A') . "</td>";
                              // Column 7: Racion (or N/A)
                              echo "<td>" . ($hasMelaza ? htmlspecialchars($row['bh_melaza_racion'] ?? '') : 'N/A') . "</td>";
                              // Column 8: Costo (or N/A)
                              echo "<td>" . ($hasMelaza ? htmlspecialchars($row['bh_melaza_costo'] ?? '') : 'N/A') . "</td>";
                              // Column 9: Valor Total (or N/A)
                              echo "<td>" . ($hasMelaza && isset($row['total_value']) ? htmlspecialchars($row['total_value']) : 'N/A') . "</td>";
                              
                              // Column 10: Estatus (or N/A)
                              if ($hasMelaza && $melazaFecha) {
                                  try {
                                      $melazaDate = new DateTime($melazaFecha);
                                      $dueDate = clone $melazaDate;
                                      $dueDate->modify("+{$vigencia} days");
                                      
                                      if ($currentDate > $dueDate) {
                                          echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                      } else {
                                          echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                      }
                                  } catch (Exception $e) {
                                      error_log("Date error: " . $e->getMessage() . " for date: " . $melazaFecha);
                                      echo '<td class="text-center"><span class="badge bg-warning">ERROR FECHA</span></td>';
                                  }
                              } else {
                                  echo '<td class="text-center"><span class="badge bg-secondary">Sin Registro</span></td>'; // Status if no concentrado
                              }
                              
                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in melaza table: " . $e->getMessage());
                      echo "<tr><td colspan='10' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>"; // Adjusted colspan to 10
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>

  <!-- Chart Section for Melaza Expenses -->
  <div class="container mt-5">
      <div class="text-center">
          <h4 class="text-secondary mb-4">
              <i class="fas fa-chart-bar me-2"></i>GASTOS DE MELAZA - MENSUAL VS ACUMULADO
          </h4>
      </div>

      <!-- Statistics Cards -->
      <div class="row stats-cards mb-4">
          <div class="col-md-3">
              <div class="stat-card">
                  <h4 id="melazaTotalExpense">$0.00</h4>
                  <p>Total Acumulado</p>
              </div>
          </div>
          <div class="col-md-3">
              <div class="stat-card">
                  <h4 id="melazaMonthlyAverage">$0.00</h4>
                  <p>Promedio Mensual</p>
              </div>
          </div>
          <div class="col-md-3">
              <div class="stat-card">
                  <h4 id="melazaHighestMonth">$0.00</h4>
                  <p>Mes Más Alto</p>
              </div>
          </div>
          <div class="col-md-3">
              <div class="stat-card">
                  <h4 id="melazaCurrentMonth">$0.00</h4>
                  <p>Mes Actual</p>
              </div>
          </div>
      </div>

      <!-- Chart Controls -->
      <div class="chart-controls mb-4">
          <div class="row">
              <div class="col-md-4">
                  <label for="melazaPeriodSelect" class="form-label">
                      <i class="fas fa-calendar me-2"></i>Período de Tiempo
                  </label>
                  <select class="form-select" id="melazaPeriodSelect">
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
                      <input class="form-check-input" type="checkbox" id="melazaShowBars" checked>
                      <label class="form-check-label" for="melazaShowBars">
                          Gastos Mensuales (Barras)
                      </label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="melazaShowLine" checked>
                      <label class="form-check-label" for="melazaShowLine">
                          Acumulado (Línea)
                      </label>
                  </div>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                  <button class="btn btn-primary" onclick="refreshMelazaChart()">
                      <i class="fas fa-sync-alt me-2"></i>Actualizar
                  </button>
                  <button class="btn btn-success ms-2" onclick="exportMelazaChart()">
                      <i class="fas fa-download me-2"></i>Exportar
                  </button>
              </div>
          </div>
      </div>

      <!-- Chart Container -->
      <div class="chart-container">
          <div id="melazaLoadingSpinner" class="loading-spinner">
              <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Cargando...</span>
              </div>
          </div>
          <canvas id="melazaExpenseChart" style="display: none;"></canvas>
      </div>

      <!-- Data Summary Table -->
      <div class="card mt-4">
          <div class="card-header">
              <h5><i class="fas fa-table me-2"></i>Resumen de Gastos por Mes</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-striped" id="melazaExpenseDataTable">
                      <thead>
                          <tr>
                              <th>Mes</th>
                              <th>Gasto Mensual</th>
                              <th>Acumulado</th>
                              <th>% del Total</th>
                          </tr>
                      </thead>
                      <tbody id="melazaExpenseDataTableBody">
                          <!-- Data will be populated by JavaScript -->
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH Melaza -->
<script>
$(document).ready(function() {
    $('#melazaTable').DataTable({
        // Set initial page length
        pageLength: 25,
        
        // Configure length menu options
        lengthMenu: [
            [25, 50, 100, -1],
            [25, 50, 100, "Todos"]
        ],
        
        // Order by fecha (date) column descending
        order: [[1, 'desc']],
        
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
                targets: [0], // Actions column
                orderable: false,
                searchable: false
            },
            {
                targets: [6, 7, 8], // Racion, Costo, Valor Total columns
                render: function(data, type, row) {
                    if (type === 'display') {
                        if (data === 'N/A') return data; // Pass through 'N/A'
                        const number = parseFloat(data);
                        if (!isNaN(number)) {
                            return number.toLocaleString('es-ES', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        } else {
                            return data; // Return original if parsing failed but wasn't N/A
                        }
                    }
                    return data;
                }
            },
            {
                targets: [1], // Fecha column
                type: 'date-eu', // Help DataTables sort European date format
                render: function(data, type, row) {
                    if (type === 'display') {
                        if (data === 'N/A') return data; // Pass through 'N/A'
                        // Date is already formatted DD/MM/YYYY in PHP
                        return data; 
                    }
                    // For sorting/filtering, return the original YYYY-MM-DD if possible, or null
                    if (type === 'sort' || type === 'filter') {
                         // We need the original YYYY-MM-DD date here for correct sorting.
                         // Let's assume the raw data is the 2nd element in the row array `row[1]`
                         // Note: This depends on DataTables internal structure and might need adjustment
                         // A better approach is to fetch YYYY-MM-DD in PHP and pass it via a hidden column or data attribute
                         // For now, let's try getting it from the raw row data for the corresponding display column
                         // If the display data `data` is 'N/A', sorting value should be null or minimal
                         if (data === 'N/A') return null; 
                         // Attempt to convert DD/MM/YYYY back to YYYY-MM-DD for sorting
                         const parts = data.split('/');
                         if (parts.length === 3) {
                            return parts[2] + '-' + parts[1] + '-' + parts[0];
                         }
                         return null; // Fallback if conversion fails
                    }
                    return data;
                }
            },
            {
                targets: [9], // Status column
                orderable: true,
                searchable: true
            }
        ]
    });
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    var newMelazaModalEl = document.getElementById('newMelazaModal');
    var tagIdInput = document.getElementById('new_tagid');

    // --- Pre-fill Tag ID when New Melaza Modal opens --- 
    if (newMelazaModalEl && tagIdInput) {
        newMelazaModalEl.addEventListener('show.bs.modal', function (event) {
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
        newMelazaModalEl.addEventListener('hidden.bs.modal', function (event) {
            tagIdInput.value = ''; 
            // Optionally reset form validation state
            $('#newMelazaForm').removeClass('was-validated'); 
            document.getElementById('newMelazaForm').reset(); // Reset other fields too
        });
    }
    // --- End Pre-fill Logic ---
    
    // Handle new entry form submission
    $('#saveNewMelaza').click(function() {
        // Validate the form
        var form = document.getElementById('newMelazaForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            racion: $('#new_racion').val(),
            etapa: $('#new_etapa').val(),
            producto: $('#new_producto').val(),
            costo: $('#new_costo').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el registro de melaza ${formData.racion} kg para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_melaza.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        racion: formData.racion,
                        etapa: formData.etapa,
                        producto: formData.producto,
                        costo: formData.costo,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newMelazaModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de melaza ha sido guardado correctamente',
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
    $('.edit-melaza').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var etapa = $(this).data('etapa');
        var producto = $(this).data('producto');
        var racion = $(this).data('racion');
        var costo = $(this).data('costo');
        var fecha = $(this).data('fecha');
        
        // Edit Melaza Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editMelazaModal" tabindex="-1" aria-labelledby="editMelazaModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMelazaModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Melaza
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editMelazaForm">
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
                                <i class="fa-solid fa-syringe"></i>
                                <label for="edit_producto" class="form-label">Melaza</label>
                                <select class="form-select" id="edit_producto" name="producto" required>
                                    <option value="">Productos</option>
                                    <?php
                                    try {
                                        $sql_alimentos = "SELECT DISTINCT bc_melaza_nombre FROM bc_melaza ORDER BY bc_melaza_nombre ASC";
                                        $stmt_alimentos = $conn->prepare($sql_alimentos);
                                        $stmt_alimentos->execute();
                                        $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($alimentos as $alimento_row) {
                                            echo '<option value="' . htmlspecialchars($alimento_row['bc_melaza_nombre']) . '">' . htmlspecialchars($alimento_row['bc_melaza_nombre']) . '</option>';
                                        }
                                    } catch (PDOException $e) {
                                        error_log("Error fetching melazas: " . $e->getMessage());
                                        echo '<option value="">Error al cargar melazas</option>';
                                    }
                                    ?>
                                </select>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-syringe"></i>
                                        <label for="edit_etapa" class="form-label">Etapa</label>
                                        <select class="form-select" id="edit_etapa" name="etapa" required>
                                            <option value="">Etapas</option>
                                            <?php
                                            try {
                                                $sql_alimentos = "SELECT DISTINCT etapas_nombre FROM b_etapas ORDER BY etapas_nombre ASC";
                                                $stmt_alimentos = $conn->prepare($sql_alimentos);
                                                $stmt_alimentos->execute();
                                                $alimentos = $stmt_alimentos->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($alimentos as $alimento_row) {
                                                    echo '<option value="' . htmlspecialchars($alimento_row['etapas_nombre']) . '">' . htmlspecialchars($alimento_row['etapas_nombre']) . '</option>';
                                                }
                                            } catch (PDOException $e) {
                                                error_log("Error fetching etapas: " . $e->getMessage());
                                                echo '<option value="">Error al cargar etapas</option>';
                                            }
                                            ?>
                                        </select>
                                    </span>                            
                                </div>
                            </div>                            
                            <div class="mb-4">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-weight"></i>
                                        <label for="edit_racion" class="form-label">Racion (kg)</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_racion" value="${racion}" required>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-4">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                        <label for="edit_costo" class="form-label">Costo ($/kg)</label>
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
                        <button type="button" class="btn btn-success" id="saveEditMelaza">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editMelazaModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editMelazaModal'));
        editModal.show();
        
        // Set the selected values for dropdowns after modal is shown
        setTimeout(function() {
            $('#edit_producto').val(producto);
            $('#edit_etapa').val(etapa);
        }, 100);
        
        // Handle save button click
        $('#saveEditMelaza').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                racion: $('#edit_racion').val(),
                etapa: $('#edit_etapa').val(),
                producto: $('#edit_producto').val(),
                costo: $('#edit_costo').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el registro de melaza para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_melaza.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            racion: formData.racion,
                            etapa: formData.etapa,
                            producto: formData.producto,
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
    $('.delete-melaza').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).closest('tr').find('td:eq(3)').text().trim(); // Get Tag ID from the 4th column
        
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
                    url: 'process_melaza.php',
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

<!-- Melaza Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Gasto Total Mensual en Melaza</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyExpenseMelazaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Expense Line Chart -->
<script>
$(document).ready(function() {
    let monthlyExpenseMelazaChart = null;

    // Fetch monthly expense data and create the chart
    $.ajax({
        url: 'get_melaza_data.php?type=monthly_expense', // Updated endpoint with type parameter
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error fetching monthly expense melaza:', data.error);
                return;
            }
            createMonthlyExpenseMelazaChart(data);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly expense melaza data:', error);
        }
    });

    function createMonthlyExpenseMelazaChart(data) {
        var ctx = document.getElementById('monthlyExpenseMelazaChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            // Display month and year (YYYY-MM)
            return item.month;
        });

        var expenses = data.map(function(item) {
            return parseFloat(item.total_expense) || 0;
        });

        monthlyExpenseMelazaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gasto Total Mensual Melaza ($)',
                    data: expenses,
                    backgroundColor: 'rgba(0, 123, 255, 0.2)', // Primary blue
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(0, 123, 255, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Gasto Total Melaza ($)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '$ ' + value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
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
                                return 'Gasto Total: $ ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Gasto Total Mensual en Melaza',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Gasto Acumulado Mensual en Melaza
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="cumulativeExpenseMelazaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Cumulative Monthly Expense Line Chart -->
<script>
$(document).ready(function() {
    let cumulativeExpenseMelazaChart = null;

    // Fetch the SAME monthly expense data used for the total monthly chart
    $.ajax({
        url: 'get_melaza_data.php?type=monthly_expense', // Using the updated endpoint with type parameter
        type: 'GET',
        dataType: 'json',
        success: function(monthlyData) {
            if (monthlyData.error) {
                console.error('Server error fetching monthly expense melaza for cumulative chart:', monthlyData.error);
                return;
            }
            if (!Array.isArray(monthlyData) || monthlyData.length === 0) {
                 console.warn('No monthly data melaza received for cumulative chart.');
                 // Optionally display a message in the chart area
                 $('#cumulativeExpenseMelazaChart').parent().html('<p class="text-center">No hay datos disponibles para mostrar el gasto acumulado.</p>');
                 return;
            }

            // Calculate cumulative data
            let cumulativeTotal = 0;
            const cumulativeData = monthlyData.map(item => {
                cumulativeTotal += parseFloat(item.total_expense) || 0;
                return {
                    month: item.month,
                    cumulative_expense: cumulativeTotal
                };
            });

            createCumulativeExpenseMelazaChart(cumulativeData);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly expense melaza data for cumulative chart:', error);
             $('#cumulativeExpenseMelazaChart').parent().html('<p class="text-center text-danger">Error al cargar datos para el gráfico acumulado.</p>');
        }
    });

    function createCumulativeExpenseMelazaChart(data) {
        var ctx = document.getElementById('cumulativeExpenseMelazaChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            return item.month; // Month label (YYYY-MM)
        });

        var cumulativeExpenses = data.map(function(item) {
            return parseFloat(item.cumulative_expense) || 0;
        });

        cumulativeExpenseMelazaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gasto Acumulado Mensual Melaza ($)',
                    data: cumulativeExpenses,
                    backgroundColor: 'rgba(23, 162, 184, 0.2)', // Info blue color
                    borderColor: 'rgba(23, 162, 184, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(23, 162, 184, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.1, // Slightly less tension for cumulative might look better
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Gasto Acumulado Melaza ($)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                return '$ ' + value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
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
                                return 'Acumulado hasta ' + context.label + ': $ ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            },
                            title: function(tooltipItems) {
                                // Display just the month in the title
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Gasto Acumulado Mensual en Melaza',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-warning text-dark"> <!-- Changed color for variety -->
            <h5 class="mb-0"><i class="fas fa-weight-hanging me-2"></i>Peso Total Mensual Registrado Melaza</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyWeightMelazaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Total Weight Line Chart -->
<script>
$(document).ready(function() {
    let monthlyWeightMelazaChart = null;

    // Fetch monthly weight data
    $.ajax({
        url: 'get_melaza_data.php?type=monthly_weight', // Updated endpoint with type parameter
        type: 'GET',
        dataType: 'json',
        success: function(weightData) {
            if (weightData.error) {
                console.error('Server error fetching monthly weight melaza:', weightData.error);
                $('#monthlyWeightMelazaChart').parent().html('<p class="text-center text-danger">Error al cargar datos de peso.</p>');
                return;
            }
            if (!Array.isArray(weightData) || weightData.length === 0) {
                 console.warn('No weight data melaza received.');
                 $('#monthlyWeightMelazaChart').parent().html('<p class="text-center">No hay datos de peso disponibles para mostrar.</p>');
                 return;
            }

            createMonthlyWeightMelazaChart(weightData);
        },
        error: function(xhr, status, error) {
            console.error('Error fetching monthly weight melaza data:', error);
            $('#monthlyWeightMelazaChart').parent().html('<p class="text-center text-danger">Error al cargar datos para el gráfico de peso.</p>');
        }
    });

    function createMonthlyWeightMelazaChart(data) {
        var ctx = document.getElementById('monthlyWeightMelazaChart').getContext('2d');

        // Format the data for the chart
        var labels = data.map(function(item) {
            return item.month; // Month label (YYYY-MM)
        });

        var weights = data.map(function(item) {
            return parseFloat(item.total_weight) || 0;
        });

        monthlyWeightMelazaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Peso Total Mensual (kg)',
                    data: weights,
                    backgroundColor: 'rgba(255, 193, 7, 0.2)', // Warning yellow
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(255, 193, 7, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Peso Total (kg)',
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
                                return 'Peso Total: ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }) + ' kg';
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Peso Total Mensual Registrado',
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header text-white" style="background-color: #6f42c1;"> <!-- Custom Purple -->
            <h5 class="mb-0"><i class="fas fa-exchange-alt me-2"></i>Indice de Conversión Alimentaria (Kg Alimento / Kg Peso Animal)</h5>
        </div>
        <div class="card-body">
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="monthlyConversionMelazaChart"></canvas>
                 <div id="conversionMelazaChartMessage" class="text-center mt-3"></div> <!-- Message area -->
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Monthly Average Conversion Rate -->
<script>
$(document).ready(function() {
    let monthlyConversionMelazaChart = null;
    // URL for Numerator: Monthly Total Feed Weight (Projected)
    const feedWeightUrl = 'get_melaza_data.php?type=monthly_feed_weight'; 
    // URL for Denominator Calculation: Monthly Total Animal Weight
    const animalWeightUrl = 'get_melaza_data.php?type=animal_weight'; 

    // Use Promise.all to fetch both datasets concurrently
    Promise.all([
        $.getJSON(feedWeightUrl), // Fetch total feed weight (Numerator)
        $.getJSON(animalWeightUrl) // Fetch total animal weight (for Denominator)
    ])
    .then(function([feedWeightData, animalWeightData]) {
        // --- Basic Error Handling --- 
        let hasError = false;
        if (!Array.isArray(feedWeightData) || feedWeightData.error) {
            console.error('Error or invalid format fetching feed weight data:', feedWeightData);
            $('#conversionMelazaChartMessage').html('<p class="text-danger">Error al cargar datos de peso de alimento.</p>');
            hasError = true;
        }
        if (!Array.isArray(animalWeightData) || animalWeightData.error) {
            console.error('Error or invalid format fetching animal weight data:', animalWeightData);
            $('#conversionMelazaChartMessage').append('<p class="text-danger">Error al cargar datos de peso animal.</p>');
             hasError = true;
        }
        if (hasError) return; // Stop if errors occurred

        if (feedWeightData.length === 0 || animalWeightData.length === 0) {
             console.warn('No data available for feed weight or animal weight to calculate FCR.');
             $('#conversionMelazaChartMessage').html('<p class="text-center">No hay suficientes datos para calcular la conversión (Kg Alimento / Kg Ganancia).</p>');
             return;
        }

        // --- Data Processing --- 
        const feedByMonth = {};
        feedWeightData.forEach(item => {
            feedByMonth[item.month] = parseFloat(item.total_feed_kg) || 0;
        });

        const weightByMonth = {};
        animalWeightData.forEach(item => {
            weightByMonth[item.month] = parseFloat(item.total_weight) || 0;
        });

        // Get all unique months present in *both* datasets and sort them
        const allMonths = [...new Set([...Object.keys(feedByMonth), ...Object.keys(weightByMonth)])].sort(); 

        const conversionData = [];

        for (let i = 0; i < allMonths.length; i++) {
            const currentMonth = allMonths[i];
            const currentFeedKg = feedByMonth[currentMonth] || 0;
            const currentWeightKg = weightByMonth[currentMonth] || 0;

            // Calculate Weight Gain (Denominator)
            let weightGain = 0;
             if (i > 0) {
                 const previousMonth = allMonths[i-1];
                 const previousWeightKg = weightByMonth[previousMonth] || 0;
                 // Ensure previous month data actually exists for calculation
                 if (weightByMonth.hasOwnProperty(previousMonth)) {
                    weightGain = currentWeightKg - previousWeightKg;
                 }
             } else {
                 // Cannot calculate gain for the very first month
                 continue; 
             }

            // Calculate Feed Conversion Ratio (FCR) (Kg Feed / Kg Gain)
            // Avoid division by zero or division when weight gain is zero or negative.
            const fcr = (weightGain > 0) ? (currentFeedKg / weightGain) : 0;

            // Only add data points where we have feed data for the current month 
            // AND positive weight gain calculated from the previous month.
            if (feedByMonth.hasOwnProperty(currentMonth) && weightGain > 0) {
                 conversionData.push({
                     month: currentMonth,
                     fcr: fcr // Indice (Kg Alimento / Kg Ganancia)
                 });
            }
        }
         
         if (conversionData.length === 0) {
             $('#conversionMelazaChartMessage').html('<p class="text-center">No se pudo calcular la conversión (quizás falta información de alimento o ganancia de peso positiva).</p>');
             return;
         }

        createMonthlyConversionChart(conversionData);
    })
    .catch(function(error) {
        console.error('Error fetching data for FCR chart:', error);
        $('#conversionMelazaChartMessage').html('<p class="text-center text-danger">Ocurrió un error al obtener los datos para el gráfico de conversión.</p>');
    });

    function createMonthlyConversionChart(data) {
        var ctx = document.getElementById('monthlyConversionMelazaChart').getContext('2d');

        // If chart exists, destroy it before creating a new one
        if (monthlyConversionMelazaChart) {
            monthlyConversionMelazaChart.destroy();
        }

        var labels = data.map(item => item.month);
        var rates = data.map(item => parseFloat(item.fcr)); 

        monthlyConversionMelazaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Indice Conversion Alimentaria Melaza (ICA)', // FCR Label
                    data: rates,
                    backgroundColor: 'rgba(111, 66, 193, 0.2)', // Purple
                    borderColor: 'rgba(111, 66, 193, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(111, 66, 193, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                         beginAtZero: true, // FCR is typically >= 0
                        title: {
                            display: true,
                            text: 'Indice Melaza (Kg Alimento / Kg Peso Animal)', // FCR Axis Label
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            callback: function(value) {
                                // Format as a ratio 
                                return value.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
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
                                // FCR Tooltip
                                return 'Indice: ' + context.parsed.y.toLocaleString('es-ES', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }); // Unitless ratio (kg/kg)
                            },
                            title: function(tooltipItems) {
                                return 'Mes: ' + tooltipItems[0].label;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: 'Indice Conversion Alimentaria Melaza (Kg Alimento / Kg Peso Animal)', // ICA Title
                        font: {
                            size: 16
                        }
                    }
                }
            }
        });
    }
});
</script>
<!-- Melaza Chart JavaScript -->
<script>
let melazaExpenseChart;
let melazaChartData = [];

// Initialize the melaza chart when page loads
$(document).ready(function() {
    // Load chart data after the melaza table is initialized
    setTimeout(function() {
        loadMelazaChartData();
    }, 1000);
    
    // Event listeners
    $('#melazaPeriodSelect').change(function() {
        updateMelazaChart();
    });
    
    $('#melazaShowBars, #melazaShowLine').change(function() {
        updateMelazaChartVisibility();
    });
});

function loadMelazaChartData() {
    $('#melazaLoadingSpinner').show();
    $('#melazaExpenseChart').hide();
    
    $.ajax({
        url: 'get_melaza_expense_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                showMelazaError('Error al cargar datos: ' + data.error);
                return;
            }
            
            melazaChartData = data;
            updateMelazaStatistics();
            updateMelazaChart();
            updateMelazaDataTable();
            
            $('#melazaLoadingSpinner').hide();
            $('#melazaExpenseChart').show();
        },
        error: function(xhr, status, error) {
            showMelazaError('Error de conexión: ' + error);
            $('#melazaLoadingSpinner').hide();
        }
    });
}

function updateMelazaStatistics() {
    if (melazaChartData.length === 0) return;
    
    const totalExpense = melazaChartData[melazaChartData.length - 1].cumulative_expense;
    const monthlyAverage = totalExpense / melazaChartData.length;
    const highestMonth = Math.max(...melazaChartData.map(d => d.total_expense));
    
    // Get current month expense
    const currentDate = new Date();
    const currentMonthKey = currentDate.getFullYear() + '-' + String(currentDate.getMonth() + 1).padStart(2, '0');
    const currentMonthData = melazaChartData.find(d => d.month === currentMonthKey);
    const currentMonthExpense = currentMonthData ? currentMonthData.total_expense : 0;
    
    $('#melazaTotalExpense').text('$' + totalExpense.toLocaleString('es-ES', {minimumFractionDigits: 2}));
    $('#melazaMonthlyAverage').text('$' + monthlyAverage.toLocaleString('es-ES', {minimumFractionDigits: 2}));
    $('#melazaHighestMonth').text('$' + highestMonth.toLocaleString('es-ES', {minimumFractionDigits: 2}));
    $('#melazaCurrentMonth').text('$' + currentMonthExpense.toLocaleString('es-ES', {minimumFractionDigits: 2}));
}

function updateMelazaChart() {
    const period = $('#melazaPeriodSelect').val();
    let filteredData = melazaChartData;
    
    if (period !== 'all') {
        const monthsToShow = parseInt(period);
        filteredData = melazaChartData.slice(-monthsToShow);
    }
    
    // Prepare data for Chart.js
    const labels = filteredData.map(d => {
        const date = new Date(d.month + '-01');
        return date.toLocaleDateString('es-ES', { year: 'numeric', month: 'short' });
    });
    
    const monthlyExpenses = filteredData.map(d => d.total_expense);
    const cumulativeExpenses = filteredData.map(d => d.cumulative_expense);
    
    // Destroy existing chart if it exists
    if (melazaExpenseChart) {
        melazaExpenseChart.destroy();
    }
    
    const ctx = document.getElementById('melazaExpenseChart').getContext('2d');
    melazaExpenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Gasto Mensual',
                data: monthlyExpenses,
                backgroundColor: 'rgba(255, 193, 7, 0.8)',
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Acumulado',
                data: cumulativeExpenses,
                type: 'line',
                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                yAxisID: 'y1',
                pointRadius: 6,
                pointHoverRadius: 8
            }]
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
                        text: 'Mes',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Gasto Mensual ($)',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-ES', {minimumFractionDigits: 0});
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Acumulado ($)',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-ES', {minimumFractionDigits: 0});
                        }
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Gastos de Melaza - Mensual vs Acumulado',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.dataset.label || '';
                            const value = '$' + context.parsed.y.toLocaleString('es-ES', {minimumFractionDigits: 2});
                            return label + ': ' + value;
                        }
                    }
                }
            }
        }
    });
    
    updateMelazaChartVisibility();
}

function updateMelazaChartVisibility() {
    if (!melazaExpenseChart) return;
    
    const showBars = $('#melazaShowBars').is(':checked');
    const showLine = $('#melazaShowLine').is(':checked');
    
    melazaExpenseChart.data.datasets[0].hidden = !showBars;
    melazaExpenseChart.data.datasets[1].hidden = !showLine;
    
    melazaExpenseChart.update();
}

function updateMelazaDataTable() {
    const tbody = $('#melazaExpenseDataTableBody');
    tbody.empty();
    
    const totalExpense = melazaChartData.length > 0 ? melazaChartData[melazaChartData.length - 1].cumulative_expense : 0;
    
    melazaChartData.forEach(function(item) {
        const date = new Date(item.month + '-01');
        const monthName = date.toLocaleDateString('es-ES', { year: 'numeric', month: 'long' });
        const percentage = totalExpense > 0 ? (item.total_expense / totalExpense * 100).toFixed(1) : '0.0';
        
        const row = `
            <tr>
                <td>${monthName}</td>
                <td>$${item.total_expense.toLocaleString('es-ES', {minimumFractionDigits: 2})}</td>
                <td>$${item.cumulative_expense.toLocaleString('es-ES', {minimumFractionDigits: 2})}</td>
                <td>${percentage}%</td>
            </tr>
        `;
        tbody.append(row);
    });
}

function refreshMelazaChart() {
    loadMelazaChartData();
}

function exportMelazaChart() {
    if (!melazaExpenseChart) {
        showMelazaError('No hay gráfico para exportar');
        return;
    }
    
    // Create a link to download the chart as PNG
    const link = document.createElement('a');
    link.download = 'gastos_melaza_' + new Date().toISOString().split('T')[0] + '.png';
    link.href = melazaExpenseChart.toBase64Image();
    link.click();
}

function showMelazaError(message) {
    Swal.fire({
        title: 'Error',
        text: message,
        icon: 'error',
        confirmButtonColor: '#dc3545'
    });
}
</script>

</body>
</html>
