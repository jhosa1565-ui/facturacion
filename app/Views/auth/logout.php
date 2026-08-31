<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Cerrada | Sistema de Facturación</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@adminlte/adminlte@4.0.0-beta2/dist/css/adminlte.min.css">
</head>
<body class="login-page bg-body-secondary d-flex align-items-center justify-content-center min-vh-100" 
      style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('<?= base_url('assets/img/login-bg.jpg') ?>') no-repeat center center fixed; background-size: cover;">
    
    <div class="login-box w-100 px-3 text-center" style="max-width: 440px;">
        
        <div class="card shadow-lg border-0 rounded-4 p-4 p-md-5" style="background: rgba(255, 255, 255, 0.96); backdrop-filter: blur(10px);">
            
            <!-- Logotipo del Sistema -->
            <div class="mb-4">
                <img src="<?= base_url('assets/img/logo.jpg') ?>" alt="Logo" style="max-height: 100px; width: auto; object-fit: contain;">
            </div>

            <!-- Icono de Check de Éxito -->
            <div class="mb-3">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 70px; height: 70px;">
                    <i class="bi bi-check-lg" style="font-size: 2.2rem;"></i>
                </div>
            </div>

            <!-- Textos descriptivos -->
            <h3 class="fw-bold text-dark mb-2">Sesión cerrada</h3>
            <p class="text-muted small mb-4 px-2">Has cerrado sesión correctamente. Gracias por utilizar el Sistema de Facturación.</p>

            <!-- Botón de acción -->
            <div class="d-grid mb-4">
                <a href="<?= base_url('login') ?>" class="btn btn-primary fw-bold py-2 shadow-sm rounded-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Volver a iniciar sesión
                </a>
            </div>

            <!-- Pie de tarjeta -->
            <div class="border-top pt-3 text-muted" style="font-size: 0.8rem;">
                &copy; <?= date('Y') ?> Sistema de Facturación
            </div>

        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@adminlte/adminlte@4.0.0-beta2/dist/js/adminlte.min.js"></script>
</body>
</html>