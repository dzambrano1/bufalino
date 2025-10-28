<?php

require_once './pdo_conexion.php';  // Go up one directory since inventario_bufalino.php is in the bufalino folder
// Now you can use $conn for database queries

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Indices Bufalinos</title>
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

<!-- ECharts -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
<!-- Custom Modal Styles -->
<link rel="stylesheet" href="./bufalino.css">

<style>
    /* Dashboard Grid Layout */
    .dashboard-container {
        padding: 20px;
        background: linear-gradient(135deg, #f0f8f0 0%, #c8e6c9 100%);
        min-height: 100bh;
    }
    
    .dashboard-header {
        text-align: center;
        margin-bottom: 16px;
        padding: 12px 0;
        background: linear-gradient(135deg, #2e7d32 0%, #388e3c 100%);
        color: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(46, 125, 50, 0.3);
    }
    
    .dashboard-title {
        font-size: 1rem;
        font-weight: 700;
        margin-bottom: 4px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    }
    
    .dashboard-subtitle {
        font-size: 0.44rem;
        opacity: 0.9;
        font-weight: 300;
    }
    
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 25px;
        margin-bottom: 30px;
    }
    
    /* Chart Card Styling */
    .chart-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 1px solid rgba(255,255,255,0.2);
    }
    
    .chart-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .chart-card-header {
        padding: 20px 25px 15px;
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .chart-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        pointer-events: none;
    }
    
    .chart-card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        position: relative;
        z-index: 1;
        color: white !important;
    }
    
    .chart-card-title i {
        color: white !important;
    }
    
    .chart-card-body {
        padding: 20px;
        height: 300px;
        position: relative;
    }
    
    .chart-canvas-container {
        width: 100%;
        height: 100%;
        position: relative;
    }
    
    .chart-canvas-container canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Action Buttons */
    .chart-actions {
        position: absolute;
        top: 15px;
        right: 15px;
        display: flex;
        gap: 8px;
        z-index: 10;
    }
    
    .chart-btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 8px;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: white !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .chart-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        color: white !important;
    }
    
    .chart-btn.expand-btn {
        color: white !important;
    }
    
    .chart-btn.pdf-btn {
        color: white !important;
    }
    
    /* Full Screen Modal */
    .chart-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100bh;
        background: rgba(0,0,0,0.9);
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .chart-modal.active {
        display: flex;
        opacity: 1;
        align-items: center;
        justify-content: center;
    }
    
    .chart-modal-content {
        background: white;
        border-radius: 20px;
        width: 95vw;
        height: 90bh;
        max-width: 1200px;
        position: relative;
        display: flex;
        flex-direction: column;
        box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }
    
    .chart-modal.active .chart-modal-content {
        transform: scale(1);
    }
    
    .chart-modal-header {
        padding: 25px 30px;
        background: linear-gradient(135deg, #2e7d32 0%, #4caf50 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .chart-modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
        color: white !important;
    }
    
    .chart-modal-title i {
        color: white !important;
    }
    
    .chart-modal-close {
        background: rgba(255,255,255,0.2);
        border: none;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }
    
    .chart-modal-close:hover {
        background: rgba(255,255,255,0.3);
        transform: rotate(90deg);
    }
    
    .chart-modal-body {
        flex: 1;
        padding: 30px;
        position: relative;
    }
    
    .chart-modal-canvas {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Loading States */
    .chart-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: #666;
    }
    
    .chart-loading .spinner {
        display: inline-block;
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #2e7d32;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        
        .dashboard-title {
            font-size: 2rem;
        }
        
        .chart-card-body {
            height: 250px;
        }
        
        .chart-modal-content {
            width: 98vw;
            height: 95bh;
            border-radius: 15px;
        }
        
        .chart-modal-header {
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }
        
        .chart-modal-title {
            font-size: 1.2rem;
        }
        
        .chart-modal-body {
            padding: 20px;
        }
    }
    
    @media (max-width: 480px) {
        .charts-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        
        .chart-card-body {
            height: 200px;
        }
        
        .dashboard-container {
            padding: 15px;
        }
    }
    
    /* Animation for chart cards */
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
    
    .chart-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
    
    .chart-card:nth-child(1) { animation-delay: 0.1s; }
    .chart-card:nth-child(2) { animation-delay: 0.2s; }
    .chart-card:nth-child(3) { animation-delay: 0.3s; }
    .chart-card:nth-child(4) { animation-delay: 0.4s; }
    .chart-card:nth-child(5) { animation-delay: 0.5s; }
    .chart-card:nth-child(6) { animation-delay: 0.6s; }
    .chart-card:nth-child(7) { animation-delay: 0.7s; }
    .chart-card:nth-child(8) { animation-delay: 0.8s; }
    .chart-card:nth-child(9) { animation-delay: 0.9s; }
    .chart-card:nth-child(10) { animation-delay: 1.0s; }
    .chart-card:nth-child(11) { animation-delay: 1.1s; }
    .chart-card:nth-child(12) { animation-delay: 1.2s; }
    .chart-card:nth-child(13) { animation-delay: 1.3s; }
    .chart-card:nth-child(14) { animation-delay: 1.4s; }

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

    /* Chart container responsive styling */
    .chart-container {
        position: relative;
        height: min(400px, 50bh);
        width: 100%;
        margin: auto;
    }

    /* Export button styling */
    #exportMilkRevenuePDF {
        transition: all 0.3s ease;
    }

    #exportMilkRevenuePDF:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
    }

    #exportMilkRevenuePDF:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
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

    /* Initial system message style */
</style>

</head>
<body>
<!-- Navigation Title -->
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
<!-- Navigation Title -->
<nav class="navbar text-center" style="border: none !important; box-shadow: none !important;">
    <!-- Title Row -->
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-between align-items-center position-relative">
                <!-- Botón de Configuración -->
                <button type="button" onclick="window.location.href='./bufalino_configuracion.php'" class="btn" style="color:white; border: none; border-radius: 8px; padding: 8px 15px; z-index: 1050; position: relative;" title="Configuración">
                    <i class="fas fa-cog"></i> Configuracion
                </button>
                
                <!-- Título centrado -->
                <h1 class="navbar-title text-center position-absolute" style="left: 50%; transform: translateX(-50%); z-index: 1;">
                    <i class="fa-solid fa-chart-line"></i>LA GRANJA DE TITO<span class="ms-2"><i class="fa-solid fa-robot"></i></span>
                </h1>
                
                <!-- Botón de Salir -->
                <button type="button" onclick="window.location.href='../inicio.php'" class="btn" style="color: white; border: none; border-radius: 8px; padding: 8px 15px; z-index: 1050; position: relative;" title="Cerrar Sesión">
                    <i class="fas fa-sign-out-alt"></i> Salir
                </button>
            </div>
        </div>
    </div>
