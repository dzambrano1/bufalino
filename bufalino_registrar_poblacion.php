<?php
require_once './pdo_conexion.php';  // Go up one directory since inventario_bufalino.php is in the bufalino folder
// Now you can use $conn for database queries

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registros Poblacion</title>
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
        <img src="./images/leche-cantaro.png" alt="Pesaje Leche" class="nav-icon">
    </button>
    
    <button class="btn btn-outline-secondary mb-3" onclick="window.location.href='./bufalino_registrar_alimentacion.php'" data-tooltip="Alimentacion">
        <img src="./images/harina-de-trigo.png" alt="Alimentacion" class="nav-icon">
    </button>

    <button class="btn btn-outline-secondary mb-3" type="button" onclick="window.location.href='./bufalino_registrar_vacunacion.php'" data-tooltip="Salud">
        <img src="./images/proteger.png" alt="Salud" class="nav-icon">
    </button>
       
    <button  class="btn btn-outline-secondary mb-3" type="button" onclick="window.location.href='./bufalino_registrar_reproduccion.php'" data-tooltip="Reproduccion">
        <img src="./images/el-embarazo.png" alt="Reproduccion" class="nav-icon">
    </button>

    <button class="icon-button" type="button" data-tooltip="Poblacion">
        <img src="./images/bufalo-icon.png" alt="Poblacion" class="nav-icon">
    </button>
</div>

<!-- Add back button before the header container -->
    
<a href="./inventario_bufalino.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>

