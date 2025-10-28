<?php
require_once './pdo_conexion.php';  // Go up one directory since inventario_bufalino.php is in the bufalino folder
// Now you can use $conn for database queries

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registros Reproduccion</title>
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

<!-- Custom -->
<link rel="stylesheet" href="./bufalino.css">

</head>
<body>
<!-- Icon Navigation Buttons -->
<div class="container" id="nav-buttons">
    <div class="container nav-icons-container" id="nav-buttons">
        <button onclick="window.location.href='../inicio.php'" class="icon-button" data-tooltip="Inicio">
            <img src="./images/default_image.png" alt="Inicio" class="nav-icon">
        </button>
        
        <button onclick="window.location.href='./inventario_bufalino.php'" class="icon-button" data-tooltip="Inventario bufalino">
            <img src="./images/bufalo-icon.png" alt="Inventario" class="nav-icon">
        </button>
        
        <button onclick="window.location.href='./bufalino_indices.php'" class="icon-button" data-tooltip="Indices bufalinos">
            <img src="./images/indices.png" alt="Inicio" class="nav-icon">
        </button>
        
        <button onclick="window.location.href='./bufalino_configuracion.php'" class="icon-button" data-tooltip="Configurar Tablas">
            <img src="./images/configuracion.png" alt="Inicio" class="nav-icon">
        </button>
    </div>
</div>

<!-- Scroll Icons Container -->
<div class="container scroll-icons-container">    
    <button class="btn btn-outline-secondary mb-3" onclick="window.location.href='./bufalino_registrar_pesaje_animal.php'" data-tooltip="Pesaje Carne">
        <img src="./images/carne.png" alt="Pesaje Carne" class="nav-icon">
    </button>
    
    <button class="btn btn-outline-secondary mb-3" onclick="window.location.href='./bufalino_registrar_pesaje_leche.php'" data-tooltip="Pesaje Leche">
        <img src="./images/leche-cantaro.png" alt="Pesajes Leche" class="nav-icon">
    </button>
    
    <button class="btn btn-outline-secondary mb-3" onclick="window.location.href='./bufalino_registrar_alimentacion.php'" data-tooltip="Alimentacion">
        <img src="./images/harina-de-trigo.png" alt="Alimentacion" class="nav-icon">
    </button>

    <button class="btn btn-outline-secondary mb-3" type="button" onclick="window.location.href='./bufalino_registrar_alimentacion.php'" data-tooltip="Salud">
        <img src="./images/proteger.png" alt="Salud" class="nav-icon">
    </button>
       
    <button class="icon-button" type="button" data-bs-toggle="collapse" data-bs-target="#" data-tooltip="Reproduccion">
        <img src="./images/el-embarazo.png" alt="Reproduccion" class="nav-icon">
    </button>

    <button class="btn btn-outline-secondary mb-3" type="button" onclick="window.location.href='./bufalino_registrar_poblacion.php'" data-tooltip="Poblacion">
    <img src="./images/bufalo-icon.png" alt="Poblacion" class="nav-icon">
    </button>
</div>

<!-- Add back button before the header container -->
    
<a href="./inventario_bufalino.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>

<!-- Registros Inseminacion -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_inseminacion WHERE bh_inseminacion_tagid = ? ORDER BY bh_inseminacion_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_inseminacion ORDER BY bh_inseminacion_fecha ASC");
        $stmt->execute();
    }
    
    $inseminacionData = [];
    $inseminacionFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process inseminacion data
    $inseminacionData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($inseminacionData as $row) {
        $date = new DateTime($row['bh_inseminacion_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_inseminacion_costo']);
        $inseminacionFechaLabels[] = $row['bh_inseminacion_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($inseminacionFechaLabels), null);
    foreach ($inseminacionFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyWeights[$month])) {
            $monthlyData[$index] = end($monthlyWeights[$month]);
        }
    }

    // Calculate regression
    $x = [];
    $y = [];
    $n = 0;

    foreach ($monthlyData as $index => $weight) {
        if ($weight !== null) {
            $x[] = $n;
            $y[] = $weight;
            $n++;
        }
    }

    if (count($x) > 1) {
        $x_mean = array_sum($x) / count($x);
        $y_mean = array_sum($y) / count($y);

        $numerator = 0;
        $denominator = 0;

        for ($i = 0; $i < count($x); $i++) {
            $numerator += ($x[$i] - $x_mean) * ($y[$i] - $y_mean);
            $denominator += pow($x[$i] - $x_mean, 2);
        }

        $slope = $denominator != 0 ? $numerator / $denominator : 0;
        $y_intercept = $y_mean - ($slope * $x_mean);

        $regressionLine = array_fill(0, count($monthlyData), null);
        $point_count = 0;

        foreach ($monthlyData as $index => $weight) {
            if ($weight !== null) {
                $regressionLine[$index] = $y_intercept + ($slope * $point_count);
                $point_count++;
            }
        }
    }

    // Calculate monthly prices
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyPrices = [];
    $monthlyPriceData = array_fill(0, count($inseminacionFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_inseminacion_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_inseminacion_costo']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($inseminacionFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($inseminacionFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_inseminacion_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_inseminacion_costo']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($inseminacionFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyValues[$month]) && $monthlyValues[$month]['count'] > 0) {
            $monthlyValueData[$index] = $monthlyValues[$month]['sum'] / $monthlyValues[$month]['count'];
        }
    }
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>
<!-- Inseminacion Table Section -->
<?php
    // Get animal name if tagid is provided
    $animalName = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $tagid = $_GET['search'];
        $stmt = $conn->prepare("SELECT nombre FROM bufalino WHERE tagid = ?");
        $stmt->execute([$tagid]);
        if ($row = $stmt->fetch()) {
            $animalName = $row['nombre'];
        }
    }

    // Fetch all inseminacion records with animal name and total value calculation
    $inseminacionQuery = "SELECT p.*, 
                         v.nombre as animal_nombre,
                         p.bh_inseminacion_costo as total_value
                  FROM bh_inseminacion p 
                  LEFT JOIN bufalino v ON p.bh_inseminacion_tagid = v.tagid 
                  ORDER BY p.bh_inseminacion_fecha DESC";
    $stmt = $conn->prepare($inseminacionQuery);
    $stmt->execute();
    $inseminacionResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <!-- Search Form -->
    <form method="GET" class="search-form mt-4 mb-4">
        <div class="search-wrapper">
            <div class="input-group">
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    class="form-control search-input" 
                    placeholder="Buscar por animal por número..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                >
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
            <label class="required-label">* Obligatorio para nuevo registro</label>
        </div>
    </form>
