<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Gestión de Productos
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<!-- DataTables CSS Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h3 class="mb-0">Gestión de Productos</h3>
        </div>
        <div class="col-sm-6 text-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
                <i class="bi bi-box-seam me-1"></i> Nuevo Producto
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle w-100" id="tablaProductos">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Marca</th>
                            <th>Precio Venta</th>
                            <th>Stock</th>
                            <th class="text-end" style="width: 15%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $prod): ?>
                                <tr>
                                    <td><?= $prod['id_producto'] ?></td>
                                    <td><?= esc($prod['codigo_barras']) ?></td>
                                    <td><?= esc($prod['nombre']) ?></td>
                                    <td><?= esc($prod['categoria_nombre']) ?></td>
                                    <td><?= esc($prod['marca_nombre']) ?></td>
                                    <td>$<?= number_format($prod['precio_venta'], 2) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $prod['stock'] > 10 ? 'success' : ($prod['stock'] > 0 ? 'warning text-dark' : 'danger') ?>">
                                            <?= $prod['stock'] ?> un.
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <!-- Botón Editar -->
                                        <button type="button" class="btn btn-sm btn-outline-warning btn-editar"
                                            data-id="<?= $prod['id_producto'] ?>"
                                            data-codigo="<?= esc($prod['codigo_barras']) ?>"
                                            data-nombre="<?= esc($prod['nombre']) ?>"
                                            data-categoria="<?= $prod['id_categoria'] ?>"
                                            data-marca="<?= $prod['id_marca'] ?>"
                                            data-precio="<?= $prod['precio_venta'] ?>"
                                            data-stock="<?= $prod['stock'] ?>"
                                            data-bs-toggle="modal" data-bs-target="#modalEditar">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <!-- Botón Eliminar -->
                                        <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar"
                                            data-url="<?= base_url('productos/eliminar/' . $prod['id_producto']) ?>">
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
        <form action="<?= base_url('productos/guardar') ?>" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-box-seam me-2"></i>Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="codigo_barras" class="form-label fw-semibold">Código de Barras</label>
                    <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" placeholder="Ej. 786123456789">
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label fw-semibold">Nombre del Producto <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required minlength="2" maxlength="100" placeholder="Ej. Camiseta deportiva">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_categoria" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_categoria" name="id_categoria" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id_categoria'] ?>"><?= esc($cat['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="id_marca" class="form-label fw-semibold">Marca <span class="text-danger">*</span></label>
                        <select class="form-select" id="id_marca" name="id_marca" required>
                            <option value="">Seleccione...</option>
                            <?php foreach ($marcas as $mar): ?>
                                <option value="<?= $mar['id_marca'] ?>"><?= esc($mar['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precio_venta" class="form-label fw-semibold">Precio Venta ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="precio_venta" name="precio_venta" required placeholder="0.00">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stock" class="form-label fw-semibold">Stock Inicial <span class="text-danger">*</span></label>
                        <input type="number" min="0" class="form-control" id="stock" name="stock" required placeholder="0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Producto</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditar" action="<?= base_url('productos/guardar') ?>" method="POST" class="modal-content">
            <?= csrf_field() ?>
            <input type="hidden" id="idProducto" name="id_producto">
            
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Editar Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="codigoEditar" class="form-label fw-semibold">Código de Barras</label>
                    <input type="text" class="form-control" id="codigoEditar" name="codigo_barras">
                </div>
                <div class="mb-3">
                    <label for="nombreEditar" class="form-label fw-semibold">Nombre del Producto <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombreEditar" name="nombre" required minlength="2" maxlength="100">
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="categoriaEditar" class="form-label fw-semibold">Categoría <span class="text-danger">*</span></label>
                        <select class="form-select" id="categoriaEditar" name="id_categoria" required>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id_categoria'] ?>"><?= esc($cat['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="marcaEditar" class="form-label fw-semibold">Marca <span class="text-danger">*</span></label>
                        <select class="form-select" id="marcaEditar" name="id_marca" required>
                            <?php foreach ($marcas as $mar): ?>
                                <option value="<?= $mar['id_marca'] ?>"><?= esc($mar['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="precioEditar" class="form-label fw-semibold">Precio Venta ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control" id="precioEditar" name="precio_venta" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="stockEditar" class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                        <input type="number" min="0" class="form-control" id="stockEditar" name="stock" required>
                    </div>
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
    $('#tablaProductos').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        columnDefs: [
            { orderable: false, targets: 7 } 
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
            text: "¡Esta acción eliminará el producto del inventario!",
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
        modalEditar.querySelector('#idProducto').value = button.getAttribute('data-id');
        modalEditar.querySelector('#codigoEditar').value = button.getAttribute('data-codigo');
        modalEditar.querySelector('#nombreEditar').value = button.getAttribute('data-nombre');
        modalEditar.querySelector('#categoriaEditar').value = button.getAttribute('data-categoria');
        modalEditar.querySelector('#marcaEditar').value = button.getAttribute('data-marca');
        modalEditar.querySelector('#precioEditar').value = button.getAttribute('data-precio');
        modalEditar.querySelector('#stockEditar').value = button.getAttribute('data-stock');
    });
});
</script>
<?= $this->endSection() ?>