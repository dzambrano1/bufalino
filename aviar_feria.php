<?php
// Include the session check file
require_once 'check_session.php';

// Require login for this page
requireLogin();

// Check if user has a valid role (admin, usuario, or comprador)
if ($_SESSION["role"] !== "admin" && $_SESSION["role"] !== "usuario" && $_SESSION["role"] !== "comprador") {
    // Redirect to permission denied or home page
    header("Location: login.php?error=permission_denied");
    exit();
}

// Check user role
$user_logged_in = $isUserLoggedIn; // Use the value from check_session.php
$user_role = $user_logged_in ? $_SESSION["role"] : "cliente";
$user_id = $user_logged_in ? $_SESSION["user_id"] : null;

// Include database connection (PDO)
require_once "./pdo_conexion.php"; 

// Check if we have a valid PDO connection
if (!isset($conn) || !($conn instanceof PDO)) {
    error_log("bufalino_feria.php failed: PDO connection not available in pdo_conexion.php");
    die("Database connection failed. Please try again later.");
}

// Initialize variables
$item_count = 0;
$categories = [];
$brands = [];
$diameters = [];
$ussages = [];
$my_animals = [];
$error_message = '';
$success_message = '';

// --- Get cart item count --- 
if ($user_logged_in) {
    try {
        $cart_query = "SELECT SUM(quantity) FROM cart_items WHERE user_id = :user_id";
        $stmt = $conn->prepare($cart_query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $item_count = (int)$stmt->fetchColumn() ?: 0;
    } catch (PDOException $e) {
        error_log("Error fetching cart count: " . $e->getMessage());
        // Silently fail, just don't show the cart count
        $item_count = 0;
    }
}

// --- Get unique filter options (only for animals currently in feria) --- 
try {
    $base_filter_query = "FROM bufalino WHERE estatus = 'Feria' AND precio > 0";
    
    $tagid_query = "SELECT DISTINCT tagid $base_filter_query AND tagid != '' ORDER BY tagid";
    $tagid_stmt = $conn->query($tagid_query);
    $tagids = $tagid_stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $nombre_query = "SELECT DISTINCT nombre $base_filter_query AND nombre != '' ORDER BY nombre";
    $nombre_stmt = $conn->query($nombre_query);
    $nombres = $nombre_stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
    $raza_query = "SELECT DISTINCT raza $base_filter_query AND raza != '' ORDER BY raza";
    $raza_stmt = $conn->query($raza_query);
    $razas = $raza_stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    $genero_query = "SELECT DISTINCT genero $base_filter_query AND genero != '' ORDER BY genero";
    $genero_stmt = $conn->query($genero_query);
    $generos = $genero_stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    // Fetch user's animals not yet in feria for the listing modal (admin only)
    if ($user_role === 'admin') {
        $my_animals_query = "SELECT tagid, nombre, genero, raza 
                             FROM bufalino 
                             WHERE estatus != 'Feria' -- Animals NOT currently in feria
                             ORDER BY nombre";
        $my_animals_stmt = $conn->query($my_animals_query);
        $my_animals = $my_animals_stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    error_log("Database error fetching filter options: " . $e->getMessage());
    die("Error cargando opciones de filtro: " . $e->getMessage());
}

// --- Handle form submission for new listings (Admin Only) --- 
if ($user_role === 'admin' && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'new_listing') {
    $tagid = $_POST['tagid'] ?? '';
    $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
    $fecha_publicacion = date('Y-m-d H:i:s'); // Use datetime for precision
    
    // Basic Validation
    if (empty($tagid) || $precio === false || $precio <= 0) {
        $error_message = "Por favor, seleccione un animal y ingrese un precio válido.";
    } else {
        try {
            // Check if animal exists and is NOT already in feria
            $check_sql = "SELECT tagid, estatus FROM bufalino WHERE tagid = :tagid";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bindParam(':tagid', $tagid, PDO::PARAM_STR);
            $check_stmt->execute();
            $animal_data = $check_stmt->fetch(PDO::FETCH_ASSOC);

            if (!$animal_data) {
                $error_message = "El animal con TagID {$tagid} no existe.";
            } elseif ($animal_data['estatus'] === 'Feria') {
                $error_message = "Este animal ya está listado en la feria.";
            } else {
                // Update bufalino record with precio, fecha_publicacion, and estatus
                $update_sql = "UPDATE bufalino SET precio = :precio, fecha_publicacion = :fecha, estatus = 'Feria' WHERE tagid = :tagid";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bindParam(':precio', $precio, PDO::PARAM_STR); // Treat decimal as string for PDO
                $update_stmt->bindParam(':fecha', $fecha_publicacion, PDO::PARAM_STR);
                $update_stmt->bindParam(':tagid', $tagid, PDO::PARAM_STR);
                
                if ($update_stmt->execute()) {
                    $success_message = "Animal {$tagid} publicado exitosamente en la feria.";
                    // Refresh the list of user's animals for the modal
                    $my_animals_query = "SELECT tagid, nombre, genero, raza FROM bufalino WHERE estatus != 'Feria' ORDER BY nombre";
                    $my_animals_stmt = $conn->query($my_animals_query);
                    $my_animals = $my_animals_stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $error_message = "Error al publicar el animal.";
                    error_log("Error executing update statement for tagid {$tagid}: " . implode(", ", $update_stmt->errorInfo()));
                }
            }
        } catch (PDOException $e) {
            $error_message = "Error de base de datos al publicar: " . $e->getMessage();
            error_log($error_message);
        }
    }
}

// Note: The old logic for fetching all listings and contact details is removed 
// as the table is now populated by AJAX via get_feria_animals.php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feria Ganadera</title> <!-- Changed title -->
    <!-- CSS Includes remain the same -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="bufalino.css">
    <style>
        /* Existing styles... */
         /* Set fixed heights and spacings */
        
        .product-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: contain;
        }
        .product-image-modal {
            max-height: 150px;
            max-width: 100%;
        }
        .filters-container {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-upload {
            border: 2px dashed #4e6c41;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s;
        }
        .btn-upload:hover {
            background-color: #e2e6ea;
            border-color: #4e6c41;
        }
        .modal-header {
            background-color: #4e6c41;
            color: white;
        }
        .modal-footer {
            border-top: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .image-magnifier {
            cursor: zoom-in;
            transition: transform 0.2s;
        }
        .image-magnifier:hover {
            transform: scale(1.5);
        }
        .selected-file {
            font-size: 0.9rem;
            margin-top: 5px;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        #productModal .modal-content {
            animation: fadeIn 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            border-radius: 10px;
        }
        #productsTable td, #productsTable th {
            text-align: center; /* Center align all table content */
            vertical-align: middle; /* Vertically align */
        }
        
        /* Enhanced Table Headers */
        #productsTable thead th {
            background: linear-gradient(135deg, #4e6c41, #759c63);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 12px 15px;
            border: none;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        #productsTable thead th::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transform: skewX(-25deg);
            transition: all 0.5s;
        }
        
        #productsTable thead:hover th::after {
            left: 100%;
        }
        
        #productsTable thead th:first-child {
            border-top-left-radius: 8px;
        }
        
        #productsTable thead th:last-child {
            border-top-right-radius: 8px;
        }
        
        #productsTable tbody tr:hover {
            background-color: rgba(78, 108, 65, 0.05); /* Light green hover */
            transition: background-color 0.3s;
        }
        
        /* 3D Depth for Filters Container */
        .filters-container {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05),
                        0 1px 3px rgba(0, 0, 0, 0.1),
                        0 -1px 0 rgba(255, 255, 255, 0.8) inset;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transform: perspective(1000px) translateZ(0);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .filters-container:hover {
            transform: perspective(1000px) translateZ(5px); /* Less pronounced Z transform */
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.07), /* Adjusted shadow */
                        0 1px 3px rgba(0, 0, 0, 0.1),
                        0 -1px 0 rgba(255, 255, 255, 0.8) inset;
        }
        
        .filters-container h5 {
            font-weight: 700;
            color: #4e6c41;
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.8);
        }
        
        .filters-container h5::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 40px;
            height: 3px;
            background: linear-gradient(to right, #4e6c41, #759c63);
            transition: width 0.3s ease;
            border-radius: 3px;
        }
        
        .filters-container h5:hover::after {
            width: 100%;
        }
        
        /* 3D Form Controls */
        .filters-container .form-control,
        .filters-container .form-select {
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 10px 15px;
            background: linear-gradient(to bottom, #f9f9f9, #ffffff);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05),
                        0 1px 2px rgba(255, 255, 255, 0.9) inset;
            transition: all 0.3s ease;
        }
        
        .filters-container .form-control:focus,
        .filters-container .form-select:focus {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(78, 108, 65, 0.1), /* Greenish shadow */
                        0 1px 0 rgba(255, 255, 255, 0.9) inset;
            border-color: rgba(78, 108, 65, 0.4);
        }
        
        /* 3D Filter Buttons */
        .filters-container .btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1),
                        0 -1px 0 rgba(255, 255, 255, 0.2) inset;
            border: none;
        }
        
        .filters-container .btn-primary {
            background: linear-gradient(135deg, #4e6c41, #759c63);
            border: none;
        }
        
        .filters-container .btn-outline-secondary {
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
            color: #6c757d;
            border: 1px solid #ced4da;
        }
        
        .filters-container .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1),
                        0 -1px 0 rgba(255, 255, 255, 0.2) inset;
        }
        
        .filters-container .btn:active {
            transform: translateY(1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1),
                        0 -1px 0 rgba(255, 255, 255, 0.2) inset;
        }
        
        /* 3D Enhanced DataTable */
        .table-responsive {
            border-radius: 10px;
            padding: 2px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.07),
                        0 5px 15px rgba(0, 0, 0, 0.05);
            background: linear-gradient(to bottom, rgba(255,255,255,0.01), rgba(255,255,255,0.08));
            transform: perspective(1000px) translateZ(0);
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .table-responsive:hover {
            transform: perspective(1000px) translateZ(3px); /* Less pronounced Z transform */
            box-shadow: 0 18px 38px rgba(0, 0, 0, 0.08), /* Adjusted shadow */
                        0 8px 18px rgba(0, 0, 0, 0.06);
        }
        
        /* Image lightbox styles */
        .fullscreen-image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
            cursor: zoom-out;
        }
        
        .lightbox-container {
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }
        
        .fullscreen-image-content {
            max-width: 100%;
            max-height: 90vh;
            object-fit: contain;
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }
        
        .product-code-display {
            position: absolute;
            bottom: -60px; /* Adjusted position */
            left: 50%;
            transform: translateX(-50%);
            width: auto; /* Adjust width based on content */
            max-width: 90%; /* Max width relative to viewport */
            text-align: center;
            background-color: rgba(40, 40, 40, 0.85) !important; /* Darker semi-transparent background */
            color: white;
            padding: 10px 20px; /* Adjusted padding */
            font-size: 14px; /* Slightly smaller font size */
            border-radius: 8px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            z-index: 10000;
            letter-spacing: 0.5px;
            display: flex;
            flex-direction: column; /* Stack rows vertically */
            align-items: center;
        }
        
        .product-code-display .product-info-row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap; /* Allow items to wrap */
            width: 100%;
            margin-bottom: 5px;
        }
        .product-code-display .product-info-row:last-child {
            margin-bottom: 0;
        }
        
        .product-code-display .product-info-item {
            margin: 3px 10px; /* Add vertical margin */
            display: inline-block;
            white-space: nowrap; /* Prevent wrapping within an item */
        }
        
        .product-code-display .product-info-label {
            font-weight: normal;
            opacity: 0.8;
            margin-right: 4px;
        }
        
        .product-code-display .product-info-value {
            font-weight: bold;
            background: rgba(0,0,0,0.2);
            padding: 2px 6px;
            border-radius: 4px;
        }
        
        .close-lightbox {
            position: absolute;
            top: 15px;
            right: 25px;
            color: white;
            font-size: 35px;
            font-weight: bold;
            cursor: pointer;
            text-shadow: 0 0 5px rgba(0,0,0,0.5);
        }
        
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.5);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }
        
        .whatsapp-btn {
            background: linear-gradient(135deg, #4e6c41, #759c63) !important;
            border: none !important;
        }
        
        .whatsapp-btn:hover {
            background: linear-gradient(135deg, #3d5834, #4e6c41) !important; /* Darker green hover */
        }
        
        .title-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        
        .title-container .row {
            width: 100%;
        }
                
        /* Navigation Links Container */
        .nav-links-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0px;
            padding: 0px 0;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .nav-link-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 15px;
            min-width: 50px;
        }
        
        .nav-link-item .nav-img {
            margin-bottom: 5px;
            transition: transform 0.3s ease;
        }
        
        .nav-link-item:hover .nav-img {
            transform: translateY(-3px);
        }
        
        .nav-link-item .nav-link {
            color: #4e6c41 !important;
            font-weight: 600;
            padding: 0.5rem 0.5rem !important;
            border-radius: 6px;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
        }
        
        .nav-link-item .nav-link:hover {
            color: #355a27 !important;
        }
        
        .nav-link-item .nav-link.active {
            color: #1e3c14 !important;
            font-weight: 700;
            position: relative;
        }
        
        .nav-link-item .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background: #4e6c41;
            border-radius: 2px;
        }
        
        @media (max-width: 768px) {
            .nav-link-item {
                margin: 0 10px;
                min-width: 80px;
            }
            
            .nav-link-item .nav-link {
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 576px) {
            .nav-link-item {
                margin: 0 5px;
                min-width: 50px;
            }
            
            .nav-link-item .nav-link {
                font-size: 0.7rem;
            }
        }
        
        /* Ecommerce navbar positioning */
        #ecommerce-navbar {
            position: relative;
            z-index: 1020;
            margin-top: 10px;
        }

        /* User Info / Logout positioning */
        .user-info-logout {
          position: absolute;
          right: 1rem; /* Use rem for consistency */
          top: 50%;
          transform: translateY(-50%); /* Center vertically initially */
          display: flex;
          align-items: center;
        }

        .user-info-logout .badge {
          margin-right: 0.5rem;
          font-size: 0.9rem; /* Restore font size */
          text-transform: capitalize; /* Restore text transform */
        }

        /* Media query for mobile screens (max-width 500px) */
        @media (max-width: 500px) {
          .user-info-logout {
            flex-direction: column; /* Stack items vertically */
            align-items: flex-end; /* Align items to the right */
            right: 0.5rem; /* Adjust position */
            top: 5px; /* Adjust top position */
            transform: none; /* Reset vertical transform */
          }

          .user-info-logout .badge {
            margin-right: 0; /* Remove right margin */
            margin-bottom: 5px; /* Add space below the badge */
          }

          .user-info-logout .btn {
             font-size: 0.75rem; /* Make button slightly smaller */
             padding: 0.2rem 0.4rem;
          }

          /* Adjust navbar title for mobile */
          .navbar-title {
            font-size: 1.5rem; /* Reduce font size */
            padding: 0; /* Remove padding */
            margin-left: 5px; /* Add left margin */
            margin-right: 5px; /* Add right margin */
            flex-grow: 1; /* Allow title to take available space */
            text-align: center; /* Ensure it stays centered */
          }
        }
    </style>