</div>

<h3 class="container mt-4 text-white">INSEMINACION</h3>

<!-- Inseminacion INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addInseminacionForm">
    <div class="card card-body">
        <form id="inseminacionForm" action="process_inseminacion.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Numero</label>
                    <input type="number" class="form-control" name="numero" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Costo ($)</label>
                    <input type="number" step="0.01" class="form-control" name="costo" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Inseminacion Insertar Script-->
<script>
$(document).ready(function() {
    $('#inseminacionForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar este registro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'insert'); // Add action parameter
                
                fetch('./process_inseminacion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: 'El registro ha sido guardado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_vacunacion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
});
</script>
<!-- Inseminacion DataTable -->

<div class="table-responsive">
  <!-- Add New Inseminacion Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addInseminacionForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="inseminacionTable" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="text-center">Numero</th>              
              <th class="text-center">Nombre</th>
              <th class="text-center">Inseminacion #</th>
              <th class="text-center">Costo ($)</th>
              <th class="text-center">Fecha</th>
              <th class="text-center">Acciones</th>

          </tr>
      </thead>
      <tbody>
<?php
// Display tables
foreach ($inseminacionResult as $row) {
    echo "<tr>";    
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_inseminacion_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_inseminacion_numero']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_inseminacion_costo']) . "</td>";    
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_inseminacion_fecha']) . "</td>";
    echo "<td class='text-center'>

            <button class='btn btn-success btn-sm edit-inseminacion'
                    data-id='" . htmlspecialchars($row['id']) . "'                    
                    data-numero='" . htmlspecialchars($row['bh_inseminacion_numero']) . "'
                    data-costo='" . htmlspecialchars($row['bh_inseminacion_costo']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_inseminacion_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editInseminacionModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-inseminacion'
                    data-id='" . htmlspecialchars($row['id']) . "'>
                <i class='fas fa-trash'></i>
            </button>
          </td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
<!--  Inseminacion Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#inseminacionTable').DataTable({
        // Set initial page length to 5
        pageLength: 5,

        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
        ],

        // Order by fecha (date) column descending
        order: [[4, 'desc']],

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
        // Add custom classes for styling
        pagingType: "simple_numbers",
        classes: {
            sPageButton: "paginate_button",
        },

 // Column specific settings
 columnDefs: [
            {
                targets: [3], // Costo
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Clean the data and ensure it's a valid number
                        const cleanNumber = data ? data.toString().replace(/[^\d.-]/g, '') : '0';
                        const number = parseFloat(cleanNumber);
                        
                        if (isNaN(number)) {
                            console.log('Invalid number:', data); // Debug log
                            return '0.00';
                        }
                        
                        return number.toFixed(2);
                    }
                    return data;
                }
            },
            {
                targets: [4], // Fecha column
                render: function(data, type, row) {
                    if (type === 'display') {
                        const parts = data.split('-');  // Split YYYY-MM-DD
                        const date = new Date(parts[0], parts[1] - 1, parts[2]);
                        const day = parts[2];  // Keep original day
                        const month = date.toLocaleDateString('es-ES', { month: 'short' });
                        const year = parts[0].slice(-2);  // Get last 2 digits of year
                        return `${day} ${month} '${year}`;
                    }
                    return data;
                }
            },
            {
                targets: [5], // Acciones column
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
<!-- Add SweetAlert2 library in the head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Delete Inseminacion Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-inseminacion').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#83956e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('./process_inseminacion.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=delete&id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'El registro ha sido eliminado.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Error al eliminar el registro'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud'
                        });
                    });
                }
            });
        });
    });
});
</script>
<!-- Edit Inseminacion Modal -->

<div class="modal fade" id="editInseminacionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Inseminacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editInseminacionForm" action="process_inseminacion.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">                    
                    <div class="mb-3">
                        <label class="form-label">Numero</label>
                        <input type="number" class="form-control" name="numero" id="edit_numero" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Costo $</label>
                        <input type="number" step="0.01" class="form-control" name="costo" id="edit_costo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" id="edit_fecha" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Inseminacion JS -->
<script>
    // Handle edit button click
    $('.edit-inseminacion').click(function() {
        const button = $(this);

        // Get data from data attributes
        const id = button.data('id');
        const numero = button.data('numero');
        const costo = button.data('costo');
        const fecha = button.data('fecha');

        // Populate modal fields
        $('#edit_id').val(id);
        $('#edit_numero').val(numero);
        $('#edit_costo').val(costo);
        $('#edit_fecha').val(fecha);
    });

    // Handle form submission
    $('#editInseminacionForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'update'); // Add action parameter
                
                fetch('process_inseminacion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        $('#editInseminacionModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_reproduccion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al actualizar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
</script>


<!-- Back to top button -->
<button id="backToTop" class="back-to-top" onclick="scrollToTop()" title="Volver arriba">
    <div class="arrow-up"><i class="fa-solid fa-arrow-up"></i></div>
</button>


<script>
window.onscroll = function() {
    const backToTopButton = document.getElementById("backToTop");
    if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
        backToTopButton.style.display = "flex";
    } else {
        backToTopButton.style.display = "none";
    }
};

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}
</script>

