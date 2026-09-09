<?php
namespace App\Models;
use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getVentasHoy()
    {
        return $this->db->table('venta')
            ->where('DATE(fecha)', date('Y-m-d'))
            ->countAllResults();
    }

    public function getIngresosMes()
    {
        $builder = $this->db->table('venta');
        $builder->selectSum('total');
        $builder->where('MONTH(fecha)', date('m'));
        $builder->where('YEAR(fecha)', date('Y'));
        $row = $builder->get()->getRow();
        return $row->total ?? 0;
    }

    public function getClientesCount()
    {
        return $this->db->table('cliente')->countAllResults();
    }

    public function getStockCriticoCount($limite = 5)
    {
        return $this->db->table('producto')
            ->where('stock <=', $limite)
            ->countAllResults();
    }

    public function getVentasUltimos7Dias()
    {
        return $this->db->query("
            SELECT DATE(fecha) as fecha, COUNT(*) as transacciones, SUM(total) as ingresos 
            FROM venta 
            WHERE fecha >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
            GROUP BY DATE(fecha) 
            ORDER BY fecha ASC
        ")->getResultArray();
    }

    public function getProductosMasVendidos($limit = 5)
    {
        return $this->db->query("
            SELECT p.nombre, SUM(dv.cantidad) as total_unidades, SUM(dv.subtotal) as total_ingresos
            FROM detalle_venta dv
            JOIN producto p ON dv.id_producto = p.id_producto
            GROUP BY p.id_producto, p.nombre
            ORDER BY total_unidades DESC
            LIMIT {$limit}
        ")->getResultArray();
    }

    public function getProductosStockBajo($limite = 5)
    {
        return $this->db->table('producto')
            ->select('nombre, precio_venta, stock')
            ->where('stock <=', $limite)
            ->orderBy('stock', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();
    }
}