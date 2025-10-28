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
<title>Bufalino Configuracion Melaza</title>
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
<!-- Icon Navigation Buttons -->

<!-- Add back button before the header container -->
<a href="./bufalino_configuracion.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>

<!-- Navigation Title -->
<nav class="navbar text-center" style="border: none !important; box-shadow: none !important;">
    <!-- Title Row -->
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-between align-items-center position-relative">
                <!-- Botón de Volver -->
                <button type="button" onclick="window.location.href='./inventario_bufalino.php'" class="btn" style="color:white; border: none; border-radius: 8px; padding: 8px 15px; z-index: 1050; position: relative;" title="Volver al Paso 1">
                    <i class="fas fa-arrow-left"></i> << Paso 1
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
        <div class="col-12 col-md-6 col-lg-4">
            <div class="d-flex justify-content-center">
                <div class="arrow-step arrow-step-active w-100" style="border-radius: 15px; clip-path: none;">
                    <span class="badge-active">🎯 Estás configurando Concentrado</span>
                    <div style="background: white; color: #17a2b8; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 2rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1.1rem;">CONFIGURACIÓN</h5>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Custom Professional CSS for Plan Melaza Table -->
<style>
/* Professional Plan Melaza Section Styling */
.plan-melaza-section {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e40af 100%);
    border-radius: 20px;
    padding: 2rem;
    margin: 2rem auto;
    box-shadow: 0 20px 60px rgba(30, 58, 138, 0.3);
    position: relative;
    overflow: hidden;
    max-width: 1200px;
    width: 90%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.plan-melaza-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.1) 50%, transparent 70%);
    pointer-events: none;
}

.plan-melaza-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: white;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    margin-bottom: 1rem;
    letter-spacing: 1px;
    position: relative;
    z-index: 1;
    text-align: center !important;
    width: 100%;
    display: block;
}

.plan-melaza-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0;
    text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
    position: relative;
    z-index: 1;
    text-align: center !important;
    width: 100%;
    display: block;
}

/* Enhanced Table Section */
.plan-melaza-table-section {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
    padding: 2.5rem;
    margin: 2rem auto;
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(59, 130, 246, 0.1);
    max-width: 1200px;
    width: 90%;
}

.plan-melaza-table-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, #f59e0b, #eab308, #84cc16, #22c55e, #06b6d4, #3b82f6, #8b5cf6);
    border-radius: 20px 20px 0 0;
}

/* Professional Table Styling */
#planMelazaTable {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    border: none !important;
    background: white;
}

#planMelazaTable thead th {
    background: linear-gradient(135deg, #f59e0b 0%, #eab308 50%, #f59e0b 100%);
    color: white;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    border: none !important;
    padding: 1.5rem 1rem;
    text-align: center;
    font-size: 0.9rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
}

#planMelazaTable thead th::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

#planMelazaTable thead th:hover::before {
    left: 100%;
}

#planMelazaTable tbody tr {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    background: white;
}

#planMelazaTable tbody tr:nth-child(odd) {
    background: linear-gradient(135deg, #fefefe 0%, #f8fafc 100%);
}

#planMelazaTable tbody tr:nth-child(even) {
    background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
}

#planMelazaTable tbody tr:hover {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #fbbf24 100%);
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(245, 158, 11, 0.25);
    border-radius: 8px;
}

#planMelazaTable tbody td {
    padding: 1.5rem 1rem;
    vertical-align: middle;
    border: 1px solid rgba(229, 231, 235, 0.5);
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

/* Stage Column Styling */
#planMelazaTable tbody td:first-child {
    background: linear-gradient(135deg, #e0f2fe 0%, #b3e5fc 100%);
    font-weight: 700;
    color: #0369a1;
    border-left: 4px solid #0ea5e9;
}

/* Product Column Styling */
#planMelazaTable tbody td:nth-child(2) {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    font-weight: 600;
    color: #166534;
    border-left: 4px solid #22c55e;
}

/* Ration Column Styling */
#planMelazaTable tbody td:nth-child(3) {
    background: linear-gradient(135deg, #fef7ff 0%, #fae8ff 100%);
    font-weight: 700;
    color: #7c2d12;
    font-size: 1.1rem;
    border-left: 4px solid #a855f7;
}

