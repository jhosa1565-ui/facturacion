<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h3 class="mb-0"><i class="bi bi-cart-plus me-2"></i>Registrar Nueva Compra (Abastecimiento)</h3>
        </div>
        <div class="col-sm-6 text-end">
            <a href="<?= base_url('compras') ?>" class="btn btn-secondary btn-sm">
                <i class="bi bi-clock-history me-1"></i> Ver Historial
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Proveedor y Productos -->
        <div class="col-lg-5">
            <!-- Selector de Proveedor -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light fw-semibold">1. Datos del Proveedor</div>
                <div class="card-body">
                    <div class="mb-2 position-relative">
                        <label class="form-label">Buscar Proveedor (Nombre o RUC)</label>
                        <input type="text" id="buscarProveedorInput" class="form-control" autocomplete="off" placeholder="Escriba para buscar...">
                        <div id="listaProveedores" class="list-group shadow" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 9999; max-height: 200px; overflow-y: auto; background: #fff;"></div>
                    </div>
                    <input type="hidden" id="id_proveedor">
                    <div id="infoProveedor" class="text-muted small mt-2">Ningún proveedor seleccionado.</div>
                </div>
            </div>

            <!-- Selector de Productos -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light fw-semibold">2. Agregar Productos al Stock</div>
                <div class="card-body">
                    <div class="mb-2 position-relative">
                        <label class="form-label">Buscar Producto</label>
                        <input type="text" id="buscarProductoInput" class="form-control" autocomplete="off" placeholder="Escriba para buscar...">
                        <div id="listaProductos" class="list-group shadow" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 9999; max-height: 200px; overflow-y: auto; background: #fff;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Detalle de la Compra y Totales -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light fw-semibold">3. Detalle de la Factura de Compra</div>
                <div class="card-body">
                    <div class="table-responsive" style="min-height: 250px;">
                        <table class="table table-bordered align-middle" id="tablaDetalle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th style="width: 90px;">Stock Actual</th>
                                    <th style="width: 90px;">Cant</th>
                                    <th style="width: 100px;">Costo Unit</th>
                                    <th style="width: 100px;">Subtotal</th>
                                    <th style="width: 50px;" class="text-center"><i class="bi bi-trash"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="filaVacia">
                                    <td colspan="6" class="text-center text-muted">No hay productos agregados.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Totales -->
                    <div class="d-flex justify-content-end">
                        <div class="w-50">
                            <table class="table table-sm">
                                <tr>
                                    <td class="fw-semibold">Subtotal:</td>
                                    <td class="text-end" id="lblSubtotal">$0.00</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">IVA (15%):</td>
                                    <td class="text-end" id="lblImpuesto">$0.00</td>
                                </tr>
                                <tr class="fs-5">
                                    <td class="fw-bold">Total:</td>
                                    <td class="text-end fw-bold text-success" id="lblTotal">$0.00</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <button type="button" id="btnProcesarCompra" class="btn btn-primary w-100 py-2 fw-semibold mt-3">
                        <i class="bi bi-check-circle me-1"></i> Registrar Compra y Actualizar Stock
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
let carrito = [];

