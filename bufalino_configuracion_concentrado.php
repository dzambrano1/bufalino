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
<title>bufalino PLAN ALIMENTO CONCENTRADO</title>
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

<!-- Professional Modal Styling -->
<style>
/* Professional Modal Styling */
.modal {
    backdrop-filter: blur(8px);
    background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    transform: scale(0.95);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modal.show .modal-content {
    transform: scale(1);
}

.modal-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-bottom: none;
    padding: 1.5rem 2rem;
    position: relative;
}

.modal-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.9) 0%, rgba(5, 150, 105, 0.9) 100%);
    z-index: -1;
}

.modal-title {
    font-weight: 600;
    font-size: 1.25rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.modal-title i {
    font-size: 1.4rem;
    color: #6b7280;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.btn-close {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    padding: 0.5rem;
    transition: all 0.3s ease;
    filter: brightness(0) invert(1);
}

.btn-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.modal-body {
    padding: 2rem;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.input-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.input-group-text {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    font-weight: 600;
    padding: 0.75rem 1rem;
    border-radius: 12px 0 0 12px;
    min-width: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.input-group-text i {
    font-size: 1.1rem;
    color: #6b7280;
}

.form-control,
.form-select {
    border: 2px solid #e5e7eb;
    border-radius: 0 12px 12px 0;
    padding: 0.875rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.form-control:focus,
.form-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1), 0 4px 16px rgba(16, 185, 129, 0.2);
    outline: none;
    transform: translateY(-2px);
}

.form-control::placeholder {
    color: #9ca3af;
    font-style: italic;
}

.modal-footer {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-top: 1px solid #e5e7eb;
    padding: 1.5rem 2rem;
    gap: 1rem;
}

.modal-footer .btn {
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    position: relative;
    overflow: hidden;
}

.modal-footer .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.modal-footer .btn:hover::before {
    left: 100%;
}

.btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(107, 114, 128, 0.4);
}

.btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

/* Special styling for the new concentrado button */
.new-concentrado-btn {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    position: relative;
    overflow: hidden;
}

.new-concentrado-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.new-concentrado-btn:hover::before {
    left: 100%;
}

.new-concentrado-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4);
}

.new-concentrado-btn i {
    color: #6b7280;
    margin-right: 0.5rem;
    font-size: 1.2rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .modal-dialog {
        margin: 1rem;
    }
    
    .modal-header,
    .modal-body,
    .modal-footer {
        padding: 1rem;
    }
    
    .modal-title {
        font-size: 1.1rem;
    }
    
    .form-control,
    .form-select {
        padding: 0.75rem;
        font-size: 0.95rem;
    }
    
    .modal-footer .btn {
        padding: 0.75rem 1.5rem;
        font-size: 0.9rem;
    }
}

/* Animation for modal appearance */
@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.modal.show .modal-content {
    animation: modalSlideIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Enhanced form validation styling */
.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-control.is-valid,
.form-select.is-valid {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

/* Loading state for buttons */
.btn.loading {
    position: relative;
    color: transparent;
}

.btn.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Enhanced table styling */
.table-section {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    margin-top: 2rem;
    margin-bottom: 2rem;
}

.table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
}

.table thead th {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    padding: 1rem;
    text-align: center;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: rgba(16, 185, 129, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
    border-color: #e5e7eb;
}

/* Enhanced button styling for table actions */
.btn-group .btn {
    border-radius: 8px;
    margin: 0 2px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    color: white;
}

/* Enhanced DataTable styling */
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter,
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    margin: 1rem 0;
}

.dataTables_wrapper .dataTables_filter input {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 0.5rem 1rem;
    transition: all 0.3s ease;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    outline: none;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px;
    margin: 0 2px;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white !important;
    border-color: #10b981;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white !important;
    border-color: #10b981;
}

/* Container styling */
.container {
    max-width: 1400px;
}

/* Header styling */
.container h3 {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Back button styling */
.back-btn {
    position: fixed;
    top: 20px;
    left: 20px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1000;
}

.back-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 12px 30px rgba(16, 185, 129, 0.4);
    color: white;
}

.back-btn i {
    font-size: 1.2rem;
    color: #6b7280;
}

/* Specific styling for newEntryModal */
#newEntryModal .modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 25px 70px rgba(16, 185, 129, 0.3);
}

#newEntryModal .modal-header {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border-radius: 20px 20px 0 0;
    padding: 2rem;
}

#newEntryModal .modal-title {
    font-size: 1.4rem;
    font-weight: 700;
}

#newEntryModal .modal-title i {
    font-size: 1.6rem;
    color: #6b7280;
    text-shadow: 0 3px 6px rgba(0, 0, 0, 0.4);
}

#newEntryModal .modal-body {
    padding: 2.5rem;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}

#newEntryModal .form-label {
    font-size: 1rem;
    font-weight: 700;
    color: #166534;
    margin-bottom: 0.5rem;
    display: inline-block;
    width: 120px;
    text-align: right;
    margin-right: 1rem;
    vertical-align: top;
    padding-top: 0.5rem;
}

#newEntryModal .input-group {
    display: inline-flex;
    width: calc(100% - 140px);
    margin-bottom: 1.5rem;
}

#newEntryModal .input-group-text {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    border: none;
    color: white;
    font-weight: 700;
    padding: 0.75rem 1rem;
    border-radius: 12px 0 0 12px;
    min-width: 50px;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

#newEntryModal .input-group-text i {
    font-size: 1.1rem;
    color: #6b7280;
}

#newEntryModal .form-control,
#newEntryModal .form-select {
    border: 2px solid #d1fae5;
    border-radius: 0 12px 12px 0;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    background: white;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    flex: 1;
}

#newEntryModal .form-control:focus,
#newEntryModal .form-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15), 0 4px 16px rgba(16, 185, 129, 0.2);
    transform: translateY(-2px);
}

#newEntryModal .modal-footer {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-top: 2px solid #bbf7d0;
    padding: 2rem;
    border-radius: 0 0 20px 20px;
}

#newEntryModal .btn {
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

#newEntryModal .btn-secondary {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

#newEntryModal .btn-secondary:hover {
    background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(107, 114, 128, 0.4);
}

#newEntryModal .btn-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

#newEntryModal .btn-success:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.4);
}

