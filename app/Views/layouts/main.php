<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $this->renderSection('title') ?> | Sistema de Facturación</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fuentes e Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- AdminLTE v4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@adminlte/adminlte@4.0.0-beta2/dist/css/adminlte.min.css">

    <!-- Forzar diseño de barra lateral a la izquierda en AdminLTE v4 -->
    <style>
        body.layout-fixed .app-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            z-index: 1038;
            background-color: #ffffff !important;
            box-shadow: var(--bs-box-shadow-sm);
        }
        body.layout-fixed .app-main, body.layout-fixed .layout-footer {
            margin-left: 250px;
        }
        @media (max-width: 991.98px) {
            body.layout-fixed .app-sidebar {
                transform: translateX(-250px);
            }
            body.layout-fixed .app-main, body.layout-fixed .layout-footer {
                margin-left: 0;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <!-- Barra Superior (Navbar) -->
        <?= $this->include('layouts/components/navbar') ?>

        <!-- Barra Lateral Vertical (Sidebar) -->
        <?= $this->include('layouts/components/sidebar') ?>

        <!-- Contenido Principal -->
        <main class="app-main">
            <div class="app-content py-4">
                <div class="container-fluid">
                    <?= $this->renderSection('content') ?>
                </div>
            </div>
        </main>

        <!-- Pie de página -->
        <?= $this->include('layouts/components/footer') ?>

    </div>

    <!-- Scripts de Bootstrap y AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@adminlte/adminlte@4.0.0-beta2/dist/js/adminlte.min.js"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>