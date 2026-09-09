<?= $this->extend('layouts/main'); ?>

<?= $this->section('content'); ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 font-weight-bold text-dark">Decisiones con datos claros</h1>
        <p class="text-muted">Revisa el pulso del negocio y detecta lo que necesita atención hoy.</p>
      </div>
      <div class="col-sm-6 text-right">
        <span class="badge bg-light p-2 border shadow-sm text-dark">
          <i class="far fa-calendar-alt"></i> <?= date('d/m/Y'); ?>
        </span>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-bottom border-primary border-top-0 border-left-0 border-right-0 p-3">
          <div class="inner">
            <h3><?= $ventas_hoy; ?></h3>
            <p class="text-muted mb-0">Ventas de hoy</p>
            <small class="text-xs text-muted">transacciones registradas</small>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-bottom border-success border-top-0 border-left-0 border-right-0 p-3">
          <div class="inner">
            <h3>$<?= number_format($ingresos_mes, 2); ?></h3>
            <p class="text-muted mb-0">Ingresos del mes</p>
            <small class="text-xs text-muted">acumulado mensual</small>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-bottom border-info border-top-0 border-left-0 border-right-0 p-3">
          <div class="inner">
            <h3><?= $clientes_count; ?></h3>
            <p class="text-muted mb-0">Clientes registrados</p>
            <small class="text-xs text-muted">base de clientes</small>
          </div>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-white shadow-sm border-bottom border-danger border-top-0 border-left-0 border-right-0 p-3">
          <div class="inner">
            <h3><?= $stock_critico; ?></h3>
            <p class="text-muted mb-0">Stock por revisar</p>
            <small class="text-xs text-danger font-weight-bold">productos con 5 o menos unidades</small>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0">
            <h3 class="card-title font-weight-bold">Actividad de los últimos 7 días</h3>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="salesChart" style="min-height: 280px; height: 280px; max-height: 280px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0">
            <h3 class="card-title font-weight-bold">Estado Operativo</h3>
          </div>
          <div class="card-body text-center d-flex flex-column justify-content-center align-items-center" style="min-height: 280px;">
            <div class="mb-3">
              <i class="fas fa-chart-pie fa-3x text-secondary opacity-50"></i>
            </div>
            <p class="text-muted">El flujo de caja y rotación de inventarios se encuentra estable para las operaciones actuales.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-8">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0">
            <h3 class="card-title font-weight-bold">Productos más vendidos</h3>
          </div>
          <div class="card-body p-0">
            <table class="table table-hover mb-0">
              <thead class="thead-light">
                <tr>
                  <th>PRODUCTO</th>
                  <th class="text-center">UNIDADES</th>
                  <th class="text-right">INGRESOS</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($productos_top)): ?>
                  <?php foreach ($productos_top as $prod): ?>
                    <tr>
                      <td class="font-weight-bold"><?= esc($prod['nombre']); ?></td>
                      <td class="text-center"><span class="badge badge-primary"><?= $prod['total_unidades']; ?></span></td>
                      <td class="text-right text-success font-weight-bold">$<?= number_format($prod['total_ingresos'], 2); ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="3" class="text-center text-muted py-3">No hay registros de ventas aún.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card shadow-sm border-0">
          <div class="card-header bg-white border-0">
            <h3 class="card-title font-weight-bold">Alertas de inventario</h3>
          </div>
          <div class="card-body p-0">
            <ul class="products-list product-list-in-card pl-2 pr-2">
              <?php if (!empty($alertas_stock)): ?>
                <?php foreach ($alertas_stock as $item): ?>
                  <li class="item py-2 border-bottom px-3">
                    <span class="product-title font-weight-bold"><?= esc($item['nombre']); ?></span>
                    <span class="product-description text-muted">Precio: $<?= number_format($item['precio_venta'], 2); ?></span>
                    <span class="badge badge-warning float-right"><?= $item['stock']; ?> unid.</span>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <li class="item text-center text-muted py-3">Inventario en niveles óptimos.</li>
              <?php endif; ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const rawData = <?= $ultimos_dias; ?>;
    const labels = rawData.map(item => item.fecha);
    const ventas = rawData.map(item => item.transacciones);
    const ingresos = rawData.map(item => item.ingresos);

    var salesChartCanvas = document.getElementById('salesChart').getContext('2d');
    
    new Chart(salesChartCanvas, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Transacciones',
                    backgroundColor: 'rgba(60,141,188,0.1)',
                    borderColor: 'rgba(60,141,188,1)',
                    data: ventas,
                    yAxisID: 'y', // Usa el eje izquierdo
                    tension: 0.3
                },
                {
                    label: 'Ingresos ($)',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    data: ingresos,
                    yAxisID: 'y1', // Usa el eje derecho para evitar que aplaste la otra línea
                    tension: 0.3
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Transacciones'
                    }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    grid: {
                        drawOnChartArea: false // Evita que se solapen las líneas de la cuadrícula
                    },
                    title: {
                        display: true,
                        text: 'Ingresos ($)'
                    }
                }
            }
        }
    });
});
</script>

<?= $this->endSection(); ?>