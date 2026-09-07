<?php
namespace App\Models;
use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table = 'venta';
    protected $primaryKey = 'id_venta';
    protected $allowedFields = ['id_cliente', 'id_usuario', 'subtotal', 'impuesto', 'total'];
    protected $useTimestamps = false;
}