<!-- Chart Container -->
<div class="chart-container">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">Inseminaciones</h5>
            <div class="chart-wrapper">
                <canvas id="inseminacionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('inseminacionChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($inseminacionFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const inseminacionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedLabels,
            datasets: [
                {
                    label: 'Dosis',
                    data: monthlyData,
                    borderColor: '#83956e',
                    backgroundColor: '#83956e33',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Línea de Tendencia',
                    data: regressionLine,
                    borderColor: '#ff6b6b',
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0,
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // Allow chart to fill container
            plugins: {
                title: {
                    display: true,
                    text: 'Tendencia Costo Inseminacion',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y.toFixed(2)} kg`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Dosis'
                    }
                }
            }
        }
    });
});
</script>

<!-- Add this script after your form -->
<script>
$(document).ready(function() {
    // Initially collapse the form
    $('#addInseminacionForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addInseminacionForm"]').click(function(e) {
        e.preventDefault(); // Prevent default toggle behavior
        const tagid = $('#search').val().trim();
        
        if (!tagid) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, ingrese un número de identificación válido primero',
                confirmButtonColor: '#83956e'
            });
            
            // Ensure form stays collapsed
            $('#addInseminacionForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addInseminacionForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addInseminacionForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addInseminacionForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addInseminacionForm').collapse('hide');
    }
});
</script>

<!-- Registros Gestacion -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_gestacion WHERE bh_gestacion_tagid = ? ORDER BY bh_gestacion_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_gestacion ORDER BY bh_gestacion_fecha ASC");
        $stmt->execute();
    }
    
    $gestacionData = [];
    $gestacionFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process gestacion data
    $gestacionData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($gestacionData as $row) {
        $date = new DateTime($row['bh_gestacion_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_gestacion_numero']);
        $gestacionFechaLabels[] = $row['bh_gestacion_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($gestacionFechaLabels), null);
    foreach ($gestacionFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyWeights[$month])) {
            $monthlyData[$index] = end($monthlyWeights[$month]);
        }
    }

    // Calculate regression
    $x = [];
    $y = [];
    $n = 0;

    foreach ($monthlyData as $index => $weight) {
        if ($weight !== null) {
            $x[] = $n;
            $y[] = $weight;
            $n++;
        }
    }

    if (count($x) > 1) {
        $x_mean = array_sum($x) / count($x);
        $y_mean = array_sum($y) / count($y);

        $numerator = 0;
        $denominator = 0;

        for ($i = 0; $i < count($x); $i++) {
            $numerator += ($x[$i] - $x_mean) * ($y[$i] - $y_mean);
            $denominator += pow($x[$i] - $x_mean, 2);
        }

        $slope = $denominator != 0 ? $numerator / $denominator : 0;
        $y_intercept = $y_mean - ($slope * $x_mean);

        $regressionLine = array_fill(0, count($monthlyData), null);
        $point_count = 0;

        foreach ($monthlyData as $index => $weight) {
            if ($weight !== null) {
                $regressionLine[$index] = $y_intercept + ($slope * $point_count);
                $point_count++;
            }
        }
    }

    // Calculate monthly prices
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyPrices = [];
    $monthlyPriceData = array_fill(0, count($gestacionFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_gestacion_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_gestacion_numero']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($gestacionFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($gestacionFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_gestacion_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_gestacion_numero']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($gestacionFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyValues[$month]) && $monthlyValues[$month]['count'] > 0) {
            $monthlyValueData[$index] = $monthlyValues[$month]['sum'] / $monthlyValues[$month]['count'];
        }
    }
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>

<!-- Gestacion Table Section -->
<?php
    // Get animal name if tagid is provided
    $animalName = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $tagid = $_GET['search'];
        $stmt = $conn->prepare("SELECT nombre FROM bufalino WHERE tagid = ?");
        $stmt->execute([$tagid]);
        if ($row = $stmt->fetch()) {
            $animalName = $row['nombre'];
        }
    }

    // Fetch all gestacion records with animal name and total value calculation
    $gestacionQuery = "SELECT p.*, 
                         v.nombre as animal_nombre,
                         p.bh_gestacion_numero as total_value
                  FROM bh_gestacion p 
                  LEFT JOIN bufalino v ON p.bh_gestacion_tagid = v.tagid 
                  ORDER BY p.bh_gestacion_fecha DESC";
    $stmt = $conn->prepare($gestacionQuery);
    $stmt->execute();
    $gestacionResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <!-- Search Form -->
    <form method="GET" class="search-form mt-4 mb-4">
        <div class="search-wrapper">
            <div class="input-group">
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    class="form-control search-input" 
                    placeholder="Buscar por animal por número..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                >
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
            <label class="required-label">* Obligatorio para nuevo registro</label>
        </div>
    </form>
</div>

<h3 class="container mt-4 text-white">GESTACION</h3>

<!-- Alimento Gestacion INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addGestacionForm">
    <div class="card card-body">
        <form id="gestacionForm" action="process_gestacion.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Numero</label>
                    <input type="number" class="form-control" name="numero" required>
                </div>                                
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Gestacion Insertar Script-->
<script>
$(document).ready(function() {
    $('#gestacionForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar este registro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'insert'); // Add action parameter
                
                fetch('./process_gestacion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: 'El registro ha sido guardado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_vacunacion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
});
</script>
<!-- Gestacion DataTable -->

<div class="table-responsive">
  <!-- Add New Gestacion Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addGestacionForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="gestacionTable" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="text-center">Numero</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Gestacion #</th>
              <th class="text-center">Fecha</th>
              <th class="text-center">Acciones</th>

          </tr>
      </thead>
      <tbody>
<?php
// Display tables
foreach ($gestacionResult as $row) {
    echo "<tr>";    
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_gestacion_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_gestacion_numero']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_gestacion_fecha']) . "</td>";
    echo "<td class='text-center'>

            <button class='btn btn-success btn-sm edit-gestacion'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-numero='" . htmlspecialchars($row['bh_gestacion_numero']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_gestacion_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editGestacionModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-gestacion'
                    data-id='" . htmlspecialchars($row['id']) . "'>
                <i class='fas fa-trash'></i>
            </button>
          </td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
<!--  Gestacion Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#gestacionTable').DataTable({
        // Set initial page length to 5
        pageLength: 5,

        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
        ],

        // Order by fecha (date) column descending
        order: [[3, 'desc']],

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
        // Add custom classes for styling
        pagingType: "simple_numbers",
        classes: {
            sPageButton: "paginate_button",
        },

 // Column specific settings
 columnDefs: [
            {
                targets: [2], // Precio, Valor y Total columns formato decimal
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Clean the data and ensure it's a valid number
                        const cleanNumber = data ? data.toString().replace(/[^\d.-]/g, '') : '0';
                        const number = parseFloat(cleanNumber);
                        
                        if (isNaN(number)) {
                            console.log('Invalid number:', data); // Debug log
                            return '0.00';
                        }
                        
                        return number.toFixed(2);
                    }
                    return data;
                }
            },
            {
                targets: [3], // Fecha column
                render: function(data, type, row) {
                    if (type === 'display') {
                        const parts = data.split('-');  // Split YYYY-MM-DD
                        const date = new Date(parts[0], parts[1] - 1, parts[2]);
                        const day = parts[2];  // Keep original day
                        const month = date.toLocaleDateString('es-ES', { month: 'short' });
                        const year = parts[0].slice(-2);  // Get last 2 digits of year
                        return `${day} ${month} '${year}`;
                    }
                    return data;
                }
            },
            {
                targets: [4], // Acciones column
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
<!-- Add SweetAlert2 library in the head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Delete Gestacion Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-gestacion').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#83956e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('./process_gestacion.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=delete&id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'El registro ha sido eliminado.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Error al eliminar el registro'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud'
                        });
                    });
                }
            });
        });
    });
});
</script>
<!-- Edit Gestacion Modal -->