document.addEventListener('DOMContentLoaded', function() {
    // 1. Búsqueda de Proveedores
    $('#buscarProveedorInput').on('input', function() {
        let q = $(this).val();
        if(q.length < 2) { $('#listaProveedores').html(''); return; }
        $.get('<?= base_url('compras/buscar-proveedor') ?>', { q: q }, function(data) {
            let html = '';
            if(data && data.length > 0) {
                data.forEach(p => {
                    html += `<a href="#" class="list-group-item list-group-item-action seleccionar-proveedor" data-id="${p.id_proveedor}" data-nombre="${p.nombre}" data-ruc="${p.ruc}">${p.ruc} - ${p.nombre}</a>`;
                });
            } else {
                html = `<div class="list-group-item text-muted">No se encontraron proveedores</div>`;
            }
            $('#listaProveedores').html(html);
        });
    });

    $(document).on('click', '.seleccionar-proveedor', function(e) {
        e.preventDefault();
        $('#id_proveedor').val($(this).data('id'));
        $('#infoProveedor').html(`<strong>Proveedor:</strong> ${$(this).data('nombre')} (${$(this).data('ruc')})`);
        $('#buscarProveedorInput').val('');
        $('#listaProveedores').html('');
    });

    // 2. Búsqueda de Productos
    $('#buscarProductoInput').on('input', function() {
        let q = $(this).val();
        if(q.length < 2) { $('#listaProductos').html(''); return; }
        $.get('<?= base_url('compras/buscar-producto') ?>', { q: q }, function(data) {
            let html = '';
            if(data && data.length > 0) {
                data.forEach(p => {
                    html += `<a href="#" class="list-group-item list-group-item-action seleccionar-producto" data-id="${p.id_producto}" data-nombre="${p.nombre}" data-precio="${p.precio_venta ?? 0}" data-stock="${p.stock}">${p.nombre} - Stock actual: ${p.stock}</a>`;
                });
            } else {
                html = `<div class="list-group-item text-muted">No se encontraron productos</div>`;
            }
            $('#listaProductos').html(html);
        });
    });

    $(document).on('click', '.seleccionar-producto', function(e) {
        e.preventDefault();
        let producto = {
            id_producto: $(this).data('id'),
            nombre: $(this).data('nombre'),
            precio_unitario: parseFloat($(this).data('precio')),
            stock: parseInt($(this).data('stock')),
            cantidad: 1
        };

        let existe = carrito.find(item => item.id_producto === producto.id_producto);
        if(existe) {
            existe.cantidad++;
        } else {
            carrito.push(producto);
        }

        $('#buscarProductoInput').val('');
        $('#listaProductos').html('');
        renderizarTabla();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('#buscarProveedorInput, #listaProveedores').length) {
            $('#listaProveedores').html('');
        }
        if (!$(e.target).closest('#buscarProductoInput, #listaProductos').length) {
            $('#listaProductos').html('');
        }
    });

    window.cambiarCantidad = function(id, cantidad) {
        let item = carrito.find(i => i.id_producto === id);
        let nuevaCant = parseInt(cantidad);
        if(nuevaCant > 0) {
            item.cantidad = nuevaCant;
        }
        renderizarTabla();
    };

    window.cambiarPrecio = function(id, precio) {
        let item = carrito.find(i => i.id_producto === id);
        let nuevoPrecio = parseFloat(precio);
        if(nuevoPrecio >= 0) {
            item.precio_unitario = nuevoPrecio;
        }
        renderizarTabla();
    };

    window.eliminarItem = function(id) {
        carrito = carrito.filter(i => i.id_producto !== id);
        renderizarTabla();
    };

    function renderizarTabla() {
        let tbody = $('#tablaDetalle tbody');
        tbody.html('');

        if(carrito.length === 0) {
            tbody.html(`<tr id="filaVacia"><td colspan="6" class="text-center text-muted">No hay productos agregados.</td></tr>`);
            $('#lblSubtotal').text('$0.00');
            $('#lblImpuesto').text('$0.00');
            $('#lblTotal').text('$0.00');
            return;
        }

        let subtotalGeneral = 0;
        carrito.forEach(item => {
            let subtotalItem = item.cantidad * item.precio_unitario;
            subtotalGeneral += subtotalItem;

            tbody.append(`
                <tr>
                    <td>${item.nombre}</td>
                    <td><span class="badge bg-secondary">${item.stock}</span></td>
                    <td><input type="number" class="form-control form-control-sm" value="${item.cantidad}" min="1" onchange="cambiarCantidad(${item.id_producto}, this.value)"></td>
                    <td><input type="number" class="form-control form-control-sm" value="${item.precio_unitario.toFixed(2)}" step="0.01" min="0" onchange="cambiarPrecio(${item.id_producto}, this.value)"></td>
                    <td>$${subtotalItem.toFixed(2)}</td>
                    <td class="text-center"><button class="btn btn-sm btn-outline-danger" onclick="eliminarItem(${item.id_producto})"><i class="bi bi-trash"></i></button></td>
                </tr>
            `);
        });

        let impuesto = subtotalGeneral * 0.15; // IVA 15%
        let total = subtotalGeneral + impuesto;

        $('#lblSubtotal').text('$' + subtotalGeneral.toFixed(2));
        $('#lblImpuesto').text('$' + impuesto.toFixed(2));
        $('#lblTotal').text('$' + total.toFixed(2));
    }

    // 4. Guardar Compra
    $('#btnProcesarCompra').on('click', function() {
        let idProveedor = $('#id_proveedor').val();
        if(!idProveedor) {
            Swal.fire('Error', 'Debe seleccionar un proveedor.', 'error');
            return;
        }
        if(carrito.length === 0) {
            Swal.fire('Error', 'Debe agregar al menos un producto.', 'error');
            return;
        }

        let subtotalGeneral = carrito.reduce((acc, i) => acc + (i.cantidad * i.precio_unitario), 0);
        let impuesto = subtotalGeneral * 0.15;
        let total = subtotalGeneral + impuesto;

        let itemsMapeados = carrito.map(i => ({
            id_producto: i.id_producto,
            cantidad: i.cantidad,
            precio_unitario: i.precio_unitario,
            subtotal: i.cantidad * i.precio_unitario
        }));

        Swal.fire({
            title: '¿Confirmar compra?',
            text: "Se registrará la factura y el stock de los productos aumentará.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, registrar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('compras/guardar') ?>',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id_proveedor: idProveedor,
                        items: itemsMapeados,
                        subtotal: subtotalGeneral,
                        impuesto: impuesto,
                        total: total
                    }),
                    headers: { '<?= csrf_header() ?>': '<?= csrf_hash() ?>' },
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire('¡Éxito!', response.message, 'success').then(() => {
                                window.location.href = '<?= base_url('compras/nueva') ?>';
                            });
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Ocurrió un error inesperado en el servidor.', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>