/* Weight Column Styling */
#planMelazaTable tbody td:nth-child(4) {
    background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
    font-weight: 700;
    color: #9a3412;
    font-size: 1.1rem;
    border-left: 4px solid #f97316;
}

/* Energy Column Styling */
#planMelazaTable tbody td:nth-child(5) {
    background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
    font-weight: 700;
    color: #991b1b;
    font-size: 1.1rem;
    border-left: 4px solid #ef4444;
}

/* Observations Column Styling */
#planMelazaTable tbody td:last-child {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    font-weight: 500;
    color: #374151;
    line-height: 1.6;
    border-left: 4px solid #64748b;
    font-style: italic;
}

/* Enhanced DataTables Buttons */
.dt-buttons {
    margin-bottom: 1.5rem;
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
    justify-content: center;
}

.dt-buttons .btn {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.dt-buttons .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.dt-buttons .btn:hover::before {
    left: 100%;
}

.dt-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

/* Responsive Enhancements */
@media (max-width: 768px) {
    .plan-melaza-title {
        font-size: 1.8rem;
    }
    
    .plan-melaza-section {
        padding: 1.5rem;
        margin: 1rem auto;
        width: 95%;
    }
    
    .plan-melaza-table-section {
        padding: 1.5rem;
        margin: 1rem auto;
        width: 95%;
    }
    
    #planMelazaTable tbody td {
        padding: 1rem 0.5rem;
        font-size: 0.9rem;
    }
    
    #planMelazaTable thead th {
        padding: 1rem 0.5rem;
        font-size: 0.8rem;
    }
}

/* Animation for table load */
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

.plan-melaza-table-section {
    animation: fadeInUp 0.8s ease-out;
}
</style>

<!-- PLAN MELAZA BUFALOS 2025 Section -->
<div class="container plan-melaza-section">
    <div class="text-center">
        <h3 class="plan-melaza-title">
            🧃 PLAN MELAZA BUFALOS 2025 – Venezuela
        </h3>
        <p class="plan-melaza-subtitle">
            Plan profesional de suplementación con melaza para diferentes etapas productivas
        </p>
    </div>
</div>

