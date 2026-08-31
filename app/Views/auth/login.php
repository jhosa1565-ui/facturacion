<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Sistema de Facturación</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@adminlte/adminlte@4.0.0-beta2/dist/css/adminlte.min.css">
</head>
<body class="login-page bg-body-secondary d-flex align-items-center justify-content-center min-vh-100" 
      style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?= base_url('assets/img/login-bg.jpg') ?>') no-repeat center center fixed; background-size: cover;">
    
    <div class="login-box w-100 px-3" style="max-width: 420px;">
        <div class="login-logo text-center mb-4">
            <a href="#" class="h2 text-decoration-none fw-bold text-white drop-shadow">
                <i class="bi bi-receipt text-primary me-2"></i>Facturación App
            </a>
        </div>
        
        <div class="card shadow-lg border-0 rounded-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="card-body login-card-body p-4 p-md-5">
                <p class="login-box-msg text-center text-muted mb-4 fw-semibold">Ingresa tus credenciales</p>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('login/authenticate') ?>" method="post" autocomplete="off">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label text-secondary small fw-bold">Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-person"></i></span>
                            <input type="text" name="username" id="username" class="form-control border-start-0 ps-0 bg-light" placeholder="admin" required autofocus>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label text-secondary small fw-bold">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-lock"></i></span>
                            <input type="password" name="password" id="password" class="form-control border-start-0 ps-0 bg-light" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm rounded-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Ingresar
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <p class="text-center text-white-50 small mt-4 fw-light">&copy; <?= date('Y') ?> Sistema de Facturación</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@adminlte/adminlte@4.0.0-beta2/dist/js/adminlte.min.js"></script>

    
</body>
</html>