</nav>

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
                    <div class="arrow-step w-100" onclick="window.location.href='./bufalino_registros.php'" title="Ir a Registros">
                        <div style="background: white; color: #28a745; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            2
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 2:<br>Registrar Tareas</h5>
                    </div>
                </div>
                <div class="col-md-4 d-flex px-1 mb-3 mb-md-0">
                    <div class="arrow-step arrow-step-last arrow-step-active w-100">
                        <span class="badge-active">🎯 Consultando Índices</span>
                        <div style="background: white; color: #17a2b8; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; font-size: 1.8rem; font-weight: bold; box-shadow: 0 3px 10px rgba(0,0,0,0.3);">
                            3
                        </div>
                        <h5 class="text-white text-center mb-0" style="font-weight: bold; font-size: 1rem;">PASO 3:<br>Consultar</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Container -->
<div class="dashboard-container">


    <!-- Charts Grid -->
    <div class="charts-grid">
        
        <!-- Milk Revenue Chart Card -->
        <div class="chart-card" data-chart="milkRevenue">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-chart-line"></i>
                    Ingresos Leche
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('milkRevenue')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('milkRevenue')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="milkRevenueChart"></canvas>
                    <div id="milkRevenueLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weight Revenue Chart Card -->
        <div class="chart-card" data-chart="pesoRevenue">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-weight"></i>
                    Valor en Pie
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('pesoRevenue')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('pesoRevenue')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="pesoRevenueChart"></canvas>
                    <div id="pesoRevenueLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Concentrado Expense Chart Card -->
        <div class="chart-card" data-chart="concentradoExpense">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-seedling"></i>
                    Concentrado
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('concentradoExpense')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('concentradoExpense')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="concentradoExpenseChart"></canvas>
                    <div id="concentradoExpenseLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Melaza Expense Chart Card -->
        <div class="chart-card" data-chart="melazaExpense">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-tint"></i>
                    Melaza
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('melazaExpense')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('melazaExpense')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="melazaExpenseChart"></canvas>
                    <div id="melazaExpenseLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Salt Expense Chart Card -->
        <div class="chart-card" data-chart="salExpense">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-fill-drip"></i>
                    Sal
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('salExpense')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('salExpense')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="salExpenseChart"></canvas>
                    <div id="salExpenseLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vaccine Costs Chart Card -->
        <div class="chart-card" data-chart="vaccineCosts">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-syringe"></i>
                    Vacunas
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('vaccineCosts')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('vaccineCosts')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="vaccineCostsChart"></canvas>
                    <div id="vaccineCostsLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Summary Chart Card -->
        <div class="chart-card" data-chart="financialSummary">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-chart-bar"></i>
                    Resumen Financiero
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('financialSummary')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('financialSummary')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="financialSummaryChart"></canvas>
                    <div id="financialSummaryLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pregnancy Chart Card -->
        <div class="chart-card" data-chart="pregnancy">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-baby"></i>
                    Gestaciones
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('pregnancy')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('pregnancy')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="pregnancyChart"></canvas>
                    <div id="pregnancyLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Births Chart Card -->
        <div class="chart-card" data-chart="births">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-heart"></i>
                    Partos
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('births')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('births')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="birthsChart"></canvas>
                    <div id="birthsLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchases Chart Card -->
        <div class="chart-card" data-chart="purchases">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-shopping-cart"></i>
                    Compras
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('purchases')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('purchases')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="purchasesChart"></canvas>
                    <div id="purchasesLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Expenses Chart Card -->
        <div class="chart-card" data-chart="allExpenses">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-chart-pie"></i>
                    Gastos Totales
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('allExpenses')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('allExpenses')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="allExpensesChart"></canvas>
                    <div id="allExpensesLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart Card -->
        <div class="chart-card" data-chart="sales">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-hand-holding-usd"></i>
                    Ventas
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('sales')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('sales')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="salesChart"></canvas>
                    <div id="salesLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Deaths Chart Card -->
        <div class="chart-card" data-chart="deaths">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-cross"></i>
                    Muertes
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('deaths')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('deaths')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="deathsChart"></canvas>
                    <div id="deathsLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Discards Chart Card -->
        <div class="chart-card" data-chart="discards">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-trash-alt"></i>
                    Descartes
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('discards')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('discards')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="discardsChart"></canvas>
                    <div id="discardsLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Weaning Chart Card -->
        <div class="chart-card" data-chart="weaning">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-cut"></i>
                    Destetes
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('weaning')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('weaning')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="weaningChart"></canvas>
                    <div id="weaningLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insemination Chart Card -->
        <div class="chart-card" data-chart="insemination">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-dna"></i>
                    Inseminaciones
                </h5>
                <div class="chart-actions">
                    <button class="chart-btn expand-btn" title="Expandir" onclick="expandChart('insemination')">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="chart-btn pdf-btn" title="Exportar PDF" onclick="exportChartPDF('insemination')">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <div class="chart-canvas-container">
                    <canvas id="inseminationChart"></canvas>
                    <div id="inseminationLoading" class="chart-loading">
                        <div class="spinner"></div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Full Screen Chart Modal -->
<div id="chartModal" class="chart-modal">
    <div class="chart-modal-content">
        <div class="chart-modal-header">
            <h4 class="chart-modal-title" id="modalChartTitle">
                <i class="fas fa-chart-bar"></i>
                Gráfico
            </h4>
            <button class="chart-modal-close" onclick="closeChartModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="chart-modal-body">
            <canvas id="modalChart"></canvas>
        </div>
    </div>
</div>

<!-- Librerias -->
<!-- Bootstrap  -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<!-- Librerias -->
<!-- Bootstrap  -->
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!-- Popper Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<!-- para usar botones en datatables JS -->  
    <script src="https://ganagram.com/ganagram/crud/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>  
    <script src="https://ganagram.com/ganagram/crud/datatables/JSZip-2.5.0/jszip.min.js"></script>    
    <script src="https://ganagram.com/ganagram/crud/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>    
    <script src="https://ganagram.com/ganagram/crud/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
    <script src="https://ganagram.com/ganagram/crud/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<!-- Ion Icon Js -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>    
<!-- Custom Menu Js -->
<script src="https://ganagram.com/ganagram/html/js/menu.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<!-- jsPDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<!-- Back to top button -->
<button id="backToTop" class="back-to-top" onclick="scrollToTop()" title="Volver arriba">
    <div class="arrow-up"><i class="fa-solid fa-arrow-up"></i></div>
</button>

<script>
// Back to top functionality
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

// Dashboard Chart Management
let chartInstances = {};
let currentExpandedChart = null;

