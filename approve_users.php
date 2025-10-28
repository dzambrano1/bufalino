<?php
// Include session check
require_once 'check_session.php';
requireAdmin(); // Only admin can approve users

// Include database connection
require_once './pdo_conexion.php';

// Process approval or deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && isset($_POST['user_id'])) {
        $user_id = (int)$_POST['user_id'];
        $action = $_POST['action'];
        
        try {
            if ($action === 'approve') {
                // Update user status to active
                $stmt = $conn->prepare("UPDATE users SET status = 'active' WHERE id = ?");
                $stmt->execute([$user_id]);
                
                $success_message = "Usuario aprobado correctamente.";
            } elseif ($action === 'delete') {
                // Delete the user
                $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                $stmt->execute([$user_id]);
                
                $success_message = "Usuario eliminado correctamente.";
            }
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}

// Get all pending users
try {
    $stmt = $conn->prepare("SELECT id, username, email, firstName, lastName, fullname, role, created_at FROM users WHERE status = 'pending' ORDER BY created_at DESC");
    $stmt->execute();
    $pending_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error al obtener usuarios pendientes: " . $e->getMessage();
    $pending_users = [];
}

// Get recently approved users
try {
    $stmt = $conn->prepare("SELECT id, username, email, firstName, lastName, fullname, role, created_at FROM users WHERE status = 'active' ORDER BY created_at DESC LIMIT 5");
    $stmt->execute();
    $recent_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error_message = "Error al obtener usuarios recientes: " . $e->getMessage();
    $recent_users = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobar Usuarios - Sistema Ganadero</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            padding-top: 56px;
            background-color: #f5f5f5;
        }
        .pending-user-card {
            border-left: 4px solid #759c63;
            margin-bottom: 15px;
            transition: all 0.2s;
        }
        .pending-user-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        .card-header {
            background: linear-gradient(135deg, #4e6c41, #759c63);
            color: white;
        }
        .btn-approve {
            background-color: #4e6c41;
            border-color: #4e6c41;
        }
        .btn-approve:hover {
            background-color: #3c5433;
            border-color: #3c5433;
        }
        .page-title {
            background: linear-gradient(135deg, #4e6c41, #759c63);
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .page-title h1 {
            font-size: 1.8rem;
            margin: 0;
        }
        .alert {
            border-radius: 5px;
        }
        .timestamp {
            font-size: 0.8rem;
            color: #666;
        }
        .role-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
        }
        .empty-list-message {
            text-align: center;
            padding: 30px;
            background-color: #f8f9fa;
            border-radius: 5px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Include navigation -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-center">
                <h1><i class="fas fa-user-check me-2"></i> Aprobar Usuarios</h1>
                <a href="inventario_vacuno.php" class="btn btn-light">
                    <i class="fas fa-arrow-left me-1"></i> Volver a Inventario
                </a>
            </div>
        </div>
        
        <?php if (isset($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?php echo $success_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-user-clock me-2"></i> Solicitudes Pendientes</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($pending_users) > 0): ?>
                            <?php foreach ($pending_users as $user): ?>
                                <div class="card pending-user-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-1"><?php echo htmlspecialchars($user['fullname']); ?></h5>
                                                <p class="mb-1">
                                                    <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($user['username']); ?> 
                                                    <span class="badge bg-secondary role-badge ms-2"><?php echo htmlspecialchars($user['role']); ?></span>
                                                </p>
                                                <p class="mb-1"><i class="fas fa-envelope me-1"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                                                <p class="timestamp mb-0"><i class="fas fa-clock me-1"></i> Registrado: <?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></p>
                                            </div>
                                            <div class="d-flex">
                                                <form method="post" class="me-2">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <input type="hidden" name="action" value="approve">
                                                    <button type="submit" class="btn btn-approve" onclick="return confirm('¿Confirmar la aprobación de este usuario?')">
                                                        <i class="fas fa-check me-1"></i> Aprobar
                                                    </button>
                                                </form>
                                                <form method="post">
                                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                    <input type="hidden" name="action" value="delete">
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este usuario?')">
                                                        <i class="fas fa-times me-1"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-list-message">
                                <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                                <h5>¡No hay solicitudes pendientes!</h5>
                                <p class="text-muted">Todas las solicitudes de usuario han sido procesadas.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-users me-2"></i> Usuarios Recientes</h5>
                    </div>
                    <div class="card-body">
                        <?php if (count($recent_users) > 0): ?>
                            <ul class="list-group">
                                <?php foreach ($recent_users as $user): ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1"><?php echo htmlspecialchars($user['fullname']); ?></h6>
                                                <small>
                                                    <i class="fas fa-user me-1"></i> <?php echo htmlspecialchars($user['username']); ?>
                                                    <span class="badge bg-secondary role-badge ms-1"><?php echo htmlspecialchars($user['role']); ?></span>
                                                </small>
                                            </div>
                                            <small class="text-muted"><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></small>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-center text-muted my-3">No hay usuarios aprobados recientemente.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 