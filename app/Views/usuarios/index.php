<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Usuarios
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<!-- DataTables CSS Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h3 class="mb-0">Gestión de Usuarios</h3>
        </div>
        <div class="col-sm-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="tablaUsuarios">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 8%;">ID</th>
                            <th>Nombre Completo</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th class="text-end" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($usuarios)): ?>
                            <?php foreach ($usuarios as $usr): ?>
                                <tr>
                                    <td><?= $usr['id_usuario'] ?></td>
                                    <td><?= esc($usr['nombre']) ?></td>
                                    <td><?= esc($usr['correo']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $usr['rol'] == 'Administrador' ? 'danger' : ($usr['rol'] == 'Supervisor' ? 'warning text-dark' : 'info') ?>">
                                            <?= esc($usr['rol']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <!-- Botón Editar -->
                                        <button type="button" class="btn btn-sm btn-outline-warning btn-editar"
                                            data-id="<?= $usr['id_usuario'] ?>"
                                            data-nombre="<?= esc($usr['nombre']) ?>"
                                            data-correo="<?= esc($usr['correo']) ?>"
                                            data-rol="<?= esc($usr['rol']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEditar">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Botón Eliminar -->
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar"
                                            data-url="<?= base_url('usuarios/eliminar/' . $usr['id_usuario']) ?>">
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
        <form action="<?= base_url('usuarios/guardar') ?>" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus-fill me-2"></i>Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required minlength="3" maxlength="100" placeholder="Ej. Ana Gómez">
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="correo" name="correo" required maxlength="100" placeholder="Ej. ana@email.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required minlength="6" placeholder="Mínimo 6 caracteres">
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label fw-semibold">Rol del Usuario <span class="text-danger">*</span></label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="">Seleccione un rol...</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Vendedor">Vendedor</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditar" action="<?= base_url('usuarios/guardar') ?>" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" id="idUsuario" name="id_usuario">
            
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="nombreEditar" class="form-label fw-semibold">Nombre Completo <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombreEditar" name="nombre" required minlength="3" maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="correoEditar" class="form-label fw-semibold">Correo Electrónico <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="correoEditar" name="correo" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="passwordEditar" class="form-label fw-semibold">Contraseña</label>
                    <input type="password" class="form-control" id="passwordEditar" name="password" minlength="6" placeholder="Dejar en blanco para mantener la actual">
                    <div class="form-text text-muted">Solo complete si desea cambiar la contraseña.</div>
                </div>
                <div class="mb-3">
                    <label for="rolEditar" class="form-label fw-semibold">Rol del Usuario <span class="text-danger">*</span></label>
                    <select class="form-select" id="rolEditar" name="rol" required>
                        <option value="Administrador">Administrador</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Vendedor">Vendedor</option>
                    </select>
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
    $('#tablaUsuarios').DataTable({
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
        modalEditar.querySelector('#idUsuario').value = button.getAttribute('data-id');
        modalEditar.querySelector('#nombreEditar').value = button.getAttribute('data-nombre');
        modalEditar.querySelector('#correoEditar').value = button.getAttribute('data-correo');
        modalEditar.querySelector('#rolEditar').value = button.getAttribute('data-rol');
        modalEditar.querySelector('#passwordEditar').value = ''; // Limpiar campo contraseña por seguridad
    });
});
</script>
<?= $this->endSection() ?>