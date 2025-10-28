<?php
// This file is included in multiple pages
// Ensure the session variables are available
if (!isset($isUserLoggedIn)) {
    require_once 'check_session.php';
}
?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: linear-gradient(135deg, #4e6c41, #759c63);">
    <div class="container">
        <a class="navbar-brand" href="inventario_bufalino.php">
            <img src="/images/default_image-removebg-preview.png" alt="Ganagram_logo" width="100" class="me-2">
            Sistema Ganadero
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="inventario_bufalino.php">
                        <i class="fas fa-clipboard-list me-1"></i> Inventario
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="bufalino_feria.php">
                        <i class="fas fa-store me-1"></i> Feria
                    </a>
                </li>
                <?php if ($isUserLoggedIn && isAdmin()): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog me-1"></i> Administración
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li>
                            <a class="dropdown-item" href="approve_users.php">
                                <i class="fas fa-user-check me-2"></i> Aprobar Usuarios
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-sliders-h me-2"></i> Configuración
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <?php if ($isUserLoggedIn): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-1"></i> 
                        <?php echo htmlspecialchars($fullname); ?>
                        <?php if (isAdmin()): ?>
                            <span class="badge bg-danger ms-1">Admin</span>
                        <?php endif; ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user-cog me-2"></i> Mi Perfil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">
                        <i class="fas fa-user-plus me-1"></i> Registrarse
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav> 