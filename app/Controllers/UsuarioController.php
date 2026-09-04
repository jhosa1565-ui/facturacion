<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;

class UsuarioController extends BaseController
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->findAll();
        return view('usuarios/index', $data);
    }

    public function guardar()
    {
        $id = $this->request->getPost('id_usuario');
        
        $data = [
            'nombre' => trim($this->request->getPost('nombre')),
            'correo' => trim($this->request->getPost('correo')),
            'rol'    => $this->request->getPost('rol'),
            'estado' => 1 // Valor por defecto para estado
        ];

        $password = $this->request->getPost('password');
        if (empty($id) && empty($password)) {
            return redirect()->back()->withInput()->with('error', 'La contraseña es obligatoria para nuevos usuarios.');
        }

        if (!empty($password)) {
            $data['clave'] = $password; // Apunta a la columna 'clave' de tu BD
        }

        if (!empty($id)) {
            $data['id_usuario'] = $id;
        }

        if (!$this->usuarioModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->usuarioModel->errors());
        }

        $mensaje = empty($id) ? 'Usuario registrado con éxito.' : 'Usuario actualizado con éxito.';
        return redirect()->to(base_url('usuarios'))->with('success', $mensaje);
    }

    public function eliminar($id)
    {
        try {
            $this->usuarioModel->delete($id);
            return redirect()->to(base_url('usuarios'))->with('success', 'Usuario eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('usuarios'))->with('error', 'No se puede eliminar el usuario.');
        }
    }
}