/* Enhanced animations for newEntryModal */
#newEntryModal .modal-content {
    animation: modalSlideInEnhanced 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes modalSlideInEnhanced {
    from {
        opacity: 0;
        transform: translateY(-100px) scale(0.8);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Special focus effects for newEntryModal inputs */
#newEntryModal .input-group:focus-within .input-group-text {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
}

#newEntryModal .form-control:focus,
#newEntryModal .form-select:focus {
    background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
}

/* Responsive adjustments for newEntryModal */
@media (max-width: 768px) {
    #newEntryModal .form-label {
        width: 100%;
        text-align: left;
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
    
    #newEntryModal .input-group {
        width: 100%;
        margin-bottom: 1rem;
    }
}
</style>

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



<div class="container text-center">
  <h3  class="container mt-4 text-white" class="collapse" id="section-historial-produccion-bufalino">
  CONFIGURACION PRODUCTOS ALIMENTOS CONCENTRADOS
  </h3>
  <p class="text-dark-50 text-center mb-4">Esta tabla muestra la configuración de productos alimenticios concentrados</p>
</div> 

<!-- Add New Concentrado Button -->
<div class="container my-3 d-flex justify-content-center">
  <button type="button" class="new-concentrado-btn" data-bs-toggle="modal" data-bs-target="#newEntryModal" >
    <i class="fas fa-plus-circle me-2"></i>Nuevo Concentrado
  </button>
</div>

