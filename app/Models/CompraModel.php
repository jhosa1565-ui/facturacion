<?php
namespace App\Models;
use CodeIgniter\Model;

class CompraModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getHistorialCompras()
    {
        return $this->db->query("
            SELECT c.*, p.nombre as proveedor_nombre 
            FROM compra c
            JOIN proveedor p ON c.id_proveedor = p.id_proveedor
            ORDER BY c.fecha DESC
        ")->getResultArray();
    }

    public function buscarProveedores($q)
    {
        // Usamos una consulta preparada con la columna real 'identificacion'
        return $this->db->query("
            SELECT id_proveedor, identificacion as ruc, nombre, telefono 
            FROM proveedor 
            WHERE nombre LIKE ? OR identificacion LIKE ? 
            LIMIT 10
        ", ["%$q%", "%$q%"])->getResultArray();
    }

    public function buscarProductos($q)
    {
        return $this->db->table('producto')
            ->like('nombre', $q)
            ->limit(10)
            ->get()
            ->getResultArray();
    }

    public function registrarCompra($id_proveedor, $items, $total)
    {
        $this->db->transStart();

        $idUsuario = session()->get('id_usuario') ?? 1;

        // 1. Insertar Cabecera de Compra
        $this->db->table('compra')->insert([
            'id_proveedor' => $id_proveedor,
            'id_usuario'   => $idUsuario,
            'total'        => $total,
            'fecha'        => date('Y-m-d H:i:s')
        ]);
        $id_compra = $this->db->insertID();

        // 2. Insertar Detalles y Aumentar Stock
        foreach ($items as $item) {
            $this->db->table('detalle_compra')->insert([
                'id_compra'      => $id_compra,
                'id_producto'    => $item->id_producto,
                'cantidad'       => $item->cantidad,
                'costo_unitario' => $item->precio_unitario, // Corregido al nombre real de tu columna
                'subtotal'       => $item->subtotal
            ]);

            // Aumentar el stock del producto en inventario
            $this->db->query("
                UPDATE producto 
                SET stock = stock + ? 
                WHERE id_producto = ?
            ", [$item->cantidad, $item->id_producto]);
        }

        $this->db->transComplete();

        return $this->db->transStatus();
    }
}