// Chart configurations and data
const chartConfigs = {
    milkRevenue: {
        title: 'Ingresos Leche',
        icon: 'fas fa-chart-line',
        dataUrl: './get_milk_revenue_data.php',
        color: 'rgba(40, 167, 69, 0.8)',
        borderColor: '#28a745'
    },
    pesoRevenue: {
        title: 'Valor en Pie',
        icon: 'fas fa-weight',
        dataUrl: './get_peso_revenue_data.php',
        color: 'rgba(220, 53, 69, 0.8)',
        borderColor: '#dc3545'
    },
    concentradoExpense: {
        title: 'Concentrado',
        icon: 'fas fa-seedling',
        dataUrl: './get_concentrado_expense_data.php',
        color: 'rgba(0, 123, 255, 0.8)',
        borderColor: '#007bff'
    },

    melazaExpense: {
        title: 'Melaza',
        icon: 'fas fa-tint',
        dataUrl: './get_melaza_expense_data.php',
        color: 'rgba(255, 193, 7, 0.8)',
        borderColor: '#ffc107'
    },
    salExpense: {
        title: 'Sal',
        icon: 'fas fa-fill-drip',
        dataUrl: './get_sal_expense_data.php',
        color: 'rgba(111, 66, 193, 0.8)',
        borderColor: '#6f42c1'
    },
    vaccineCosts: {
        title: 'Vacunas',
        icon: 'fas fa-syringe',
        dataUrl: './get_vaccine_costs_data.php',
        color: 'rgba(23, 162, 184, 0.8)',
        borderColor: '#17a2b8'
    },
    financialSummary: {
        title: 'Resumen Financiero',
        icon: 'fas fa-chart-bar',
        dataUrl: './get_financial_summary_data.php',
        color: [
            'rgba(40, 167, 69, 0.8)',   // Green for Income
            'rgba(220, 53, 69, 0.8)',   // Red for Expenses  
            'rgba(0, 123, 255, 0.8)'    // Blue for Gross Profit
        ],
        borderColor: [
            'rgba(40, 167, 69, 1)',
            'rgba(220, 53, 69, 1)', 
            'rgba(0, 123, 255, 1)'
        ]
    },
    pregnancy: {
        title: 'Gestaciones',
        icon: 'fas fa-baby',
        dataUrl: './get_pregnancy_data.php',
        color: 'rgba(232, 62, 140, 0.8)',
        borderColor: '#e83e8c'
    },
    births: {
        title: 'Partos',
        icon: 'fas fa-heart',
        dataUrl: './get_births_data.php',
        color: 'rgba(32, 201, 151, 0.8)',
        borderColor: '#20c997'
    },
    purchases: {
        title: 'Compras',
        icon: 'fas fa-shopping-cart',
        dataUrl: './get_purchases_data.php',
        color: 'rgba(102, 16, 242, 0.8)',
        borderColor: '#6610f2'
    },
    allExpenses: {
        title: '',
        icon: 'fas fa-chart-pie',
        dataUrl: './get_all_expenses_data.php',
        color: [
            'rgba(220, 53, 69, 0.8)',   // Red for total expenses
            'rgba(255, 193, 7, 0.8)',   // Amber for feed expenses  
            'rgba(108, 117, 125, 0.8)'  // Gray for health expenses
        ],
        borderColor: [
            'rgba(220, 53, 69, 1)',
            'rgba(255, 193, 7, 1)', 
            'rgba(108, 117, 125, 1)'
        ]
    },
    sales: {
        title: 'Ventas',
        icon: 'fas fa-hand-holding-usd',
        dataUrl: './get_sales_data.php',
        color: 'rgba(253, 126, 20, 0.8)',
        borderColor: '#fd7e14'
    },
    deaths: {
        title: 'Decesos Mensuales de Animales',
        icon: 'fas fa-cross',
        dataUrl: './get_deaths_data.php',
        color: 'rgba(108, 117, 125, 0.8)',
        borderColor: '#6c757d'
    },
    discards: {
        title: 'Descartes',
        icon: 'fas fa-trash-alt',
        dataUrl: './get_discards_data.php',
        color: 'rgba(114, 28, 36, 0.8)',
        borderColor: '#721c24'
    },
    weaning: {
        title: 'Destetes',
        icon: 'fas fa-cut',
        dataUrl: './get_weaning_data.php',
        color: 'rgba(13, 202, 240, 0.8)',
        borderColor: '#0dcaf0'
    },
    insemination: {
        title: 'Inseminaciones',
        icon: 'fas fa-dna',
        dataUrl: './get_insemination_data.php',
        color: 'rgba(50, 205, 50, 0.8)',
        borderColor: '#32cd32'
    }
};

// Generic chart loading function
async function loadChart(chartType, canvasId, isModal = false) {
    const config = chartConfigs[chartType];
    if (!config) return;

    const loadingId = `${chartType}Loading`;
    const loadingDiv = document.getElementById(loadingId);
    
    if (loadingDiv) {
        loadingDiv.style.display = 'block';
    }

    try {
        const response = await fetch(config.dataUrl);
        const data = await response.json();

        if (data.error) {
            throw new Error(data.error);
        }

        if (data.length === 0) {
            if (loadingDiv) {
                loadingDiv.innerHTML = '<div class="alert alert-info"><i class="fas fa-info-circle me-2"></i>No hay datos disponibles</div>';
            }
            return;
        }

        if (loadingDiv) {
            loadingDiv.style.display = 'none';
        }

        // Process data based on chart type
        let chartData = processChartData(data, chartType, config);
        
        // Check if there's cumulative data (second dataset)
        const hasCumulativeData = chartData.datasets && chartData.datasets.length > 1;
        
        // Create chart
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        const ctx = canvas.getContext('2d');
        
        // Destroy existing chart if it exists
        if (chartInstances[canvasId]) {
            chartInstances[canvasId].destroy();
        }

        // Create new chart
        const chartConfig = {
            type: getChartType(chartType),
            data: chartData,
            options: getChartOptions(chartType, isModal, hasCumulativeData)
        };
        
        // Store chartType for tooltip identification
        chartConfig.chartType = chartType;
        
        if (chartType === 'concentradoExpense') {
            console.log('Creating concentrado chart with config:', chartConfig);
        }
        
        chartInstances[canvasId] = new Chart(ctx, chartConfig);
        
        if (chartType === 'concentradoExpense') {
            console.log('Concentrado chart created successfully');
        }

    } catch (error) {
        console.error(`Error loading ${chartType} chart:`, error);
        if (loadingDiv) {
            loadingDiv.innerHTML = '<div class="alert alert-danger"><i class="fas fa-exclamation-circle me-2"></i>Error al cargar datos</div>';
        }
    }
}

