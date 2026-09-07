<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    public function index()
    {
        // Si ya está autenticado, redirigir al módulo principal
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('facturacion'));
        }
        return view('auth/login');
    }

    public function authenticate()
    {
        $correo = trim($this->request->getPost('username')); // Asegúrate de que tu input en el login se llame 'correo'
        $password = $this->request->getPost('password');

        $usuarioModel = new UsuarioModel();
       
        // Buscar el usuario en la base de datos por su correo
        $usuario = $usuarioModel->where('correo', $correo)->first();

        if ($usuario) {
       
            // Verificar la contraseña encriptada usando password_verify contra la columna 'clave'
            if (password_verify($password, $usuario['clave'])) {
                
                // Opcional: Validar si el usuario está activo (estado = 1)
                if (isset($usuario['estado']) && $usuario['estado'] == 0) {
                    return redirect()->back()->withInput()->with('error', 'Tu cuenta se encuentra inactiva.');
                }

                // Registrar los datos reales en la sesión
                session()->set([
                    'id_usuario' => $usuario['id_usuario'],
                    'nombre'     => $usuario['nombre'],
                    'correo'     => $usuario['correo'],
                    'rol'        => $usuario['rol'],
                    'isLoggedIn' => true
                ]);

                return redirect()->to(base_url('facturacion'));
            }
        }
        return redirect()->back()->withInput()->with('error', 'Correo o contraseña incorrectos.');
    }

    public function logout()
    {
        // Destruye los datos de la sesión actual
        session()->destroy();

        // Muestra la vista personalizada de sesión cerrada
        return view('auth/logout');
    }
}