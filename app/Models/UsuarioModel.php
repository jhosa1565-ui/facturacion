<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    
    protected $allowedFields = ['nombre', 'correo', 'clave', 'rol', 'estado'];
    protected $useTimestamps = false;

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['clave']) && !empty($data['data']['clave'])) {
            $data['data']['clave'] = password_hash($data['data']['clave'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['clave']);
        }
        return $data;
    }

    protected $validationRules = [
        'id_usuario' => 'permit_empty|integer',
        'nombre'     => 'required|min_length[3]|max_length[100]',
        'correo'     => 'required|valid_email|is_unique[usuario.correo,id_usuario,{id_usuario}]',
        'rol'        => 'required'
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del usuario es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.'
        ],
        'correo' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Debe ingresar un correo electrónico válido.',
            'is_unique'   => 'Este correo ya se encuentra registrado por otro usuario.'
        ]
    ];
}