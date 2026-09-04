<?php

namespace App\Models;

use CodeIgniter\Model;

class ProveedorModel extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id_proveedor';
    protected $allowedFields = ['identificacion', 'nombre', 'telefono'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'id_proveedor'   => 'permit_empty|integer',
        'identificacion' => 'required|min_length[10]|max_length[13]|is_unique[proveedor.identificacion,id_proveedor,{id_proveedor}]',
        'nombre'         => 'required|min_length[3]|max_length[100]',
        'telefono'       => 'permit_empty|max_length[20]'
    ];

    protected $validationMessages = [
        'identificacion' => [
            'required'   => 'La identificación es obligatoria.',
            'min_length' => 'La identificación debe tener al menos 10 dígitos.',
            'max_length' => 'La identificación no puede superar los 13 caracteres.',
            'is_unique'  => 'Este proveedor ya se encuentra registrado.'
        ],
        'nombre' => [
            'required'   => 'El nombre del proveedor es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 100 caracteres.'
        ]
    ];
}