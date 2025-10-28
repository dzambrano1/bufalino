<?php
require_once '../bufalino/pdo_conexion.php';

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
<title>bufalino Register Herd</title>
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

<!-- Custom Modal Styles -->
<style>
    /* Modal Styling */
    .modal-content {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        overflow: hidden;
    }
    
    .modal-header {
        background: linear-gradient(to right, #28a745, #20c997);
        color: white;
        border-bottom: none;
        padding: 1.5rem;
    }
    
    .modal-header .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
    }
    
    .modal-header .btn-close {
        color: white;
        opacity: 0.8;
        transition: opacity 0.3s;
        filter: brightness(0) invert(1);
    }
    
    .modal-header .btn-close:hover {
        opacity: 1;
    }
    
    .modal-body {
        padding: 1.75rem;
        background-color: #f8f9fa;
    }
    
    .modal-footer {
        border-top: none;
        padding: 1rem 1.75rem 1.5rem;
        background-color: #f8f9fa;
    }
    
    /* Form Elements */
    .modal .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    
    .modal .form-control {
        border-radius: 0.375rem;
        border: 1px solid #ced4da;
        padding: 0.75rem 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .modal .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    }
    
    .modal .form-control:hover:not(:focus) {
        border-color: #adb5bd;
    }
    
    /* Buttons */
    .modal .btn {
        padding: 0.5rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.3s;
    }
    
    .modal .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .modal .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
    }
    
    .modal .btn-success:active {
        transform: translateY(0);
        box-shadow: none;
    }
    
    .modal .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .modal .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
    }
    
    .modal .btn-secondary:active {
        transform: translateY(0);
        box-shadow: none;
    }
    
    /* Animation */
    .modal.fade .modal-dialog {
        transform: scale(0.9);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }
    
    .modal.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }
    
    /* Modal Backdrop */
    .modal-backdrop.show {
        opacity: 0.7;
        backdrop-filter: blur(3px);
    }
    
    /* Input Group */
    .input-group {
        margin-bottom: 1rem;
    }
    
    /* Input Group Text */
    .input-group-text {
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #28a745;
    }
    
    /* Focused Form Group Effect */
    .modal .form-control:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25);
    }
    
    /* Modal Highlight Animation on Open */
    @keyframes modalHighlight {
        0% {
            box-shadow: 0 0 0 rgba(40, 167, 69, 0);
        }
        50% {
            box-shadow: 0 0 30px rgba(40, 167, 69, 0.3);
        }
        100% {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
    }
    
    .modal.show .modal-content {
        animation: modalHighlight 0.5s ease forwards;
    }
    
    /* Hover effect for input groups */
    .modal .input-group:hover .input-group-text {
        background-color: #e9ecef;
        transition: background-color 0.3s;
    }
    
    /* Readonly fields styling */
    .modal input[readonly] {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
    
    /* Form validation styles */
    .modal .form-control:invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }
    
    /* Modal title icon */
    .modal-title i {
        margin-right: 8px;
    }

    /* Back to Top Button Styling */
    .back-to-top {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    }

    .back-to-top.visible {
        opacity: 1;
        visibility: visible;
    }

    .back-to-top:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .back-to-top:active {
        transform: translateY(0);
    }

    @media (max-width: 768px) {
        .back-to-top {
            bottom: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }
    }

    .button-label {
        display: block;
        text-align: center;
        font-size: 0.7rem;
        width: 100%;
    }

    /* Optional: Add a subtle highlight effect when scrolled to a section */
    @keyframes highlightFade {
        0% { background-color: rgba(40, 167, 69, 0.2); }
        100% { background-color: transparent; }
    }

    .highlight-section {
        animation: highlightFade 2s ease-out;
    }
</style>

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
<!-- Icon Navigation Buttons -->
<div class="container" id="nav-buttons">
    <div class="container nav-icons-container" id="nav-buttons">
        <div class="icon-button-container">
            <button onclick="window.location.href='#'" class="icon-button">
                <img src="./images/default_image.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">INICIO</span>
        </div>
        

        <div class="icon-button-container">
            <button onclick="window.location.href='./inventario_bufalino.php'" class="icon-button">
                <img src="./images/bufalo-icon.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">INVENTARIO</span>
        </div>        


        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_registros.php'" class="icon-button">
                <img src="./images/registros.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">REGISTROS</span>
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
</div>

<!-- Scroll Icons Container -->
<div class="container scroll-icons-container">
    <button class="btn btn-outline-secondary mb-3" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#compra" 
        data-tooltip="Compras"
        aria-expanded="false"
        aria-controls="compra">
        <img src="./images/compra.png" alt="Compras" class="nav-icon">
        <span class="button-label">COMPRAS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#venta" 
        data-tooltip="Ventas"
        aria-expanded="false"
        aria-controls="venta">
        <img src="./images/venta.png" alt="Ventas" class="nav-icon">
        <span class="button-label">VENTAS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#deceso" 
        data-tooltip="Decesos"
        aria-expanded="false"
        aria-controls="deceso">
        <img src="./images/craneo-de-toro.png" alt="Decesos" class="nav-icon">
        <span class="button-label">DECESOS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#descarte" 
        data-tooltip="Descartes"
        aria-expanded="false"
        aria-controls="descarte">
        <img src="./images/descarte.png" alt="Descartes" class="nav-icon">
        <span class="button-label">DESCARTES</span>
    </button>
</div>


<!-- Add back button before the header container -->
<a href="./bufalino_registros.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>
<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="compra">
  REGISTROS DE COMPRAS
  </h3>
  
  <div class="container mt-3 mb-4 text-center">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newEntryModalCompras">
          <i class="fas fa-plus"></i> Agregar
      </button>
  </div>
  
  <!-- New Aborto Entry Modal -->
  
  <div class="modal fade" id="newEntryModalCompras" tabindex="-1" aria-labelledby="newEntryModalLabelCompras" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="newEntryModalLabelCompras">
                      <i class="fas fa-plus-circle me-2"></i>Nuevo Registro de Compra
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="newCompraForm">
                      <div class="mb-4">
                          <label for="new_tagid" class="form-label">Tag ID</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-tag"></i></span>
                              <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_precio" class="form-label">Precio</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                              <input type="number" step="0.01" class="form-control" id="new_precio" name="precio" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_peso" class="form-label">Peso</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fa-solid fa-weight-scale"></i></span>
                              <input type="number" step="0.01" class="form-control" id="new_peso" name="peso" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_fecha" class="form-label">Fecha</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                              <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                          </div>
                      </div>                      
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      <i class="fas fa-times me-1"></i>Cancelar
                  </button>
                  <button type="button" class="btn btn-success" id="saveNewCompra">
                      <i class="fas fa-save me-1"></i>Guardar
                  </button>
              </div>
          </div>
      </div>
  </div>
  
  <!-- DataTable for bh_compra records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="bh_compraTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">ID</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>                    
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Precio</th>
                      <th class="text-center">Peso</th>
                      <th class="text-center">Estatus</th>                     
                      <th class="text-center">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                    // Query to get all bh_compra records with animal name
                    $compraQuery = "SELECT c.*, v.nombre as animal_nombre
                              FROM bh_compra c 
                              LEFT JOIN bufalino v ON c.bh_compra_tagid = v.tagid 
                              ORDER BY c.bh_compra_fecha DESC";
                              
                    $stmt = $conn->prepare($compraQuery);  
                    $stmt->execute();
                    $compraData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // If no data, display a message
                    if (empty($compraData)) {
                        echo "<tr><td colspan='9' class='text-center'>No hay registros disponibles</td></tr>";
                    } else {
                        // Get vigencia setting for compra records
                        $vigencia = 30; // Default value
                        try {
                            $configQuery = "SELECT v_vencimiento_compra FROM v_vencimiento LIMIT 1";
                            $configStmt = $conn->prepare($configQuery);
                            $configStmt->execute();
                            
                            // Explicitly use PDO fetch method
                            $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                            if ($row && isset($row['v_vencimiento_compra'])) {
                                $vigencia = intval($row['v_vencimiento_compra']);
                            }
                        } catch (PDOException $e) {
                            error_log("Error fetching configuration: " . $e->getMessage());
                            // Continue with default value
                        }
                        
                        $currentDate = new DateTime();
                        foreach ($compraData as $row) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['id'] ?? '') . "</td>";                        
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_fecha'] ?? '') . "</td>";                        
                            echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_tagid'] ?? '') . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_precio'] ?? '') . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_peso'] ?? '') . "</td>";

                            // Calculate due date and determine status
                            try {
                                $compraDate = new DateTime($row['bh_compra_fecha']);
                                $dueDate = clone $compraDate;
                                $dueDate->modify("+{$vigencia} days");
                                
                                if ($currentDate > $dueDate) {
                                    echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                } else {
                                    echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                }
                            } catch (Exception $e) {
                                // Handle invalid date format
                                error_log("Date error: " . $e->getMessage() . " for date: " . $row['bh_compra_fecha']);
                                echo '<td class="text-center"><span class="badge bg-warning">ERROR</span></td>';
                            }
                            
                            // Add action buttons (edit and delete)
                            echo '<td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-warning btn-sm edit-compra" 
                                        data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                        data-tagid="' . htmlspecialchars($row['bh_compra_tagid'] ?? '') . '"
                                        data-fecha="' . htmlspecialchars($row['bh_compra_fecha'] ?? '') . '"
                                        data-precio="' . htmlspecialchars($row['bh_compra_precio'] ?? '') . '"
                                        data-peso="' . htmlspecialchars($row['bh_compra_peso'] ?? '') . '">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-compra" 
                                        data-id="' . htmlspecialchars($row['id'] ?? '') . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>';
                            
                            echo "</tr>";
                        }
                    }
                } catch (PDOException $e) {
                    error_log("Error in compra table: " . $e->getMessage());
                    echo "<tr><td colspan='9' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH compra -->
<script>
$(document).ready(function() {
    $('#bh_compraTable').DataTable({
        // Set initial page length
        pageLength: 5,
        
        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
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
                targets: [4, 5], // Precio, Peso columns
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
                targets: [5], // Status column
                orderable: true,
                searchable: true
            },
            {
                targets: [6], // Actions column
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
    $('#saveNewCompra').click(function() {
        // Validate the form
        var form = document.getElementById('newCompraForm');
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
            text: `¿Desea registrar la compra para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_compra.php',
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
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newEntryModalCompras'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de compra ha sido guardado correctamente',
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
        $('.edit-compra').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var precio = $(this).data('precio');
        var peso = $(this).data('peso');
        var fecha = $(this).data('fecha');
        
        // Edit Compra Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editCompraModal" tabindex="-1" aria-labelledby="editCompraModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCompraModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Compra
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editCompraForm">
                            <input type="hidden" id="edit_id" value="${id}">
                            <div class="mb-4">
                                <label for="edit_tagid" class="form-label">Tag ID</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_precio" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input type="text" class="form-control" id="edit_precio" value="${precio}" required>
                                </div>
                            </div>                            
                            <div class="mb-4">
                                <label for="edit_peso" class="form-label">Peso</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input type="text" class="form-control" id="edit_peso" value="${peso}" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditCompra">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editCompraModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editCompraModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditCompra').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                precio: $('#edit_precio').val(),
                peso: $('#edit_peso').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar la compra para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_compra.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            precio: formData.precio,
                            peso: formData.peso,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'La compra para el animal con Tag ID ${formData.tagid} ha sido actualizada correctamente',
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
    $('.delete-compra').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar compra?',
            text: `¿Está seguro de que desea eliminar la compra para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
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
                    url: 'process_compra.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'La compra para el animal con Tag ID ${tagid} ha sido eliminada correctamente',
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

<!-- Compra Line Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evolución de Compras</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <select id="animalFilter" class="form-select">
                        <option value="all">Todos los animales</option>
                        <!-- Animal options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="dataRangeFilter" class="form-select">
                        <option value="20">Último</option>
                    </select>
                </div>
            </div>
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="compraChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Compra Line Chart -->
<script>
$(document).ready(function() {
    let allCompraData = [];
    let compraChart = null;
    
    // Fetch compra data and create the chart
    $.ajax({
        url: 'get_compra_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allCompraData = data;
            populateAnimalFilter(data);
            createCompraChart(data);
            
            // Add event listeners for filters
            $('#animalFilter, #dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching compra data:', error);
        }
    });
    
    function populateAnimalFilter(data) {
        // Get unique animals from the data
        const animals = [];
        const uniqueTagIds = new Set();
        
        data.forEach(item => {
            if (item.bh_compra_tagid && !uniqueTagIds.has(item.bh_compra_tagid)) {
                uniqueTagIds.add(item.bh_compra_tagid);
                animals.push({
                    tagid: item.bh_compra_tagid,
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
        
        let filteredData = [...allCompraData];
        
        // Filter by animal if not "all"
        if (selectedAnimal !== 'all') {
            filteredData = filteredData.filter(item => item.bh_compra_tagid === selectedAnimal);
        }
        
        // Sort data by date
        filteredData.sort((a, b) => new Date(a.bh_compra_fecha) - new Date(b.bh_compra_fecha));
        
        // Apply range filter
        if (selectedRange !== 'all' && filteredData.length > parseInt(selectedRange)) {
            filteredData = filteredData.slice(filteredData.length - parseInt(selectedRange));
        }
        
        // Update chart with filtered data
        updateChartData(filteredData);
    }
    
    function updateChartData(data) {
        if (compraChart) {
            compraChart.destroy();
        }
        createCompraChart(data);
    }
    
    function createCompraChart(data) {
        var ctx = document.getElementById('compraChart').getContext('2d');
        
        // Format the data for the chart
        var labels = data.map(function(item) {
            // Format the date for display
            var parts = item.bh_compra_fecha.split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return item.bh_compra_fecha;
        });
        
        var precio = data.map(function(item) {
            return item.bh_compra_precio;
        });
        
        compraChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Precio',
                    data: precio,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Precio',
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
                                }) + ' €';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha',
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
                                var dataPoint = data[index];
                                
                                var tooltipText = [
                                    'Precio: ' + context.parsed.y.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })
                                ];
                                
                                if (dataPoint && dataPoint.animal_nombre) {
                                    tooltipText.unshift('Animal: ' + dataPoint.animal_nombre);
                                }
                                
                                return tooltipText;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: function() {
                            const selectedAnimal = $('#animalFilter').val();
                            if (selectedAnimal !== 'all') {
                                const animalName = $('#animalFilter option:selected').text();
                                return 'Evolución de Compras - ' + animalName;
                            }
                            return 'Evolución de Compras - Todos los Animales';
                        },
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

<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="section-historial-produccion-bufalino">
  REGISTROS DE DECESOS
  </h3>
  
  <div class="container mt-3 mb-4 text-center">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newDecesoModal">
          <i class="fas fa-plus"></i> Agregar
      </button>
  </div>
  
  <!-- New Deceso Entry Modal -->
  
  <div class="modal fade" id="newDecesoModal" tabindex="-1" aria-labelledby="newDecesoModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="newDecesoModalLabel">
                      <i class="fas fa-plus-circle me-2"></i>Nuevo Registro de Deceso
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="newDecesoForm">
                      <div class="mb-4">
                          <label for="new_tagid" class="form-label">Tag ID</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-tag"></i></span>
                              <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_causa" class="form-label">Causa</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                              <input type="text" class="form-control" id="new_causa" name="causa" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_fecha" class="form-label">Fecha</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                              <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                          </div>
                      </div>                      
                  </form>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                      <i class="fas fa-times me-1"></i>Cancelar
                  </button>
                  <button type="button" class="btn btn-success" id="saveNewDeceso">
                      <i class="fas fa-save me-1"></i>Guardar
                  </button>
              </div>
          </div>
      </div>
  </div>
  
  <!-- DataTable for bh_deceso records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="bh_decesoTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">ID</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>                    
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Causa</th>                      
                      <th class="text-center">Estatus</th>                     
                      <th class="text-center">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                    // Query to get all bh_parto records with animal name
                    $decesoQuery = "SELECT c.*, v.nombre as animal_nombre
                              FROM bh_deceso c 
                              LEFT JOIN bufalino v ON c.bh_deceso_tagid = v.tagid 
                              ORDER BY c.bh_deceso_fecha DESC";
                              
                    $stmt = $conn->prepare($decesoQuery);
                    $stmt->execute();
                    $decesoData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // If no data, display a message
                    if (empty($decesoData)) {
                        echo "<tr><td colspan='9' class='text-center'>No hay registros disponibles</td></tr>";
                    } else {
                        // Get vigencia setting for deceso records
                        $vigencia = 30; // Default value
                        try {
                            $configQuery = "SELECT v_vencimiento_deceso FROM v_vencimiento LIMIT 1";
                            $configStmt = $conn->prepare($configQuery);
                            $configStmt->execute();
                            
                            // Explicitly use PDO fetch method
                            $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                            if ($row && isset($row['v_vencimiento_deceso'])) {
                                $vigencia = intval($row['v_vencimiento_deceso']);
                            }
                        } catch (PDOException $e) {
                            error_log("Error fetching configuration: " . $e->getMessage());
                            // Continue with default value
                        }
                        
                        $currentDate = new DateTime();
                        foreach ($decesoData as $row) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['id'] ?? '') . "</td>";                        
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_deceso_fecha'] ?? '') . "</td>";                        
                            echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_deceso_tagid'] ?? '') . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_deceso_causa'] ?? '') . "</td>";
                            // Calculate due date and determine status
                            try {
                                $decesoDate = new DateTime($row['bh_deceso_fecha']);
                                $dueDate = clone $decesoDate;
                                $dueDate->modify("+{$vigencia} days");
                                
                                if ($currentDate > $dueDate) {
                                    echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                } else {
                                    echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                }
                            } catch (Exception $e) {
                                // Handle invalid date format
                                error_log("Date error: " . $e->getMessage() . " for date: " . $row['bh_deceso_fecha']);
                                echo '<td class="text-center"><span class="badge bg-warning">ERROR</span></td>';
                            }
                            
                            // Add action buttons (edit and delete)
                            echo '<td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-warning btn-sm edit-deceso" 
                                        data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                        data-tagid="' . htmlspecialchars($row['bh_deceso_tagid'] ?? '') . '"
                                        data-fecha="' . htmlspecialchars($row['bh_deceso_fecha'] ?? '') . '"
                                        data-peso="' . htmlspecialchars($row['bh_deceso_peso'] ?? '') . '">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-deceso" 
                                        data-id="' . htmlspecialchars($row['id'] ?? '') . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>';
                            
                            echo "</tr>";
                        }
                    }
                } catch (PDOException $e) {
                    error_log("Error in deceso table: " . $e->getMessage());
                    echo "<tr><td colspan='9' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH deceso -->
<script>
$(document).ready(function() {
    $('#bh_decesoTable').DataTable({
        // Set initial page length
        pageLength: 5,
        
        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
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
                targets: [5], // Status column
                orderable: true,
                searchable: true
            },
            {
                targets: [6], // Actions column
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
    $('#saveNewDeceso').click(function() {
        // Validate the form
        var form = document.getElementById('newDecesoForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            tagid: $('#new_tagid').val(),
            causa: $('#new_causa').val(),
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el deceso para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_deceso.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        tagid: formData.tagid,
                        causa: formData.causa,
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newDecesoModal'));
                        modal.hide();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de deceso ha sido guardado correctamente',
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
        $('.edit-deceso').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var causa = $(this).data('causa');
        var fecha = $(this).data('fecha');
        
        // Edit Deceso Modal dialog for editing

        var modalHtml = `
        <div class="modal fade" id="editDecesoModal" tabindex="-1" aria-labelledby="editDecesoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDecesoModalLabel">
                            <i class="fas fa-weight me-2"></i>Editar Deceso
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editDecesoForm">
                            <input type="hidden" id="edit_id" value="${id}">
                            <div class="mb-4">
                                <label for="edit_tagid" class="form-label">Tag ID</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_causa" class="form-label">Causa</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input type="text" class="form-control" id="edit_causa" value="${causa}" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditDeceso">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editDecesoModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editDecesoModal'));
        editModal.show();
        
        // Handle save button click
        $('#saveEditDeceso').click(function() {
            var formData = {
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                causa: $('#edit_causa').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar el deceso para el animal con Tag ID ${formData.tagid}?`,
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
                        url: 'process_deceso.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            tagid: formData.tagid,
                            causa: formData.causa,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'El deceso para el animal con Tag ID ${formData.tagid} ha sido actualizado correctamente',
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
    $('.delete-deceso').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar deceso?',
            text: `¿Está seguro de que desea eliminar el deceso para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
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
                    url: 'process_deceso.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'El deceso para el animal con Tag ID ${tagid} ha sido eliminado correctamente',
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

<!-- Deceso Line Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evolución de Decesos</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <select id="animalFilter" class="form-select">
                        <option value="all">Todos los animales</option>
                        <!-- Animal options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="dataRangeFilter" class="form-select">
                        <option value="20">Último</option>
                    </select>
                </div>
            </div>
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="decesoChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Deceso Line Chart -->
<script>
$(document).ready(function() {
    let allDecesoData = [];
    let decesoChart = null;
    
    // Fetch compra data and create the chart
    $.ajax({
        url: 'get_deceso_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allDecesoData = data;
            populateAnimalFilter(data);
            createDecesoChart(data);
            
            // Add event listeners for filters
            $('#animalFilter, #dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching deceso data:', error);
        }
    });
    
    function populateAnimalFilter(data) {
        // Get unique animals from the data
        const animals = [];
        const uniqueTagIds = new Set();
        
        data.forEach(item => {
            if (item.bh_deceso_tagid && !uniqueTagIds.has(item.bh_deceso_tagid)) {
                uniqueTagIds.add(item.bh_deceso_tagid);
                animals.push({
                    tagid: item.bh_deceso_tagid,
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
        
        let filteredData = [...allDecesoData];
        
        // Filter by animal if not "all"
        if (selectedAnimal !== 'all') {
            filteredData = filteredData.filter(item => item.bh_deceso_tagid === selectedAnimal);
        }
        
        // Sort data by date
        filteredData.sort((a, b) => new Date(a.bh_deceso_fecha) - new Date(b.bh_deceso_fecha));
        
        // Apply range filter
        if (selectedRange !== 'all' && filteredData.length > parseInt(selectedRange)) {
            filteredData = filteredData.slice(filteredData.length - parseInt(selectedRange));
        }
        
        // Update chart with filtered data
        updateChartData(filteredData);
    }
    
    function updateChartData(data) {
        if (decesoChart) {
            decesoChart.destroy();
        }
        createDecesoChart(data);
    }
    
    function createDecesoChart(data) {
        var ctx = document.getElementById('decesoChart').getContext('2d');
        
        // Format the data for the chart
        var labels = data.map(function(item) {
            // Format the date for display
            var parts = item.bh_deceso_fecha.split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return item.bh_deceso_fecha;
        });
        
        var causa = data.map(function(item) {
            return item.bh_deceso_causa;
        });
        
        decesoChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Causa',
                    data: causa,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Causa',
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
                                }) + ' €';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha',
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
                                var dataPoint = data[index];
                                
                                var tooltipText = [
                                    'Causa: ' + context.parsed.y.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })
                                ];
                                
                                if (dataPoint && dataPoint.animal_nombre) {
                                    tooltipText.unshift('Animal: ' + dataPoint.animal_nombre);
                                }
                                
                                return tooltipText;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: function() {
                            const selectedAnimal = $('#animalFilter').val();
                            if (selectedAnimal !== 'all') {
                                const animalName = $('#animalFilter option:selected').text();
                                return 'Evolución de Decesos - ' + animalName;
                            }
                            return 'Evolución de Decesos - Todos los Animales';
                        },
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

<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="descarte">
  REGISTROS DE DESCARTE
  </h3>
  
  <div class="container mt-3 mb-4 text-center">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newEntryModalDescarte">
          <i class="fas fa-plus"></i> Agregar
      </button>
  </div>
  
  <!-- New Descarte Entry Modal -->
  
  <div class="modal fade" id="newEntryModalDescarte" tabindex="-1" aria-labelledby="newEntryModalLabelDescarte" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="newEntryModalLabelDescarte">
                      <i class="fas fa-plus-circle me-2"></i>Nuevo Registro de Descarte
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>            
              <div class="modal-body">
                  <form id="newDescarteForm">
                      <div class="mb-4">
                          <label for="new_tagid" class="form-label">Tag ID</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-tag"></i></span>
                              <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_peso" class="form-label">Peso</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                              <input type="text" class="form-control" id="new_peso" name="peso" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_fecha" class="form-label">Fecha</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                              <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                          </div>
                      </div>                      
                  </form>
              </div>
              <div class="modal-footer">
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
  
  <!-- DataTable for bh_descarte records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="bh_descarteTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">ID</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>                    
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Peso</th>                      
                      <th class="text-center">Estatus</th>                     
                      <th class="text-center">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                    // Query to get all bh_parto records with animal name
                    $descarteQuery = "SELECT c.*, v.nombre as animal_nombre
                              FROM bh_descarte c 
                              LEFT JOIN bufalino v ON c.bh_descarte_tagid = v.tagid 
                              ORDER BY c.bh_descarte_fecha DESC";
                              
                    $stmt = $conn->prepare($descarteQuery);
                    $stmt->execute();
                    $descarteData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    // If no data, display a message
                    if (empty($descarteData)) {
                        echo "<tr><td colspan='9' class='text-center'>No hay registros disponibles</td></tr>";
                    } else {
                        // Get vigencia setting for descarte records
                        $vigencia = 30; // Default value
                        try {
                            $configQuery = "SELECT v_vencimiento_descarte FROM v_vencimiento LIMIT 1";
                            $configStmt = $conn->prepare($configQuery);
                            $configStmt->execute();
                            
                            // Explicitly use PDO fetch method
                            $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                            if ($row && isset($row['v_vencimiento_descarte'])) {
                                $vigencia = intval($row['v_vencimiento_descarte']);
                            }
                        } catch (PDOException $e) {
                            error_log("Error fetching configuration: " . $e->getMessage());
                            // Continue with default value
                        }
                        
                        $currentDate = new DateTime();
                        foreach ($descarteData as $row) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['id'] ?? '') . "</td>";                        
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_descarte_fecha'] ?? '') . "</td>";                        
                            echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_descarte_tagid'] ?? '') . "</td>";
                            echo "<td class='text-center'>" . htmlspecialchars($row['bh_descarte_peso'] ?? '') . "</td>";
                            
                            // Calculate due date and determine status
                            try {
                                $descarteDate = new DateTime($row['bh_descarte_fecha']);
                                $dueDate = clone $descarteDate;
                                $dueDate->modify("+{$vigencia} days");
                                
                                if ($currentDate > $dueDate) {
                                    echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                } else {
                                    echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                }
                            } catch (Exception $e) {
                                // Handle invalid date format
                                error_log("Date error: " . $e->getMessage() . " for date: " . $row['bh_descarte_fecha']);
                                echo '<td class="text-center"><span class="badge bg-warning">ERROR</span></td>';
                            }
                            
                            // Add action buttons (edit and delete)
                            echo '<td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-warning btn-sm edit-descarte" 
                                        data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                        data-tagid="' . htmlspecialchars($row['bh_descarte_tagid'] ?? '') . '"
                                        data-fecha="' . htmlspecialchars($row['bh_descarte_fecha'] ?? '') . '"
                                        data-peso="' . htmlspecialchars($row['bh_descarte_peso'] ?? '') . '">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm delete-descarte" 
                                        data-id="' . htmlspecialchars($row['id'] ?? '') . '">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>';
                            
                            echo "</tr>";
                        }
                    }
                } catch (PDOException $e) {
                    error_log("Error in descarte table: " . $e->getMessage());
                    echo "<tr><td colspan='9' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH descarte -->
<script>
$(document).ready(function() {
    $('#bh_descarteTable').DataTable({
        // Set initial page length
        pageLength: 5,
        
        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
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
                targets: [5], // Status column
                orderable: true,
                searchable: true
            },
            {
                targets: [6], // Actions column
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
            fecha: $('#new_fecha').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el descarte para el animal con Tag ID ${formData.tagid}?`,
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
                        fecha: formData.fecha
                    },
                    success: function(response) {
                        // Close the modal
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newEntryModalDescarte'));
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
                            <div class="mb-4">
                                <label for="edit_tagid" class="form-label">Tag ID</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_peso" class="form-label">Peso</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input type="text" class="form-control" id="edit_peso" value="${peso}" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
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
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'El descarte para el animal con Tag ID ${formData.tagid} ha sido actualizado correctamente',
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
                            text: 'El descarte para el animal con Tag ID ${tagid} ha sido eliminado correctamente',
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

<!-- Descarte Line Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evolución de Descartes</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <select id="animalFilter" class="form-select">
                        <option value="all">Todos los animales</option>
                        <!-- Animal options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="dataRangeFilter" class="form-select">
                        <option value="20">Último</option>
                    </select>
                </div>
            </div>
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="descarteChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Descarte Line Chart -->
<script>
$(document).ready(function() {
    let allDescarteData = [];
    let descarteChart = null;
    
    // Fetch compra data and create the chart
    $.ajax({
        url: 'get_descarte_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allDescarteData = data;
            populateAnimalFilter(data);
            createDescarteChart(data);
            
            // Add event listeners for filters
            $('#animalFilter, #dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching descarte data:', error);
        }
    });
    
    function populateAnimalFilter(data) {
        // Get unique animals from the data
        const animals = [];
        const uniqueTagIds = new Set();
        
        data.forEach(item => {
            if (item.bh_descarte_tagid && !uniqueTagIds.has(item.bh_descarte_tagid)) {
                uniqueTagIds.add(item.bh_descarte_tagid);
                animals.push({
                    tagid: item.bh_descarte_tagid,
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
        
        let filteredData = [...allDescarteData];
        
        // Filter by animal if not "all"
        if (selectedAnimal !== 'all') {
            filteredData = filteredData.filter(item => item.bh_descarte_tagid === selectedAnimal);
        }
        
        // Sort data by date
        filteredData.sort((a, b) => new Date(a.bh_descarte_fecha) - new Date(b.bh_descarte_fecha));
        
        // Apply range filter
        if (selectedRange !== 'all' && filteredData.length > parseInt(selectedRange)) {
            filteredData = filteredData.slice(filteredData.length - parseInt(selectedRange));
        }
        
        // Update chart with filtered data
        updateChartData(filteredData);
    }
    
    function updateChartData(data) {
        if (descarteChart) {
            descarteChart.destroy();
        }
        createDescarteChart(data);
    }
    
    function createDescarteChart(data) {
        var ctx = document.getElementById('descarteChart').getContext('2d');
        
        // Format the data for the chart
        var labels = data.map(function(item) {
            // Format the date for display
            var parts = item.bh_descarte_fecha.split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return item.bh_descarte_fecha;
        });
        
        var causa = data.map(function(item) {
            return item.bh_descarte_causa;
        });
        
        descarteChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Peso',
                    data: peso,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Peso',
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
                                }) + ' €';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha',
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
                                var dataPoint = data[index];
                                
                                var tooltipText = [
                                    'Peso: ' + context.parsed.y.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })
                                ];
                                
                                if (dataPoint && dataPoint.animal_nombre) {
                                    tooltipText.unshift('Animal: ' + dataPoint.animal_nombre);
                                }
                                
                                return tooltipText;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: function() {
                            const selectedAnimal = $('#animalFilter').val();
                            if (selectedAnimal !== 'all') {
                                const animalName = $('#animalFilter option:selected').text();
                                return 'Evolución de Descartes - ' + animalName;
                            }
                            return 'Evolución de Descartes - Todos los Animales';
                        },
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

<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="venta">
  REGISTROS DE VENTAS
  </h3>
  
  <div class="container mt-3 mb-4 text-center">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newEntryModalVentas">
          <i class="fas fa-plus"></i> Agregar
      </button>
  </div>
  
  <!-- New Venta Entry Modal -->
  
  <div class="modal fade" id="newEntryModalVentas" tabindex="-1" aria-labelledby="newEntryModalLabelVentas" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="newEntryModalLabelVentas">
                      <i class="fas fa-plus-circle me-2"></i>Nuevo Registro de Venta
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="newVentaForm">
                      <div class="mb-4">
                          <label for="new_tagid" class="form-label">Tag ID</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-tag"></i></span>
                              <input type="text" class="form-control" id="new_tagid" name="tagid" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_peso" class="form-label">Peso</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                              <input type="text" class="form-control" id="new_peso" name="peso" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_precio" class="form-label">Precio</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                              <input type="text" class="form-control" id="new_precio" name="precio" required>
                          </div>
                      </div>
                      <div class="mb-4">
                          <label for="new_fecha" class="form-label">Fecha</label>
                          <div class="input-group">
                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                              <input type="date" class="form-control" id="new_fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>" required>
                          </div>
                      </div>                      
                  </form>
              </div>
              <div class="modal-footer">
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
  
  <!-- DataTable for bh_venta records -->
  
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="bh_ventaTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                      <th class="text-center">ID</th>
                      <th class="text-center">Fecha</th>
                      <th class="text-center">Nombre</th>                    
                      <th class="text-center">Tag ID</th>
                      <th class="text-center">Peso</th>                      
                      <th class="text-center">Precio</th>
                      <th class="text-center">Estatus</th>                     
                      <th class="text-center">Acciones</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                  try {
                      // Query to get all bh_venta records with animal name
                      $ventaQuery = "SELECT v.*, v.nombre as animal_nombre,
                                ve.bh_venta_peso as bh_venta_peso,
                                ve.bh_venta_precio as bh_venta_precio,
                                ve.bh_venta_fecha as bh_venta_fecha,
                                ve.bh_venta_tagid as bh_venta_tagid
                                FROM bh_venta ve 
                                JOIN bufalino v ON v.tagid = ve.bh_venta_tagid 
                                ORDER BY ve.bh_venta_fecha DESC";
                                
                      $stmt = $conn->prepare($ventaQuery);
                      $stmt->execute();
                      $ventaData = $stmt->fetchAll(PDO::FETCH_ASSOC);
                      
                      // If no data, display a message
                      if (empty($ventaData)) {
                          echo "<tr><td colspan='9' class='text-center'>No hay registros disponibles</td></tr>";
                      } else {
                          // Get vigencia setting for venta records
                            $vigencia = 30; // Default value
                          try {
                              $configQuery = "SELECT v_vencimiento_venta FROM v_vencimiento LIMIT 1";
                              $configStmt = $conn->prepare($configQuery);
                              $configStmt->execute();
                              
                              // Explicitly use PDO fetch method
                              $row = $configStmt->fetch(PDO::FETCH_ASSOC);
                              if ($row && isset($row['v_vencimiento_venta'])) {
                                  $vigencia = intval($row['v_vencimiento_venta']);
                              }
                          } catch (PDOException $e) {
                              error_log("Error fetching configuration: " . $e->getMessage());
                              // Continue with default value
                          }
                          
                          $currentDate = new DateTime();
                          foreach ($ventaData as $row) {
                              echo "<tr>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['id'] ?? '') . "</td>";                        
                              echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_fecha'] ?? '') . "</td>";                        
                              echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre'] ?? 'N/A') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_tagid'] ?? '') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_peso'] ?? '') . "</td>";
                              echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_precio'] ?? '') . "</td>";

                              // Calculate due date and determine status
                              try {
                                  $ventaDate = new DateTime($row['bh_venta_fecha']);
                                  $dueDate = clone $ventaDate;
                                  $dueDate->modify("+{$vigencia} days");
                                  
                                  if ($currentDate > $dueDate) {
                                      echo '<td class="text-center"><span class="badge bg-danger">VENCIDO</span></td>';
                                  } else {
                                      echo '<td class="text-center"><span class="badge bg-success">VIGENTE</span></td>';
                                  }
                              } catch (Exception $e) {
                                  // Handle invalid date format
                                  error_log("Date error: " . $e->getMessage() . " for date: " . $row['bh_venta_fecha']);
                                  echo '<td class="text-center"><span class="badge bg-warning">ERROR</span></td>';
                              }
                              
                              // Add action buttons (edit and delete)
                              echo '<td class="text-center">
                                  <div class="btn-group" role="group">
                                      <button class="btn btn-warning btn-sm edit-venta" 
                                              data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                              data-tagid="' . htmlspecialchars($row['bh_venta_tagid'] ?? '') . '"
                                              data-fecha="' . htmlspecialchars($row['bh_venta_fecha'] ?? '') . '"
                                              data-peso="' . htmlspecialchars($row['bh_venta_peso'] ?? '') . '"
                                          data-precio="' . htmlspecialchars($row['bh_venta_precio'] ?? '') . '">
                                          <i class="fas fa-edit"></i>
                                      </button>
                                      <button class="btn btn-danger btn-sm delete-venta" 
                                          data-id="' . htmlspecialchars($row['id'] ?? '') . '">
                                          <i class="fas fa-trash"></i>
                                      </button>
                                  </div>
                              </td>';
                              
                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      error_log("Error in venta table: " . $e->getMessage());
                      echo "<tr><td colspan='9' class='text-center'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                  }
                  ?>
              </tbody>
          </table>
      </div>
  </div>
</div>

<!-- Initialize DataTable for VH venta -->
<script>
$(document).ready(function() {
    $('#bh_ventaTable').DataTable({
        // Set initial page length
        pageLength: 5,
        
        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
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
                targets: [4, 5], // Peso, Precio columns
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
                targets: [5], // Status column
                orderable: true,
                searchable: true
            },
            {
                targets: [6], // Actions column
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
            peso: $('#new_peso').val(),
            precio: $('#new_precio').val(),
            fecha: $('#new_fecha').val()
        };  
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar la venta para el animal con Tag ID ${formData.tagid}?`,
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
                    url: 'process_venta.php',
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
                        var modal = bootstrap.Modal.getInstance(document.getElementById('newEntryModalVentas'));
                        modal.hide();
                        
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
    $('.edit-venta').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        var peso = $(this).data('peso');
        var precio = $(this).data('precio');
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
                        <form id="editDecesoForm">
                            <input type="hidden" id="edit_id" value="${id}">
                            <div class="mb-4">
                                <label for="edit_tagid" class="form-label">Tag ID</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    <input type="text" class="form-control" id="edit_tagid" value="${tagid}" readonly>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_precio" class="form-label">Precio</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="text" class="form-control" id="edit_precio" value="${precio}" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_peso" class="form-label">Peso</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input type="text" class="form-control" id="edit_peso" value="${peso}" required>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edit_fecha" class="form-label">Fecha</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    <input type="date" class="form-control" id="edit_fecha" value="${fecha}" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
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
                id: $('#edit_id').val(),
                tagid: $('#edit_tagid').val(),
                precio: $('#edit_precio').val(),
                peso: $('#edit_peso').val(),
                fecha: $('#edit_fecha').val()
            };
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar la venta para el animal con Tag ID ${formData.tagid}?`,
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
                            id: formData.id,
                            tagid: formData.tagid,
                            precio: formData.precio,
                            peso: formData.peso,
                            fecha: formData.fecha
                        },
                        success: function(response) {
                            // Close the modal
                            editModal.hide();
                            
                            // Show success message
                            Swal.fire({
                                title: '¡Actualización exitosa!',
                                text: 'La venta para el animal con Tag ID ${formData.tagid} ha sido actualizada correctamente',
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
    $('.delete-venta').click(function() {
        var id = $(this).data('id');
        var tagid = $(this).data('tagid');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar venta?',
            text: `¿Está seguro de que desea eliminar la venta para el animal con Tag ID ${tagid}? Esta acción no se puede deshacer.`,
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
                        // Show success message
                        Swal.fire({
                            title: '¡Eliminado!',
                            text: 'La venta para el animal con Tag ID ${tagid} ha sido eliminada correctamente',
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

<!-- Venta Line Chart Section -->

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Evolución de Ventas</h5>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <select id="animalFilter" class="form-select">
                        <option value="all">Todos los animales</option>
                        <!-- Animal options will be populated dynamically -->
                    </select>
                </div>
                <div class="col-md-4">
                    <select id="dataRangeFilter" class="form-select">
                        <option value="20">Último</option>
                    </select>
                </div>
            </div>
            <div class="chart-container" style="position: relative; height:50vh; width:100%">
                <canvas id="ventaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script for Deceso Line Chart -->
<script>
$(document).ready(function() {
    let allVentaData = [];
    let ventaChart = null;
    
    // Fetch compra data and create the chart
    $.ajax({
        url: 'get_venta_data.php',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            
            allVentaData = data;
            populateAnimalFilter(data);
            createVentaChart(data);
            
            // Add event listeners for filters
            $('#animalFilter, #dataRangeFilter').on('change', function() {
                updateChart();
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching venta data:', error);
        }
    });
    
    function populateAnimalFilter(data) {
        // Get unique animals from the data
        const animals = [];
        const uniqueTagIds = new Set();
        
        data.forEach(item => {
            if (item.bh_venta_tagid && !uniqueTagIds.has(item.bh_venta_tagid)) {
                uniqueTagIds.add(item.bh_venta_tagid);
                animals.push({
                    tagid: item.bh_venta_tagid,
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
        
        let filteredData = [...allVentaData];
        
        // Filter by animal if not "all"
        if (selectedAnimal !== 'all') {
            filteredData = filteredData.filter(item => item.bh_venta_tagid === selectedAnimal);
        }   
        
        // Sort data by date
        filteredData.sort((a, b) => new Date(a.bh_venta_fecha) - new Date(b.bh_venta_fecha));
        
        // Apply range filter
        if (selectedRange !== 'all' && filteredData.length > parseInt(selectedRange)) {
            filteredData = filteredData.slice(filteredData.length - parseInt(selectedRange));
        }
        
        // Update chart with filtered data
        updateChartData(filteredData);
    }
    
    function updateChartData(data) {
        if (ventaChart) {
            ventaChart.destroy();
        }
        createVentaChart(data);
    }
    
    function createVentaChart(data) {
        var ctx = document.getElementById('ventaChart').getContext('2d');
        
        // Format the data for the chart
        var labels = data.map(function(item) {
            // Format the date for display
            var parts = item.bh_venta_fecha.split('-');
            if (parts.length === 3) {
                return parts[2] + '/' + parts[1] + '/' + parts[0];
            }
            return item.bh_venta_fecha;
        });
        
        var precio = data.map(function(item) {
            return item.bh_venta_precio;
        });
        
        ventaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Precio',
                    data: precio,
                    backgroundColor: 'rgba(40, 167, 69, 0.2)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(40, 167, 69, 1)',
                    pointBorderColor: '#fff',
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: false,
                        title: {
                            display: true,
                            text: 'Precio',
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
                                }) + ' €';
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Fecha',
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
                                var dataPoint = data[index];
                                var tooltipText = [
                                    'Precio: ' + context.parsed.y.toLocaleString('es-ES', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })
                                ];
                                
                                if (dataPoint && dataPoint.animal_nombre) {
                                    tooltipText.unshift('Animal: ' + dataPoint.animal_nombre);
                                }
                                
                                return tooltipText;
                            }
                        }
                    },
                    title: {
                        display: true,
                        text: function() {
                            const selectedAnimal = $('#animalFilter').val();
                            if (selectedAnimal !== 'all') {
                                const animalName = $('#animalFilter option:selected').text();
                                return 'Evolución de Ventas - ' + animalName;
                            }
                            return 'Evolución de Ventas - Todos los Animales';
                        },
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all buttons in the scroll-icons-container
    const scrollButtons = document.querySelectorAll('.scroll-icons-container .btn');
    
    scrollButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Prevent default collapse behavior
            e.preventDefault();
            
            // Get the target section ID from data-bs-target
            const targetId = this.getAttribute('data-bs-target').replace('#', '');
            const targetSection = document.getElementById(targetId);
            
            if (targetSection) {
                // Add a small delay to allow for the collapse animation
                setTimeout(() => {
                    // Scroll to the section with smooth behavior
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                        inline: 'nearest'
                    });
                    
                    // Show the collapsed section
                    const bsCollapse = new bootstrap.Collapse(targetSection, {
                        show: true
                    });
                }, 100);
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const backToTopButton = document.getElementById('backToTop');
    
    // Show/hide button based on scroll position
    function toggleBackToTopButton() {
        if (window.scrollY > 300) {
            backToTopButton.classList.add('visible');
        } else {
            backToTopButton.classList.remove('visible');
        }
    }
    
    // Smooth scroll to top
    function scrollToTop(e) {
        e.preventDefault();
        
        // First, check if native smooth scrolling is supported
        if ('scrollBehavior' in document.documentElement.style) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        } else {
            // Fallback for browsers that don't support smooth scrolling
            const scrollStep = -window.scrollY / (500 / 15); // 500ms duration
            
            function scrollAnimation() {
                if (window.scrollY !== 0) {
                    window.scrollBy(0, scrollStep);
                    requestAnimationFrame(scrollAnimation);
                }
            }
            
            requestAnimationFrame(scrollAnimation);
        }
    }
    
    // Add scroll event listener with throttling
    let isScrolling = false;
    
    window.addEventListener('scroll', function() {
        if (!isScrolling) {
            window.requestAnimationFrame(function() {
                toggleBackToTopButton();
                isScrolling = false;
            });
            isScrolling = true;
        }
    });
    
    // Add click event listener
    backToTopButton.addEventListener('click', scrollToTop);
    
    // Optional: Hide button on page load
    toggleBackToTopButton();
    
    // Optional: Add keyboard support
    backToTopButton.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
            scrollToTop(e);
        }
    });
});
</script>

<!-- Back to Top Button -->
<button id="backToTop" class="btn btn-success back-to-top" title="Volver arriba">
    <i class="fas fa-arrow-up"></i>
</button>