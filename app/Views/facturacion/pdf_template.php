<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #<?= $venta['id_venta'] ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #2c3e50; }
        .info-table, .items-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .info-table td { padding: 5px; vertical-align: top; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .items-table th { background-color: #f8f9fa; color: #333; }
        .text-right { text-align: right; }
        .totals { margin-top: 20px; float: right; width: 250px; }
        .totals table { width: 100%; border-collapse: collapse; }
        .totals td { padding: 5px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>

    <div class="header">
        <h2>SISTEMA DE FACTURACIÓN</h2>
        <p>Comprobante de Venta</p>
    </div>

    <table class="info-table">
        <tr>
            <td>
                <strong>Cliente:</strong> <?= $cliente['nombre'] ?? 'Consumidor Final' ?><br>
                <strong>Identificación:</strong> <?= $cliente['identificacion'] ?? 'N/A' ?><br>
                <strong>Teléfono:</strong> <?= $cliente['telefono'] ?? 'N/A' ?>
            </td>
            <td class="text-right">
                <strong>Nro Factura:</strong> #<?= str_pad($venta['id_venta'], 6, '0', STR_PAD_LEFT) ?><br>
                <strong>Fecha:</strong> <?= $venta['fecha'] ?><br>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th class="text-right">Cant</th>
                <th class="text-right">P. Unit</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $item): ?>
            <tr>
                <td><?= $item['nombre_producto'] ?></td>
                <td class="text-right"><?= $item['cantidad'] ?></td>
                <td class="text-right">$<?= number_format($item['precio_unitario'], 2) ?></td>
                <td class="text-right">$<?= number_format($item['subtotal'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Total:</strong></td>
                <td class="text-right"><strong>$<?= number_format($venta['total'], 2) ?></strong></td>
            </tr>
        </table>
    </div>

</body>
</html>