// Process chart data based on type
function processChartData(data, chartType, config) {
    let labels, values, additionalData = {}, rawDataArray = [];

    switch(chartType) {
        case 'milkRevenue':
            // Monthly grouped data with new calculation logic
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            
            // Calculate cumulative milk production and income
            let cumulativeQuantity = 0;
            let cumulativeIncome = 0;
            
            const cumulativeData = data.map(item => {
                cumulativeQuantity += parseFloat(item.total_quantity);
                return cumulativeQuantity;
            });
            
            const cumulativeIncomeData = data.map(item => {
                cumulativeIncome += parseFloat(item.total_revenue);
                return cumulativeIncome;
            });
            
            values = data.map(item => parseFloat(item.total_revenue));
            
            // Store enhanced data for tooltips
            additionalData.monthlyData = data.map((item, index) => ({
                month: item.month,
                monthly_income: parseFloat(item.total_revenue),
                monthly_production: parseFloat(item.total_quantity),
                cumulative_income: cumulativeIncomeData[index],
                cumulative_production: cumulativeData[index]
            }));
            
            // Store cumulative data for second dataset
            additionalData.cumulativeQuantity = cumulativeData;
            break;
            
        case 'pesoRevenue':
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseFloat(item.total_revenue));
            break;
            
        case 'concentradoExpense':
            console.log('Processing concentradoExpense data:', data);
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseFloat(item.total_expense));
            console.log('Concentrado labels:', labels);
            console.log('Concentrado values:', values);
            
            // Calculate cumulative concentrado expenses
            let cumulativeExpense = 0;
            const cumulativeExpenseData = data.map(item => {
                cumulativeExpense += parseFloat(item.total_expense);
                return cumulativeExpense;
            });
            
            // Store raw data for tooltips with cumulative info
            rawDataArray = data.map((item, index) => ({
                month: item.month,
                total_expense: parseFloat(item.total_expense),
                total_quantity: parseFloat(item.total_quantity),
                avg_price: parseFloat(item.avg_price),
                record_count: parseInt(item.record_count),
                days_count: parseInt(item.days_count),
                cumulative_expense: cumulativeExpenseData[index]
            }));
            
            // Store cumulative data for second dataset
            additionalData.cumulativeExpense = cumulativeExpenseData;
            break;

        case 'melazaExpense':
            console.log('Processing melazaExpense data:', data);
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseFloat(item.total_expense));
            console.log('Melaza labels:', labels);
            console.log('Melaza values:', values);
            
            // Calculate cumulative melaza expenses
            let cumulativeMelazaExpense = 0;
            const cumulativeMelazaExpenseData = data.map(item => {
                cumulativeMelazaExpense += parseFloat(item.total_expense);
                return cumulativeMelazaExpense;
            });
            
            // Store raw data for tooltips with cumulative info
            rawDataArray = data.map((item, index) => ({
                month: item.month,
                total_expense: parseFloat(item.total_expense),
                total_quantity: parseFloat(item.total_quantity),
                avg_price: parseFloat(item.avg_price),
                record_count: parseInt(item.record_count),
                days_count: parseInt(item.days_count),
                cumulative_expense: cumulativeMelazaExpenseData[index]
            }));
            
            // Store cumulative data for second dataset
            additionalData.cumulativeExpense = cumulativeMelazaExpenseData;
            break;
            
        case 'salExpense':
            console.log('Processing salExpense data:', data);
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseFloat(item.total_expense));
            console.log('Salt labels:', labels);
            console.log('Salt values:', values);
            
            // Calculate cumulative salt expenses
            let cumulativeSalExpense = 0;
            const cumulativeSalExpenseData = data.map(item => {
                cumulativeSalExpense += parseFloat(item.total_expense);
                return cumulativeSalExpense;
            });
            
            // Store raw data for tooltips with cumulative info
            rawDataArray = data.map((item, index) => ({
                month: item.month,
                total_expense: parseFloat(item.total_expense),
                total_quantity: parseFloat(item.total_quantity),
                avg_price: parseFloat(item.avg_price),
                record_count: parseInt(item.record_count),
                days_count: parseInt(item.days_count),
                cumulative_expense: cumulativeSalExpenseData[index]
            }));
            
            // Store cumulative data for second dataset
            additionalData.cumulativeExpense = cumulativeSalExpenseData;
            break;
            
        case 'vaccineCosts':
            labels = data.map(item => item.vaccine_name);
            values = data.map(item => parseFloat(item.total_cost));
            break;
            
        case 'financialSummary':
            labels = data.map(item => item.category);
            values = data.map(item => parseFloat(item.amount));
            // Store additional data for tooltips
            additionalData.financialData = data.map(item => ({
                category: item.category,
                amount: item.formatted_amount,
                details: item.details
            }));
            break;
            
        case 'deaths':
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseInt(item.deaths_count));
            additionalData.causes = data.map(item => item.causes || 'No especificado');
            break;
            
        case 'discards':
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseInt(item.discards_count));
            additionalData.weights = data.map(item => item.avg_weight ? `${item.avg_weight} kg promedio` : 'Peso no disponible');
            break;
            
        case 'weaning':
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseInt(item.weaning_count));
            additionalData.weights = data.map(item => item.avg_weight ? `${item.avg_weight} kg promedio` : 'Peso no disponible');
            break;
            
        case 'insemination':
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseInt(item.insemination_count || item.count || 0));
            break;
            
        case 'sales':
            // Sales data for bar chart: Y-axis = precio_venta (total_revenue), X-axis = fecha_venta grouped by month
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseFloat(item.total_revenue));
            // Store additional data for tooltips
            additionalData.salesData = data.map(item => ({
                month: item.month,
                sales_count: item.sales_count,
                total_revenue: parseFloat(item.total_revenue),
                avg_price: parseFloat(item.avg_price),
                total_weight: parseFloat(item.total_weight),
                tagids: item.tagids || ''
            }));
            break;
            
        case 'purchases':
            // Purchases data for bar chart: Y-axis = precio_compra (total_price), X-axis = fecha_compra grouped by month
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseFloat(item.total_price));
            // Store additional data for tooltips
            additionalData.purchasesData = data.map(item => ({
                month: item.month,
                purchase_count: item.purchase_count,
                total_price: parseFloat(item.total_price),
                avg_price: parseFloat(item.avg_price),
                total_weight: parseFloat(item.total_weight),
                tagids: item.tagids || ''
            }));
            break;
            
        case 'allExpenses':
            // All Expenses data for pie chart - aggregate all categories across all months
            const categoryTotals = {};
            
            // Aggregate all expense categories across all months
            data.forEach(item => {
                const categories = item.categories || {};
                Object.entries(categories).forEach(([category, amount]) => {
                    if (!categoryTotals[category]) {
                        categoryTotals[category] = 0;
                    }
                    categoryTotals[category] += parseFloat(amount);
                });
            });
            
            // Sort categories by amount (highest first) and prepare for pie chart
            const sortedCategories = Object.entries(categoryTotals)
                .sort(([,a], [,b]) => b - a)
                .filter(([,amount]) => amount > 0);
            
            labels = sortedCategories.map(([category]) => category);
            values = sortedCategories.map(([,amount]) => amount);
            
            // Store additional data for tooltips
            additionalData.expensesData = sortedCategories.map(([category, amount]) => ({
                category: category,
                amount: amount,
                percentage: ((amount / sortedCategories.reduce((sum, [,amt]) => sum + amt, 0)) * 100).toFixed(1)
            }));
            
            // Store monthly data for detailed tooltips
            additionalData.monthlyBreakdown = data.map(item => ({
                month: item.month,
                total_expenses: parseFloat(item.total_expenses),
                feed_expenses: parseFloat(item.feed_expenses),
                health_expenses: parseFloat(item.health_expenses),
                categories: item.categories || {},
                details: item.details || {}
            }));
            break;
            
        default:
            labels = data.map(item => {
                const [year, month] = item.month.split('-');
                const monthNames = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            values = data.map(item => parseInt(item[Object.keys(item).find(key => key.includes('_count'))] || item.count || 0));
    }

    // Ensure rawData is always an array that matches the data length for other chart types
    if (rawDataArray.length === 0) {
        for (let i = 0; i < labels.length; i++) {
            if (data && data[i]) {
                rawDataArray[i] = data[i];
            } else {
                // Create fallback data object
                rawDataArray[i] = {
                    month: labels[i] || `Month ${i + 1}`,
                    tagids: '',
                    record_count: values[i] || 0
                };
            }
        }
    }

    // Create datasets array - default single dataset
    let datasets = [{
        label: config.title,
        data: values,
        backgroundColor: Array.isArray(config.color) ? config.color : config.color,
        borderColor: Array.isArray(config.borderColor) ? config.borderColor : config.borderColor,
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
        additionalData: additionalData,
        rawData: rawDataArray // Store properly structured raw data for tooltip access
    }];
    
    // Add second dataset for milkRevenue chart (cumulative milk production)
    if (chartType === 'milkRevenue' && additionalData.cumulativeQuantity) {
        datasets.push({
            label: 'Producción Acumulada (kg)',
            data: additionalData.cumulativeQuantity,
            type: 'line', // Line chart for cumulative data
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 3,
            fill: false,
            tension: 0.4,
            yAxisID: 'y1', // Use second y-axis
            pointBackgroundColor: 'rgba(54, 162, 235, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            additionalData: additionalData,
            rawData: rawDataArray
        });
    }
    
    // Add second dataset for concentrado chart (cumulative expenses)
    if (chartType === 'concentradoExpense' && additionalData.cumulativeExpense) {
        datasets.push({
            label: 'Gastos Acumulados ($)',
            data: additionalData.cumulativeExpense,
            type: 'line', // Line chart for cumulative data
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 3,
            fill: false,
            tension: 0.4,
            yAxisID: 'y1', // Use second y-axis
            pointBackgroundColor: 'rgba(255, 99, 132, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            additionalData: additionalData,
            rawData: rawDataArray
        });
    }
    
    // Add second dataset for melaza chart (cumulative expenses)
    if (chartType === 'melazaExpense' && additionalData.cumulativeExpense) {
        datasets.push({
            label: 'Gastos Acumulados ($)',
            data: additionalData.cumulativeExpense,
            type: 'line', // Line chart for cumulative data
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            borderColor: 'rgba(255, 159, 64, 1)',
            borderWidth: 3,
            fill: false,
            tension: 0.4,
            yAxisID: 'y1', // Use second y-axis
            pointBackgroundColor: 'rgba(255, 159, 64, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            additionalData: additionalData,
            rawData: rawDataArray
        });
    }
    
    // Add second dataset for salt chart (cumulative expenses)
    if (chartType === 'salExpense' && additionalData.cumulativeExpense) {
        datasets.push({
            label: 'Gastos Acumulados ($)',
            data: additionalData.cumulativeExpense,
            type: 'line', // Line chart for cumulative data
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 3,
            fill: false,
            tension: 0.4,
            yAxisID: 'y1', // Use second y-axis
            pointBackgroundColor: 'rgba(75, 192, 192, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            additionalData: additionalData,
            rawData: rawDataArray
        });
    }
    

    
    // Configure pie chart for allExpenses chart
    if (chartType === 'allExpenses') {
        // Professional pie chart colors for different expense categories
        const pieColors = [
            'rgba(220, 53, 69, 0.8)',   // Red
            'rgba(255, 193, 7, 0.8)',   // Amber
            'rgba(40, 167, 69, 0.8)',   // Green
            'rgba(0, 123, 255, 0.8)',   // Blue
            'rgba(102, 16, 242, 0.8)',  // Purple
            'rgba(253, 126, 20, 0.8)',  // Orange
            'rgba(108, 117, 125, 0.8)', // Gray
            'rgba(32, 201, 151, 0.8)',  // Teal
            'rgba(232, 62, 140, 0.8)',  // Pink
            'rgba(13, 202, 240, 0.8)',  // Cyan
            'rgba(50, 205, 50, 0.8)',   // Lime
            'rgba(255, 105, 180, 0.8)'  // Hot Pink
        ];
        
        const pieBorderColors = [
            'rgba(220, 53, 69, 1)',
            'rgba(255, 193, 7, 1)',
            'rgba(40, 167, 69, 1)',
            'rgba(0, 123, 255, 1)',
            'rgba(102, 16, 242, 1)',
            'rgba(253, 126, 20, 1)',
            'rgba(108, 117, 125, 1)',
            'rgba(32, 201, 151, 1)',
            'rgba(232, 62, 140, 1)',
            'rgba(13, 202, 240, 1)',
            'rgba(50, 205, 50, 1)',
            'rgba(255, 105, 180, 1)'
        ];
        
        // Single dataset for pie chart with multiple colors
        datasets = [{
            label: 'Gastos por Categoría',
            data: values,
            backgroundColor: pieColors.slice(0, values.length),
            borderColor: pieBorderColors.slice(0, values.length),
            borderWidth: 2,
            hoverOffset: 4,
            additionalData: additionalData,
            rawData: rawDataArray
        }];
    }

    return {
        labels: labels,
        datasets: datasets
    };
}

