<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Banner de Bienvenida con Degradado Corporativo e Ilustración Visual -->
<div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);">
    <div class="card-body p-4 p-md-5 position-relative">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-white text-primary fw-bold px-3 py-2 rounded-pill mb-3 shadow-sm">
                    <i class="bi bi-stars me-1"></i> Sistema de Facturación Pro
                </span>
                <h1 class="fw-bold display-6 mb-2">¡Bienvenido de nuevo, <?= session('name') ?? 'Administrador' ?>! 👋</h1>
                <p class="lead opacity-85 mb-0 fs-6">Tu espacio de control está listo. Gestiona comprobantes electrónicos, revisa historiales y optimiza tu negocio de forma ágil.</p>
            </div>
            <div class="col-lg-4 text-end d-none d-lg-block">
                <i class="bi bi-receipt-cutoff display-1 text-white opacity-25"></i>
            </div>
        </div>
        <!-- Elemento decorativo de fondo -->
        <div class="position-absolute end-0 bottom-0 translate-middle-y me-n5 opacity-10">
            <i class="bi bi-shield-check" style="font-size: 15rem;"></i>
        </div>
    </div>
</div>

<!-- Fila de Tarjetas Métricas con Colores Vibrantes -->
<div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm h-100 border-start border-primary border-4 bg-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 text-primary">
                        <i class="bi bi-grid-1x2-fill fs-4"></i>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-bold">Principal</span>
                </div>
                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Módulo General</h6>
                <h4 class="fw-bold text-dark mb-0">Gestión Activa</h4>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm h-100 border-start border-success border-4 bg-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 p-3 rounded-3 text-success">
                        <i class="bi bi-file-earmark-plus-fill fs-4"></i>
                    </div>
                    <span class="badge bg-success-subtle text-success fw-bold">Acción</span>
                </div>
                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Nueva Factura</h6>
                <h4 class="fw-bold text-dark mb-0">Registrar Venta</h4>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm h-100 border-start border-warning border-4 bg-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-3 text-warning">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                    <span class="badge bg-warning-subtle text-warning fw-bold">Consulta</span>
                </div>
                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Historial</h6>
                <h4 class="fw-bold text-dark mb-0">Ver Registros</h4>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card border-0 rounded-4 shadow-sm h-100 border-start border-info border-4 bg-white">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 text-info">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                    <span class="badge bg-info-subtle text-info fw-bold">Seguridad</span>
                </div>
                <h6 class="text-muted small fw-semibold text-uppercase mb-1">Estado de Red</h6>
                <h4 class="fw-bold text-dark mb-0">100% Seguro</h4>
            </div>
        </div>
    </div>
</div>

<!-- Sección de Accesos Rápidos y Perfil -->
<div class="row g-4 mb-4">
    <!-- Panel Izquierdo de Accesos -->
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-0">Panel de Control Rápido</h5>
                </div>
                <span class="badge bg-success text-white px-3 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i> En línea
                </span>
            </div>
            
            <div class="card-body p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <a href="<?= base_url('facturas/nueva') ?>" class="text-decoration-none p-3 border-0 bg-light rounded-4 d-block h-100 shadow-sm transition-all hover-scale">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary text-white p-3 rounded-3 me-3 shadow-sm">
                                    <i class="bi bi-file-earmark-plus-fill fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Nueva Factura</h6>
                                    <p class="text-muted small mb-0">Crear comprobante</p>
                                </div>
                            </div>
                            <span class="text-primary small fw-bold"><i class="bi bi-arrow-right me-1">Click para acceder</i></span>
                        </a>
                    </div>
                    
                    <div class="col-md-6">
                        <a href="<?= base_url('facturas') ?>" class="text-decoration-none p-3 border-0 bg-light rounded-4 d-block h-100 shadow-sm transition-all hover-scale">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-warning text-white p-3 rounded-3 me-3 shadow-sm">
                                    <i class="bi bi-journals fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-1">Historial</h6>
                                    <p class="text-muted small mb-0">Revisar facturas</p>
                                </div>
                            </div>
                            <span class="text-primary small fw-bold"><i class="bi bi-arrow-right me-1">Click para acceder</i></span>
                        </a>
                    </div>
                </div>

                <div class="p-3 bg-primary-subtle rounded-4 d-flex align-items-center gap-3 border border-primary-subtle">
                    <i class="bi bi-info-circle-fill fs-4 text-primary"></i>
                    <div>
                        <h6 class="fw-bold text-primary mb-1">Aviso del Sistema</h6>
                        <p class="text-dark small mb-0">Todas tus transacciones están protegidas y cifradas bajo las normativas vigentes.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Perfil Derecho -->
    <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm h-100 bg-white text-center">
            <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                <div class="position-relative mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-lg mx-auto" style="width: 90px; height: 90px;">
                        <i class="bi bi-person-fill" style="font-size: 3.5rem;"></i>
                    </div>
                    <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-2" title="Activo"></span>
                </div>
                <h5 class="fw-bold text-dark mb-1"><?= session('name') ?? 'Usuario Administrador' ?></h5>
                <p class="text-muted small mb-3"><i class="bi bi-at"></i><?= session('username') ?? 'admin' ?></p>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 mb-4">Rol: Administrador</span>
                <div class="d-grid w-100">
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger fw-bold rounded-pill py-2 shadow-sm">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>