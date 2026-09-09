<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VentaModel;
use App\Models\DetalleVentaModel;
use App\Models\ProductoModel;
use App\Models\ClienteModel;

class VentaController extends BaseController
{
    protected $ventaModel;
    protected $detalleVentaModel;
    protected $productoModel;
    protected $clienteModel;

    public function __construct()
    {
        $this->ventaModel = new VentaModel();
        $this->detalleVentaModel = new DetalleVentaModel();
        $this->productoModel = new ProductoModel();
        $this->clienteModel = new ClienteModel();
    }

    public function index()
    {
        return view('facturacion/index');
    }

    public function nueva()
    {
        return view('facturacion/index');
    }

    public function buscarCliente()
    {
        $term = $this->request->getGet('q');
        if (!$term) {
            return $this->response->setJSON([]);
        }

        $clientes = $this->clienteModel
            ->like('nombre', $term)
            ->orLike('identificacion', $term)
            ->findAll(10);
            
        return $this->response->setJSON($clientes);
    }

    public function buscarProducto()
    {
        $term = $this->request->getGet('q');
        if (!$term) {
            return $this->response->setJSON([]);
        }

        $productos = $this->productoModel
            ->like('nombre', $term)
            ->orLike('codigo_barras', $term)
            ->where('stock >', 0)
            ->findAll(10);
            
        return $this->response->setJSON($productos);
    }

    public function guardar()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $json = $this->request->getJSON(true);
            
            $idCliente = $json['id_cliente'] ?? null;
            $items = $json['items'] ?? [];
            $total = $json['total'] ?? 0;
            $idUsuario = session()->get('id_usuario') ?? 1;

            if (!$idCliente || empty($items)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Datos incompletos para procesar la venta.']);
            }

            // 1. Guardar Cabecera de Venta
            $idVenta = $this->ventaModel->insert([
                'id_cliente' => $idCliente,
                'id_usuario' => $idUsuario,
                'total'      => $total,
                'fecha'      => date('Y-m-d H:i:s')
            ]);

            // 2. Guardar Detalle y Descontar Stock
            foreach ($items as $item) {
                $producto = $this->productoModel->find($item['id_producto']);

                if (!$producto || $producto['stock'] < $item['cantidad']) {
                    $db->transRollback();
                    return $this->response->setJSON([
                        'status' => 'error', 
                        'message' => 'Stock insuficiente para el producto: ' . ($producto['nombre'] ?? 'Desconocido')
                    ]);
                }

                $this->detalleVentaModel->insert([
                    'id_venta'        => $idVenta,
                    'id_producto'     => $item['id_producto'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal'        => $item['subtotal']
                ]);

                $nuevoStock = $producto['stock'] - $item['cantidad'];
                $this->productoModel->update($item['id_producto'], ['stock' => $nuevoStock]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Error al procesar la transacción de la venta.']);
            }

            return $this->response->setJSON(['status' => 'success', 'message' => '¡Factura generada con éxito!', 'id_venta' => $idVenta]);

        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}