<div class="modal fade" id="editGestacionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Gestacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editGestacionForm" action="process_gestacion.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">
                    <div class="mb-3">
                        <label class="form-label">Gestacion #</label>
                        <input type="text" class="form-control" name="numero" id="edit_numero" required>
                    </div>                    
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" id="edit_fecha" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Gestacion JS -->
<script>
    // Handle edit button click
    $('.edit-gestacion').click(function() {
        const button = $(this);

        // Get data from data attributes
        const id = button.data('id');
        const numero = button.data('numero');
        const fecha = button.data('fecha');

        // Populate modal fields
        $('#edit_id').val(id);
        $('#edit_numero').val(numero);
        $('#edit_fecha').val(fecha);
    });

    // Handle form submission
    $('#editGestacionForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'update'); // Add action parameter
                
                fetch('./process_gestacion.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        $('#editGestacionModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_vacunacion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al actualizar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
</script>

<!-- Chart Container -->
<div class="chart-container">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">Gestaciones</h5>
            <div class="chart-wrapper">
                <canvas id="gestacionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('gestacionChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($gestacionFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const gestacionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedLabels,
            datasets: [
                {
                    label: 'Dosis',
                    data: monthlyData,
                    borderColor: '#83956e',
                    backgroundColor: '#83956e33',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Línea de Tendencia',
                    data: regressionLine,
                    borderColor: '#ff6b6b',
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0,
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // Allow chart to fill container
            plugins: {
                title: {
                    display: true,
                    text: 'Tendencia de Inversión',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y.toFixed(2)} kg`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Dosis'
                    }
                }
            }
        }
    });
});
</script>

<!-- Add this script after your form -->
<script>
$(document).ready(function() {
    // Initially collapse the form
    $('#addGestacionForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addGestacionForm"]').click(function(e) {
        e.preventDefault(); // Prevent default toggle behavior
        const tagid = $('#search').val().trim();
        
        if (!tagid) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, ingrese un número de identificación válido primero',
                confirmButtonColor: '#83956e'
            });
            
            // Ensure form stays collapsed
            $('#addGestacionForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addGestacionForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addGestacionForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addGestacionForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addGestacionForm').collapse('hide');
    }
});
</script>

<!-- Registros Parto -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_parto WHERE bh_parto_tagid = ? ORDER BY bh_parto_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_parto ORDER BY bh_parto_fecha ASC");
        $stmt->execute();
    }
    
    $partoData = [];
    $partoFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process parto data
    $partoData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($partoData as $row) {
        $date = new DateTime($row['bh_parto_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_parto_numero']);
        $partoFechaLabels[] = $row['bh_parto_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($partoFechaLabels), null);
    foreach ($partoFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyWeights[$month])) {
            $monthlyData[$index] = end($monthlyWeights[$month]);
        }
    }

    // Calculate regression
    $x = [];
    $y = [];
    $n = 0;

    foreach ($monthlyData as $index => $weight) {
        if ($weight !== null) {
            $x[] = $n;
            $y[] = $weight;
            $n++;
        }
    }

    if (count($x) > 1) {
        $x_mean = array_sum($x) / count($x);
        $y_mean = array_sum($y) / count($y);

        $numerator = 0;
        $denominator = 0;

        for ($i = 0; $i < count($x); $i++) {
            $numerator += ($x[$i] - $x_mean) * ($y[$i] - $y_mean);
            $denominator += pow($x[$i] - $x_mean, 2);
        }

        $slope = $denominator != 0 ? $numerator / $denominator : 0;
        $y_intercept = $y_mean - ($slope * $x_mean);

        $regressionLine = array_fill(0, count($monthlyData), null);
        $point_count = 0;

        foreach ($monthlyData as $index => $weight) {
            if ($weight !== null) {
                $regressionLine[$index] = $y_intercept + ($slope * $point_count);
                $point_count++;
            }
        }
    }

    // Calculate monthly prices
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyPrices = [];
    $monthlyPriceData = array_fill(0, count($partoFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_parto_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_parto_numero']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($partoFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($partoFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_parto_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_parto_numero']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($partoFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyValues[$month]) && $monthlyValues[$month]['count'] > 0) {
            $monthlyValueData[$index] = $monthlyValues[$month]['sum'] / $monthlyValues[$month]['count'];
        }
    }
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>

<!-- SAL Table Section -->
<?php
    // Get animal name if tagid is provided
    $animalName = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $tagid = $_GET['search'];
        $stmt = $conn->prepare("SELECT nombre FROM bufalino WHERE tagid = ?");
        $stmt->execute([$tagid]);
        if ($row = $stmt->fetch()) {
            $animalName = $row['nombre'];
        }
    }

    // Fetch all parto records with animal name and total value calculation
    $partoQuery = "SELECT p.*, 
                         v.nombre as animal_nombre,
                         p.bh_parto_numero as total_value
                  FROM bh_parto p 
                  LEFT JOIN bufalino v ON p.bh_parto_tagid = v.tagid 
                  ORDER BY p.bh_parto_fecha DESC";
    $stmt = $conn->prepare($partoQuery);
    $stmt->execute();
    $partoResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <!-- Search Form -->
    <form method="GET" class="search-form mt-4 mb-4">
        <div class="search-wrapper">
            <div class="input-group">
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    class="form-control search-input" 
                    placeholder="Buscar por animal por número..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                >
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
            <label class="required-label">* Obligatorio para nuevo registro</label>
        </div>
    </form>
</div>

<h3 class="container mt-4 text-white">PARTO</h3>

<!-- Parto INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addPartoForm">
    <div class="card card-body">
        <form id="partoForm" action="process_parto.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Numero</label>
                    <input type="number" class="form-control" name="numero" required>
                </div>                
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Parto Insertar Script-->
<script>
$(document).ready(function() {
    $('#partoForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar este registro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'insert'); // Add action parameter
                
                fetch('./process_parto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: 'El registro ha sido guardado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_reproduccion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
});
</script>
<!-- Parto DataTable -->

<div class="table-responsive">
  <!-- Add New Parto Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addPartoForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="partoTable" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="text-center">Numero</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Parto #</th>
              <th class="text-center">Fecha</th>
              <th class="text-center">Acciones</th>
          </tr>
      </thead>
      <tbody>
<?php
// Display tables
foreach ($partoResult as $row) {
    echo "<tr>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_parto_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_parto_numero']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_parto_fecha']) . "</td>";
    echo "<td class='text-center'>
            <button class='btn btn-success btn-sm edit-parto'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-numero='" . htmlspecialchars($row['bh_parto_numero']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_parto_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editPartoModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-parto'
                    data-id='" . htmlspecialchars($row['id']) . "'>
                <i class='fas fa-trash'></i>
            </button>
          </td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
<!--  Parto Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#partoTable').DataTable({
        // Set initial page length to 5
        pageLength: 5,

        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
        ],

        // Order by fecha (date) column descending
        order: [[3, 'desc']],

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
        // Add custom classes for styling
        pagingType: "simple_numbers",
        classes: {
            sPageButton: "paginate_button",
        },

 // Column specific settings
 columnDefs: [
            {
                targets: [2], // Parto Number column
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Clean the data and ensure it's a valid number
                        const cleanNumber = data ? data.toString().replace(/[^\d.-]/g, '') : '0';
                        const number = parseFloat(cleanNumber);
                        
                        if (isNaN(number)) {
                            console.log('Invalid number:', data); // Debug log
                            return '0.00';
                        }
                        
                        return number.toFixed(2);
                    }
                    return data;
                }
            },
            {
                targets: [3], // Fecha column
                render: function(data, type, row) {
                    if (type === 'display') {
                        const parts = data.split('-');  // Split YYYY-MM-DD
                        const date = new Date(parts[0], parts[1] - 1, parts[2]);
                        const day = parts[2];  // Keep original day
                        const month = date.toLocaleDateString('es-ES', { month: 'short' });
                        const year = parts[0].slice(-2);  // Get last 2 digits of year
                        return `${day} ${month} '${year}`;
                    }
                    return data;
                }
            },
            {
                targets: [4], // Acciones column
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
<!-- Add SweetAlert2 library in the head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Delete Parto Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-parto').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#83956e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('./process_parto.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=delete&id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'El registro ha sido eliminado.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Error al eliminar el registro'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud'
                        });
                    });
                }
            });
        });
    });
});
</script>
<!-- Edit Parto Modal -->

