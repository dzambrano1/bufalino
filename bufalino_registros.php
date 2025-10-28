<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bufalino Registros</title>
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





    .error-message {
        background-color: #ffebee;
        color: #c62828;
        padding: 10px;
        margin: 10px 0;
        border-radius: 20px;
        border-bottom-left-radius: 5px;
    }

    .full-width-button {
        width: 100% !important;
        display: block !important;
        box-sizing: border-box !important;
    }



    /* Scroll Icons Container */
    .scroll-icons-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        overflow-y: visible;
        padding: 15px 0;
        position: relative;
        height: auto;
        -webkit-overflow-scrolling: touch;
    }

    .scroll-icons-container .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 8px;
        margin-bottom: 10px;
        width: 100%;
        padding: 0 15px;
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

    /* Button styling to match nav-icons-container buttons */
    .btn.btn-outline-secondary {
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
        border: none;
        border-radius: 50% !important;
        width: 100px;
        height: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        padding: 0;
        box-shadow: 
            0 4px 8px rgba(0,0,0,0.15),
            inset 0 2px 4px rgba(255,255,255,0.8),
            inset 0 -2px 4px rgba(0,0,0,0.1);
        cursor: pointer;
        margin: 5px;
    }

    .btn.btn-outline-secondary:hover {
        transform: translateY(-3px);
        box-shadow: 
            0 8px 16px rgba(0,0,0,0.2),
            inset 0 2px 4px rgba(255,255,255,0.9),
            inset 0 -2px 4px rgba(0,0,0,0.15);
        background: linear-gradient(145deg, #f8f8f8, #e8e8e8);
    }

    .btn.btn-outline-secondary:active {
        transform: translateY(1px);
        box-shadow: 
            0 2px 4px rgba(0,0,0,0.1),
            inset 0 1px 2px rgba(0,0,0,0.1);
    }

    .btn.btn-outline-secondary .nav-icon {
        width: 30px;
        height: 30px;
        object-fit: contain;
        transition: all 0.3s ease;
    }

    .btn.btn-outline-secondary .button-label {
        font-size: 0.6rem;
        font-weight: 600;
        color: #495057;
        text-align: center;
        margin-top: 0.5rem;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn.btn-outline-secondary:hover .button-label {
        color: #28a745;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .btn.btn-outline-secondary {
            width: 90px;
            height: 90px;
        }
        
        .btn.btn-outline-secondary .nav-icon {
            width: 25px;
            height: 25px;
        }
        
        .btn.btn-outline-secondary .button-label {
            font-size: 0.6rem;
        }
    }

    @media (max-width: 480px) {
        .btn.btn-outline-secondary {
            width: 80px;
            height: 80px;
        }
        
        .btn.btn-outline-secondary .nav-icon {
            width: 22px;
            height: 22px;
        }
        
        .btn.btn-outline-secondary .button-label {
            font-size: 0.6rem;
        }
    }

    /* Remove height restriction for all screen sizes */
    @media (max-height: 800px) {
        .scroll-icons-container {
            max-height: none;
            overflow-y: visible;
        }
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
                        <span class="badge-active">🎯 Registrando Tareas</span>
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
<!-- Scroll Icons Container -->
<div class="container scroll-icons-container">
    <div class="container  salud-container" data-category="SALUD">    
    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-tooltip="Aftosa"
        aria-expanded="false"
        aria-controls="aftosa"
        onclick="window.location.href='./bufalino_register_aftosa.php'">
        <img src="./images/aftosa.png" alt="Aftosa" class="nav-icon">
        <span class="button-label">AFTOSA</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-tooltip="Aftosa"
        aria-expanded="false"
        aria-controls="brucelosis"
        onclick="window.location.href='./bufalino_register_brucelosis.php'">
        <img src="./images/brucelosis.png" alt="Brucelosis" class="nav-icon">
        <span class="button-label">BRUCELOSIS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-tooltip="Carbunco"
        aria-expanded="false"
        aria-controls="carbunco"
        onclick="window.location.href='./bufalino_register_carbunco.php'">
        <img src="./images/carbunco.png" alt="Carbunco" class="nav-icon">
        <span class="button-label">CARBUNCO</span>
    </button>

    <button class="btn btn-outline-secondary mb-3" type="button" 
        data-bs-toggle="collapse" 
        data-tooltip="CBR"
        aria-expanded="false"
        aria-controls="cbr"
        onclick="window.location.href='./bufalino_register_cbr.php'">
        <img src="./images/cbr.png" alt="CBR" class="nav-icon">
        <span class="button-label">CBR</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#ibr" 
        data-tooltip="IBR"
        aria-expanded="false"
        aria-controls="ibr"
        onclick="window.location.href='./bufalino_register_ibr.php'">
        <img src="./images/ibr.png" alt="IBR" class="nav-icon">
        <span class="button-label">IBR</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#garrapatas" 
        data-tooltip="Garrapatas"
        aria-expanded="false"
        aria-controls="garrapatas"
        onclick="window.location.href='./bufalino_register_garrapatas.php'">
        <img src="./images/garrapatas.png" alt="Garrapatas" class="nav-icon">
        <span class="button-label">GARRAPATAS</span>
    </button>
    
    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#alimentacion" 
        data-tooltip="Parasitos"
        aria-expanded="false"
        aria-controls="alimentacion"
        onclick="window.location.href='./bufalino_register_parasitos.php'">
        <img src="./images/parasitos.png" alt="Parasitos" class="nav-icon">
        <span class="button-label">PARASITOS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#salud" 
        data-tooltip="Mastitis"
        aria-expanded="false"
        aria-controls="salud"
        onclick="window.location.href='./bufalino_register_mastitis.php'">
        <img src="./images/mastitis.png" alt="Mastitis" class="nav-icon">
        <span class="button-label">MASTITIS</span>
    </button>
    </div>

    <div class="container poblacion-container" data-category="POBLACION">
    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#compra" 
        data-tooltip="Compras"
        aria-expanded="false"
        aria-controls="compra"
        onclick="window.location.href='./bufalino_register_compras.php'">
        <img src="./images/compras.png" alt="Compra" class="nav-icon">
        <span class="button-label">COMPRAS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#venta" 
        data-tooltip="Venta"
        aria-expanded="false"   
        aria-controls="venta"
        onclick="window.location.href='./bufalino_register_nacimientos.php'">
        <img src="./images/becerrito.png" alt="Venta" class="nav-icon">
        <span class="button-label">NACIMIENTOS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#venta" 
        data-tooltip="Venta"
        aria-expanded="false"   
        aria-controls="venta"
        onclick="window.location.href='./bufalino_register_venta.php'">
        <img src="./images/venta.png" alt="Venta" class="nav-icon">
        <span class="button-label">VENTAS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#deceso" 
        data-tooltip="Deceso"
        aria-expanded="false"   
        aria-controls="deceso"
        onclick="window.location.href='./bufalino_register_decesos.php'">
        <img src="./images/deceso.png" alt="Deceso" class="nav-icon">
        <span class="button-label">DECESOS</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#descarte" 
        data-tooltip="Descarte"
        aria-expanded="false"   
        aria-controls="descarte"  
        onclick="window.location.href='./bufalino_register_descarte.php'">
        <img src="./images/descarte.png" alt="Descarte" class="nav-icon">
        <span class="button-label">DESCARTE</span>
    </button>
    </div>

    <div class="container reproduccion-container" data-category="REPRODUCCION">
    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#reproduccion" 
        data-tooltip="Inseminacion"
        aria-expanded="false"
        aria-controls="reproduccion"
        onclick="window.location.href='./bufalino_register_inseminacion.php'">
        <img src="./images/inseminacion.png" alt="Inseminacion" class="nav-icon">
        <span class="button-label">INSEMINACION</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#gestacion" 
        data-tooltip="Gestacion"
        aria-expanded="false"
        aria-controls="gestacion"   
        onclick="window.location.href='./bufalino_register_gestacion.php'">
        <img src="./images/gestacion.png" alt="Gestacion" class="nav-icon">
        <span class="button-label">GESTACION</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#parto" 
        data-tooltip="Parto"
        aria-expanded="false"
        aria-controls="parto"   
        onclick="window.location.href='./bufalino_register_parto.php'">
        <img src="./images/parto.png" alt="Parto" class="nav-icon"> 
        <span class="button-label">PARTO</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#destete" 
        data-tooltip="Destete"
        aria-expanded="false"
        aria-controls="destete"
        onclick="window.location.href='./bufalino_register_destete.php'">
        <img src="./images/destete.png" alt="Destete" class="nav-icon">
        <span class="button-label">DESTETE</span>
    </button>
    </div>

    <div class="container alimentacion-container" data-category="ALIMENTACION">
    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#feed" 
        data-tooltip="Feed"
        aria-expanded="false"   
        aria-controls="feed"  
        onclick="window.location.href='./bufalino_register_feed.php'">    
        <img src="./images/feed.png" alt="Feed" class="nav-icon">
        <span class="button-label">ABA</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#melaza" 
        data-tooltip="Melaza"
        aria-expanded="false"   
        aria-controls="melaza"  
        onclick="window.location.href='./bufalino_register_melaza.php'"> 
        <img src="./images/melaza.png" alt="Melaza" class="nav-icon">
        <span class="button-label">MELAZA</span>
    </button>

    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#sal" 
        data-tooltip="Sal"
        aria-expanded="false"   
        aria-controls="Sal"  
        onclick="window.location.href='./bufalino_register_sal.php'">
        <img src="./images/sal.png" alt="Sal" class="nav-icon">
        <span class="button-label">SAL</span>
    </button>
    </div>

    <div class="container produccion-container" data-category="PRODUCCION">
    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#carne" 
        data-tooltip="Carne"
        aria-expanded="false"   
        aria-controls="carne"  
        onclick="window.location.href='./bufalino_register_meat.php'">
        <img src="./images/carne.png" alt="Carne" class="nav-icon">
        <span class="button-label">CARNE</span>
    </button>
    
    <button class="btn btn-outline-secondary mb-3 rounded-circle" type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#leche" 
        data-tooltip="Leche"
        aria-expanded="false"   
        aria-controls="leche"  
        onclick="window.location.href='./bufalino_register_leche.php'">
        <img src="./images/leche.png" alt="Leche" class="nav-icon">
        <span class="button-label">LECHE</span>
    </button>
    </div>
</div>
</body>
</html>