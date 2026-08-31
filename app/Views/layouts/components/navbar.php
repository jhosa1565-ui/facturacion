<nav class="app-header navbar navbar-expand bg-white border-bottom shadow-sm">
    <div class="container-fluid px-3">
        
        <!-- Botón para colapsar/expandir barra lateral en móviles -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-secondary" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list fs-4"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-flex align-items-center">
                <span class="navbar-text text-dark fw-semibold small">Panel de Control</span>
            </li>
        </ul>

        <!-- Menú de Usuario Desplegable (Dropdown) -->
        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-decoration-none py-1 px-2 rounded-pill bg-body-tertiary border" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 32px; height: 32px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="fw-bold text-dark small d-none d-sm-inline"><?= session('name') ?? 'Usuario Administrador' ?></span>
                    <i class="bi bi-chevron-down text-muted small"></i>
                </a>
                
                <!-- Ventana Desplegable (Dropdown Menu) idéntica a tu diseño -->
                <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-3 text-center" style="width: 280px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(10px);">
                    
                    <!-- Avatar Grande -->
                    <li class="pt-3 pb-2">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm mb-2" style="width: 65px; height: 65px;">
                            <i class="bi bi-person-fill" style="font-size: 2.5rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0"><?= session('name') ?? 'Usuario Administrador' ?></h6>
                        <p class="text-muted small mb-1">@<?= session('username') ?? 'admin' ?></p>
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1" style="font-size: 0.75rem;">Administrador</span>
                    </li>

                    <li><hr class="dropdown-divider my-2"></li>

                    <!-- Opciones del Menú -->
                    <li>
                        <a href="#" class="dropdown-item py-2 rounded-2 text-secondary d-flex align-items-center gap-2 fw-semibold">
                            <i class="bi bi-person text-primary fs-5"></i> Mi Perfil
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item py-2 rounded-2 text-secondary d-flex align-items-center gap-2 fw-semibold">
                            <i class="bi bi-gear text-secondary fs-5"></i> Configuración
                        </a>
                    </li>

                    <li><hr class="dropdown-divider my-2"></li>

                    <!-- Botón de Cerrar Sesión -->
                    <li>
                        <a href="<?= base_url('logout') ?>" class="dropdown-item py-2 rounded-2 text-danger bg-danger-subtle bg-opacity-10 d-flex align-items-center justify-content-center gap-2 fw-bold shadow-sm">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a>
                    </li>

                </ul>
            </li>
        </ul>

    </div>
</nav>