</head>
<body> <!-- Removed extra body tag -->

<!-- Navigation Title -->

<nav class="navbar text-center">
    <!-- Title Row -->
    <div class="container-fluid">
        <div class="row w-100">
            <div class="col-12 d-flex justify-content-center align-items-center">
                <h1 class="navbar-title text-center mx-auto">
                    <i class="fas fa-store me-2"></i> <!-- Changed Icon -->
                    FERIA GANADERA
                    <i class="fas fa-tags ms-2"></i> <!-- Changed Icon -->
                </h1>
                <!-- Updated User Info/Logout container -->
                <div class="user-info-logout">
                    <span class="badge bg-primary"> <!-- Removed me-2 and inline styles -->
                        <?php echo htmlspecialchars($_SESSION["role"]); ?>
                    </span>
                    <a href="logout.php" class="btn btn-outline-danger btn-sm" title="Cerrar sesión">
                        <i class="fas fa-sign-out-alt"></i> Salir
                    </a>
                </div>
            </div>            
        </div>
    </div>     
</nav>

<!-- Icon Navigation Buttons (Assuming this is reused) -->
<!-- Icon Navigation Buttons -->

<div class="container nav-icons-container">
    <div class="icon-button-container">
        <button onclick="window.location.href='../inicio.php'" class="icon-button">
            <img src="./images/Ganagram_New_Logo-png.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">INICIO</span>
    </div>

    <div class="icon-button-container">
        <button onclick="window.location.href='./inventario_bufalino.php'" class="icon-button">
            <img src="./images/vaca.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">POBLACION</span>
    </div>

        
    <div class="icon-button-container">
        <button onclick="window.location.href='./bufalino_registros.php'" class="icon-button">
            <img src="./images/registros.png" alt="Inicio" class="nav-icon">
        </button>
        <span class="button-label">REGISTROS</span>
    </div>
    
    <div class="icon-button-container">
        <button onclick="window.location.href='./bufalino_indices.php'" class="icon-button">
            <img src="./images/fondo-indexado.png" alt="Inicio" class="nav-icon">
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

