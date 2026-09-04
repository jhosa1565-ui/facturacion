<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ClienteModel;

class ClienteController extends BaseController
{
    protected $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    public function index()
    {
        $data['clientes'] = $this->clienteModel->findAll();
        return view('clientes/index', $data);
    }

    public function guardar()
    {
        $id = $this->request->getPost('id_cliente');
        $identificacion = trim($this->request->getPost('identificacion'));

        // Validación extra de algoritmo de Cédula Ecuatoriana (10 dígitos válidos)
        if (!$this->validarCedula($identificacion)) {
            return redirect()->back()->withInput()->with('error', 'El número de cédula ingresado no es válido.');
        }

        $data = [
            'identificacion' => $identificacion,
            'nombre'         => trim($this->request->getPost('nombre')),
            'telefono'       => trim($this->request->getPost('telefono')),
            'correo'         => trim($this->request->getPost('correo'))
        ];

        if (!empty($id)) {
            $data['id_cliente'] = $id;
        }

        if (!$this->clienteModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->clienteModel->errors());
        }

        $mensaje = empty($id) ? 'Cliente registrado con éxito.' : 'Cliente actualizado con éxito.';
        return redirect()->to('clientes')->with('success', $mensaje);
    }

    public function eliminar($id)
    {
        try {
            $this->clienteModel->delete($id);
            return redirect()->to('clientes')->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to('clientes')->with('error', 'No se puede eliminar el cliente porque tiene ventas u otras dependencias asociadas.');
        }
    }

    // Función auxiliar estricta para validar cédula ecuatoriana
    private function validarCedula($cedula)
    {
        if (strlen($cedula) != 10 || !is_numeric($cedula)) {
            return false;
        }

        $provincia = intval(substr($cedula, 0, 2));
        if ($provincia < 1 || ($provincia > 24 && $provincia != 30)) {
            return false;
        }

        $tercerDigito = intval(substr($cedula, 2, 1));
        if ($tercerDigito >= 6) { 
            return false;
        }

        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;

        for ($i = 0; $i < 9; $i++) {
            $valor = intval(substr($cedula, $i, 1)) * $coeficientes[$i];
            if ($valor >= 10) {
                $valor -= 9;
            }
            $suma += $valor;
        }

        $digitoVerificadorCalculado = ($suma % 10 == 0) ? 0 : (10 - ($suma % 10));
        $digitoVerificadorReal = intval(substr($cedula, 9, 1));

        return $digitoVerificadorCalculado === $digitoVerificadorReal;
    }
}