// Get chart type based on data
function getChartType(chartType) {
    // Mixed charts (bar + line) for expense charts with cumulative data
    if (chartType === 'milkRevenue' || chartType === 'concentradoExpense' || chartType === 'melazaExpense' || chartType === 'salExpense') {
        return 'bar'; // Base type is bar, line will be added as secondary dataset
    }
    
    // allExpenses uses pie chart for better expense distribution visualization
    if (chartType === 'allExpenses') {
        return 'pie';
    }
    
    const barChartTypes = ['vaccineCosts', 'deaths', 'discards', 'weaning', 'insemination', 'financialSummary', 'sales', 'purchases'];
    return barChartTypes.includes(chartType) ? 'bar' : 'line';
}

// Get chart options
function getChartOptions(chartType, isModal = false, hasCumulativeData = false) {
    const baseOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: chartConfigs[chartType].title,
                font: {
                    size: isModal ? 18 : 14,
                    weight: 'bold'
                },
                color: '#333'
            },
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: isModal ? 14 : 12,
                        weight: '500'
                    },
                    color: '#666'
                }
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                beginAtZero: true,
                title: {
                    display: chartType === 'milkRevenue' || chartType === 'concentradoExpense' || chartType === 'melazaExpense' || chartType === 'salExpense' || chartType === 'financialSummary',
                    text: chartType === 'milkRevenue' ? 'Ingresos ($)' : 
                          chartType === 'financialSummary' ? 'Monto ($)' : 'Gastos Mensuales ($)',
                    color: '#666',
                    font: {
                        size: isModal ? 14 : 12,
                        weight: 'bold'
                    }
                },
                ticks: {
                    font: {
                        size: isModal ? 12 : 10
                    },
                    color: '#666',
                    callback: function(value) {
                        if (chartType === 'milkRevenue' || chartType === 'concentradoExpense' || chartType === 'melazaExpense' || chartType === 'salExpense' || chartType === 'financialSummary') {
                            return '$' + value.toLocaleString();
                        }
                        return value;
                    }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            },
            x: {
                ticks: {
                    font: {
                        size: isModal ? 12 : 10
                    },
                    color: '#666',
                    maxRotation: 45
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.1)'
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    };

    // Only add y1 axis if there's cumulative data
    if (hasCumulativeData && (chartType === 'milkRevenue' || chartType === 'concentradoExpense' || chartType === 'melazaExpense' || chartType === 'salExpense')) {
        // Define colors for each chart type
        let axisColor, axisText;
        if (chartType === 'milkRevenue') {
            axisColor = 'rgba(54, 162, 235, 1)';
            axisText = 'Producción Acumulada (kg)';
        } else if (chartType === 'concentradoExpense') {
            axisColor = 'rgba(255, 99, 132, 1)';
            axisText = 'Gastos Acumulados ($)';
        } else if (chartType === 'melazaExpense') {
            axisColor = 'rgba(255, 159, 64, 1)';
            axisText = 'Gastos Acumulados ($)';
        } else if (chartType === 'salExpense') {
            axisColor = 'rgba(75, 192, 192, 1)';
            axisText = 'Gastos Acumulados ($)';
        }
        
        baseOptions.scales.y1 = {
            type: 'linear',
            display: true,
            position: 'right',
            beginAtZero: true,
            title: {
                display: true,
                text: axisText,
                color: axisColor,
                font: {
                    size: isModal ? 14 : 12,
                    weight: 'bold'
                }
            },
            ticks: {
                font: {
                    size: isModal ? 12 : 10
                },
                color: axisColor,
                callback: function(value) {
                    if (chartType === 'milkRevenue') {
                        return value.toLocaleString() + ' kg';
                    } else {
                        return '$' + value.toLocaleString();
                    }
                }
            },
            grid: {
                drawOnChartArea: false, // Don't draw grid lines for second axis
            }
        };
    }

    // Add custom tooltips for specific chart types
    const tooltipChartTypes = ['deaths', 'discards', 'weaning', 'insemination', 'milkRevenue', 'concentradoExpense', 'melazaExpense', 'salExpense', 'financialSummary', 'allExpenses'];
    if (tooltipChartTypes.includes(chartType)) {
        baseOptions.plugins.tooltip = {
            enabled: true,
            mode: 'index',
            intersect: false,
            position: 'nearest',
            external: null,
            callbacks: {
                title: function(context) {
                    // Always show a title, use the label or fallback
                    return context[0] && context[0].label ? context[0].label : 'Mes';
                },

                label: function(context) {
                    try {
                        const dataset = context.dataset;
                        const dataIndex = context.dataIndex;
                        const chartType = context.chart.config.chartType || 'unknown';
                        
                        // Special handling for milkRevenue chart - check multiple ways to identify
                        const isMilkRevenueChart = chartType === 'milkRevenue' || 
                                                  context.chart.canvas.id.includes('milkRevenue') ||
                                                  context.chart.canvas.id === 'modalChart' && currentExpandedChart === 'milkRevenue';
                        
                        if (isMilkRevenueChart) {
                            // Handle both revenue bars and cumulative production line
                            if (dataset && dataset.additionalData && dataset.additionalData.monthlyData && dataset.additionalData.monthlyData[dataIndex]) {
                                const monthData = dataset.additionalData.monthlyData[dataIndex];
                                
                                // Return organized 4-figure tooltip
                                const lines = [
                                    `Ingreso Mensual: $${monthData.monthly_income.toLocaleString()}`,
                                    `Producción Mensual: ${monthData.monthly_production.toLocaleString()} kg`,
                                    `Ingreso Acumulado: $${monthData.cumulative_income.toLocaleString()}`,
                                    `Producción Acumulada: ${monthData.cumulative_production.toLocaleString()} kg`
                                ];
                                
                                return lines;
                            }
                            
                            // Fallback with basic info if detailed data is not available
                            return [
                                `Valor: ${context.parsed.y.toLocaleString()}`
                            ];
                        }
                        
                        // Special handling for concentradoExpense chart
                        const isConcentradoChart = chartType === 'concentradoExpense' || 
                                                  context.chart.canvas.id.includes('concentrado') ||
                                                  context.chart.canvas.id === 'modalChart' && currentExpandedChart === 'concentradoExpense';
                        
                        if (isConcentradoChart) {
                            
                            if (dataset && dataset.rawData && dataset.rawData[dataIndex]) {
                                const monthData = dataset.rawData[dataIndex];
                                
                                // Return organized tooltip with expense details
                                const lines = [
                                    `Gasto Mensual: $${monthData.total_expense.toLocaleString()}`,
                                    `Cantidad Mensual: ${monthData.total_quantity.toLocaleString()} kg`,
                                    `Precio Promedio: $${monthData.avg_price.toLocaleString()}`,
                                    `Gasto Acumulado: $${monthData.cumulative_expense.toLocaleString()}`,
                                    `Registros: ${monthData.record_count}`,
                                    `Días: ${monthData.days_count}`
                                ];
                                
                                return lines;
                            }
                            
                            // Fallback with basic info if detailed data is not available
                            return [
                                `Gasto: $${context.parsed.y.toLocaleString()}`
                            ];
                        }
                        
                        // Special handling for melazaExpense chart
                        const isMelazaChart = chartType === 'melazaExpense' || 
                                             context.chart.canvas.id.includes('melaza') ||
                                             context.chart.canvas.id === 'modalChart' && currentExpandedChart === 'melazaExpense';
                        
                        if (isMelazaChart) {
                            
                            if (dataset && dataset.rawData && dataset.rawData[dataIndex]) {
                                const monthData = dataset.rawData[dataIndex];
                                
                                // Return organized tooltip with expense details
                                const lines = [
                                    `Gasto Mensual: $${monthData.total_expense.toLocaleString()}`,
                                    `Cantidad Mensual: ${monthData.total_quantity.toLocaleString()} kg`,
                                    `Precio Promedio: $${monthData.avg_price.toLocaleString()}`,
                                    `Gasto Acumulado: $${monthData.cumulative_expense.toLocaleString()}`,
                                    `Registros: ${monthData.record_count}`,
                                    `Días: ${monthData.days_count}`
                                ];
                                
                                return lines;
                            }
                            
                            // Fallback with basic info if detailed data is not available
                            return [
                                `Gasto: $${context.parsed.y.toLocaleString()}`
                            ];
                        }
                        
                        // Special handling for salExpense chart
                        const isSalChart = chartType === 'salExpense' || 
                                          context.chart.canvas.id.includes('sal') ||
                                          context.chart.canvas.id === 'modalChart' && currentExpandedChart === 'salExpense';
                        
                        if (isSalChart) {
                            
                            if (dataset && dataset.rawData && dataset.rawData[dataIndex]) {
                                const monthData = dataset.rawData[dataIndex];
                                
                                // Return organized tooltip with expense details
                                const lines = [
                                    `Gasto Mensual: $${monthData.total_expense.toLocaleString()}`,
                                    `Cantidad Mensual: ${monthData.total_quantity.toLocaleString()} kg`,
                                    `Precio Promedio: $${monthData.avg_price.toLocaleString()}`,
                                    `Gasto Acumulado: $${monthData.cumulative_expense.toLocaleString()}`,
                                    `Registros: ${monthData.record_count}`,
                                    `Días: ${monthData.days_count}`
                                ];
                                
                                return lines;
                            }
                            
                            // Fallback with basic info if detailed data is not available
                            return [
                                `Gasto: $${context.parsed.y.toLocaleString()}`
                            ];
                        }
                        
                        // Special handling for financialSummary chart
                        const isFinancialSummaryChart = chartType === 'financialSummary' || 
                                                       context.chart.canvas.id.includes('financialSummary') ||
                                                       context.chart.canvas.id === 'modalChart' && currentExpandedChart === 'financialSummary';
                        
                        if (isFinancialSummaryChart) {
                            if (dataset && dataset.additionalData && dataset.additionalData.financialData && dataset.additionalData.financialData[dataIndex]) {
                                const financialData = dataset.additionalData.financialData[dataIndex];
                                const lines = [
                                    `${financialData.category}: $${parseFloat(financialData.amount).toLocaleString()}`
                                ];
                                
                                // Add details for Income category
                                if (financialData.category === 'Ingresos' && financialData.details) {
                                    if (financialData.details.milk_income && parseFloat(financialData.details.milk_income) > 0) {
                                        lines.push(`  - Leche: $${parseFloat(financialData.details.milk_income).toLocaleString()}`);
                                    }
                                    if (financialData.details.sales_income && parseFloat(financialData.details.sales_income) > 0) {
                                        lines.push(`  - Ventas: $${parseFloat(financialData.details.sales_income).toLocaleString()}`);
                                    }
                                }
                                
                                return lines;
                            }
                            return [
                                `Monto: $${context.parsed.y.toLocaleString()}`
                            ];
                        }
                        
                        // Special handling for allExpenses pie chart
                        const isAllExpensesChart = chartType === 'allExpenses' || 
                                                  context.chart.canvas.id.includes('allExpenses') ||
                                                  context.chart.canvas.id === 'modalChart' && currentExpandedChart === 'allExpenses';
                        
                        if (isAllExpensesChart) {
                            if (dataset && dataset.additionalData && dataset.additionalData.expensesData && dataset.additionalData.expensesData[dataIndex]) {
                                const expenseData = dataset.additionalData.expensesData[dataIndex];
                                const lines = [
                                    `${expenseData.category}`,
                                    `Monto: $${parseFloat(expenseData.amount).toLocaleString()}`,
                                    `Porcentaje: ${expenseData.percentage}%`
                                ];
                                
                                // Add category type information
                                const feedCategories = ['Concentrado', 'Melaza', 'Sal'];
                                const healthCategories = ['Aftosa', 'Brucelosis', 'IBR', 'CBR', 'Carbunco', 'Garrapatas', 'Lombrices'];
                                
                                if (feedCategories.includes(expenseData.category)) {
                                    lines.push('Tipo: Alimentación');
                                } else if (healthCategories.includes(expenseData.category)) {
                                    lines.push('Tipo: Sanitario');
                                }
                                
                                return lines;
                            }
                            return [
                                `Monto: $${context.parsed.toLocaleString()}`
                            ];
                        }
                        
                        // Original logic for other chart types
                        let rawData = null;
                        if (dataset && dataset.rawData && Array.isArray(dataset.rawData) && dataset.rawData[dataIndex]) {
                            rawData = dataset.rawData[dataIndex];
                        }
                        
                        // Extract tag IDs with comprehensive validation
                        if (rawData && rawData.tagids) {
                            const tagidsString = String(rawData.tagids).trim();
                            if (tagidsString && tagidsString !== '' && tagidsString !== 'null' && tagidsString !== 'undefined') {
                                const tagIds = tagidsString.split(',')
                                    .map(tag => String(tag).trim())
                                    .filter(tag => tag && tag !== '' && tag !== 'null' && tag !== 'undefined');
                                
                                if (tagIds.length > 0) {
                                    return tagIds.join(', ');
                                }
                            }
                        }
                        
                        // Fallback: Show that there are records but no tag IDs
                        if (context.parsed && context.parsed.y > 0) {
                            return `${context.parsed.y} registros - Sin Tag IDs`;
                        }
                        
                        return 'Sin datos disponibles';
                        
                    } catch (error) {
                        console.warn('Tooltip error:', error);
                        return 'Error al cargar datos';
                    }
                },
                beforeBody: function() {
                    return null; // No additional content before body
                },
                afterBody: function() {
                    return null; // No additional content after body
                },
                footer: function() {
                    return null; // No footer content
                }
            },
            backgroundColor: 'rgba(0, 0, 0, 0.85)',
            titleColor: '#ffffff',
            bodyColor: '#ffffff',
            borderColor: '#555555',
            borderWidth: 1,
            cornerRadius: 6,
            displayColors: false,
            titleFont: {
                size: 13,
                weight: 'bold'
            },
            bodyFont: {
                size: 12,
                lineHeight: 1.3
            },
            padding: 10,
            caretPadding: 4,
            caretSize: 5,
            multiKeyBackground: 'transparent',
            filter: function(tooltipItem) {
                // For expense charts with cumulative data, only show tooltip for the first dataset (bars)
                const isMilkRevenueChart = tooltipItem.chart.config.chartType === 'milkRevenue' || 
                                          tooltipItem.chart.canvas.id.includes('milkRevenue') ||
                                          tooltipItem.chart.canvas.id === 'modalChart' && currentExpandedChart === 'milkRevenue';
                
                const isConcentradoChart = tooltipItem.chart.config.chartType === 'concentradoExpense' || 
                                          tooltipItem.chart.canvas.id.includes('concentrado') ||
                                          tooltipItem.chart.canvas.id === 'modalChart' && currentExpandedChart === 'concentradoExpense';
                
                const isMelazaChart = tooltipItem.chart.config.chartType === 'melazaExpense' || 
                                     tooltipItem.chart.canvas.id.includes('melaza') ||
                                     tooltipItem.chart.canvas.id === 'modalChart' && currentExpandedChart === 'melazaExpense';
                
                const isSalChart = tooltipItem.chart.config.chartType === 'salExpense' || 
                                  tooltipItem.chart.canvas.id.includes('sal') ||
                                  tooltipItem.chart.canvas.id === 'modalChart' && currentExpandedChart === 'salExpense';
                
                if (isMilkRevenueChart || isConcentradoChart || isMelazaChart || isSalChart) {
                    return tooltipItem.datasetIndex === 0; // Only show for first dataset (bars)
                }
                
                // Always show tooltip for other chart types
                return true;
            },
            itemSort: function(a, b) {
                // Keep original order
                return 0;
            }
        };
        
        // Optimize interaction settings for better tooltip detection
        baseOptions.interaction = {
            intersect: false,
            mode: 'index',
            axis: 'x'
        };
        
        // Ensure hover settings work properly
        baseOptions.onHover = function(event, activeElements) {
            event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
        };
    }
    
    // Special options for allExpenses pie chart
    if (chartType === 'allExpenses') {
        baseOptions.plugins.legend = {
            display: true,
            position: 'right',
            labels: {
                font: {
                    size: isModal ? 14 : 12
                },
                color: '#666',
                padding: 15,
                usePointStyle: true,
                generateLabels: function(chart) {
                    const data = chart.data;
                    if (data.labels.length && data.datasets.length) {
                        const dataset = data.datasets[0];
                        const expensesData = dataset.additionalData?.expensesData || [];
                        
                        return data.labels.map((label, index) => {
                            const expense = expensesData[index];
                            const displayText = expense ? 
                                `${label}: $${parseFloat(expense.amount).toLocaleString()} (${expense.percentage}%)` : 
                                label;
                            
                            return {
                                text: displayText,
                                fillStyle: dataset.backgroundColor[index],
                                strokeStyle: dataset.borderColor[index],
                                pointStyle: 'circle',
                                hidden: false,
                                index: index
                            };
                        });
                    }
                    return [];
                }
            }
        };
        
        // Remove scales for pie chart
        delete baseOptions.scales;
        
        // Update interaction mode for pie chart
        baseOptions.interaction = {
            intersect: true,
            mode: 'point'
        };
        
        // Add professional pie chart animations
        baseOptions.animation = {
            animateRotate: true,
            animateScale: false,
            duration: 1000,
            easing: 'easeOutQuart'
        };
        
        // Enhance pie chart layout
        baseOptions.layout = {
            padding: {
                top: 20,
                bottom: 20,
                left: 20,
                right: 20
            }
        };
    }
    
    return baseOptions;
}