<!-- E-commerce Navigation Row -->
<div class="container mt-4" id="ecommerce-navbar">    
    <div class="row">
        <div class="col-12">
            <div class="nav-links-container d-flex justify-content-center">
                <div class="nav-link-item text-center mx-3">
                    <img src="./images/rebaño.png" alt="Publicados" width="40" class="nav-img">
                    <div>
                        <!-- Ensure this link points to the current page or is styled as active -->
                        <a class="nav-link active" href="bufalino_feria.php">PUBLICADOS</a> 
                    </div>
                </div>
                
                <div class="nav-link-item text-center mx-3">
                    <div class="position-relative">
                        <img src="./images/carrito-animal.png" alt="Seleccionados" width="40" class="nav-img">
                        <!-- This badge display logic is correct -->
                        <?php if ($item_count > 0): ?>                                
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge" style="font-size: 0.75rem;">
                            <?php echo $item_count; ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div>
                        <a class="nav-link" href="cart.php">SELECCIONADOS</a>
                    </div>
                </div>
                
                <?php if ($user_logged_in): ?>
                <div class="nav-link-item text-center mx-3">
                    <img src="./images/pedidos.png" alt="Ventas" width="40" class="nav-img">
                    <div>
                        <a class="nav-link" href="orders.php">VENTAS</a>
                    </div>
                </div>
                
                <div class="nav-link-item text-center mx-3">
                    <img src="./images/pagos.png" alt="Pagos" width="40" class="nav-img">
                    <div>
                        <a class="nav-link" href="payments.php">PAGOS</a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mt-4 mb-4"> <!-- Added mb-4 for spacing -->

    <!-- Display Messages -->
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo htmlspecialchars($success_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?php echo htmlspecialchars($error_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="filters-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5><i class="fas fa-filter me-2"></i> Filtrar Animales</h5>
             <?php if ($user_role === "admin"): ?>
                <button class="btn btn-success btn-sm" onclick="openNewProductModal()">
                    <i class="fas fa-plus me-1"></i> Publicar Animal
                </button>
            <?php endif; ?>
        </div>
        <form id="filterForm" class="row g-3 align-items-end">
            <div class="col-md-3 col-sm-6">
                <label for="tagid-filter" class="form-label small">Número (Tag ID)</label>
                <select class="form-select form-select-sm" id="tagid-filter" name="tagid">
                    <option value="">Todos</option>
                    <?php foreach ($tagids as $tagid_opt): ?>
                    <option value="<?php echo htmlspecialchars($tagid_opt); ?>">
                        <?php echo htmlspecialchars($tagid_opt); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                 <label for="nombre-filter" class="form-label small">Nombre</label>
                <select class="form-select form-select-sm" id="nombre-filter" name="nombre">
                    <option value="">Todos</option>
                     <?php foreach ($nombres as $nombre_opt): ?>
                    <option value="<?php echo htmlspecialchars($nombre_opt); ?>">
                        <?php echo htmlspecialchars($nombre_opt); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                 <label for="raza-filter" class="form-label small">Raza</label>
                <select class="form-select form-select-sm" id="raza-filter" name="raza">
                    <option value="">Todas</option>
                    <?php foreach ($razas as $raza_opt): ?>
                    <option value="<?php echo htmlspecialchars($raza_opt); ?>">
                        <?php echo htmlspecialchars($raza_opt); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 col-sm-6">
                 <label for="genero-filter" class="form-label small">Sexo</label>
                <select class="form-select form-select-sm" id="genero-filter" name="genero">
                    <option value="">Todos</option>
                     <?php foreach ($generos as $genero_opt): ?>
                    <option value="<?php echo htmlspecialchars($genero_opt); ?>">
                        <?php echo htmlspecialchars($genero_opt); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-12 mt-3 text-center"> <!-- Centered buttons -->
                <button type="button" class="btn btn-primary btn-sm me-2" id="applyFilters">
                    <i class="fas fa-search me-1"></i> Aplicar Filtros
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="resetFilters">
                    <i class="fas fa-undo me-1"></i> Reiniciar
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="table-responsive mt-4">
        <table id="productsTable" class="table table-striped table-bordered table-hover" style="width:100%;">
            <thead> <!-- Removed thead class -->
                <tr>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Tag Id</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Raza</th>
                    <th class="text-center">Sexo</th>
                    <th class="text-center">Precio [$]</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Products will be loaded here by AJAX -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add Animal to Feria Modal (Admin Only) -->
<?php if ($user_role === "admin"): ?>
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel"><i class="fas fa-plus-circle me-2"></i> Agregar Animal a la Feria</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="productForm" method="post" action="bufalino_feria.php"> <!-- Post back to self -->
                    <input type="hidden" name="action" value="new_listing">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modal-tagid" class="form-label">Animal (ID - Nombre - Sexo - Raza)</label>
                            <select class="form-select" id="modal-tagid" name="tagid" required>
                                <option value="" disabled selected>Seleccione un animal disponible...</option>
                                <?php if (empty($my_animals)): ?>
                                <option value="" disabled>No hay animales disponibles para agregar.</option>
                                <?php else: ?>
                                    <?php foreach ($my_animals as $animal): ?>
                                    <option value="<?php echo htmlspecialchars($animal['tagid']); ?>">
                                        <?php echo htmlspecialchars($animal['tagid'] . ' - ' . $animal['nombre'] . ' (' . $animal['genero'] . ' / ' . $animal['raza'] . ')'); ?>
                                    </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Solo se muestran animales que no están actualmente en la feria.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="modal-precio" class="form-label">Precio de Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="modal-precio" name="precio" step="0.01" min="0.01" required placeholder="0.00">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="submit" form="productForm" class="btn btn-primary">
                    <i class="fas fa-check me-1"></i> Publicar en Feria
                </button>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Image Lightbox Modal -->
<div id="imageLightbox" class="fullscreen-image-modal">
    <span class="close-lightbox">&times;</span>
    <div class="lightbox-container">
        <img id="fullscreenImage" class="fullscreen-image-content">
        <div id="productCodeDisplay" class="product-code-display"></div>
    </div>
</div>

<!-- WhatsApp Chat Button (Assuming include works) -->
<?php // include 'whatsapp_button.php'; ?>

<!-- BCV Rate Modal (Assuming this logic is separate or not needed here) -->
<!-- ... -->

<!-- JS Includes -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
<script>
$(document).ready(function() {
    // Initialize DataTable
    const productsTable = $('#productsTable').DataTable({
        processing: true,
        serverSide: false, // Data loaded client-side via AJAX call initially
        ajax: {
            url: 'get_feria_animals.php', // Endpoint to fetch initial/filtered data
            type: 'GET', 
            dataSrc: '' // Expecting an array of objects directly
        },
        language: {
            "processing": "<i class='fas fa-spinner fa-spin fa-2x'></i> Procesando...",
            "lengthMenu": "Mostrar _MENU_ animales",
            "zeroRecords": "No se encontraron animales que coincidan con los filtros",
            "emptyTable": "No hay animales publicados en la feria actualmente",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ animales",
            "infoEmpty": "Mostrando 0 a 0 de 0 animales",
            "infoFiltered": "(filtrado de _MAX_ animales totales)",
            "search": "Buscar Rápido:",
            "paginate": {
                "first": "<<",
                "last": ">>",
                "next": ">",
                "previous": "<"
            }
        },
        columns: [
            { data: 'image', orderable: false, className: 'text-center' },
            { data: 'tagid', className: 'text-center' },
            { data: 'nombre', className: 'text-center' },
            { data: 'raza', className: 'text-center' },
            { data: 'genero', className: 'text-center' },
            { data: 'precio', className: 'text-center' },
            { data: 'actions', orderable: false, className: 'text-center' }
        ],
        columnDefs: [
            {
                targets: 0, // Image column
                render: function(data, type, row) {
                    const imgPath = data || './images/default_animal.png'; // Default image
                    return `<img src="${htmlspecialchars(imgPath)}" alt="${htmlspecialchars(row.nombre || 'Animal')}" 
                            class="product-image image-magnifier" 
                            style="cursor: pointer;" 
                            data-product-tagid="${htmlspecialchars(row.tagid)}"
                            data-product-nombre="${htmlspecialchars(row.nombre || '')}"
                            data-product-genero="${htmlspecialchars(row.genero)}"
                            data-product-raza="${htmlspecialchars(row.raza)}"
                            data-product-etapa="${htmlspecialchars(row.etapa)}"
                            data-product-grupo="${htmlspecialchars(row.grupo || '')}"
                            data-product-precio="${htmlspecialchars(row.precio)}"
                            data-product-fecha="${htmlspecialchars(row.fecha_publicacion || '')}">`;
                }
            },
            {
                targets: 5, // USD Price column
                render: function(data) {
                    const price = parseFloat(data);
                    return isNaN(price) ? 'N/A' : '$' + price.toFixed(2);
                }
            },                
            {
                targets: 6, // Actions column
                render: function(data, type, row) {
                    const userRole = "<?php echo $user_role; ?>";
                    let actions = '';
                    
                    if (userRole === "admin") {
                        actions = `
                            <button class="btn btn-sm btn-success me-1" title="Editar Precio" onclick="editProduct('${htmlspecialchars(row.tagid)}')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" title="Quitar de Feria" onclick="removeFromFeria('${htmlspecialchars(row.tagid)}')">
                                <i class="fas fa-trash-alt"></i> <!-- Changed icon -->
                            </button>
                        `;
                    } else {
                        // Comprador or Usuario
                        actions = `
                            <button class="btn btn-sm btn-success seleccionar-btn" title="Agregar al carrito" onclick="addToCart('${htmlspecialchars(row.tagid)}')">
                                <i class="fas fa-cart-plus"></i> Seleccionar
                            </button>
                        `;
                         // Add WhatsApp button only if needed for 'usuario' role
                         // if (userRole === 'usuario') {
                         // actions += ` <a href="?contact=1&tagid=${row.tagid}" class="btn btn-sm btn-success whatsapp-btn">
                         //                 <i class="fab fa-whatsapp"></i> Contactar
                         //             </a>`;
                         // }
                    }
                    return actions;
                }
            }
        ],
        responsive: true,
        autoWidth: false,
        pageLength: 10, // Default number of rows
        lengthMenu: [10, 25, 50, 100] // Options for rows per page
    });
    
    // Helper function to escape HTML (for JS security)
    function htmlspecialchars(str) {
        if (typeof str !== 'string') str = String(str);
        return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
    }

    // Load filtered products via AJAX based on form
    function loadFilteredProducts() {
        const tagid = $('#tagid-filter').val();
        const nombre = $('#nombre-filter').val();
        const raza = $('#raza-filter').val();
        const genero = $('#genero-filter').val();
        
        // Build query parameters
        let queryParams = {};
        if (tagid) queryParams.tagid = tagid;
        if (nombre) queryParams.nombre = nombre;
        if (raza) queryParams.raza = raza;
        if (genero) queryParams.genero = genero;
        
        console.log('Filtering with params:', queryParams);

        // Update the DataTable AJAX URL and reload
        productsTable.ajax.url('get_feria_animals.php?' + $.param(queryParams)).load();
    }
    
    // Apply filters button
    $('#applyFilters').click(function() {
        loadFilteredProducts();
    });
    
    // Reset filters button
    $('#resetFilters').click(function() {
        $('#filterForm')[0].reset();
        loadFilteredProducts(); // Load with no filters
    });
    
    // --- Admin Specific Functions ---
    <?php if ($user_role === "admin"): ?>
    window.openNewProductModal = function() {
        $('#productForm')[0].reset(); // Reset form fields
        $('#productModal').modal('show');
    };
    
    window.editProduct = function(tagid) {
        // Redirect to a dedicated edit page or open a pre-filled modal
        // For now, redirecting to a hypothetical edit page:
        window.location.href = 'edit_feria_price.php?tagid=' + encodeURIComponent(tagid);
    };
    
    window.removeFromFeria = function(tagid) {
        if (confirm('¿Está seguro que desea quitar este animal [ID: ' + tagid + '] de la feria? Esta acción cambiará su estado y quitará el precio.')) {
            $.ajax({
                url: 'remove_from_feria.php', // Dedicated endpoint
                type: 'POST',
                data: { tagid: tagid },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert('Animal removido de la feria correctamente.');
                        productsTable.ajax.reload(); // Reload DataTable data
                        // Optionally update the "Add Animal" modal list if needed
                    } else {
                        alert('Error: ' + (response.message || 'Ocurrió un error al remover el animal.'));
                    }
                },
                error: function(xhr, estatus, error) {
                    console.error("Error removing animal:", error, xhr.responseText);
                    alert('Error de conexión al intentar remover el animal.');
                }
            });
        }
    };
    <?php endif; ?>
    
    // --- Image Lightbox --- 
    $(document).on('click', '.image-magnifier', function() {
        const imageUrl = $(this).attr('src');
        const productTagid = htmlspecialchars($(this).data('product-tagid') || 'N/A');
        const productNombre = htmlspecialchars($(this).data('product-nombre') || 'N/A');
        const productGenero = htmlspecialchars($(this).data('product-genero') || 'N/A');
        const productRaza = htmlspecialchars($(this).data('product-raza') || 'N/A');
        const productEtapa = htmlspecialchars($(this).data('product-etapa') || 'N/A');
        const productGrupo = htmlspecialchars($(this).data('product-grupo') || 'N/A');
        const productPrecioRaw = $(this).data('product-precio');
        const productPrecio = !isNaN(parseFloat(productPrecioRaw)) ? '$' + parseFloat(productPrecioRaw).toFixed(2) : 'N/A';
        const productFecha = htmlspecialchars($(this).data('product-fecha') || 'N/A');
        
        $('#fullscreenImage').attr('src', imageUrl);
        
        $('#productCodeDisplay').html(`
            <div class="product-info-row">
                <div class="product-info-item"><span class="product-info-label">ID:</span><span class="product-info-value">${productTagid}</span></div>
                <div class="product-info-item"><span class="product-info-label">Nombre:</span><span class="product-info-value">${productNombre}</span></div>
            </div>
            <div class="product-info-row">
                <div class="product-info-item"><span class="product-info-label">Raza:</span><span class="product-info-value">${productRaza}</span></div>
                <div class="product-info-item"><span class="product-info-label">Sexo:</span><span class="product-info-value">${productGenero}</span></div>
            </div>
            <div class="product-info-row">
                <div class="product-info-item"><span class="product-info-label">Etapa:</span><span class="product-info-value">${productEtapa}</span></div>
                <div class="product-info-item"><span class="product-info-label">Grupo:</span><span class="product-info-value">${productGrupo}</span></div>
            </div>
            <div class="product-info-row">
                <div class="product-info-item"><span class="product-info-label">Precio:</span><span class="product-info-value">${productPrecio}</span></div>
                <div class="product-info-item"><span class="product-info-label">Publicado:</span><span class="product-info-value">${productFecha}</span></div>
            </div>
        `);
        
        $('#imageLightbox').css('display', 'flex');
        $('body').css('overflow', 'hidden');
    });

    $('#imageLightbox, .close-lightbox').click(function(e) {
        // Close only if clicking on the backdrop or the close button itself
        if ($(e.target).is('#imageLightbox') || $(e.target).is('.close-lightbox')) {
            $('#imageLightbox').css('display', 'none');
            $('body').css('overflow', 'auto');
        }
    });

    // --- Add to Cart Functionality --- 
    window.addToCart = function(tagid) {
        console.log(`Attempting to add tagid: ${tagid} to cart.`); // Debug log
        $.ajax({
            url: 'add_to_cart.php', // Endpoint to handle adding items
            type: 'POST',
            data: {
                tagid: tagid,
                quantity: 1 // Default quantity to add
            },
            dataType: 'json',
            success: function(response) {
                console.log('Add to cart response:', response); // Debug log
                if (response.success) {
                    alert('Animal [' + tagid + '] agregado al carrito correctamente!');
                    
                    // Update cart count badge
                    if (typeof response.cart_count !== 'undefined') {
                        updateCartBadge(response.cart_count);
                    }
                } else {
                    alert('Error: ' + (response.message || 'No se pudo agregar el animal al carrito.'));
                }
            },
            error: function(xhr, estatus, error) {
                console.error("Error adding animal to cart:", error, xhr.responseText);
                alert('Error de conexión al agregar al carrito. Intente de nuevo.');
            }
        });
    };

    // Function to update the cart badge display
    function updateCartBadge(count) {
        const badgeSelector = '.cart-badge'; // Specific class for the cart badge span
        const badgeContainer = $('.nav-link-item:has(a[href="cart.php"]) .position-relative');
        let badge = $(badgeSelector);

        if (count > 0) {
            if (badge.length === 0) {
                // Create badge if it doesn't exist
                badgeContainer.append(
                    `<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-badge" style="font-size: 0.75rem;">${count}</span>`
                );
            } else {
                // Update existing badge count and ensure visibility
                badge.text(count).show();
            }
        } else {
            // Hide badge if count is 0 or less
            if (badge.length > 0) {
                badge.hide();
            }
        }
    }

    // Initial update of cart badge based on PHP value (if needed, though AJAX response is better)
    updateCartBadge(<?php echo $item_count; ?>);

});
</script>

</body>
</html> 