<!-- DataTable for Plan Melaza 2025 -->
<div class="container plan-melaza-table-section">
    <div class="table-responsive">
        <table id="planMelazaTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Etapa / Edad</th>
                    <th class="text-center">Producto Comercial (Venezuela)</th>
                    <th class="text-center">Ración diaria (Kg)</th>
                    <th class="text-center">Objetivo de Peso (Kg)</th>
                    <th class="text-center">Aporte Energético (Kcal/kg MS)</th>
                    <th class="text-center">Observaciones clave</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">Becerros (3–6 meses)</td>
                    <td class="text-center">Melaza Líquida Agropecuaria La Búfala</td>
                    <td class="text-center">0.5 – 0.8</td>
                    <td class="text-center">120 – 180</td>
                    <td class="text-center">~2,800</td>
                    <td class="text-start">Mezclar con afrecho de arroz o maíz. Estimula consumo de sólidos y flora ruminal</td>
                </tr>
                <tr>
                    <td class="text-center">Recría (6–18 meses)</td>
                    <td class="text-center">Melaza Cañera Mieles del Sur</td>
                    <td class="text-center">1.0 – 1.5</td>
                    <td class="text-center">250 – 400</td>
                    <td class="text-center">~2,800</td>
                    <td class="text-start">Ideal en mezcla con heno pobre. Mejora palatabilidad y conversión</td>
                </tr>
                <tr>
                    <td class="text-center">Engorde (>18 meses)</td>
                    <td class="text-center">Melaza Líquida Agropecuaria La Búfala</td>
                    <td class="text-center">2.0 – 3.0</td>
                    <td class="text-center">450 – 600</td>
                    <td class="text-center">~2,800</td>
                    <td class="text-start">Usar con núcleo proteico. Incrementa energía sin sobrecalentar</td>
                </tr>
                <tr>
                    <td class="text-center">Vientres gestantes</td>
                    <td class="text-center">Melaza Cañera Mieles del Sur</td>
                    <td class="text-center">1.5 – 2.0</td>
                    <td class="text-center">Mantener >500</td>
                    <td class="text-center">~2,800</td>
                    <td class="text-start">Apoyo energético en último tercio. Evita cetosis y mejora condición corporal</td>
                </tr>
                <tr>
                    <td class="text-center">Lactancia</td>
                    <td class="text-center">Melaza Líquida Agropecuaria La Búfala</td>
                    <td class="text-center">2.0 – 2.5</td>
                    <td class="text-center">Mantener >500</td>
                    <td class="text-center">~2,800</td>
                    <td class="text-start">Estimula producción láctea. Mezclar con fuente proteica y mineralización adecuada</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#planMelazaTable').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="fas fa-file-excel me-2"></i>Exportar Excel',
                className: 'btn btn-success btn-sm dt-button-professional',
                title: 'Plan Melaza Bufalos 2025 - Venezuela',
                filename: 'Plan_Melaza_Bufalos_2025_Venezuela',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf me-2"></i>Generar PDF',
                className: 'btn btn-danger btn-sm dt-button-professional',
                title: 'PLAN MELAZA BUFALOS 2025 - VENEZUELA',
                filename: 'Plan_Melaza_Bufalos_2025_Venezuela',
                orientation: 'landscape',
                pageSize: 'A3',
                customize: function(doc) {
                    doc.content[1].table.widths = ['15%', '25%', '15%', '15%', '15%', '15%'];
                    doc.styles.tableHeader.fontSize = 10;
                    doc.styles.tableHeader.bold = true;
                    doc.styles.tableHeader.alignment = 'center';
                    doc.styles.tableBodyEven.fontSize = 9;
                    doc.styles.tableBodyOdd.fontSize = 9;
                    doc.defaultStyle.fontSize = 9;
                    
                    // Add professional header
                    doc.content.splice(0, 0, {
                        text: '🧃 PLAN MELAZA BUFALOS 2025 - VENEZUELA',
                        style: 'title',
                        alignment: 'center',
                        fontSize: 16,
                        bold: true,
                        margin: [0, 0, 0, 20]
                    });
                    
                    doc.content.splice(1, 0, {
                        text: 'Plan profesional de suplementación con melaza para diferentes etapas productivas',
                        style: 'subtitle',
                        alignment: 'center',
                        fontSize: 12,
                        margin: [0, 0, 0, 15]
                    });
                },
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-2"></i>Imprimir Plan',
                className: 'btn btn-info btn-sm dt-button-professional',
                title: 'PLAN MELAZA BUFALOS 2025 - VENEZUELA',
                customize: function(win) {
                    $(win.document.body)
                        .css('font-size', '12pt')
                        .prepend(
                            '<div style="text-align:center; margin-bottom: 20px;">' +
                            '<h1 style="color: #1e3a8a; margin-bottom: 10px;">🧃 PLAN MELAZA BUFALOS 2025 - VENEZUELA</h1>' +
                            '<p style="color: #64748b; font-size: 14pt;">Plan profesional de suplementación con melaza para diferentes etapas productivas</p>' +
                            '</div>'
                        );
                        
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', '10pt');
                        
                    $(win.document.body).find('table th')
                        .css({
                            'background-color': '#f59e0b',
                            'color': 'white',
                            'text-align': 'center',
                            'padding': '8px',
                            'font-weight': 'bold'
                        });
                        
                    $(win.document.body).find('table td')
                        .css({
                            'padding': '6px',
                            'border': '1px solid #e5e7eb'
                        });
                }
            }
        ],
        columnDefs: [
            {
                targets: [0, 1, 2, 3, 4], // All centered columns
                className: 'text-center'
            },
            {
                targets: [5], // Observaciones column
                orderable: false,
                searchable: true,
                width: '25%',
                className: 'text-start',
                render: function(data, type, row) {
                    if (type === 'display') {
                        return '<div style="text-align: left;">' + data + '</div>';
                    }
                    return data;
                }
            }
        ]
    });
});
</script>

<!-- Add back button before the header container -->
<a href="./bufalino_configuracion.php" class="back-btn">
    <i class="fas fa-arrow-left"></i>
</a>
<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="section-historial-produccion-bufalino">
  CONFIGURACION MELAZA
  </h3>
</div> 
<!-- New Entry Modal Configuracion Melaza -->

<!-- Add New Vacuna Melaza Button -->
<div class="container my-3 text-center">
  <button type="button" class="btn btn-success text-center" data-bs-toggle="modal" data-bs-target="#newEntryModal">
    <i class="fas fa-plus-circle me-2"></i>Nueva Melaza
  </button>
</div>

