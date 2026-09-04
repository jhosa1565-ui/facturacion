<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProveedorModel;

class ProveedorController extends BaseController
{
    protected $proveedorModel;

    public function __construct()
    {
        $this->proveedorModel = new ProveedorModel();
    }

    public function index()
    {
        $data['proveedores'] = $this->proveedorModel->findAll();
        return view('proveedores/index', $data);
    }

    public function guardar()
    {
        $id = $this->request->getPost('id_proveedor');
        $identificacion = trim($this->request->getPost('identificacion'));

        // Validación de cédula o RUC válido
        if (!$this->validarIdentificacion($identificacion)) {
            return redirect()->back()->withInput()->with('error', 'El número de identificación (Cédula o RUC) ingresado no es válido.');
        }

        $data = [
            'identificacion' => $identificacion,
            'nombre'         => trim($this->request->getPost('nombre')),
            'telefono'       => trim($this->request->getPost('telefono'))
        ];

        if (!empty($id)) {
            $data['id_proveedor'] = $id;
        }

        if (!$this->proveedorModel->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->proveedorModel->errors());
        }

        $mensaje = empty($id) ? 'Proveedor registrado con éxito.' : 'Proveedor actualizado con éxito.';
        return redirect()->to('proveedores')->with('success', $mensaje);
    }

    public function eliminar($id)
    {
        try {
            $this->proveedorModel->delete($id);
            return redirect()->to('proveedores')->with('success', 'Proveedor eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to('proveedores')->with('error', 'No se puede eliminar el proveedor porque está asociado a compras o productos.');
        }
    }

    private function validarIdentificacion($id)
    {
        if (strlen($id) == 10 && is_numeric($id)) {
            return $this->validarCedula($id);
        } elseif (strlen($id) == 13 && is_numeric($id)) {
            $provincia = intval(substr($id, 0, 2));
            if (($provincia >= 1 && $provincia <= 24) || $provincia == 30) {
                return substr($id, 10, 3) === '001' || intval(substr($id, 2, 1)) < 6;
            }
        }
        return false;
    }

    private function validarCedula($cedula)
    {
        $provincia = intval(substr($cedula, 0, 2));
        if ($provincia < 1 || ($provincia > 24 && $provincia != 30)) return false;
        $tercerDigito = intval(substr($cedula, 2, 1));
        if ($tercerDigito >= 6) return false;
        $coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];
        $suma = 0;
        for ($i = 0; $i < 9; $i++) {
            $valor = intval(substr($cedula, $i, 1)) * $coeficientes[$i];
            if ($valor >= 10) $valor -= 9;
            $suma += $valor;
        }
        $digitoVerificadorCalculado = ($suma % 10 == 0) ? 0 : (10 - ($suma % 10));
        return $digitoVerificadorCalculado === intval(substr($cedula, 9, 1));
    }
}