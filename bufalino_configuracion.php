<?php
require_once './pdo_conexion.php';  // Go up one directory since inventario_bufalino.php is in the bufalino folder
// Now you can use $conn for database queries

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bufalino Configuracion</title>
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

<!-- Add these in the <head> section, after your existing CSS/JS links -->

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
<!-- Custom Modal Styles -->
<link rel="stylesheet" href="./bufalino.css">

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








    /* Category container styling with improved spacing, vertical alignment and subtle shadows */
    .salud-container, .reproduccion-container, .poblacion-container, .alimentacion-container, .produccion-container {
        border: 2px dotted #28a745;
        border-radius: 15px;
        padding: 20px 10px 15px 10px;
        margin-bottom: 25px;
        position: relative;
        width: 95%; /* Slightly narrower than parent to show borders clearly */
        background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(248, 249, 250, 0.9));
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center; /* Center items vertically */
        box-shadow: 
            0px 4px 8px rgba(0, 0, 0, 0.06),
            0px 2px 4px rgba(0, 0, 0, 0.04),
            inset 0px 1px 2px rgba(255, 255, 255, 0.9);
        transition: all 0.3s ease;
    }

    .salud-container:hover, .reproduccion-container:hover, .poblacion-container:hover, 
    .alimentacion-container:hover, .produccion-container:hover {
        box-shadow: 
            0px 6px 12px rgba(0, 0, 0, 0.08),
            0px 3px 6px rgba(0, 0, 0, 0.06),
            inset 0px 1px 2px rgba(255, 255, 255, 1);
        border-color: #20c997;
        background: linear-gradient(145deg, rgba(255, 255, 255, 1), rgba(248, 249, 250, 0.95));
    }

    /* Adjust the button container inside categories for better spacing and alignment */
    .salud-container .container, .reproduccion-container .container, 
    .poblacion-container .container, .alimentacion-container .container, 
    .produccion-container .container {
        padding: 0;
        margin: 0;
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center; /* Center items vertically */
    }

    /* Category label styling with enhanced professional appearance */
    .salud-container::before, .reproduccion-container::before, .poblacion-container::before, 
    .alimentacion-container::before, .produccion-container::before {
        content: attr(data-category);
        position: absolute;
        top: -12px;
        left: 20px;
        background: linear-gradient(145deg, #ffffff, #f8f9fa);
        padding: 4px 15px;
        font-size: 0.85rem;
        font-weight: bold;
        color: #28a745;
        text-transform: uppercase;
        border-radius: 8px;
        box-shadow: 
            0px 3px 6px rgba(0, 0, 0, 0.12),
            0px 1px 3px rgba(0, 0, 0, 0.08),
            inset 0px 1px 2px rgba(255, 255, 255, 0.9);
        z-index: 1;
        border: 1px solid rgba(40, 167, 69, 0.2);
        text-shadow: 0px 1px 2px rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .salud-container:hover::before, .reproduccion-container:hover::before, .poblacion-container:hover::before, 
    .alimentacion-container:hover::before, .produccion-container:hover::before {
        color: #20c997;
        border-color: rgba(32, 201, 151, 0.3);
        box-shadow: 
            0px 4px 8px rgba(0, 0, 0, 0.15),
            0px 2px 4px rgba(0, 0, 0, 0.1),
            inset 0px 1px 2px rgba(255, 255, 255, 1);
        text-shadow: 0px 1px 2px rgba(255, 255, 255, 1);
    }

</style>
</head>
<body>
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
                    <span class="badge-active">🎯 Estás configurando</span>
                    <div style="background: white; color: #17a2b8; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 2rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                        <i class="fas fa-cog"></i>
                    </div>
                    <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1.1rem;">CONFIGURACIÓN</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scroll Icons Container -->
<div class="container scroll-icons-container">


    <div class="container  salud-container" data-category="CONFIGURACION SALUD">
        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_aftosa.php'" class="icon-button">
                <img src="./images/aftosa.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">AFTOSA</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_brucelosis.php'" class="icon-button">
                <img src="./images/brucelosis.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">BRUCELOSIS</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_carbunco.php'" class="icon-button">
                <img src="./images/carbunco.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">CARBUNCO</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_ibr.php'" class="icon-button">
                <img src="./images/ibr.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">IBR</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_cbr.php'" class="icon-button">
                <img src="./images/cbr.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">CBR</span>
        </div>
        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_garrapatas.php'" class="icon-button">
                <img src="./images/garrapatas.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">GARRAPATAS</span>
        </div>
        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_parasitos.php'" class="icon-button">
                <img src="./images/parasitos.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">PARASITOS</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_mastitis.php'" class="icon-button">
                <img src="./images/mastitis.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">MASTITIS</span>
        </div>
    </div>

    <div class="container  alimentacion-container" data-category="CONFIGURACION ALIMENTACION">
        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_concentrado.php'" class="icon-button">
                <img src="./images/concentrado.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">CONCENTRADO</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_melaza.php'" class="icon-button">
                <img src="./images/melaza.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">MELAZA</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_sal.php'" class="icon-button">
                <img src="./images/sal.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">SAL</span>
        </div>
    </div>
    <div class="container  poblacion-container" data-category="CONFIGURACION POBLACION">
        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_razas.php'" class="icon-button">
                <img src="./images/raza.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">RAZAS</span>
        </div>
        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_etapas.php'" class="icon-button">
                <img src="./images/etapas.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">ETAPAS</span>
        </div>
        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_grupos.php'" class="icon-button">
                <img src="./images/grupo.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">GRUPOS</span>
        </div>

        <div class="icon-button-container">
            <button onclick="window.location.href='./bufalino_configuracion_estatus.php'" class="icon-button">
                <img src="./images/estatus.png" alt="Inicio" class="nav-icon">
            </button>
            <span class="button-label">ESTATUS</span>
        </div>
    </div>
</div>