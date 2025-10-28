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
<title>Bufalino Register Ventas</title>
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
                        <span class="badge-active">🎯 Registrando Ventas</span>
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

    
  <!-- New Venta Entry Modal -->
  
  <div class="modal fade" id="newVentaModal" tabindex="-1" aria-labelledby="newVentaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newVentaModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Registrar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newVentaForm">
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
                                <input type="number" step="0.01" class="form-control" id="new_peso" name="peso" required>
                            </span>                            
                        </div>
                    </div>
                    <div class="mb-4">                        
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fa-solid fa-dollar-sign"></i>
                                <label for="new_precio" class="form-label">Precio</label>
                                <input type="number" step="0.01" class="form-control" id="new_precio" name="precio" required>
                            </span>                            
                        </div>
                    </div>                                                              
                </form>
            </div>
            <div class="modal-footer btn-group">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success" id="saveNewVenta">
                    <i class="fas fa-save me-1"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>
  
  <!-- PHP Data Queries for Statistics -->
  <?php
  try {
      // Query to get sold buffalos (estatus = Vendido) for statistics
      $soldVentaQuery = "SELECT *
                    FROM bufalino
                    WHERE estatus = 'Vendido'
                    ORDER BY fecha_venta DESC";                              
      $stmt = $conn->prepare($soldVentaQuery);  
      $stmt->execute();
      $soldVentaData = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      // Query to get available buffalos (estatus = Activo or Descarte) for statistics
      $availableVentaQuery = "SELECT *
                    FROM bufalino
                    WHERE estatus IN ('Activo', 'Descarte')
                    ORDER BY nombre ASC";                              
      $stmt = $conn->prepare($availableVentaQuery);  
      $stmt->execute();
      $availableVentaData = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      // Calculate additional statistics
      $totalSoldValue = 0;
      $totalSoldWeight = 0;
      foreach ($soldVentaData as $row) {
          if (!empty($row['precio_venta']) && !empty($row['peso_venta'])) {
              $totalSoldValue += floatval($row['precio_venta']);
              $totalSoldWeight += floatval($row['peso_venta']);
          }
      }
      
      $averageSoldPrice = count($soldVentaData) > 0 ? $totalSoldValue / count($soldVentaData) : 0;
      $averageSoldWeight = count($soldVentaData) > 0 ? $totalSoldWeight / count($soldVentaData) : 0;
      
  } catch (PDOException $e) {
      error_log("Error in statistics queries: " . $e->getMessage());
      $soldVentaData = [];
      $availableVentaData = [];
      $totalSoldValue = 0;
      $totalSoldWeight = 0;
      $averageSoldPrice = 0;
      $averageSoldWeight = 0;
  }
  ?>

  <!-- Statistics Cards -->
  <div class="container mb-4">
      <div class="row">
          <div class="col-md-2">
              <div class="card bg-success text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-dollar-sign me-2"></i>Bufalos Vendidos
                      </h5>
                      <h3 class="mb-0" id="soldCount"><?php echo count($soldVentaData); ?></h3>
                      <small>Total de ventas realizadas</small>
                  </div>
              </div>
          </div>
          <div class="col-md-2">
              <div class="card bg-primary text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-cow me-2"></i>Bufalos Disponibles
                      </h5>
                      <h3 class="mb-0" id="availableCount"><?php echo count($availableVentaData); ?></h3>
                      <small>Listos para venta</small>
                  </div>
              </div>
          </div>
          <div class="col-md-2">
              <div class="card bg-info text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-dollar-sign me-2"></i>Total Venta
                      </h5>
                      <h3 class="mb-0" id="totalValue">$<?php echo number_format($totalSoldValue, 0); ?></h3>
                      <small>Valor acumulado</small>
                  </div>
              </div>
          </div>
          <div class="col-md-2">
              <div class="card bg-warning text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-weight me-2"></i>Peso Promedio
                      </h5>
                      <h3 class="mb-0" id="avgWeight"><?php echo number_format($averageSoldWeight, 0); ?> kg</h3>
                      <small>Peso promedio vendido</small>
                  </div>
              </div>
          </div>
          <div class="col-md-4">
              <div class="card bg-secondary text-white shadow">
                  <div class="card-body text-center">
                      <h5 class="card-title">
                          <i class="fas fa-dollar-sign me-2"></i>Valor Bufalo Promedio
                      </h5>
                      <h3 class="mb-0" id="avgPrice">$<?php echo number_format($averageSoldPrice, 0); ?></h3>
                      <small>Precio promedio por animal</small>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- DataTable for Sold Buffalos (estatus = Vendido) -->
  
  <div class="container table-section mb-5" style="display: block;">
      <div class="card shadow">
          <div class="card-header bg-success text-white">
              <h5 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Buffalos Vendidos</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="soldVentaTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                            <th class="text-center">Imagen</th>
                            <th class="text-center">Acciones</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Fecha</th>                                        
                            <th class="text-center">Tag ID</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Peso</th>                      
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          // Use the data already queried for statistics
                          // If no data, display a message
                          if (empty($soldVentaData)) {
                              echo "<tr><td colspan='8' class='text-center text-muted'>No hay buffalos vendidos</td></tr>";
                          } else {
                              foreach ($soldVentaData as $row) {
                                  echo "<tr>";
                                  echo '<td class="text-center">';
                                  // Check if animal has an image
                                  if (!empty($row['image'])) {
                                      echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Imagen del animal" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                  } else {
                                      echo '<img src="images/robot-de-chat.png" alt="Imagen por defecto" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                  }
                                  echo '</td>';
                                  
                                  // Add action buttons (edit and delete)
                                  echo '<td class="text-center">
                                  <div class="btn-group" role="group">
                                      <button class="btn btn-warning btn-sm edit-venta" 
                                          data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                          data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '"
                                          data-fecha="' . htmlspecialchars($row['fecha_venta'] ?? '') . '"
                                          data-precio="' . htmlspecialchars($row['precio_venta'] ?? '') . '"
                                          data-peso="' . htmlspecialchars($row['peso_venta'] ?? '') . '">
                                          <i class="fas fa-edit"></i>
                                      </button>
                                      <button class="btn btn-danger btn-sm delete-venta" 
                                          data-id="' . htmlspecialchars($row['id'] ?? '') . '">
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </div>
                              </td>';

                                  echo "<td class='text-center'>" . htmlspecialchars($row['estatus'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['fecha_venta'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['precio_venta'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['peso_venta'] ?? '') . "</td>";                            
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

  <!-- DataTable for Available Buffalos (estatus = Activo or Descarte) -->
  
  <div class="container table-section mb-5" style="display: block;">
      <div class="card shadow">
          <div class="card-header bg-success text-white">
              <h5 class="mb-0"><i class="fas fa-cow me-2"></i>Buffalos Disponibles</h5>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table id="availableVentaTable" class="table table-striped table-bordered">
                      <thead>
                          <tr>
                            <th class="text-center">Imagen</th>
                            <th class="text-center">Acciones</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Fecha</th>                                        
                            <th class="text-center">Tag ID</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Peso</th>                      
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                          // Use the data already queried for statistics
                          // If no data, display a message
                          if (empty($availableVentaData)) {
                              echo "<tr><td colspan='8' class='text-center text-muted'>No hay buffalos disponibles</td></tr>";
                          } else {
                              foreach ($availableVentaData as $row) {
                                  echo "<tr>";
                                  echo '<td class="text-center">';
                                  // Check if animal has an image
                                  if (!empty($row['image'])) {
                                      echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Imagen del animal" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                  } else {
                                      echo '<img src="images/robot-de-chat.png" alt="Imagen por defecto" class="img-fluid" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">';
                                  }
                                  echo '</td>';
                                  
                                  // Add action buttons (sell button only for available buffalos)
                                  echo '<td class="text-center">
                                  <div class="btn-group" role="group">
                                      <button class="btn btn-success btn-sm sell-animal" 
                                          data-tagid="' . htmlspecialchars($row['tagid'] ?? '') . '">
                                          <i class="fas fa-dollar-sign"></i>
                                      </button>
                                  </div>
                              </td>';

                                  echo "<td class='text-center'>" . htmlspecialchars($row['estatus'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['nombre'] ?? 'N/A') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['fecha_venta'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['tagid'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['precio_venta'] ?? '') . "</td>";
                                  echo "<td class='text-center'>" . htmlspecialchars($row['peso_venta'] ?? '') . "</td>";                            
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

<!-- Spectacular Sales Performance Chart -->
<div class="container chart-container mb-4">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-gradient-success text-white d-flex align-items-center justify-content-between">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2"></i>
                Rendimiento de Ventas - Mensual y Acumulado
            </h5>
            <div class="chart-controls">
                <select class="form-select form-select-sm bg-white text-dark border-0" id="timeFilter">
                    <option value="12">Últimos 12 Meses</option>
                    <option value="24">Últimos 24 Meses</option>
                    <option value="36">Últimos 36 Meses</option>
                </select>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="chart-container">
                <canvas id="salesPerformanceChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Professional CSS Styling -->
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

/* Chart container styling */
.chart-container {
    position: relative;
    height: 70vh;
    width: 100%;
    background: white;
    border-radius: 12px;
    overflow: hidden;
}

.chart-container.loading::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    margin: -20px 0 0 -20px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #28a745;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 1000;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Card styling */
.card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
}

.card-header {
    border-bottom: none;
    padding: 1.5rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.card-body {
    padding: 2rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
}

/* Canvas styling */
canvas {
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

/* Chart controls styling */
.chart-controls .form-select {
    border-radius: 8px;
    font-weight: 500;
    min-width: 150px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.chart-controls .form-select:focus {
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    border-color: #28a745;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .chart-container {
        height: 60vh;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-header {
        padding: 1rem;
    }
    
    .chart-controls .form-select {
        min-width: 120px;
        font-size: 0.875rem;
    }
}

/* Enhanced shadows and effects */
.shadow-lg {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
}

/* Typography enhancements */
h5 {
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* Loading state */
.chart-container.loading canvas {
    opacity: 0.3;
    transition: opacity 0.3s ease;
}
</style>

<!-- Additional CSS for better table styling -->
<style>
/* Enhanced table styling */
.table-section .card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    margin-bottom: 2rem;
}

.table-section .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.table-section .card-header {
    border-bottom: none;
    padding: 1.25rem;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.table-section .card-header h5 {
    margin: 0;
    font-size: 1.1rem;
}

.table-section .card-body {
    padding: 1.5rem;
}

/* Statistics cards styling */
#soldCount, #availableCount, #totalValue, #avgWeight, #avgPrice {
    font-weight: 700;
    font-size: 1.25rem;
}

.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.bg-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

.bg-info {
    background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important;
}

.bg-warning {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
}

.bg-secondary {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%) !important;
}

/* Responsive adjustments for 5-column layout */
@media (max-width: 1200px) {
    .col-md-2, .col-md-4 {
        margin-bottom: 1rem;
    }
}

@media (max-width: 768px) {
    .table-section .card-header {
        padding: 1rem;
    }
    
    .table-section .card-body {
        padding: 1rem;
    }
    
    #soldCount, #availableCount, #totalValue, #avgWeight, #avgPrice {
        font-size: 1rem;
    }
    
    /* Stack cards vertically on mobile */
    .col-md-2, .col-md-4 {
        margin-bottom: 1rem;
    }
}

/* Table enhancements */
.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transition: background-color 0.2s ease;
}

/* Button styling */
.btn-group .btn {
    border-radius: 6px;
    margin: 0 2px;
    transition: all 0.2s ease;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-section .card-header {
        padding: 1rem;
    }
    
    .table-section .card-body {
        padding: 1rem;
    }
    
    #soldCount, #availableCount, #totalValue, #avgWeight {
        font-size: 2rem;
    }
    
    /* Stack cards vertically on mobile */
    .col-md-3 {
        margin-bottom: 1rem;
    }
}
</style>

<!-- JavaScript for Statistics and Enhanced Functionality -->
<script>
$(document).ready(function() {
    // Statistics are now generated by PHP, so no need for JavaScript counting
    
    // Add row highlighting for better UX
    $('.table tbody').on('mouseenter', 'tr', function() {
        $(this).addClass('table-hover');
    }).on('mouseleave', 'tr', function() {
        $(this).removeClass('table-hover');
    });
    
    // Refresh statistics when page is reloaded (after operations)
    // This will happen automatically since the page reloads after operations
});
</script>

<!-- JavaScript for Sales Performance Chart -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize the chart with sample data first
    initializeSalesChart();
    
    // Add event listener for time filter
    document.getElementById('timeFilter').addEventListener('change', function() {
        updateSalesChart(this.value);
    });
});

function initializeSalesChart() {
    const ctx = document.getElementById('salesPerformanceChart').getContext('2d');
    
    // Create professional gradients
    const salesGradient = ctx.createLinearGradient(0, 0, 0, 400);
    salesGradient.addColorStop(0, 'rgba(40, 167, 69, 0.8)');
    salesGradient.addColorStop(0.5, 'rgba(40, 167, 69, 0.4)');
    salesGradient.addColorStop(1, 'rgba(40, 167, 69, 0.1)');

    const cumulativeGradient = ctx.createLinearGradient(0, 0, 0, 400);
    cumulativeGradient.addColorStop(0, 'rgba(32, 201, 151, 0.8)');
    cumulativeGradient.addColorStop(0.5, 'rgba(32, 201, 151, 0.4)');
    cumulativeGradient.addColorStop(1, 'rgba(32, 201, 151, 0.1)');

    const lineGradient = ctx.createLinearGradient(0, 0, 0, 400);
    lineGradient.addColorStop(0, 'rgba(32, 201, 151, 1)');
    lineGradient.addColorStop(1, 'rgba(40, 167, 69, 1)');

    // Sample data for initial chart
    const sampleData = generateSampleSalesData(12);
    
    window.salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: sampleData.labels,
            datasets: [
                {
                    label: '🐄 Ventas Mensuales',
                    data: sampleData.sales,
                    backgroundColor: salesGradient,
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    yAxisID: 'y'
                },
                {
                    label: '💵 Valor Acumulado ($)',
                    data: sampleData.cumulative,
                    type: 'line',
                    backgroundColor: cumulativeGradient,
                    borderColor: lineGradient,
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: 'rgba(32, 201, 151, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: 8,
                    pointHoverRadius: 12,
                    pointHoverBackgroundColor: 'rgba(32, 201, 151, 1)',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 4,
                    pointStyle: 'circle',
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            animation: {
                duration: 2000,
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
                            ctx.shadowColor = 'rgba(40, 167, 69, 0.5)';
                            ctx.shadowBlur = 20;
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
            plugins: {
                legend: {
                    position: 'top',
                    align: 'center',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20,
                        font: {
                            size: 14,
                            weight: '600',
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        color: '#495057',
                        generateLabels: function(chart) {
                            const data = chart.data;
                            if (data.labels.length && data.datasets.length) {
                                return data.datasets.map((dataset, i) => ({
                                    text: dataset.label,
                                    fillStyle: dataset.backgroundColor,
                                    strokeStyle: dataset.borderColor,
                                    lineWidth: 0,
                                    hidden: false,
                                    index: i
                                }));
                            }
                            return [];
                        }
                    }
                },
                title: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    titleFont: {
                        size: 16,
                        weight: 'bold',
                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                    },
                    bodyFont: {
                        size: 14,
                        family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                    },
                    padding: 16,
                    cornerRadius: 12,
                    displayColors: false,
                    borderColor: 'rgba(40, 167, 69, 0.8)',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                if (context.datasetIndex === 0) {
                                    label = label.replace('🐄 ', '');
                                    label += ': ' + context.parsed.y + ' animales';
                                } else {
                                    label = label.replace('💵 ', '');
                                    label += ': $' + context.parsed.y.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    });
                                }
                            }
                            return label;
                        },
                        title: function(context) {
                            return '📅 ' + context[0].label;
                        }
                    }
                },
                datalabels: {
                    display: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Meses (Año-Mes)',
                        color: '#495057',
                        font: {
                            size: 14,
                            weight: '600',
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: {
                            top: 10
                        }
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 12,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: 8
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
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Cantidad de Animales Vendidos',
                        color: '#495057',
                        font: {
                            size: 14,
                            weight: '600',
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: {
                            bottom: 10
                        }
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 12,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: 8,
                        callback: function(value, index, values) {
                            if (Math.floor(value) === value) {
                                return value;
                            }
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
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Valor Acumulado ($)',
                        color: '#495057',
                        font: {
                            size: 14,
                            weight: '600',
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: {
                            bottom: 10
                        }
                    },
                    ticks: {
                        color: '#6c757d',
                        font: {
                            size: 12,
                            family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                        },
                        padding: 8,
                        callback: function(value, index, values) {
                            return '$' + value.toLocaleString('es-ES', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            });
                        }
                    },
                    grid: {
                        drawOnChartArea: false
                    },
                    border: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        width: 1
                    }
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

function generateSampleSalesData(months) {
    const labels = [];
    const sales = [];
    const cumulative = [];
    
    const currentDate = new Date();
    let cumulativeValue = 0;
    
    for (let i = months - 1; i >= 0; i--) {
        const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
        const monthLabel = date.toLocaleDateString('es-ES', { 
            year: 'numeric', 
            month: 'short' 
        });
        
        labels.push(monthLabel);
        
        // Generate realistic sales data
        const monthlySales = Math.floor(Math.random() * 15) + 5; // 5-20 animals per month
        const averagePrice = 800 + Math.random() * 400; // $800-$1200 per animal
        const monthlyValue = monthlySales * averagePrice;
        
        sales.push(monthlySales);
        cumulativeValue += monthlyValue;
        cumulative.push(cumulativeValue);
    }
    
    return { labels, sales, cumulative };
}

function updateSalesChart(months) {
    if (window.salesChart) {
        const newData = generateSampleSalesData(parseInt(months));
        
        window.salesChart.data.labels = newData.labels;
        window.salesChart.data.datasets[0].data = newData.sales;
        window.salesChart.data.datasets[1].data = newData.cumulative;
        
        window.salesChart.update('active');
    }
}
</script>

<!-- Initialize DataTable for VH venta -->
<script>
$(document).ready(function() {
    $('#soldVentaTable').DataTable({
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
                targets: [6, 7], // Precio, Peso columns
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
                targets: [1], // Fecha column
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
                targets: [0], // Actions column
                orderable: false,
                searchable: false
            }
        ]
    });

    $('#availableVentaTable').DataTable({
        // Set initial page length
        pageLength: 10,
        
        // Configure length menu options
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todos"]
        ],
        
        // Order by nombre (name) column ascending for available buffalos
        order: [[3, 'asc']],
        
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
                targets: [6, 7], // Precio, Peso columns
                render: function(data, type, row) {
                    if (type === 'display') {
                        if (data && data !== '') {
                            return parseFloat(data).toLocaleString('es-ES', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                        return 'N/A';
                    }
                    return data;
                }
            },
            {
                targets: [4], // Fecha column
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Parse the date parts manually to avoid timezone issues
                        if (data && data !== '') {
                            // Split the date string (format: YYYY-MM-DD)
                            var parts = data.split('-');
                            // Create date string in local format (DD/MM/YYYY)
                            if (parts.length === 3) {
                                return parts[2] + '/' + parts[1] + '/' + parts[0];
                            }
                        }
                        return 'N/A'; // Return N/A if no date
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
});
</script>

<!-- JavaScript for Edit and Delete buttons -->
<script>
$(document).ready(function() {
    // Handle new entry form submission
    $('#saveNewVenta').click(function() {
        // Validate the form
        var form = document.getElementById('newVentaForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            precio: $('#new_precio').val(),
            peso: $('#new_peso').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar la venta para el animal con Tag ID ${formData.tagid}? Esto marcará el animal como "Vendido".`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, registrar venta',
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
                
                // Send AJAX request to update bufalino record with sale information
                $.ajax({
                    url: 'process_venta.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        precio: formData.precio,
                        peso: formData.peso,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newVentaModal'));
                        if(modal) {
                            modal.hide();
                        }
                        
                        if(response.success) {
                            // Show success message
                            Swal.fire({
                                title: '¡Registro exitoso!',
                                text: 'El registro de venta ha sido guardado correctamente',
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // Reload the page to show updated data
                                location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'Ha ocurrido un error al registrar la venta',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
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

    // Add handler for sell-animal button
    $('.sell-animal').click(function() {
        var tagid = $(this).data('tagid');
        
        // Populate the tagid field in the newVentaModal
        $('#new_tagid').val(tagid);
        
        // Show the modal
        var newVentaModal = new bootstrap.Modal(document.getElementById('newVentaModal'));
        newVentaModal.show();
    });

    // Handle edit button click
    $('.edit-venta').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var precio = $(this).data('precio');
        var peso = $(this).data('peso');
        var fecha = $(this).data('fecha');
        
        // Edit Venta Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editVentaModal" tabindex="-1" aria-labelledby="editVentaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editVentaModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Venta
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editVentaForm">
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
                                        <i class="fas fa-dollar-sign"></i>
                                        <label for="edit_precio" class="form-label">Monto ($)</label>                                    
                                        <input type="number" step="0.01" class="form-control" id="edit_precio" value="${precio}" required>
                                    </span>                                    
                                </div>
                            </div>
                            <div class="mb-2">                            
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-weight"></i>
                                        <label for="edit_peso" class="form-label">Peso (kg)</label>                                    
                                        <input type="number" step="0.01" class="form-control" id="edit_peso" value="${peso}" required>
                                    </span>                                    
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditVenta">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editVentaModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editVentaModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditVenta').click(function() {
            var formData = {
                tagid: $('#edit_tagid').val(),
                precio: $('#edit_precio').val(),
                peso: $('#edit_peso').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar la información de venta para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_venta.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            tagid: formData.tagid,
                            precio: formData.precio,
                            peso: formData.peso,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            if(response.success) {
                                // Show success message
                                Swal.fire({
                                    title: '¡Actualización exitosa!',
                                    text: `La información de venta para el animal con Tag ID ${formData.tagid} ha sido actualizada correctamente`,
                                    icon: 'success',
                                    confirmButtonColor: '#28a745'
                                }).then(() => {
                                    // Reload the page to show updated data
                                    location.reload();
                                });
                            } else {
                                // Show error message
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message || 'Ha ocurrido un error al actualizar la información',
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
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
    $('.delete-venta').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar registro de venta?',
            text: `¿Está seguro de que desea eliminar el registro de venta para el animal con Tag ID ${tagid}? El estatus del animal volverá a "Activo".`,
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
                    url: 'process_venta.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        if(response.success) {
                            // Show success message
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: `El registro de venta para el animal con Tag ID ${tagid} ha sido eliminado correctamente`,
                                icon: 'success',
                                confirmButtonColor: '#28a745'
                            }).then(() => {
                                // Reload the page to show updated data
                                location.reload();
                            });
                        } else {
                            // Show error message
                            Swal.fire({
                                title: 'Error',
                                text: response.message || 'Ha ocurrido un error al eliminar el registro',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            });
                        }
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