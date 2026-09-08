<?php 
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Verificar si está logueado
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rolUsuario = $session->get('rol');
        $arguments = $arguments ?? [];

        // Si el filtro exige roles específicos y el usuario no los tiene
        if (!empty($arguments) && !in_array($rolUsuario, $arguments)) {
            // Si es un encargado intentando entrar a módulos prohibidos, redirigir a facturación
            if ($rolUsuario === 'encargado') {
                return redirect()->to('/facturacion')->with('error', 'No tienes permisos para acceder a esta sección.');
            }
            
            // Redirección por defecto para otros casos
            return redirect()->to('/dashboard')->with('error', 'Acceso no autorizado.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No es necesario hacer nada aquí
    }
}