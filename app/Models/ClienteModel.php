<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = ['identificacion', 'nombre', 'telefono', 'correo'];
    protected $useTimestamps = false;

    protected $validationRules = [
        'id_cliente'     => 'permit_empty|integer',
        'identificacion' => 'required|exact_length[10]|numeric|is_unique[cliente.identificacion,id_cliente,{id_cliente}]',
        'nombre'         => 'required|min_length[3]|max_length[100]',
        'telefono'       => 'permit_empty|max_length[20]',
        'correo'         => 'permit_empty|valid_email|max_length[100]'
    ];

    protected $validationMessages = [
        'identificacion' => [
            'required'     => 'La identificación (cédula) es obligatoria.',
            'exact_length' => 'La cédula debe tener exactamente 10 dígitos.',
            'numeric'      => 'La cédula debe contener solo números.',
            'is_unique'    => 'Esta cédula ya se encuentra registrada.'
        ],
        'nombre' => [
            'required'   => 'El nombre del cliente es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 100 caracteres.'
        ],
        'correo' => [
            'valid_email' => 'Por favor ingrese un correo electrónico válido.'
        ]
    ];
}