// Expand chart to full screen
function expandChart(chartType) {
    const config = chartConfigs[chartType];
    if (!config) return;

    currentExpandedChart = chartType;
    
    // Update modal title
    const modalTitle = document.getElementById('modalChartTitle');
    modalTitle.innerHTML = `<i class="${config.icon}"></i> ${config.title}`;
    
    // Show modal
    const modal = document.getElementById('chartModal');
    modal.classList.add('active');
    
    // Load chart in modal
    setTimeout(() => {
        loadChart(chartType, 'modalChart', true);
    }, 300);
}

// Close chart modal
function closeChartModal() {
    const modal = document.getElementById('chartModal');
    modal.classList.remove('active');
    
    // Destroy modal chart
    if (chartInstances['modalChart']) {
        chartInstances['modalChart'].destroy();
        delete chartInstances['modalChart'];
    }
    
    currentExpandedChart = null;
}

// Export chart to PDF
async function exportChartPDF(chartType) {
    const config = chartConfigs[chartType];
    if (!config) return;

    try {
        const canvas = document.getElementById(`${chartType}Chart`);
        if (!canvas) return;

        // Show loading state
        Swal.fire({
            title: 'Generando PDF...',
            text: 'Por favor espere',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Create PDF
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('landscape', 'mm', 'a4');

        // Add title
        pdf.setFontSize(18);
        pdf.setFont(undefined, 'bold');
        pdf.text(config.title, 20, 25);

        // Add subtitle
        pdf.setFontSize(12);
        pdf.setFont(undefined, 'normal');
        pdf.text('Sistema de Gestión Ganadera - Ganagram', 20, 35);

        // Convert canvas to image
        const imgData = canvas.toDataURL('image/png');
        const imgWidth = 250;
        const imgHeight = 150;
        
        // Center the image
        const x = (297 - imgWidth) / 2;
        const y = 45;
        
        pdf.addImage(imgData, 'PNG', x, y, imgWidth, imgHeight);

        // Add footer
        const pageHeight = pdf.internal.pageSize.height;
        pdf.setFontSize(10);
        pdf.setTextColor(128, 128, 128);
        pdf.text('Sistema de Gestión Ganadera - Ganagram', 20, pageHeight - 15);
        
        const now = new Date();
        pdf.text(`Generado: ${now.toLocaleDateString()}`, 200, pageHeight - 15);

        // Save the PDF
        const filename = `${chartType}_${now.getFullYear()}_${(now.getMonth()+1).toString().padStart(2,'0')}_${now.getDate().toString().padStart(2,'0')}.pdf`;
        pdf.save(filename);

        // Show success message
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'El reporte PDF se ha generado correctamente',
            timer: 2000,
            showConfirmButton: false
        });

    } catch (error) {
        console.error('Error generating PDF:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo generar el PDF: ' + error.message
        });
    }
}

// Close modal when clicking outside
document.getElementById('chartModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeChartModal();
    }
});

// Escape key to close modal
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && currentExpandedChart) {
        closeChartModal();
    }
});

// Load all charts when page is ready
document.addEventListener('DOMContentLoaded', function() {
    // Load all dashboard charts
    Object.keys(chartConfigs).forEach(chartType => {
        loadChart(chartType, `${chartType}Chart`);
    });
});

// Resize handler to update charts
window.addEventListener('resize', function() {
    Object.values(chartInstances).forEach(chart => {
        if (chart) {
            chart.resize();
        }
    });
});
</script>

</body>
</html>