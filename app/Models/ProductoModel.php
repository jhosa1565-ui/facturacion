<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table = 'producto';
    protected $primaryKey = 'id_producto';
    
    protected $allowedFields = ['codigo_barras', 'nombre', 'id_categoria', 'id_marca', 'precio_venta', 'stock'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'id_producto'  => 'permit_empty|integer',
        'nombre'       => 'required|min_length[2]|max_length[100]',
        'id_categoria' => 'required|integer',
        'id_marca'     => 'required|integer',
        'precio_venta' => 'required|decimal',
        'stock'        => 'required|integer'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del producto es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.'
        ],
        'precio_venta' => [
            'required' => 'El precio de venta es obligatorio.',
            'decimal'  => 'Debe ingresar un valor numérico válido para el precio.'
        ],
        'stock' => [
            'required' => 'El stock es obligatorio.',
            'integer'  => 'El stock debe ser un número entero.'
        ]
    ];
}