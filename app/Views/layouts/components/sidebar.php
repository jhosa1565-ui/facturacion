<aside class="app-sidebar border-end" data-bs-theme="light">
    <!-- Logotipo y Nombre del Sistema -->
    <div class="sidebar-brand border-bottom py-3 text-center">
        <a href="<?= base_url('dashboard') ?>" class="brand-link text-decoration-none d-flex align-items-center justify-content-center gap-2 px-2">
            <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="Logo" style="max-height: 100px; width: auto; object-fit: contain;">
            <span class="brand-text fw-bold text-dark fs-5">Facturación App</span>
        </a>
    </div>

    <!-- Menú de Navegación Lateral -->
    <div class="sidebar-wrapper px-2 py-3">
        <nav>
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item mb-2">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link <?= url_is('dashboard') ? 'active bg-light border-end border-3 border-primary text-primary' : 'text-secondary' ?>">
                        <i class="nav-icon bi bi-grid me-2"></i>
                        <p class="fw-semibold mb-0">Dashboard</p>
                    </a>
                </li>

                <li class="nav-item <?= url_is('facturas*') ? 'menu-open' : '' ?>">
                    <a href="#" class="nav-link text-secondary">
                        <i class="nav-icon bi bi-receipt me-2"></i>
                        <p class="mb-0">
                            Módulo Facturación
                            <i class="nav-arrow bi bi-chevron-right float-end"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview ps-3 mt-1">
                        <li class="nav-item mb-1">
                            <a href="<?= base_url('facturas/nueva') ?>" class="nav-link text-secondary py-1">
                                <i class="nav-icon bi bi-plus-circle me-2"></i>
                                <p class="mb-0">Nueva Factura</p>
                            </a>
                        </li>
                        <li class="nav-item">
    <a href="<?= base_url('categorias') ?>" class="nav-link <?= url_is('categorias*') ? 'active bg-light border-end border-3 border-primary text-primary' : 'text-secondary' ?>">
        <i class="nav-icon bi bi-tags me-2"></i>
        <p class="mb-0">Categorías</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= base_url('marcas') ?>" class="nav-link <?= url_is('marcas*') ? 'active' : '' ?>">
        <i class="nav-icon bi bi-patch-check-fill"></i>
        <p>Marcas</p>
    </a>
</li>
<!-- Clientes -->
<li class="nav-item">
    <a href="<?= base_url('clientes') ?>" class="nav-link <?= url_is('clientes*') ? 'active' : '' ?>">
        <i class="nav-icon bi bi-people-fill"></i>
        <p>Clientes</p>
    </a>
</li>
<!-- Proveedores -->
<li class="nav-item">
    <a href="<?= base_url('proveedores') ?>" class="nav-link <?= url_is('proveedores*') ? 'active' : '' ?>">
        <i class="nav-icon bi bi-truck"></i>
        <p>Proveedores</p>
    </a>
</li>
                        <li class="nav-item">
                            <a href="<?= base_url('facturas') ?>" class="nav-link text-secondary py-1">
                                <i class="nav-icon bi bi-clock-history me-2"></i>
                                <p class="mb-0">Historial</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>