<div class="modal fade" id="editPartoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Parto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPartoForm" action="process_parto.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">
                    <div class="mb-3">
                        <label class="form-label">Parto #</label>
                        <input type="number" class="form-control" name="numero" id="edit_numero" required>
                    </div>                    
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" id="edit_fecha" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Parto JS -->
<script>
    // Handle edit button click
    $('.edit-parto').click(function() {
        const button = $(this);

        // Get data from data attributes
        const id = button.data('id');
        const numero = button.data('numero');
        const fecha = button.data('fecha');

        // Populate modal fields
        $('#edit_id').val(id);
        $('#edit_numero').val(numero);
        $('#edit_fecha').val(fecha);
    });

    // Handle form submission
    $('#editPartoForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'update'); // Add action parameter
                
                fetch('./process_parto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        $('#editPartoModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_reproduccion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al actualizar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
</script>

<!-- Chart Container -->
<div class="chart-container">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">Partos</h5>
            <div class="chart-wrapper">
                <canvas id="partoChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('partoChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($partoFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const partoChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedLabels,
            datasets: [
                {
                    label: 'Dosis',
                    data: monthlyData,
                    borderColor: '#83956e',
                    backgroundColor: '#83956e33',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Línea de Tendencia',
                    data: regressionLine,
                    borderColor: '#ff6b6b',
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0,
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // Allow chart to fill container
            plugins: {
                title: {
                    display: true,
                    text: 'Tendencia de Inversión',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y.toFixed(2)} kg`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Dosis'
                    }
                }
            }
        }
    });
});
</script>

<!-- Add this script after your form -->
<script>
$(document).ready(function() {
    // Initially collapse the form
    $('#addPartoForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addPartoForm"]').click(function(e) {
        e.preventDefault(); // Prevent default toggle behavior
        const tagid = $('#search').val().trim();
        
        if (!tagid) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, ingrese un número de identificación válido primero',
                confirmButtonColor: '#83956e'
            });
            
            // Ensure form stays collapsed
            $('#addPartoForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addPartoForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addPartoForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addPartoForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addPartoForm').collapse('hide');
    }
});
</script>

<!-- Registros Destete -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_destete WHERE bh_destete_tagid = ? ORDER BY bh_destete_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_destete ORDER BY bh_destete_fecha ASC");
        $stmt->execute();
    }
    
    $desteteData = [];
    $desteteFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process destete data
    $desteteData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($desteteData as $row) {
        $date = new DateTime($row['bh_destete_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_destete_peso']);
        $desteteFechaLabels[] = $row['bh_destete_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($desteteFechaLabels), null);
    foreach ($desteteFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyWeights[$month])) {
            $monthlyData[$index] = end($monthlyWeights[$month]);
        }
    }

    // Calculate regression
    $x = [];
    $y = [];
    $n = 0;

    foreach ($monthlyData as $index => $weight) {
        if ($weight !== null) {
            $x[] = $n;
            $y[] = $weight;
            $n++;
        }
    }

    if (count($x) > 1) {
        $x_mean = array_sum($x) / count($x);
        $y_mean = array_sum($y) / count($y);

        $numerator = 0;
        $denominator = 0;

        for ($i = 0; $i < count($x); $i++) {
            $numerator += ($x[$i] - $x_mean) * ($y[$i] - $y_mean);
            $denominator += pow($x[$i] - $x_mean, 2);
        }

        $slope = $denominator != 0 ? $numerator / $denominator : 0;
        $y_intercept = $y_mean - ($slope * $x_mean);

        $regressionLine = array_fill(0, count($monthlyData), null);
        $point_count = 0;

        foreach ($monthlyData as $index => $weight) {
            if ($weight !== null) {
                $regressionLine[$index] = $y_intercept + ($slope * $point_count);
                $point_count++;
            }
        }
    }

    // Calculate monthly prices
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyPrices = [];
    $monthlyPriceData = array_fill(0, count($desteteFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_destete_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_destete_peso']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($desteteFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($desteteFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_destete_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_destete_peso']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($desteteFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyValues[$month]) && $monthlyValues[$month]['count'] > 0) {
            $monthlyValueData[$index] = $monthlyValues[$month]['sum'] / $monthlyValues[$month]['count'];
        }
    }
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>

<!-- Destete Table Section -->
<?php
    // Get animal name if tagid is provided
    $animalName = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $tagid = $_GET['search'];
        $stmt = $conn->prepare("SELECT nombre FROM bufalino WHERE tagid = ?");
        $stmt->execute([$tagid]);
        if ($row = $stmt->fetch()) {
            $animalName = $row['nombre'];
        }
    }

    // Fetch all destete records with animal name and total value calculation
    $desteteQuery = "SELECT p.*, 
                         v.nombre as animal_nombre,
                         CAST((p.bh_destete_peso) AS DECIMAL(10,2)) as total_value
                  FROM bh_destete p 
                  LEFT JOIN bufalino v ON p.bh_destete_tagid = v.tagid 
                  ORDER BY p.bh_destete_fecha DESC";
    $stmt = $conn->prepare($desteteQuery);
    $stmt->execute();
    $desteteResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <!-- Search Form -->
    <form method="GET" class="search-form mt-4 mb-4">
        <div class="search-wrapper">
            <div class="input-group">
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    class="form-control search-input" 
                    placeholder="Buscar animal por número..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                >
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
            <label class="required-label">* Obligatorio para nuevo registro</label>
        </div>
    </form>
</div>

<h3 class="container mt-4 text-white">DESTETE</h3>

<!-- Destete INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addDesteteForm">
    <div class="card card-body">
        <form id="desteteForm" action="process_destete.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">                
                <div class="col-md-4">
                    <label class="form-label">Peso</label>
                    <input type="number" step="0.01" class="form-control" name="peso" required>
                </div>                
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Destete Insertar Script-->
<script>
$(document).ready(function() {
    $('#desteteForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar este registro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'insert'); // Add action parameter
                
                fetch('./process_destete.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: 'El registro ha sido guardado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_reproduccion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
});
</script>
<!-- Destete DataTable -->

<div class="table-responsive">
  <!-- Add New Destete Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addDesteteForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="desteteTable" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="text-center">Numero</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Peso</th>
              <th class="text-center">Fecha</th>
              <th class="text-center">Acciones</th>

          </tr>
      </thead>
      <tbody>
<?php
// Display tables
foreach ($desteteResult as $row) {
    echo "<tr>";    
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_destete_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_destete_peso']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_destete_fecha']) . "</td>";
    echo "<td class='text-center'>

            <button class='btn btn-success btn-sm edit-destete'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-peso='" . htmlspecialchars($row['bh_destete_peso']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_destete_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editDesteteModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-destete'
                    data-id='" . htmlspecialchars($row['id']) . "'>
                <i class='fas fa-trash'></i>
            </button>
          </td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
<!--  Destete Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#desteteTable').DataTable({
        // Set initial page length to 5
        pageLength: 5,

        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
        ],

        // Order by fecha (date) column descending
        order: [[3, 'desc']],

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
        // Add custom classes for styling
        pagingType: "simple_numbers",
        classes: {
            sPageButton: "paginate_button",
        },

 // Column specific settings
 columnDefs: [
            {
                targets: [2], // Peso column
                render: function(data, type, row) {
                    if (type === 'display') {
                        // Clean the data and ensure it's a valid number
                        const cleanNumber = data ? data.toString().replace(/[^\d.-]/g, '') : '0';
                        const number = parseFloat(cleanNumber);
                        
                        if (isNaN(number)) {
                            console.log('Invalid number:', data); // Debug log
                            return '0.00';
                        }
                        
                        return number.toFixed(2);
                    }
                    return data;
                }
            },
            {
                targets: [3], // Fecha column
                render: function(data, type, row) {
                    if (type === 'display') {
                        const parts = data.split('-');  // Split YYYY-MM-DD
                        const date = new Date(parts[0], parts[1] - 1, parts[2]);
                        const day = parts[2];  // Keep original day
                        const month = date.toLocaleDateString('es-ES', { month: 'short' });
                        const year = parts[0].slice(-2);  // Get last 2 digits of year
                        return `${day} ${month} '${year}`;
                    }
                    return data;
                }
            },
            {
                targets: [4], // Acciones column
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
<!-- Add SweetAlert2 library in the head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Delete Destete Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-destete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#83956e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('./process_destete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=delete&id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'El registro ha sido eliminado.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Error al eliminar el registro'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud'
                        });
                    });
                }
            });
        });
    });
});
</script>
<!-- Edit Destete Modal -->