<!-- Registros Compra -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_compra WHERE bh_compra_tagid = ? ORDER BY bh_compra_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_compra ORDER BY bh_compra_fecha ASC");
        $stmt->execute();
    }
    
    $compraData = [];
    $compraFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process compra data
    $compraData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($compraData as $row) {
        $date = new DateTime($row['bh_compra_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_compra_peso']);
        $compraFechaLabels[] = $row['bh_compra_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($compraFechaLabels), null);
    foreach ($compraFechaLabels as $index => $date) {
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
    $monthlyPriceData = array_fill(0, count($compraFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_compra_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_compra_precio']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($compraFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($compraFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_compra_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_compra_peso']) * floatval($row['bh_compra_precio']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($compraFechaLabels as $index => $date) {
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
<!-- Compra Table Section -->
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

    // Fetch all compra records with animal name and total value calculation
    $compraQuery = "SELECT p.*, 
                         v.nombre as animal_nombre,
                         CAST((p.bh_compra_peso * p.bh_compra_precio) AS DECIMAL(10,2)) as total_value
                  FROM bh_compra p 
                  LEFT JOIN bufalino v ON p.bh_compra_tagid = v.tagid 
                  ORDER BY p.bh_compra_fecha DESC";
    $stmt = $conn->prepare($compraQuery);
    $stmt->execute();
    $compraResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<h3 class="container mt-4 text-white">COMPRAS</h3>

<!-- Compra INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addCompraForm">
    <div class="card card-body">
        <form id="compraForm" action="process_compra.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Peso</label>
                    <input type="number" step="0.01" class="form-control" name="peso" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Precio ($)</label>
                    <input type="number" step="0.01" class="form-control" name="precio" required>
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

<!-- Compra Insertar Script-->
<script>
$(document).ready(function() {
    $('#compraForm').on('submit', function(e) {
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
                
                fetch('./process_compra.php', {
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
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
<!-- Compra DataTable -->

<div class="table-responsive">
  <!-- Add New Compra Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addCompraForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="compraTable" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="text-center">Numero</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Peso (Kg)</th>
              <th class="text-center">Precio ($)</th>
              <th class="text-center">Fecha</th>
              <th class="text-center">Acciones</th>

          </tr>
      </thead>
      <tbody>
<?php
// Display tables
foreach ($compraResult as $row) {
    echo "<tr>";    
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_peso']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_precio']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_compra_fecha']) . "</td>";
    echo "<td class='text-center'>

            <button class='btn btn-success btn-sm edit-compra'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-peso='" . htmlspecialchars($row['bh_compra_peso']) . "'
                    data-precio='" . htmlspecialchars($row['bh_compra_precio']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_compra_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editCompraModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-compra'
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
<!--  Compra Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#compraTable').DataTable({
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
                targets: [2,3], // Peso y Precio
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
<!-- Delete Compra Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-compra').forEach(button => {
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
                    fetch('./process_compra.php', {
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
<!-- Edit Compra Modal -->

<div class="modal fade" id="editCompraModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Compra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCompraForm" action="process_compra.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">                    
                    <div class="mb-3">
                        <label class="form-label">Peso (Kg)</label>
                        <input type="number" step="0.01" class="form-control" name="peso" id="edit_peso" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio ($)</label>
                        <input type="number" step="0.01" class="form-control" name="precio" id="edit_precio" required>
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

<!-- Edit Compra JS -->
<script>
    // Handle edit button click
    $('.edit-compra').click(function() {
        const button = $(this);

        // Get data from data attributes
        const id = button.data('id');
        const peso = button.data('peso');
        const precio = button.data('precio');
        const fecha = button.data('fecha');

        // Populate modal fields
        $('#edit_id').val(id);
        $('#edit_peso').val(peso);
        $('#edit_precio').val(precio);
        $('#edit_fecha').val(fecha);
    });

    // Handle form submission
    $('#editCompraForm').on('submit', function(e) {
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
                
                fetch('process_compra.php', {
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
                        $('#editCompraModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
            <h5 class="card-title">Compra</h5>
            <div class="chart-wrapper">
                <canvas id="compraChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('compraChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($compraFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const compraChart = new Chart(ctx, {
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
                    text: 'Tendencia Compras',
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
    $('#addCompraForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addCompraForm"]').click(function(e) {
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
            $('#addCompraForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addCompraForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addCompraForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addCompraForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addCompraForm').collapse('hide');
    }
});
</script>

<!-- Registros Deceso -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_deceso WHERE bh_deceso_tagid = ? ORDER BY bh_deceso_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_deceso ORDER BY bh_deceso_fecha ASC");
        $stmt->execute();
    }
    
    $decesoData = [];
    $decesoFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process deceso data
    $decesoData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($decesoData as $row) {
        $date = new DateTime($row['bh_deceso_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_deceso_peso']);
        $decesoFechaLabels[] = $row['bh_deceso_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($decesoFechaLabels), null);
    foreach ($decesoFechaLabels as $index => $date) {
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
    $monthlyPriceData = array_fill(0, count($decesoFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_deceso_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_deceso_peso']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($decesoFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($decesoFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_deceso_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_deceso_peso']) * floatval($row['bh_deceso_precio']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($decesoFechaLabels as $index => $date) {
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

<!-- Deceso Table Section -->
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

    // Fetch all deceso records with animal name and total value calculation
    $decesoQuery = "SELECT p.*, 
                         v.nombre as animal_nombre                         
                  FROM bh_deceso p 
                  LEFT JOIN bufalino v ON p.bh_deceso_tagid = v.tagid 
                  ORDER BY p.bh_deceso_fecha DESC";
    $stmt = $conn->prepare($decesoQuery);
    $stmt->execute();
    $decesoResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<h3 class="container mt-4 text-white">DECESOS</h3>

<!-- Alimento Deceso INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addDecesoForm">
    <div class="card card-body">
        <form id="decesoForm" action="process_deceso.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Causa</label>
                    <input type="text" class="form-control" name="causa" required>
                </div>                                                
                <div class="col-md-4">
                    <label class="form-label"></label>Fecha</label>
                    <input type="date" class="form-control" name="fecha" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Deceso Insertar Script-->
<script>
$(document).ready(function() {
    $('#decesoForm').on('submit', function(e) {
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
                
                fetch('./process_deceso.php', {
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
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
<!-- Deceso DataTable -->

<div class="table-responsive">
  <!-- Add New Deceso Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addDecesoForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="decesoTable" class="table table-striped table-bordered">
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
foreach ($decesoResult as $row) {
    echo "<tr>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_deceso_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_deceso_causa']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_deceso_fecha']) . "</td>";
    echo "<td class='text-center'>

            <button class='btn btn-success btn-sm edit-deceso'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-causa='" . htmlspecialchars($row['bh_deceso_causa']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_deceso_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editDecesoModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-deceso'
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
<!--  Deceso Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#decesoTable').DataTable({
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
<!-- Delete Deceso Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-deceso').forEach(button => {
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
                    fetch('./process_deceso.php', {
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
<!-- Edit Deceso Modal -->

<div class="modal fade" id="editDecesoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Deceso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editDecesoForm" action="process_deceso.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">
                    <div class="mb-3">
                        <label class="form-label">Causa </label>
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

<!-- Edit Deceso JS -->
<script>
    // Handle edit button click
    $('.edit-deceso').click(function() {
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
    $('#editDecesoForm').on('submit', function(e) {
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
                
                fetch('./process_deceso.php', {
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
                        $('#editDecesoModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
            <h5 class="card-title">Decesos</h5>
            <div class="chart-wrapper">
                <canvas id="decesoChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('decesoChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($decesoFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const decesoChart = new Chart(ctx, {
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
    $('#addDecesoForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addDecesoForm"]').click(function(e) {
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
            $('#addDecesoForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addDecesoForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addDecesoForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addDecesoForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addDecesoForm').collapse('hide');
    }
});
</script>

<!-- Registros Descarte -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_descarte WHERE bh_descarte_tagid = ? ORDER BY bh_descarte_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_descarte ORDER BY bh_descarte_fecha ASC");
        $stmt->execute();
    }
    
    $descarteData = [];
    $descarteFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process descarte data
    $descarteData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($descarteData as $row) {
        $date = new DateTime($row['bh_descarte_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_descarte_peso']);
        $descarteFechaLabels[] = $row['bh_descarte_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($descarteFechaLabels), null);
    foreach ($descarteFechaLabels as $index => $date) {
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
    $monthlyPriceData = array_fill(0, count($descarteFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_descarte_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_descarte_peso']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($descarteFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($descarteFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_descarte_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_descarte_peso']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($descarteFechaLabels as $index => $date) {
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

<!-- Descarte Table Section -->
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

    // Fetch all descarte records with animal name and total value calculation
    $descarteQuery = "SELECT p.*, 
                         v.nombre as animal_nombre                         
                  FROM bh_descarte p 
                  LEFT JOIN bufalino v ON p.bh_descarte_tagid = v.tagid 
                  ORDER BY p.bh_descarte_fecha DESC";
    $stmt = $conn->prepare($descarteQuery);
    $stmt->execute();
    $descarteResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<h3 class="container mt-4 text-white">DESCARTE</h3>

<!-- Descarte INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addDescarteForm">
    <div class="card card-body">
        <form id="descarteForm" action="process_descarte.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">peso</label>
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

<!-- Descarte Insertar Script-->
<script>
$(document).ready(function() {
    $('#descarteForm').on('submit', function(e) {
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
                
                fetch('./process_descarte.php', {
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
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
<!-- Descarte DataTable -->

<div class="table-responsive">
  <!-- Add New Descarte Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addDescarteForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="descarteTable" class="table table-striped table-bordered">
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
foreach ($descarteResult as $row) {
    echo "<tr>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_descarte_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_descarte_peso']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_descarte_fecha']) . "</td>";
    echo "<td class='text-center'>
            <button class='btn btn-success btn-sm edit-descarte'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-causa='" . htmlspecialchars($row['bh_descarte_peso']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_descarte_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editDescarteModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-descarte'
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
<!--  Descarte Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#descarteTable').DataTable({
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
<!-- Delete Descarte Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-descarte').forEach(button => {
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
                    fetch('./process_descarte.php', {
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
<!-- Edit Descarte Modal -->

<div class="modal fade" id="editDescarteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Descarte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editDescarteForm" action="process_descarte.php" method="POST">
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

<!-- Edit Descarte JS -->
<script>
    // Handle edit button click
    $('.edit-descarte').click(function() {
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
    $('#editDescarteForm').on('submit', function(e) {
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
                
                fetch('./process_descarte.php', {
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
                        $('#editDescarteModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
            <h5 class="card-title">Descartes</h5>
            <div class="chart-wrapper">
                <canvas id="descarteChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('descarteChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($descarteFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const descarteChart = new Chart(ctx, {
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
    $('#addDescarteForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addDescarteForm"]').click(function(e) {
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
            $('#addDescarteForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addDescarteForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addDescarteForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addDescarteForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addDescarteForm').collapse('hide');
    }
});
</script>

<!-- Registros Venta -->

<?php
try {
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $stmt = $conn->prepare("SELECT * FROM bh_venta WHERE bh_venta_tagid = ? ORDER BY bh_venta_fecha ASC");
        $stmt->execute([$_GET['search']]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM bh_venta ORDER BY bh_venta_fecha ASC");
        $stmt->execute();
    }
    
    $ventaData = [];
    $ventaFechaLabels = [];
    $monthlyWeights = [];
    $regressionLine = [];
    
    // Process venta data
    $ventaData = $stmt->fetchAll(); // Fetch all records at once
    foreach ($ventaData as $row) {
        $date = new DateTime($row['bh_venta_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyWeights[$monthKey])) {
            $monthlyWeights[$monthKey] = [];
        }
        $monthlyWeights[$monthKey][] = floatval($row['bh_venta_peso']);
        $ventaFechaLabels[] = $row['bh_venta_fecha'];
    }

    // Initialize and calculate monthly data
    $monthlyData = array_fill(0, count($ventaFechaLabels), null);
    foreach ($ventaFechaLabels as $index => $date) {
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
    $monthlyPriceData = array_fill(0, count($ventaFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_venta_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyPrices[$monthKey])) {
            $monthlyPrices[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $monthlyPrices[$monthKey]['sum'] += floatval($row['bh_venta_peso']);
        $monthlyPrices[$monthKey]['count']++;
    }

    foreach ($ventaFechaLabels as $index => $date) {
        $month = (new DateTime($date))->format('Y-m');
        if (isset($monthlyPrices[$month]) && $monthlyPrices[$month]['count'] > 0) {
            $monthlyPriceData[$index] = $monthlyPrices[$month]['sum'] / $monthlyPrices[$month]['count'];
        }
    }

    // Calculate monthly values
    $stmt->execute(); // Re-execute to reset the cursor
    $monthlyValues = [];
    $monthlyValueData = array_fill(0, count($ventaFechaLabels), null);

    while ($row = $stmt->fetch()) {
        $date = new DateTime($row['bh_venta_fecha']);
        $monthKey = $date->format('Y-m');

        if (!isset($monthlyValues[$monthKey])) {
            $monthlyValues[$monthKey] = ['sum' => 0, 'count' => 0];
        }

        $totalValue = floatval($row['bh_venta_peso']) * floatval($row['bh_venta_precio']);
        $monthlyValues[$monthKey]['sum'] += $totalValue;
        $monthlyValues[$monthKey]['count']++;
    }

    foreach ($ventaFechaLabels as $index => $date) {
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

<!-- Venta Table Section -->
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

    // Fetch all venta records with animal name and total value calculation
    $ventaQuery = "SELECT p.*, 
                         v.nombre as animal_nombre,
                         CAST((p.bh_venta_peso * p.bh_venta_precio) AS DECIMAL(10,2)) as total_value
                  FROM bh_venta p 
                  LEFT JOIN bufalino v ON p.bh_venta_tagid = v.tagid 
                  ORDER BY p.bh_venta_fecha DESC";
    $stmt = $conn->prepare($ventaQuery);
    $stmt->execute();
    $ventaResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<h3 class="container mt-4 text-white">VENTAS</h3>

<!-- Venta INSERT FORM -->

<div class="container table-section" style="display: block;">
<div class="collapse mb-3" id="addVentaForm">
    <div class="card card-body">
        <form id="ventaForm" action="process_venta.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <input type="hidden" name="tagid" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <div class="row g-3">                
                <div class="col-md-4">
                    <label class="form-label">Peso (Kg)</label>
                    <input type="number" step="0.01" class="form-control" name="peso" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Precio ($)</label>
                    <input type="number" step="0.01" class="form-control" name="precio" required>
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

<!-- Venta Insertar Script-->
<script>
$(document).ready(function() {
    $('#ventaForm').on('submit', function(e) {
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
                
                fetch('./process_venta.php', {
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
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
<!-- Venta DataTable -->

<div class="table-responsive">
  <!-- Add New Venta Form -->
  <button class="btn btn-success mb-3 text-center" type="button" data-bs-toggle="collapse" data-bs-target="#addVentaForm">
  <i class="fas fa-plus"></i> Registrar
  </button>
  <table id="ventaTable" class="table table-striped table-bordered">
      <thead>
          <tr>
              <th class="text-center">Numero</th>
              <th class="text-center">Nombre</th>
              <th class="text-center">Peso</th>
              <th class="text-center">Precio</th>
              <th class="text-center">Fecha</th>
              <th class="text-center">Acciones</th>

          </tr>
      </thead>
      <tbody>
<?php
// Display tables
foreach ($ventaResult as $row) {
    echo "<tr>";    
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_tagid']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['animal_nombre']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_peso']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_precio']) . "</td>";
    echo "<td class='text-center'>" . htmlspecialchars($row['bh_venta_fecha']) . "</td>";
    echo "<td class='text-center'>

            <button class='btn btn-success btn-sm edit-venta'
                    data-id='" . htmlspecialchars($row['id']) . "'
                    data-peso='" . htmlspecialchars($row['bh_venta_peso']) . "'
                    data-precio='" . htmlspecialchars($row['bh_venta_precio']) . "'
                    data-fecha='" . htmlspecialchars($row['bh_venta_fecha']) . "'
                    data-bs-toggle='modal'
                    data-bs-target='#editVentaModal'>
                <i class='fas fa-edit'></i>
            </button>
            <button class='btn btn-danger btn-sm delete-venta'
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
<!--  Venta Inicializacion DataTable -->
<script>
$(document).ready(function() {
    $('#ventaTable').DataTable({
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
                targets: [2,3], // Peso & Precio column
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
<!-- Delete Venta Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to all delete buttons
    document.querySelectorAll('.delete-venta').forEach(button => {
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
                    fetch('./process_venta.php', {
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
<!-- Edit Venta Modal -->

<div class="modal fade" id="editVentaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editVentaForm" action="process_venta.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="edit_id">
                    <input type="hidden" name="tagid" id="edit_tagid">                    
                    <div class="mb-3">
                        <label class="form-label">Peso (Kg)</label>
                        <input type="number" step="0.01" class="form-control" name="peso" id="edit_peso" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Precio ($)</label>
                        <input type="number" step="0.01" class="form-control" name="precio" id="edit_precio" required>
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

<!-- Edit Venta JS -->
<script>
    // Handle edit button click
    $('.edit-venta').click(function() {
        const button = $(this);

        // Get data from data attributes
        const id = button.data('id');
        const peso = button.data('peso');
        const precio = button.data('precio');
        const fecha = button.data('fecha');

        // Populate modal fields
        $('#edit_id').val(id);
        $('#edit_peso').val(peso);
        $('#edit_precio').val(precio);
        $('#edit_fecha').val(fecha);
    });

    // Handle form submission
    $('#editVentaForm').on('submit', function(e) {
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
                
                fetch('process_venta.php', {
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
                        $('#editVentaModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Actualizado!',
                            text: 'El registro ha sido actualizado exitosamente.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = data.redirect || 'bufalino_registrar_poblacion.php';
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
            <h5 class="card-title">Ventas</h5>
            <div class="chart-wrapper">
                <canvas id="ventaChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('ventaChart').getContext('2d');
    
    // Prepare data for the chart
    const labels = <?php echo json_encode($ventaFechaLabels); ?>;
    const monthlyData = <?php echo json_encode($monthlyData); ?>;
    const regressionLine = <?php echo json_encode($regressionLine); ?>;

    // Format dates for display
    const formattedLabels = labels.map(date => {
        const d = new Date(date);
        const month = d.toLocaleString('es-ES', { month: 'short' });
        const year = d.getFullYear().toString().slice(-2);
        return `${month} '${year}`;
    });

    const ventaChart = new Chart(ctx, {
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
    $('#addVentaForm').collapse('hide');

    // Handle the click on the button that opens the form
    $('[data-bs-toggle="collapse"][data-bs-target="#addVentaForm"]').click(function(e) {
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
            $('#addVentaForm').collapse('hide');
        } else {
            // Only toggle if there's a tagid
            $('#addVentaForm').collapse('toggle');
        }
    });

    // Also collapse form when search input is cleared
    $('#search').on('input', function() {
        if (!$(this).val().trim()) {
            $('#addVentaForm').collapse('hide');
        }
    });

    // Additional safety: prevent form from being shown if no tagid
    $('#addVentaForm').on('show.bs.collapse', function(e) {
        const tagid = $('#search').val().trim();
        if (!tagid) {
            e.preventDefault();
            $(this).collapse('hide');
        }
    });

    // Ensure form is hidden on page load if no tagid
    if (!$('#search').val().trim()) {
        $('#addVentaForm').collapse('hide');
    }
});
</script>
</body>
</html> 