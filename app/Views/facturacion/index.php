<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?> Nueva Factura <?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-6">
            <h3 class="mb-0"><i class="bi bi-receipt-cutoff me-2"></i>Nueva Factura de Venta</h3>
        </div>
    </div>

    <div class="row">
        <!-- Columna Izquierda: Selección de Cliente y Productos -->
        <div class="col-lg-5">
            <!-- Selector de Cliente -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light fw-semibold">1. Datos del Cliente</div>
                <div class="card-body">
                    <div class="mb-2 position-relative">
                        <label class="form-label">Buscar Cliente (Nombre o Cédula/RUC)</label>
                        <input type="text" id="buscarClienteInput" class="form-control" autocomplete="off" placeholder="Escriba para buscar...">
                        <!-- Contenedor absoluto con z-index alto para garantizar visibilidad -->
                        <div id="listaClientes" class="list-group shadow" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 9999; max-height: 200px; overflow-y: auto; background: #fff;"></div>
                    </div>
                    <input type="hidden" id="id_cliente">
                    <div id="infoCliente" class="text-muted small mt-2">Ningún cliente seleccionado.</div>
                </div>
            </div>

            <!-- Selector de Productos -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light fw-semibold">2. Agregar Productos</div>
                <div class="card-body">
                    <div class="mb-2 position-relative">
                        <label class="form-label">Buscar Producto (Nombre o Código)</label>
                        <input type="text" id="buscarProductoInput" class="form-control" autocomplete="off" placeholder="Escriba para buscar...">
                        <!-- Contenedor absoluto con z-index alto para garantizar visibilidad -->
                        <div id="listaProductos" class="list-group shadow" style="position: absolute; top: 100%; left: 0; right: 0; z-index: 9999; max-height: 200px; overflow-y: auto; background: #fff;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Detalle de Factura y Totales -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light fw-semibold">3. Detalle de la Factura</div>
                <div class="card-body">
                    <div class="table-responsive" style="min-height: 250px;">
                        <table class="table table-bordered align-middle" id="tablaDetalle">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th style="width: 90px;">Stock</th>
                                    <th style="width: 90px;">Cant</th>
                                    <th style="width: 100px;">P. Unit</th>
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

                    <button type="button" id="btnProcesarVenta" class="btn btn-success w-100 py-2 fw-semibold mt-3">
                        <i class="bi bi-check-circle me-1"></i> Concretar Factura
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
    // 1. Búsqueda de Clientes AJAX
    $('#buscarClienteInput').on('input', function() {
        let q = $(this).val();
        if(q.length < 2) { $('#listaClientes').html(''); return; }
        $.get('<?= base_url('facturas/buscar-cliente') ?>', { q: q }, function(data) {
            let html = '';
            if(data && data.length > 0) {
                data.forEach(c => {
                    html += `<a href="#" class="list-group-item list-group-item-action seleccionar-cliente" data-id="${c.id_cliente}" data-nombre="${c.nombre}" data-identificacion="${c.identificacion}">${c.identificacion} - ${c.nombre}</a>`;
                });
            } else {
                html = `<div class="list-group-item text-muted">No se encontraron clientes</div>`;
            }
            $('#listaClientes').html(html);
        });
    });

    $(document).on('click', '.seleccionar-cliente', function(e) {
        e.preventDefault();
        $('#id_cliente').val($(this).data('id'));
        $('#infoCliente').html(`<strong>Cliente:</strong> ${$(this).data('nombre')} (${$(this).data('identificacion')})`);
        $('#buscarClienteInput').val('');
        $('#listaClientes').html('');
    });

    // 2. Búsqueda de Productos AJAX
    $('#buscarProductoInput').on('input', function() {
        let q = $(this).val();
        if(q.length < 2) { $('#listaProductos').html(''); return; }
        $.get('<?= base_url('facturas/buscar-producto') ?>', { q: q }, function(data) {
            let html = '';
            if(data && data.length > 0) {
                data.forEach(p => {
                    html += `<a href="#" class="list-group-item list-group-item-action seleccionar-producto" data-id="${p.id_producto}" data-nombre="${p.nombre}" data-precio="${p.precio_venta}" data-stock="${p.stock}">${p.nombre} - Stock: ${p.stock} - $${p.precio_venta}</a>`;
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
            if(existe.cantidad + 1 > producto.stock) {
                Swal.fire('Atención', 'No hay suficiente stock disponible para agregar más unidades.', 'warning');
                return;
            }
            existe.cantidad++;
        } else {
            carrito.push(producto);
        }

        $('#buscarProductoInput').val('');
        $('#listaProductos').html('');
        renderizarTabla();
    });

    // Ocultar listas al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#buscarClienteInput, #listaClientes').length) {
            $('#listaClientes').html('');
        }
        if (!$(e.target).closest('#buscarProductoInput, #listaProductos').length) {
            $('#listaProductos').html('');
        }
    });

    // 3. Renderizar Tabla y Totales
    window.cambiarCantidad = function(id, cantidad) {
        let item = carrito.find(i => i.id_producto === id);
        let nuevaCant = parseInt(cantidad);
        if(nuevaCant > item.stock) {
            Swal.fire('Atención', 'La cantidad supera el stock disponible (' + item.stock + ')', 'warning');
            renderizarTabla();
            return;
        }
        if(nuevaCant > 0) {
            item.cantidad = nuevaCant;
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
                    <td><input type="number" class="form-control form-control-sm" value="${item.cantidad}" min="1" max="${item.stock}" onchange="cambiarCantidad(${item.id_producto}, this.value)"></td>
                    <td>$${item.precio_unitario.toFixed(2)}</td>
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

    // 4. Concretar Factura
    $('#btnProcesarVenta').on('click', function() {
        let idCliente = $('#id_cliente').val();
        if(!idCliente) {
            Swal.fire('Error', 'Debe seleccionar un cliente para la factura.', 'error');
            return;
        }
        if(carrito.length === 0) {
            Swal.fire('Error', 'Debe agregar al menos un producto.', 'error');
            return;
        }

        let subtotalGeneral = carrito.reduce((acc, i) => acc + (i.cantidad * i.precio_unitario), 0);
        let impuesto = subtotalGeneral * 0.15;
        let total = subtotalGeneral + impuesto;

        // Mapeamos el carrito asegurando que cada objeto lleve explícitamente su 'subtotal'
        let itemsMapeados = carrito.map(i => ({
            id_producto: i.id_producto,
            cantidad: i.cantidad,
            precio_unitario: i.precio_unitario,
            subtotal: i.cantidad * i.precio_unitario
        }));

        Swal.fire({
            title: '¿Confirmar venta?',
            text: "Se generará la factura y se descontará el stock de los productos.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, facturar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('facturas/guardar') ?>',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        id_cliente: idCliente,
                        items: itemsMapeados,
                        subtotal: subtotalGeneral,
                        impuesto: impuesto,
                        total: total
                    }),
                    headers: { '<?= csrf_header() ?>': '<?= csrf_hash() ?>' },
                    success: function(response) {
                        if(response.status === 'success') {
                            Swal.fire('¡Éxito!', response.message, 'success').then(() => {
                                window.location.href = '<?= base_url('facturas/nueva') ?>';
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