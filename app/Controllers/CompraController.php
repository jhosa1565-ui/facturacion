<?php
namespace App\Controllers;
use App\Models\CompraModel;

class CompraController extends BaseController
{
    public function index()
    {
        $model = new CompraModel();
        $data['compras'] = $model->getHistorialCompras();
        
        return view('layouts/main', [
            'content' => view('compras/index', $data)
        ]);
    }

    public function nueva()
    {
        return view('compras/nueva');
    }

    public function buscarProveedor()
    {
        $model = new CompraModel();
        $q = $this->request->getGet('q');
        $proveedores = $model->buscarProveedores($q);
        return $this->response->setJSON($proveedores);
    }

    public function buscarProducto()
    {
        $model = new CompraModel();
        $q = $this->request->getGet('q');
        $productos = $model->buscarProductos($q);
        return $this->response->setJSON($productos);
    }

    public function guardar()
    {
        $json = $this->request->getJSON();
        
        if (!$json || empty($json->id_proveedor) || empty($json->items)) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Datos incompletos para procesar la compra.'
            ]);
        }

        $model = new CompraModel();
        
        // Recalcular el total general basado en los items
        $totalGeneral = 0;
        foreach($json->items as $item) {
            $totalGeneral += ($item->cantidad * $item->precio_unitario);
        }

        $exito = $model->registrarCompra(
            $json->id_proveedor,
            $json->items,
            $totalGeneral
        );

        if ($exito) {
            return $this->response->setJSON([
                'status' => 'success', 
                'message' => 'Compra registrada con éxito e inventario actualizado.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Error al registrar la compra en la base de datos.'
            ]);
        }
    }
}