<div class="modal fade" id="newEntryModal" tabindex="-1" aria-labelledby="newEntryModalLabel">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="newEntryModalLabel">
                  <i class="fas fa-plus-circle me-2"></i>Configurar Nueva Melaza
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form id="newMelazaForm">
              <input type="hidden" id="new_id" name="id" value="">
                  <div class="mb-4">                        
                      <div class="input-group">
                          <span class="input-group-text">
                              <i class="fa-solid fa-syringe"></i>
                              <label for="new_melaza" class="form-label">Melaza Producto</label>
                              <select class="form-select" id="new_melaza" name="melaza" required>
                                  <option value="">Seleccionar</option>
                                  <?php
                                  $sql_names = "SELECT DISTINCT bc_melaza_nombre FROM bc_melaza ORDER BY bc_melaza_nombre ASC";
                                  $stmt_names = $conn->prepare($sql_names);
                                  $stmt_names->execute();
                                  $names = $stmt_names->fetchAll(PDO::FETCH_ASSOC);
                                  foreach ($names as $name_row) {
                                      echo '<option value="' . htmlspecialchars($name_row['bc_melaza_nombre']) . '">' . htmlspecialchars($name_row['bc_melaza_nombre']) . '</option>';
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
                              <label for="new_etapa" class="form-label">Etapa</label>
                              <select class="form-select" id="new_etapa" name="etapa" required>
                                  <option value="">Seleccionar</option>
                                  <?php
                                  $sql_etapas = "SELECT DISTINCT bc_melaza_etapa FROM bc_melaza ORDER BY bc_melaza_etapa ASC";
                                  $stmt_etapas = $conn->prepare($sql_etapas);
                                  $stmt_etapas->execute();
                                  $etapas = $stmt_etapas->fetchAll(PDO::FETCH_ASSOC);
                                  foreach ($etapas as $etapa_row) {
                                      echo '<option value="' . htmlspecialchars($etapa_row['bc_melaza_etapa']) . '">' . htmlspecialchars($etapa_row['bc_melaza_etapa']) . '</option>';
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
                              <label for="new_racion" class="form-label">Racion (Kg)</label>
                              <input type="number" step="0.01" class="form-control" id="new_racion" name="racion" required>
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
                  <div class="mb-4">                        
                      <div class="input-group">
                          <span class="input-group-text">
                              <i class="fa-solid fa-calendar-days"></i>
                              <label for="new_vigencia" class="form-label">Vigencia (dias)</label>
                              <input type="number" class="form-control" id="new_vigencia" name="vigencia" required>
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
                    <th class="text-center">Melaza Producto</th>
                    <th class="text-center">Etapa</th>
                    <th class="text-center">Racion (Kg)</th>
                    <th class="text-center">Costo ($)</th>
                    <th class="text-center">Vigencia (dias)</th>                                 
                  </tr>
              </thead>
              <tbody>
                  <?php
                      $melazaQuery = "SELECT * FROM bc_melaza";

                      $stmt = $conn->prepare($melazaQuery);
                      $stmt->execute();
                      $melazasData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      if (empty($melazasData)) {
                          echo "<tr><td colspan='5' class='text-center'>No hay registros disponibles</td></tr>";
                      } else {
                          foreach ($melazasData as $row) {
                              echo "<tr>";
                              
                              // Column 0: Actions
                              echo '<td class="text-center">';
                              echo '    <div class="btn-group" role="group">';
                              echo '        <button class="btn btn-warning btn-sm edit-melaza" 
                                              data-id="' . htmlspecialchars($row['id'] ?? '') . '" 
                                              data-melaza="' . htmlspecialchars($row['bc_melaza_nombre'] ?? '') . '" 
                                              data-etapa="' . htmlspecialchars($row['bc_melaza_etapa'] ?? '') . '" 
                                              data-racion="' . htmlspecialchars($row['bc_melaza_racion'] ?? '') . '" 
                                              data-costo="' . htmlspecialchars($row['bc_melaza_costo'] ?? '') . '" 
                                              data-vigencia="' . htmlspecialchars($row['bc_melaza_vigencia'] ?? '') . '"
                                              title="Editar Configuracion Vacuna Melaza">
                                              <i class="fas fa-edit"></i>
                                          </button>';
                              echo '        <button class="btn btn-danger btn-sm delete-melaza" 
                                              data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                              title="Eliminar Configuracion Vacuna Melaza">
                                              <i class="fas fa-trash"></i>
                                          </button>';
                              echo '    </div>';
                              echo '</td>';
                              
                              // Column 1: Vacuna
                              echo "<td>" . htmlspecialchars($row['bc_melaza_nombre'] ?? '') . "</td>";
                              // Columna 2: Etapa
                              echo "<td>" . htmlspecialchars($row['bc_melaza_etapa'] ?? '') . "</td>";
                              
                              // Column 3: Dosis
                              echo "<td>" . htmlspecialchars($row['bc_melaza_racion'] ?? 'N/A') . "</td>";
                              
                              // Column 4: Costo
                              echo "<td>" . htmlspecialchars($row['bc_melaza_costo'] ?? 'N/A') . "</td>";
                              
                              // Column 5: Vigencia
                              echo "<td>" . htmlspecialchars($row['bc_melaza_vigencia'] ?? 'N/A') . "</td>";

                              echo "</tr>";
                          }
                      }
                  ?>
              </tbody>
          </table>
      </div>
</div>


<!-- Initialize DataTable for VH melaza -->
<script>
$(document).ready(function() {
    $('#melazaTable').DataTable({
        // Set initial page length
        pageLength: 5,
        
        // Configure length menu options
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "Todos"]
        ],
        
        // Order by Vigencia column descending (column index 4)
        order: [[5, 'desc']],
        
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
                 targets: [0], // Actions column
                 orderable: false,
                 searchable: false
             },
            {
                targets: [3, 4], // Dosis, Costo columns
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
                targets: [5], // Vigencia column
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
    // --- Initialize Modals Once --- 
    var newEntryModalElement = document.getElementById('newEntryModal');
    var newEntryModalInstance = new bootstrap.Modal(newEntryModalElement); 
    // Note: editMelazaModal is created dynamically later, so no need to initialize here.

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
            melaza: $('#new_melaza').val(),
            etapa: $('#new_etapa').val(),
            racion: $('#new_racion').val(),
            costo: $('#new_costo').val(),
            vigencia: $('#new_vigencia').val()
        };
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el alimento ${formData.melaza} con ración de ${formData.racion} kg?`,
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
                    url: 'process_configuracion_melaza.php',
                    type: 'POST',
                    data: {
                        action: 'insert',
                        melaza: formData.melaza,
                        etapa: formData.etapa,
                        racion: formData.racion,
                        costo: formData.costo,
                        vigencia: formData.vigencia
                    },
                    success: function(response) {
                        console.log('Success response:', response);
                        // Close the modal
                        newEntryModalInstance.hide();
                        
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
                        console.error('AJAX error:', xhr, status, error);
                        console.log('Request data:', {
                            action: 'insert',
                            melaza: formData.melaza,
                            etapa: formData.etapa,
                            racion: formData.racion,
                            costo: formData.costo,
                            vigencia: formData.vigencia
                        });
                        
                        // Show error message
                        let errorMsg = 'Error al procesar la solicitud';
                        
                        try {
                            const response = JSON.parse(xhr.responseText);
                            console.log('Error response:', response);
                            if (response.message) {
                                errorMsg = response.message;
                            }
                        } catch (e) {
                            console.error('Error parsing response:', e);
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
        var melaza = $(this).data('melaza');
        var etapa = $(this).data('etapa');
        var racion = $(this).data('racion');
        var costo = $(this).data('costo');
        var vigencia = $(this).data('vigencia');

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

        // Edit Configuracion Melaza Modal dialog for editing
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
                            <input type="hidden" id="edit_id" name="id" value="${id}">
                            <div class="mb-2">                                
                                    
                            <div class="mb-2">                            
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-syringe"></i>
                                        <label for="edit_melaza" class="form-label">Melaza</label>                                    
                                        <select class="form-select" id="edit_melaza" name="melaza" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            // Fetch distinct names from the database
                                            $sql_names = "SELECT DISTINCT bc_melaza_nombre FROM bc_melaza ORDER BY bc_melaza_nombre ASC";
                                            $stmt_names = $conn->prepare($sql_names);
                                            $stmt_names->execute();
                                            $names = $stmt_names->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($names as $name_row) {
                                                echo '<option value="' . htmlspecialchars($name_row['bc_melaza_nombre']) . '">' . htmlspecialchars($name_row['bc_melaza_nombre']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </span>                                    
                                </div>                                
                            </div>
                            <div class="mb-2">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-syringe"></i>
                                        <label for="edit_etapa" class="form-label">Etapa</label>                                    
                                        <select class="form-select" id="edit_etapa" name="etapa" required>
                                            <option value="">Seleccionar</option>
                                            <?php
                                            $sql_etapas = "SELECT DISTINCT bc_melaza_etapa FROM bc_melaza ORDER BY bc_melaza_etapa ASC";
                                            $stmt_etapas = $conn->prepare($sql_etapas);
                                            $stmt_etapas->execute();
                                            $etapas = $stmt_etapas->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($etapas as $etapa_row) {
                                                echo '<option value="' . htmlspecialchars($etapa_row['bc_melaza_etapa']) . '">' . htmlspecialchars($etapa_row['bc_melaza_etapa']) . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </span>                                    
                                </div>                                
                            </div>
                            <div class="mb-2">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa-solid fa-eye-dropper"></i>
                                        <label for="edit_racion" class="form-label">Racion (Kg)</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_racion" name="racion" value="${racion}" required>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">                                
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                        <label for="edit_costo" class="form-label">Costo ($)</label>
                                        <input type="number" step="0.01" class="form-control" id="edit_costo" name="costo" value="${costo}" required>
                                    </span>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-days"></i>
                                        <label for="edit_vigencia" class="form-label">Vigencia (dias)</label>
                                        <input type="number" class="form-control" id="edit_vigencia" name="vigencia" value="${vigencia}" required>
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
        
        // Handle save button click
        $('#saveEditMelaza').click(function() {
            // Create a form object to properly validate
            var form = document.getElementById('editMelazaForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            var formData = {
                id: $('#edit_id').val(),
                melaza: $('#edit_melaza').val(),
                etapa: $('#edit_etapa').val(),
                racion: $('#edit_racion').val(),
                costo: $('#edit_costo').val(),
                vigencia: $('#edit_vigencia').val()
            };
            
            console.log('Save changes clicked. Form Data being sent:', formData); // Debug log 2
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar la configuracion de melaza?`,
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
                        url: 'process_configuracion_melaza.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            melaza: formData.melaza,
                            etapa: formData.etapa,
                            racion: formData.racion,
                            costo: formData.costo,
                            vigencia: formData.vigencia
                        },
                        success: function(response) {
                            console.log('Update success response:', response);
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
                            console.error('Update AJAX error:', xhr, status, error);
                            console.log('Update request data:', {
                                action: 'update',
                                id: formData.id,
                                melaza: formData.melaza,
                                etapa: formData.etapa,
                                racion: formData.racion,
                                costo: formData.costo,
                                vigencia: formData.vigencia
                            });
                            
                            // Show error message
                            let errorMsg = 'Error al procesar la solicitud';
                            
                            try {
                                const response = JSON.parse(xhr.responseText);
                                console.log('Update error response:', response);
                                if (response.message) {
                                    errorMsg = response.message;
                                }
                            } catch (e) {
                                console.error('Error parsing update response:', e);
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
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar registro?',
            text: `¿Está seguro de que desea eliminar la configuracion de melaza? Esta acción no se puede deshacer.`,
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
                    url: 'process_configuracion_melaza.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        id: id
                    },
                    success: function(response) {
                        console.log('Delete success response:', response);
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
                        console.error('Delete AJAX error:', xhr, status, error);
                        console.log('Delete request data:', {
                            action: 'delete',
                            id: id
                        });
                        
                        // Show error message
                        let errorMsg = 'Error al procesar la solicitud';
                        
                        try {
                            const response = JSON.parse(xhr.responseText);
                            console.log('Delete error response:', response);
                            if (response.message) {
                                errorMsg = response.message;
                            }
                        } catch (e) {
                            console.error('Error parsing delete response:', e);
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
    $(document).on('click', '.register-new-melaza-btn', function() { 
        // Get tagid from the button's data-tagid-prefill attribute
        var tagid = $(this).data('tagid-prefill'); 
        
        // Clear previous data in the modal
        $('#newMelazaForm')[0].reset();
        $('#new_id').val(''); // Ensure ID is cleared
        
      
        
        // Show the new entry modal using the existing instance
        newEntryModalInstance.show(); 
    });
});
</script>
</body>
</html>