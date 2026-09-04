<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Administración de Proveedores
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<!-- DataTables CSS Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h3 class="mb-0">Gestión de Proveedores</h3>
        </div>
        <div class="col-sm-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                <i class="bi bi-truck me-1"></i> Nuevo Proveedor
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="tablaProveedores">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 8%;">ID</th>
                            <th>Identificación (Cédula / RUC)</th>
                            <th>Nombre de Proveedor</th>
                            <th>Teléfono</th>
                            <th class="text-end" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($proveedores)): ?>
                            <?php foreach ($proveedores as $prov): ?>
                                <tr>
                                    <td><?= $prov['id_proveedor'] ?></td>
                                    <td><?= esc($prov['identificacion']) ?></td>
                                    <td><?= esc($prov['nombre']) ?></td>
                                    <td><?= esc($prov['telefono']) ?></td>
                                    <td class="text-end">
                                        <!-- Botón Editar -->
                                        <button type="button" class="btn btn-sm btn-outline-warning btn-editar"
                                            data-id="<?= $prov['id_proveedor'] ?>"
                                            data-identificacion="<?= esc($prov['identificacion']) ?>"
                                            data-nombre="<?= esc($prov['nombre']) ?>"
                                            data-telefono="<?= esc($prov['telefono']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEditar">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Botón Eliminar con SweetAlert2 -->
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar"
                                            data-url="<?= base_url('proveedores/eliminar/' . $prov['id_proveedor']) ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Crear -->
<div class="modal fade" id="modalCrear" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?= base_url('proveedores/guardar') ?>" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-truck me-2"></i>Nuevo Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="identificacion" class="form-label fw-semibold">Identificación (Cédula o RUC) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="identificacion" name="identificacion" required maxlength="13" placeholder="Ej. 1004567890 o RUC">
                    <div class="form-text">Ingrese 10 dígitos (cédula) o 13 dígitos (RUC).</div>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold">Nombre del Proveedor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3" maxlength="100" placeholder="Ej. Distribuidora S.A.">
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label fw-semibold">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" maxlength="20" placeholder="Ej. 062600100">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Proveedor</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditar" action="<?= base_url('proveedores/guardar') ?>" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" id="idProveedor" name="id_proveedor">
            
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Proveedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="identificacionEditar" class="form-label fw-semibold">Identificación (Cédula o RUC) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="identificacionEditar" name="identificacion" required maxlength="13">
                </div>
                <div class="mb-3">
                    <label for="nombreEditar" class="form-label fw-semibold">Nombre del Proveedor <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombreEditar" name="nombre" required minlength="3" maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="telefonoEditar" class="form-label fw-semibold">Teléfono</label>
                    <input type="text" class="form-control" id="telefonoEditar" name="telefono" maxlength="20">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Actualizar Cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#tablaProveedores').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        columnDefs: [
            { orderable: false, targets: 4 } 
        ],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]]
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });

    <?php if (session()->has('success')): ?>
        Toast.fire({ icon: 'success', title: '<?= addslashes(session('success')) ?>' });
    <?php endif; ?>

    <?php if (session()->has('error')): ?>
        Toast.fire({ icon: 'error', title: '<?= addslashes(session('error')) ?>' });
    <?php endif; ?>

    <?php if (session()->has('errors')): ?>
        <?php foreach (session('errors') as $error): ?>
            Toast.fire({ icon: 'error', title: '<?= addslashes($error) ?>' });
        <?php endforeach; ?>
    <?php endif; ?>

    $(document).on('click', '.btn-eliminar', function(e) {
        e.preventDefault();
        let urlEliminar = $(this).data('url');
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡Esta acción no se puede revertir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash"></i> Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = urlEliminar;
            }
        });
    });

    const modalEditar = document.getElementById('modalEditar');
    modalEditar.addEventListener('show.bs.modal', function(event) {
        let button = event.relatedTarget;
        modalEditar.querySelector('#idProveedor').value = button.getAttribute('data-id');
        modalEditar.querySelector('#identificacionEditar').value = button.getAttribute('data-identificacion');
        modalEditar.querySelector('#nombreEditar').value = button.getAttribute('data-nombre');
        modalEditar.querySelector('#telefonoEditar').value = button.getAttribute('data-telefono');
    });
});
</script>
<?= $this->endSection() ?>