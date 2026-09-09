<?php
namespace App\Controllers;
use App\Models\DashboardModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $model = new DashboardModel();

        $data = [
            'ventas_hoy' => $model->getVentasHoy(),
            'ingresos_mes' => $model->getIngresosMes(),
            'clientes_count' => $model->getClientesCount(),
            'stock_critico' => $model->getStockCriticoCount(),
            'ultimos_dias' => json_encode($model->getVentasUltimos7Dias()),
            'productos_top' => $model->getProductosMasVendidos(),
            'alertas_stock' => $model->getProductosStockBajo(),
        ];

        return view('dashboard/index', $data);
    }
}