<div class="modal fade" id="editDesteteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Destete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editDesteteForm" action="process_destete.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">                    
                    <div class="mb-3">
                        <label class="form-label">Peso</label>
                        <input type="number" step="0.01" class="form-control" name="peso" id="edit_peso" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" id="edit_fecha" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Destete JS -->
<script>
    // Handle edit button click
    $('.edit-destete').click(function() {
        const button = $(this);

        // Get data from data attributes
        const id = button.data('id');
        const peso = button.data('peso');
        const fecha = button.data('fecha');

        // Populate modal fields
        $('#edit_id').val(id);
        $('#edit_peso').val(peso);
        $('#edit_fecha').val(fecha);
    });

    // Handle form submission
    $('#editDesteteForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'update'); // Add action parameter
                
                fetch('process_destete.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        $('#editDesteteModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_reproduccion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al actualizar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
</script>

<!-- Chart Container -->
<div class="chart-container">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">Destetes</h5>
            <div class="chart-wrapper">
                <canvas id="desteteChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('desteteChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($desteteFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const desteteChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedLabels,
            datasets: [
                {
                    label: 'Dosis',
                    data: monthlyData,
                    borderColor: '#83956e',
                    backgroundColor: '#83956e33',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Línea de Tendencia',
                    data: regressionLine,
                    borderColor: '#ff6b6b',
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0,
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // Allow chart to fill container
            plugins: {
                title: {
                    display: true,
                    text: 'Tendencia',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y.toFixed(2)} kg`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Dosis'
                    }
                }
            }
        }
    });
});
</script>

<!-- Add this script after your form -->
<script>
$(document).ready(function() {
    // Initially collapse the form
    $('#addDesteteForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addDesteteForm"]').click(function(e) {
        e.preventDefault(); // Prevent default toggle behavior
        const tagid = $('#search').val().trim();
        
        if (!tagid) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, ingrese un número de identificación válido primero',
                confirmButtonColor: '#83956e'
            });
            
            // Ensure form stays collapsed
            $('#addDesteteForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addDesteteForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addDesteteForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addDesteteForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addDesteteForm').collapse('hide');
    }
});
</script>

<!-- Registros Aborto -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_aborto WHERE bh_aborto_tagid = ? ORDER BY bh_aborto_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_aborto ORDER BY bh_aborto_fecha ASC");
        $stmt->execute();
    }
    
    $abortoData = [];
    $abortoFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process aborto data
    $abortoData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($abortoData as $row) {
        $date = new DateTime($row['bh_aborto_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval(1);
        $abortoFechaLabels[] = $row['bh_aborto_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($abortoFechaLabels), null);
    foreach ($abortoFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyWeights[$month])) {
            $monthlyData[$index] = end($monthlyWeights[$month]);
        }
    }

    // Calculate regression
    $x = [];
    $y = [];
    $n = 0;

    foreach ($monthlyData as $index => $weight) {
        if ($weight !== null) {
            $x[] = $n;
            $y[] = $weight;
            $n++;
        }
    }

    if (count($x) > 1) {
        $x_mean = array_sum($x) / count($x);
        $y_mean = array_sum($y) / count($y);

        $numerator = 0;
        $denominator = 0;

        for ($i = 0; $i < count($x); $i++) {
            $numerator += ($x[$i] - $x_mean) * ($y[$i] - $y_mean);
            $denominator += pow($x[$i] - $x_mean, 2);
        }

        $slope = $denominator != 0 ? $numerator / $denominator : 0;
        $y_intercept = $y_mean - ($slope * $x_mean);

        $regressionLine = array_fill(0, count($monthlyData), null);
        $point_count = 0;

        foreach ($monthlyData as $index => $weight) {
            if ($weight !== null) {
                $regressionLine[$index] = $y_intercept + ($slope * $point_count);
                $point_count++;
            }
        }
    }

    // Calculate monthly prices
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyPrices = [];
    $monthlyPriceData = array_fill(0, count($abortoFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_aborto_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += 1;
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($abortoFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($abortoFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_aborto_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval(1);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($abortoFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyValues[$month]) && $monthlyValues[$month]['count'] > 0) {
            $monthlyValueData[$index] = $monthlyValues[$month]['sum'] / $monthlyValues[$month]['count'];
        }
    }
  }
  catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }

?>

<!-- Aborto Table Section -->
<?php
    // Get animal name if tagid is provided
    $animalName = '';
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $tagid = $_GET['search'];
        $stmt = $conn->prepare("SELECT nombre FROM bufalino WHERE tagid = ?");
        $stmt->execute([$tagid]);
        if ($row = $stmt->fetch()) {
            $animalName = $row['nombre'];
        }
    }

    // Fetch all aborto records with animal name and total value calculation
    $abortoQuery = "SELECT p.*, 
                         v.nombre as animal_nombre,
                         CAST( 1 AS DECIMAL(10,2)) as total_value
                  FROM bh_aborto p 
                  LEFT JOIN bufalino v ON p.bh_aborto_tagid = v.tagid 
                  ORDER BY p.bh_aborto_fecha DESC";
    $stmt = $conn->prepare($abortoQuery);
    $stmt->execute();
    $abortoResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <!-- Search Form -->
    <form method="GET" class="search-form mt-4 mb-4">
        <div class="search-wrapper">
            <div class="input-group">
                <input 
                    type="text" 
                    id="search" 
                    name="search" 
                    class="form-control search-input" 
                    placeholder="Buscar animal por número..." 
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                >
                <button type="submit" class="btn btn-search">
                    <i class="fas fa-search"></i>
                    Buscar
                </button>
            </div>
            <label class="required-label">* Obligatorio para nuevo registro</label>
        </div>
    </form>
</div>

<h3 class="container mt-4 text-white">ABORTO</h3>

<!-- Aborto INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addAbortoForm">
    <div class="card card-body">
        <form id="abortoForm" action="process_aborto.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Causa</label>
                    <input type="text" class="form-control" name="causa" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Aborto Insertar Script-->
<script>
$(document).ready(function() {
    $('#abortoForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar este registro?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'insert'); // Add action parameter
                
                fetch('./process_aborto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Guardado!',
                            text: 'El registro ha sido guardado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_reproduccion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al guardar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
});
</script>
<!-- Aborto DataTable -->

<div class="table-responsive">
  <!-- Add New Aborto Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addAbortoForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="abortoTable" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="text-center">Numero</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Causa</th>
              <th class="text-center">Fecha</th>
              <th class="text-center">Acciones</th>

          </tr>
      </thead>
      <tbody>
<?php
// Display tables
foreach ($abortoResult as $row) {
    echo "<tr>";    
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_aborto_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_aborto_causa']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_aborto_fecha']) . "</td>";
    echo "<td class='text-center'>

            <button class='btn btn-success btn-sm edit-aborto'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-causa='" . htmlspecialchars($row['bh_aborto_causa']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_aborto_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editAbortoModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-aborto'
                    data-id='" . htmlspecialchars($row['id']) . "'>
                <i class='fas fa-trash'></i>
            </button>
          </td>";
    echo "</tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>
<!--  Aborto Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#abortoTable').DataTable({
        // Set initial page length to 5
        pageLength: 5,

        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
        ],

        // Order by fecha (date) column descending
        order: [[3, 'desc']],

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
        // Add custom classes for styling
        pagingType: "simple_numbers",
        classes: {
            sPageButton: "paginate_button",
        },

 // Column specific settings
 columnDefs: [            
            {
                targets: [3], // Fecha column
                render: function(data, type, row) {
                    if (type === 'display') {
                        const parts = data.split('-');  // Split YYYY-MM-DD
                        const date = new Date(parts[0], parts[1] - 1, parts[2]);
                        const day = parts[2];  // Keep original day
                        const month = date.toLocaleDateString('es-ES', { month: 'short' });
                        const year = parts[0].slice(-2);  // Get last 2 digits of year
                        return `${day} ${month} '${year}`;
                    }
                    return data;
                }
            },
            {
                targets: [4], // Acciones column
                orderable: false,
                searchable: false
            }
        ]
    });
});
</script>
<!-- Add SweetAlert2 library in the head section -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Delete Aborto Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-aborto').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede revertir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#83956e',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('./process_aborto.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=delete&id=${id}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminado!',
                                text: 'El registro ha sido eliminado.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Error al eliminar el registro'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al procesar la solicitud'
                        });
                    });
                }
            });
        });
    });
});
</script>
<!-- Edit Aborto Modal -->