<div class="modal fade" id="newEntryModal" tabindex="-1" aria-labelledby="newEntryModalLabel">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="newEntryModalLabel">
                  <i class="fas fa-plus-circle me-2"></i>Configurar Nuevo Concentrado
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
                    <form id="newConcentradoForm">
                            <input type="hidden" id="new_id" name="id" value="">
                            
                            <div class="mb-3">
                                <label for="new_concentrado" class="form-label">Alimento</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-utensils"></i>
                                    </span>
                                    <input type="text" class="form-control" id="new_concentrado" name="concentrado" placeholder="Nombre del alimento" required>
                                </div>                                
                            </div>
                            
                            <div class="mb-3">                            
                                <label for="new_etapa" class="form-label">Etapa</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-layer-group"></i>
                                    </span>
                                    <select class="form-select" id="new_etapa" name="etapa" required>
                                        <option value="">Seleccionar etapa</option>
                                        <?php
                                        // Fetch distinct names from the database
                                        $sql_etapas = "SELECT DISTINCT bc_etapas_nombre FROM bc_etapas ORDER BY bc_etapas_nombre ASC";
                                        $stmt_etapas = $conn->prepare($sql_etapas);
                                        $stmt_etapas->execute();
                                        $etapas = $stmt_etapas->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($etapas as $etapa_row) {
                                            echo '<option value="' . htmlspecialchars($etapa_row['bc_etapas_nombre']) . '">' . htmlspecialchars($etapa_row['bc_etapas_nombre']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>                                
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_costo" class="form-label">Costo ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-money-bill-1-wave"></i>
                                    </span>
                                    <input type="number" step="0.01" class="form-control" id="new_costo" name="costo" placeholder="0.00" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="new_vigencia" class="form-label">Vigencia (días)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-days"></i>
                                    </span>
                                    <input type="number" class="form-control" id="new_vigencia" name="vigencia" placeholder="0" required>
                                </div>
                            </div>
                        </form>
          </div>
          <div class="modal-footer btn-group">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="fas fa-times me-1"></i>Cancelar
              </button>
              <button type="button" class="btn btn-success" id="saveNewConcentrado">
                  <i class="fas fa-save me-1"></i>Guardar
              </button>
          </div>
      </div>
  </div>
</div>

  <!-- DataTable for ah_concentrado records -->
  <div class="container table-section" style="display: block;">
      <div class="table-responsive">
          <table id="concentradoTable" class="table table-striped table-bordered">
              <thead>
                  <tr>
                    <th class="text-center">Acciones</th>
                    <th class="text-center">Producto</th>
                    <th class="text-center">Etapa</th>
                    <th class="text-center">Costo ($/kg)</th>
                    <th class="text-center">Vigencia (dias)</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                      $concentradoQuery = "SELECT * FROM bc_concentrado";
                      
                      try {
                          $stmt = $conn->prepare($concentradoQuery);
                          $stmt->execute();
                          $concentradosData = $stmt->fetchAll(PDO::FETCH_ASSOC);

                          if (empty($concentradosData)) {
                              echo "<tr><td colspan='5' class='text-center'>No hay registros disponibles</td></tr>";
                          } else {
                              foreach ($concentradosData as $row) {
                              echo "<tr>";
                              
                              // Column 0: Actions
                              echo '<td class="text-center">';
                              echo '    <div class="btn-group" role="group">';
                              echo '        <button class="btn btn-warning edit-concentrado" 
                                              data-id="' . htmlspecialchars($row['id'] ?? '') . '" 
                                              data-concentrado="' . htmlspecialchars($row['bc_concentrado_nombre'] ?? '') . '" 
                                              data-etapa="' . htmlspecialchars($row['bc_concentrado_etapa'] ?? '') . '"
                                              data-costo="' . htmlspecialchars($row['bc_concentrado_costo'] ?? '') . '" 
                                              data-vigencia="' . htmlspecialchars($row['bc_concentrado_vigencia'] ?? '') . '"
                                              title="Editar Configuración Concentrado">
                                              <i class="fas fa-edit"></i>
                                          </button>';
                              echo '        <button class="btn btn-danger btn-sm delete-concentrado" 
                                              data-id="' . htmlspecialchars($row['id'] ?? '') . '"
                                              title="Eliminar Configuración Concentrado">
                                              <i class="fas fa-trash"></i>
                                          </button>';
                              echo '    </div>';
                              echo '</td>';
                              
                              // Column 1: Producto
                              echo "<td>" . htmlspecialchars($row['bc_concentrado_nombre'] ?? '') . "</td>";
                              // Column 2: Etapa
                              echo "<td>" . htmlspecialchars($row['bc_concentrado_etapa'] ?? '') . "</td>";
                              // Column 3: Costo
                              echo "<td>" . htmlspecialchars($row['bc_concentrado_costo'] ?? 'N/A') . "</td>";
                              // Column 4: Vigencia
                              echo "<td>" . htmlspecialchars($row['bc_concentrado_vigencia'] ?? 'N/A') . "</td>";
                              echo "</tr>";
                          }
                      }
                  } catch (PDOException $e) {
                      echo "<tr><td colspan='5' class='text-center text-danger'>Error al cargar datos: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                  }
                  ?>
              </tbody>
          </table>
      </div>
</div>

<!-- Initialize DataTable for concentradoTable -->
<script>
$(document).ready(function() {
    $('#concentradoTable').DataTable({
        // Set initial page length
        pageLength: 10,
        
        // Configure length menu options
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todos"]
        ],
        
        // Order by Producto column ascending (column index 1)
        order: [[1, 'asc']],
        
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
        
        // Column specific settings for 5 columns
        columnDefs: [
            {
                targets: [0], // Actions column
                orderable: false,
                searchable: false,
                width: '120px'
            },
            {
                targets: [1, 2], // Producto, Etapa columns
                orderable: true,
                searchable: true
            },
            {
                targets: [3], // Costo column
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    if (type === 'display' && data !== 'N/A' && data !== 'No Registrado') {
                        // Attempt to parse only if data looks like a number
                        const num = parseFloat(data);
                        if (!isNaN(num)) {
                            return '$' + num.toLocaleString('es-ES', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }
                    return data; // Return original data if not display or not a valid number
                }
            },
            {
                targets: [4], // Vigencia column
                orderable: true,
                searchable: true,
                render: function(data, type, row) {
                    if (type === 'display' && data !== 'N/A' && data !== 'No Registrado') {
                        // Attempt to parse only if data looks like a number
                        const num = parseFloat(data);
                        if (!isNaN(num)) {
                            return num.toLocaleString('es-ES', {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0
                            }) + ' días';
                        }
                    }
                    return data; // Return original data if not display or not a valid number
                }
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
    // Note: editConcentradoModal is created dynamically later, so no need to initialize here.

    // Handle new entry form submission
    $('#saveNewConcentrado').click(function() {
        console.log('Save button clicked'); // Debug log
        
        // Validate the form
        var form = document.getElementById('newConcentradoForm');
        if (!form.checkValidity()) {
            console.log('Form validation failed'); // Debug log
            form.reportValidity();
            return;
        }
        
        // Get form data
        var formData = {
            action: 'create',
            concentrado: $('#new_concentrado').val().trim(),
            etapa: $('#new_etapa').val().trim(),
            costo: $('#new_costo').val().trim(),
            vigencia: $('#new_vigencia').val().trim()
        };
        
        console.log('Form data collected:', formData); // Debug log
        
        // Validate that all fields have values
        if (!formData.concentrado || !formData.etapa || !formData.costo || !formData.vigencia) {
            Swal.fire({
                title: 'Error de Validación',
                text: 'Por favor complete todos los campos requeridos',
                icon: 'warning',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        // Show confirmation dialog using SweetAlert2
        Swal.fire({
            title: '¿Confirmar registro?',
            text: `¿Desea registrar el alimento ${formData.concentrado} ?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#dc3545',
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('User confirmed, sending AJAX request'); // Debug log
                
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
                    url: 'process_configuracion_concentrado.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log('Success response:', response);
                        
                        // Close the modal
                        newEntryModalInstance.hide();
                        
                        // Clear the form
                        $('#newConcentradoForm')[0].reset();
                        
                        // Show success message
                        Swal.fire({
                            title: '¡Registro exitoso!',
                            text: 'El registro de concentrado ha sido guardado correctamente',
                            icon: 'success',
                            confirmButtonColor: '#28a745'
                        }).then(() => {
                            // Reload the page to show updated data
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', xhr, status, error);
                        console.log('Request data:', formData);
                        console.log('Response text:', xhr.responseText);
                        
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
    $('.edit-concentrado').click(function() {
        var id = $(this).data('id');
        var concentrado = $(this).data('concentrado');
        var etapa = $(this).data('etapa');
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

        // Edit PLAN ALIMENTO CONCENTRADO Modal dialog for editing
        var modalHtml = `
        <div class="modal fade" id="editConcentradoModal" tabindex="-1" aria-labelledby="editConcentradoModalLabel">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editConcentradoModalLabel">
                            <i class="fas fa-edit me-2"></i>Editar Concentrado
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editConcentradoForm">
                            <input type="hidden" id="edit_id" name="id" value="${id}">
                            <div class="mb-3">
                                <label for="edit_concentrado" class="form-label">Alimento</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-utensils"></i>
                                    </span>
                                    <input type="text" class="form-control" id="edit_concentrado" name="concentrado" value="${concentrado}" placeholder="Nombre del alimento" required>
                                </div>                                
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_etapa" class="form-label">Etapa</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-layer-group"></i>
                                    </span>
                                    <select class="form-select" id="edit_etapa" name="etapa" required>
                                        <option value="">Seleccionar etapa</option>
                                        <?php
                                        $sql_etapas = "SELECT DISTINCT bc_etapas_nombre FROM bc_etapas ORDER BY bc_etapas_nombre ASC";
                                        $stmt_etapas = $conn->prepare($sql_etapas);
                                        $stmt_etapas->execute();
                                        $etapas = $stmt_etapas->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($etapas as $etapa_row) {
                                            echo '<option value="' . htmlspecialchars($etapa_row['bc_etapas_nombre']) . '">' . htmlspecialchars($etapa_row['bc_etapas_nombre']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>                                
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_costo" class="form-label">Costo ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-money-bill-1-wave"></i>
                                    </span>
                                    <input type="number" step="0.01" class="form-control" id="edit_costo" name="costo" value="${costo}" placeholder="0.00" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="edit_vigencia" class="form-label">Vigencia (días)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-days"></i>
                                    </span>
                                    <input type="number" class="form-control" id="edit_vigencia" name="vigencia" value="${vigencia}" placeholder="0" required>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer btn-group">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="button" class="btn btn-success" id="saveEditConcentrado">
                            <i class="fas fa-save me-1"></i>Guardar Cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>`;
        
        // Remove any existing modal
        $('#editConcentradoModal').remove();
        
        // Add the modal to the page
        $('body').append(modalHtml);
        
        // Show the modal
        var editModal = new bootstrap.Modal(document.getElementById('editConcentradoModal'));
        editModal.show();
        
        // Set the selected values in the form
        $('#edit_concentrado').val(concentrado);
        $('#edit_etapa').val(etapa);
        
        // Handle save button click
        $('#saveEditConcentrado').click(function() {
            // Create a form object to properly validate
            var form = document.getElementById('editConcentradoForm');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            var formData = {
                id: $('#edit_id').val(),
                concentrado: $('#edit_concentrado').val(),
                etapa: $('#edit_etapa').val(),
                costo: $('#edit_costo').val(),
                vigencia: $('#edit_vigencia').val()
            };
            
            console.log('Save changes clicked. Form Data being sent:', formData); // Debug log 2
            
            // Show confirmation dialog
            Swal.fire({
                title: '¿Guardar cambios?',
                text: `¿Desea actualizar la configuracion de concentrado?`,
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
                        url: 'process_configuracion_concentrado.php',
                        type: 'POST',
                        data: {
                            action: 'update',
                            id: formData.id,
                            concentrado: formData.concentrado,
                            etapa: formData.etapa,
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
                                concentrado: formData.concentrado,
                                etapa: formData.etapa,
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
    $('.delete-concentrado').click(function() {
        var id = $(this).data('id');
        
        // Confirm before deleting using SweetAlert2
        Swal.fire({
            title: '¿Eliminar registro?',
            text: `¿Está seguro de que desea eliminar la configuracion de concentrado? Esta acción no se puede deshacer.`,
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
                    url: 'process_configuracion_concentrado.php',
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
    $(document).on('click', '.register-new-concentrado-btn', function() { 
        // Get tagid from the button's data-tagid-prefill attribute
        var tagid = $(this).data('tagid-prefill'); 
        
        // Clear previous data in the modal
        $('#newConcentradoForm')[0].reset();
        $('#new_id').val(''); // Ensure ID is cleared
        
      
        
        // Show the new entry modal using the existing instance
        newEntryModalInstance.show(); 
    });

    // Enhanced modal interactions
    $(document).ready(function() {
        // Add loading states to buttons
        $('#saveNewConcentrado, #saveEditConcentrado').click(function() {
            var $btn = $(this);
            var originalText = $btn.html();
            
            $btn.addClass('loading').prop('disabled', true);
            
            // Re-enable button after form submission (handled by existing code)
            setTimeout(function() {
                $btn.removeClass('loading').prop('disabled', false).html(originalText);
            }, 3000);
        });

        // Enhanced form validation with visual feedback
        $('.form-control, .form-select').on('input change', function() {
            var $input = $(this);
            var isValid = $input[0].checkValidity();
            
            $input.removeClass('is-valid is-invalid');
            
            if (isValid && $input.val().trim() !== '') {
                $input.addClass('is-valid');
            } else if ($input.val().trim() !== '') {
                $input.addClass('is-invalid');
            }
        });

        // Smooth modal animations
        $('.modal').on('show.bs.modal', function() {
            $(this).find('.modal-content').css('transform', 'scale(0.95)');
        });

        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.modal-content').css('transform', 'scale(1)');
        });

        // Enhanced close button interactions
        $('.btn-close').hover(
            function() {
                $(this).css('transform', 'rotate(90deg) scale(1.1)');
            },
            function() {
                $(this).css('transform', 'rotate(0deg) scale(1)');
            }
        );

        // Add focus management for accessibility
        $('.modal').on('shown.bs.modal', function() {
            $(this).find('.form-control:first').focus();
        });

        // Enhanced input group interactions
        $('.input-group').hover(
            function() {
                $(this).find('.input-group-text').css('box-shadow', '0 6px 16px rgba(16, 185, 129, 0.4)');
            },
            function() {
                $(this).find('.input-group-text').css('box-shadow', '0 4px 12px rgba(16, 185, 129, 0.3)');
            }
        );
    });
});
</script>
<!-- Cattle Daily Portion Calculator Section -->
<div class="container text-center mt-5">
    <h3 class="container mt-4 text-white">
        CALCULADORA RACION DIARIA Vs RETORNO INVERSION
    </h3>
    <p class="text-dark-50 text-center mb-4">Herramienta de asesoría financiera para determinar la inversión óptima en alimentación concentrada</p>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- Calculator Form -->
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Parámetros de Cálculo</h5>
                </div>
                <div class="card-body">
                    <form id="cattleCalculatorForm">
                        <div class="mb-3">
                            <label for="peso_inicial" class="form-label">Peso Inicial (kg) (Usar 0 si nacio en el corral)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                <input type="number" step="0.1" class="form-control" id="peso_inicial" name="peso_inicial" placeholder="0.0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="precio_kg_inicial" class="form-label">Precio en pie inicial ($/kg)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input type="number" step="0.01" class="form-control" id="precio_kg_inicial" name="precio_kg_inicial" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="peso_final" class="form-label">Peso final (kg)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-weight"></i></span>
                                <input type="number" step="0.1" class="form-control" id="peso_final" name="peso_final" placeholder="0.0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="precio_kg_final" class="form-label">Precio en pie final ($/kg)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input type="number" step="0.1" class="form-control" id="precio_kg_final" name="precio_kg_final" placeholder="0.0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="duracion_dias" class="form-label">Periodo de Evaluación (días)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-calendar-days"></i></span>
                                <input type="number" class="form-control" id="duracion_dias" name="duracion_dias" placeholder="0" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="sistema_ganadero" class="form-label">Sistema Ganadero</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-cow"></i></span>
                                <select class="form-select" id="sistema_ganadero" name="sistema_ganadero" required>
                                    <option value="">Seleccionar sistema</option>
                                    <option value="extensivo" data-forraje="90" data-concentrado="10" data-fcr="9.5">Extensivo (90% Forraje, 10% Concentrado, FCR: 9.5)</option>
                                    <option value="semi-intensivo" data-forraje="70" data-concentrado="30" data-fcr="8.0">Semi-Intensivo (70% Forraje, 30% Concentrado, FCR: 8.0)</option>
                                    <option value="intensivo" data-forraje="50" data-concentrado="50" data-fcr="6.5">Intensivo (50% Forraje, 50% Concentrado, FCR: 6.5)</option>
                                    <option value="feedlot" data-forraje="30" data-concentrado="70" data-fcr="5.5">Intensivo Avanzado (30% Forraje, 70% Concentrado, FCR: 5.5)</option>
                                    <option value="feedlot-extremo" data-forraje="10" data-concentrado="90" data-fcr="5.0">Feedlot Extremo (10% Forraje, 90% Concentrado, FCR: 5.0)</option>
                                    <option value="personalizado" data-forraje="0" data-concentrado="0" data-fcr="0">🔧 Personalizado</option>
                                </select>
                            </div>
                            <small class="form-text text-muted">Seleccione el sistema ganadero según su operación. El FCR se ajustará automáticamente.</small>
                        </div>
                        
                        <div class="mb-3" id="fcr_personalizado_container" style="display: none;">
                            <label for="fcr_ajustable" class="form-label">FCR Personalizado - Rango: 4.5 - 10.5</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-exchange-alt"></i></span>
                                <input type="number" step="0.1" class="form-control" id="fcr_ajustable" name="fcr_ajustable" placeholder="6.5" min="4.5" max="10.5" value="6.5">
                                <button class="btn btn-outline-info" type="button" id="optimizeFcrBtn" title="Calcular FCR Óptimo">
                                    <i class="fas fa-magic"></i> Óptimo
                                </button>
                            </div>
                            <small class="form-text text-muted">Menor FCR = más eficiente. Use "Óptimo" para calcular el FCR que maximiza ROI.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="costo_alimento_kg" class="form-label">Costo Alimento (kg/$)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
                                <input type="number" step="0.01" class="form-control" id="costo_alimento_kg" name="costo_alimento_kg" placeholder="0.00" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-success" id="calculateBtn">
                                <i class="fas fa-calculator me-2"></i>RETORNO INVERSION
                            </button>
                            <button type="button" class="btn btn-secondary" id="clearBtn">
                                <i class="fas fa-eraser me-2"></i>Limpiar Formulario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Results Display -->
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Resultados del Análisis</h5>
                </div>
                <div class="card-body" id="resultsContainer">
                    <div class="text-center text-muted" id="noResultsMessage">
                        <i class="fas fa-info-circle fa-3x mb-3"></i>
                        <p>Complete el formulario y presione "Calcular ROI" para ver los resultados del análisis financiero.</p>
                    </div>
                    
                    <div id="calculationResults" style="display: none;">
                        <!-- Step-by-step calculation results will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Calculate button click handler
    $('#calculateBtn').click(function() {
        calculateCattleROI();
    });
    
    // Clear button click handler
    $('#clearBtn').click(function() {
        $('#cattleCalculatorForm')[0].reset();
        $('#fcr_ajustable').val('4.5'); // Reset FCR to default
        $('#calculationResults').hide();
        $('#noResultsMessage').show();
    });
    
    // Optimize FCR button click handler
    $('#optimizeFcrBtn').click(function() {
        const pesoInicial = parseFloat($('#peso_inicial').val()) || 0;
        const precioKgInicial = parseFloat($('#precio_kg_inicial').val()) || 0;
        const pesoFinal = parseFloat($('#peso_final').val()) || 0;
        const precioKgFinal = parseFloat($('#precio_kg_final').val()) || 0;
        const costoAlimentoKg = parseFloat($('#costo_alimento_kg').val()) || 0;
        
        // Check if we have enough data to optimize
        if (pesoInicial === 0 || pesoFinal === 0 || precioKgFinal === 0 || costoAlimentoKg === 0) {
            Swal.fire({
                title: 'Datos Insuficientes',
                text: 'Complete peso inicial, peso final, precio final y costo del alimento para calcular el FCR óptimo.',
                icon: 'warning',
                confirmButtonColor: '#ffc107'
            });
            return;
        }
        
        const kgGanados = pesoFinal - pesoInicial;
        if (kgGanados <= 0) {
            Swal.fire({
                title: 'Error de Datos',
                text: 'El peso final debe ser mayor al peso inicial.',
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
            return;
        }
        
        // Calculate optimal FCR (minimize cost while maximizing gain)
        // The optimal FCR is the one that maximizes ROI
        let bestFcr = 4.5;
        let bestRoi = -1000;
        
        for (let testFcr = 3.5; testFcr <= 6.0; testFcr += 0.1) {
            const alimentoConsumido = kgGanados * testFcr;
            const costoTotalAlimento = alimentoConsumido * costoAlimentoKg;
            const costoTotalCompra = pesoInicial * precioKgInicial;
            const costoTotal = costoTotalCompra + costoTotalAlimento;
            const ingresoVenta = pesoFinal * precioKgFinal;
            const roi = costoTotal > 0 ? ((ingresoVenta - costoTotal) / costoTotal * 100) : -1000;
            
            if (roi > bestRoi) {
                bestRoi = roi;
                bestFcr = testFcr;
            }
        }
        
        $('#fcr_ajustable').val(bestFcr.toFixed(1));
        
        Swal.fire({
            title: 'FCR Óptimo Calculado',
            text: `FCR óptimo: ${bestFcr.toFixed(1)} (ROI estimado: ${bestRoi.toFixed(2)}%)`,
            icon: 'success',
            confirmButtonColor: '#28a745'
        });
        
        // Trigger calculation if form is complete
        if (isFormComplete()) {
            calculateCattleROI();
        }
    });
    
    // Handle livestock system change
    $('#sistema_ganadero').change(function() {
        const selectedOption = $(this).find('option:selected');
        const sistemaValue = $(this).val();
        
        if (sistemaValue === 'personalizado') {
            $('#fcr_personalizado_container').show();
            $('#fcr_ajustable').attr('required', true);
        } else {
            $('#fcr_personalizado_container').hide();
            $('#fcr_ajustable').removeAttr('required');
            
            // Set FCR automatically based on selected system
            if (sistemaValue) {
                const fcrValue = selectedOption.data('fcr');
                $('#fcr_ajustable').val(fcrValue);
            }
        }
        
        // Trigger calculation if form is complete
        if (isFormComplete()) {
            calculateCattleROI();
        }
    });
    
    // Real-time calculation on input change
    $('#cattleCalculatorForm input, #cattleCalculatorForm select').on('input change', function() {
        if (isFormComplete()) {
            calculateCattleROI();
        }
    });
    
    function isFormComplete() {
        let complete = true;
        
        // Check all required fields
        $('#cattleCalculatorForm input[required], #cattleCalculatorForm select[required]').each(function() {
            if ($(this).val() === '') {
                complete = false;
                return false;
            }
        });
        
        // Special check for custom FCR
        const sistemaGanadero = $('#sistema_ganadero').val();
        if (sistemaGanadero === 'personalizado') {
            const fcrPersonalizado = $('#fcr_ajustable').val();
            if (!fcrPersonalizado || fcrPersonalizado === '') {
                complete = false;
            }
        }
        
        return complete;
    }
    
    function calculateCattleROI() {
        // Validate form
        const form = document.getElementById('cattleCalculatorForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }
        
        // Get input values
        const pesoInicial = parseFloat($('#peso_inicial').val()) || 0;
        const precioKgInicial = parseFloat($('#precio_kg_inicial').val()) || 0;
        const pesoFinal = parseFloat($('#peso_final').val()) || 0;
        const precioKgFinal = parseFloat($('#precio_kg_final').val()) || 0;
        const costoAlimentoKg = parseFloat($('#costo_alimento_kg').val()) || 0;
        const duracionDias = parseInt($('#duracion_dias').val()) || 0;
        
        // Get livestock system data
        const sistemaGanadero = $('#sistema_ganadero').val();
        const selectedOption = $('#sistema_ganadero').find('option:selected');
        let fcr, porcentajeForraje, porcentajeConcentrado;
        
        if (sistemaGanadero === 'personalizado') {
            fcr = parseFloat($('#fcr_ajustable').val()) || 6.5;
            porcentajeForraje = 50; // Default values for custom
            porcentajeConcentrado = 50;
        } else if (sistemaGanadero) {
            fcr = selectedOption.data('fcr') || 6.5;
            porcentajeForraje = selectedOption.data('forraje') || 50;
            porcentajeConcentrado = selectedOption.data('concentrado') || 50;
        } else {
            fcr = 6.5;
            porcentajeForraje = 50;
            porcentajeConcentrado = 50;
        }
        
        // Calculate derived values
        const kgGanados = pesoFinal - pesoInicial;
        const gananciaDiaria = duracionDias > 0 ? (kgGanados / duracionDias) : 0;
        
        // Calculate food consumption using user-defined FCR
        const alimentoTotalConsumido = kgGanados * fcr;
        
        // Calculate forraje and concentrado portions
        const forrajeConsumido = alimentoTotalConsumido * (porcentajeForraje / 100);
        const concentradoConsumido = alimentoTotalConsumido * (porcentajeConcentrado / 100);
        
        // Calculate daily rations (this is the key result!)
        const racionDiariaTotal = duracionDias > 0 ? (alimentoTotalConsumido / duracionDias) : 0;
        const racionDiariaForraje = duracionDias > 0 ? (forrajeConsumido / duracionDias) : 0;
        const racionDiariaConcentrado = duracionDias > 0 ? (concentradoConsumido / duracionDias) : 0;
        
        // Calculate break-even point for feed cost
        const costoTotalCompra = pesoInicial * precioKgInicial;
        const ingresoVenta = pesoFinal * precioKgFinal;
        const margenDisponible = ingresoVenta - costoTotalCompra;
        const precioAlimentoEquilibrio = concentradoConsumido > 0 ? (margenDisponible / concentradoConsumido) : 0;
        
        // Perform financial calculations (only concentrado has cost in this calculator)
        const costoTotalAlimento = concentradoConsumido * costoAlimentoKg;
        const costoTotal = costoTotalCompra + costoTotalAlimento;
        const roi = costoTotal > 0 ? ((ingresoVenta - costoTotal) / costoTotal * 100) : 0;
        const ganancia = ingresoVenta - costoTotal;
        
        // Format numbers for display
        const formatCurrency = (value) => '$' + value.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        const formatNumber = (value) => value.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        const formatPercent = (value) => value.toLocaleString('es-ES', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + '%';
        
        // Determine ROI status and color
        let roiStatus = '';
        let roiColor = '';
        if (roi > 20) {
            roiStatus = 'Excelente';
            roiColor = 'text-success';
        } else if (roi > 10) {
            roiStatus = 'Bueno';
            roiColor = 'text-info';
        } else if (roi > 0) {
            roiStatus = 'Aceptable';
            roiColor = 'text-warning';
        } else {
            roiStatus = 'Pérdida';
            roiColor = 'text-danger';
        }
        
        // Display results
        const resultsHtml = `
            <div class="calculation-steps">
                <h6 class="text-primary mb-3"><i class="fas fa-list-ol me-2"></i>Cálculos Paso a Paso:</h6>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-primary me-2">1</span>
                        <strong>Kilogramos Ganados</strong>
                    </div>
                    <div class="step-calculation">
                        <code>kg_ganados = peso_final - peso_inicial</code>
                        <div class="step-result">
                            ${formatNumber(pesoFinal)} kg - ${formatNumber(pesoInicial)} kg = <strong>${formatNumber(kgGanados)} kg</strong>
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-primary me-2">2</span>
                        <strong>Ganancia Diaria</strong>
                    </div>
                    <div class="step-calculation">
                        <code>ganancia_diaria = kg_ganados ÷ duración_días</code>
                        <div class="step-result">
                            ${formatNumber(kgGanados)} kg ÷ ${duracionDias} días = <strong>${formatNumber(gananciaDiaria)} kg/día</strong>
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-primary me-2">3</span>
                        <strong>Sistema Ganadero: ${sistemaGanadero.charAt(0).toUpperCase() + sistemaGanadero.slice(1)}</strong>
                    </div>
                    <div class="step-calculation">
                        <code>Proporción: ${porcentajeForraje}% Forraje + ${porcentajeConcentrado}% Concentrado</code>
                        <div class="step-result">
                            <strong>FCR del Sistema:</strong> ${formatNumber(fcr)} kg alimento/kg ganancia
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-primary me-2">4</span>
                        <strong>Alimento Total Consumido</strong>
                    </div>
                    <div class="step-calculation">
                        <code>alimento_total = kg_ganados × FCR</code>
                        <div class="step-result">
                            ${formatNumber(kgGanados)} kg × ${formatNumber(fcr)} = <strong>${formatNumber(alimentoTotalConsumido)} kg</strong>
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-info me-2">5</span>
                        <strong>Desglose por Tipo de Alimento</strong>
                    </div>
                    <div class="step-calculation">
                        <code>forraje = ${porcentajeForraje}% × alimento_total</code>
                        <div class="step-result">
                            <strong>Forraje:</strong> ${formatNumber(forrajeConsumido)} kg (${porcentajeForraje}%)
                        </div>
                        <code>concentrado = ${porcentajeConcentrado}% × alimento_total</code>
                        <div class="step-result">
                            <strong>Concentrado:</strong> ${formatNumber(concentradoConsumido)} kg (${porcentajeConcentrado}%)
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-4 border border-success rounded p-3" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
                    <div class="step-header">
                        <span class="badge bg-success me-2" style="font-size: 1.1em;">⭐</span>
                        <strong style="color: #155724; font-size: 1.2em;">RACIONES DIARIAS RECOMENDADAS</strong>
                    </div>
                    <div class="step-calculation" style="background-color: #f8fff9; border: 2px solid #28a745;">
                        <code style="color: #155724; font-weight: bold;">ración_diaria_total = alimento_total ÷ duración_días</code>
                        <div class="step-result">
                            <span style="font-size: 1.3em; color: #155724; font-weight: bold;">
                                🌾 Total: ${formatNumber(racionDiariaTotal)} kg/día
                            </span>
                        </div>
                        <hr style="margin: 10px 0; border-color: #28a745;">
                        <div class="step-result">
                            <span style="font-size: 1.1em; color: #155724; font-weight: bold;">
                                🌿 Forraje: ${formatNumber(racionDiariaForraje)} kg/día (${porcentajeForraje}%)
                            </span>
                        </div>
                        <div class="step-result">
                            <span style="font-size: 1.2em; color: #155724; font-weight: bold; text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
                                🥄 Concentrado: ${formatNumber(racionDiariaConcentrado)} kg/día (${porcentajeConcentrado}%)
                            </span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small style="color: #155724; font-weight: 500;">
                            💡 El concentrado es el que genera costo. El forraje se asume disponible (pastoreo/forraje propio).
                        </small>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-info me-2">7</span>
                        <strong>Punto de Equilibrio - Precio Concentrado</strong>
                    </div>
                    <div class="step-calculation">
                        <code>precio_equilibrio = (ingreso_venta - costo_compra) ÷ concentrado_consumido</code>
                        <div class="step-result">
                            (${formatCurrency(ingresoVenta)} - ${formatCurrency(costoTotalCompra)}) ÷ ${formatNumber(concentradoConsumido)} kg = <strong class="${precioAlimentoEquilibrio > costoAlimentoKg ? 'text-success' : 'text-danger'}">${formatCurrency(precioAlimentoEquilibrio)}/kg</strong>
                        </div>
                        <small class="text-muted">
                            ${precioAlimentoEquilibrio > costoAlimentoKg ? 
                                '✅ El precio actual del concentrado está por debajo del punto de equilibrio' : 
                                '⚠️ El precio actual del concentrado supera el punto de equilibrio'}
                        </small>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-warning me-2">8</span>
                        <strong>Costo Total del Concentrado</strong>
                    </div>
                    <div class="step-calculation">
                        <code>costo_total_concentrado = concentrado_consumido × costo_concentrado_kg</code>
                        <div class="step-result">
                            ${formatNumber(concentradoConsumido)} kg × ${formatCurrency(costoAlimentoKg)}/kg = <strong>${formatCurrency(costoTotalAlimento)}</strong>
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-warning me-2">9</span>
                        <strong>Costo Total de Compra</strong>
                    </div>
                    <div class="step-calculation">
                        <code>costo_total_compra = peso_inicial × precio_kg_inicial</code>
                        <div class="step-result">
                            ${formatNumber(pesoInicial)} kg × ${formatCurrency(precioKgInicial)}/kg = <strong>${formatCurrency(costoTotalCompra)}</strong>
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-danger me-2">10</span>
                        <strong>Costo Total</strong>
                    </div>
                    <div class="step-calculation">
                        <code>costo_total = costo_total_compra + costo_total_concentrado</code>
                        <div class="step-result">
                            ${formatCurrency(costoTotalCompra)} + ${formatCurrency(costoTotalAlimento)} = <strong>${formatCurrency(costoTotal)}</strong>
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-3">
                    <div class="step-header">
                        <span class="badge bg-success me-2">11</span>
                        <strong>Ingreso por Venta</strong>
                    </div>
                    <div class="step-calculation">
                        <code>ingreso_venta = peso_final × precio_kg_final</code>
                        <div class="step-result">
                            ${formatNumber(pesoFinal)} kg × ${formatCurrency(precioKgFinal)}/kg = <strong>${formatCurrency(ingresoVenta)}</strong>
                        </div>
                    </div>
                </div>
                
                <div class="step-item mb-4">
                    <div class="step-header">
                        <span class="badge bg-info me-2">12</span>
                        <strong>ROI (Retorno de Inversión)</strong>
                    </div>
                    <div class="step-calculation">
                        <code>ROI = (ingreso_venta - costo_total) / costo_total × 100</code>
                        <div class="step-result">
                            (${formatCurrency(ingresoVenta)} - ${formatCurrency(costoTotal)}) / ${formatCurrency(costoTotal)} × 100 = <strong class="${roiColor}">${formatPercent(roi)}</strong>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="summary-section">
                    <!-- Destacar Raciones Diarias en el resumen -->
                    <div class="alert alert-success text-center mb-4" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border: 3px solid #28a745;">
                        <h4 class="alert-heading text-success mb-3">
                            <i class="fas fa-utensils me-2"></i>RACIONES DIARIAS - SISTEMA ${sistemaGanadero.toUpperCase()}
                        </h4>
                        <div class="row">
                            <div class="col-md-4">
                                <div style="font-size: 1.6em; color: #155724; font-weight: bold;">
                                    🌾 ${formatNumber(racionDiariaTotal)} kg/día
                                </div>
                                <small style="color: #155724; font-weight: 500;">Total</small>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 1.4em; color: #155724; font-weight: bold;">
                                    🌿 ${formatNumber(racionDiariaForraje)} kg/día
                                </div>
                                <small style="color: #155724; font-weight: 500;">Forraje (${porcentajeForraje}%)</small>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 1.8em; color: #155724; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                                    🥄 ${formatNumber(racionDiariaConcentrado)} kg/día
                                </div>
                                <small style="color: #155724; font-weight: 600;">Concentrado (${porcentajeConcentrado}%)</small>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="text-success mb-3"><i class="fas fa-chart-pie me-2"></i>Resumen Financiero:</h6>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="summary-item">
                                <span class="summary-label">Inversión Total:</span>
                                <span class="summary-value text-danger">${formatCurrency(costoTotal)}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Ingreso por Venta:</span>
                                <span class="summary-value text-success">${formatCurrency(ingresoVenta)}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Ganancia/Pérdida:</span>
                                <span class="summary-value ${ganancia >= 0 ? 'text-success' : 'text-danger'}">${formatCurrency(ganancia)}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="roi-display text-center">
                                <div class="roi-value ${roiColor}" style="font-size: 2.5em; font-weight: bold;">
                                    ${formatPercent(roi)}
                                </div>
                                <div class="roi-status">
                                    <span class="badge ${roi > 0 ? 'bg-success' : 'bg-danger'} fs-6">${roiStatus}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div class="alert ${precioAlimentoEquilibrio > costoAlimentoKg ? 'alert-success' : 'alert-warning'} mb-2">
                            <h6 class="alert-heading">
                                <i class="fas fa-balance-scale me-1"></i>Análisis de Punto de Equilibrio
                            </h6>
                            <p class="mb-1">
                                <strong>Precio máximo alimento para rentabilidad:</strong> ${formatCurrency(precioAlimentoEquilibrio)}/kg
                            </p>
                            <p class="mb-1">
                                <strong>Precio actual del alimento:</strong> ${formatCurrency(costoAlimentoKg)}/kg
                            </p>
                            <p class="mb-0">
                                <strong>Margen de seguridad:</strong> 
                                <span class="${precioAlimentoEquilibrio > costoAlimentoKg ? 'text-success' : 'text-danger'}">
                                    ${formatCurrency(precioAlimentoEquilibrio - costoAlimentoKg)}/kg
                                    ${precioAlimentoEquilibrio > costoAlimentoKg ? '(Rentable)' : '(No Rentable)'}
                                </span>
                            </p>
                        </div>
                        
                        <div class="alert alert-info mb-2">
                            <h6 class="alert-heading">
                                <i class="fas fa-magic me-1"></i>Optimización FCR
                            </h6>
                            <p class="mb-1">
                                <strong>FCR actual:</strong> ${formatNumber(fcr)} 
                                <small class="text-muted">(${fcr <= 4.0 ? 'Excelente' : fcr <= 4.5 ? 'Bueno' : fcr <= 5.0 ? 'Aceptable' : 'Mejorable'})</small>
                            </p>
                            <p class="mb-0">
                                <small>💡 Use el botón "Óptimo" para calcular el FCR que maximiza el ROI con los precios actuales.</small>
                            </p>
                        </div>
                        
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            El costo del concentrado representa aproximadamente el 70-80% de los costos totales de alimentación.
                        </small>
                    </div>
                </div>
            </div>
        `;
        
        $('#noResultsMessage').hide();
        $('#calculationResults').html(resultsHtml).show();
    }
});
</script>

<style>
.calculation-steps .step-item {
    border-left: 3px solid #007bff;
    padding-left: 15px;
    margin-left: 15px;
}

.step-header {
    font-weight: 600;
    margin-bottom: 8px;
}

.step-calculation {
    background-color: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
    font-family: 'Courier New', monospace;
}

.step-calculation code {
    background-color: #e9ecef;
    padding: 2px 5px;
    border-radius: 3px;
    font-size: 0.9em;
    display: block;
    margin-bottom: 8px;
}

.step-result {
    font-family: inherit;
    color: #495057;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    padding: 5px 0;
    border-bottom: 1px solid #dee2e6;
}

.summary-label {
    font-weight: 500;
}

.summary-value {
    font-weight: bold;
}

.roi-display {
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 10px;
    border: 2px solid #dee2e6;
}

.card {
    border: none;
    border-radius: 10px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

/* Professional Calculator Buttons Styling */
#cattleCalculatorForm .d-grid {
    gap: 12px !important;
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
    padding: 0 20px;
}

#calculateBtn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
    border-radius: 12px;
    padding: 17px 40px;
    font-weight: 600;
    font-size: 1.1em;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    width: 100%;
}

#calculateBtn:hover {
    background: linear-gradient(135deg, #218838 0%, #1ea085 100%);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    transform: translateY(-2px);
}

#calculateBtn:active {
    transform: translateY(0px);
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
}

#calculateBtn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

#calculateBtn:hover::before {
    left: 100%;
}

#clearBtn {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    border: none;
    border-radius: 12px;
    padding: 15px 40px;
    font-weight: 500;
    font-size: 1em;
    color: white;
    box-shadow: 0 3px 12px rgba(108, 117, 125, 0.25);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    width: 100%;
}

#clearBtn:hover {
    background: linear-gradient(135deg, #5a6268 0%, #343a40 100%);
    box-shadow: 0 5px 18px rgba(108, 117, 125, 0.35);
    transform: translateY(-1px);
    color: white;
}

#clearBtn:active {
    transform: translateY(0px);
    box-shadow: 0 2px 8px rgba(108, 117, 125, 0.25);
}

#clearBtn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
    transition: left 0.5s;
}

#clearBtn:hover::before {
    left: 100%;
}

/* Button Icons Animation */
#calculateBtn i, #clearBtn i {
    transition: transform 0.3s ease;
}

#calculateBtn:hover i {
    transform: scale(1.1) rotate(5deg);
}

#clearBtn:hover i {
    transform: scale(1.1) rotate(-5deg);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #calculateBtn, #clearBtn {
        padding: 15px 20px;
        font-size: 1em;
    }
    
    #calculateBtn {
        font-size: 1.05em;
    }
}
</style>

</body>
</html>