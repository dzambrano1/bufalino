<?php
// Include the session check file
require_once 'check_session.php';

// Require login for this page
requireLogin();

// Check if user has a valid role (comprador)
if ($_SESSION["role"] !== "comprador") {
    // Return error response
    echo json_encode([
        'success' => false,
        'message' => 'Permisos insuficientes'
    ]);
    exit();
}

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido'
    ]);
    exit();
}

// Get tagid and quantity from request
$tagid = $_POST['tagid'] ?? '';
$quantity = intval($_POST['quantity'] ?? 1);

// Validate input
if (empty($tagid)) {
    echo json_encode([
        'success' => false,
        'message' => 'ID del animal no proporcionado'
    ]);
    exit();
}

if ($quantity <= 0) {
    $quantity = 1; // Ensure quantity is at least 1
}

// Include database connection
require_once "./pdo_conexion.php";

// Initialize the database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    echo json_encode([
        'success' => false,
        'message' => 'Error de conexión a la base de datos: ' . mysqli_connect_error()
    ]);
    exit();
}

try {
    // First check if the animal exists and is in "Feria" estatus
    $check_sql = "SELECT tagid, nombre, genero, raza, precio_venta, etapa, grupo, estatus, image FROM vacuno WHERE tagid = ? AND estatus = 'Feria' AND precio_venta > 0";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $tagid);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $animal = $result->fetch_assoc();
    
    if (!$animal) {
        echo json_encode([
            'success' => false,
            'message' => 'Animal no encontrado o no disponible en la feria'
        ]);
        exit();
    }
    
    // Get user ID
    $user_id = $_SESSION['user_id'];
    
    // Check if the animal is already in the cart
    $check_cart_sql = "SELECT id, quantity FROM cart_items WHERE user_id = ? AND tagid = ?";
    $check_cart_stmt = $conn->prepare($check_cart_sql);
    $check_cart_stmt->bind_param("is", $user_id, $tagid);
    $check_cart_stmt->execute();
    $cart_result = $check_cart_stmt->get_result();
    $existing_item = $cart_result->fetch_assoc();
    
    if ($existing_item) {
        // Update existing cart item quantity
        $new_quantity = $existing_item['quantity'] + $quantity;
        $update_sql = "UPDATE cart_items SET quantity = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $existing_item['id']);
        $update_stmt->execute();
    } else {
        // Add new cart item with all the requested fields
        $insert_sql = "INSERT INTO cart_items (user_id, tagid, quantity, precio_venta, nombre, genero, raza, etapa, grupo, status, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("isidsssssss", 
            $user_id, 
            $tagid, 
            $quantity, 
            $animal['precio_venta'],
            $animal['nombre'],
            $animal['genero'],
            $animal['raza'],
            $animal['etapa'],
            $animal['grupo'],
            $animal['status'],
            $animal['image']
        );
        $insert_stmt->execute();
    }
    
    // Get updated cart count
    $count_sql = "SELECT SUM(quantity) as total FROM cart_items WHERE user_id = ?";
    $count_stmt = $conn->prepare($count_sql);
    $count_stmt->bind_param("i", $user_id);
    $count_stmt->execute();
    $count_result = $count_stmt->get_result();
    $count_row = $count_result->fetch_assoc();
    $cart_count = (int)($count_row['total'] ?? 0);
    
    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Animal agregado al carrito correctamente',
        'cart_count' => $cart_count
    ]);
    
} catch (Exception $e) {
    // Log error
    error_log("Error adding to cart: " . $e->getMessage());
    
    // Return error response
    echo json_encode([
        'success' => false,
        'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
    ]);
} finally {
    // Close connection
    if (isset($conn)) {
        $conn->close();
    }
}
?> 