<div class="modal fade" id="editAbortoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Aborto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAbortoForm" action="process_aborto.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">
                    <div class="mb-3">
                        <label class="form-label">Causa</label>
                        <input type="text" class="form-control" name="causa" id="edit_causa" required>
                    </div>                    
                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="fecha" id="edit_fecha" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Aborto JS -->
<script>
    // Handle edit button click
    $('.edit-aborto').click(function() {
        const button = $(this);

        // Get data from data attributes
        const id = button.data('id');
        const causa = button.data('causa');
        const fecha = button.data('fecha');

        // Populate modal fields
        $('#edit_id').val(id);
        $('#edit_causa').val(causa);
        $('#edit_fecha').val(fecha);
    });

    // Handle form submission
    $('#editAbortoForm').on('submit', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "¿Desea guardar los cambios?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#83956e',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = this;
                const formData = new FormData(form);
                formData.append('action', 'update'); // Add action parameter
                
                fetch('process_aborto.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        $('#editAbortoModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_reproduccion.php';
                        });
                    } else {
                        throw new Error(data.message || 'Error al actualizar');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Error al procesar la solicitud'
                    });
                });
            }
        });
    });
</script>

<!-- Chart Container -->
<div class="chart-container">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">Abortos</h5>
            <div class="chart-wrapper">
                <canvas id="abortoChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('abortoChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($abortoFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const abortoChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: formattedLabels,
            datasets: [
                {
                    label: 'Dosis',
                    data: monthlyData,
                    borderColor: '#83956e',
                    backgroundColor: '#83956e33',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                },
                {
                    label: 'Línea de Tendencia',
                    data: regressionLine,
                    borderColor: '#ff6b6b',
                    borderDash: [5, 5],
                    fill: false,
                    pointRadius: 0,
                    tension: 0
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  // Allow chart to fill container
            plugins: {
                title: {
                    display: true,
                    text: 'Tendencia de Inversión',
                    font: {
                        size: 16
                    }
                },
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y.toFixed(2)} kg`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Dosis'
                    }
                }
            }
        }
    });
});
</script>

<!-- Add this script after your form -->
<script>
$(document).ready(function() {
    // Initially collapse the form
    $('#addAbortoForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addAbortoForm"]').click(function(e) {
        e.preventDefault(); // Prevent default toggle behavior
        const tagid = $('#search').val().trim();
        
        if (!tagid) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor, ingrese un número de identificación válido primero',
                confirmButtonColor: '#83956e'
            });
            
            // Ensure form stays collapsed
            $('#addAbortoForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addAbortoForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addAbortoForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addAbortoForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addAbortoForm').collapse('hide');
    }
});
</script>
</body>
</html> 