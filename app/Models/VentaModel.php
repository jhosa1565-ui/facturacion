<?php
namespace App\Models;
use CodeIgniter\Model;

class VentaModel extends Model
{
    protected $table      = 'venta';
    protected $primaryKey = 'id_venta';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'id_cliente', 
        'id_usuario', 
        'total', 
        'fecha'
    ];

    protected $useTimestamps = false;
}