<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-3 align-items-center">
        <div class="col-sm-6">
            <h3 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Compras</h3>
        </div>
        <div class="col-sm-6 text-end">
            <a href="<?= base_url('compras/nueva') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Nueva Compra
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        id_compra
                        <tr>
                            <th>#ID</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">IVA</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($compras)): ?>
                            <?php foreach ($compras as $c): ?>
                                <tr>
                                    <td><?= $c['id_compra']; ?></td>
                                    <td class="fw-semibold"><?= esc($c['proveedor_nombre']); ?></td>
                                    <td><?= $c['fecha']; ?></td>
                                    <td class="text-end">$<?= number_format($c['subtotal'], 2); ?></td>
                                    <td class="text-end">$<?= number_format($c['impuesto'], 2); ?></td>
                                    <td class="text-end fw-bold text-success">$<?= number_format($c['total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No hay compras registradas todavía.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>